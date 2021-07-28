<?php
/*
首页
*/
//加载头部
get_header();
$post_extend = get_post_meta( get_the_ID(), 'wztlaw', true );

if($post_extend){
    if(is_array($post_extend)){
        $post_extend['views'] = isset($post_extend['views'])?$post_extend['views']+1:1;
    }else{
        $post_extend = [];
        $post_extend['views'] =1;
    }
    update_post_meta( get_the_ID(),'wztlaw',  $post_extend );
}else{
    delete_post_meta(get_the_ID(),'wztlaw');
    add_post_meta(get_the_ID(),'wztlaw',['views'=>1]);
}
$category = get_the_category();
if(isset($category[0])){
    $catid = $category[0]->term_id;
}
$category_data = get_term_meta( $catid, 'wztlaw', true );
if(isset($category_data['pic'])&& $category_data['pic']){
?>
<div><img src="<?php echo $category_data['pic'];?>" style="width:100%" alt="<?php echo $category_data['alt'];?>"></div>
<?php
}
if(isset($post_extend['type']) && $post_extend['type']>1){

?>

 <section>
       <div class="ArticleListBox">
        <div class="teamdetails  wztlaw_container">
            <div class="col-lg-3 teamdetailsLeft pc">
                <?php dynamic_sidebar(__( '主侧边栏', 'wztlaw' )); ?>
            </div>
            <div class="col-lg-9 teamdetailsright">
                <div class="teamdetailsItem ">
            <div class="wzt_link row ">
          
                <a href="/">首页</a><span>&raquo;</span><?php if(isset($catid) && $catid){echo get_category_parents( $catid, TRUE, "<span>&raquo;</span>" );}?><span><?php the_title();?></span>
       
            </div>
                <div class="row">
                    <div class="col-lg-6 teamdetailjpg">
                        <?php preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches); ?>
                        <?php if(isset($post_extend['pic']) && $post_extend['pic']){?>
                            <img src="<?php echo $post_extend['pic'];?>" alt="<?php if(isset($post_extend['alt'])&& $post_extend['alt']){echo $post_extend['alt'];}else{echo get_the_title();} ?>">
                            <?php }elseif(isset($matches[1][0])){?>
                            <img src="<?php echo $matches[1][0];?>" alt="<?php if(isset($post_extend['alt'])&& $post_extend['alt']){echo $post_extend['alt'];}else{echo get_the_title();} ?>">
                            <?php }else{?>
                                <img src="<?php echo get_template_directory_uri().'/assets/images/'?>nohai.jpg" alt="<?php if(isset($post_extend['alt'])&& $post_extend['alt']){echo $post_extend['alt'];}else{echo get_the_title();} ?>">
                            <?php }?>
                        
                    </div>
                     <div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
                        <div id="innerdiv" style="position:absolute;">
                            <img id="bigimg" style="border:5px solid #fff;" src="" />
                        </div>
                    </div>
                    <div class="col-lg-6">

                        <div class="tim">
                            <div class="item">
                                <h1 style=""><?php the_title();?></h1>
                                <h4><img class="" src="<?php echo get_template_directory_uri().'/assets/images/'?>time.png" alt="time.png"> <?php echo get_the_date('Y/m/d'); ?></h4>
                                <h4><img class="bimg" src="<?php echo get_template_directory_uri().'/assets/images/'?>sea.png" alt="sea.png"> <?php echo $post_extend['views']; ?></h4>
                              
                                    <div class="bdsharebuttonbox" style="    display: inline-block; vertical-align: text-bottom;float: right;margin-top:7px">
                                        <div class="social-share" data-sites="weibo,qq, wechat, qzone"></div>
        </div>
      
                                <div class="haveteamdetails">
                                    <p><?php echo mb_strimwidth(strip_tags(get_post(get_the_ID())->post_content),0,110,'...');?></p>
                                </div>
                                <div class="wzt_btn wzt_btnC">
                                    <?php if(isset($post_extend['button']) && $post_extend['button']){
                                            foreach($post_extend['button'] as $key=>$val){
                                                if($val['button_type']==1){?>
 
                                                    <button style="border:1px solid <?php echo $val['button_color'];?>"><a href="<?php echo $val['button_url'];?>" style="color:<?php echo $val['button_color'];?>"><i class="<?php echo $val['button_icon']; ?>"></i><?php echo $val['button_title'];?></a></button>
                                                   
                                                <?php }elseif($val['button_type']==2){?>
                                                <button class="imgsbtn" src="<?php echo $val['button_pic']; ?>" style="color:<?php echo $val['button_color']?>;border:1px solid <?php echo $val['button_color'];?>"><i class="<?php echo $val['button_icon']; ?>"></i><?php echo $val['button_title']?></button>
                                                <?php }elseif($val['button_type']==3){?>
                                                <button style="color:<?php echo $val['button_color'];?>; border:1px solid <?php echo $val['button_color'];?>"><a href="http://wpa.qq.com/msgrd?v=3&amp;uin=<?php echo $val['button_qq']; ?>&amp;site=qq&amp;menu=yes" style="color:<?php echo $val['button_color'];?>;" target="_blank" rel="nofollow"><i class="<?php echo $val['button_icon']; ?>"></i><?php echo $val['button_title']?></a></button>

                                        <?php }}}?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class=" row">
                    <div class="teamdetailstitle">
                       <?php the_content();?>
                        <div class="wzt_Textlable">
                    <?php the_tags('标签：', ' · ', ''); ?>
                   
                </div>
                    </div>
                </div>
                
                <div class="wzt_Pages">
                    <div class="wzt_last">
                        <?php $prev_post = get_previous_post();if(!empty($prev_post)){ ?>
                        上一篇：<a href="<?php echo get_permalink($prev_post->ID);?>"><?php echo $prev_post->post_title;?></a>
                        <?php }?>
                    </div>
                    <div class="wzt_next">
                        <?php $next_post = get_next_post();if(!empty($next_post)){?>
                        下一篇：<a href="<?php echo get_permalink($next_post->ID);?>"><?php echo $next_post->post_title;?></a>
                        <?php }?>
                    </div>
                </div>
                <div class="hotTeams">
                    <h3>【最新推荐】</h3>
                    <ul class="post-loop post-loop-image-news ">
                        <?php if(isset($catid) && $catid){ $posts = get_posts( "category=".$catid."&numberposts=10" );
                            foreach($posts as $key=>$val){ ?>
                        <li class="post-item">
                            <div class="post-item-inner">
                                <a href="<?php echo get_permalink($val->ID);?>" >
                                    <?php preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $val->post_content, $matches);
                                        $pos = get_post_meta($val->ID,'wztlaw',true);
                                    ?>
                                    
                                    <img width="480" height="720" src="<?php 
                                        if(isset($pos['pic']) && $pos['pic']){
                                            echo $pos['pic'];
        
                                        }elseif(isset($matches[1][0]) && $matches[1][0]){
                                            echo $matches[1][0];
                                        }else{echo get_template_directory_uri().'/assets/images/nohai.jpg';}?>" class="attachment-default size-default wp-post-image j-lazy" alt="<?php if(isset( $pos['alt'])){echo $pos['alt'];} ?>" />
                                </a>
                                <h2 class="item-title">
                                    <a href="<?php echo get_permalink($val->ID);?>" rel="  "> <?php echo $val->post_title;?></a>
                                </h2>
                                <div class="item-excerpt">
                                    <p><?php echo mb_strimwidth(strip_tags($val->post_content),0,110,'...');?>
                                    </p>
                                </div>
                                <div class="item-meta">
                                    <span class="item-date"><?php echo substr($val->post_modified_gmt,0,10)?></span>
                                </div>
                            </div>

                        </li>
                        <?php }}?>
                       
                    </ul>
                </div>
            </div>

        </div>
        </div>
        </div>
    </section>
