<?php
/**
 * Created by PhpStorm.
 * User: marco.bevilacqua
 * Date: 29/03/2017
 * Time: 15:46
 */

use satispay\Satispay as Satispay;
require_once 'src/lib/Satispay.php';

$url = $_REQUEST['api_method'];
$method = $_SERVER['REQUEST_METHOD'];
$obj = null;

if($method == 'POST'){
    $obj = $_REQUEST;
}



if($method != ""){

}

$satispay_helper = new Satispay($method, $url, $obj);

$res = $satispay_helper->exec();

var_dump($res);
die();