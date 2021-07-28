<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title><?php echo wztlaw_gettitle()?></title>
<meta content="width=device-width, initial-scale=1.0, user-scalable=no, minimal-ui" name="viewport">
<?php $wztlaw_theme = get_option('wztlaw_theme'); ?>
<link rel="icon" href="<?php echo $wztlaw_theme['favicon'];?>"  />
<?php wp_head(); ?>
<?php 
    $wztlaw_theme = get_option('wztlaw_theme'); 
    if(isset($wztlaw_theme['bg']) && $wztlaw_theme['bg']){
        $head_bg= $wztlaw_theme['bg'];
    }else{
        $head_bg= '#ffffff';
    }
    if(isset($wztlaw_theme['color']) && $wztlaw_theme['color']){
        $head_cl= $wztlaw_theme['color'];
    }else{
        $head_cl= '#333333';
    }
    $wztlaw_foot = get_option('wztlaw_foot');
    if(isset($wztlaw_foot['bg']) && $wztlaw_foot['bg']){
        $foot_bg= $wztlaw_foot['bg'];
    }else{
        $foot_bg= '#2d2d2d';
    }
    if(isset($wztlaw_foot['color']) && $wztlaw_foot['color']){
        $foot_cl= $wztlaw_foot['color'];
    }else{
        $foot_cl= '#ffffff';
    }
    $wztlaw_index = get_option('wztlaw_index');
    if(isset($wztlaw_index['mouse']) && $wztlaw_index['mouse']){
        $button_sj= $wztlaw_index['mouse'];
    }else{
        $button_sj= '#BC1515';
    }
    if(isset($wztlaw_index['color']) && $wztlaw_index['color']){
        $side_cl= $wztlaw_index['color'];
    }else{
        $side_cl= '#ffffff';
    }
    if(isset($wztlaw_index['bg']) && $wztlaw_index['bg']){
        $side_bg= $wztlaw_index['bg'];
    }else{
        $side_bg= '#BC1515';
    }
    $wztlaw_business = get_option('wztlaw_business');
     if(isset($wztlaw_business['color']) && $wztlaw_business['color']){
        $ywly_cl= $wztlaw_business['color'];
    }else{
        $ywly_cl= '#BC1515';
    }
    if(isset($wztlaw_business['size']) && $wztlaw_business['size']){
        $ywly_size= $wztlaw_business['size'].'px';
    }else{
        $ywly_size= '21px';
    }

?>
<style>
.ywly .cont .nohavecon h2,.ywly .item h2{
    color: <?php echo $ywly_cl; ?>;
    font-size: <?php echo $ywly_size; ?>;
}
    .wzt_Header,
    .wzt_Header .wzt_navList>div>ul>li{
        background:<?php echo $head_bg; ?>;
    }
    .wzt_navH .wzt_navList>div>ul>li a{
          color:<?php echo $head_cl; ?>;
    }
  
    .foot{
        background:<?php echo $foot_bg ; ?>;
    }
    .ft_menu div,
    .ft_info .fz,
    .foot .ft_b,
    {
        color:<?php echo $foot_cl; ?>;
    }
     .Exhibition_items{
           -webkit-box-shadow: inset 0 0 0 3px <?php echo $button_sj; ?>;
    box-shadow: inset 0 0 0 3px <?php echo $button_sj; ?>;
     }
     .Exhibition_items::after{
          border-color: <?php echo $button_sj; ?><?php echo $button_sj; ?> transparent transparent;
     }
    .wzt_more a:hover,
     .wzt_more a:focus,
     .wzt_lstdCarouse .item-title a:hover,
    .wzt_lstdCarouse .item-title a:focus, 
    .wzt_wzlb .wzt_ServixeRight ul li .content h2 a:hover,
    .wzt_wzlb .wzt_ServixeRight ul li .content h2 a:focus,
    .wzt_wzlb .wzt_consultingService .wzt_ServixeLeft h3 a:hover,
    .wzt_wzlb .wzt_consultingService .wzt_ServixeLeft h3 a:focus,
    .wzt_yqlj .menu .lk.cur, .wzt_yqlj .menu .lk:hover,
    .wzt_yqlj .list a:hover,
    .wzt_yqlj .list a:focus,
    .ft_menu a:hover,
    .wzt_LawyerTeam .wzt_LawyerTeamList .link ul li a:hover,
    .paginations a:hover, .paginations a:focus,.teamdetailsItem .wzt_textLIst ul li a:hover,
    .teamdetailsItem .wzt_textLIst ul li a:focus,
    .teamdetailsItem .wzt_label a:hover,
    .teamdetailsItem .wzt_label a:focus,
    .ArticleListBox .wzt_Textlable a:hover,
    .ArticleListBox .wzt_Textlable a:focus,
    .teamdetailsright .teamrightList .wzt_textLIst ul li .wzt_textLIstR h2 a:hover,
    .teamdetailsright .teamrightList .wzt_textLIst ul li .wzt_textLIstR h2 a:focus,
    .ArticleListBox .wzt_Pages a:hover,
    .ArticleListBox .wzt_Pages a:focus,
    .post-loop-image-news .item-title a:hover,
    .ArticleListBox .wzt_Recommend ul li a:hover,
    .ArticleListBox .wzt_Recommend ul li a:focus,
