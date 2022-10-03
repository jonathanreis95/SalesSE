<?php

namespace Core;

class Container
{
    public static function newController($controller)
    {
        $newController = "App\\Controllers\\" . $controller;
        return new $newController;
    }

    public static function getModel($model)
    {
        $objModel ="\\App\\Models\\". $model;
        return new $objModel(DataBase::getDataBase());
    }

    public static function pageNotFound()
    {
        if(file_exists(__DIR__ . "/../app/Views/404.php")){
            require_once __DIR__ . "/../app/Views/404.php";
        }else{
            echo 'Erro 404 Page not found !';
        }
    }
}