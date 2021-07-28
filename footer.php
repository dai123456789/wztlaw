 <!-- 底部链接 -->
    <footer>
        <div class="wzt_dblj wow slideInUp">
            <div class="foot">
                <div class="wztlaw_container pc">
                    <div class="col-lg-12">
                        <div class="ft_t auto clearfix ">
                            <div class="ft_menu fl">
                                <?php

                                    if( has_nav_menu('wztlaw_footermenu') ) {
                                        wp_nav_menu( [
                                            'theme_location'  => 'wztlaw_footermenu',
                                            'depth'           => 0,]
                                            );
                                    }else{
                                ?>
                                <div>请在后台外观-》菜单中添加菜单选中底部显示位置</div>
                                <?php
                                    }
                                ?>
                            </div>
                            <?php  $wztlaw_foot = get_option('wztlaw_foot');?>
                            <div class="ft_info fl">
                                <p class="fz tel">热线：<?php if(isset($wztlaw_foot['mobile'])&& $wztlaw_foot['mobile']){echo $wztlaw_foot['mobile'];}else{echo '请在后台主题设置-》底部设置中添加';}?></p>
                                <p class="fz address">地址：<?php if(isset($wztlaw_foot['address'])&& $wztlaw_foot['address']){echo $wztlaw_foot['address'];}else{echo '请在后台主题设置-》底部设置中添加';}?></p>
                                <p class="fz email">邮箱：<?php if(isset($wztlaw_foot['email'])&& $wztlaw_foot['email']){echo $wztlaw_foot['email'];}else{echo '请在后台主题设置-》底部设置中添加';}?></p>
                            </div>
                            <div class="ft_vx fr">
                                <?php if(isset($wztlaw_foot['qrcode'])&& $wztlaw_foot['qrcode']){ ?>
                                <img src="<?php echo $wztlaw_foot['qrcode'];?>" alt="<?php if(isset($wztlaw_foot['alt'])){echo $wztlaw_foot['alt'];}?>" class="pic">
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ft_b">

                    Copyright © <?php if(isset($wztlaw_foot['year'])&& $wztlaw_foot['year']){echo $wztlaw_foot['year'];}else{echo '请在后台主题设置-》底部设置中添加';}?>版权所有<a href="https://beian.miit.gov.cn" target="_blank"><?php if(isset($wztlaw_foot['copy'])&& $wztlaw_foot['copy']){echo $wztlaw_foot['copy'];}else{echo '请在后台主题设置-》底部设置中添加';}?></a>
                </div>
            </div>
        </div>
    </footer>
<?php wp_footer();?>

</body>
</html>