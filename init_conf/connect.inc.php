<?php if(!defined('_ABDO_PHP_DOTNET_PRO_79') || _ABDO_PHP_DOTNET_PRO_79!='ebdbf060a90f7fcd532jh4551060fb9a539543'){exit;}?>
<?
require_once("config.inc.php");
$link=mysql_connect("localhost","root","");
mysql_query("set charset utf8");
mysql_query("SET character_set_client=utf8");
mysql_query("SET character_set_connection=utf8");
mysql_query("SET character_set_database=utf8");
mysql_query("SET character_set_results=utf8");
mysql_query("SET character_set_server=utf8");
mysql_select_db(_DB_NAME) or die(mysql_error());?>