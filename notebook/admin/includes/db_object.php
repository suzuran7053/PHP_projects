<?php

// CREATE A PARENT CLASS THAT IS GOING TO HAVE COMMONLY USED DATABASE METHODS
// That's because We have some methods that we are going to be using no matther what class we create.(in common)
// CLASS INHERITANCE IS GOING TO PROVIDE US A EASIER WAY TO NOT COPYING AND PASTING OVER AND OVER AGAIN
// [LATE STATIC BINDINGS] - USE static:: NOT self:: TO ACCESS THE INHERITED CLASS(CHILD CLASS) WE ARE WORKING WITH


class Db_object {
    
    public $upload_directory = "images";
    
    // It's good to have this errors array in case we have a problem when we move pictures from $tem_path to our directory "image"
    // Put those errors in this array and display message back to user
    public $errors = array();
    public $upload_errors_array = array(
        // CREATE AN ASSOCIATIVE ARRAY TO SHOW THE MESSAGE AFTER UPLOADING
        // Here, we are using constants for keys but you can use number instead if you want
        /* UPLOAD_ERR_OK         => "There is no error.",
        UPLOAD_ERR_INI_SIZE   => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
        UPLOAD_ERR_FORM_SIZE  => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",  // <-- not sure if this message is complete or not..
        UPLOAD_ERR_PARTIAL    => "The uploaded file was only partially uploaded.",
        UPLOAD_ERR_NO_FILE    => "No file was uploaded.",
        UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
        UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
        UPLOAD_ERR_EXTENSION  => "A PHP extension stopped the file upload." */
    );
    
 





    // This function will be used only to get all data from the table. $sql is defined here.
    public static function find_all(){
        // return static::find_by_query("SELECT * FROM " . static::$db_table);
        return static::find_by_query("SELECT * FROM " . static::$db_table);
        // Using static:: instead of static:: ($this can work also but not recommended to take advantage of "static")
        // static:: is going to use the inherited class we are working with (Now, User) 
    }

