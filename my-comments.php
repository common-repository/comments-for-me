<?php
/*
Plugin Name: My Comments
Plugin URI: http://wordpress.org/extend/plugins/author-comments/
Description: Extend wordpress to provide author specific comment moderation.
Version: 1.0
Author: smrtr
Author URI: http//smrtr.co.uk
License: MIT license (http://www.opensource.org/licenses/mit-license.php)
*/
//error_reporting(E_ALL);
//hide general comments
require_once('configure.php');
require_once('bootstrap.php');

$directories = array(
    mc_abs_inc.'/libs',
    mc_abs_inc,
    mc_abs_inc.'/models'
);

new Smrtr_Model_MyCommentsBootstrap($directories);
new Smrtr_Model_MyCommentsPages;

global $mc_comments;
$mc_comments = new Smrtr_Model_WpComments;
// admin action

