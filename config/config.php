<?php

Config::set('site_name', 'My first MVC');// название нашего сайта

Config::set('languages', array('en', 'fr'));//языки

// Routes. Route name => method prefix
Config::set('routes', array(
    'default' => '',
    'admin'   => 'admin_',
));

Config::set('default_route', 'default');
Config::set('default_language', 'en');
Config::set('default_controller', 'pages');
Config::set('default_action', 'index');

Config::set('db.host', 'localhost');
Config::set('db.user', 'root');
Config::set('db.password', 'root');
Config::set('db.db_name', 'mvc');

Config::set('salt', 'jd7sj3sdkd964he7e');