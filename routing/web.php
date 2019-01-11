<?php
function request_path()
{
    $request_uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    $script_name = explode('/', trim($_SERVER['SCRIPT_NAME'], '/'));
    $parts = array_diff_assoc($request_uri, $script_name);
    if (empty($parts))
    {
        return '/';
    }
    $path = implode('/', $parts);
    if (($position = strpos($path, '?')) !== FALSE)
    {
        $path = substr($path, 0, $position);
    }
    return $path;
}

$routes = [
    '' =>"ProductController@index",
    'product' => "ProductController@index",
    'product/add' => "ProductController@add",
    'product/update' => "ProductController@update",
    'product/status' => "ProductController@setStatus",
    'product/orderby' => "ProductController@orderby",
];

$path = request_path();

if (isset($routes[$path]))
{
    $exp = explode('@', $routes[$path]);
    $class_name = $exp[0];
    $function_name = $exp[1];
    $string_class = '\Controller\\'.$class_name;
    $select_class = new $string_class();
    $select_class->$function_name();
}else{
    dd('Класса не существует!');
}