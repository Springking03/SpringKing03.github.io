<?php
    require './controllers/BaseController.php';
    require './core/Database.php';
    require './models/BaseModel.php';
    require './configs/uriConfig.php';

    $controllerName = ucfirst(strtolower($_REQUEST['controller'] ?? 'Home')) . 'Controller';
    $actionName = strtolower($_REQUEST['action'] ?? 'home');
    require "./controllers/$controllerName.php";

    $controllerObj = new $controllerName();
    $controllerObj->$actionName();
