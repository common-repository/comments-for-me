<div class="tbswp wrap">
    
    <?php

    $this->getBlock('header');

    $tabs = array(
        'all'      =>'List All',
        'pending'  =>'List Pending',
        'approved' =>'List Approved',
       
        'spam'     =>'List Spammed',
        'trash'    =>'List Trashed',
        
        'edit'     =>'Edit Comment',
        'reply'    =>'Reply to Comment'
        );

    $a = new smrtrTabs($tabs,mc_abs_plug.'/_layouts/comments','view');
    $a->keepQueryStrings(array('view','page'));
    ?>

    <?php $a->menu(array('class'=>'nav nav-pills')); ?>
    <div class="tab-content">
    <?php $a->canvas(); ?>
    </div>

</div>