.widget_nav_menu>div>ul>li a:hover, .teamdetailsLeft .widget_categories>ul>li a:hover, .teamdetailsLeft .widget_recent_entries>ul>li a:hover, .teamdetailsLeft .widget_recent_comments>ul>li a:hover, .teamdetailsLeft .widget_archive>ul>li a:hover, .teamdetailsLeft .widget_meta>ul>li a:hover, .teamdetailsLeft .widget_meta>ul>li a:hover,
.widget_nav_menu>div>ul>li a:focus, .teamdetailsLeft .widget_categories>ul>li a:focus, .teamdetailsLeft .widget_recent_entries>ul>li a:focus, .teamdetailsLeft .widget_recent_comments>ul>li a:focus, .teamdetailsLeft .widget_archive>ul>li a:focus, .teamdetailsLeft .widget_meta>ul>li a:focus, .teamdetailsLeft .widget_meta>ul>li a:focus,.teamdetailsLeft .tagcloud a:hover,
.teamdetailsLeft .tagcloud a:focus
{
        color:<?php echo $button_sj; ?>;
    }
    .wzt_Header .wzt_navList .menu-item-has-children>a:hover::after{
        
            border-bottom: 1px solid <?php echo $button_sj; ?>;
    border-right: 1px solid <?php echo $button_sj; ?>;
    }
    .wzt_wzlb .wzt_consultingService .xian::before{
        background: <?php echo $button_sj; ?>;
        
    }
   .teamdetailsLeft .widget h3,#searchsubmit{
       background: <?php echo $side_bg; ?>;
    }
    .wzt_Header .wzt_navList .menu-item-has-children>a::after{
        border-bottom: 1px solid <?php echo $head_cl; ?>;
        border-right: 1px solid <?php echo $head_cl; ?>;
    }
    .detailbox .wztlaw_container{
        max-width:800px!important;
    }
    .teamdetailstitle .wztlaw_container{
        max-width:800px!important;
    }
</style>
</head>

