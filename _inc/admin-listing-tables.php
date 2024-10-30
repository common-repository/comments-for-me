<?php
class Smrtr_Model_MyCommentsListing extends smtrWp_Table_Core{
    
    
    function actionButton($key,$id,$icon,$text,$url='button'){
        
        switch($url){
            case 'button':
                return sprintf( '<button class="btn2" name="%s[]" value="%s"><i class="%s"></i>&nbsp;&nbsp;%s</button>',$key,$id,$icon,$text );
            default:
                 return sprintf( '<a class="btn2" href="%s&view=%s&c=%s"><i class="%s"></i>&nbsp;&nbsp;%s</a>',$url,$key,$id,$icon,$text );
        }
        
    }
    
    function column_default( $item, $col )
    {
        
        $url     = '/wp-admin/admin.php?page=comments';
        $actions = array();
        $view    = isset($_REQUEST['view'])?$_REQUEST['view']:'all';
        
        if(!in_array($view,array('spam','trash'))){
            $actions['edit']          = $this->actionButton('edit' ,    $item->ID,'icon-pencil',     'Edit' ,$url);
            $actions['reply']         = $this->actionButton('reply',    $item->ID,'icon-share-alt',  'Reply',$url);
            $actions['approve']       = $this->actionButton('approve',  $item->ID,'icon-thumbs-up',  'Approve');
            $actions['unapprove']     = $this->actionButton('unapprove',$item->ID,'icon-thumbs-down','Unapprove');
            $actions['spam']          = $this->actionButton('spam',     $item->ID,'icon-ban-circle',  'Spam');
            $actions['trash']         = $this->actionButton('trash',    $item->ID,'icon-trash',       'Trash');
           
        }
        
        if($view=='spam')
        {
            $actions['trash']         = $this->actionButton('trash',    $item->ID,'icon-trash',       'Trash');
            $actions['unspam']        = $this->actionButton('unspam',   $item->ID,'icon-ok-circle' ,  'Unspam');
        }
        
        if($view=='trash'){
            $actions['untrash']   = $this->actionButton('untrash',  $item->ID,'icon-folder-open', 'Untrash');
            $actions['delete']    = $this->actionButton('delete',   $item->ID,'icon-remove',      'Delete');
        }
       


        
	switch ( $col ) {
           
            case 'author':
                return sprintf('%s<br/><small><a href="mailto:%s">%s</a></small><br/>%s',$item->$col,$item->email,$item->email,$item->ip);
                break;
	    case 'date':
                return date('d M Y @H:i',smrtrWP::dt2ts($item->$col));
                break;
            case 'comment':
                return $item->$col.$this->row_actions( $actions );
	    default:
                return $item->$col;
                
	}
    }
    
    function single_row( $item ) {

        static $alternate = 'alternate';
        
        $class = array();
        
        $class[] = $alternate = $alternate=='alternate'?'':'alternate' ;
        
        $class[] = $item->comment_approved==1?'approved':'unapproved';
        
        //echo $item->comment_approved;
        
        $temp = trim(implode(' ',$class));
        
        $row_class= $temp?'class="'.$temp.'"':'';
        
        
        printf('<tr %s>',$row_class);
        echo $this->single_row_columns( $item );
        printf('</tr>');

    }
    
    
    
  
   
}
