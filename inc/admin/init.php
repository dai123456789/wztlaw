<?php
if(!defined('ABSPATH'))exit;
class wztlaw{
    public function __construct() {
        $this->wztlaw_admin();
    }
    public function wztlaw_admin(){
        require get_template_directory() . '/inc/admin/admin.php';
        new wztlaw_admin();
    }
}
?>