<?php

defined('BASIC_PATH') || define('BASIC_PATH', realpath(__DIR__));

# Configuration BD
$dbf = BASIC_PATH . '/rb-mysql.php';
if(file_exists($dbf) && is_readable($dbf)) {
    @require($dbf);
    R::setup('mysql:host=localhost;dbname=pharmacie', 'root', '');
    
    # Autoloader
   function pharma_autoload ($className) {
       $Fn = BASIC_PATH . '/class/' . $className . '.php';
        if(file_exists($Fn)) include_once $Fn;
   }
   spl_autoload_register('pharma_autoload');
    
} else {die('Db connection file not found !'); }