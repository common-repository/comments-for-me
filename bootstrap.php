<?php


class Smrtr_Model_MyCommentsBootstrap
{
 
    public function __construct($autoload=array()){
        
        if(isset($_REQUEST['page'])&&$_REQUEST['page']=='comments')
        add_action('admin_head', 'my_comments_scripts' );
        
        foreach($autoload as $dir)
            $this->autoload($dir);
    }
    
    public function isHidden($file){

        if(substr(trim($file), 0, 1)==='.')
            return true;
        else return false;
        
    }
    
    public function autoload($dir){
        
        
        
        $files = scandir($dir);
        
        if(!is_array($files))
            return false;
        
        if(count($files)<1)
            return false;


        sort($files);

        foreach($files as $file){

            if(!$this->isHidden($file)&&!is_dir("$dir/$file"))
                include_once("$dir/$file");
        }
    }
}


if(!function_exists('pre_dump')){
    
    function pre_dump($a){
        echo '<pre>'.print_r($a,true).'</pre>';
    }
}
if(!function_exists('array_multi_key_exists')){
    
    function array_multi_key_exists(array $arrNeedles, array $arrHaystack, $blnMatchAll=false){
        
        $blnFound = array_key_exists(array_shift($arrNeedles), $arrHaystack);

        if($blnFound && (count($arrNeedles) == 0 || !$blnMatchAll))
            return true;

        if(!$blnFound && count($arrNeedles) == 0 || $blnMatchAll)
            return false;

        return array_multi_key_exists($arrNeedles, $arrHaystack, $blnMatchAll);
    }
}