<?php
//主题更新
require 'theme-updates/theme-update-checker.php';  
$example_update_checker = new ThemeUpdateChecker(  
    'wztlaw',                                              
    'http://wp.seohnzz.com/themes/info.json'   
); 
//去除wordpress自带工具栏
add_filter('show_admin_bar', '__return_false');
add_action( 'wp_enqueue_scripts', 'wztlaw_enqueue' );
require get_template_directory().'/inc/class/function.php';
//加载功能
require get_template_directory() .'/inc/wztlaw.php';
$wztlaw_sc404 = get_option('wztlaw_sc404');

if($wztlaw_sc404!=1){
    $sc404 = file_get_contents('./wp-content/themes/wztlaw/404.php');
    file_put_contents('404.html',$sc404);
    add_option('wztlaw_sc404',1);
}
add_action('wp_head','wztlaw_mainpage',1);
add_action('wp_footer','wztlaw_foot_add',1);

require get_template_directory().'/inc/class/wztlaw_artpic.php'; 
function wztlaw_widgets_init() {
    register_sidebar( array(
        'name'          => __( '主侧边栏', 'wztlaw' ),
        'id'            => 'sidebar-1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ) );
    register_widget('wztlaw_artpic');
}

add_action( 'widgets_init', 'wztlaw_widgets_init' );
//菜单
function wztlaw_menus() {
     add_post_type_support('post', array('excerpt'));
    //顶部菜单
    register_nav_menus(
        array(
          'wztlaw_topmenu' => __( '顶部菜单' ),
          'wztlaw_footermenu'=>__( '底部菜单' ),
        )
    );
}
add_action( 'init', 'wztlaw_menus' );
function wztlaw_show_category() {
    global $wpdb;
    $request = "SELECT $wpdb->terms.term_id, name FROM $wpdb->terms ";
    $request .= " LEFT JOIN $wpdb->term_taxonomy ON $wpdb->term_taxonomy.term_id = $wpdb->terms.term_id ";
    $request .= " WHERE $wpdb->term_taxonomy.taxonomy = 'category' ";
    $request .= " ORDER BY term_id asc";
    $categorys = $wpdb->get_results($request);
    echo '<div class="uk-panel uk-panel-box" style="margin-bottom: 20px;"><h3 style="margin-top: 0; margin-bottom: 15px; font-size: 18px; line-height: 24px; font-weight: 400; text-transform: none; color: #666;">可能会用到的分类ID</h3>';
    echo "<ul style='overflow:hidden;'>";
    foreach ($categorys as $category) { 
        echo  '<li style="margin-right: 10px;float:left;margin-bottom: 5px;">'.$category->name."（<code>".$category->term_id.'</code>）</li>';
    }
    echo "</ul></div>";
}
?>