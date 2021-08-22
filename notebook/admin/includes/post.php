<?php

class Post extends Db_object {
    protected static $db_table = "post";   // TO BE UNIVERSE 

    protected static $db_table_fields = array('id', 'cat_id', 'date', 'flag', 'tags', 'title', 'sub_title', 'content');
    public $id;
    public $cat_id;
    public $date;
    public $flag;
    public $tags;
    public $title;
    public $sub_title;
    public $content;
    //public $image;

    
    public static function find_post_by_cat($cat_id){
        global $database;
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE cat_id = " . $cat_id;
        $sql .= " ORDER BY date DESC";
        return self::find_by_query($sql);            
    }

    public static function find_all(){
        return static::find_by_query("SELECT * FROM " . static::$db_table ." ORDER BY date DESC");
        // Using static:: instead of static:: ($this can work also but not recommended to take advantage of "static")
        // static:: is going to use the inherited class we are working with (Now, User) 
    }

    // ASSIGN THE INFO OF THE UPLOADED FILE INTO PROPERTIES
    // FIRST, CHECK IF THERE'S NO PROBLEM WITH UPLOADING FILES, THEN TO THE PROCESS ACCORDING TO THE SITUATION
    // This method will be passed $_FILES['uploaded_file'] as an argument, which is come from name of file input in HTML
    public function set_file($file){
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
            $this->type = $file['type'];
            $this->size = $file['size'];
            //echo  "filename:" . $this->filename . "<br> filepath:" .  $this->tmp_path;
        }       
    }  // WE ARE NOT SAVING ANY DATA INTO DB YET


    
    // WE CAN USE THIS IN <img src=""> TO BE ABLE TO GET THE FILE PASS MORE DYNAMICALLY AND EASILY
    public function picture_path(){
        return $this->upload_directory.DS.$this->filename;
    }



    public function save(){
        if($this->id){  // if we do have id, just use update() method
            $this->update();
        }else {            
            if(!empty($this->errors)){
                return false;
            }
            if(empty($this->filename) || empty($this->tmp_path)){
                $this->errors[] = "The file was not available";
                return false;
            }

            // Here, $this->upload_directory equals "images"
            $target_path = SITE_ROOT.DS.'admin'.DS. $this->upload_directory.DS.$this->filename;
            
            // Check if the same filename already exist in the directory
            if(file_exists($target_path)){   // DON'T FORGET 'S' FOR file_existS
                $this->errors[] = "The file $this->filename already exists";
                return false;
            }

            // move_uploaded_file(現在の(仮の)保存場所, "../保存先/ファイル名");
            if(move_uploaded_file($this->tmp_path, $target_path)){  // if the file was successfully moved into the parmanent directory($target_path)
                if($this->create()){  // HERE, FINALLY CREATE A NEW ROW IN DB
                    unset($this->tmp_path);
                    return true;
                }
            }else{
                // if the move_uploaded_file was failed
                $this->errors[] = "The file directory probably does not have permissioin";
                return false;            
            }
        }
    }

    // WE NEED TO CREATE THIS AS WE NEED TO DELETE THE PHOTO FROM THE DIRECTORY AS WELL, NOT ONLY FROM DB.
    /* public function delete_photo(){
        if($this->delete()){  // If it was deleted in DB
            $target_path = SITE_ROOT.DS."admin".DS.$this->picture_path();
            // unline() function deletes the file in the directory, not in DB
            return unlink($target_path) ? true : false;
        } else {
            return false;
        }
    } */

    /* public static function display_sidebar_data($photo_id){
        $photo = Photo::find_by_id($photo_id);

        $output = "<a class='thumbnail' href='#'><img width='100%' src='{$photo->picture_path()}'></a>";
        $output .= "<p>Filename: $photo->filename</p>";
        $output .= "<p>Type: $photo->type</p>";
        $output .= "<p>Size: $photo->size</p>";
        echo $output;
    } */
}



?>