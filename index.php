<?php

/*
首页
*/
//加载头部
get_header();
?>

    <!-- 轮播图 -->
    <section>
        <?php $wztlaw_lunbo = get_option('wztlaw_lunbo');if(isset($wztlaw_lunbo['lunbo_open']) && $wztlaw_lunbo['lunbo_open']==1){if(isset($wztlaw_lunbo['pic'])){?>
        <!-- Swiper -->
        <div class="swiper-container sm">
            
             <?php if(count($wztlaw_lunbo['pic'])==1){ 
                ?>
                 <img src="<?php echo $wztlaw_lunbo['pic'][1]['mobile_test'];?>" <?php if(isset($wztlaw_lunbo['pic'][1]['mobile_alt'])){echo "alt='".$wztlaw_lunbo['pic'][1]['mobile_alt']."'";}?>/>
                 
                          
            <?php }elseif(count($wztlaw_lunbo['pic'])>1){?>
            <div class="swiper-wrapper">
                 <?php if(isset($wztlaw_lunbo['pic']) && $wztlaw_lunbo['pic']){ 
                        foreach($wztlaw_lunbo['pic'] as $key=>$val){
                    ?>
                <div class="swiper-slide"> 
                    <?php if(isset($val['url']) && $val['url']){?>
                    <a class="sm" href="<?php echo $val['url'];?>" <?php if($val['target']==1){echo "target='_blank'";}?> <?php if($val['nofollow']==1){echo "rel='nofollow'";}?>><img src="<?php echo $val['mobile_test'];?>" <?php if(isset($val['mobile_alt'])){echo "alt='".$val['mobile_alt']."'";}?> /></a>
                    <?php }else{?>
                   <img src="<?php echo $val['mobile_test'];?>" <?php if(isset($val['mobile_alt'])){echo "alt='".$val['mobile_alt']."'";}?> />
                    <?php }?>
                </div>
                <?php }}?>
              

            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
            <!-- Add Arrows -->
            <!-- <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div> -->
         <?php }?>
        </div>
        
        <div class="wzt_Carouse  pc">
            
             <?php if(count($wztlaw_lunbo['pic'])==1){ 
                ?>
                <div class="carousel">
                    <div class="carousel-inner ">
                        <div class="item active">
                            <img src="<?php echo $wztlaw_lunbo['pic'][1]['test'];?>" <?php if(isset($wztlaw_lunbo['pic'][1]['pc_alt'])){echo "alt='".$wztlaw_lunbo['pic'][1]['pc_alt']."'";}?>/>
                        </div>
                    </div>
                </div>
            <?php }elseif(count($wztlaw_lunbo['pic'])>1){?>              
            <div id="myCarouse" class="carousel" data-ride="carousel">
                <div class="carousel-inner ">
                    <?php if(isset($wztlaw_lunbo['pic']) && $wztlaw_lunbo['pic']){ 
                        foreach($wztlaw_lunbo['pic'] as $key=>$val){
                    ?>
            

                    <div class="item <?php if($key==1){echo 'active';}?>">
                        <?php if(isset($val['url']) && $val['url']){?>
                        <a class="pc" href="<?php echo $val['url'];?>" <?php if($val['target']==1){echo "target='_blank'";}?> <?php if($val['nofollow']==1){echo "rel='nofollow'";}?>><img src="<?php echo $val['test'];?>" <?php if(isset($val['pc_alt'])){echo "alt='".$val['pc_alt']."'";}?>/></a>
                         
                        <?php }else{?>
                        <img src="<?php echo $val['test'];?>" <?php if(isset($val['pc_alt'])){echo "alt='".$val['pc_alt']."'";}?>/>
                        <?php } ?>
                    </div>
                    <?php }}?>
                </div>
                
                <ol class="carousel-indicators">
                    <?php foreach($wztlaw_lunbo['pic'] as $key=>$val){
                        if(count($wztlaw_lunbo['pic'])>1){
                            if($key==1){?>
                            <li data-target="#myCarouse" data-slide-to="<?php echo $key-1;?>" class="active"></li>
                             <?php }else{?>
                            <li data-target="#myCarouse" data-slide-to="<?php echo $key-1;?>"></li>
                            <?php  }
                        }
                     }?>
                </ol>
                <div class="wzt_exchange wzt_toright ">

                    <a href="#myCarouse" class="left carousel-control" data-slide="prev">

                        <span>
                        <img src="<?php echo get_template_directory_uri().'/assets/images/'?>toleft.png" alt="">
                    </span>
                    </a>
                    <a href="#myCarouse" class="right carousel-control" data-slide="next">
                        <span>
                        <img src="<?php echo get_template_directory_uri().'/assets/images/'?>toleft.png" alt="">
                    </span>
                    </a>
                </div>
            </div>
            
            <?php }?>
        </div>
        <?php }}?>
        <!-- about us -->
        <?php $wztlaw_about = get_option('wztlaw_about');if(isset($wztlaw_about['auto']) && $wztlaw_about['auto']){?>
        <div class="wzt_about <?php if(!isset($wztlaw_about['mobile_auto']) || !$wztlaw_about['mobile_auto']){echo 'pc';}?>">
            <div class="about ">
                <div class="top">
                    <h2><?php echo $wztlaw_about['title']; ?></h2>
                    <p><?php echo $wztlaw_about['title_en']; ?></p>
                </div>
                <!-- wzt_aboutRight：图片在右  wzt_aboutLeft:图片在左 -->
                <div class="wztlaw_container content  <?php if($wztlaw_about['flex']==1){echo 'wzt_aboutLeft';}else{echo 'wzt_aboutRight';}?>">
                    <!--没有图片 class加nohave  有图片则不加-->
                     <div class=" wow bounceInLeft  about_right about_bimg flex_item col-lg-6 col-sm-12 sm <?php if(isset($wztlaw_about['pic']) && $wztlaw_about['pic']){}else{echo 'nohave';}?>">
                        <img src="<?php echo $wztlaw_about['pic'];?>" alt="<?php if(isset($wztlaw_about['alt'])){echo $wztlaw_about['alt'];}?>">
                    </div>
                    <!--没有图片 class为col-lg-12  有图片class为col-lg-6  -->
                    <div class="wow bounceInRight about_left flex_item  <?php if(isset($wztlaw_about['pic']) && $wztlaw_about['pic']){echo 'col-lg-6';}else{echo 'col-lg-12';}?> col-sm-12">
                        <p <?php if(isset($wztlaw_about['indent']) && $wztlaw_about['indent']==1){echo 'style="text-indent:2em"';}?>>
                            <?php if(isset($wztlaw_about['indent']) && $wztlaw_about['indent']==1){?>
                           <?php echo str_replace("\r","<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;",str_replace("\n",'<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;',$wztlaw_about['description']));?>
                           <?php }else{?>
                            <?php echo str_replace("\r","<br />",str_replace("\n",'<br />',$wztlaw_about['description']));?>
                           <?php }?>
                           
                        </p>
                        <div class="about_leftBtn">
                              <div class="wzt_more">
               <a href="<?php echo $wztlaw_about['url'];?>">了解更多</a>
            </div>
                        
                            </div>
                    </div>
                    <!--没有图片 class加nohave  有图片则不加-->
                    <div class=" about_right wow bounceInRight about_bimg flex_item col-lg-6 col-sm-12 pc <?php if(isset($wztlaw_about['pic']) && $wztlaw_about['pic']){}else{echo 'nohave';}?>">
                       
                        <img src="<?php echo $wztlaw_about['pic'];?>" alt="<?php if(isset($wztlaw_about['alt'])){echo $wztlaw_about['alt'];}?>">
                    </div>
                </div>
            </div>
        </div>
        <?php }?>

        <!-- 业务模块 -->
         <?php $wztlaw_business = get_option('wztlaw_business');if(isset($wztlaw_business['auto']) && $wztlaw_business['auto']){?>
        <div class="wzt_ywly  <?php if(!isset($wztlaw_business['mobile_auto']) || !$wztlaw_business['mobile_auto']){echo 'pc';}?>">
            <!-- 业务领域 -->
            <div class="ywly">
                <div class="wztlaw_container cont ">
                    <div class="top">
                        <h2><?php echo $wztlaw_business['title'];?></h2>
                        <p><?php echo $wztlaw_business['title_en'];?></p>
                    </div>
                    <div class="cont wow bounceInUp">
                        <?php if(isset($wztlaw_business['pic'])&& $wztlaw_business['pic']){
                            foreach($wztlaw_business['pic'] as $key=>$val){
                        ?>
                        <div class="col-lg-3  col-sm-6 col-md-6 col-xs-6">
                            <!--没有图片 class加nohavecon  有图片则不加-->
                            <div class="item <?php if(isset($val['test']) && $val['test']){}else{echo 'nohavecon';}?>">
                                <!--没有图片 class加nohave  有图片则不加-->
                                <div class="img <?php if(isset($val['test']) && $val['test']){}else{echo 'nohave';}?>">
                                    <?php if(isset($val['url']) && $val['url']){?>
                                    <a href="<?php if(isset($val['url'])){echo $val['url'];}?>" <?php if(isset($val['target'])&& $val['target']==1){echo 'target="_blank"';}?> <?php if(isset($val['nofollow'])&& $val['nofollow']==1){echo 'rel="nofollow"';}?>><img src="<?php echo $val['test'];?>" alt="<?php if(isset($val['alt'])){echo $val['alt'];}?>"></a>
                                    <?php }else{?>
                                    <img src="<?php echo $val['test'];?>" alt="<?php if(isset($val['alt'])){echo $val['alt'];}?>">
                                    <?php }?>
                                </div>
                                
                                <h2 ><?php echo $val['buss'];?></h2>
                            </div>
                        </div>
                        <?php }}?>
                        
                    </div>
                </div>
            </div>
            <div class="wzt_more">
                <?php 
                if(isset($wztlaw_business['url']) && $wztlaw_business['url']){
                    echo '<a href="'.$wztlaw_business['url'].'">查看更多</a>';
                }
                ?>
            </div>
        </div>
        <?php }?>
        <!-- 律师团队 -->
        <?php $wztlaw_pic_art = get_option('wztlaw_pic_art');if(isset($wztlaw_pic_art['auto']) && $wztlaw_pic_art['auto']){?>
        <div class="wzt_lstd wow bounceInLeft <?php if(!isset($wztlaw_pic_art['mobile_auto']) || !$wztlaw_pic_art['mobile_auto']){echo 'pc';}?>">
           <div class="lstd">
                <div class="wztlaw_container">
                     
                 <div class="icon_LImg icon_LImgS  pc">
                     <img src="<?php echo get_template_directory_uri().'/assets/images/'?>toleft.png" alt="">
                 </div>
                    <div class="top">
                        <h2><?php echo $wztlaw_pic_art['title'];?></h2>
                        <p><?php echo $wztlaw_pic_art['title_en'];?></p>
                    </div>
                    <div class="wzt_lstdCarouse pc">
                        <?php global $wpdb; $post_3 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."posts  as a left join ".$wpdb->prefix ."postmeta as b on a.ID=b.post_id  where b.meta_key='wztlaw' and meta_value like '%s:4:\"type\";s:1:\"3\"%' and a.post_status='publish' and a.post_type='post' group by b.post_id",ARRAY_A);?>
                       <div id="myCarouse1" class="carousel" style="width:<?php echo ceil(count($post_3)/3)*1149?>px">
                           
                            
                            <?php foreach($post_3 as $key=>$val){ ?>
                            
                            <div class="col-lg-4 active">
                                <div class="post-item-inner">
                                    <a class="ho_img" href="<?php echo get_permalink($val['ID']);?>" title="" rel="  ">
                                     <?php preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $val['post_content'], $matches);$pos = get_post_meta($val['ID'],'wztlaw',true);?>
                                   
                                        <img src="<?php 
                                         if(isset($pos['pic']) && $pos['pic']){
                                            echo $pos['pic'];
                                        }elseif(isset($matches[1][0]) && $matches[1][0]){
                                            echo $matches[1][0];
                                        }else{
                                            echo get_template_directory_uri().'/assets/images/nohai.jpg';
                                        }?>" class="attachment-default size-default wp-post-image j-lazy" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo $val['post_title'];} ?>" />
                                    </a>
                                    
                                    <h2 class="item-title">
                                        <a href="<?php echo get_permalink($val['ID']);?>" rel="  "><?php echo $val['post_title']; ?></a>
                                    </h2>
                                    <p class="CarouseTime">
                                        <?php echo substr($val['post_modified_gmt'],0,10)?>
                                    </p>
                                    <div class="item-excerpt">
                                        <p>
                                            <?php echo strip_tags($val['post_content']); ?>
                                        </p>
                                    </div>
                                </div>

                            </div>
                            <?php }?>
                           
   
                        </div>
                    </div>
                      <div class="wzt_lstdCarouse1 sm">
                          <?php global $wpdb; $post_3 = $wpdb->get_results("SELECT * FROM ".$wpdb->prefix ."posts  as a left join ".$wpdb->prefix ."postmeta as b on a.ID=b.post_id where b.meta_key='wztlaw' and meta_value like '%s:4:\"type\";s:1:\"3\"%' and a.post_status='publish' and a.post_type='post' ",ARRAY_A);?>
                            <?php foreach($post_3 as $key=>$val){ ?>
                        <div class="col-lg-4 col-md-4 col-md-6 col-xs-6">
                            <div class="post-item-inner">
                                <a class="ho_img" href="<?php echo get_permalink($val['ID']);?>" title="" rel="  ">
                                    <?php preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $val['post_content'], $matches);$pos = get_post_meta($val['ID'],'wztlaw',true);?>
                                   
                                        <img src="<?php 
                                        if(isset($pos['pic']) && $pos['pic']){
                                            echo $pos['pic'];
                                        }elseif(isset($matches[1][0]) && $matches[1][0]){
                                            echo $matches[1][0];
                                        }else{
                                        
                                            echo get_template_directory_uri().'/assets/images/nohai.jpg';
                                        
                                        }?>" class="attachment-default size-default wp-post-image j-lazy" alt="<?php echo $val['post_title']; ?>" />
                                </a>
                                <h2 class="item-title">
                                    <a href="<?php echo get_permalink($val['ID']);?>" rel="  "> <?php echo $val['post_title']; ?></a>
                                </h2>
                               

                            </div>
                        </div>
                          <?php }?>
                           
                        
                    </div>
                    <div class="wzt_more">
                        <?php 
                        if(isset($wztlaw_pic_art['term_id']) && $wztlaw_pic_art['term_id']){ ?>
                        <a href="<?php echo get_category_link($wztlaw_pic_art['term_id']); ?>">查看更多</a>
                        <?php }?>
                    </div>
                     <div class="icon_RImg icon_RImgS pc">
                <img src="<?php echo get_template_directory_uri().'/assets/images/'?>toleft.png" alt="">
            </div>
            </div>
            
        </div>
        </div>
        <?php }?>
        <?php $wztlaw_word = get_option('wztlaw_word');?>
        <?php if(isset($wztlaw_word['auto']) && $wztlaw_word['auto']==1){?>
        <div class="wztlaw_container wow bounceInRight <?php if(!isset($wztlaw_word['mobile_auto']) ||(isset($wztlaw_word['mobile_auto']) && !$wztlaw_word['mobile_auto'])){echo 'pc';}?>">
            <div class="wztlaw_advantage">
                <div class="wztlaw_advantage_bd">
                    <ul>
                        <?php if(isset($wztlaw_word['pic'])&& $wztlaw_word['pic']){foreach($wztlaw_word['pic'] as $key=>$val){?>
                        <li>
                            <p class="wztlaw_advantage_bd_1">
                                <i><?php echo $val['title'];?></i>
                                <span><?php echo $val['title_en'];?></span>
                            </p>
                            <div class="wztlaw_advantage_bd_2">
                                <span><?php echo $val['desc'];?></span>
                            </div>
                        </li>
                        <?php }}?>
                       
                    </ul>
                </div>
            </div>
        </div>
        <?php }?>
        <?php $wztlaw_photo = get_option('wztlaw_photo');?>
         <?php if(isset($wztlaw_photo['lunbo_open']) && $wztlaw_photo['lunbo_open']==1){?>
        <div class="zizhi <?php if(!isset($wztlaw_photo['mobile_auto']) ||(isset($wztlaw_photo['mobile_auto']) && !$wztlaw_photo['mobile_auto'])){echo 'pc';}?>">
            <div>
                <!--轮播-->
                <div class="lb_gl">
                    <div class="lb_gl_box">
                        <h2 class="turn_3d"><?php if(isset($wztlaw_photo['title'])){echo $wztlaw_photo['title'];}?></h2>
                        <div class="pictureSlider poster-main">
                            <div class="poster-btn poster-prev-btn"></div>
                            <ul id="zturn" class="poster-list">
                                <?php if(isset($wztlaw_photo['pic'])&& $wztlaw_photo['pic']){foreach($wztlaw_photo['pic'] as $key=>$val){?>
                                <li class="poster-item  zturn-item">
                                    <img src="<?php echo $val['test'];?>" alt="<?php echo $val['pc_alt']; ?>">
                                </li>
                                <?php }}?>
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var aa=new zturn({
            		id:"zturn",
            		opacity:0.9,
            		width:382,
            		Awidth:1024,
            		scale:0.9,
            		auto:true,//是否轮播 默认5000
            		turning:1000//轮播时长
            	})
            </script>
        </div>
        <?php }?>
        <?php $wztlaw_zhao = get_option('wztlaw_zhao');?>
         <?php if(isset($wztlaw_zhao['lunbo_open']) && $wztlaw_zhao['lunbo_open']==1){?>
        <div class="wztlaw_container wow bounceInLeft  <?php if(!isset($wztlaw_zhao['mobile_auto']) ||(isset($wztlaw_zhao['mobile_auto']) && !$wztlaw_zhao['mobile_auto'])){echo 'pc';}?>">
            <div class="wztlaw_recruit">
                <div class="wztlaw_recruit_hd">
                    <h3><?php if(isset($wztlaw_zhao['title'])){echo $wztlaw_zhao['title'];}?></h3>
                    <h4><?php if(isset($wztlaw_zhao['title_en'])){echo $wztlaw_zhao['title_en'];}?></h4>
                </div>
                <div class="wztlaw_recruit_bd clearfix">
                     <?php if(isset($wztlaw_zhao['pic'])&& $wztlaw_zhao['pic']){foreach($wztlaw_zhao['pic'] as $key=>$val){?>
                    <div>
                        <h3><?php echo $val['position'];?></h3>
                        <p><?php echo $val['desc'];?></p>
                    </div>
                    <?php }}?>
                </div>
            </div>
        </div>
        <?php }?>
        <!--公司人员介绍-->
        <?php $wztlaw_number = get_option('wztlaw_number');?>
         <?php if(isset($wztlaw_number['lunbo_open']) && $wztlaw_number['lunbo_open']==1){?>
        <div class="wzylaw_Company wow bounceInRight <?php if(!isset($wztlaw_number['mobile_auto']) ||(isset($wztlaw_number['mobile_auto']) && !$wztlaw_number['mobile_auto'])){echo 'pc';}?>">
            <?php if(isset($wztlaw_number['pic'])&& $wztlaw_number['pic']){foreach($wztlaw_number['pic'] as $key=>$val){?>
            <div>
                <p><?php echo $val['name'];?></p>
                <div class="timer count-title" id="count-number" data-to="<?php echo $val['number'];?>" data-speed="2000"><?php echo $val['number'];?></div>
            </div>
            <?php }}?>
        </div>
        <?php }?>
        <!-- 工作环境 -->
        <?php $wztlaw_pic = get_option('wztlaw_pic');if(isset($wztlaw_pic['auto']) && $wztlaw_pic['auto']){?>
        
        
         <div class="wzt_gzhj pc">
            <div class="wztlaw_container">
                <div class="top">
                    <h2><?php echo $wztlaw_pic['title'];?></h2>
                    <p><?php echo $wztlaw_pic['title_en'];?></p>
                </div>
         <div class="ProductIntroduction">
        <div class="ProductExhibition">
            <div class="icon_LImg">
                <img src="<?php echo get_template_directory_uri().'/assets/images/'?>toleft.png" alt="">
            </div>
            <div class="Exhibition_num ">
                 <?php if(isset($wztlaw_pic['pic'])&& $wztlaw_pic['pic']){foreach($wztlaw_pic['pic'] as $key=>$val){?>
                <div class="Exhibition_item  <?php if($key==1){echo 'czt_active';}?>"><img src="<?php echo $val['test'];?>" alt="<?php if(isset($val['alt'])){echo $val['alt'];}?>"></div>
                 <?php }}?>
                <div class="Exhibition_items"></div>
            </div>

            <div class="icon_RImg">
                <img src="<?php echo get_template_directory_uri().'/assets/images/'?>toleft.png" alt="">
            </div>
        </div>

        <div class="ProductExhibition_wrap">
            <div class="ProductExhibition_box gallery">
               <?php if(isset($wztlaw_pic['pic'])&& $wztlaw_pic['pic']){
                                            foreach($wztlaw_pic['pic'] as $key=>$val){
                            ?>
                            <div class="Exhibition_Img"><img src="<?php echo $val['test'];?>" alt="<?php if(isset($val['alt'])){echo $val['alt'];}?>"></div>
                            
                            <?php }}?>
            </div>
        </div>

    </div>
    </div>
        </div>
         <?php if(isset($wztlaw_pic['mobile_auto']) && $wztlaw_pic['mobile_auto']){?>
        <div class="wzt_gzhj sm">
            <div class="ifocus ifocuss wztlaw_container">
                <div class="top">
                    <h2><?php echo $wztlaw_pic['title'];?></h2>
                    <p><?php echo $wztlaw_pic['title_en'];?></p>
                </div>
                <ul class="xiangc gallery">
                     <?php if(isset($wztlaw_pic['pic'])&& $wztlaw_pic['pic']){
                        foreach($wztlaw_pic['pic'] as $key=>$val){
                            if($key==0){  
                    ?>
                    <li class="current"><img src="<?php echo $val['test'];?>" alt="<?php if(isset($val['alt'])){echo $val['alt'];}?>" class="imgs" /></li>
                    <?php }else{?>
                     <li class="normal"><img src="<?php echo $val['test'];?>" alt="<?php if(isset($val['alt'])){echo $val['alt'];}?>"  class="imgs"/></li>
                    <?php }}}?>
                    
                </ul>
            </div>
             <div id="outerdiv" style="position:fixed;top:0;left:0;background:rgba(0,0,0,0.7);z-index:2;width:100%;height:100%;display:none;">
        <div id="innerdiv" style="position:absolute;">
            <img id="bigimg" style="border:5px solid #fff;" src="" />
        </div>
    </div>
        </div>
        <?php }?>
        <?php }?>
        <!-- 文章列表 -->

        <?php $wztlaw_news = get_option('wztlaw_news');if(isset($wztlaw_news['auto']) && $wztlaw_news['auto'] ){?>
        
        <!-- 文章列表 -->
        <div class="wzt_wzlb <?php if(!isset($wztlaw_news['mobile_auto']) || !$wztlaw_news['mobile_auto']){echo 'pc';}?>">
            <div class="wzlb">
                <div class="wztlaw_container">
                    <div class="wzt_article">
                        <div class="col-lg-6 col-sm-6 col-xs-6">
                            <h2><?php echo $wztlaw_news['title']; ?></h2>
                        </div>
                        <?php if(isset($wztlaw_news['term_id']) && $wztlaw_news['term_id']){?>
                        <div class="col-lg-6 col-sm-6 col-xs-6">
                            <h3><a href="<?php echo get_category_link($wztlaw_news['term_id']); ?>">更多>></a></h3>
                        </div>
                        <?php }?>
                    </div>
                    <div class="wzt_consultingService">
                           <?php if(isset($wztlaw_news['term_id']) && $wztlaw_news['term_id']){?>
                        <?php $posts = get_posts( "category=".$wztlaw_news['term_id']."&numberposts=6" ); ?>
                        <div class="col-lg-6 wzt_ServixeLeft wow bounceInLeft">
                                                         <?php if(isset($posts[0]->ID)){  $pos = get_post_meta($posts[0]->ID,'wztlaw',true);?>
                            <h3>
                                <a href="<?php echo get_permalink($posts[0]->ID);?>">
                                    <div class="Serviceimgs">
                                      <?php preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $posts[0]->post_content, $matches);?>
                                    <?php if(isset($pos['pic']) && $pos['pic']){?>
                                    <img src="<?php echo $pos['pic'];?>" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo $posts[0]->post_title;} ?>">
                                    <?php }elseif(isset($matches[1][0])){?>
                                    <img src="<?php echo $matches[1][0];?>" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo $posts[0]->post_title;} ?>">
                                    <?php }else{?>
                                     <img src="<?php echo get_template_directory_uri().'/assets/images/nohai.jpg';?>" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo $posts[0]->post_title;} ?>">
                                    <?php }?>
                                        <span class="Servicetime">
                                            
                                         <?php echo substr($posts[0]->post_modified_gmt,8,2)?>
                                        <em><?php echo substr($posts[0]->post_modified_gmt,0,7)?></em>
                                      </span>
                                    </div>



                                    <h4>
                                       <?php echo $posts[0]->post_title;?>
                                    </h4>
                                   <p><?php echo mb_strimwidth(strip_tags($posts[0]->post_content),0,510,'...');?></p>
                            <?php }?>
                                    <div class="xian"></div>
                                </a>
                            </h3>
                        </div>
                        <div class="col-lg-6 wzt_ServixeRight wow bounceInRight">
                            <ul>
                                 <?php foreach($posts as $key=>$val){if($key>0){$pos = get_post_meta($val->ID,'wztlaw',true);?>
                                <li>
                                    <div class="time">
                                        <p class="time_day"><?php echo substr($val->post_modified_gmt,8,2)?></p>
                                        <p class="time_date"><?php echo substr($val->post_modified_gmt,0,7)?></p>
                                    </div>
                                    <div class="content">
                                        <h2><a href="<?php echo get_permalink($val->ID);?>" title="<?php echo $val->post_title;?>？"><?php echo $val->post_title;?></a></h2>
                                        <div class="desc"><?php echo mb_strimwidth(strip_tags($val->post_content),0,110,'...'); ?></div>
                                    </div>
                                </li>
                               <?php }}?>
                            </ul>
                        </div>
                         <?php }?>
                    </div>
                </div>
            </div>
        </div>
        <?php }?>
        <?php $wztlaw_message = get_option('wztlaw_message');if(isset($wztlaw_message['open']) && $wztlaw_message['open']==1){?>
        <!--在线留言-->
        <div class="wzt_message wztlaw_container">
            <h3>在线留言</h3>
            <form action="" onsubmit="return false">
                <div style="overflow: hidden;">
                    <div class="wzt_message_b1">
                        <span></span>
                        <input type="text" placeholder="姓名" name="name">
                    </div>
                    <div class="wzt_message_b1">
                        <span></span>
                        <div>*</div>
                        <div class="wzt_message_b1_tx"></div>
                        <input type="text" id="tel" placeholder="电话"  name="mobile">
                    </div>
                    <div class="wzt_message_b1">
                        <span></span>
                        <input type="text" placeholder="邮箱" name="email">
                    </div>
                    <div class="wzt_message_b1">
                        <span></span>
                        <input type="text" placeholder="地址" name="address">
                    </div>
                </div>
                <div class="wzt_message_b2">
                    <span></span>
                    <textarea placeholder="内容" name="content"></textarea>
                </div>
                <div class="wzt_message_bt">
                    <input type="submit" value="提交留言">
                </div>
            </form>
        </div>
        <script>
            //验证手机号
            var regTel=/(1[3-9]\d{9}$)/;
             
            function yt_tel(){
                var tel=$('#tel').val();
                if (!regTel.test(tel)) {
                    // $('.tel span').show();
                    // alert("电话格式不正确！")
                    $(".wzt_message_b1_tx").css("display","block")
                    $(".wzt_message_b1_tx").html("请输入正确的手机号！！！")
                    return false;
                }else{
                    //  alert("电话格式正确！")
                    $(".wzt_message_b1_tx").css("display","none")
                    return true;
                }
            }
            $(".wzt_message_bt input").click(function() {
                var dianh = yt_tel()
                if(!dianh) {
                    // alert("请输入正确的手机号")
                    $(".wzt_message_b1_tx").css("display","block")
                    return false
                }else {
                    // var name = $('input[name="name"]]').val();
                    var mobile = $('input[name="mobile"]').val();
                    var email = $('input[name="email"]').val();
                    var address = $('input[name="address"]').val();
                    var content = $('input[name="content"]').val();
                    $.ajax({
                        url:'',
                        data:{"nonce":"<?php echo wp_create_nonce('wztlaw');?>","action":"wztlaw","name":name,"mobile":mobile,"email":email,"address":address,"content":content,"wztlaw_message":1,"wztlaw":1},
                        type:'post',
                        dataType:'json',
                        success:function(data){
                            if(data.code){
                                alert(data.msg);
                                location.reload();
                            }else{
                                alert(data.msg);
                            }
                        }
                    })
                    return false
                }
            })
        </script>
        <?php }?>
        <!-- 友情链接 -->
        <div class="wzt_yqlj ">
            <div class="wztlaw_container">
                <div class="col-lg-12">
                    <div class="auto">
                        <div class="menu tabmenu">
                            <a class="lk">友情链接</a>
                            <a class="lk cur">热门标签</a>
                        </div>
                        <div class="tabwrap">
                            <div class="module" style="display: none;">
                                <div class="list">
                                    <?php $wztlaw_link = get_option('wztlaw_link');?>
                                    <?php if(isset($wztlaw_link['pic'])&& $wztlaw_link['pic']){
                                        foreach($wztlaw_link['pic'] as $key=>$val){
                                    ?>
                                    <a  href="<?php echo $val['url']; ?>" target="_blank"><?php echo $val['name']; ?></a> <?php if($key!=count($wztlaw_link['pic'])){echo '|';}?>
                                    
                                    <?php }}?>
                                </div>
                            </div>
                            <div class="module" style="display:block;">
                                <div class="list">
                                    <?php $tags_list = get_tags( array('number' => '18772', 'orderby' => '', 'order' => 'DESC', 'hide_empty' => false) );  ?>
                                    <?php foreach($tags_list as $key=>$val){?>
                                        <a title="<?php echo $val->name;?>" href="<?php echo get_tag_link($val->term_id)?>"><?php echo $val->name;?></a> |
                                    <?php } ?>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>  
    </section>  
    <script>
    $(function() {
        <?php if(isset($wztlaw_lunbo['lunbo_open']) && $wztlaw_lunbo['lunbo_open']==1){
            if(isset($wztlaw_lunbo['pic']) && count($wztlaw_lunbo['pic'])>1){?>
        try{
            // 特效、
             new WOW().init();
             var swiper = new Swiper('.swiper-container', {
                slidesPerView: 1,
                spaceBetween: 30,
                loop: true,
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                speed: 1000,
                autoplay: {
                    delay: 2000
                },
            });
        	
        }catch(e){
        	
        }
        <?php }}?>
        // 图册
        var ns = "wztlaw_rebox";
            var indexs = 0;
            // let length = $(classNz).length;
            var classNz=".ProductIntroduction .ProductExhibition_box img ";
            var classNzs=".wzt_gzhj .xiangc img"
            tuce(classNz,false)
            tuce(classNzs,true)
            function tuce(classNz,sm){
                let length=$(classNz).length;
                console.log(length)
                  $(classNz).click(function(e) {
                    console.log("length")   
                let imgsrc = $(this).attr("src")
                indexs = $(classNz).index(this)
                $(".gallery").after('<div class="' + ns + '" style="z-index: 500;">' +
                    '<a href="javascript:void(0)" class="' + ns + '-close ' + ns + '-button">' + '</a>' +
                    '<a href="javascript:void(0)" class="' + ns + '-prev ' + ns + '-button">' + '</a>' +
                    '<a href="javascript:void(0)" class="' + ns + '-next ' + ns + '-button">' + '</a>' +
                    '<div class="' + ns + '-contents"><img src=' + imgsrc + ' class="' + ns + '-content" /></div>' +
                    '<div class="' + ns + '-caption"><p></p></div>' +
                    '</div>')
                     if(sm){
                        var imheight = $(".wzt_gzhj  .ifocuss .wztlaw_rebox-contents img").height() / 2;
                        $(".wzt_gzhj .ifocuss .wztlaw_rebox-contents img").css("margin-top", -imheight + "px");
                    
                    }
                indexs == length - 1 ? $(".wztlaw_rebox .wztlaw_rebox-next").css("display", "none") : $(".wztlaw_rebox .wztlaw_rebox-prev").css("display", "block")
                indexs == 0 ? $(".wztlaw_rebox .wztlaw_rebox-prev").css("display", "none") : $(".wztlaw_rebox .wztlaw_rebox-next").css("display", "block")
                if (length == 1 || length == 2) {
                    $(".wztlaw_rebox .wztlaw_rebox-prev").css("display", "none");
                    $(".wztlaw_rebox .wztlaw_rebox-next").css("display", "none")
                }
                if (length == 2) {
                    indexs == 0 ? $(".wztlaw_rebox .wztlaw_rebox-next").css("display", "block") : $(".wztlaw_rebox .wztlaw_rebox-prev").css("display", "block")
                }
                $(".wztlaw_rebox").on("click", ".wztlaw_rebox-close", function(e) {
                        $(".wztlaw_rebox").css("display", "none")
                    }).on("click", ".wztlaw_rebox-prev", function(e) {
                        if (indexs > 0) {
                            indexs--;
                            goto(indexs)
                        }
                        indexs == 0 ? $(".wztlaw_rebox .wztlaw_rebox-prev").css("display", "none") : $(".wztlaw_rebox .wztlaw_rebox-next").css("display", "block")
                        if (length == 2) {
                            indexs == 0 ? $(".wztlaw_rebox .wztlaw_rebox-next").css("display", "block") : $(".wztlaw_rebox .wztlaw_rebox-prev").css("display", "block")
                        }
                          e.stopPropagation();
                    })
                    .on("click", ".wztlaw_rebox-next", function(e) {
                 
                        if (indexs < length - 1) {
                            indexs++;
                            goto(indexs)
                        }
                        indexs == length - 1 ? $(".wztlaw_rebox .wztlaw_rebox-next").css("display", "none") : $(".wztlaw_rebox .wztlaw_rebox-prev").css("display", "block")
                        if (length == 2) {
                            indexs == 0 ? $(".wztlaw_rebox .wztlaw_rebox-next").css("display", "block") : $(".wztlaw_rebox .wztlaw_rebox-prev").css("display", "block")
                        }
                          e.stopPropagation();
                    })
                       $(".wzt_gzhj .ifocus .wztlaw_rebox").click(function(){
                            $(".wzt_gzhj .ifocus .wztlaw_rebox").css("display","none")
                        })
                        
                e.preventDefault()

            })
            }
          

            function goto(i) {
                var secs = $(classNz).eq(i).attr("src");
                $(".wztlaw_rebox-contents img").attr("src", secs)
            }
            
        // 工作环境
         var latenum = 0;
    // 判断照片个数
    var imgsnum = $(".ProductExhibition .Exhibition_num img").length;

    if (imgsnum > 5) {
        $(".ProductExhibition .icon_LImg").css("top", "0px")
        $(".ProductExhibition .icon_RImg").css("top", "590px")
    }

    function move() {
        latenum += 1;
        if (latenum > imgsnum - 5 && imgsnum > 5) {
            let ylatenum = -(imgsnum - 5) * 125 + "px";
            changeCss(ylatenum);
        }
        if (latenum == imgsnum) {
            changeCss(0);
            latenum = 0
        }
        change(latenum)
    }
    var titm = setInterval(move, 3000);

    function stopTimer() {
        clearInterval(titm);
    }

    $(".ProductExhibition").hover(function() {
        stopTimer()
    }, function() {

        titm = setInterval(move, 3000);
    });



    // 点击 切换上下
    // 下
    $(".ProductIntroduction .icon_RImg").click(function() {

        if (latenum < imgsnum - 1) {
            latenum += 1;

        } else {
            latenum = 0
        }
        change(latenum)
    })


    // 上
    $(".ProductIntroduction .icon_LImg").click(function() {
        if (latenum > 0) {
            latenum -= 1;
        } else {
            latenum = imgsnum - 1;
            let ynum = -(imgsnum - 5);
       
            let ylatenum = ynum * 125 + "px";
            
            changeCss(ylatenum)
        }
        change(latenum)
    })


    // 位移
    function changeCss(ylatenum) {

        $(".Exhibition_num").css({
            "transform": "translate3d(0px, " + ylatenum + ",0px)",
            "transition-duration": "300ms"
        });
    }

    // 点击item
    $(".Exhibition_item").click(function() {
        let ixd = $(this).index()

        change(ixd)
    })

    function change(idx) {
        latenum = idx;
        $(".Exhibition_item").removeClass("czt_active")
        $(".Exhibition_item").eq(idx).addClass("czt_active")
        var cahngeX = -idx * 622 + "px";
        var trachangeX = idx * 125 + "px";
        $(".ProductExhibition_box").css("transform", "translate3d(0px," + cahngeX + ",0px)")
        $(".Exhibition_items").css("transform", "translateY(" + trachangeX + ")")
        if (latenum < imgsnum - 5 || latenum == imgsnum - 5) {
            let ylatenum = -latenum * 125 + "px";
            changeCss(ylatenum)
        }

    }


        // 点击放大图片
        //   $(".wzt_gzhj .imgs").click(function() {
        //     var _this = $(this); //将当前的pimg元素作为_this传入函数 
        //     imgShow("#outerdiv", "#innerdiv", "#bigimg", _this);
        // });
        $(".menu a").mouseover(function() {
            $(this).siblings().removeClass("cur")
            $(this).addClass("cur");
            let index = $(this).index();
            $(".tabwrap").children(".module").css("display", "none")
            $(".tabwrap").children(".module").eq(index).css("display", "block");

        })
    var idxt=0;//全局变量，记录当前轮播图的索引
   var lec=0
    var leng=$(".wzt_lstdCarouse .carousel>.active").length;

    var lengths=Math.ceil(leng/3)-1

    function moves(){
         idxt+=1;

         if(idxt>lengths){
             idxt=0;
         }
    
        lec=idxt*1149
    $(".wzt_lstdCarouse .carousel").css("left","-"+lec+"px");

    }
     $("#myCarouse1").hover(function(){
         clearInterval(titms);
     },function(){
         titms=setInterval(moves,5000);
     })
    // var bus= lengths?"block":"none";
    if(lengths){
      $(".wzt_lstd .lstd>.wztlaw_container>.icon_LImg").css("display","block") ;
      $(".wzt_lstd .lstd>.wztlaw_container>.icon_RImg").css("display","block") ;
    }
    else{
      $(".wzt_lstd .lstd>.wztlaw_container>.icon_LImg").css("display","none") ;
      $(".wzt_lstd .lstd>.wztlaw_container>.icon_RImg").css("display","none") ;
    }
    // 左右切换
    // 左
    $(".wzt_lstd .lstd .icon_LImgS").click(function(){
         if(idxt==0){
       
             idxt=lengths;
         }
         else{
            idxt--;
         }
            lec=idxt*1149
    $(".wzt_lstdCarouse .carousel").css("left","-"+lec+"px");
    })
     // 右
    $(".wzt_lstd .lstd .icon_RImgS").click(function(){
         if(idxt==lengths){
             idxt=0;
         }
         else{
            idxt+=1;
         }
            lec=idxt*1149
    $(".wzt_lstdCarouse .carousel").css("left","-"+lec+"px");
    })
    var titms=setInterval(moves,5000);

    })
 
    </script>
<?php
//加载尾部
get_footer();
?>
