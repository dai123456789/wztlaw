<?php
if(!defined('ABSPATH'))exit;
if(is_admin()){
	require get_template_directory() . '/inc/admin/init.php';
	new wztlaw();
}else{
	require get_template_directory() . '/inc/index/init.php';
	new wztlaw();
}
