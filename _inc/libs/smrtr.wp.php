<?php

/**
 * Smrtr Class helper for wordpress items
 */
if ( !class_exists( 'smrtrWP' ) ) {
class smrtrWP {
    
    
    
    /**
    * Are we in the admin section of wordpress
    * @param type $file_handler
    * @param type $post_id
    * @param type $setthumb 
    */
    
    public static function isSite(){
        
        if($_SERVER['PHP_SELF']==='index.php')
            return true;
        
        
    }
    
    public static function dt2ts($datetime_str)
    {
        list( $y, $m, $d, $h, $i, $s ) = preg_split( '([^0-9])', $datetime_str);

        return mktime($h, $i, $s, $m, $d, $y);
    }
    
    public static function stringGen($length=7,$chars=''){
        
        $length =$length==0?10:$length;
        
        $c = "";
        $chars = $chars?$chars:"abcdefghijklm78y98npqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
        
        srand((double)microtime() * 1000000);
        for ($i = 0; $i < $length; $i++)
        {
            $c .= substr($chars, rand() % strlen($chars), 1);
        }
        return $c;
        
    }
    
    
    public static function login( $user ) {
        $username   = $user;
        // log in automatically
        if ( !is_user_logged_in() ) {
            $user = get_userdatabylogin( $username );
            $user_id = $user->ID;
            $user_login = $user->user_login;
            wp_set_current_user( $user_id, $user_login );
            wp_set_auth_cookie( $user_id );
            do_action( 'wp_login', $user_login );
        }     
    }

    
    public static function genUniqueID($col,$table,$length=7,$chars=''){
     
        global $wpdb;
        
        $chars = $chars?$chars:'12493875642956';
        $exists = true;
        do{

            $guid = self::stringGen($length,$chars);

         
            $exists = (boolean) $wpdb->get_var("
            SELECT COUNT($col) as the_amount FROM $table WHERE $col = '$guid'");
            //$wpdb->show_errors();
            //$wpdb->print_error();

        } while (true == $exists);

        return $guid;
    }
    
    
    public static function rowExists($table,$col,$data,$format='%d'){

        global $wpdb;
        return (boolean)$wpdb->get_var(sprintf("select count(1) from $table where $col='$data'"));
        
        //$wpdb->show_errors();
        //$wpdb->print_error();
        //return (boolean)
    }
    public static function updateRow($table,$set,$where,$set_format,$where_format){

        global $wpdb;
        $result = $wpdb->update($table,$set,$where,$set_format,$where_format);
        //$wpdb->show_errors();
        //$wpdb->print_error();
        return $result;
    }
    public static function getRow($table,$col,$data,$select='*'){

        global $wpdb;
        $res =  $wpdb->get_row("select $select from $table where $col='$data'");
        
        
        if($res){
            
            
            if(count(get_object_vars($res))==1){
                
                return $res->{$select};
                
            }else return $res;
        }
        
        return false;
        
    }
    
    
 

}


}
?>
