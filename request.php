<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 29/03/2017
 * Time: 15:46
 */

require_once 'src/lib/Satispay.php';
use satispay\Request as Request;

$request = null;

$method = $_SERVER['REQUEST_METHOD'];
$route = $_REQUEST['api_method'];
$obj = $_REQUEST;

//create request Object
$request = Request::create($method, $route, $obj);
$res = null;

//check for request
if(!is_null($request)) {
    $res = $request->exec();
}
//var_dump($res);