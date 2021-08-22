<?php

class Category extends Db_object {
    protected static $db_table = "category";   // TO BE UNIVERSE 
    protected static $db_table_fields = array('id', 'name', 'colour', 'status');
    public $id;
    public $name;
    public $colour;
    public $status;

    

    public static function find_cat_by_id($cat_id){
        global $database;
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE id = " . $cat_id;
        $sql .= " LIMIT 1";
        return self::find_by_query($sql);            
    }
    
    public static function find_all_cat(){
        global $database;
        $sql = "SELECT * FROM " . self::$db_table. " WHERE status = 1";
        return self::find_by_query($sql);            
    }
}

?>