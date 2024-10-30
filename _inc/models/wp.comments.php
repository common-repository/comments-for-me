<?php


class Smrtr_Model_WpComments{

    /**
     * Reading Actions
     */
    public function getComment($id){
        
        global $wpdb;
      
        $sql = sprintf('select * 
             from wp_comments c
             left join wp_users u on u.ID=c.user_id
             left join wp_posts p on c.comment_post_ID=p.ID where c.comment_ID=%d',$id);
        
        return $wpdb->get_row($sql);
         
    }
    
    public function getComments(){
        
        global $wpdb;

        $sql = sprintf('select * 
            from wp_comments c
            left join wp_users u on u.ID=c.user_id
            left join wp_posts p on c.comment_post_ID=p.ID');
        
        return $wpdb->get_results($sql);
    }
    
    
    public function getCommentProperty($id,$property){
        global $wpdb;
      
        $sql = sprintf('select %s 
             from wp_comments c
             left join wp_users u on u.ID=c.user_id
             left join wp_posts p on c.comment_post_ID=p.ID where c.comment_ID=%d',$property,$id);
        
         $ret = $wpdb->get_var($sql);
         //$wpdb->show_errors();$wpdb->Print_error();
         return $ret;
    }
    
    public function commentExists($id){
        
       global $wpdb;
       
       return (bool)$wpdb->get_var(sprintf('select count(1) from wp_comments where comment_ID=%d',$id));
       
    }
    
    public function getStatus($id){
        
        return $this->getCommentProperty($id,'c.comment_approved');
    }
    
    
    /*
     * Executables 
     */
    
    public function insertComment(array $insert){
        
        global $wpdb;
        
        $data = array();
        

        $data['comment_post_ID']      = (int)$insert['post_id'];
        $data['user_id']              = (int)$insert['post_author'];
        $data['comment_parent']       = (int)$insert['comment_parent'];
        
        $data['comment_approved']     = 1;
        
        $data['comment_author']       = $insert['comment_author'];
        $data['comment_author_email'] = $insert['comment_email'];
        $data['comment_author_url']   = $insert['comment_url'];
        $data['comment_content']      = $insert['comment'];
        
        $data['comment_author_IP']    = $_SERVER['SERVER_ADDR'];
        $data['comment_agent']        = $_SERVER['HTTP_USER_AGENT'];
        $data['comment_date']         = date('Y-m-d H:i:s');
        $data['comment_date_gmt']     = date('Y-m-d H:i:s');
        
        $data_format = array('%d','%d','%d','%d','%s','%s','%s','%s','%s','%s','%s','%s');
        
        $result = $wpdb->insert('wp_comments',$data,$data_format);

        
        $ttl = $wpdb->get_var(sprintf('select count(1) from wp_comments where comment_post_ID=%d',$insert['post_id']));

        $where = array( 'ID' => $insert['post_id']);
        $where_format = array('%d');
        
        $result = $wpdb->update('wp_posts',array('comment_count'=>$ttl), $where,array('%d'),$where_format);

        
        if($result)
            return true;
        else return false;
        
    }
    
    public function updateComment($id,$comment){
        
        global $wpdb;

        $where = array( 'comment_ID' => $id);
        $where_format = array('%d');

        $result = $wpdb->update('wp_comments',array('comment_content'=>$comment), $where,array('%s'),$where_format);

        if($result)
            return true;

        return false;
    }
    
    public function updateCommentStatus($id,$status){
        
        global $wpdb;

        $where        = array( 'comment_ID' => $id);
        $where_format = array('%d');
        $data         = array('comment_approved'=>$status);
        $data_format  = array('%s');
        
        $result = $wpdb->update('wp_comments',$data, $where,$data_format,$where_format);


        if($result)
            return true;

        return false;
    }
    
    
    
    public function deleteComment($id){
        
        global $wpdb;
        
        $sql = sprintf('delete from `wp_comments` where comment_ID=%d and comment_approved="trash"',$id);
        $result = $wpdb->query($sql);

        
        
        if($result)
            return true;

        return false;
    }
    
    
    public function hasStatus($id,$status){
        
        global $wpdb;
        return (boolean) $wpdb->get_var(sprintf('select count(1) from wp_comments where comment_ID=%d and comment_status=%s',$id,$status));
        
    }
    
    public function saveCommentMeta($id,$status){
        
        global $wpdb;
        return (boolean) $wpdb->get_var(sprintf('select count(1) from wp_comments where comment_ID=%d and comment_status=%s',$id,$status));
        
    }
    
    public function deleteCommentMeta($id,$key,$value){
        
        global $wpdb;
        return (boolean) $wpdb->get_var(sprintf('select count(1) from wp_comments where comment_ID=%d and comment_status=%s',$id,$status));
        
    }
   
    public function commentMetaExists($id,$meta_key){
        
        global $wpdb;
        return (boolean) $wpdb->get_var(sprintf('select count(1) from wp_commentmeta where meta_key=%d and comment_status=%s',$id,$status));
    }
    
    
    
    public function mc_convertAction($action){
        switch ($action){
            case 'approve':
                return 1;
            case 'unapprove':
                return 0;
            case 'trash':
            case 'delete':
            case 'spam':
                return $action;
            case 'unspam':
            case 'untrash':
                return 0;
        }
    }


   public function do_actions($items,$action){

      
        if(!is_array($items))
            return array();
        
        $changes = array();
        foreach($items as $id){

            $converted_action = (string)$this->mc_convertAction($action);

            switch ($converted_action){

                case 'delete':
                    if($this->deleteComment($id,$converted_action))
                            $changes[] = $converted_action;
                    break;
                default:

                    if($this->updateCommentStatus($id,$converted_action))
                            $changes[] = $converted_action;

                    break;
            }
        }
    
        return $changes;
    }
}




?>