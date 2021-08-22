<?php

class User extends Db_object {
    protected static $db_table = "users";   // TO BE UNIVERSE 
    protected static $db_table_fields = array('username', 'password');  // We don't want to include keys that is not integer(id) or irelevant to User instance($db_table)
    public $id;
    public $username;
    public $password;
    /* public $filename;
    public $upload_directory = "images";
    public $image_placeholder = "http://placehold.it/200x200&text=image";
    public $tmp_path; 

    public function image_path_and_placeholder(){
        return empty($this->filename) ? $this->image_placeholder : $this->upload_directory.DS.$this->filename;
    }
    */

    public static function verify_user($username, $password){
        global $database;
        // FIRST, SANITISE THE VALUES PASSED AS ARGUMENTS
        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM " . self::$db_table . " WHERE ";
        $sql .= "username = '$username' AND ";  //DO NOT FORGET '' !!!!!
        $sql .= "password = '$password' ";
        $sql .= "LIMIT 1";
        $the_result_array = self::find_by_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    } 
    
    
   /*  public function set_file($file){
        // TO MAKE SURE IF THE FILE IS UPLOADED 
        if(empty($file) || !$file || !is_array($file)){
            $this->errors[] = "There was no file uploaded here";
            return false;
        } elseif($file['error'] != 0){
            $this->errors[] = $this->upload_errors_array[$file['error']];
            return false;
        } else{
            // Here, $file == $_FILES['uploaded_file']
            $this->filename = basename($file['name']);  // basename() return only the file name without returning any other information           
            $this->tmp_path = $file['tmp_name'];
            //echo  "filename:" . $this->filename . "<br> filepath:" .  $this->tmp_path;
        }
    }  // WE ARE NOT SAVING ANY DATA INTO DB YET */



    

   /*  public function save_user_and_image(){
        if(!empty($this->errors)){
            return false;
        }
        if(empty($this->filename) || empty($this->tmp_path)){
            $this->errors[] = "The file was not available";
            return false;
        }

        // Here, $this->upload_directory equals "images"
        $target_path = SITE_ROOT.DS.'admin'.DS. $this->upload_directory.DS.$this->filename;
        
        // move_uploaded_file(現在の(仮の)保存場所, "../保存先/ファイル名");
        if(move_uploaded_file($this->tmp_path, $target_path)){  // if the file was successfully moved into the parmanent directory($target_path)
            if($this->save()){  // HERE, FINALLY UPDATE A NEW ROW IN DB
                unset($this->tmp_path);
                return true;
            }
        }else{
            // if the move_uploaded_file was failed
            $this->errors[] = "The file directory probably does not have permissioin";
            return false;            
        }
    }



    // WE CAN USE THIS IN <img src=""> TO BE ABLE TO GET THE FILE PASS MORE DYNAMICALLY AND EASILY
    public function picture_path(){
        return $this->upload_directory.DS.$this->filename;
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

    public function ajax_save_user_image($user_image, $user_id){
        global $database;
        $user_image = $database->escape_string($user_image);
        $user_id = $database->escape_string($user_id);
        $this->filename = $user_image;
        $this->id = $user_id;

        $sql = "UPDATE users SET filename='$this->filename'";
        $sql .= " WHERE id=".$user_id;
        $update_image = $database->query($sql);
        echo $this->image_path_and_placeholder();
    }


    // SHOW THE PHOTOS POSTED BY THE USER (photos.php)
    public function photos(){
        return Photo::find_by_query("SELECT * FROM photos WHERE user_id = ".$this->id);
    }

} // End of the User Class */
}

?>