<?php
require("../../vendor/autoload.php");

//echo $_SERVER['DOCUMENT_ROOT'].'/models';
$openapi = \OpenApi\Generator::scan([$_SERVER['DOCUMENT_ROOT'].'/models']);

header('Content-Type: application/json');
echo $openapi->toJSON();
