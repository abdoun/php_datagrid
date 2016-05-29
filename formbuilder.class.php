<?php //error_reporting(0);?><?php //session_start();?>
<?php if(!defined('_ABDO_PHP_DOTNET_PRO_79') || _ABDO_PHP_DOTNET_PRO_79!='ebdbf060a90f7fcd532jh4551060fb9a539543'){exit;}?>
<?php
//require_once('datasource.class.php');    
class formbuilder extends datasource
{
    protected $action='';
    protected $method='post';
    protected $validation='';
    
    function __construct($db,$query,$id='',$action='',$method='post')
    {
        parent::db_connect($db);
        parent::get_scheme($query);
        if(!empty($id)){parent::get_data($query." where id=$id");}        
        $this->action=$action;
        $this->method=$method;
        $this->validation=$this->js_validation();
        $this->js();
        $this->draw();
        parent::db_close();
    }
    protected function js_validation()
    {
        foreach($this->scheme as $value)
        {
            if($value['info']->not_null==1 && $value['name']!='id')
            {
                $return.='if(this.'.$value['name'].'.value==\'\'){alert(\'sorry, you have not ever fill '.$value['name'].' field\');this.'.$value['name'].'.focus();return false;}';
            }
        }
        return $return;
    }
    protected function draw()
    {
        print('<form name="'.$this->scheme[0]['table'].'" id="'.$this->scheme[0]['table'].'" action="'.$this->action.'" method="'.$this->method.'" onsubmit="'.$this->validation.'">');
        print('<table>');
        foreach($this->scheme as $value)
        {
            $this->build_field_box($value);
        }
        print('<tr><td colspan="2"><input type="submit" name="submit" id="submit" value="ok" /></td></tr>');
        print('</table>');
        print('</form>');
    }
    protected function build_field_box($field)
    {
        if($field['info']->not_null==1)
        {
            $mandatory='<font color="#ff0000">*</font>';
        }
        else
        {
            $mandatory='';
        }
        if($field['name']=='id')
        {
            print('<tr><td colspan="2"><input type="hidden" maxlength="'.$field['max_length'].'" name="'.$field['name'].'" title="'.$field['name'].'" value="'.$this->data[1][$field['name']].'" /></td></tr>');
        }
        elseif($field['flag']=='enum')
        {
            print('<tr><td>'.$field['name'].'</td><td><select name="'.$field['name'].'" title="'.$field['name'].'">');
            foreach($field['value'] as $valuee)
            {
                if($this->data[1][$field['name']]==$valuee){$selected=' selected';}else{$selected='';}
                print('<option value="'.$valuee.'" '.$selected.'>'.$valuee.'</option>');
            }
            print('</td></tr>');
        }
        elseif(count($field['value'])>0)
        {
            print('<tr><td>'.$field['name'].'</td><td><select name="'.$field['name'].'" title="'.$field['name'].'">');
            foreach($field['value'] as $keyy=>$valuee)
            {
                if($this->data[1][$field['name']]==$keyy){$selected=' selected';}
                print('<option value="'.$keyy.'" '.$selected.'>'.$valuee.'</option>');
            }
            print('</td></tr>');
        }
        else
        {
            switch($field['type'])
            {
                case "string":
                    if($field['name']=='id'){$type='hidden';}else{$type='text';}
                    print('<tr><td>'.$field['name'].$mandatory.'</td><td><input type="'.$type.'" maxlength="'.$field['max_length'].'" name="'.$field['name'].'" title="'.$field['name'].'" value="'.$this->data[1][$field['name']].'" /></td></tr>');
                break;
                case "int":
                    if($field['name']=='id'){$type='hidden';}else{$type='text';$validate=' onkeypress="this.value=trim(this.value.toLowerCase());this.value=parseInt(this.value);if(this.value==\'NaN\' || isNaN(parseInt(this.value)))this.value=\'\';" onblur="this.value=trim(this.value.toLowerCase());this.value=parseInt(this.value);if(this.value==\'NaN\' || isNaN(parseInt(this.value)))this.value=\'\';" onkeyup="this.value=trim(this.value.toLowerCase());this.value=parseInt(this.value);if(this.value==\'NaN\' || isNaN(parseInt(this.value)))this.value=\'\';"';}
                    print('<tr><td>'.$field['name'].$mandatory.'</td><td><input type="'.$type.'" maxlength="'.$field['max_length'].'" name="'.$field['name'].'" title="'.$field['name'].'" value="'.$this->data[1][$field['name']].'" '.$validate.' /></td></tr>');
                break;
                case "blob":
                    print('<tr><td>'.$field['name'].$mandatory.'</td><td><textarea maxlength="'.$field['max_length'].'" name="'.$field['name'].'" title="'.$field['name'].'" '.$validate.'>'.$this->data[1][$field['name']].'</textarea></td></tr>');
                break;
                default:
            }
        }
        
        
    }
    protected function js()
    {
        ?><script type="text/javascript">
	    function trim(txt)
    	{
    		while (txt.indexOf (' ') == 0) { txt = txt.substr(1); }
    		while (txt.substr(txt.length-1)==' ') { txt = txt.substr(0,txt.length-1); }
    		return txt ;
    	}
        function trim_number(txt)
    	{
    		while (txt.indexOf('0')==0 || txt.indexOf('1')==0 || txt.indexOf('2')==0 || txt.indexOf('3')==0 || txt.indexOf('4')==0 || txt.indexOf('5')==0 || txt.indexOf('6')==0 || txt.indexOf('7')==0 || txt.indexOf('8')==0 || txt.indexOf('9')==0) { txt = txt.substr(1); }
    		while (txt.substr(txt.length-1)=='0' || txt.substr(txt.length-1)=='1' || txt.substr(txt.length-1)=='2' || txt.substr(txt.length-1)=='3' || txt.substr(txt.length-1)=='4' || txt.substr(txt.length-1)=='5' || txt.substr(txt.length-1)=='6' || txt.substr(txt.length-1)=='7' || txt.substr(txt.length-1)=='8' || txt.substr(txt.length-1)=='9') { txt = txt.substr(0,txt.length-1); }
    		return txt ;
    	}
        </script>
        <?php
    }
    /**
 * SELECT COLUMN_TYPE 
 * FROM INFORMATION_SCHEMA.COLUMNS 
 * WHERE TABLE_NAME = 'yourTable' 
 *   AND COLUMN_NAME = 'yourColumn' limit 1; 
 */
    
    
}?>