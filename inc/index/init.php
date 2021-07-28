<?php
if(!defined('ABSPATH'))exit;
class wztlaw{
    public function __construct() {
        $this->wztlaw_index(); 
    }
    public function wztlaw_index(){
        require get_template_directory() . '/inc/index/index.php';
        
        new wztlaw_index();
    }
}
?>