    // This function will be used only to get a user by its id. $sql is defined here.
    public static function find_by_id($id){
        $the_result_array = static::find_by_query("SELECT * FROM " . static::$db_table ." WHERE id = $id LIMIT 1");

        // IF IT'S NOT EMPTY, GET THE FIRST OBJECT IN THE ARRAY
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    

    // We won't need to use while loop with mysqli_fetch_array anymore once we make this method
    // We will be able to use the returned value (associative array of the result) with just a normal loop
    public static function find_by_query($sql){
        global $database;
        // Assign the result of the query into $result_set (using a method created in database.php)
        $result_set = $database->query($sql);
        $the_object_array = array(); //First, create an empty array
        // fetch the database(table) and assign them into the array, just like we used to do before
        while($row = mysqli_fetch_array($result_set)){  // Now, $row has the data table of the result set
            // We're putting all objects in here
            $the_object_array[] = static::instantiation($row); // Assign the returned value of instantiation method into the array
        }
        return $the_object_array;  
        //各行ごと(ユーザーごと)に作られたインスタンス(User)が丸ごと入ってる。構造は以下の通り。
    }   /*　↓　  ↓
        var_dump(User::find_all_users()); ( = var_dump(User::find_by_query("SELECT * FROM users"));
            array(3) {
                [0]=> object(User)#7 (5) {
                    ["id"]=> string(1) "1" 
                    ["username"]=> string(4) "rico" 
                    ["password"]=> string(3) "123" 
                    ["first_name"]=> string(4) "John" 
                    ["last_name"]=> string(3) "Doe" 
                } [1]=> object(User)#8 (5) {
                    ["id"]=> string(1) "2" 
                    ["username"]=> string(4) "Momo" 

                    ["password"]=> string(4) "momo" 
                    ["first_name"]=> string(4) "Momo" 
                    ["last_name"]=> string(6) "Morris"
                }
            }
        */

    
    // What for? --> CREATE A NEW INSTANCE OF THE CHILD CLASS (User, Photo, etc)
    // --> This method roops through the $the_record(=$row, which has columns and records that we get from the database) and assign the values-properties-set into the new instance
    public static function instantiation($the_record){

        // We want to make this function create a new instance of the inherited(calling) class, not Self class(Db_object), so we need to use "get_called_class()" to get the calling class name instead of using "new self()"
        // https://www.php.net/manual/en/language.oop5.late-static-bindings.php
        $calling_class = get_called_class(); // get_called_class() can be used to retrieve a string with the name of the called class and static:: introduces its scope.
        $the_object = new $calling_class();   // We can omit (), both ways work same.

        foreach ($the_record as $the_attribute => $value) { // loop through the $row (passed as a parameter)
            if($the_object->has_the_attribute($the_attribute)){  // If $the_attribute is same as the one the parent class(User, Photo, etc) has, 
                $the_object->$the_attribute = $value; // Assigning property-value-set into the instance
                // Don't forget the $ sign before "the_attribute"
            }
            // EXAMPLE; INSTANTIATE FROM USER CLASS...
            // $the_object->id = $found_user['id']
            // $the_object->username = $found_user['username']
            // $the_object->password = $found_user['password']
            // $the_object->first_name = $found_user['first_name']
            // $the_object->last_name = $found_user['last_name']
        }
        return $the_object;
    }
    


    // What for? --> TO CHECK THE PROPERTIES THAT A NEW INSTANCE IS GOING TO HAVE IS SAME AS THE PROPERTIES THAT THE USER CLASS(PARENT) HAS
    // Make this function as PRIVATE because we don't need to use this one outside
    private function has_the_attribute($the_attribute){
        // getting all the properties of User Class(=$this) and asign them into the variable $object_properties as an array
        $object_properties = get_object_vars($this);  //get_object_vars() returns all the properties of User class has, even if they are PRIVATE property
        return array_key_exists($the_attribute, $object_properties); // Will return boolean of if the attribute ($the_attribute) exists in the array ($object_peoperties)          
    }



    // We're going to put all properties and their values of this instance THAT MATCH $db_table_field, into an associative array to use create() and update() methods
    protected function properties() {        
        $properties = array();
        foreach (static::$db_table_fields as $db_fields) { // Here, 'field' means equal to 'column' in DB
        // We want to check if the values(assigned in $db_table_fields) match the properties of $this(User, Photo, etc).
        // If it does, assign the value into $properties array with the its key to use in other methods
            if(property_exists($this, $db_fields)){  // Here, $this means Db_object class
                $properties[$db_fields] = $this->$db_fields;  //DON'T FORGET $ SIGN!
            }
        }
        return $properties;
        /* EXAMPLE OF INSIDE OF $properties.. 
        array(4) { 
            ["username"]=> string(7) "(naoko)" 
            ["password"]=> string(5) "IT IS" 
            ["first_name"]=> string(3) "TOO" 
            ["last_name"]=> string(4) "HOT!" 
        }*/
    }


    // Escape values in $properties array to prevent SQL Injection attack
    protected function clean_properties(){
        global $database;
        $clean_properties = array();
        foreach ($this->properties() as $key => $value) { // We can set the object we want to loop around like this!  ($this->properties())
            // Assigning the cleaned values into array with keys
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }






    
 

    // CHECK IF THE USER IS ALREADY IN THE DB, IF SO JUST update(),' IF NOT create()
    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }   // * This method was overwritten in Photo class



    // ** FROM HERE, MANIPULATE INSIDE THE DATABASE ** 

    // CREATE A ROW IN DB
    // Create a data inside our data table, clean it(escape) and assign it into an object, at the same time 
    public function create() {
        global $database;     // If we were accessing database, we need to contact with instance $database
        // assign all properties(and their values) of this object into a variable $properties
        $properties = $this->clean_properties();  
                
        // Separating each keys by comma
        $sql = "INSERT INTO " . static::$db_table ."(". implode(",", array_keys($properties)) .")";  // We don't include "id" as it should be auto-created and incremented in DB
        $sql .= " VALUES('". implode("', '", array_values($properties)) ."')";  //Wrap & devide values by single quotes ''

        if($database->query($sql)) {
            $this->id = $database->the_insert_id(); // Here, get the auto-generated id and assign it to object property $this->id
            return true;
        }else { // We need to put "id" into the object as we haven't assigned "id" to the object. (While in DB, already auto-created)
            return false;
        }
    }

    // UPDATE DATA IN DB
    public function update(){
        global $database;

        $properties = $this->clean_properties();  
        /*var_dump($properties);
        array(4) { 
            ["username"]=> string(7) "(naoko)" 
            ["password"]=> string(5) "IT IS" 
            ["first_name"]=> string(3) "TOO" 
            ["last_name"]=> string(4) "HOT!" 
        }*/
        $properties_pairs = array();  // this array is used to format $properties array to use as SQL statement below.

        // HERE, FORMATTING $properties SO THAT WE CAN USE $properties_pairs AS SQL STATEMENT 
        foreach ($properties as $key => $value) {
            $properties_pairs[] = "$key='$value'";  
        }
        /*var_dump($properties_pairs);            // FORMATTIED!
        array(4) {
            [0]=> string(18) "username='(naoko)'" 
            [1]=> string(15) "password='HAVE'" 
            [2]=> string(18) "first_name='ANICE'" 
            [3]=> string(16) "last_name='DAY!'" 
        }*/

        $sql = "UPDATE " . static::$db_table ." SET ";
        //  escapes special characters in a string for use in an SQL query, taking into account the current character set of the connection.
        $sql .= implode(",", $properties_pairs);    // This sql statement will be like...  password='HAVE', first_name='ANICE', last_name='DAY!'..
        $sql .= " WHERE id= " . $database->escape_string($this->id);   //id should be integer so we don't need to put ''

        $database->query($sql);
        // mysqli_affected_rows() function is available for us in the mySQLi API. This gets the number of affected rows in a previous MySQL operation
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;      // Here, 1 means 1 row in DB 
    }


    // DELETE FROM THE DB
    public function delete(){
        global $database;
        $sql = "DELETE FROM " . static::$db_table;
        $sql .= " WHERE id= " . $database->escape_string($this->id);
        $sql .= " LIMIT 1"; // It's always a good idea to LIMIT 1 even though already using WHERE statement, to prevent occuring errors

        $database->query($sql);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }
    

    public static function count_all(){   // HOW TO CALL? -->  Photo::count_all();
        global $database;
        // The reason to user static:: is we need to use the value of the variable $db_class assined in each child-class
        $sql = "SELECT COUNT(*) FROM ".static::$db_table;
        // The COUNT() function returns the number of rows that matches a specified criterion.
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);
        return array_shift($row);
    }


    // WE NEED TO CREATE THIS AS WE NEED TO DELETE THE PHOTO FROM THE DIRECTORY AS WELL, NOT ONLY FROM DB.
    public function delete_photo(){
        if($this->delete()){  // If it was deleted in DB
            $target_path = SITE_ROOT.DS."admin".DS.$this->picture_path();
            // unline() function deletes the file in the directory, not in DB
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    }
}


?>