<?php


// DIRECTORY_SEPARATOR is a constant PHP has, which means \ on Window, / on Mac (It will differ depending on what operating system you are using)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'Users'.DS.'USER'.DS.'pg'.DS.'gallery');  // C:\Users\USER\pg\gallery
defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes');  // C:\Users\USER\pg\gallery\admin\includes
// echo INCLUDES_PATH; (admin_content.php)  // -->  \Users\USER\pg\gallery\admin\includes



// 新しいクラスを作ったらここに足していくのを忘れない
// USE require_once() INSTEAD OF include() AS IT'S MORE SECURE BY EDWIN
require_once("functions.php");
require_once("new_config.php");
require_once("database.php");
require_once("db_object.php");
require_once("post.php");
require_once("user.php");
//require_once("pagenate.php");
require_once("category.php");
require_once("session.php");



?>