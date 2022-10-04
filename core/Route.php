<?php

namespace Core;

Class Route
{
    private $routes;

    public function __construct(array $routes)
    {
        $this->setRoutes($routes);
        $this->run();
    }


    private function getUrl()
    {
        return parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    }
    
    private function setRoutes($routes)
    {
        $newRoutes = [];
        foreach($routes as $route){
            $method = $route[1];
            $methodAction = explode('@', $method);
            $routeArray = [$route[0], $methodAction[0], $methodAction[1]];            
            $newRoutes[] = $routeArray;
        }        
        $this->routes = $newRoutes;
    }

    private function getRequest()
    {
        $obj = new \stdClass;

        if(isset($_GET)){
            $obj->get = new \stdClass;

            foreach($_GET as $key => $value){
                $obj->get->$key = $value;
            }
        }
        

        if(isset($_POST)){
            $obj->post = new \stdClass;

            foreach($_POST as $key => $value){
                $obj->post->$key = $value;
            }
        }

        return $obj;
    }

    private function run()
    {
        $url = $this->getUrl();
        $urlArray = explode('/', $url);
       
        $foundRoute = false;

        foreach($this->routes as $route){
            $pathRoute = $route[0];
            $routeArray = explode('/', $route[0]);
            $param = [];
            for($i=0; $i < count($routeArray); $i++){
                if(count($urlArray) == count($routeArray)){
                    if(strpos($routeArray[$i], "{") !== false){
                        $routeArray[$i] = $urlArray[$i];                        
                        $param[] = $urlArray[$i];
                    }
                }
                $route[0] = implode('/', $routeArray);
            }

            if($url == $route[0]){
                $foundRoute = true;
                $controller = $route[1];
                $action = $route[2];
                break;
            }
        }

        if($foundRoute){
            $objController = Container::newController($controller);

            switch(count($param)){
                case 1:
                    $objController->$action($param[0], $this->getRequest());
                    break;
                case 2:
                    $objController->$action($param[0], $param[1], $this->getRequest());
                    break;
                case 3:
                        $objController->$action($param[0], $param[1], $param[2], $this->getRequest());
                        break;    
                 default:
                    $objController->$action($this->getRequest());
                    break; 
            } 
        }else{
            Container::pageNotFound();
        }
    }

}