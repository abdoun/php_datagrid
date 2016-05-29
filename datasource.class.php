<?php //error_reporting(0);?><?php //session_start();?>
<?php if(!defined('_ABDO_PHP_DOTNET_PRO_79') || _ABDO_PHP_DOTNET_PRO_79!='ebdbf060a90f7fcd532jh4551060fb9a539543'){exit;}?>
<?php
abstract class datasource
{
    protected $scheme;
    protected $data;
    protected $db;
    protected $link;
    protected $server;
    protected $user;
    protected $pass;
    protected $tables;
    
    protected function db_connect($db,$server="localhost",$user="root",$pass="")
    {
        $this->db=$db;
        $this->server=$server;
        $this->user=$user;
        $this->pass=$pass;
        $this->link=mysql_connect($this->server,$this->user,$this->pass);
        mysql_query("set charset utf8");
        mysql_query("SET character_set_client=utf8");
        mysql_query("SET character_set_connection=utf8");
        mysql_query("SET character_set_database=utf8");
        mysql_query("SET character_set_results=utf8");
        mysql_query("SET character_set_server=utf8");
        mysql_select_db($this->db) or die(mysql_error());
        $this->tables=$this->get_table();
    }
    protected function db_close()
    {
        mysql_close($this->link);
    }
    protected function get_scheme($query)
    {
        $re=mysql_query($query);
        
        for ($l=0; $l < mysql_num_fields($re); $l++) 
        {
            $field[$l]['type']  = mysql_field_type($re, $l);
            $field[$l]['name']  = mysql_field_name($re, $l);
            $field[$l]['max_length']  = mysql_field_len($re, $l);
            $field[$l]['flag'] = mysql_field_flags($re, $l);
            $field[$l]['table'] = mysql_field_table($re, $l);
            $field[$l]['info']=mysql_fetch_field($re,$l);
            if(in_array($field[$l]['name'],$this->tables))
            {
                $r=mysql_query("select id,".$field[$l]['name']." from ".$field[$l]['name']);
                while($res=mysql_fetch_array($r))
                {
                    $field[$l]['value'][$res['id']]=$res[$field[$l]['name']];
                }                
            }
            if($field[$l]['flag']=='enum')
            {
                $field[$l]['value']=$this->enum_select($field[$l]['table'],$field[$l]['name']);                
            }
        }

        //while ($meta = mysql_fetch_field($re)) 
//        {        
//            $field[$l]['name']= $meta->name;
//            $field[$l]['type']=$meta->type;
//            $field[$l]['table']=$meta->table;
//            $field[$l]['key']=$meta->primary_key;
//            $field[$l]['max_length']=$meta->max_length;
//            $field[$l]['not_null']=$meta->not_null;
//            $l++;
//        }
        
        $this->scheme=$field;
    }
    protected function get_data($query)
    {
        //$this->get_scheme($query);
        $re=mysql_query($query);
        $i=0;
        foreach($this->scheme as $key=>$value)
        {
            $row[$i][$value['name']]=$value['name'];
        }
        while($res=mysql_fetch_array($re))
        {
            $i++;
            foreach($this->scheme as $key=>$value)
            {
                $row[$i][$value['name']]=$res[$value['name']];
            }                    
        }
    $this->data=$row;
    }
    protected function get_table()
    {
        $result = mysql_list_tables($this->db);
        $num_rows = mysql_num_rows($result);
        for ($i = 0; $i < $num_rows; $i++) 
        {
            $tables[$i]= mysql_tablename($result, $i);
        }
        return $tables;
    }
    protected function enum_select( $table , $field )
    {
        $query = " SHOW COLUMNS FROM `$table` LIKE '$field' ";
        $result = mysql_query( $query ) or die( 'error getting enum field ' . mysql_error() );
        $row = mysql_fetch_array( $result , MYSQL_NUM );
        #extract the values
        #the values are enclosed in single quotes
        #and separated by commas
        $regex = "/'(.*?)'/";
        preg_match_all( $regex , $row[1], $enum_array );
        $enum_fields = $enum_array[1];
        return( $enum_fields );
    }
}?>