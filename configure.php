<?php

/* 
 * Configure commonly used paths
 */

define('mc_url_jquery','http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js');
$plugin_abs = str_replace('/','\\',dirname(__FILE__));
define('mc_abs_plug',str_replace('\\','/',$plugin_abs));
$plugin_dir = end(explode('\\',$plugin_abs));


//host
define('mc_url_host',   get_bloginfo('url'));
define('mc_url_plug',   plugins_url().'/'.$plugin_dir);
define('mc_rel_plug',   str_replace(mc_url_host,'',mc_url_plug));

//lib root
define('mc_abs_inc',    mc_abs_plug . '/_inc');
define('mc_url_inc',    mc_url_plug . '/_inc');
define('mc_rel_inc',    mc_rel_plug . '/_inc');

//asset root
define('mc_abs_assets', mc_abs_plug . '/_assets');
define('mc_url_assets', mc_url_plug . '/_assets');
define('mc_rel_assets', mc_rel_plug . '/_assets');

//block root
define('mc_abs_blocks', mc_abs_plug . '/_blocks');
define('mc_url_blocks', mc_url_plug . '/_blocks');
define('mc_rel_blocks', mc_rel_plug . '/_blocks');


define('mc_abs_layouts', mc_abs_plug . '/_layouts');
define('mc_url_layouts', mc_url_plug . '/_layouts');
define('mc_rel_layouts', mc_rel_plug . '/_layouts');


$cols = array();
$cols['cb']        = '<input type="checkbox"/>';
$cols['author']    = array('Author',1);
$cols['comment']   = array('Comment',1);
$cols['title']     = array('Post Title',1);
$cols['date']      = array('Date',1);
$cols['count']     = array('Count',1);


$keys = array();
$keys['date']    ='c.comment_date';
$keys['comment'] ='c.comment_content';
$keys['title']   ='p.post_title';
$keys['author']  ='c.comment_author';
$keys['count']   ='p.comment_count';

$GLOBALS['my_comments']['cols'] = $cols;
$GLOBALS['my_comments']['keys'] = $keys;

define('MC_RPP',10);