<?php

    // Load Config
    require_once 'config/config.php';

    // Load Vaiables
    require_once 'config/define.php';
    
    // Load Helpers
    require_once 'helpers/url.php';
    require_once 'helpers/session.php';
    require_once 'helpers/datetime.php';
    
    // Autoload Core Libraries
    spl_autoload_register(function($className){
       require_once 'lib/' . $className . '.php';
    });

