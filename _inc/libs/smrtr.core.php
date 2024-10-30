<?php

/**
 * Smrtr Class helper for wordpress items
 */
if(!class_exists('smrtr')){
class smrtr {
    
    
    
    /**
    * Are we in the admin section of wordpress
    * @param type $file_handler
    * @param type $post_id
    * @param type $setthumb 
    */
    
    public static function slug($string,$separator='-'){

        
        if(!in_array($separator,array('-','_')))
                return false;

        $replace = $separator==='-'?'_':'-';

        $string = str_replace($replace,$separator,$string);

        $string =  preg_replace('/[^A-Za-z0-9-]+/', $separator, strtolower($string)); 
        
        return trim($string,$separator);

    }
    
    
    public static function isBetween($int,$min,$max){
        return ($int>$min && $int<$max);
    }
    
    
        
    public static function printPHParr($arr){

        $ret = array();

        foreach($arr as $key => $val){

            if($key)
            $ret[$key] = "'$key' => $val";
        }
        $concat = implode(',',$ret);
        return "array($concat)";
    }
    

    public static function strtime($datetime_str)
    {
        list( $y, $m, $d, $h, $i, $s ) = preg_split( '([^0-9])', $datetime_str);

        return mktime($h, $i, $s, $m, $d, $y);
    }

    public static function redirect($param='redirect'){
            
         return isset($_REQUEST[$param])?$_REQUEST[$param]:'';
    }
    public static function datetime(){
        return date('Y-m-d H:i:s');
    }
    
    function shortenText($string,$max_size)
    {
        $new_str = $string;
        $len = strlen($string);
        if($len>$max_size)
        {
            $new_str = substr($string,0,$max_size-3)."<small>...</small>";
        }
        return $new_str;
    }
    
    
}
}

if(!function_exists('args')){
   function args($pairs=array()){


        $urlParts = getURLparts();
        $path  = isset($urlParts['path'])?$urlParts['path']:'';
        $query = isset($urlParts['query'])?$urlParts['query']:'';
        $parts = queryToArray($query);

        unset($parts['paged']);
        $parts = array_merge($parts,$pairs);
        $string = arrayToQuery($parts);

        return sprintf('%s?%s',$path,$string);
    }
}
if(!function_exists('argsArr')){
    function argsArr(){


        $urlParts = getURLparts();
        $query = isset($urlParts['query'])?$urlParts['query']:'';



        return queryToArray($query);

    }
}

if(!function_exists('queryToArray')){
function queryToArray($string){

    $arr = explode('&',$string);


    $pairs = array();
    foreach($arr as $pair){
        
        
        $parts = explode('=',$pair);
       
        $pairs[$parts[0]] = isset($parts[1])?$parts[1]:'';

    }
    return $pairs;
}
}

if(!function_exists('arrayToQuery')){
    function arrayToQuery($arr){


        $pairs = array();

        foreach($arr as $key => $val){

                if(isset($val)&&!empty($val))
                $pairs[$key] = "$key=$val";
                else $pairs[$key] = "$key";
            }
            return implode('&',$pairs);
    }
}

if(!function_exists('getURLparts')){
    function getURLparts(){

        return parse_url($_SERVER['REQUEST_URI']);  
    }
}



if(!function_exists('generateHiddenFields')){
    function generateHiddenFields($arr=array(),$remove = array()){

        $hidden = array();
        foreach($arr as $key => $val){
            if(!in_array($key,$remove))
            $hidden[] = sprintf('<input type="hidden" name="%s" value="%s"/>',$key,$val);

        }
        return implode('',$hidden);

    }
}

?>
