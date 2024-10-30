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
                $comment    = $mc_comments->getComment($id);
                
                
                $submitted = false;
                if(isset($_POST['comment'])){
                    
                    
                    $insert = array();
                    
                    $insert['post_id']        = $comment->comment_post_ID;
                    $insert['post_author']    = $comment->post_author;
                    $insert['comment_parent'] = $comment->comment_ID;
                    $insert['comment_author'] = $comment->comment_author;
                    $insert['comment_email']  = $comment->comment_author_email;
                    $insert['comment_url']    = $comment->comment_author_url;
                    $insert['comment']        = $wpdb->prepare($_POST['comment']);;

                    $submitted = $mc_comments->insertComment($insert);
                }
                
                
                if($submitted==false){
                 ?>
                <form action="/wp-admin/admin.php?page=comments&view=reply&c=<?php echo $comment->comment_ID;?>" method="POST">
                    <div class="row-fluid">
                        <div class="well span10">
                            <h3>Reply to comment:<small> <?php echo $comment->post_title;?></small></h3>
                            
                            <br/>
                            <blockquote>
                                <?php echo nl2br($comment->comment_content);?><br/><br/>
                                <small>By <?php echo $comment->comment_author;?>, <?php echo date('d M Y @H:i',smrtrWP::dt2ts($comment->comment_date));?></small>
                            </blockquote>
                            <br/>

                            <textarea name="comment" rows="10" class="span12" style="height:300px"></textarea>
                            <br/>
                            <button class="btn2">Reply to comment</button>
                            <?php //include('list-applicant-apps.php');?>
                        </div>

                    </div>
                </form>
                <?php
                }else{
                    smrtrMsg::fail('Your reply has been submitted.');
                }

        }else {
            smrtrMsg::fail('Comment does not exist');
        }

    }
    
    
    ?>
</div>