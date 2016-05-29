<?php //error_reporting(0);?><?php //session_start();?>
<?php if(!defined('_ABDO_PHP_DOTNET_PRO_79') || _ABDO_PHP_DOTNET_PRO_79!='ebdbf060a90f7fcd532jh4551060fb9a539543'){exit;}?>
<?php
//require_once('datasource.class.php');
    
class datagrid extends datasource
{
    function __construct($db,$query)
    {
        parent::db_connect($db);
        parent::get_scheme($query);
        foreach($_GET as $key=>$value)
        {
            if($key!='sort' && $key!='field' && $key!='page' && $value!='')
            {
                $query.=" and $key like '%$value%'";
            }            
        }
        if(!empty($_GET['field']) && !empty($_GET['sort'])){$query.=" order by $_GET[field]  $_GET[sort]";}else{$query.='';}
        if(empty($_GET['page'])){$_GET['page']='0';}$query.=" limit $_GET[page],10";
        parent::get_data($query);        
        $this->draw();
        parent::db_close();
    }
    protected function filter()
    {
        print('<form method="get" action="?" name="filter" id="filter"><tr>');
        foreach($this->data[0] as $value)
        {
            print('<td><input type="text" name="'.$value.'" value="'.$_GET[$value].'" onblur="filter.submit();" /></td>');
        }
        print('</tr></form>');
    }
    protected function paging()
    {
        print('<form method="get" action="?" name="paging" id="paging"><tr>');
        $no=count($this->data[0])-1;
        $pages=$no/10;
        print('<td colspan="'.count($this->data[0]).'"><input size="2" type="text" name="page" value="'.$_GET['page'].'" onblur="paging.submit();" /> of '.($pages%10).'</td>');
        print('</tr></form>');
    }
    protected function draw()
    {
        $i=1;
        print('<table border="0">');
        $this->filter();
        foreach($this->data as $key=>$value)
        {
            if($i==1)
            {
                $bg=' bgcolor="#cccccc"';
            }
            elseif($i%2==0)
            {
                $bg=' bgcolor="#ffffff"';
            }
            else
            {
                $bg=' bgcolor="#f0f0f0"';
            }
            print('<tr'.$bg.'>');
            foreach($value as $a=>$b)
            {
                if($_GET['sort']=='asc'){$sort='desc';}else{$sort='asc';}
                if($_GET['field']==$b){if($_GET['sort']=='desc'){$property=' ^';}else{$property=' v';}}else{$property='';}
                $url='';
                foreach($_GET as $key=>$value)
                {
                    if($key!='sort' && $key!='field' && $key!='page' && $value!='')
                    {
                        $url.="&$key=$value";
                    }            
                }
                if($i==1){$b='<a href="?field='.$b.'&sort='.$sort.$url.'">'.$b.' '.$property.'</a>';}
                //if($a!='id')
                //{                    
                    print('<td>'.$b.'</td>');
                //}                
            }
            
            print('</tr>');
            $i++;
        }
        $this->paging();
        print('<table>');
    }
}?>