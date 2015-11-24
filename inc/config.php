<?php
require_once("db.class.php");
$sql = new Database("localhost", "root", "", "new_erp");
$sql->txt = "SET NAMES utf8";
$sql->doSql();

$rootPath = $_SERVER['DOCUMENT_ROOT']."/erp/";
$baseUrl = "http://".$_SERVER['HTTP_HOST']."/erp/";
?>