<?php }else{?>
 <section>
        <div class="ArticleListBox">
            <div class="teamdetails    wztlaw_container">
                <div class="col-lg-3 teamdetailsLeft pc">
                    <?php dynamic_sidebar(__( '主侧边栏', 'wztlaw' )); ?>
                </div>
                <div class="col-lg-9 articledetailsR ">
                    <div class="teamdetailsItem teamrightList articledetailscont">
                        <div class="wzt_articledetailsR">
                            <div class="wzt_link ">

                                <a href="/">首页</a><span>&raquo;</span><?php if(isset($catid) && $catid){echo get_category_parents( $catid, TRUE, "<span>&raquo;</span>" );}?><span><?php the_title();?></span>

                            </div>
                            <div class="wzt_linkDetails">
                                <h2><?php the_title();?></h2>
                                <p> <span> <?php the_time('Y-m-d h:m:s') ?></span></p>
                                <div class="detailbox">
                                   <?php the_content();?>
                                </div>
                            </div>
                            <div class="flexedsbB botnfen">
                            <div class="wzt_Textlable" style="   ">
                                <?php the_tags('标签：', ' · ', ''); ?>
                               
                            </div>
       
        <!--                    <div class="bdsharebuttonbox">-->
        <!--    <a href="#" class="bds_more" data-cmd="more"></a>-->
        <!--    <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>-->
        <!--    <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>-->
        <!--    <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>-->
        <!--    <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>-->
        <!--    <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>-->
        <!--</div>-->
        <div class="bdsharebuttonbox">
         <div class="social-share" data-sites="weibo,qq, wechat, qzone"></div>
         </div>
                            </div>
                            <div class="wzt_Pages">
                                <div class="wzt_last">
                                    <?php $prev_post = get_next_post();if(!empty($prev_post)){ ?>
                                    上一篇：<a href="<?php echo get_permalink($prev_post->ID);?>"><?php echo $prev_post->post_title;?></a>
                                    <?php }?>
                                </div>
                                <div class="wzt_next">
                                    <?php $next_post = get_previous_post();if(!empty($next_post)){?>
                                    下一篇：<a href="<?php echo get_permalink($next_post->ID);?>"><?php echo $next_post->post_title;?></a>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
}
//加载尾部
get_footer();
?>
<script>
         $(function() {
         //  图片右对齐
            $(".detailbox .alignright").parent().css("text-align","right")
             $(".detailbox .aligncenter").parent().css("text-align","center")
            $(".imgsbtn").click(function() {
                var _this = $(this); //将当前的pimg元素作为_this传入函数 
                imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
            });
        });

        function imgShow(outerdiv, innerdiv, bigimg, _this) {
            var src = _this.attr("src"); //获取当前点击的pimg元素中的src属性 
            $(bigimg).attr("src", src); //设置#bigimg元素的src属性 
            /*获取当前点击图片的真实大小，并显示弹出层及大图*/
            $("<img/>").attr("src", src).load(function() {
                var windowW = $(window).width(); //获取当前窗口宽度 
                var windowH = $(window).height(); //获取当前窗口高度 
                var realWidth = this.width; //获取图片真实宽度 
                var realHeight = this.height; //获取图片真实高度 
                var imgWidth, imgHeight;
                var scale = 0.8; //缩放尺寸，当图片真实宽度和高度大于窗口宽度和高度时进行缩放 
                if (realHeight > windowH * scale) { //判断图片高度 
                    imgHeight = windowH * scale; //如大于窗口高度，图片高度进行缩放 
                    imgWidth = imgHeight / realHeight * realWidth; //等比例缩放宽度 
                    if (imgWidth > windowW * scale) { //如宽度扔大于窗口宽度 
                        imgWidth = windowW * scale; //再对宽度进行缩放 
                    }
                } else if (realWidth > windowW * scale) { //如图片高度合适，判断图片宽度 
                    imgWidth = windowW * scale; //如大于窗口宽度，图片宽度进行缩放 
                    imgHeight = imgWidth / realWidth * realHeight; //等比例缩放高度 
                } else { //如果图片真实高度和宽度都符合要求，高宽不变 
                    imgWidth = realWidth;
                    imgHeight = realHeight;
                }
                $(bigimg).css("width", imgWidth); //以最终的宽度对图片缩放 
                var w = (windowW - imgWidth) / 2; //计算图片与窗口左边距 
                var h = (windowH - imgHeight) / 2; //计算图片与窗口上边距 
                $(innerdiv).css({
                    "top": h,
                    "left": w
                }); //设置#innerdiv的top和left属性 
                $(outerdiv).fadeIn("fast"); //淡入显示#outerdiv及.pimg 
            });
            $(outerdiv).click(function() { //再次点击淡出消失弹出层 
                $(this).fadeOut("fast");
            });
        }
        // 分享
        // $('#share-1').share();
    //  window._bd_share_config = {
    //     "common": {
    //         "bdSnsKey": {},
    //         "bdText": "",
    //         "bdMini": "2",
    //         "bdMiniList": false,
    //         "bdPic": "",
    //         "bdStyle": "0",
    //         "bdSize": "16"
    //     },
    //     "share": {},
    //     "image": {
    //         "viewList": ["qzone", "tsina", "tqq", "renren", "weixin"],
    //         "viewText": "分享到：",
    //         "viewSize": "16"
    //     },
    //     "selectShare": {
    //         "bdContainerClass": null,
    //         "bdSelectMiniList": ["qzone", "tsina", "tqq", "renren", "weixin"]
    //     }
    // };
    // with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src =
    //     'http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion=' + ~(-new Date() / 36e5)];
</script>