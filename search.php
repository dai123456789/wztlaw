<?php
get_header();
$category_data = get_term_meta( $cat, 'wztlaw', true );
if(isset($category_data['pic'])&& $category_data['pic']){
?>
<div><img src="<?php echo $category_data['pic'];?>" style="width:100%" alt="<?php if(isset($category_data['alt'])){echo $category_data['alt'];}?>"></div>
<?php 
}
$current = get_category($cat);
if(isset($current->category_parent)){
$current_cat_ID = $current->category_parent;
}
$childcat = get_categories('child_of='.$cat);
if(isset($category_data['type']) && $category_data['type']==2){
?>

  <section>
        <div class="wzt_LawyerTeam ArticleListBox">
            <div class="wztlaw_container">
            <div class="teamdetailsLeft col-lg-3"><?php dynamic_sidebar(__( '主侧边栏', 'wztlaw' )); ?></div>
            
            <div class="wzt_LawyerTeamList col-lg-9">
                <div class="teamdetailsItem">
                <div class="Tab">
                    <?php if(!$current_cat_ID && $childcat){?>
                    <div class="link">
                        <!--<div class="container">-->
                            <ul>
                                <li class="active"><a href="<?php echo get_category_link( $cat ); ?>">
                            全部                                                                                          
                           </a></li>
                            <?php wp_list_categories("orderby=id&child_of=" . $cat . "&depth=1&hide_empty=0&hierarchical=1&optioncount=1&title_li=");?>

                            </ul>
                        <!--</div>-->
                    </div>
                    <?php } ?>
                    <!-- tab内容 -->
                    <div class="wzt_TeamList">
                        <div>
                            <span>当前位置：</span><?php echo get_category_parents( $cat, TRUE, "<span>&raquo;</span>" ); ?>
                        </div>
                        <div class="wzt_LawyerTeamListBox">
                            <!--<div class="container">-->
                                <ul>
                                     <?php if( have_posts()){
                         
                                    while ( have_posts() ){
                                        the_post();
                                    ?>
                               
                                    <li>
                                        <a href="<?php the_permalink(); ?>">
                                             <div class="wzt_TeamImg">
                                                <?php preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches); $pos = get_post_meta(get_the_ID(),'wztlaw',true);?>
                                                <?php if(isset($pos['pic']) && $pos['pic']){?>
                                                <img src="<?php echo $pos['pic'];?>" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo get_the_title();} ?>">
                                                <?php }elseif(isset($matches[1][0])){?>
                                                <img src="<?php echo $matches[1][0];?>" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo get_the_title();} ?>">
                                                <?php }else{?>
                                                    <img src="<?php echo get_template_directory_uri().'/assets/images/'?>nohai.jpg" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo get_the_title();} ?>">
                                                <?php }?>

                                                
                                            </div>
                                            <div class="wzt_TeamText">
                                                    <h2><?php the_title(); ?></h2>
                                                    <!--<p><?php echo mb_strimwidth(strip_tags(get_post(get_the_ID())->post_content),0,10,'...');?></p>-->
                                                </div>
                                           
                                        </a>
                                    </li>
                                    <?php }}?>
                                   
                                    
                                </ul>
                                 <?php  pagelist();
                                    wp_reset_query();?>
                            <!--</div>-->
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
        </div>
    </section>
<?php }elseif(isset($category_data['type']) && $category_data['type']==3){ ?>
    <section>
        <!--律师团队-->
        
        <div class="wzt_LawyerTeam">
            <div class="wzt_LawyerTeamList" >
                <div class="Tab">
                    <?php if(!$current_cat_ID && $childcat){?>
                    <div class="link">
                        <div class="wztlaw_container">
                            <ul>
                                <li class="active"><a href="<?php echo get_category_link( $cat ); ?>">
                            全部                                                                                          
                           </a></li>
                            <?php wp_list_categories("orderby=id&child_of=" . $cat . "&depth=1&hide_empty=0&hierarchical=1&optioncount=1&title_li=");?>

                            </ul>
                        </div>
                    </div>
                    <?php } ?>
                    <!-- tab内容 -->
                    <div class="wzt_TeamList">
                        <div class="wzt_LawyerTeamListBox" style="padding:15px">
                            <div class="wztlaw_container">
                                <ul>
                                <?php if( have_posts()){
                         
                                    while ( have_posts() ){
                                        the_post();
                                    ?>
                               
                                    <li>
                                       
                                       
                                        <a href="<?php the_permalink(); ?>">
                                             <div class="wzt_TeamImg">
                                                <?php preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches); $pos = get_post_meta(get_the_ID(),'wztlaw',true);?>
                                                <?php if(isset($pos['pic']) && $pos['pic']){?>
                                                <img src="<?php echo $pos['pic'];?>" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo get_the_title();} ?>">
                                                <?php }elseif(isset($matches[1][0])){?>
                                                <img src="<?php echo $matches[1][0];?>" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo get_the_title();} ?>">
                                                <?php }else{?>
                                                    <img src="<?php echo get_template_directory_uri().'/assets/images/'?>nohai.jpg" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo get_the_title();} ?>">
                                                <?php }?>

                                               
                                            </div>
                                            <div class="wzt_TeamText">
                                                    <h2><?php the_title(); ?></h2>
                                               
                                                </div>
                                        </a>
                                    </li>
                                    <?php }}?>
                                   
                                    
                                </ul>
                                 <?php  pagelist();
                                    wp_reset_query();?>
                            </div>
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
                <div class="col-lg-9 teamdetailsright">
                    <div class="teamdetailsItem teamrightList">
                        <div>
                            <?php if(isset($cat) && $cat){?>
                            <span>当前位置：</span><?php echo get_category_parents( $cat, TRUE, "<span>&raquo;</span>" ); ?>
                            <?php }?>
                        </div>
                        <div class="wzt_textLIst">
                            <ul>
                                 <?php if( have_posts()){
                         
                                while ( have_posts() ){
                                    the_post();
                                ?>
                               
                                <li>
                                     <div class="wzt_imgLe">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_the_content(), $matches); $pos = get_post_meta(get_the_ID(),'wztlaw',true);?>
                                                <?php if(isset($pos['pic']) && $pos['pic']){?>
                                                <img src="<?php echo $pos['pic'];?>" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo get_the_title();} ?>">
                                                <?php }elseif(isset($matches[1][0])){?>
                                                <img src="<?php echo $matches[1][0];?>" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo get_the_title();} ?>">
                                                <?php }else{?>
                                                    <img src="<?php echo get_template_directory_uri().'/assets/images/'?>nohai.jpg" alt="<?php if(isset($pos['alt'])&& $pos['alt']){echo $pos['alt'];}else{echo get_the_title();} ?>">
                                                <?php }?>
                                            </a>
                                        </div>
                                        <div class="wzt_textLIstR">
                                            <h2><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"> <?php the_title(); ?></a></h2>
                                            <h4>发布日期：<?php echo get_the_date('Y-m-d'); ?></h4>
                                            <p class="pc">
                                                <?php echo mb_strimwidth(strip_tags( get_the_content()),0,230,'...');?></p>
                                        </div>
                                   
                                </li>
                                <?php }}?>
                                <?php  pagelist();
                                wp_reset_query();?>
                            </ul>
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