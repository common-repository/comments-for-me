<?php

class Smrtr_Model_MyCommentsPages extends Smrtr_Model_WpAdminPages{
    
    public function __construct()
    {
       
        $this->setLayoutLocation(mc_abs_layouts);
        $this->setBlockLocation(mc_abs_blocks);
        
        //about page
        $this->addPage('My Comments','comments','moderate_comments');
     
        //$this->addSubPage("Entries ($entries->total)",'entries','moderate_comments','comments');
      
        $this->setAdminPage($this->getCurrentPage());
	add_action( 'admin_menu', array( &$this, 'createPages' ) );
        
        return $this;
    }
}
