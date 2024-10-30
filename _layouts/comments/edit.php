<div class="tbswp wrap">

<?php

    $this->getBlock('header','/admin');
    
    global $wpdb;
    
  
    if(!isset($_REQUEST['c'])){
        
        smrtrMsg::fail('Please select a comment to reply to.');
        //include('all.php');
    
    }else{
        
        $id = $_REQUEST['c'];
        
        global $mc_comments;
        
        if($mc_comments->commentExists($id)){

                
                if(isset($_POST['comment'])){
                    
                    $text = $wpdb->prepare($_POST['comment']);
                    $mc_comments->updateComment($id,$text);
                }
                $comment    = $mc_comments->getComment($id);

                 ?>
                  <form action="/wp-admin/admin.php?page=comments&view=edit&c=<?php echo $comment->comment_ID;?>" method="POST">
                    <div class="row-fluid">
                        <div class="well span10">
                            <h3>Edit comment<small> made on <?php echo $comment->post_title;?></small></h3>
                            
                            <br/>
                          

                            <textarea name="comment" rows="10" class="span12" style="height:300px"><?php echo str_replace("\\",'',htmlspecialchars($comment->comment_content,ENT_QUOTES));?></textarea>
                            <br/>
                            <button class="btn2">Update Comment</button>
                            <?php //include('list-applicant-apps.php');?>
                        </div>

                    </div
                  </form>
                <?php

        }else {
            smrtrMsg::fail('Comment does not exist');
        }

    }
    
    
    ?>
</div>