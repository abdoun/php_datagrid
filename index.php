<?php error_reporting(0);
header("Content-Type: text/html; charset=utf-8"); //session_start();?>
<?php define('_ABDO_PHP_DOTNET_PRO_79','ebdbf060a90f7fcd532jh4551060fb9a539543');?>
<?php //require_once("init_conf/connect.inc.php");?>
<?php require_once("init_conf/function.inc.php");?>
<?php
	$_REQUEST=clean_input($_REQUEST);
	$_POST=clean_input($_POST);
	$_GET=clean_input($_GET);
	$_SESSION=clean_input($_SESSION);
	$_COOKIE=clean_input($_COOKIE);
require_once('datasource.class.php');
require_once('datagrid.class.php');
require_once('formbuilder.class.php');
$form=new formbuilder("test","select * from news",2);
new datagrid("test","select * from news where 1=1");
?>