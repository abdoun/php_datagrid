<?php if(!defined('_ABDO_PHP_DOTNET_PRO_79') || _ABDO_PHP_DOTNET_PRO_79!='ebdbf060a90f7fcd532jh4551060fb9a539543'){exit();}
function goto_($page,$alert='')
{
 ?>
	<script type="text/javascript">
	<?php
	 if($alert!="")
	 {
	  print("alert('".$alert."');");
	 }
	 ?>
	location.href="<?php print($page);?>";	
	</script>
 <?php
}
	function rightemail($email){
	$RightEmail=ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[_a-z0-9-]+(\.[_a-z0-9-]+)",$email);
	return $RightEmail;
	}
	function clean($input){//
		$input=stripslashes(trim($input));//remove spaces and \
		$input=strip_tags($input);//remove html and php markup
		$input=htmlspecialchars($input);//replace markup
		$input=AddSlashes($input);//escape quetes
		//$input=htmlentities($input);
		//$input=escapeshellcmd($input);
		$input=mysql_real_escape_string($input);
	return $input;
	}
	function reclean($output){//
		return StripSlashes($output);	
	}
	
function get_dir_pic($image){
	 return substr($image,3);
	 }

function clean_input($array)
{
	if(is_array($array) && count($array)>0)
	{
		foreach($array as $key=>$value)
		{
			$array[$key]=reclean($value);
			$array[$key]=clean($value);
		}
		return $array;
	}
	else
	{
		return $array;
	}
}
function get_include_contents($filename) {
    if (is_file($filename)) {
        ob_start();
        include $filename;
        $contents = ob_get_contents();
        ob_end_clean();
        return $contents;
    }
    return false;
}
?>