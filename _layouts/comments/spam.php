<div class="tbswp wrap">
    <?php
            global $wpdb,$mc_comments;
           
            $usr    = wp_get_current_user();
            $uid    = $usr->data->ID;
            
            $list   = new Smrtr_Model_MyCommentsListing ;
            $action = $list->getAction(array('unapprove','unspam','approve','trash','untrash','spam'));
            $items  = $_POST['action']==-1&&$_POST['action2']==-1?$_POST[$action]:$_POST['action_items'];

            $do_actions = $mc_comments->do_actions($items,$action);
            
           
            if(is_array($do_actions)&&count($do_actions)>0)
            smrtrMsg::info("Comment(s) have been moved.");
            
            $list->setLimit(MC_RPP);
            $list->setOrdering();        
            $list->setColumns($GLOBALS['my_comments']['cols']);
            
            $list->setBulkActions(array(
                     'trash'     => 'Trash',
                     'unspam'    => 'Unspam',
                    ));
            
         
            $ordering = isset($GLOBALS['my_comments']['keys'][$list->orderby])?
                    sprintf('order by %s %s',$GLOBALS['my_comments']['keys'][$list->orderby],$list->order):'';

            if(!$ordering){
                $ordering = 'order by c.comment_date desc';
            }


            $sql_base = sprintf('
            from wp_comments c left join wp_posts p on c.comment_post_ID=p.ID
            where p.post_status="publish" and c.comment_approved="spam"
            and p.post_author=%d',$uid);


            $sql_data =  sprintf('select 
            c.comment_ID as ID,
            c.comment_post_ID,
            c.comment_author as author,
            c.comment_author_email as email,
            c.comment_author_url,
            c.comment_author_IP as ip,
            c.comment_date as date,
            c.comment_date_gmt,
            c.comment_content as comment,
            c.comment_approved,
            c.comment_type as cb,
            c.comment_parent,
            c.user_id,
            c.comment_type as actions,
            p.post_title as title,
            p.comment_count as count
            %s

            %s  %s;',$sql_base,$ordering,$list->sql->limit);

            $sql_count = sprintf('select count(1) %s #base query',$sql_base);
            $data      = $wpdb->get_results($sql_data);
            $total     = $wpdb->get_var($sql_count);

            $list->prepare_items($data,$total,MC_RPP);
            
            echo $list->printStyles('table ',array(
             '.column-author' => 'width:15%!important;line-height:19px',
             '.column-comment'=> 'width:60%!important;line-height:19px;',
             '.column-title'  => 'width:10%!important',
             '.column-date'   => 'width:10%!important',
             '.column-count'  => 'width:5%!important',
            ));
    ?>
    <form action="/wp-admin/admin.php?page=comments&view=spam" method="POST">
        <?php $list->display();?>
    </form>
</div>