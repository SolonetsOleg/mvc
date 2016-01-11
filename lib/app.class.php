<?php

class App{

    protected static $router;//для хранения информации разбора пути в объекте класса router.class.php
    public static $db;
    public static function getRouter(){//метод запроса значения router
        return self::$router;
    }
public static function run($uri){
        self::$router = new Router($uri);//переопределяем значение router

        self::$db = new DB(Config::get('db.host'), Config::get('db.user'), Config::get('db.password'), Config::get('db.db_name'));//присваиваем в $db даннные для подключения к базе

        Lang::load(self::$router->getLanguage());//подгружаем язык из router.class.php

        $controller_class = ucfirst(self::$router->getController()).'Controller';//присваеваем значение контроллера ($controller из router.class.php)
        $controller_method = strtolower(self::$router->getMethodPrefix().self::$router->getAction());//присваеваем значение метода ($method_prefix из router.class.php)

        $layout = self::$router->getRoute();//$route из router.class.php
        if ( $layout == 'admin' && Session::get('role') != 'admin' ){//проверяем если админ не залогинен
            if ( $controller_method != 'admin_login' ){
                Router::redirect('/admin/users/login');//перенаправляем на формулогина
            }
        }
        // Calling controller's method
        $controller_object = new $controller_class();
        if ( method_exists($controller_object, $controller_method) ){//method_exists — Проверяет, существует ли метод в данном классе
            // Controller's action may return a view path
            $view_path = $controller_object->$controller_method();
            $view_object = new View($controller_object->getData(), $view_path);
            $content = $view_object->render();
        } else {
            throw new Exception('Method '.$controller_method.' of class '.$controller_class.' does not exist.');
        }

        $layout_path = VIEWS_PATH.DS.$layout.'.html';
        $layout_view_object = new View(compact('content'), $layout_path);
        echo $layout_view_object->render();
    }

}