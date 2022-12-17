<?php 



/**
 * @param string $name Name of ENV Constant
 * @param mixed $default Deafult value If name of ENV not Registered
 * @return string IF exist, will return value of ENV. IF not will return default value.
 */
function env(string $name, $default = null)
{
    global $env;
    if (isset($env[$name])) {
        return $env[$name];
    } else {
        return $default;
    }
}


function has(array $data, $key)
{
    return isset($data[$key]);
}

function old($name, $default = null)
{
    if (has($_POST, $name)) {
        return $_POST[$name];
    } else if (has($_GET, $name)) {
        return $_GET[$name];
    } else {
        return $default;
    }
}

function dump($data)
{
    var_dump($data);
}


function dd($data)
{
    dump($data);
    die();
}


function view(string $view, $data = [], $collection = false)
{
    if ($check = \Lawana\View\View::check($view)) {
        return new \Lawana\View\View($check[1], $data, $collection);
    } else {
        \Lawana\Utils\Redirect::error('ERROR', "View: <b>$view</b> Not Found.");
    }
}

function need(string $view, $data = [])
{
    if ($check = \Lawana\View\View::check($view)) {
        require_once $check[1];
    } else {
        \Lawana\Utils\Redirect::error('ERROR', "View: <b>$view</b> Not Found.");
    }
}


function faker() {
    $f = Faker\Factory::create("id_ID");
    return $f;
}