<body>
<header class="wzt_Header">
        <div class="wzt_navH">
            <div class="wztlaw_header">
                <div class="wzt_logo pc">
                    <?php if(isset($wztlaw_theme['pc_logo']) && $wztlaw_theme['pc_logo'] ){ ?>
                    <a href="/"><img src="<?php echo $wztlaw_theme['pc_logo']; ?>" alt="<?php if(isset($wztlaw_theme['pc_alt'])){echo $wztlaw_theme['pc_alt'];}?>"></a>
                    <?php 
                        }else{
                    ?>
                    <div>请在后台主题设置-》头部设置中设置电脑端logo图片</div>
                    <?php }?>
                </div>
                <div class="wzt_logo sm">
                    <?php if(isset($wztlaw_theme['mobile_logo']) && $wztlaw_theme['mobile_logo'] ){ ?>
                    <a href="/"><img src="<?php echo $wztlaw_theme['mobile_logo']; ?>"></a>
                    <?php 
                        }else{

                    ?>
                    <div>请在后台主题设置-》</br>头部设置中设置手机端logo图片</div>
                    <?php }?>
                </div>
                <div class="wzt_icon">
                    <img src="<?php echo get_template_directory_uri().'/assets/images/'?>caidan.png" alt="">
                </div>
            </div>
            <div class="wzt_navList pc">
                 <?php

                    if( has_nav_menu('wztlaw_topmenu') ) {
                        wp_nav_menu( [
                            'theme_location'  => 'wztlaw_topmenu',
                            'depth'           => 0,]
                            );
                    }else{
                ?>
                <div>请在后台外观-》菜单中添加菜单选中顶部显示位置</div>
                <?php
                    }
                ?>
                
            </div>
            <div class="wzt_navList wzt_navListS sm">
                 <?php

                    if( has_nav_menu('wztlaw_topmenu') ) {
                        wp_nav_menu( [
                            'theme_location'  => 'wztlaw_topmenu',
                            'depth'           => 0,]
                            );
                    }else{
                ?>
                <div>请在后台外观-》</br>菜单中添加菜单选中顶部显示位置</div>
                <?php
                    }
                ?>
            </div>
        </div>
    </header>
       <div class="wztlaw_consultation ">
        <?php $wztlaw_social = get_option('wztlaw_social');if(isset($wztlaw_social['auto']) && $wztlaw_social['auto']){?>
        
        <ul <?php if(!isset($wztlaw_social['mobile_auto']) ||  !$wztlaw_social['mobile_auto']){echo 'class="pc"';}?>>
            <li class="wztlaw_search_form">
                <?php echo get_search_form( false );?>
                <img src="<?php echo get_template_directory_uri().'/assets/images/'?>search.png" alt="" class="ico">
            </li>
            <?php if(isset($wztlaw_social['qq']) && $wztlaw_social['qq']){?>
            <li>
                <a id="qq" href="<?php echo 'http://wpa.qq.com/msgrd?v=3&amp;uin='.$wztlaw_social['qq'].'&amp;site=qq&amp;menu=yes'; ?>" target="_blank" rel="nofollow">
                    <img src="<?php echo get_template_directory_uri().'/assets/images/'?>qq.png" alt="" class="ico">
                </a>
                <span class="ewm animated flipInX" id="qqr" style="">
                    <?php echo $wztlaw_social['qq'];?>
                </span>
            </li>
            <?php }?>
            <?php if(isset($wztlaw_social['wx']) && $wztlaw_social['wx']){?>
            <li>
                <a id="weixin">
                    <img src="<?php echo get_template_directory_uri().'/assets/images/'?>weixin.png" alt="" class="ico">
                </a>
                <span class="ewm1 animated flipInX" id="weix">
                    <img src="<?php echo $wztlaw_social['wx'];?>">
                </span>
            </li>
            <?php }?>
            <?php if(isset($wztlaw_social['mobile']) && $wztlaw_social['mobile']){?>
            <li>
                <a id="dianh" href="tel:<?php echo $wztlaw_social['mobile'];?>">
                    <img src="<?php echo get_template_directory_uri().'/assets/images/'?>phone1.png" alt="" class="ico">
                </a>
                <span class="ewm animated flipInX" id="dianha">
                    <?php echo $wztlaw_social['mobile'];?>
                </span>
            </li>
            <?php }?>
            <?php if(isset($wztlaw_social['wb']) && $wztlaw_social['wb']){?>
            <li>
                <a id="weib" href="<?php echo $wztlaw_social['wb'];?>" target="_blank" rel="nofollow">
                    <img src="<?php echo get_template_directory_uri().'/assets/images/'?>weibo.png" alt="" class="ico">
                </a>
                <span class="ewm animated flipInX" id="weibo">
                    <?php echo $wztlaw_social['wb'];?>
                </span>
            </li>
            <?php }?>
            <?php if(isset($wztlaw_social['email']) && $wztlaw_social['email']){?>
            <li>
                <a id="youxi">
                    <img src="<?php echo get_template_directory_uri().'/assets/images/'?>youjian.png" alt="" class="ico">
                </a>
                <span class="ewm animated flipInX" id="youxa">
                    <?php echo $wztlaw_social['email'];?>
                </span>
            </li>
            <?php }?>
            <li>
                <a id="huiding">
                    <img src="<?php echo get_template_directory_uri().'/assets/images/'?>huiding.png" alt="" class="ico">
                </a>
            </li>
        </ul>
        <?php }?>
    </div>
    <script>
        $(function(){
           var width=document.body.clientWidth;
           console.log(width)
           if(width<1000){
               $(".wzt_Header .wzt_navList .menu-item-has-children>a").click(function(e){
                   e.preventDefault();
               })
                   
              
           }
           $("#qq").hover(function() {
            $("#qqr").show();

        }, function() {
            $("#qqr").hide();
        })
        $("#weixin").hover(function() {
            $("#weix").show();

        }, function() {
            $("#weix").hide();
        })
        $("#dianh").hover(function() {
            $("#dianha").show();

        }, function() {
            $("#dianha").hide();
        });
        $("#youxi").hover(function() {
            $("#youxa").show();

        }, function() {
            $("#youxa").hide();
        })
        $("#weib").hover(function() {
            $("#weibo").show();

        }, function() {
            $("#weibo").hide();
        });
        $("#huiding").click(function() {
            $("html,body").animate({
                scrollTop: 0
            }, 500);
        })
        })
    </script>
   

    