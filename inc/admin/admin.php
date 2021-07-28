<?php
class wztlaw_admin{
    public function __construct() {
         //加载css、js
        add_action( 'admin_enqueue_scripts', 'wztlaw_enqueue' );
        add_action('add_meta_boxes',[$this,'wztlaw_add_meta_box']);
        add_action('publish_post',  [$this, 'wztlaw_save_post'], 3, 10);
        add_action( 'admin_init', [$this, 'wztlaw_taxonomy_fields'], 3, 10 );
        add_action('admin_menu', [$this,'wztlaw_addpages']);
        if( isset($_GET['page']) && ( $_GET['page'] == 'wztlaw' ) ){
            if($_POST){
                if(isset($_POST['data']) && is_string($_POST['data'])){
                   
                    $data = stripslashes($_POST['data']);
                    
                    $BaiduSEO = json_decode($data,true);
                    if(isset($BaiduSEO['wztlaw'])){
                        $this->data = $BaiduSEO;
                        add_action('init',[$this,'wztlaw_post']);
                    }
                }
            }
            if(isset($_GET['message']) && $_GET['message']==1){
                global $wpdb;
                $page = (int)$_GET['pages'];
                $limit = (int)$_GET['limit']; 
                $start = ((int)$page-1)*(int)$limit;
               
                $count = $wpdb->query('select ID from '.$wpdb->prefix . 'wztlaw_message ',ARRAY_A);
                $article = $wpdb->get_results('select * from '.$wpdb->prefix . 'wztlaw_message  order by id desc limit '.$start.','.$limit,ARRAY_A);
                echo json_encode(['code'=>0,'msg'=>'','count'=>$count,'data'=>$article]);exit; 
            }
        }
    }
    public function wztlaw_taxonomy_fields(){
        add_action( 'category_add_form_fields', [$this, 'wztlaw_taxonomy_edit'], 3, 10 );
        add_action( 'category_edit_form', [$this, 'wztlaw_taxonomy_edit'], 3, 10 );
        add_action( 'created_category', [$this, 'wztlaw_taxonomy_save'], 3, 10 );
        add_action( 'edited_category', [$this, 'wztlaw_taxonomy_save'], 3, 10 );
        add_action( 'delete_category', [$this, 'wztlaw_taxonomy_delete'], 3, 10 );
    }
    public function wztlaw_taxonomy_edit($term){
        $form_edit = ( is_object( $term ) && isset( $term->taxonomy ) ) ? true : false;
        $taxonomy  = ( $form_edit ) ? $term->taxonomy : $term;
        $classname = ( $form_edit ) ? 'edit' : 'add';
        if($classname=='edit'){
        if(isset($term->term_id)){
            $wztlaw = get_term_meta($term->term_id,'wztlaw',true);
        }
        echo '<div class="layui-form-item">
          <label class="layui-form-label" style="width:210px;text-align:left;color:#23282d;margin-left:-15px">布局样式</label>
          <div class="layui-input-block">';
          if(isset($wztlaw['type']) && $wztlaw['type']==1){
            echo '<label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="1" title="新闻资讯" checked="">新闻资讯</label>
            <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="2" title="图文+侧栏">图文+侧栏</label>
            <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="3" title="图文 无侧栏">图文 无侧栏</label>';
          }elseif(isset($wztlaw['type']) && $wztlaw['type']==2){
            echo '<label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="1" title="新闻资讯" >新闻资讯</label>
            <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="2" title="图文+侧栏" checked="">图文+侧栏</label>
            <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="3" title="图文 无侧栏">图文 无侧栏</label>';
          }elseif(isset($wztlaw['type']) && $wztlaw['type']==3){
            echo '<label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="1" title="新闻资讯" >新闻资讯</label>
            <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="2" title="图文+侧栏" checked="">图文+侧栏</label>
            <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="3" title="图文 无侧栏" checked="">图文 无侧栏</label>';
          }else{
            echo '<label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="1" title="新闻资讯" checked="">新闻资讯</label>
            <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="2" title="图文+侧栏">图文+侧栏</label>
            <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="3" title="图文 无侧栏">图文 无侧栏</label>';
          }
          echo '</div>
        </div>
        <div class="layui-form-item">
        <label class="layui-form-label" style="width:210px;text-align:left;color:#23282d;margin-left:-15px">分类banner</label>
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="tes1">上传图片</button>';
            if(isset($wztlaw['pic']) && $wztlaw['pic']){
                echo '<input type="hidden" name="wztlaw[pic]" value="'.$wztlaw['pic'].'">';
            }else{
                 echo '<input type="hidden" name="wztlaw[pic]" value="">';
            }

            echo '<div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:225px;line-height:200px">';
                    if(isset($wztlaw['pic']) && $wztlaw['pic']){
                        echo '<img class="layui-upload-img" id="dem1" style="width:200px" src="'.$wztlaw['pic'].'">';
                    }else{
                        echo '<img class="layui-upload-img" id="dem1" style="width:200px" src="">';
                    }
                    
            echo '<p id="demoText"></p>
            </div>
        </div>
    </div>
    <div class="layui-form-item layui-form-text">
        <label class="layui-form-label" style="width:210px;text-align:left;color:#23282d;margin-left:-15px">alt描述</label>
        <div class="layui-input-block" style="margin-left:225px">';
            if(isset($wztlaw['alt']) && $wztlaw['alt']){
                echo ' <input type="text" name="wztlaw[alt]"   autocomplete="off" placeholder="" class="layui-input" value="'.$wztlaw['alt'].'">';
            }else{
                echo ' <input type="text" name="wztlaw[alt]"   autocomplete="off" placeholder="" class="layui-input" value="">';
            }

        echo '</div>
    </div>
   <script>
      jQuery(document).ready(function($){
        $("#tes1").click(function(){     
            event.preventDefault();   
            
            upload_frame = wp.media({   
                title: "添加图片",   
                button: {   
                    text: "选择图片",   
                },   
                multiple: false   
            });   
            upload_frame.on("select",function(){   
                attachment = upload_frame.state().get("selection").first().toJSON(); 
                
                $("input[name=\'wztlaw[pic]\']").val(attachment.url);   
                $("#dem1").attr("src",attachment.url);
            });    
            upload_frame.open();   
        }) 
      })
    </script>
  
        ';
      }else{
          
          echo '<div class="layui-form-item">
              <label class="layui-form-label" style="width: 100%;text-align: left;">布局样式</label>
              <div class="layui-input-block" style="margin-left:0px">
              
              <label style="vertical-align: middle;display: inline-block;"><input type="radio" name="wztlaw[type]" value="1" title="新闻资讯" checked="">新闻资讯</label>
                <label style="vertical-align: middle;display: inline-block;"><input type="radio" name="wztlaw[type]" value="2" title="图文+侧栏">图文+侧栏</label>
                <label style="vertical-align: middle;display: inline-block;"><input type="radio" name="wztlaw[type]" value="3" title="图文 无侧栏">图文 无侧栏</label>
             
             </div>
            </div>
            <div class="layui-form-item">
            <label class="layui-form-label" style="width: 100%;text-align: left;">分类banner</label>
            <div class="layui-upload">
                <button type="button" class="layui-btn" id="tes1">上传图片</button>
                
               <input type="hidden" name="wztlaw[pic]" value="">
                
    
                <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;line-height:200px">
                        
                           <img class="layui-upload-img" id="dem1" style="width:200px" src="">
                       
                        
                <p id="demoText"></p>
                </div>
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label" style="width: 100%;text-align: left;">alt描述</label>
            <div class="layui-input-block" style="margin-left:0px">
                <input type="text" name="wztlaw[alt]"   autocomplete="off" placeholder="" class="layui-input" value="">
                
    
            </div>
        </div>
        <script>
          jQuery(document).ready(function($){
            $("#tes1").click(function(){     
                event.preventDefault();   
                
                upload_frame = wp.media({   
                    title: "添加图片",   
                    button: {   
                        text: "选择图片",   
                    },   
                    multiple: false   
                });   
                upload_frame.on("select",function(){   
                    attachment = upload_frame.state().get("selection").first().toJSON(); 
                    
                    $("input[name=\'wztlaw[pic]\']").val(attachment.url);   
                    $("#dem1").attr("src",attachment.url);
                });    
                upload_frame.open();   
            }) 
          })
        </script>
      
            ';
      }
        

      
    }
    
    public function wztlaw_taxonomy_save($term_id){
      if(isset($_POST['wztlaw'])){
            $res = get_term_meta($term_id,'wztlaw',true);
            if(!$res){
                add_term_meta($term_id,'wztlaw',$_POST['wztlaw']);
            }else{
                update_term_meta( $term_id,'wztlaw', $_POST['wztlaw'] );
            }
        }
    }

    public function wztlaw_add_meta_box( $post_type) {
        if($post_type=='post'){
            add_meta_box( 'wztlaw', '更多功能', array( $this, 'wztlaw_meta_box_content' ), 'post', 'normal', 'high', '' );
        }

    }
    public function wztlaw_save_post($post_id){
        if(isset($_POST['wztlaw_yanzheng']) && $_POST['wztlaw_yanzheng']=='wztlaw_edit'){
            if(isset($_POST['wztlaw'])){
                $res = get_post_meta( $post_id, 'wztlaw', true );
                if($res){
                    update_post_meta( $post_id,'wztlaw', $_POST['wztlaw'] );
                }else{
                    delete_post_meta($post_id,'wztlaw');
                    add_post_meta($post_id,'wztlaw',$_POST['wztlaw']);
                }
            }
        }
    }
    public function wztlaw_meta_box_content( $post, $callback ) {
        
        $wztlaw = get_post_meta($post->ID,'wztlaw',true);
         echo '<style>
                .tctp{
                    cleaar:both; 
                }
                .tctp li{
                    float:left;
                    
                }
                .tctp li img{
                    img{
                        width:100px;
                        height:100px;
                    }
                }
                #wztlaw_icon i{
                    border:1px solid #ccc;
                    padding:5px;
                }
            </style>';
        echo '<input type="hidden" name="wztlaw_yanzheng" value="wztlaw_edit">';
        echo '<div class="layui-form-item">

            <label class="layui-form-label">文章类型</label>
            <div class="layui-input-block">';
            if(isset($wztlaw['type']) && $wztlaw['type']==2){
                echo '<label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="1" title="普通"  >普通</label>
              <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="2" title="图文" checked="">图文</label>
              <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="3" title="图文+首页" >图文+首页</label>';
            }elseif(isset($wztlaw['type']) && $wztlaw['type']==3){
                echo '<label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="1" title="普通"  >普通</label>
              <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="2" title="图文" >图文</label>
              <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="3" title="图文+首页" checked="">图文+首页</label>';
            }else{
                 echo '<label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="1" title="普通" checked="" >普通</label>
              <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="2" title="图文" >图文</label>
              <label style="vertical-align: middle;line-height: 36px;"><input type="radio" name="wztlaw[type]" value="3" title="图文+首页" >图文+首页</label>';
            }
            echo ' </div>
        </div>';
        if(isset($wztlaw['type']) && ($wztlaw['type']==2 || $wztlaw['type']==3)){
        echo    '<div class="ptwz">
                    <div class="layui-form-item" >
                        <label class="layui-form-label">缩略图</label>
                        <div class="layui-upload">
                            <button type="button" class="layui-btn" id="test1">上传图片</button>';
                            if(isset($wztlaw['pic']) && $wztlaw['pic']){
                                echo '<input type="hidden" name="wztlaw[pic]" value="'.$wztlaw['pic'].'">';
                            }else{
                                 echo '<input type="hidden" name="wztlaw[pic]" value="">';
                            }
            
                            echo '<div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">';
                                if(isset($wztlaw['pic']) && $wztlaw['pic']){
                                    echo '<img class="layui-upload-img" id="de1" style="width:200px" src="'.$wztlaw['pic'].'">';
                                }else{
                                    echo '<img class="layui-upload-img" id="de1" style="width:200px" src="">';
                                }
                                
                                echo '<p id="demoText"></p>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">alt描述</label>
                        <div class="layui-input-block">';
                        if(isset($wztlaw['alt']) && $wztlaw['alt']){
                            echo '<input type="text" name="wztlaw[alt]"   autocomplete="off" placeholder="" class="layui-input" value="'.$wztlaw['alt'].'">';
                        }else{
                            echo '<input type="text" name="wztlaw[alt]"   autocomplete="off" placeholder="" class="layui-input" value="">';
                        }
            
                        echo '</div>
                    </div>
                </div>
                <div class="twwz" style="display:none">
                    <div class="layui-form-item" >
                        <label class="layui-form-label">图文图册</label>
                        <div class="layui-upload">
                            <button type="button" class="layui-btn" id="test2">创建图册</button>';
                                if(isset($wztlaw['ids']) && $wztlaw['ids']){
                                    echo '<input type="hidden" name="wztlaw[ids]" value="'.$wztlaw['ids'].'" class="tc_edit">';
                                     echo '<div class="layui-upload-list" style="margin-left:110px;">
                                        <ul class="tctp">';
                                            $urls = explode(',',$wztlaw['ids']);
                                            foreach($urls as $key=>$val){
                                                
                                                echo '<li><img src="'.wp_get_attachment_image_src($val,'thumbnail')[0].'"></li>';
                                            }
                                        echo'    
                                        </ul>';
                                }else{
                                     echo '<input type="hidden" name="wztlaw[ids]" value="" class="tc_edit">';
                                      echo '<div class="layui-upload-list" style="margin-left:110px;">
                                        <ul class="tctp">
                                            
                                        </ul>';
                                }
                        echo '</div>
                    </div>
                </div>
            ';
        }else{
        echo    '<div  class="ptwz">
                    <div class="layui-form-item" >
                        <label class="layui-form-label">缩略图</label>
                        <div class="layui-upload">
                            <button type="button" class="layui-btn" id="test1">上传图片</button>';
                            if(isset($wztlaw['pic']) && $wztlaw['pic']){
                                echo '<input type="hidden" name="wztlaw[pic]" value="'.$wztlaw['pic'].'">';
                            }else{
                                 echo '<input type="hidden" name="wztlaw[pic]" value="">';
                            }
            
                            echo '<div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">';
                                if(isset($wztlaw['pic']) && $wztlaw['pic']){
                                    echo '<img class="layui-upload-img" id="de1" style="width:200px" src="'.$wztlaw['pic'].'">';
                                }else{
                                    echo '<img class="layui-upload-img" id="de1" style="width:200px" src="">';
                                }
                                
                                echo '<p id="demoText"></p>
                            </div>
                        </div>
                    </div>
                    <div class="layui-form-item layui-form-text">
                        <label class="layui-form-label">alt描述</label>
                        <div class="layui-input-block">';
                            if(isset($wztlaw['alt']) && $wztlaw['alt']){
                                echo '<input type="text" name="wztlaw[alt]"   autocomplete="off" placeholder="" class="layui-input" value="'.$wztlaw['alt'].'">';
                            }else{
                                echo '<input type="text" name="wztlaw[alt]"   autocomplete="off" placeholder="" class="layui-input" value="">';
                            }
            
                        echo '</div>
                    </div>
                </div>
                <div class="twwz" style="display:none">
                    <div class="layui-form-item" >
                        <label class="layui-form-label">图文图册</label>
                        <div class="layui-upload">
                            <button type="button" class="layui-btn" id="test2">创建图册</button>';
                            if(isset($wztlaw['ids']) && $wztlaw['ids']){
                                echo '<input type="hidden" name="wztlaw[ids]" value="'.$wztlaw['ids'].'" class="tc_edit">';
                            }else{
                                 echo '<input type="hidden" name="wztlaw[ids]" value="" class="tc_edit">';
                            }
            
                            echo '<div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
                                 <ul class="tctp">';
                                    if(isset($wztlaw['ids']) && $wztlaw['ids']){
                                        $urls = explode(',',$wztlaw['ids']);
                                        foreach($urls as $key=>$val){
                                            
                                            echo '<li><img src="'.wp_get_attachment_image_src($val,'thumbnail')[0].'"></li>';
                                        }
                                    }
                                echo'    
                                </ul>';
                                
                            echo '</div>
                        </div>
                    </div>
                </div>';
        }
    echo '<div style="margin:20px 110px" class="lunbo_list">';
        $num = 0;
        $color ="";
        if(isset($wztlaw['button'])){

            foreach($wztlaw['button'] as $key=>$val){
                ++$num; 
                $color .=$val['button_color'].',';
                echo '<div class="layui-collapse" lay-accordion="">
                    <div class="layui-colla-item">
                        <h2 class="layui-colla-title" style="position: relative;height: 42px;line-height: 42px;padding: 0 15px 0 35px;color: #333;background-color: #f2f2f2;cursor: pointer;font-size: 14px;overflow: hidden;">添加按钮</h2>
                        <div class="layui-colla-content">
                           <div class="layui-form-item">

                                <label class="layui-form-label">菜单类型</label>
                                <div class="layui-input-block">';
                                if($val['button_type']==1){
                                  echo '<label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="'.$num.'" name="wztlaw[button]['.$num.'][button_type]" value="1" title="跳转链接" checked="" >跳转链接</label>
                                  <label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="'.$num.'" name="wztlaw[button]['.$num.'][button_type]" value="2" title="弹出图像" >弹出图像</label>
                                  <label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="'.$num.'" name="wztlaw[button]['.$num.'][button_type]" value="3" title="QQ在线咨询" >QQ在线咨询</label>';
                                }elseif($val['button_type']==2){
                                    echo '<label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="'.$num.'" name="wztlaw[button]['.$num.'][button_type]" value="1" title="跳转链接"  >跳转链接</label>
                                  <label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="'.$num.'" name="wztlaw[button]['.$num.'][button_type]" value="2" title="弹出图像" checked="" >弹出图像</label>
                                  <label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="'.$num.'" name="wztlaw[button]['.$num.'][button_type]" value="3" title="QQ在线咨询" >QQ在线咨询</label>';
                                }elseif($val['button_type']==3){
                                    echo '<label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="'.$num.'" name="wztlaw[button]['.$num.'][button_type]" value="1" title="跳转链接"  >跳转链接</label>
                                  <label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="'.$num.'" name="wztlaw[button]['.$num.'][button_type]" value="2" title="弹出图像" >弹出图像</label>
                                  <label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="'.$num.'" name="wztlaw[button]['.$num.'][button_type]" value="3" title="QQ在线咨询" checked="">QQ在线咨询</label>';
                                }
                                echo '</div>
                              </div>
                            <div class="layui-form-item">
                                 <label class="layui-form-label">按钮文本</label>
                                 <div class="layui-input-block">
                                  <input type="text" name="wztlaw[button]['.$num.'][button_title]"   autocomplete="off" placeholder="" class="layui-input" value="'.$val['button_title'].'">
                                 </div>
                            </div>
                            <div class="layui-form-item">
                                <label class="layui-form-label">按钮图标</label>
                                <div class="layui-input-block" >
                                    <input type="hidden" name="wztlaw[button]['.$num.'][button_icon]"   autocomplete="off" placeholder="" class="layui-input" value="'.$val['button_icon'].'">
                                    <i class="'.$val['button_icon'].'"></i>
                                    <button type="button" class="layui-btn layui-btn-normal wztlaw_addicon"  data-num="'.$num.'">添加图标</button>
                                </div>
                              </div>
                                
                            <div class="layui-form-item">
                                <label class="layui-form-label">按钮颜色</label>
                                  <div class="layui-input-inline" style="width: 120px;">
                                    <input type="text"  placeholder="请选择颜色" class="layui-input" id="test-form-input'.$num.'" name="wztlaw[button]['.$num.'][button_color]" value="'.$val['button_color'].'">
                                  </div>
                                  <div class="layui-inline" style="left: -11px;">
                                    <div id="test-form'.$num.'" data-num="'.$num.'"></div>
                                  </div>
                            </div>';
                            if($val['button_type']==1){
                            echo '<div class="layui-form-item button_url">
                                 <label class="layui-form-label">跳转链接</label>
                                 <div class="layui-input-block">
                                  <input type="text" name="wztlaw[button]['.$num.'][button_url]"   autocomplete="off" placeholder="" class="layui-input" value="'.$val['button_url'].'">
                                 </div>
                            </div><div class="layui-form-item button_pic" style="display:none">
                                <label class="layui-form-label">上传图像</label>
                                <div class="layui-upload">
                                    <button type="button" class="layui-btn" id="tests'.$num.'" onclick="test('.$num.')">上传图片</button>
                                    <input type="hidden" name="wztlaw[button]['.$num.'][button_pic]" value="">
                                    <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
                                            <img class="layui-upload-img" id="demos'.$num.'" style="width:200px" src="">
                                        
                                        <p id="demoText"></p>
                                    </div>
                                </div>
                            </div><div class="layui-form-item button_qq" style="display:none">
                                     <label class="layui-form-label">qq号码</label>
                                     <div class="layui-input-block">
                                      <input type="text" name="wztlaw[button]['.$num.'][button_qq]"   autocomplete="off" placeholder="" class="layui-input" value="">
                                     </div>
                                
                                </div>';
                            }elseif($val['button_type']==2){
                            echo '<div class="layui-form-item button_url" style="display:none">
                                 <label class="layui-form-label">跳转链接</label>
                                 <div class="layui-input-block">
                                  <input type="text" name="wztlaw[button]['.$num.'][button_url]"   autocomplete="off" placeholder="" class="layui-input" value="">
                                 </div>
                            </div><div class="layui-form-item button_pic" >
                                <label class="layui-form-label">上传图像</label>
                                <div class="layui-upload">
                                    <button type="button" class="layui-btn" id="tests'.$num.'" onclick="test('.$num.')">上传图片</button>
                                    <input type="hidden" name="wztlaw[button]['.$num.'][button_pic]" value="'.$val['button_pic'].'">
                                    <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
                                            <img class="layui-upload-img" id="demos'.$num.'" style="width:200px" src="'.$val['button_pic'].'">
                                        
                                        <p id="demoText"></p>
                                    </div>
                                </div>
                            </div><div class="layui-form-item button_qq" style="display:none">
                                     <label class="layui-form-label">qq号码</label>
                                     <div class="layui-input-block">
                                      <input type="text" name="wztlaw[button]['.$num.'][button_qq]"   autocomplete="off" placeholder="" class="layui-input" value="">
                                     </div>
                                
                                </div>';
                            }elseif($val['button_type']==3){
                            echo '<div class="layui-form-item button_url" style="display:none">
                                 <label class="layui-form-label">跳转链接</label>
                                 <div class="layui-input-block">
                                  <input type="text" name="wztlaw[button]['.$num.'][button_url]"   autocomplete="off" placeholder="" class="layui-input" value="">
                                 </div>
                            </div><div class="layui-form-item button_pic" style="display:none">
                                <label class="layui-form-label">上传图像</label>
                                <div class="layui-upload">
                                    <button type="button" class="layui-btn" id="tests'.$num.'" onclick="test('.$num.')">上传图片</button>
                                    <input type="hidden" name="wztlaw[button]['.$num.'][button_pic]" value="">
                                    <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
                                            <img class="layui-upload-img" id="demos'.$num.'" style="width:200px" src="">
                                        
                                        <p id="demoText"></p>
                                    </div>
                                </div>
                            </div><div class="layui-form-item button_qq" >
                                     <label class="layui-form-label">qq号码</label>
                                     <div class="layui-input-block">
                                      <input type="text" name="wztlaw[button]['.$num.'][button_qq]"   autocomplete="off" placeholder="" class="layui-input" value="'.$val['button_qq'].'">
                                     </div>
                                
                                </div>';
                            }
                            echo '<div class="layui-form-item">
                                <label class="layui-form-label"></label>
                                <div class="layui-input-block" >
                                    
                                    <button class="layui-btn layui-btn-danger lunbo_delete"><i class="layui-icon layui-icon-delete"></i>删除</button>
                                    
                                </div>
                              </div>
                        </div>
                    </div>
                </div>';
            }
        }
    echo '</div>';
    if(isset($wztlaw['type']) && ($wztlaw['type']==2 || $wztlaw['type']==3)){
        echo '<div class="layui-form-item layui-form-text add_button" >';
    }else{
        echo '<div class="layui-form-item layui-form-text add_button"  style="display:none">';
    }
    echo    '<div class="layui-input-block">
           <button type="button" class="layui-btn layui-btn-normal lunbo_add_hdp">添加按钮</button>
        </div>
    </div>
    
    <script>
        function test(i){
            event.preventDefault();   
            
            upload_frame = wp.media({   
                title: "添加图片",   
                button: {   
                    text: "选择图片",   
                },   
                multiple: false   
            });   
            upload_frame.on("select",function(){   
                attachment = upload_frame.state().get("selection").first().toJSON(); 
                jQuery("body").find("input[name=\'wztlaw[button]["+i+"][button_pic]\']").val(attachment.url);   
                jQuery("body").find("#demos"+i).attr("src",attachment.url);
            });    
            upload_frame.open();   
        }
       
        jQuery(document).ready(function($){
            layui.use(["colorpicker","form","element","layer"], function(){
                var  colorpicker = layui.colorpicker;
                var form = layui.form;
                var element = layui.element;
                var layer = layui.layer;
                var num_add = "'.$num.'";
                var color = "'.$color.'";
                color = color.split(",");
                
                for(var i=1;i<=num_add;i++){
                    colorpicker.render({
                        elem: "#test-form"+i
                        ,color: color[i-1]
                        ,done: function(color){
                           var j = $(this)[0].elem.replace("#test-form","");
                          
                          $("body").find("#test-form-input"+j).val(color);
                        }
                    });
                }
                $("body").on("click","#wztlaw_icon i",function(){
                    
                    layer.close(layer.index);
                    var do_num = $("body").find("input[name=\'do_num\']").val();
                    var cla = $(this).attr("class");
                    $("body").find("input[name=\'wztlaw[button]["+do_num+"][button_icon]\']").val(cla);
                    $("body").find("input[name=\'wztlaw[button]["+do_num+"][button_icon]\']").next("i").attr("class",cla);
                })
                $("body").on("click",".wztlaw_addicon",function(){
                    var do_num = $(this).attr("data-num");
                    
                    layer.open({
                        type: 1,
                        title:"请选择图标",
                        area:["500px","300px"],
                        closeBtn: 1, //不显示关闭按钮
                        anim: 0,
                        shadeClose: true, //开启遮罩关闭
                        content:   `<div id="wztlaw_icon">
                                        <input type="hidden" name="do_num" value="`+do_num+`">
                                       
                                        <i class="fa fa-universal-access" aria-hidden="true"></i>
                                        <i class="fa fa-fort-awesome" aria-hidden="true"></i>
                                        <i class="fa fa-commenting" aria-hidden="true"></i>
                                        <i class="fa fa-map-signs" aria-hidden="true"></i>
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <i class="fa fa-send-o" aria-hidden="true"></i>
                                        <i class="fa fa-book" aria-hidden="true"></i>
                                        <i class="fa fa-fighter-jet" aria-hidden="true"></i>
                                        <i class="fa fa-beer" aria-hidden="true"></i>
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-pied-piper-alt" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                        <i class="fa fa-address-book" aria-hidden="true"></i>
                                        <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                        <i class="fa fa-address-card" aria-hidden="true"></i>
                                        <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                        <i class="fa fa-adjust" aria-hidden="true"></i>
                                        <i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i>
                                        <i class="fa fa-anchor" aria-hidden="true"></i>
                                        <i class="fa fa-archive" aria-hidden="true"></i>
                                        <i class="fa fa-area-chart" aria-hidden="true"></i>
                                        <i class="fa fa-arrows" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-h" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-v" aria-hidden="true"></i>
                                        <i class="fa fa-asl-interpreting" aria-hidden="true"></i>
                                        <i class="fa fa-assistive-listening-systems" aria-hidden="true"></i>
                                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                                        <i class="fa fa-at" aria-hidden="true"></i>
                                        <i class="fa fa-audio-description" aria-hidden="true"></i>
                                        <i class="fa fa-automobile" aria-hidden="true"></i>
                                        <i class="fa fa-balance-scale" aria-hidden="true"></i>
                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                        <i class="fa fa-bank" aria-hidden="true"></i>
                                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                        <i class="fa fa-bar-chart-o" aria-hidden="true"></i>
                                        <i class="fa fa-barcode" aria-hidden="true"></i>
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                        <i class="fa fa-bath" aria-hidden="true"></i>
                                        <i class="fa fa-bathtub" aria-hidden="true"></i>
                                        <i class="fa fa-battery" aria-hidden="true"></i>
                                        <i class="fa fa-battery-0" aria-hidden="true"></i>
                                        <i class="fa fa-battery-1" aria-hidden="true"></i>
                                        <i class="fa fa-battery-2" aria-hidden="true"></i>
                                        <i class="fa fa-battery-3" aria-hidden="true"></i>
                                        <i class="fa fa-battery-4" aria-hidden="true"></i>
                                        <i class="fa fa-battery-empty" aria-hidden="true"></i>
                                        <i class="fa fa-battery-full" aria-hidden="true"></i>
                                        <i class="fa fa-battery-half" aria-hidden="true"></i>
                                        <i class="fa fa-battery-quarter" aria-hidden="true"></i>
                                        <i class="fa fa-battery-three-quarters" aria-hidden="true"></i>
                                        <i class="fa fa-bed" aria-hidden="true"></i>
                                        <i class="fa fa-beer" aria-hidden="true"></i>
                                        <i class="fa fa-bell" aria-hidden="true"></i>
                                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                                        <i class="fa fa-bell-slash" aria-hidden="true"></i>
                                        <i class="fa fa-bell-slash-o" aria-hidden="true"></i>
                                        <i class="fa fa-bicycle" aria-hidden="true"></i>
                                        <i class="fa fa-binoculars" aria-hidden="true"></i>
                                        <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                                        <i class="fa fa-blind" aria-hidden="true"></i>
                                        <i class="fa fa-bluetooth" aria-hidden="true"></i>
                                        <i class="fa fa-bluetooth-b" aria-hidden="true"></i>
                                        <i class="fa fa-bolt" aria-hidden="true"></i>
                                        <i class="fa fa-bomb" aria-hidden="true"></i>
                                        <i class="fa fa-book" aria-hidden="true"></i>
                                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                                        <i class="fa fa-bookmark-o" aria-hidden="true"></i>
                                        <i class="fa fa-braille" aria-hidden="true"></i>
                                        <i class="fa fa-briefcase" aria-hidden="true"></i>
                                        <i class="fa fa-bug" aria-hidden="true"></i>
                                        <i class="fa fa-building" aria-hidden="true"></i>
                                        <i class="fa fa-building-o" aria-hidden="true"></i>
                                        <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                        <i class="fa fa-bullseye" aria-hidden="true"></i>
                                        <i class="fa fa-bus" aria-hidden="true"></i>
                                        <i class="fa fa-cab" aria-hidden="true"></i>
                                        <i class="fa fa-calculator" aria-hidden="true"></i>
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                        <i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
                                        <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                        <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                                        <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
                                        <i class="fa fa-camera" aria-hidden="true"></i>
                                        <i class="fa fa-camera-retro" aria-hidden="true"></i>
                                        <i class="fa fa-car" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-left" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-right" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                        <i class="fa fa-cc" aria-hidden="true"></i>
                                        <i class="fa fa-certificate" aria-hidden="true"></i>
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-child" aria-hidden="true"></i>
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                        <i class="fa fa-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                                        <i class="fa fa-circle-thin" aria-hidden="true"></i>
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <i class="fa fa-clone" aria-hidden="true"></i>
                                        <i class="fa fa-close" aria-hidden="true"></i>
                                        <i class="fa fa-cloud" aria-hidden="true"></i>
                                        <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        <i class="fa fa-code" aria-hidden="true"></i>
                                        <i class="fa fa-code-fork" aria-hidden="true"></i>
                                        <i class="fa fa-coffee" aria-hidden="true"></i>
                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                        <i class="fa fa-comment-o" aria-hidden="true"></i>
                                        <i class="fa fa-commenting" aria-hidden="true"></i>
                                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                        <i class="fa fa-comments" aria-hidden="true"></i>
                                        <i class="fa fa-comments-o" aria-hidden="true"></i>
                                        <i class="fa fa-compass" aria-hidden="true"></i>
                                        <i class="fa fa-copyright" aria-hidden="true"></i>
                                        <i class="fa fa-creative-commons" aria-hidden="true"></i>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                                        <i class="fa fa-crop" aria-hidden="true"></i>
                                        <i class="fa fa-crosshairs" aria-hidden="true"></i>
                                        <i class="fa fa-cube" aria-hidden="true"></i>
                                        <i class="fa fa-cubes" aria-hidden="true"></i>
                                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                                        <i class="fa fa-dashboard" aria-hidden="true"></i>
                                        <i class="fa fa-database" aria-hidden="true"></i>
                                        <i class="fa fa-deaf" aria-hidden="true"></i>
                                        <i class="fa fa-deafness" aria-hidden="true"></i>
                                        <i class="fa fa-desktop" aria-hidden="true"></i>
                                        <i class="fa fa-diamond" aria-hidden="true"></i>
                                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        <i class="fa fa-drivers-license" aria-hidden="true"></i>
                                        <i class="fa fa-drivers-license-o" aria-hidden="true"></i>
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        <i class="fa fa-envelope-open" aria-hidden="true"></i>
                                        <i class="fa fa-envelope-open-o" aria-hidden="true"></i>
                                        <i class="fa fa-envelope-square" aria-hidden="true"></i>
                                        <i class="fa fa-eraser" aria-hidden="true"></i>
                                        <i class="fa fa-exchange" aria-hidden="true"></i>
                                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        <i class="fa fa-external-link" aria-hidden="true"></i>
                                        <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                        <i class="fa fa-eyedropper" aria-hidden="true"></i>
                                        <i class="fa fa-fax" aria-hidden="true"></i>
                                        <i class="fa fa-feed" aria-hidden="true"></i>
                                        <i class="fa fa-female" aria-hidden="true"></i>
                                        <i class="fa fa-fighter-jet" aria-hidden="true"></i>
                                        <i class="fa fa-file-archive-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-audio-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-code-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-movie-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-photo-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-picture-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-sound-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-video-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-word-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-zip-o" aria-hidden="true"></i>
                                        <i class="fa fa-film" aria-hidden="true"></i>
                                        <i class="fa fa-filter" aria-hidden="true"></i>
                                        <i class="fa fa-fire" aria-hidden="true"></i>
                                        <i class="fa fa-fire-extinguisher" aria-hidden="true"></i>
                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                        <i class="fa fa-flag-checkered" aria-hidden="true"></i>
                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                        <i class="fa fa-flash" aria-hidden="true"></i>
                                        <i class="fa fa-flask" aria-hidden="true"></i>
                                        <i class="fa fa-folder" aria-hidden="true"></i>
                                        <i class="fa fa-folder-o" aria-hidden="true"></i>
                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                        <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                                        <i class="fa fa-frown-o" aria-hidden="true"></i>
                                        <i class="fa fa-futbol-o" aria-hidden="true"></i>
                                        <i class="fa fa-gamepad" aria-hidden="true"></i>
                                        <i class="fa fa-gavel" aria-hidden="true"></i>
                                        <i class="fa fa-gear" aria-hidden="true"></i>
                                        <i class="fa fa-gears" aria-hidden="true"></i>
                                        <i class="fa fa-gift" aria-hidden="true"></i>
                                        <i class="fa fa-glass" aria-hidden="true"></i>
                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                        <i class="fa fa-group" aria-hidden="true"></i>
                                        <i class="fa fa-hand-grab-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-lizard-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-paper-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-peace-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-rock-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-scissors-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-spock-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-stop-o" aria-hidden="true"></i>
                                        <i class="fa fa-handshake-o" aria-hidden="true"></i>
                                        <i class="fa fa-hard-of-hearing" aria-hidden="true"></i>
                                        <i class="fa fa-hashtag" aria-hidden="true"></i>
                                        <i class="fa fa-hdd-o" aria-hidden="true"></i>
                                        <i class="fa fa-headphones" aria-hidden="true"></i>
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        <i class="fa fa-heartbeat" aria-hidden="true"></i>
                                        <i class="fa fa-history" aria-hidden="true"></i>
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                        <i class="fa fa-hotel" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-1" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-2" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-3" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-end" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-o" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                                        <i class="fa fa-i-cursor" aria-hidden="true"></i>
                                        <i class="fa fa-id-badge" aria-hidden="true"></i>
                                        <i class="fa fa-id-card" aria-hidden="true"></i>
                                        <i class="fa fa-id-card-o" aria-hidden="true"></i>
                                        <i class="fa fa-image" aria-hidden="true"></i>
                                        <i class="fa fa-inbox" aria-hidden="true"></i>
                                        <i class="fa fa-industry" aria-hidden="true"></i>
                                        <i class="fa fa-info" aria-hidden="true"></i>
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        <i class="fa fa-institution" aria-hidden="true"></i>
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                        <i class="fa fa-keyboard-o" aria-hidden="true"></i>
                                        <i class="fa fa-language" aria-hidden="true"></i>
                                        <i class="fa fa-laptop" aria-hidden="true"></i>
                                        <i class="fa fa-leaf" aria-hidden="true"></i>
                                        <i class="fa fa-legal" aria-hidden="true"></i>
                                        <i class="fa fa-lemon-o" aria-hidden="true"></i>
                                        <i class="fa fa-level-down" aria-hidden="true"></i>
                                        <i class="fa fa-level-up" aria-hidden="true"></i>
                                        <i class="fa fa-life-bouy" aria-hidden="true"></i>
                                        <i class="fa fa-life-buoy" aria-hidden="true"></i>
                                        <i class="fa fa-life-ring" aria-hidden="true"></i>
                                        <i class="fa fa-life-saver" aria-hidden="true"></i>
                                        <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                                        <i class="fa fa-location-arrow" aria-hidden="true"></i>
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                        <i class="fa fa-low-vision" aria-hidden="true"></i>
                                        <i class="fa fa-magic" aria-hidden="true"></i>
                                        <i class="fa fa-magnet" aria-hidden="true"></i>
                                        <i class="fa fa-mail-forward" aria-hidden="true"></i>
                                        <i class="fa fa-mail-reply" aria-hidden="true"></i>
                                        <i class="fa fa-mail-reply-all" aria-hidden="true"></i>
                                        <i class="fa fa-male" aria-hidden="true"></i>
                                        <i class="fa fa-map" aria-hidden="true"></i>
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <i class="fa fa-map-o" aria-hidden="true"></i>
                                        <i class="fa fa-map-pin" aria-hidden="true"></i>
                                        <i class="fa fa-map-signs" aria-hidden="true"></i>
                                        <i class="fa fa-meh-o" aria-hidden="true"></i>
                                        <i class="fa fa-microchip" aria-hidden="true"></i>
                                        <i class="fa fa-microphone" aria-hidden="true"></i>
                                        <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                        <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                        <i class="fa fa-minus-square" aria-hidden="true"></i>
                                        <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-mobile" aria-hidden="true"></i>
                                        <i class="fa fa-mobile-phone" aria-hidden="true"></i>
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                        <i class="fa fa-moon-o" aria-hidden="true"></i>
                                        <i class="fa fa-mortar-board" aria-hidden="true"></i>
                                        <i class="fa fa-motorcycle" aria-hidden="true"></i>
                                        <i class="fa fa-mouse-pointer" aria-hidden="true"></i>
                                        <i class="fa fa-music" aria-hidden="true"></i>
                                        <i class="fa fa-navicon" aria-hidden="true"></i>
                                        <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                                        <i class="fa fa-object-group" aria-hidden="true"></i>
                                        <i class="fa fa-object-ungroup" aria-hidden="true"></i>
                                        <i class="fa fa-paint-brush" aria-hidden="true"></i>
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                        <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                        <i class="fa fa-paw" aria-hidden="true"></i>
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-percent" aria-hidden="true"></i>
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <i class="fa fa-phone-square" aria-hidden="true"></i>
                                        <i class="fa fa-photo" aria-hidden="true"></i>
                                        <i class="fa fa-picture-o" aria-hidden="true"></i>
                                        <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                        <i class="fa fa-plane" aria-hidden="true"></i>
                                        <i class="fa fa-plug" aria-hidden="true"></i>
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-podcast" aria-hidden="true"></i>
                                        <i class="fa fa-power-off" aria-hidden="true"></i>
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                        <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                                        <i class="fa fa-qrcode" aria-hidden="true"></i>
                                        <i class="fa fa-question" aria-hidden="true"></i>
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                        <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-quote-left" aria-hidden="true"></i>
                                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                                        <i class="fa fa-random" aria-hidden="true"></i>
                                        <i class="fa fa-recycle" aria-hidden="true"></i>
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                        <i class="fa fa-registered" aria-hidden="true"></i>
                                        <i class="fa fa-remove" aria-hidden="true"></i>
                                        <i class="fa fa-reorder" aria-hidden="true"></i>
                                        <i class="fa fa-reply" aria-hidden="true"></i>
                                        <i class="fa fa-reply-all" aria-hidden="true"></i>
                                        <i class="fa fa-retweet" aria-hidden="true"></i>
                                        <i class="fa fa-road" aria-hidden="true"></i>
                                        <i class="fa fa-rocket" aria-hidden="true"></i>
                                        <i class="fa fa-rss" aria-hidden="true"></i>
                                        <i class="fa fa-rss-square" aria-hidden="true"></i>
                                        <i class="fa fa-s15" aria-hidden="true"></i>
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        <i class="fa fa-search-minus" aria-hidden="true"></i>
                                        <i class="fa fa-search-plus" aria-hidden="true"></i>
                                        <i class="fa fa-send" aria-hidden="true"></i>
                                        <i class="fa fa-send-o" aria-hidden="true"></i>
                                        <i class="fa fa-server" aria-hidden="true"></i>
                                        <i class="fa fa-share" aria-hidden="true"></i>
                                        <i class="fa fa-share-alt" aria-hidden="true"></i>
                                        <i class="fa fa-share-alt-square" aria-hidden="true"></i>
                                        <i class="fa fa-share-square" aria-hidden="true"></i>
                                        <i class="fa fa-share-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-shield" aria-hidden="true"></i>
                                        <i class="fa fa-ship" aria-hidden="true"></i>
                                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        <i class="fa fa-shower" aria-hidden="true"></i>
                                        <i class="fa fa-sign-in" aria-hidden="true"></i>
                                        <i class="fa fa-sign-language" aria-hidden="true"></i>
                                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                                        <i class="fa fa-signal" aria-hidden="true"></i>
                                        <i class="fa fa-signing" aria-hidden="true"></i>
                                        <i class="fa fa-sitemap" aria-hidden="true"></i>
                                        <i class="fa fa-sliders" aria-hidden="true"></i>
                                        <i class="fa fa-smile-o" aria-hidden="true"></i>
                                        <i class="fa fa-snowflake-o" aria-hidden="true"></i>
                                        <i class="fa fa-soccer-ball-o" aria-hidden="true"></i>
                                        <i class="fa fa-sort" aria-hidden="true"></i>
                                        <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-alpha-desc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-amount-desc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-asc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-down" aria-hidden="true"></i>
                                        <i class="fa fa-sort-numeric-asc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-numeric-desc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-up" aria-hidden="true"></i>
                                        <i class="fa fa-space-shuttle" aria-hidden="true"></i>
                                        <i class="fa fa-spinner" aria-hidden="true"></i>
                                        <i class="fa fa-spoon" aria-hidden="true"></i>
                                        <i class="fa fa-square" aria-hidden="true"></i>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-half" aria-hidden="true"></i>
                                        <i class="fa fa-star-half-empty" aria-hidden="true"></i>
                                        <i class="fa fa-star-half-full" aria-hidden="true"></i>
                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-sticky-note" aria-hidden="true"></i>
                                        <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                                        <i class="fa fa-street-view" aria-hidden="true"></i>
                                        <i class="fa fa-suitcase" aria-hidden="true"></i>
                                        <i class="fa fa-sun-o" aria-hidden="true"></i>
                                        <i class="fa fa-support" aria-hidden="true"></i>
                                        <i class="fa fa-tablet" aria-hidden="true"></i>
                                        <i class="fa fa-tachometer" aria-hidden="true"></i>
                                        <i class="fa fa-tag" aria-hidden="true"></i>
                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                        <i class="fa fa-tasks" aria-hidden="true"></i>
                                        <i class="fa fa-taxi" aria-hidden="true"></i>
                                        <i class="fa fa-television" aria-hidden="true"></i>
                                        <i class="fa fa-terminal" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-0" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-1" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-2" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-3" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-4" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-empty" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-full" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-half" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-quarter" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-three-quarters" aria-hidden="true"></i>
                                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        <i class="fa fa-ticket" aria-hidden="true"></i>
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-times-rectangle" aria-hidden="true"></i>
                                        <i class="fa fa-times-rectangle-o" aria-hidden="true"></i>
                                        <i class="fa fa-tint" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-down" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-left" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-right" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-up" aria-hidden="true"></i>
                                        <i class="fa fa-trademark" aria-hidden="true"></i>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        <i class="fa fa-tree" aria-hidden="true"></i>
                                        <i class="fa fa-trophy" aria-hidden="true"></i>
                                        <i class="fa fa-truck" aria-hidden="true"></i>
                                        <i class="fa fa-tty" aria-hidden="true"></i>
                                        <i class="fa fa-tv" aria-hidden="true"></i>
                                        <i class="fa fa-umbrella" aria-hidden="true"></i>
                                        <i class="fa fa-universal-access" aria-hidden="true"></i>
                                        <i class="fa fa-university" aria-hidden="true"></i>
                                        <i class="fa fa-unlock" aria-hidden="true"></i>
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                        <i class="fa fa-unsorted" aria-hidden="true"></i>
                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-user-o" aria-hidden="true"></i>
                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                        <i class="fa fa-user-secret" aria-hidden="true"></i>
                                        <i class="fa fa-user-times" aria-hidden="true"></i>
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                        <i class="fa fa-vcard" aria-hidden="true"></i>
                                        <i class="fa fa-vcard-o" aria-hidden="true"></i>
                                        <i class="fa fa-video-camera" aria-hidden="true"></i>
                                        <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                        <i class="fa fa-volume-down" aria-hidden="true"></i>
                                        <i class="fa fa-volume-off" aria-hidden="true"></i>
                                        <i class="fa fa-volume-up" aria-hidden="true"></i>
                                        <i class="fa fa-warning" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair-alt" aria-hidden="true"></i>
                                        <i class="fa fa-wifi" aria-hidden="true"></i>
                                        <i class="fa fa-window-close" aria-hidden="true"></i>
                                        <i class="fa fa-window-close-o" aria-hidden="true"></i>
                                        <i class="fa fa-window-maximize" aria-hidden="true"></i>
                                        <i class="fa fa-window-minimize" aria-hidden="true"></i>
                                        <i class="fa fa-window-restore" aria-hidden="true"></i>
                                        <i class="fa fa-wrench" aria-hidden="true"></i>
                                        <i class="fa fa-hand-grab-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-lizard-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-left" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-hand-paper-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-peace-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-rock-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-scissors-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-spock-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-stop-o" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        <i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i>
                                        <i class="fa fa-asl-interpreting" aria-hidden="true"></i>
                                        <i class="fa fa-assistive-listening-systems" aria-hidden="true"></i>
                                        <i class="fa fa-audio-description" aria-hidden="true"></i>
                                        <i class="fa fa-blind" aria-hidden="true"></i>
                                        <i class="fa fa-braille" aria-hidden="true"></i>
                                        <i class="fa fa-cc" aria-hidden="true"></i>
                                        <i class="fa fa-deaf" aria-hidden="true"></i>
                                        <i class="fa fa-deafness" aria-hidden="true"></i>
                                        <i class="fa fa-hard-of-hearing" aria-hidden="true"></i>
                                        <i class="fa fa-low-vision" aria-hidden="true"></i>
                                        <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-sign-language" aria-hidden="true"></i>
                                        <i class="fa fa-signing" aria-hidden="true"></i>
                                        <i class="fa fa-tty" aria-hidden="true"></i>
                                        <i class="fa fa-universal-access" aria-hidden="true"></i>
                                        <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair-alt" aria-hidden="true"></i>
                                        <i class="fa fa-ambulance" aria-hidden="true"></i>
                                        <i class="fa fa-automobile" aria-hidden="true"></i>
                                        <i class="fa fa-bicycle" aria-hidden="true"></i>
                                        <i class="fa fa-bus" aria-hidden="true"></i>
                                        <i class="fa fa-cab" aria-hidden="true"></i>
                                        <i class="fa fa-car" aria-hidden="true"></i>
                                        <i class="fa fa-fighter-jet" aria-hidden="true"></i>
                                        <i class="fa fa-motorcycle" aria-hidden="true"></i>
                                        <i class="fa fa-plane" aria-hidden="true"></i>
                                        <i class="fa fa-rocket" aria-hidden="true"></i>
                                        <i class="fa fa-ship" aria-hidden="true"></i>
                                        <i class="fa fa-space-shuttle" aria-hidden="true"></i>
                                        <i class="fa fa-subway" aria-hidden="true"></i>
                                        <i class="fa fa-taxi" aria-hidden="true"></i>
                                        <i class="fa fa-train" aria-hidden="true"></i>
                                        <i class="fa fa-truck" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair-alt" aria-hidden="true"></i>
                                        <i class="fa fa-genderless" aria-hidden="true"></i>
                                        <i class="fa fa-intersex" aria-hidden="true"></i>
                                        <i class="fa fa-mars" aria-hidden="true"></i>
                                        <i class="fa fa-mars-double" aria-hidden="true"></i>
                                        <i class="fa fa-mars-stroke" aria-hidden="true"></i>
                                        <i class="fa fa-mars-stroke-h" aria-hidden="true"></i>
                                        <i class="fa fa-mars-stroke-v" aria-hidden="true"></i>
                                        <i class="fa fa-mercury" aria-hidden="true"></i>
                                        <i class="fa fa-neuter" aria-hidden="true"></i>
                                        <i class="fa fa-transgender" aria-hidden="true"></i>
                                        <i class="fa fa-transgender-alt" aria-hidden="true"></i>
                                        <i class="fa fa-venus" aria-hidden="true"></i>
                                        <i class="fa fa-venus-double" aria-hidden="true"></i>
                                        <i class="fa fa-venus-mars" aria-hidden="true"></i>
                                        <i class="fa fa-file" aria-hidden="true"></i>
                                        <i class="fa fa-file-archive-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-audio-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-code-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-movie-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-photo-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-picture-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-sound-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                        <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-video-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-word-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-zip-o" aria-hidden="true"></i>
                                        <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                        <i class="fa fa-gear" aria-hidden="true"></i>
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                        <i class="fa fa-spinner" aria-hidden="true"></i>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                        <i class="fa fa-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-minus-square" aria-hidden="true"></i>
                                        <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-square" aria-hidden="true"></i>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-cc-amex" aria-hidden="true"></i>
                                        <i class="fa fa-cc-diners-club" aria-hidden="true"></i>
                                        <i class="fa fa-cc-discover" aria-hidden="true"></i>
                                        <i class="fa fa-cc-jcb" aria-hidden="true"></i>
                                        <i class="fa fa-cc-mastercard" aria-hidden="true"></i>
                                        <i class="fa fa-cc-paypal" aria-hidden="true"></i>
                                        <i class="fa fa-cc-stripe" aria-hidden="true"></i>
                                        <i class="fa fa-cc-visa" aria-hidden="true"></i>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                                        <i class="fa fa-google-wallet" aria-hidden="true"></i>
                                        <i class="fa fa-paypal" aria-hidden="true"></i>
                                        <i class="fa fa-area-chart" aria-hidden="true"></i>
                                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                        <i class="fa fa-bar-chart-o" aria-hidden="true"></i>
                                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                                        <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                        <i class="fa fa-bitcoin" aria-hidden="true"></i>
                                        <i class="fa fa-btc" aria-hidden="true"></i>
                                        <i class="fa fa-cny" aria-hidden="true"></i>
                                        <i class="fa fa-dollar" aria-hidden="true"></i>
                                        <i class="fa fa-eur" aria-hidden="true"></i>
                                        <i class="fa fa-euro" aria-hidden="true"></i>
                                        <i class="fa fa-gbp" aria-hidden="true"></i>
                                        <i class="fa fa-gg" aria-hidden="true"></i>
                                        <i class="fa fa-gg-circle" aria-hidden="true"></i>
                                        <i class="fa fa-ils" aria-hidden="true"></i>
                                        <i class="fa fa-inr" aria-hidden="true"></i>
                                        <i class="fa fa-jpy" aria-hidden="true"></i>
                                        <i class="fa fa-krw" aria-hidden="true"></i>
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                        <i class="fa fa-rmb" aria-hidden="true"></i>
                                        <i class="fa fa-rouble" aria-hidden="true"></i>
                                        <i class="fa fa-rub" aria-hidden="true"></i>
                                        <i class="fa fa-ruble" aria-hidden="true"></i>
                                        <i class="fa fa-rupee" aria-hidden="true"></i>
                                        <i class="fa fa-shekel" aria-hidden="true"></i>
                                        <i class="fa fa-sheqel" aria-hidden="true"></i>
                                        <i class="fa fa-try" aria-hidden="true"></i>
                                        <i class="fa fa-turkish-lira" aria-hidden="true"></i>
                                        <i class="fa fa-usd" aria-hidden="true"></i>
                                        <i class="fa fa-won" aria-hidden="true"></i>
                                        <i class="fa fa-yen" aria-hidden="true"></i>
                                        <i class="fa fa-align-center" aria-hidden="true"></i>
                                        <i class="fa fa-align-justify" aria-hidden="true"></i>
                                        <i class="fa fa-align-left" aria-hidden="true"></i>
                                        <i class="fa fa-align-right" aria-hidden="true"></i>
                                        <i class="fa fa-bold" aria-hidden="true"></i>
                                        <i class="fa fa-chain" aria-hidden="true"></i>
                                        <i class="fa fa-chain-broken" aria-hidden="true"></i>
                                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                                        <i class="fa fa-columns" aria-hidden="true"></i>
                                        <i class="fa fa-copy" aria-hidden="true"></i>
                                        <i class="fa fa-cut" aria-hidden="true"></i>
                                        <i class="fa fa-dedent" aria-hidden="true"></i>
                                        <i class="fa fa-eraser" aria-hidden="true"></i>
                                        <i class="fa fa-file" aria-hidden="true"></i>
                                        <i class="fa fa-file-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                        <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                        <i class="fa fa-font" aria-hidden="true"></i>
                                        <i class="fa fa-header" aria-hidden="true"></i>
                                        <i class="fa fa-indent" aria-hidden="true"></i>
                                        <i class="fa fa-italic" aria-hidden="true"></i>
                                        <i class="fa fa-link" aria-hidden="true"></i>
                                        <i class="fa fa-list" aria-hidden="true"></i>
                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                                        <i class="fa fa-list-ul" aria-hidden="true"></i>
                                        <i class="fa fa-outdent" aria-hidden="true"></i>
                                        <i class="fa fa-paperclip" aria-hidden="true"></i>
                                        <i class="fa fa-paragraph" aria-hidden="true"></i>
                                        <i class="fa fa-paste" aria-hidden="true"></i>
                                        <i class="fa fa-repeat" aria-hidden="true"></i>
                                        <i class="fa fa-rotate-left" aria-hidden="true"></i>
                                        <i class="fa fa-rotate-right" aria-hidden="true"></i>
                                        <i class="fa fa-save" aria-hidden="true"></i>
                                        <i class="fa fa-scissors" aria-hidden="true"></i>
                                        <i class="fa fa-strikethrough" aria-hidden="true"></i>
                                        <i class="fa fa-subscript" aria-hidden="true"></i>
                                        <i class="fa fa-superscript" aria-hidden="true"></i>
                                        <i class="fa fa-table" aria-hidden="true"></i>
                                        <i class="fa fa-text-height" aria-hidden="true"></i>
                                        <i class="fa fa-text-width" aria-hidden="true"></i>
                                        <i class="fa fa-th" aria-hidden="true"></i>
                                        <i class="fa fa-th-large" aria-hidden="true"></i>
                                        <i class="fa fa-th-list" aria-hidden="true"></i>
                                        <i class="fa fa-underline" aria-hidden="true"></i>
                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                        <i class="fa fa-unlink" aria-hidden="true"></i>
                                        <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                                        <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                                        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                        <i class="fa fa-angle-double-up" aria-hidden="true"></i>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                        <i class="fa fa-arrows" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-h" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-v" aria-hidden="true"></i>
                                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        <i class="fa fa-caret-left" aria-hidden="true"></i>
                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-left" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-right" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                        <i class="fa fa-exchange" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-left" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-long-arrow-down" aria-hidden="true"></i>
                                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                        <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-down" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-left" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-right" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-up" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                                        <i class="fa fa-backward" aria-hidden="true"></i>
                                        <i class="fa fa-compress" aria-hidden="true"></i>
                                        <i class="fa fa-eject" aria-hidden="true"></i>
                                        <i class="fa fa-expand" aria-hidden="true"></i>
                                        <i class="fa fa-fast-backward" aria-hidden="true"></i>
                                        <i class="fa fa-fast-forward" aria-hidden="true"></i>
                                        <i class="fa fa-forward" aria-hidden="true"></i>
                                        <i class="fa fa-pause" aria-hidden="true"></i>
                                        <i class="fa fa-pause-circle" aria-hidden="true"></i>
                                        <i class="fa fa-pause-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                                        <i class="fa fa-play-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-random" aria-hidden="true"></i>
                                        <i class="fa fa-step-backward" aria-hidden="true"></i>
                                        <i class="fa fa-step-forward" aria-hidden="true"></i>
                                        <i class="fa fa-stop" aria-hidden="true"></i>
                                        <i class="fa fa-stop-circle" aria-hidden="true"></i>
                                        <i class="fa fa-stop-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                        <i class="fa fa-500px" aria-hidden="true"></i>
                                        <i class="fa fa-adn" aria-hidden="true"></i>
                                        <i class="fa fa-amazon" aria-hidden="true"></i>
                                        <i class="fa fa-android" aria-hidden="true"></i>
                                        <i class="fa fa-angellist" aria-hidden="true"></i>
                                        <i class="fa fa-apple" aria-hidden="true"></i>
                                        <i class="fa fa-bandcamp" aria-hidden="true"></i>
                                        <i class="fa fa-behance" aria-hidden="true"></i>
                                        <i class="fa fa-behance-square" aria-hidden="true"></i>
                                        <i class="fa fa-bitbucket" aria-hidden="true"></i>
                                        <i class="fa fa-bitbucket-square" aria-hidden="true"></i>
                                        <i class="fa fa-bitcoin" aria-hidden="true"></i>
                                        <i class="fa fa-black-tie" aria-hidden="true"></i>
                                        <i class="fa fa-bluetooth" aria-hidden="true"></i>
                                        <i class="fa fa-bluetooth-b" aria-hidden="true"></i>
                                        <i class="fa fa-btc" aria-hidden="true"></i>
                                        <i class="fa fa-buysellads" aria-hidden="true"></i>
                                        <i class="fa fa-cc-amex" aria-hidden="true"></i>
                                        <i class="fa fa-cc-diners-club" aria-hidden="true"></i>
                                        <i class="fa fa-cc-discover" aria-hidden="true"></i>
                                        <i class="fa fa-cc-jcb" aria-hidden="true"></i>
                                        <i class="fa fa-cc-mastercard" aria-hidden="true"></i>
                                        <i class="fa fa-cc-paypal" aria-hidden="true"></i>
                                        <i class="fa fa-cc-stripe" aria-hidden="true"></i>
                                        <i class="fa fa-cc-visa" aria-hidden="true"></i>
                                        <i class="fa fa-chrome" aria-hidden="true"></i>
                                        <i class="fa fa-codepen" aria-hidden="true"></i>
                                        <i class="fa fa-codiepie" aria-hidden="true"></i>
                                        <i class="fa fa-connectdevelop" aria-hidden="true"></i>
                                        <i class="fa fa-contao" aria-hidden="true"></i>
                                        <i class="fa fa-css3" aria-hidden="true"></i>
                                        <i class="fa fa-dashcube" aria-hidden="true"></i>
                                        <i class="fa fa-delicious" aria-hidden="true"></i>
                                        <i class="fa fa-deviantart" aria-hidden="true"></i>
                                        <i class="fa fa-digg" aria-hidden="true"></i>
                                        <i class="fa fa-dribbble" aria-hidden="true"></i>
                                        <i class="fa fa-dropbox" aria-hidden="true"></i>
                                        <i class="fa fa-drupal" aria-hidden="true"></i>
                                        <i class="fa fa-edge" aria-hidden="true"></i>
                                        <i class="fa fa-eercast" aria-hidden="true"></i>
                                        <i class="fa fa-empire" aria-hidden="true"></i>
                                        <i class="fa fa-envira" aria-hidden="true"></i>
                                        <i class="fa fa-etsy" aria-hidden="true"></i>
                                        <i class="fa fa-expeditedssl" aria-hidden="true"></i>
                                        <i class="fa fa-fa" aria-hidden="true"></i>
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                        <i class="fa fa-facebook-f" aria-hidden="true"></i>
                                        <i class="fa fa-facebook-official" aria-hidden="true"></i>
                                        <i class="fa fa-facebook-square" aria-hidden="true"></i>
                                        <i class="fa fa-firefox" aria-hidden="true"></i>
                                        <i class="fa fa-first-order" aria-hidden="true"></i>
                                        <i class="fa fa-flickr" aria-hidden="true"></i>
                                        <i class="fa fa-font-awesome" aria-hidden="true"></i>
                                        <i class="fa fa-fonticons" aria-hidden="true"></i>
                                        <i class="fa fa-fort-awesome" aria-hidden="true"></i>
                                        <i class="fa fa-forumbee" aria-hidden="true"></i>
                                        <i class="fa fa-foursquare" aria-hidden="true"></i>
                                        <i class="fa fa-free-code-camp" aria-hidden="true"></i>
                                        <i class="fa fa-ge" aria-hidden="true"></i>
                                        <i class="fa fa-get-pocket" aria-hidden="true"></i>
                                        <i class="fa fa-gg" aria-hidden="true"></i>
                                        <i class="fa fa-gg-circle" aria-hidden="true"></i>
                                        <i class="fa fa-git" aria-hidden="true"></i>
                                        <i class="fa fa-git-square" aria-hidden="true"></i>
                                        <i class="fa fa-github" aria-hidden="true"></i>
                                        <i class="fa fa-github-alt" aria-hidden="true"></i>
                                        <i class="fa fa-github-square" aria-hidden="true"></i>
                                        <i class="fa fa-gitlab" aria-hidden="true"></i>
                                        <i class="fa fa-gittip" aria-hidden="true"></i>
                                        <i class="fa fa-glide" aria-hidden="true"></i>
                                        <i class="fa fa-glide-g" aria-hidden="true"></i>
                                        <i class="fa fa-google" aria-hidden="true"></i>
                                        <i class="fa fa-google-plus" aria-hidden="true"></i>
                                        <i class="fa fa-google-plus-circle" aria-hidden="true"></i>
                                        <i class="fa fa-google-plus-official" aria-hidden="true"></i>
                                        <i class="fa fa-google-plus-square" aria-hidden="true"></i>
                                        <i class="fa fa-google-wallet" aria-hidden="true"></i>
                                        <i class="fa fa-gratipay" aria-hidden="true"></i>
                                        <i class="fa fa-grav" aria-hidden="true"></i>
                                        <i class="fa fa-hacker-news" aria-hidden="true"></i>
                                        <i class="fa fa-houzz" aria-hidden="true"></i>
                                        <i class="fa fa-html5" aria-hidden="true"></i>
                                        <i class="fa fa-imdb" aria-hidden="true"></i>
                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                        <i class="fa fa-internet-explorer" aria-hidden="true"></i>
                                        <i class="fa fa-ioxhost" aria-hidden="true"></i>
                                        <i class="fa fa-joomla" aria-hidden="true"></i>
                                        <i class="fa fa-jsfiddle" aria-hidden="true"></i>
                                        <i class="fa fa-lastfm" aria-hidden="true"></i>
                                        <i class="fa fa-lastfm-square" aria-hidden="true"></i>
                                        <i class="fa fa-leanpub" aria-hidden="true"></i>
                                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                                        <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                                        <i class="fa fa-linode" aria-hidden="true"></i>
                                        <i class="fa fa-linux" aria-hidden="true"></i>
                                        <i class="fa fa-maxcdn" aria-hidden="true"></i>
                                        <i class="fa fa-meanpath" aria-hidden="true"></i>
                                        <i class="fa fa-medium" aria-hidden="true"></i>
                                        <i class="fa fa-meetup" aria-hidden="true"></i>
                                        <i class="fa fa-mixcloud" aria-hidden="true"></i>
                                        <i class="fa fa-modx" aria-hidden="true"></i>
                                        <i class="fa fa-odnoklassniki" aria-hidden="true"></i>
                                        <i class="fa fa-odnoklassniki-square" aria-hidden="true"></i>
                                        <i class="fa fa-opencart" aria-hidden="true"></i>
                                        <i class="fa fa-openid" aria-hidden="true"></i>
                                        <i class="fa fa-opera" aria-hidden="true"></i>
                                        <i class="fa fa-optin-monster" aria-hidden="true"></i>
                                        <i class="fa fa-pagelines" aria-hidden="true"></i>
                                        <i class="fa fa-paypal" aria-hidden="true"></i>
                                        <i class="fa fa-pied-piper" aria-hidden="true"></i>
                                        <i class="fa fa-pied-piper-alt" aria-hidden="true"></i>
                                        <i class="fa fa-pied-piper-pp" aria-hidden="true"></i>
                                        <i class="fa fa-pinterest" aria-hidden="true"></i>
                                        <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                        <i class="fa fa-pinterest-square" aria-hidden="true"></i>
                                        <i class="fa fa-product-hunt" aria-hidden="true"></i>
                                        <i class="fa fa-qq" aria-hidden="true"></i>
                                        <i class="fa fa-quora" aria-hidden="true"></i>
                                        <i class="fa fa-ra" aria-hidden="true"></i>
                                        <i class="fa fa-ravelry" aria-hidden="true"></i>
                                        <i class="fa fa-rebel" aria-hidden="true"></i>
                                        <i class="fa fa-reddit" aria-hidden="true"></i>
                                        <i class="fa fa-reddit-alien" aria-hidden="true"></i>
                                        <i class="fa fa-reddit-square" aria-hidden="true"></i>
                                        <i class="fa fa-renren" aria-hidden="true"></i>
                                        <i class="fa fa-resistance" aria-hidden="true"></i>
                                        <i class="fa fa-safari" aria-hidden="true"></i>
                                        <i class="fa fa-scribd" aria-hidden="true"></i>
                                        <i class="fa fa-sellsy" aria-hidden="true"></i>
                                        <i class="fa fa-share-alt" aria-hidden="true"></i>
                                        <i class="fa fa-share-alt-square" aria-hidden="true"></i>
                                        <i class="fa fa-shirtsinbulk" aria-hidden="true"></i>
                                        <i class="fa fa-simplybuilt" aria-hidden="true"></i>
                                        <i class="fa fa-skyatlas" aria-hidden="true"></i>
                                        <i class="fa fa-skype" aria-hidden="true"></i>
                                        <i class="fa fa-slack" aria-hidden="true"></i>
                                        <i class="fa fa-slideshare" aria-hidden="true"></i>
                                        <i class="fa fa-snapchat" aria-hidden="true"></i>
                                        <i class="fa fa-snapchat-ghost" aria-hidden="true"></i>
                                        <i class="fa fa-snapchat-square" aria-hidden="true"></i>
                                        <i class="fa fa-soundcloud" aria-hidden="true"></i>
                                        <i class="fa fa-spotify" aria-hidden="true"></i>
                                        <i class="fa fa-stack-exchange" aria-hidden="true"></i>
                                        <i class="fa fa-stack-overflow" aria-hidden="true"></i>
                                        <i class="fa fa-steam" aria-hidden="true"></i>
                                        <i class="fa fa-steam-square" aria-hidden="true"></i>
                                        <i class="fa fa-stumbleupon" aria-hidden="true"></i>
                                        <i class="fa fa-stumbleupon-circle" aria-hidden="true"></i>
                                        <i class="fa fa-superpowers" aria-hidden="true"></i>
                                        <i class="fa fa-telegram" aria-hidden="true"></i>
                                        <i class="fa fa-tencent-weibo" aria-hidden="true"></i>
                                        <i class="fa fa-themeisle" aria-hidden="true"></i>
                                        <i class="fa fa-trello" aria-hidden="true"></i>
                                        <i class="fa fa-tripadvisor" aria-hidden="true"></i>
                                        <i class="fa fa-tumblr" aria-hidden="true"></i>
                                        <i class="fa fa-tumblr-square" aria-hidden="true"></i>
                                        <i class="fa fa-twitch" aria-hidden="true"></i>
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                        <i class="fa fa-twitter-square" aria-hidden="true"></i>
                                        <i class="fa fa-usb" aria-hidden="true"></i>
                                        <i class="fa fa-viacoin" aria-hidden="true"></i>
                                        <i class="fa fa-viadeo" aria-hidden="true"></i>
                                        <i class="fa fa-viadeo-square" aria-hidden="true"></i>
                                        <i class="fa fa-vimeo" aria-hidden="true"></i>
                                        <i class="fa fa-vimeo-square" aria-hidden="true"></i>
                                        <i class="fa fa-vine" aria-hidden="true"></i>
                                        <i class="fa fa-vk" aria-hidden="true"></i>
                                        <i class="fa fa-wechat" aria-hidden="true"></i>
                                        <i class="fa fa-weibo" aria-hidden="true"></i>
                                        <i class="fa fa-weixin" aria-hidden="true"></i>
                                        <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                        <i class="fa fa-wikipedia-w" aria-hidden="true"></i>
                                        <i class="fa fa-windows" aria-hidden="true"></i>
                                        <i class="fa fa-wordpress" aria-hidden="true"></i>
                                        <i class="fa fa-wpbeginner" aria-hidden="true"></i>
                                        <i class="fa fa-wpexplorer" aria-hidden="true"></i>
                                        <i class="fa fa-wpforms" aria-hidden="true"></i>
                                        <i class="fa fa-xing" aria-hidden="true"></i>
                                        <i class="fa fa-xing-square" aria-hidden="true"></i>
                                        <i class="fa fa-y-combinator" aria-hidden="true"></i>
                                        <i class="fa fa-y-combinator-square" aria-hidden="true"></i>
                                        <i class="fa fa-yahoo" aria-hidden="true"></i>
                                        <i class="fa fa-yc" aria-hidden="true"></i>
                                        <i class="fa fa-yc-square" aria-hidden="true"></i>
                                        <i class="fa fa-yelp" aria-hidden="true"></i>
                                        <i class="fa fa-yoast" aria-hidden="true"></i>
                                        <i class="fa fa-youtube" aria-hidden="true"></i>
                                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                        <i class="fa fa-youtube-square" aria-hidden="true"></i>
                                        <i class="fa fa-ambulance" aria-hidden="true"></i>
                                        <i class="fa fa-h-square" aria-hidden="true"></i>
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        <i class="fa fa-heartbeat" aria-hidden="true"></i>
                                        <i class="fa fa-hospital-o" aria-hidden="true"></i>
                                        <i class="fa fa-medkit" aria-hidden="true"></i>
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                        <i class="fa fa-stethoscope" aria-hidden="true"></i>
                                        <i class="fa fa-user-md" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair-alt" aria-hidden="true"></i>
                                        <i class="fa fa-address-book" aria-hidden="true"></i>
                                        <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                        <i class="fa fa-address-card" aria-hidden="true"></i>
                                        <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                        <i class="fa fa-bandcamp" aria-hidden="true"></i>
                                        <i class="fa fa-bath" aria-hidden="true"></i>
                                        <i class="fa fa-bathtub" aria-hidden="true"></i>
                                        <i class="fa fa-drivers-license" aria-hidden="true"></i>
                                        <i class="fa fa-drivers-license-o" aria-hidden="true"></i>
                                        <i class="fa fa-eercast" aria-hidden="true"></i>
                                        <i class="fa fa-envelope-open" aria-hidden="true"></i>
                                        <i class="fa fa-envelope-open-o" aria-hidden="true"></i>
                                        <i class="fa fa-etsy" aria-hidden="true"></i>
                                        <i class="fa fa-free-code-camp" aria-hidden="true"></i>
                                        <i class="fa fa-grav" aria-hidden="true"></i>
                                        <i class="fa fa-handshake-o" aria-hidden="true"></i>
                                        <i class="fa fa-id-badge" aria-hidden="true"></i>
                                        <i class="fa fa-id-card" aria-hidden="true"></i>
                                        <i class="fa fa-id-card-o" aria-hidden="true"></i>
                                        <i class="fa fa-imdb" aria-hidden="true"></i>
                                        <i class="fa fa-linode" aria-hidden="true"></i>
                                        <i class="fa fa-meetup" aria-hidden="true"></i>
                                        <i class="fa fa-microchip" aria-hidden="true"></i>
                                        <i class="fa fa-podcast" aria-hidden="true"></i>
                                        <i class="fa fa-quora" aria-hidden="true"></i>
                                        <i class="fa fa-ravelry" aria-hidden="true"></i>
                                        <i class="fa fa-s15" aria-hidden="true"></i>
                                        <i class="fa fa-shower" aria-hidden="true"></i>
                                        <i class="fa fa-snowflake-o" aria-hidden="true"></i>
                                        <i class="fa fa-superpowers" aria-hidden="true"></i>
                                        <i class="fa fa-telegram" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-0" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-1" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-2" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-3" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-4" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-empty" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-full" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-half" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-quarter" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-three-quarters" aria-hidden="true"></i>
                                        <i class="fa fa-times-rectangle" aria-hidden="true"></i>
                                        <i class="fa fa-times-rectangle-o" aria-hidden="true"></i>
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-user-o" aria-hidden="true"></i>
                                        <i class="fa fa-vcard" aria-hidden="true"></i>
                                        <i class="fa fa-vcard-o" aria-hidden="true"></i>
                                        <i class="fa fa-window-close" aria-hidden="true"></i>
                                        <i class="fa fa-window-close-o" aria-hidden="true"></i>
                                        <i class="fa fa-window-maximize" aria-hidden="true"></i>
                                        <i class="fa fa-window-minimize" aria-hidden="true"></i>
                                        <i class="fa fa-window-restore" aria-hidden="true"></i>
                                        <i class="fa fa-wpexplorer" aria-hidden="true"></i>
                                        <i class="fa fa-address-book" aria-hidden="true"></i>
                                        <i class="fa fa-address-book-o" aria-hidden="true"></i>
                                        <i class="fa fa-address-card" aria-hidden="true"></i>
                                        <i class="fa fa-address-card-o" aria-hidden="true"></i>
                                        <i class="fa fa-adjust" aria-hidden="true"></i>
                                        <i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i>
                                        <i class="fa fa-anchor" aria-hidden="true"></i>
                                        <i class="fa fa-archive" aria-hidden="true"></i>
                                        <i class="fa fa-area-chart" aria-hidden="true"></i>
                                        <i class="fa fa-arrows" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-h" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-v" aria-hidden="true"></i>
                                        <i class="fa fa-asl-interpreting" aria-hidden="true"></i>
                                        <i class="fa fa-assistive-listening-systems" aria-hidden="true"></i>
                                        <i class="fa fa-asterisk" aria-hidden="true"></i>
                                        <i class="fa fa-at" aria-hidden="true"></i>
                                        <i class="fa fa-audio-description" aria-hidden="true"></i>
                                        <i class="fa fa-automobile" aria-hidden="true"></i>
                                        <i class="fa fa-balance-scale" aria-hidden="true"></i>
                                        <i class="fa fa-ban" aria-hidden="true"></i>
                                        <i class="fa fa-bank" aria-hidden="true"></i>
                                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                        <i class="fa fa-bar-chart-o" aria-hidden="true"></i>
                                        <i class="fa fa-barcode" aria-hidden="true"></i>
                                        <i class="fa fa-bars" aria-hidden="true"></i>
                                        <i class="fa fa-bath" aria-hidden="true"></i>
                                        <i class="fa fa-bathtub" aria-hidden="true"></i>
                                        <i class="fa fa-battery" aria-hidden="true"></i>
                                        <i class="fa fa-battery-0" aria-hidden="true"></i>
                                        <i class="fa fa-battery-1" aria-hidden="true"></i>
                                        <i class="fa fa-battery-2" aria-hidden="true"></i>
                                        <i class="fa fa-battery-3" aria-hidden="true"></i>
                                        <i class="fa fa-battery-4" aria-hidden="true"></i>
                                        <i class="fa fa-battery-empty" aria-hidden="true"></i>
                                        <i class="fa fa-battery-full" aria-hidden="true"></i>
                                        <i class="fa fa-battery-half" aria-hidden="true"></i>
                                        <i class="fa fa-battery-quarter" aria-hidden="true"></i>
                                        <i class="fa fa-battery-three-quarters" aria-hidden="true"></i>
                                        <i class="fa fa-bed" aria-hidden="true"></i>
                                        <i class="fa fa-beer" aria-hidden="true"></i>
                                        <i class="fa fa-bell" aria-hidden="true"></i>
                                        <i class="fa fa-bell-o" aria-hidden="true"></i>
                                        <i class="fa fa-bell-slash" aria-hidden="true"></i>
                                        <i class="fa fa-bell-slash-o" aria-hidden="true"></i>
                                        <i class="fa fa-bicycle" aria-hidden="true"></i>
                                        <i class="fa fa-binoculars" aria-hidden="true"></i>
                                        <i class="fa fa-birthday-cake" aria-hidden="true"></i>
                                        <i class="fa fa-blind" aria-hidden="true"></i>
                                        <i class="fa fa-bluetooth" aria-hidden="true"></i>
                                        <i class="fa fa-bluetooth-b" aria-hidden="true"></i>
                                        <i class="fa fa-bolt" aria-hidden="true"></i>
                                        <i class="fa fa-bomb" aria-hidden="true"></i>
                                        <i class="fa fa-book" aria-hidden="true"></i>
                                        <i class="fa fa-bookmark" aria-hidden="true"></i>
                                        <i class="fa fa-bookmark-o" aria-hidden="true"></i>
                                        <i class="fa fa-braille" aria-hidden="true"></i>
                                        <i class="fa fa-briefcase" aria-hidden="true"></i>
                                        <i class="fa fa-bug" aria-hidden="true"></i>
                                        <i class="fa fa-building" aria-hidden="true"></i>
                                        <i class="fa fa-building-o" aria-hidden="true"></i>
                                        <i class="fa fa-bullhorn" aria-hidden="true"></i>
                                        <i class="fa fa-bullseye" aria-hidden="true"></i>
                                        <i class="fa fa-bus" aria-hidden="true"></i>
                                        <i class="fa fa-cab" aria-hidden="true"></i>
                                        <i class="fa fa-calculator" aria-hidden="true"></i>
                                        <i class="fa fa-calendar" aria-hidden="true"></i>
                                        <i class="fa fa-calendar-check-o" aria-hidden="true"></i>
                                        <i class="fa fa-calendar-minus-o" aria-hidden="true"></i>
                                        <i class="fa fa-calendar-o" aria-hidden="true"></i>
                                        <i class="fa fa-calendar-plus-o" aria-hidden="true"></i>
                                        <i class="fa fa-calendar-times-o" aria-hidden="true"></i>
                                        <i class="fa fa-camera" aria-hidden="true"></i>
                                        <i class="fa fa-camera-retro" aria-hidden="true"></i>
                                        <i class="fa fa-car" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-left" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-right" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-cart-arrow-down" aria-hidden="true"></i>
                                        <i class="fa fa-cart-plus" aria-hidden="true"></i>
                                        <i class="fa fa-cc" aria-hidden="true"></i>
                                        <i class="fa fa-certificate" aria-hidden="true"></i>
                                        <i class="fa fa-check" aria-hidden="true"></i>
                                        <i class="fa fa-check-circle" aria-hidden="true"></i>
                                        <i class="fa fa-check-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-child" aria-hidden="true"></i>
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                        <i class="fa fa-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-circle-o-notch" aria-hidden="true"></i>
                                        <i class="fa fa-circle-thin" aria-hidden="true"></i>
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        <i class="fa fa-clone" aria-hidden="true"></i>
                                        <i class="fa fa-close" aria-hidden="true"></i>
                                        <i class="fa fa-cloud" aria-hidden="true"></i>
                                        <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                        <i class="fa fa-cloud-upload" aria-hidden="true"></i>
                                        <i class="fa fa-code" aria-hidden="true"></i>
                                        <i class="fa fa-code-fork" aria-hidden="true"></i>
                                        <i class="fa fa-coffee" aria-hidden="true"></i>
                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                        <i class="fa fa-comment" aria-hidden="true"></i>
                                        <i class="fa fa-comment-o" aria-hidden="true"></i>
                                        <i class="fa fa-commenting" aria-hidden="true"></i>
                                        <i class="fa fa-commenting-o" aria-hidden="true"></i>
                                        <i class="fa fa-comments" aria-hidden="true"></i>
                                        <i class="fa fa-comments-o" aria-hidden="true"></i>
                                        <i class="fa fa-compass" aria-hidden="true"></i>
                                        <i class="fa fa-copyright" aria-hidden="true"></i>
                                        <i class="fa fa-creative-commons" aria-hidden="true"></i>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                                        <i class="fa fa-crop" aria-hidden="true"></i>
                                        <i class="fa fa-crosshairs" aria-hidden="true"></i>
                                        <i class="fa fa-cube" aria-hidden="true"></i>
                                        <i class="fa fa-cubes" aria-hidden="true"></i>
                                        <i class="fa fa-cutlery" aria-hidden="true"></i>
                                        <i class="fa fa-dashboard" aria-hidden="true"></i>
                                        <i class="fa fa-database" aria-hidden="true"></i>
                                        <i class="fa fa-deaf" aria-hidden="true"></i>
                                        <i class="fa fa-deafness" aria-hidden="true"></i>
                                        <i class="fa fa-desktop" aria-hidden="true"></i>
                                        <i class="fa fa-diamond" aria-hidden="true"></i>
                                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-download" aria-hidden="true"></i>
                                        <i class="fa fa-drivers-license" aria-hidden="true"></i>
                                        <i class="fa fa-drivers-license-o" aria-hidden="true"></i>
                                        <i class="fa fa-edit" aria-hidden="true"></i>
                                        <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                        <i class="fa fa-envelope-open" aria-hidden="true"></i>
                                        <i class="fa fa-envelope-open-o" aria-hidden="true"></i>
                                        <i class="fa fa-envelope-square" aria-hidden="true"></i>
                                        <i class="fa fa-eraser" aria-hidden="true"></i>
                                        <i class="fa fa-exchange" aria-hidden="true"></i>
                                        <i class="fa fa-exclamation" aria-hidden="true"></i>
                                        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                                        <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>
                                        <i class="fa fa-external-link" aria-hidden="true"></i>
                                        <i class="fa fa-external-link-square" aria-hidden="true"></i>
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        <i class="fa fa-eye-slash" aria-hidden="true"></i>
                                        <i class="fa fa-eyedropper" aria-hidden="true"></i>
                                        <i class="fa fa-fax" aria-hidden="true"></i>
                                        <i class="fa fa-feed" aria-hidden="true"></i>
                                        <i class="fa fa-female" aria-hidden="true"></i>
                                        <i class="fa fa-fighter-jet" aria-hidden="true"></i>
                                        <i class="fa fa-file-archive-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-audio-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-code-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-movie-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-photo-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-picture-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-sound-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-video-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-word-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-zip-o" aria-hidden="true"></i>
                                        <i class="fa fa-film" aria-hidden="true"></i>
                                        <i class="fa fa-filter" aria-hidden="true"></i>
                                        <i class="fa fa-fire" aria-hidden="true"></i>
                                        <i class="fa fa-fire-extinguisher" aria-hidden="true"></i>
                                        <i class="fa fa-flag" aria-hidden="true"></i>
                                        <i class="fa fa-flag-checkered" aria-hidden="true"></i>
                                        <i class="fa fa-flag-o" aria-hidden="true"></i>
                                        <i class="fa fa-flash" aria-hidden="true"></i>
                                        <i class="fa fa-flask" aria-hidden="true"></i>
                                        <i class="fa fa-folder" aria-hidden="true"></i>
                                        <i class="fa fa-folder-o" aria-hidden="true"></i>
                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                        <i class="fa fa-folder-open-o" aria-hidden="true"></i>
                                        <i class="fa fa-frown-o" aria-hidden="true"></i>
                                        <i class="fa fa-futbol-o" aria-hidden="true"></i>
                                        <i class="fa fa-gamepad" aria-hidden="true"></i>
                                        <i class="fa fa-gavel" aria-hidden="true"></i>
                                        <i class="fa fa-gear" aria-hidden="true"></i>
                                        <i class="fa fa-gears" aria-hidden="true"></i>
                                        <i class="fa fa-gift" aria-hidden="true"></i>
                                        <i class="fa fa-glass" aria-hidden="true"></i>
                                        <i class="fa fa-globe" aria-hidden="true"></i>
                                        <i class="fa fa-graduation-cap" aria-hidden="true"></i>
                                        <i class="fa fa-group" aria-hidden="true"></i>
                                        <i class="fa fa-hand-grab-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-lizard-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-paper-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-peace-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-rock-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-scissors-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-spock-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-stop-o" aria-hidden="true"></i>
                                        <i class="fa fa-handshake-o" aria-hidden="true"></i>
                                        <i class="fa fa-hard-of-hearing" aria-hidden="true"></i>
                                        <i class="fa fa-hashtag" aria-hidden="true"></i>
                                        <i class="fa fa-hdd-o" aria-hidden="true"></i>
                                        <i class="fa fa-headphones" aria-hidden="true"></i>
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        <i class="fa fa-heartbeat" aria-hidden="true"></i>
                                        <i class="fa fa-history" aria-hidden="true"></i>
                                        <i class="fa fa-home" aria-hidden="true"></i>
                                        <i class="fa fa-hotel" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-1" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-2" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-3" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-end" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-half" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-o" aria-hidden="true"></i>
                                        <i class="fa fa-hourglass-start" aria-hidden="true"></i>
                                        <i class="fa fa-i-cursor" aria-hidden="true"></i>
                                        <i class="fa fa-id-badge" aria-hidden="true"></i>
                                        <i class="fa fa-id-card" aria-hidden="true"></i>
                                        <i class="fa fa-id-card-o" aria-hidden="true"></i>
                                        <i class="fa fa-image" aria-hidden="true"></i>
                                        <i class="fa fa-inbox" aria-hidden="true"></i>
                                        <i class="fa fa-industry" aria-hidden="true"></i>
                                        <i class="fa fa-info" aria-hidden="true"></i>
                                        <i class="fa fa-info-circle" aria-hidden="true"></i>
                                        <i class="fa fa-institution" aria-hidden="true"></i>
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                        <i class="fa fa-keyboard-o" aria-hidden="true"></i>
                                        <i class="fa fa-language" aria-hidden="true"></i>
                                        <i class="fa fa-laptop" aria-hidden="true"></i>
                                        <i class="fa fa-leaf" aria-hidden="true"></i>
                                        <i class="fa fa-legal" aria-hidden="true"></i>
                                        <i class="fa fa-lemon-o" aria-hidden="true"></i>
                                        <i class="fa fa-level-down" aria-hidden="true"></i>
                                        <i class="fa fa-level-up" aria-hidden="true"></i>
                                        <i class="fa fa-life-bouy" aria-hidden="true"></i>
                                        <i class="fa fa-life-buoy" aria-hidden="true"></i>
                                        <i class="fa fa-life-ring" aria-hidden="true"></i>
                                        <i class="fa fa-life-saver" aria-hidden="true"></i>
                                        <i class="fa fa-lightbulb-o" aria-hidden="true"></i>
                                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                                        <i class="fa fa-location-arrow" aria-hidden="true"></i>
                                        <i class="fa fa-lock" aria-hidden="true"></i>
                                        <i class="fa fa-low-vision" aria-hidden="true"></i>
                                        <i class="fa fa-magic" aria-hidden="true"></i>
                                        <i class="fa fa-magnet" aria-hidden="true"></i>
                                        <i class="fa fa-mail-forward" aria-hidden="true"></i>
                                        <i class="fa fa-mail-reply" aria-hidden="true"></i>
                                        <i class="fa fa-mail-reply-all" aria-hidden="true"></i>
                                        <i class="fa fa-male" aria-hidden="true"></i>
                                        <i class="fa fa-map" aria-hidden="true"></i>
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <i class="fa fa-map-o" aria-hidden="true"></i>
                                        <i class="fa fa-map-pin" aria-hidden="true"></i>
                                        <i class="fa fa-map-signs" aria-hidden="true"></i>
                                        <i class="fa fa-meh-o" aria-hidden="true"></i>
                                        <i class="fa fa-microchip" aria-hidden="true"></i>
                                        <i class="fa fa-microphone" aria-hidden="true"></i>
                                        <i class="fa fa-microphone-slash" aria-hidden="true"></i>
                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                        <i class="fa fa-minus-circle" aria-hidden="true"></i>
                                        <i class="fa fa-minus-square" aria-hidden="true"></i>
                                        <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-mobile" aria-hidden="true"></i>
                                        <i class="fa fa-mobile-phone" aria-hidden="true"></i>
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                        <i class="fa fa-moon-o" aria-hidden="true"></i>
                                        <i class="fa fa-mortar-board" aria-hidden="true"></i>
                                        <i class="fa fa-motorcycle" aria-hidden="true"></i>
                                        <i class="fa fa-mouse-pointer" aria-hidden="true"></i>
                                        <i class="fa fa-music" aria-hidden="true"></i>
                                        <i class="fa fa-navicon" aria-hidden="true"></i>
                                        <i class="fa fa-newspaper-o" aria-hidden="true"></i>
                                        <i class="fa fa-object-group" aria-hidden="true"></i>
                                        <i class="fa fa-object-ungroup" aria-hidden="true"></i>
                                        <i class="fa fa-paint-brush" aria-hidden="true"></i>
                                        <i class="fa fa-paper-plane" aria-hidden="true"></i>
                                        <i class="fa fa-paper-plane-o" aria-hidden="true"></i>
                                        <i class="fa fa-paw" aria-hidden="true"></i>
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-percent" aria-hidden="true"></i>
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <i class="fa fa-phone-square" aria-hidden="true"></i>
                                        <i class="fa fa-photo" aria-hidden="true"></i>
                                        <i class="fa fa-picture-o" aria-hidden="true"></i>
                                        <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                        <i class="fa fa-plane" aria-hidden="true"></i>
                                        <i class="fa fa-plug" aria-hidden="true"></i>
                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-podcast" aria-hidden="true"></i>
                                        <i class="fa fa-power-off" aria-hidden="true"></i>
                                        <i class="fa fa-print" aria-hidden="true"></i>
                                        <i class="fa fa-puzzle-piece" aria-hidden="true"></i>
                                        <i class="fa fa-qrcode" aria-hidden="true"></i>
                                        <i class="fa fa-question" aria-hidden="true"></i>
                                        <i class="fa fa-question-circle" aria-hidden="true"></i>
                                        <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-quote-left" aria-hidden="true"></i>
                                        <i class="fa fa-quote-right" aria-hidden="true"></i>
                                        <i class="fa fa-random" aria-hidden="true"></i>
                                        <i class="fa fa-recycle" aria-hidden="true"></i>
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                        <i class="fa fa-registered" aria-hidden="true"></i>
                                        <i class="fa fa-remove" aria-hidden="true"></i>
                                        <i class="fa fa-reorder" aria-hidden="true"></i>
                                        <i class="fa fa-reply" aria-hidden="true"></i>
                                        <i class="fa fa-reply-all" aria-hidden="true"></i>
                                        <i class="fa fa-retweet" aria-hidden="true"></i>
                                        <i class="fa fa-road" aria-hidden="true"></i>
                                        <i class="fa fa-rocket" aria-hidden="true"></i>
                                        <i class="fa fa-rss" aria-hidden="true"></i>
                                        <i class="fa fa-rss-square" aria-hidden="true"></i>
                                        <i class="fa fa-s15" aria-hidden="true"></i>
                                        <i class="fa fa-search" aria-hidden="true"></i>
                                        <i class="fa fa-search-minus" aria-hidden="true"></i>
                                        <i class="fa fa-search-plus" aria-hidden="true"></i>
                                        <i class="fa fa-send" aria-hidden="true"></i>
                                        <i class="fa fa-send-o" aria-hidden="true"></i>
                                        <i class="fa fa-server" aria-hidden="true"></i>
                                        <i class="fa fa-share" aria-hidden="true"></i>
                                        <i class="fa fa-share-alt" aria-hidden="true"></i>
                                        <i class="fa fa-share-alt-square" aria-hidden="true"></i>
                                        <i class="fa fa-share-square" aria-hidden="true"></i>
                                        <i class="fa fa-share-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-shield" aria-hidden="true"></i>
                                        <i class="fa fa-ship" aria-hidden="true"></i>
                                        <i class="fa fa-shopping-bag" aria-hidden="true"></i>
                                        <i class="fa fa-shopping-basket" aria-hidden="true"></i>
                                        <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                                        <i class="fa fa-shower" aria-hidden="true"></i>
                                        <i class="fa fa-sign-in" aria-hidden="true"></i>
                                        <i class="fa fa-sign-language" aria-hidden="true"></i>
                                        <i class="fa fa-sign-out" aria-hidden="true"></i>
                                        <i class="fa fa-signal" aria-hidden="true"></i>
                                        <i class="fa fa-signing" aria-hidden="true"></i>
                                        <i class="fa fa-sitemap" aria-hidden="true"></i>
                                        <i class="fa fa-sliders" aria-hidden="true"></i>
                                        <i class="fa fa-smile-o" aria-hidden="true"></i>
                                        <i class="fa fa-snowflake-o" aria-hidden="true"></i>
                                        <i class="fa fa-soccer-ball-o" aria-hidden="true"></i>
                                        <i class="fa fa-sort" aria-hidden="true"></i>
                                        <i class="fa fa-sort-alpha-asc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-alpha-desc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-amount-asc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-amount-desc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-asc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-desc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-down" aria-hidden="true"></i>
                                        <i class="fa fa-sort-numeric-asc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-numeric-desc" aria-hidden="true"></i>
                                        <i class="fa fa-sort-up" aria-hidden="true"></i>
                                        <i class="fa fa-space-shuttle" aria-hidden="true"></i>
                                        <i class="fa fa-spinner" aria-hidden="true"></i>
                                        <i class="fa fa-spoon" aria-hidden="true"></i>
                                        <i class="fa fa-square" aria-hidden="true"></i>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-star" aria-hidden="true"></i>
                                        <i class="fa fa-star-half" aria-hidden="true"></i>
                                        <i class="fa fa-star-half-empty" aria-hidden="true"></i>
                                        <i class="fa fa-star-half-full" aria-hidden="true"></i>
                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o" aria-hidden="true"></i>
                                        <i class="fa fa-sticky-note" aria-hidden="true"></i>
                                        <i class="fa fa-sticky-note-o" aria-hidden="true"></i>
                                        <i class="fa fa-street-view" aria-hidden="true"></i>
                                        <i class="fa fa-suitcase" aria-hidden="true"></i>
                                        <i class="fa fa-sun-o" aria-hidden="true"></i>
                                        <i class="fa fa-support" aria-hidden="true"></i>
                                        <i class="fa fa-tablet" aria-hidden="true"></i>
                                        <i class="fa fa-tachometer" aria-hidden="true"></i>
                                        <i class="fa fa-tag" aria-hidden="true"></i>
                                        <i class="fa fa-tags" aria-hidden="true"></i>
                                        <i class="fa fa-tasks" aria-hidden="true"></i>
                                        <i class="fa fa-taxi" aria-hidden="true"></i>
                                        <i class="fa fa-television" aria-hidden="true"></i>
                                        <i class="fa fa-terminal" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-0" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-1" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-2" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-3" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-4" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-empty" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-full" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-half" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-quarter" aria-hidden="true"></i>
                                        <i class="fa fa-thermometer-three-quarters" aria-hidden="true"></i>
                                        <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        <i class="fa fa-ticket" aria-hidden="true"></i>
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                        <i class="fa fa-times-circle" aria-hidden="true"></i>
                                        <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-times-rectangle" aria-hidden="true"></i>
                                        <i class="fa fa-times-rectangle-o" aria-hidden="true"></i>
                                        <i class="fa fa-tint" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-down" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-left" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-off" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-on" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-right" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-up" aria-hidden="true"></i>
                                        <i class="fa fa-trademark" aria-hidden="true"></i>
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                        <i class="fa fa-tree" aria-hidden="true"></i>
                                        <i class="fa fa-trophy" aria-hidden="true"></i>
                                        <i class="fa fa-truck" aria-hidden="true"></i>
                                        <i class="fa fa-tty" aria-hidden="true"></i>
                                        <i class="fa fa-tv" aria-hidden="true"></i>
                                        <i class="fa fa-umbrella" aria-hidden="true"></i>
                                        <i class="fa fa-universal-access" aria-hidden="true"></i>
                                        <i class="fa fa-university" aria-hidden="true"></i>
                                        <i class="fa fa-unlock" aria-hidden="true"></i>
                                        <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                                        <i class="fa fa-unsorted" aria-hidden="true"></i>
                                        <i class="fa fa-upload" aria-hidden="true"></i>
                                        <i class="fa fa-user" aria-hidden="true"></i>
                                        <i class="fa fa-user-circle" aria-hidden="true"></i>
                                        <i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-user-o" aria-hidden="true"></i>
                                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                                        <i class="fa fa-user-secret" aria-hidden="true"></i>
                                        <i class="fa fa-user-times" aria-hidden="true"></i>
                                        <i class="fa fa-users" aria-hidden="true"></i>
                                        <i class="fa fa-vcard" aria-hidden="true"></i>
                                        <i class="fa fa-vcard-o" aria-hidden="true"></i>
                                        <i class="fa fa-video-camera" aria-hidden="true"></i>
                                        <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                        <i class="fa fa-volume-down" aria-hidden="true"></i>
                                        <i class="fa fa-volume-off" aria-hidden="true"></i>
                                        <i class="fa fa-volume-up" aria-hidden="true"></i>
                                        <i class="fa fa-warning" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair-alt" aria-hidden="true"></i>
                                        <i class="fa fa-wifi" aria-hidden="true"></i>
                                        <i class="fa fa-window-close" aria-hidden="true"></i>
                                        <i class="fa fa-window-close-o" aria-hidden="true"></i>
                                        <i class="fa fa-window-maximize" aria-hidden="true"></i>
                                        <i class="fa fa-window-minimize" aria-hidden="true"></i>
                                        <i class="fa fa-window-restore" aria-hidden="true"></i>
                                        <i class="fa fa-wrench" aria-hidden="true"></i>
                                        <i class="fa fa-hand-grab-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-lizard-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-left" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-hand-paper-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-peace-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-pointer-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-rock-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-scissors-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-spock-o" aria-hidden="true"></i>
                                        <i class="fa fa-hand-stop-o" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-down" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                                        <i class="fa fa-american-sign-language-interpreting" aria-hidden="true"></i>
                                        <i class="fa fa-asl-interpreting" aria-hidden="true"></i>
                                        <i class="fa fa-assistive-listening-systems" aria-hidden="true"></i>
                                        <i class="fa fa-audio-description" aria-hidden="true"></i>
                                        <i class="fa fa-blind" aria-hidden="true"></i>
                                        <i class="fa fa-braille" aria-hidden="true"></i>
                                        <i class="fa fa-cc" aria-hidden="true"></i>
                                        <i class="fa fa-deaf" aria-hidden="true"></i>
                                        <i class="fa fa-deafness" aria-hidden="true"></i>
                                        <i class="fa fa-hard-of-hearing" aria-hidden="true"></i>
                                        <i class="fa fa-low-vision" aria-hidden="true"></i>
                                        <i class="fa fa-question-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-sign-language" aria-hidden="true"></i>
                                        <i class="fa fa-signing" aria-hidden="true"></i>
                                        <i class="fa fa-tty" aria-hidden="true"></i>
                                        <i class="fa fa-universal-access" aria-hidden="true"></i>
                                        <i class="fa fa-volume-control-phone" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair-alt" aria-hidden="true"></i>
                                        <i class="fa fa-ambulance" aria-hidden="true"></i>
                                        <i class="fa fa-automobile" aria-hidden="true"></i>
                                        <i class="fa fa-bicycle" aria-hidden="true"></i>
                                        <i class="fa fa-bus" aria-hidden="true"></i>
                                        <i class="fa fa-cab" aria-hidden="true"></i>
                                        <i class="fa fa-car" aria-hidden="true"></i>
                                        <i class="fa fa-fighter-jet" aria-hidden="true"></i>
                                        <i class="fa fa-motorcycle" aria-hidden="true"></i>
                                        <i class="fa fa-plane" aria-hidden="true"></i>
                                        <i class="fa fa-rocket" aria-hidden="true"></i>
                                        <i class="fa fa-ship" aria-hidden="true"></i>
                                        <i class="fa fa-space-shuttle" aria-hidden="true"></i>
                                        <i class="fa fa-subway" aria-hidden="true"></i>
                                        <i class="fa fa-taxi" aria-hidden="true"></i>
                                        <i class="fa fa-train" aria-hidden="true"></i>
                                        <i class="fa fa-truck" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair-alt" aria-hidden="true"></i>
                                        <i class="fa fa-genderless" aria-hidden="true"></i>
                                        <i class="fa fa-intersex" aria-hidden="true"></i>
                                        <i class="fa fa-mars" aria-hidden="true"></i>
                                        <i class="fa fa-mars-double" aria-hidden="true"></i>
                                        <i class="fa fa-mars-stroke" aria-hidden="true"></i>
                                        <i class="fa fa-mars-stroke-h" aria-hidden="true"></i>
                                        <i class="fa fa-mars-stroke-v" aria-hidden="true"></i>
                                        <i class="fa fa-mercury" aria-hidden="true"></i>
                                        <i class="fa fa-neuter" aria-hidden="true"></i>
                                        <i class="fa fa-transgender" aria-hidden="true"></i>
                                        <i class="fa fa-transgender-alt" aria-hidden="true"></i>
                                        <i class="fa fa-venus" aria-hidden="true"></i>
                                        <i class="fa fa-venus-double" aria-hidden="true"></i>
                                        <i class="fa fa-venus-mars" aria-hidden="true"></i>
                                        <i class="fa fa-file" aria-hidden="true"></i>
                                        <i class="fa fa-file-archive-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-audio-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-code-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-excel-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-image-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-movie-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-photo-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-picture-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-sound-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                        <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-video-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-word-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-zip-o" aria-hidden="true"></i>
                                        <i class="fa fa-cog" aria-hidden="true"></i>
                                        <i class="fa fa-gear" aria-hidden="true"></i>
                                        <i class="fa fa-refresh" aria-hidden="true"></i>
                                        <i class="fa fa-spinner" aria-hidden="true"></i>
                                        <i class="fa fa-check-square" aria-hidden="true"></i>
                                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-circle" aria-hidden="true"></i>
                                        <i class="fa fa-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-dot-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-minus-square" aria-hidden="true"></i>
                                        <i class="fa fa-minus-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                        <i class="fa fa-plus-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-square" aria-hidden="true"></i>
                                        <i class="fa fa-square-o" aria-hidden="true"></i>
                                        <i class="fa fa-cc-amex" aria-hidden="true"></i>
                                        <i class="fa fa-cc-diners-club" aria-hidden="true"></i>
                                        <i class="fa fa-cc-discover" aria-hidden="true"></i>
                                        <i class="fa fa-cc-jcb" aria-hidden="true"></i>
                                        <i class="fa fa-cc-mastercard" aria-hidden="true"></i>
                                        <i class="fa fa-cc-paypal" aria-hidden="true"></i>
                                        <i class="fa fa-cc-stripe" aria-hidden="true"></i>
                                        <i class="fa fa-cc-visa" aria-hidden="true"></i>
                                        <i class="fa fa-credit-card" aria-hidden="true"></i>
                                        <i class="fa fa-credit-card-alt" aria-hidden="true"></i>
                                        <i class="fa fa-google-wallet" aria-hidden="true"></i>
                                        <i class="fa fa-paypal" aria-hidden="true"></i>
                                        <i class="fa fa-area-chart" aria-hidden="true"></i>
                                        <i class="fa fa-bar-chart" aria-hidden="true"></i>
                                        <i class="fa fa-bar-chart-o" aria-hidden="true"></i>
                                        <i class="fa fa-line-chart" aria-hidden="true"></i>
                                        <i class="fa fa-pie-chart" aria-hidden="true"></i>
                                        <i class="fa fa-bitcoin" aria-hidden="true"></i>
                                        <i class="fa fa-btc" aria-hidden="true"></i>
                                        <i class="fa fa-cny" aria-hidden="true"></i>
                                        <i class="fa fa-dollar" aria-hidden="true"></i>
                                        <i class="fa fa-eur" aria-hidden="true"></i>
                                        <i class="fa fa-euro" aria-hidden="true"></i>
                                        <i class="fa fa-gbp" aria-hidden="true"></i>
                                        <i class="fa fa-gg" aria-hidden="true"></i>
                                        <i class="fa fa-gg-circle" aria-hidden="true"></i>
                                        <i class="fa fa-ils" aria-hidden="true"></i>
                                        <i class="fa fa-inr" aria-hidden="true"></i>
                                        <i class="fa fa-jpy" aria-hidden="true"></i>
                                        <i class="fa fa-krw" aria-hidden="true"></i>
                                        <i class="fa fa-money" aria-hidden="true"></i>
                                        <i class="fa fa-rmb" aria-hidden="true"></i>
                                        <i class="fa fa-rouble" aria-hidden="true"></i>
                                        <i class="fa fa-rub" aria-hidden="true"></i>
                                        <i class="fa fa-ruble" aria-hidden="true"></i>
                                        <i class="fa fa-rupee" aria-hidden="true"></i>
                                        <i class="fa fa-shekel" aria-hidden="true"></i>
                                        <i class="fa fa-sheqel" aria-hidden="true"></i>
                                        <i class="fa fa-try" aria-hidden="true"></i>
                                        <i class="fa fa-turkish-lira" aria-hidden="true"></i>
                                        <i class="fa fa-usd" aria-hidden="true"></i>
                                        <i class="fa fa-won" aria-hidden="true"></i>
                                        <i class="fa fa-yen" aria-hidden="true"></i>
                                        <i class="fa fa-align-center" aria-hidden="true"></i>
                                        <i class="fa fa-align-justify" aria-hidden="true"></i>
                                        <i class="fa fa-align-left" aria-hidden="true"></i>
                                        <i class="fa fa-align-right" aria-hidden="true"></i>
                                        <i class="fa fa-bold" aria-hidden="true"></i>
                                        <i class="fa fa-chain" aria-hidden="true"></i>
                                        <i class="fa fa-chain-broken" aria-hidden="true"></i>
                                        <i class="fa fa-clipboard" aria-hidden="true"></i>
                                        <i class="fa fa-columns" aria-hidden="true"></i>
                                        <i class="fa fa-copy" aria-hidden="true"></i>
                                        <i class="fa fa-cut" aria-hidden="true"></i>
                                        <i class="fa fa-dedent" aria-hidden="true"></i>
                                        <i class="fa fa-eraser" aria-hidden="true"></i>
                                        <i class="fa fa-file" aria-hidden="true"></i>
                                        <i class="fa fa-file-o" aria-hidden="true"></i>
                                        <i class="fa fa-file-text" aria-hidden="true"></i>
                                        <i class="fa fa-file-text-o" aria-hidden="true"></i>
                                        <i class="fa fa-files-o" aria-hidden="true"></i>
                                        <i class="fa fa-floppy-o" aria-hidden="true"></i>
                                        <i class="fa fa-font" aria-hidden="true"></i>
                                        <i class="fa fa-header" aria-hidden="true"></i>
                                        <i class="fa fa-indent" aria-hidden="true"></i>
                                        <i class="fa fa-italic" aria-hidden="true"></i>
                                        <i class="fa fa-link" aria-hidden="true"></i>
                                        <i class="fa fa-list" aria-hidden="true"></i>
                                        <i class="fa fa-list-alt" aria-hidden="true"></i>
                                        <i class="fa fa-list-ol" aria-hidden="true"></i>
                                        <i class="fa fa-list-ul" aria-hidden="true"></i>
                                        <i class="fa fa-outdent" aria-hidden="true"></i>
                                        <i class="fa fa-paperclip" aria-hidden="true"></i>
                                        <i class="fa fa-paragraph" aria-hidden="true"></i>
                                        <i class="fa fa-paste" aria-hidden="true"></i>
                                        <i class="fa fa-repeat" aria-hidden="true"></i>
                                        <i class="fa fa-rotate-left" aria-hidden="true"></i>
                                        <i class="fa fa-rotate-right" aria-hidden="true"></i>
                                        <i class="fa fa-save" aria-hidden="true"></i>
                                        <i class="fa fa-scissors" aria-hidden="true"></i>
                                        <i class="fa fa-strikethrough" aria-hidden="true"></i>
                                        <i class="fa fa-subscript" aria-hidden="true"></i>
                                        <i class="fa fa-superscript" aria-hidden="true"></i>
                                        <i class="fa fa-table" aria-hidden="true"></i>
                                        <i class="fa fa-text-height" aria-hidden="true"></i>
                                        <i class="fa fa-text-width" aria-hidden="true"></i>
                                        <i class="fa fa-th" aria-hidden="true"></i>
                                        <i class="fa fa-th-large" aria-hidden="true"></i>
                                        <i class="fa fa-th-list" aria-hidden="true"></i>
                                        <i class="fa fa-underline" aria-hidden="true"></i>
                                        <i class="fa fa-undo" aria-hidden="true"></i>
                                        <i class="fa fa-unlink" aria-hidden="true"></i>
                                        <i class="fa fa-angle-double-down" aria-hidden="true"></i>
                                        <i class="fa fa-angle-double-left" aria-hidden="true"></i>
                                        <i class="fa fa-angle-double-right" aria-hidden="true"></i>
                                        <i class="fa fa-angle-double-up" aria-hidden="true"></i>
                                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        <i class="fa fa-angle-left" aria-hidden="true"></i>
                                        <i class="fa fa-angle-right" aria-hidden="true"></i>
                                        <i class="fa fa-angle-up" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-down" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-left" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-o-left" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-o-right" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-circle-up" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-down" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-right" aria-hidden="true"></i>
                                        <i class="fa fa-arrow-up" aria-hidden="true"></i>
                                        <i class="fa fa-arrows" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-h" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-v" aria-hidden="true"></i>
                                        <i class="fa fa-caret-down" aria-hidden="true"></i>
                                        <i class="fa fa-caret-left" aria-hidden="true"></i>
                                        <i class="fa fa-caret-right" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-left" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-right" aria-hidden="true"></i>
                                        <i class="fa fa-caret-square-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-caret-up" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-down" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-left" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-right" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-circle-up" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-right" aria-hidden="true"></i>
                                        <i class="fa fa-chevron-up" aria-hidden="true"></i>
                                        <i class="fa fa-exchange" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-down" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-left" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-right" aria-hidden="true"></i>
                                        <i class="fa fa-hand-o-up" aria-hidden="true"></i>
                                        <i class="fa fa-long-arrow-down" aria-hidden="true"></i>
                                        <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                                        <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                                        <i class="fa fa-long-arrow-up" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-down" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-left" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-right" aria-hidden="true"></i>
                                        <i class="fa fa-toggle-up" aria-hidden="true"></i>
                                        <i class="fa fa-arrows-alt" aria-hidden="true"></i>
                                        <i class="fa fa-backward" aria-hidden="true"></i>
                                        <i class="fa fa-compress" aria-hidden="true"></i>
                                        <i class="fa fa-eject" aria-hidden="true"></i>
                                        <i class="fa fa-expand" aria-hidden="true"></i>
                                        <i class="fa fa-fast-backward" aria-hidden="true"></i>
                                        <i class="fa fa-fast-forward" aria-hidden="true"></i>
                                        <i class="fa fa-forward" aria-hidden="true"></i>
                                        <i class="fa fa-pause" aria-hidden="true"></i>
                                        <i class="fa fa-pause-circle" aria-hidden="true"></i>
                                        <i class="fa fa-pause-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                        <i class="fa fa-play-circle" aria-hidden="true"></i>
                                        <i class="fa fa-play-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-random" aria-hidden="true"></i>
                                        <i class="fa fa-step-backward" aria-hidden="true"></i>
                                        <i class="fa fa-step-forward" aria-hidden="true"></i>
                                        <i class="fa fa-stop" aria-hidden="true"></i>
                                        <i class="fa fa-stop-circle" aria-hidden="true"></i>
                                        <i class="fa fa-stop-circle-o" aria-hidden="true"></i>
                                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                        <i class="fa fa-adn" aria-hidden="true"></i>
                                        <i class="fa fa-amazon" aria-hidden="true"></i>
                                        <i class="fa fa-android" aria-hidden="true"></i>
                                        <i class="fa fa-angellist" aria-hidden="true"></i>
                                        <i class="fa fa-apple" aria-hidden="true"></i>
                                        <i class="fa fa-bandcamp" aria-hidden="true"></i>
                                        <i class="fa fa-behance" aria-hidden="true"></i>
                                        <i class="fa fa-behance-square" aria-hidden="true"></i>
                                        <i class="fa fa-bitbucket" aria-hidden="true"></i>
                                        <i class="fa fa-bitbucket-square" aria-hidden="true"></i>
                                        <i class="fa fa-bitcoin" aria-hidden="true"></i>
                                        <i class="fa fa-black-tie" aria-hidden="true"></i>
                                        <i class="fa fa-bluetooth" aria-hidden="true"></i>
                                        <i class="fa fa-bluetooth-b" aria-hidden="true"></i>
                                        <i class="fa fa-btc" aria-hidden="true"></i>
                                        <i class="fa fa-buysellads" aria-hidden="true"></i>
                                        <i class="fa fa-cc-amex" aria-hidden="true"></i>
                                        <i class="fa fa-cc-diners-club" aria-hidden="true"></i>
                                        <i class="fa fa-cc-discover" aria-hidden="true"></i>
                                        <i class="fa fa-cc-jcb" aria-hidden="true"></i>
                                        <i class="fa fa-cc-mastercard" aria-hidden="true"></i>
                                        <i class="fa fa-cc-paypal" aria-hidden="true"></i>
                                        <i class="fa fa-cc-stripe" aria-hidden="true"></i>
                                        <i class="fa fa-cc-visa" aria-hidden="true"></i>
                                        <i class="fa fa-chrome" aria-hidden="true"></i>
                                        <i class="fa fa-codepen" aria-hidden="true"></i>
                                        <i class="fa fa-codiepie" aria-hidden="true"></i>
                                        <i class="fa fa-connectdevelop" aria-hidden="true"></i>
                                        <i class="fa fa-contao" aria-hidden="true"></i>
                                        <i class="fa fa-css3" aria-hidden="true"></i>
                                        <i class="fa fa-dashcube" aria-hidden="true"></i>
                                        <i class="fa fa-delicious" aria-hidden="true"></i>
                                        <i class="fa fa-deviantart" aria-hidden="true"></i>
                                        <i class="fa fa-digg" aria-hidden="true"></i>
                                        <i class="fa fa-dribbble" aria-hidden="true"></i>
                                        <i class="fa fa-dropbox" aria-hidden="true"></i>
                                        <i class="fa fa-drupal" aria-hidden="true"></i>
                                        <i class="fa fa-edge" aria-hidden="true"></i>
                                        <i class="fa fa-eercast" aria-hidden="true"></i>
                                        <i class="fa fa-empire" aria-hidden="true"></i>
                                        <i class="fa fa-envira" aria-hidden="true"></i>
                                        <i class="fa fa-etsy" aria-hidden="true"></i>
                                        <i class="fa fa-expeditedssl" aria-hidden="true"></i>
                                        <i class="fa fa-fa" aria-hidden="true"></i>
                                        <i class="fa fa-facebook" aria-hidden="true"></i>
                                        <i class="fa fa-facebook-f" aria-hidden="true"></i>
                                        <i class="fa fa-facebook-official" aria-hidden="true"></i>
                                        <i class="fa fa-facebook-square" aria-hidden="true"></i>
                                        <i class="fa fa-firefox" aria-hidden="true"></i>
                                        <i class="fa fa-first-order" aria-hidden="true"></i>
                                        <i class="fa fa-flickr" aria-hidden="true"></i>
                                        <i class="fa fa-font-awesome" aria-hidden="true"></i>
                                        <i class="fa fa-fonticons" aria-hidden="true"></i>
                                        <i class="fa fa-fort-awesome" aria-hidden="true"></i>
                                        <i class="fa fa-forumbee" aria-hidden="true"></i>
                                        <i class="fa fa-foursquare" aria-hidden="true"></i>
                                        <i class="fa fa-free-code-camp" aria-hidden="true"></i>
                                        <i class="fa fa-ge" aria-hidden="true"></i>
                                        <i class="fa fa-get-pocket" aria-hidden="true"></i>
                                        <i class="fa fa-gg" aria-hidden="true"></i>
                                        <i class="fa fa-gg-circle" aria-hidden="true"></i>
                                        <i class="fa fa-git" aria-hidden="true"></i>
                                        <i class="fa fa-git-square" aria-hidden="true"></i>
                                        <i class="fa fa-github" aria-hidden="true"></i>
                                        <i class="fa fa-github-alt" aria-hidden="true"></i>
                                        <i class="fa fa-github-square" aria-hidden="true"></i>
                                        <i class="fa fa-gitlab" aria-hidden="true"></i>
                                        <i class="fa fa-gittip" aria-hidden="true"></i>
                                        <i class="fa fa-glide" aria-hidden="true"></i>
                                        <i class="fa fa-glide-g" aria-hidden="true"></i>
                                        <i class="fa fa-google" aria-hidden="true"></i>
                                        <i class="fa fa-google-plus" aria-hidden="true"></i>
                                        <i class="fa fa-google-plus-circle" aria-hidden="true"></i>
                                        <i class="fa fa-google-plus-official" aria-hidden="true"></i>
                                        <i class="fa fa-google-plus-square" aria-hidden="true"></i>
                                        <i class="fa fa-google-wallet" aria-hidden="true"></i>
                                        <i class="fa fa-gratipay" aria-hidden="true"></i>
                                        <i class="fa fa-grav" aria-hidden="true"></i>
                                        <i class="fa fa-hacker-news" aria-hidden="true"></i>
                                        <i class="fa fa-houzz" aria-hidden="true"></i>
                                        <i class="fa fa-html5" aria-hidden="true"></i>
                                        <i class="fa fa-imdb" aria-hidden="true"></i>
                                        <i class="fa fa-instagram" aria-hidden="true"></i>
                                        <i class="fa fa-internet-explorer" aria-hidden="true"></i>
                                        <i class="fa fa-ioxhost" aria-hidden="true"></i>
                                        <i class="fa fa-joomla" aria-hidden="true"></i>
                                        <i class="fa fa-jsfiddle" aria-hidden="true"></i>
                                        <i class="fa fa-lastfm" aria-hidden="true"></i>
                                        <i class="fa fa-lastfm-square" aria-hidden="true"></i>
                                        <i class="fa fa-leanpub" aria-hidden="true"></i>
                                        <i class="fa fa-linkedin" aria-hidden="true"></i>
                                        <i class="fa fa-linkedin-square" aria-hidden="true"></i>
                                        <i class="fa fa-linode" aria-hidden="true"></i>
                                        <i class="fa fa-linux" aria-hidden="true"></i>
                                        <i class="fa fa-maxcdn" aria-hidden="true"></i>
                                        <i class="fa fa-meanpath" aria-hidden="true"></i>
                                        <i class="fa fa-medium" aria-hidden="true"></i>
                                        <i class="fa fa-meetup" aria-hidden="true"></i>
                                        <i class="fa fa-mixcloud" aria-hidden="true"></i>
                                        <i class="fa fa-modx" aria-hidden="true"></i>
                                        <i class="fa fa-odnoklassniki" aria-hidden="true"></i>
                                        <i class="fa fa-odnoklassniki-square" aria-hidden="true"></i>
                                        <i class="fa fa-opencart" aria-hidden="true"></i>
                                        <i class="fa fa-openid" aria-hidden="true"></i>
                                        <i class="fa fa-opera" aria-hidden="true"></i>
                                        <i class="fa fa-optin-monster" aria-hidden="true"></i>
                                        <i class="fa fa-pagelines" aria-hidden="true"></i>
                                        <i class="fa fa-paypal" aria-hidden="true"></i>
                                        <i class="fa fa-pied-piper" aria-hidden="true"></i>
                                        <i class="fa fa-pied-piper-alt" aria-hidden="true"></i>
                                        <i class="fa fa-pied-piper-pp" aria-hidden="true"></i>
                                        <i class="fa fa-pinterest" aria-hidden="true"></i>
                                        <i class="fa fa-pinterest-p" aria-hidden="true"></i>
                                        <i class="fa fa-pinterest-square" aria-hidden="true"></i>
                                        <i class="fa fa-product-hunt" aria-hidden="true"></i>
                                        <i class="fa fa-qq" aria-hidden="true"></i>
                                        <i class="fa fa-quora" aria-hidden="true"></i>
                                        <i class="fa fa-ra" aria-hidden="true"></i>
                                        <i class="fa fa-ravelry" aria-hidden="true"></i>
                                        <i class="fa fa-rebel" aria-hidden="true"></i>
                                        <i class="fa fa-reddit" aria-hidden="true"></i>
                                        <i class="fa fa-reddit-alien" aria-hidden="true"></i>
                                        <i class="fa fa-reddit-square" aria-hidden="true"></i>
                                        <i class="fa fa-renren" aria-hidden="true"></i>
                                        <i class="fa fa-resistance" aria-hidden="true"></i>
                                        <i class="fa fa-safari" aria-hidden="true"></i>
                                        <i class="fa fa-scribd" aria-hidden="true"></i>
                                        <i class="fa fa-sellsy" aria-hidden="true"></i>
                                        <i class="fa fa-share-alt" aria-hidden="true"></i>
                                        <i class="fa fa-share-alt-square" aria-hidden="true"></i>
                                        <i class="fa fa-shirtsinbulk" aria-hidden="true"></i>
                                        <i class="fa fa-simplybuilt" aria-hidden="true"></i>
                                        <i class="fa fa-skyatlas" aria-hidden="true"></i>
                                        <i class="fa fa-skype" aria-hidden="true"></i>
                                        <i class="fa fa-slack" aria-hidden="true"></i>
                                        <i class="fa fa-slideshare" aria-hidden="true"></i>
                                        <i class="fa fa-snapchat" aria-hidden="true"></i>
                                        <i class="fa fa-snapchat-ghost" aria-hidden="true"></i>
                                        <i class="fa fa-snapchat-square" aria-hidden="true"></i>
                                        <i class="fa fa-soundcloud" aria-hidden="true"></i>
                                        <i class="fa fa-spotify" aria-hidden="true"></i>
                                        <i class="fa fa-stack-exchange" aria-hidden="true"></i>
                                        <i class="fa fa-stack-overflow" aria-hidden="true"></i>
                                        <i class="fa fa-steam" aria-hidden="true"></i>
                                        <i class="fa fa-steam-square" aria-hidden="true"></i>
                                        <i class="fa fa-stumbleupon" aria-hidden="true"></i>
                                        <i class="fa fa-stumbleupon-circle" aria-hidden="true"></i>
                                        <i class="fa fa-superpowers" aria-hidden="true"></i>
                                        <i class="fa fa-telegram" aria-hidden="true"></i>
                                        <i class="fa fa-tencent-weibo" aria-hidden="true"></i>
                                        <i class="fa fa-themeisle" aria-hidden="true"></i>
                                        <i class="fa fa-trello" aria-hidden="true"></i>
                                        <i class="fa fa-tripadvisor" aria-hidden="true"></i>
                                        <i class="fa fa-tumblr" aria-hidden="true"></i>
                                        <i class="fa fa-tumblr-square" aria-hidden="true"></i>
                                        <i class="fa fa-twitch" aria-hidden="true"></i>
                                        <i class="fa fa-twitter" aria-hidden="true"></i>
                                        <i class="fa fa-twitter-square" aria-hidden="true"></i>
                                        <i class="fa fa-usb" aria-hidden="true"></i>
                                        <i class="fa fa-viacoin" aria-hidden="true"></i>
                                        <i class="fa fa-viadeo" aria-hidden="true"></i>
                                        <i class="fa fa-viadeo-square" aria-hidden="true"></i>
                                        <i class="fa fa-vimeo" aria-hidden="true"></i>
                                        <i class="fa fa-vimeo-square" aria-hidden="true"></i>
                                        <i class="fa fa-vine" aria-hidden="true"></i>
                                        <i class="fa fa-vk" aria-hidden="true"></i>
                                        <i class="fa fa-wechat" aria-hidden="true"></i>
                                        <i class="fa fa-weibo" aria-hidden="true"></i>
                                        <i class="fa fa-weixin" aria-hidden="true"></i>
                                        <i class="fa fa-whatsapp" aria-hidden="true"></i>
                                        <i class="fa fa-wikipedia-w" aria-hidden="true"></i>
                                        <i class="fa fa-windows" aria-hidden="true"></i>
                                        <i class="fa fa-wordpress" aria-hidden="true"></i>
                                        <i class="fa fa-wpbeginner" aria-hidden="true"></i>
                                        <i class="fa fa-wpexplorer" aria-hidden="true"></i>
                                        <i class="fa fa-wpforms" aria-hidden="true"></i>
                                        <i class="fa fa-xing" aria-hidden="true"></i>
                                        <i class="fa fa-xing-square" aria-hidden="true"></i>
                                        <i class="fa fa-y-combinator" aria-hidden="true"></i>
                                        <i class="fa fa-y-combinator-square" aria-hidden="true"></i>
                                        <i class="fa fa-yahoo" aria-hidden="true"></i>
                                        <i class="fa fa-yc" aria-hidden="true"></i>
                                        <i class="fa fa-yc-square" aria-hidden="true"></i>
                                        <i class="fa fa-yelp" aria-hidden="true"></i>
                                        <i class="fa fa-yoast" aria-hidden="true"></i>
                                        <i class="fa fa-youtube" aria-hidden="true"></i>
                                        <i class="fa fa-youtube-play" aria-hidden="true"></i>
                                        <i class="fa fa-youtube-square" aria-hidden="true"></i>
                                        <i class="fa fa-ambulance" aria-hidden="true"></i>
                                        <i class="fa fa-h-square" aria-hidden="true"></i>
                                        <i class="fa fa-heart" aria-hidden="true"></i>
                                        <i class="fa fa-heart-o" aria-hidden="true"></i>
                                        <i class="fa fa-heartbeat" aria-hidden="true"></i>
                                        <i class="fa fa-hospital-o" aria-hidden="true"></i>
                                        <i class="fa fa-medkit" aria-hidden="true"></i>
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                        <i class="fa fa-stethoscope" aria-hidden="true"></i>
                                        <i class="fa fa-user-md" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair" aria-hidden="true"></i>
                                        <i class="fa fa-wheelchair-alt" aria-hidden="true"></i>

                                    </div>`
                    }); 
                })
                $("input[name=\'wztlaw[type]\']").change(function(){
                    var value=$("input[name=\'wztlaw[type]\']:checked").val();
                    if(value==1){
                       
                        
                        $(".add_button").css("display","none");
                    }else{
                       
                        $(".add_button").css("display","block");
                    }
                })
                $("body").on("change",".nav_type",function(){
                    var num = $(this).attr("data-num");
                    var value=$("input[name=\'wztlaw[button]["+num+"][button_type]\']:checked").val();
                    if(value==1){
                        $(this).parents(".layui-colla-content").find(".button_pic").css("display","none");
                        $(this).parents(".layui-colla-content").find(".button_qq").css("display","none");
                        $(this).parents(".layui-colla-content").find(".button_url").css("display","block");
                    }else if(value==2){
                        $(this).parents(".layui-colla-content").find(".button_pic").css("display","block");
                        $(this).parents(".layui-colla-content").find(".button_qq").css("display","none");
                        $(this).parents(".layui-colla-content").find(".button_url").css("display","none");
                    }else if(value==3){
                        $(this).parents(".layui-colla-content").find(".button_pic").css("display","none");
                        $(this).parents(".layui-colla-content").find(".button_qq").css("display","block");
                        $(this).parents(".layui-colla-content").find(".button_url").css("display","none");
                    }
                })
                $("#test1").click(function(){     
                    event.preventDefault();   
                    
                    upload_frame = wp.media({   
                        title: "添加图片",   
                        button: {   
                            text: "选择图片",   
                        },   
                        multiple: false   
                    });   
                    upload_frame.on("select",function(){   
                        attachment = upload_frame.state().get("selection").first().toJSON(); 
                        
                        $("input[name=\'wztlaw[pic]\']").val(attachment.url);   
                        $("#de1").attr("src",attachment.url);
                    });    
                    upload_frame.open();   
                }) 
                $("#test2").click(function(){
                
                     event.preventDefault(); 
                        var tc_edit = $(".tc_edit").val();
                        if(tc_edit){
                            upload_frame1 = wp.media.gallery.edit("[gallery ids=\'" + tc_edit + "\']");
                            upload_frame1.setState("gallery-library");
                             upload_frame1.on("update",
                                function(a) {
                                    $(".tctp").empty();
                                    var b = a.models.map(function(a) {
                                        var b = a.toJSON(),
                                        c = void 0 !== b.sizes.thumbnail ? b.sizes.thumbnail.url: b.url;
                                        return $(".tctp").append("<li><img src=\'" + c + "\'></li>"),
                                        b.id
                                    });
                                    $(".tc_edit").val(b.join(","));
                                
                            })
                        }else{
                            upload_frame1 = wp.media({  
                                title:"创建图册",
                                library: {
                                    type: "image"
                                },
                                button: {   
                                    text: "创建图册",   
                                },  
                               frame: "post",
                                state: "gallery",
                                multiple: true
                            });
                            upload_frame1.open();
                            upload_frame1.on("update",
                                function(a) {
                                    $(".tctp").empty();
                                   
                                    var b = a.models.map(function(a) {
                                        var b = a.toJSON(),
                                        c = void 0 !== b.sizes.thumbnail ? b.sizes.thumbnail.url: b.url;
                                        return $(".tctp").append("<li><img src=\'" + c + "\'></li>"),
                                        b.id
                                    });
                                    $(".tc_edit").val(b.join(","));
                                
                            })
                        }
                       
                    
                })
                 //删除按钮
                $("body").on("click",".lunbo_delete",function(){
                    $(this).parents(".layui-collapse").remove();
                })
                if(num_add){
                    var num = num_add;
                }else{
                    var num = 0;
                }
                $(".lunbo_add_hdp").click(function(){

                    ++num;
                    $("input[name=\'wzt_num\']").val(num);
                    $(".lunbo_list .layui-colla-content").removeClass("layui-show");
                    $(".lunbo_list").append(`
                        <div class="layui-collapse" lay-accordion="">
                            <div class="layui-colla-item">
                                <h2 class="layui-colla-title" style="position: relative;height: 42px;line-height: 42px;padding: 0 15px 0 35px;color: #333;background-color: #f2f2f2;cursor: pointer;font-size: 14px;overflow: hidden;">添加按钮</h2>
                                <div class="layui-colla-content layui-show">
                                   <div class="layui-form-item">

                                        <label class="layui-form-label">菜单类型</label>
                                        <div class="layui-input-block">
                                          <label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="`+num+`" name="wztlaw[button][`+num+`][button_type]" value="1" title="跳转链接" checked="" >跳转链接</label>
                                          <label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="`+num+`" name="wztlaw[button][`+num+`][button_type]" value="2" title="弹出图像" >弹出图像</label>
                                          <label style="vertical-align: middle;line-height: 36px;"><input type="radio" class="nav_type" data-num="`+num+`" name="wztlaw[button][`+num+`][button_type]" value="3" title="QQ在线咨询" >QQ在线咨询</label>
                                         </div>
                                      </div>
                                    <div class="layui-form-item">
                                         <label class="layui-form-label">按钮文本</label>
                                         <div class="layui-input-block">
                                          <input type="text" name="wztlaw[button][`+num+`][button_title]"   autocomplete="off" placeholder="" class="layui-input" value="">
                                         </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">按钮图标</label>
                                        <div class="layui-input-block" >
                                            <input type="hidden" name="wztlaw[button][`+num+`][button_icon]"   autocomplete="off" placeholder="" class="layui-input" value="">
                                            <i></i>
                                            <button type="button" class="layui-btn layui-btn-normal wztlaw_addicon" data-num="`+num+`" >添加图标</button>
                                        </div>
                                      </div>
                                        
                                    <div class="layui-form-item">
                                        <label class="layui-form-label">按钮颜色</label>
                                          <div class="layui-input-inline" style="width: 120px;">
                                            <input type="text" value="" placeholder="请选择颜色" class="layui-input" id="test-form-input`+num+`" name="wztlaw[button][`+num+`][button_color]">
                                          </div>
                                          <div class="layui-inline" style="left: -11px;">
                                            <div id="test-form`+num+`"></div>
                                          </div>
                                    </div>
                                    <div class="layui-form-item button_url">
                                         <label class="layui-form-label">跳转链接</label>
                                         <div class="layui-input-block">
                                          <input type="text" name="wztlaw[button][`+num+`][button_url]"   autocomplete="off" placeholder="" class="layui-input" value="">
                                         </div>
                                    </div>
                                    <div class="layui-form-item button_pic" style="display:none">
                                        <label class="layui-form-label">上传图像</label>
                                        <div class="layui-upload">
                                            <button type="button" class="layui-btn" id="tests`+num+`" onclick="test(`+num+`)">上传图片</button>
                                            <input type="hidden" name="wztlaw[button][`+num+`][button_pic]" >
                                            <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
                                                    <img class="layui-upload-img" id="demos`+num+`" style="width:200px">
                                                
                                                <p id="demoText"></p>
                                            </div>
                                        </div>
                                    </div>
                                     <div class="layui-form-item button_qq" style="display:none">
                                         <label class="layui-form-label">qq号码</label>
                                         <div class="layui-input-block">
                                          <input type="text" name="wztlaw[button][`+num+`][button_qq]"   autocomplete="off" placeholder="" class="layui-input" value="">
                                         </div>
                                    </div>
                                    <div class="layui-form-item">
                                        <label class="layui-form-label"></label>
                                        <div class="layui-input-block" >
                                            
                                            <button class="layui-btn layui-btn-danger lunbo_delete"><i class="layui-icon layui-icon-delete"></i>删除</button>
                                            
                                        </div>
                                      </div>
                                </div>
                            </div>
                        </div>`);
                        colorpicker.render({
                            elem: "#test-form"+num
                            ,color: "#1c97f5"
                            ,done: function(color){
                              $("#test-form-input"+num).val(color);
                            }
                        });
                        layui.element.render();
                        form.render();
                     
                })
            })
        })
    </script>
  ';

          
    }
    public function wztlaw_post(){
        $data = $this->data;
        
        if(isset($data['nonce']) && isset($data['action']) && wp_verify_nonce($data['nonce'],$data['action'])){
            switch ($data['wztlaw']) {
                case 1:
                    $list = [
                        'pc_logo'=>esc_url($data['pc_logo']),
                        'mobile_logo'=>esc_url($data['mobile_logo']),
                        'favicon'=>esc_url($data['favicon']),
                        'pc_alt' =>sanitize_text_field($data['pc_alt']),
                        'mobile_alt' =>sanitize_text_field($data['mobile_alt']),
                        'bg'=>$data['bg'],
                        'color'=>$data['color'],
                    ];
                    $wztlaw_theme = get_option('wztlaw_theme'); 
                    if($wztlaw_theme){
                        update_option('wztlaw_theme',$list);
                    }else{
                    	add_option('wztlaw_theme',$list);
                	}  
                	echo json_encode(['msg'=>1]);exit; 
                    break;
                case 2:
                    $list = [
                        
                        'bg'=>$data['bg'],
                        'color'=>$data['color'],
                        'mouse'=>$data['mouse']
                    ];
                    if(isset($data['close'])){
                        $list['is_texiao'] =1;
                    }else{
                        $list['is_texiao'] =0;
                    }
                    if(isset($data['gu'])){
                        $list['gu'] =1;
                    }else{
                        $list['gu'] =0;
                    }
                    
                    $wztlaw_index = get_option('wztlaw_index');
                    if($wztlaw_index){
                        update_option('wztlaw_index',$list);
                    }else{
                    	add_option('wztlaw_index',$list);
                	}  
                	echo json_encode(['msg'=>1]);exit;
                    break;
                case 3:
                    $list = [];
                    if(isset($data['lunbo_open'])){
                        $list['lunbo_open'] = 1;
                    }else{
                        $list['lunbo_open'] = 0;
                    }
                   
                    for($i =1;$i<=$data['wzt_num'];$i++){
                        if(isset($data['test'.$i])){
                            $list['pic'][$i]['test'] = $data['test'.$i];
                        }
                        if(isset($data['mobile_test'.$i])){
                            $list['pic'][$i]['mobile_test'] = $data['mobile_test'.$i];
                        }
                        if(isset($data['url'.$i])){
                            $list['pic'][$i]['url'] = $data['url'.$i];
                        }
                        if(isset($data['pc_alt'.$i])){
                            $list['pic'][$i]['pc_alt'] = $data['pc_alt'.$i];
                        }
                        if(isset($data['mobile_alt'.$i])){
                            $list['pic'][$i]['mobile_alt'] = $data['mobile_alt'.$i];
                        }
                        if(isset($data['target'.$i])){
                            $list['pic'][$i]['target'] = 1;
                        }elseif(isset($data['test'.$i])){
                            $list['pic'][$i]['target'] = 0;
                        }
                        if(isset($data['nofollow'.$i])){
                            $list['pic'][$i]['nofollow'] = 1;
                        }elseif(isset($data['test'.$i])){
                            $list['pic'][$i]['nofollow'] = 0;
                        }
                    }
                    $wztlaw_index = get_option('wztlaw_lunbo');
                    if($wztlaw_index !==false){
                        update_option('wztlaw_lunbo',$list);
                    }else{
                        add_option('wztlaw_lunbo',$list);
                    }  
                    echo json_encode(['msg'=>1]);exit;

                    break;
                case 4:
                    $list = [
                        'title'=>sanitize_text_field($data['title']),
                        'title_en'=>sanitize_text_field($data['title_en']),
                        'flex'=>(int)$data['flex'],
                        'pic'=>$data['pic'],
                        'description'=>sanitize_textarea_field($data['description']),
                        'url'=>$data['url'],
                        'alt'=>sanitize_text_field($data['alt'])
                    ];
                    if(isset($data['close'])){
                        $list['auto'] = 1;
                    }else{
                        $list['auto'] = 0;
                    }
                    if(isset($data['mobile_close'])){
                        $list['mobile_auto'] = 1;
                    }else{
                        $list['mobile_auto'] = 0;
                    }
                    if(isset($data['indent'])){
                        $list['indent'] = 1;
                    }else{
                        $list['indent'] = 0;
                    }

                    $wztlaw_about = get_option('wztlaw_about');
                    if($wztlaw_about!==false){
                        update_option('wztlaw_about',$list);
                    }else{
                    	add_option('wztlaw_about',$list);
                	}  
                	echo json_encode(['msg'=>1]);exit;
                    break;
                case 5:
                    $list = [
                        'title'=>sanitize_text_field($data['title']),
                        'title_en'=>sanitize_text_field($data['title_en']),
                        'url'=>$data['url'],
                        'size'=>$data['size'],
                        'color'=>$data['color']
                    ];
                    if(isset($data['close'])){
                        $list['auto'] = 1;
                    }else{
                        $list['auto'] = 0;
                    }
                    if(isset($data['mobile_close'])){
                        $list['mobile_auto'] = 1;
                    }else{
                        $list['mobile_auto'] = 0;
                    }
                    
                    for($i =1;$i<=$data['wzt_num'];$i++){
                        if(isset($data['test'.$i])){
                            $list['pic'][$i]['test'] = $data['test'.$i];
                        }
                        if(isset($data['buss'.$i])){
                            $list['pic'][$i]['buss'] = $data['buss'.$i];
                        }
                        if(isset($data['url'.$i])){
                            $list['pic'][$i]['url'] = $data['url'.$i];
                        }
                        if(isset($data['alt'.$i])){
                            $list['pic'][$i]['alt'] = $data['alt'.$i];
                        }
                        if(isset($data['target'.$i])){
                            $list['pic'][$i]['target'] = 1;
                        }elseif(isset($data['test'.$i])){
                            $list['pic'][$i]['target'] = 0;
                        }
                        if(isset($data['nofollow'.$i])){
                            $list['pic'][$i]['nofollow'] = 1;
                        }elseif(isset($data['test'.$i])){
                            $list['pic'][$i]['nofollow'] = 0;
                        }
                        
                    }
                    $wztlaw_business = get_option('wztlaw_business');
                    if($wztlaw_business!==false){
                        update_option('wztlaw_business',$list);
                    }else{
                        add_option('wztlaw_business',$list);
                    }  
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 6:
                   $list = [
                        'title'=>sanitize_text_field($data['title']),
                        'title_en'=>sanitize_text_field($data['title_en']),
                        
                    ];
                    if(isset($data['close'])){
                        $list['auto'] = 1;
                    }else{
                        $list['auto'] = 0;
                    }
                    if(isset($data['mobile_close'])){
                        $list['mobile_auto'] = 1;
                    }else{
                        $list['mobile_auto'] = 0;
                    }
                    
                    for($i =1;$i<=$data['wzt_num'];$i++){
                        if(isset($data['test'.$i])){
                            $list['pic'][$i]['test'] = $data['test'.$i];
                        }
                        if(isset($data['alt'.$i])){
                            $list['pic'][$i]['alt'] = $data['alt'.$i];
                        }
                        
                    }
                    $wztlaw_pic = get_option('wztlaw_pic');
                    if($wztlaw_pic!==false){
                        update_option('wztlaw_pic',$list);
                    }else{
                        add_option('wztlaw_pic',$list);
                    }  
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 7:
                    $list = [
                        'title'=>sanitize_text_field($data['title']),
                        'term_id'=>(int)$data['term_id']
                    ];
                    if(isset($data['close'])){
                        $list['auto'] = 1;
                    }else{
                        $list['auto'] = 0;
                    }
                    if(isset($data['mobile_close'])){
                        $list['mobile_auto'] = 1;
                    }else{
                        $list['mobile_auto'] = 0;
                    }
                    $wztlaw_news = get_option('wztlaw_news');
                    if($wztlaw_news!==false){
                        update_option('wztlaw_news',$list);
                    }else{
                        add_option('wztlaw_news',$list);
                    }
                    echo json_encode(['msg'=>1]);exit;  
                    break;
                case 8:
                    $list = [
                        'mobile'=>sanitize_text_field($data['mobile']),
                        'address'=>sanitize_text_field($data['address']),
                        'email'=>$data['email'],
                        'qrcode'=>$data['qrcode'],
                        'copy'=>sanitize_text_field($data['copy']),
                        'year'=>$data['year'],
                        'alt'=>$data['alt'],
                    ];
                    $wztlaw_foot = get_option('wztlaw_foot');
                    if($wztlaw_foot!==false){
                        update_option('wztlaw_foot',$list);
                    }else{
                        add_option('wztlaw_foot',$list);
                    }
                    echo json_encode(['msg'=>1]);exit;  
                    break;
                case 9:
                    for($i =1;$i<=$data['wzt_num'];$i++){
                        if(isset($data['name'.$i])){
                            $list['pic'][$i]['name'] = $data['name'.$i];
                        }
                        if(isset($data['url'.$i])){
                            $list['pic'][$i]['url'] = $data['url'.$i];
                        } 
                    }
                    $wztlaw_link = get_option('wztlaw_link');
                    if($wztlaw_link!==false){
                        update_option('wztlaw_link',$list);
                    }else{
                        add_option('wztlaw_link',$list);
                    }
                    echo json_encode(['msg'=>1]);exit;  
                    break;
                case 10:
                    $list = [
                        'title'=>sanitize_text_field($data['title']),
                        'title_en'=>sanitize_text_field($data['title_en']),
                        'term_id'=>(int)$data['term_id']
                    ];
                    if(isset($data['close'])){
                        $list['auto'] = 1;
                    }else{
                        $list['auto'] = 0;
                    }
                    if(isset($data['mobile_close'])){
                        $list['mobile_auto'] = 1;
                    }else{
                        $list['mobile_auto'] = 0;
                    }
                    $wztlaw_pic = get_option('wztlaw_pic_art');
                    if($wztlaw_pic!==false){
                        update_option('wztlaw_pic_art',$list);
                    }else{
                        add_option('wztlaw_pic_art',$list);
                    }  
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 11:
                    $list['key'] = sanitize_text_field($data['key']);
                    $wztlaw = get_option('wztlaw');
                    if($list!==false){
                        update_option('wztlaw',$list['key']);
                    }else{
                        add_option('wztlaw',$list['key']);
                    }
                    wztlaw_ss(1);
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 12:
                    $list = [
                        'wx'=>$data['wx'],
                        'alt'=>$data['alt'],
                        'qq'=>$data['qq'],
                        'wb'=>$data['wb'],
                        'email'=>$data['email'],
                        'mobile'=>$data['mobile']
                    ];
                    if(isset($data['close'])){
                        $list['auto'] = 1;
                    }else{
                        $list['auto'] = 0;
                    }
                    if(isset($data['mobile_close'])){
                        $list['mobile_auto'] = 1;
                    }else{
                        $list['mobile_auto'] = 0;
                    }
                    $wztlaw_social = get_option('wztlaw_social');
                    if($wztlaw_social!==false){
                        update_option('wztlaw_social',$list);
                    }else{
                        add_option('wztlaw_social',$list);
                    }  
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 13:
                    $list = [
                        'head_html'=>$data['head_html'],
                        'foot_html'=>$data['foot_html'],
                    ];
                    $wztlaw_html = get_option('wztlaw_html');
                    if($wztlaw_html!==false){
                        update_option('wztlaw_html',$list);
                    }else{
                        add_option('wztlaw_html',$list);
                    }  
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 14:
                    $list = [
                        'type'=>(int)$data['type'],
                        'num'=>(int)$data['num'],
                        'ex'=>$data['ex'],
                        'title'=>$data['title'],
                        'keywords'=>$data['keywords'],
                        'description'=>$data['description'],
                    ];
                    if(isset($data['is_ex'])){
                        $list['is_ex'] = 0;
                    }else{
                        $list['is_ex'] = 1;
                    }
                    $wztlaw_seo = get_option('wztlaw_seo');
                    if($wztlaw_seo!==false){
                        update_option('wztlaw_seo',$list);
                    }else{
                        add_option('wztlaw_seo',$list);
                    }
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 15:
                    if(isset($data['close'])){
                        $list['auto'] = 1;
                    }else{
                        $list['auto'] = 0;
                    }
                    if(isset($data['mobile_close'])){
                        $list['mobile_auto'] = 1;
                    }else{
                        $list['mobile_auto'] = 0;
                    }
                    
                    for($i =1;$i<=$data['wzt_num'];$i++){
                        if(isset($data['title'.$i])){
                            $list['pic'][$i]['title'] = $data['title'.$i];
                        }
                        if(isset($data['title_en'.$i])){
                            $list['pic'][$i]['title_en'] = $data['title_en'.$i];
                        }
                        if(isset($data['desc'.$i])){
                            $list['pic'][$i]['desc'] = $data['desc'.$i];
                        }
                        if(isset($data['alt'.$i])){
                            $list['pic'][$i]['alt'] = $data['alt'.$i];
                        }
                        
                        
                    }
                    $wztlaw_word = get_option('wztlaw_word');
                    if($wztlaw_word!==false){
                        update_option('wztlaw_word',$list);
                    }else{
                        add_option('wztlaw_word',$list);
                    }  
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 16:
                     $list = [
                        'title'=>sanitize_text_field($data['title']),
                       
                    ];
                    if(isset($data['lunbo_open'])){
                        $list['lunbo_open'] = 1;
                    }else{
                        $list['lunbo_open'] = 0;
                    }
                    if(isset($data['mobile_close'])){
                        $list['mobile_auto'] = 1;
                    }else{
                        $list['mobile_auto'] = 0;
                    }
                    
                    for($i =1;$i<=$data['wzt_num'];$i++){
                        if(isset($data['test'.$i])){
                            $list['pic'][$i]['test'] = $data['test'.$i];
                        }
                        if(isset($data['pc_alt'.$i])){
                            $list['pic'][$i]['pc_alt'] = $data['pc_alt'.$i];
                        }
                        
                        
                    }
                    $wztlaw_photo = get_option('wztlaw_photo');
                    if($wztlaw_photo!==false){
                        update_option('wztlaw_photo',$list);
                    }else{
                        add_option('wztlaw_photo',$list);
                    }  
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 17:
                     $list = [
                        'title'=>sanitize_text_field($data['title']),
                        'title_en'=>sanitize_text_field($data['title_en']),
                       
                    ];
                    if(isset($data['lunbo_open'])){
                        $list['lunbo_open'] = 1;
                    }else{
                        $list['lunbo_open'] = 0;
                    }
                    if(isset($data['mobile_close'])){
                        $list['mobile_auto'] = 1;
                    }else{
                        $list['mobile_auto'] = 0;
                    }
                    
                    for($i =1;$i<=$data['wzt_num'];$i++){
                        if(isset($data['position'.$i])){
                            $list['pic'][$i]['position'] = $data['position'.$i];
                        }
                        if(isset($data['desc'.$i])){
                            $list['pic'][$i]['desc'] = $data['desc'.$i];
                        }
                    }
                    $wztlaw_zhao = get_option('wztlaw_zhao');
                    if($wztlaw_zhao!==false){
                        update_option('wztlaw_zhao',$list);
                    }else{
                        add_option('wztlaw_zhao',$list);
                    }  
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 18:
                    $list  = [
                        'back'=>sanitize_text_field($data['back']),
                        'alt'=>sanitize_text_field($data['alt']),
                    ];
                    if(isset($data['lunbo_open'])){
                        $list['lunbo_open'] = 1;
                    }else{
                        $list['lunbo_open'] = 0;
                    }
                    if(isset($data['mobile_close'])){
                        $list['mobile_auto'] = 1;
                    }else{
                        $list['mobile_auto'] = 0;
                    }
                    
                    for($i =1;$i<=$data['wzt_num'];$i++){
                        if(isset($data['name'.$i])){
                            $list['pic'][$i]['name'] = $data['name'.$i];
                        }
                        if(isset($data['number'.$i])){
                            $list['pic'][$i]['number'] = $data['number'.$i];
                        }
                        
                        
                    }
                    $wztlaw_number = get_option('wztlaw_number');
                    if($wztlaw_number!==false){
                        update_option('wztlaw_number',$list);
                    }else{
                        add_option('wztlaw_number',$list);
                    }  
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 19:
                    if(isset($data['open'])){
                        $list['open'] = 1;
                    }else{
                        $list['open'] = 0;
                    }
                    $wztlaw_message = get_option('wztlaw_message');
                    if($wztlaw_message!==false){
                        update_option('wztlaw_message',$list);
                    }else{
                        add_option('wztlaw_message',$list);
                    }
                    if($list['open']==1){
                        global $wpdb;
                        $charset_collate = '';
                        if (!empty($wpdb->charset)) {
                          $charset_collate = "DEFAULT CHARACTER SET {$wpdb->charset}";
                        }
                        if (!empty( $wpdb->collate)) {
                          $charset_collate .= " COLLATE {$wpdb->collate}";
                        }
                        $sql1 = "CREATE TABLE " . $wpdb->prefix . "wztlaw_message   (
                            id int(10) NOT NULL AUTO_INCREMENT,
                            name varchar(100)  NULL ,
                            mobile varchar(100) NOT NULL,
                            email varchar(100)  NULL,
                            address text  NULL,
                            content text  NULL,
                            UNIQUE KEY id (id)
                        ) $charset_collate;";
                        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
                        dbDelta($sql1);
                    }
                    echo json_encode(['msg'=>1]);exit;
                    break;
                case 20:
                    global $wpdb;
                    foreach($data['value'] as $key=>$val){
                	    $term = (int)$val['id'];
                	    $res = $wpdb->query( "DELETE FROM " . $wpdb->prefix . "wztlaw_message where id=".$term); 
                	}
                	echo json_encode(['msg'=>'1']);exit;
                    break;
            }
        }
        
    }
    public function wztlaw_addpages(){
        $res = $this->wztlaw_option();
        
        if($res){
            add_menu_page('主题设置', '主题设置', 'manage_options', 'wztlaw', [$this,'wztlaw_toplevelpage'] );
        }else{
            add_menu_page('主题激活', '主题激活', 'manage_options', 'wztlaw', [$this,'wztlaw_theme_active'] );
        }
    }
    public function wztlaw_theme_active(){
        
        require plugin_dir_path(__FILE__).'template/jihuo.php';
    }
    public function wztlaw_option(){
        $wztlaw = get_option('wztlaw');
        $wztlaw = get_option('wztlaw_'.$wztlaw);
        return $wztlaw;
       
    }
    public function wztlaw_toplevelpage(){
        global $wpdb;
        $wzt_page = isset($_GET['law_page'])?(int)$_GET['law_page']:1;
        require plugin_dir_path(__FILE__).'template/header.php';
        $wztlaw = get_option('wztlaw');
        switch($wzt_page){
            case 1:
                $wztlaw_theme = get_option('wztlaw_theme');
                require plugin_dir_path(__FILE__).'template/setting.php';
                break;
            case 2:
                $wztlaw_index = get_option('wztlaw_index');
                require plugin_dir_path(__FILE__).'template/index.php';
                break;
            case 3:
                $wztlaw_index = get_option('wztlaw_lunbo');
                require plugin_dir_path(__FILE__).'template/lunbo.php';
                break;
            case 4:
                $wztlaw_index = get_option('wztlaw_about');
                require plugin_dir_path(__FILE__).'template/about.php';
                break;
            case 5:
                $wztlaw_index = get_option('wztlaw_business');
                require plugin_dir_path(__FILE__).'template/business.php';
                break;
            case 6:
                $wztlaw_index = get_option('wztlaw_pic');
                require plugin_dir_path(__FILE__).'template/pic.php';
                break;
            case 7:
                $wztlaw_index = get_option('wztlaw_news');
                $cate = $wpdb->get_results('select distinct a.* from '.$wpdb->prefix.'terms as a join '.$wpdb->prefix.'term_taxonomy as b on a.term_id=b.term_id join '.$wpdb->prefix.'term_relationships as c on b.term_taxonomy_id=c.term_taxonomy_id where b.taxonomy="category"');
                require plugin_dir_path(__FILE__).'template/news.php';
                break;
            case 8:
                $wztlaw_index = get_option('wztlaw_foot');
                require plugin_dir_path(__FILE__).'template/foot.php';
                break;
            case 9:
                $wztlaw_index = get_option('wztlaw_link');
                require plugin_dir_path(__FILE__).'template/link.php';
                break;
            case 10:
                $cate = $wpdb->get_results('select distinct a.* from '.$wpdb->prefix.'terms as a join '.$wpdb->prefix.'term_taxonomy as b on a.term_id=b.term_id join '.$wpdb->prefix.'term_relationships as c on b.term_taxonomy_id=c.term_taxonomy_id where b.taxonomy="category"');
                $wztlaw_index = get_option('wztlaw_pic_art');
                require plugin_dir_path(__FILE__).'template/pic_art.php';
                break;
            case 12:
                $wztlaw_theme = get_option('wztlaw_social');
                require plugin_dir_path(__FILE__).'template/social.php';
                break;
            case 13:
                $wztlaw_index = get_option('wztlaw_html');
                require plugin_dir_path(__FILE__).'template/html.php';
                break;
             case 14:
                $wztlaw_index = get_option('wztlaw_seo');
                require plugin_dir_path(__FILE__).'template/seo.php';
                break;
            case 15:
                $wztlaw_index = get_option('wztlaw_word');
                require plugin_dir_path(__FILE__).'template/word.php';
                break;
            case 16:
                $wztlaw_index = get_option('wztlaw_photo');
                require plugin_dir_path(__FILE__).'template/photo.php';
                break;
            case 17:
                $wztlaw_index = get_option('wztlaw_zhao');
                require plugin_dir_path(__FILE__).'template/zhao.php';
                break;
            case 18:
                $wztlaw_index = get_option('wztlaw_number');
                require plugin_dir_path(__FILE__).'template/number.php';
                break;
            case 19:
                $wztlaw_index = get_option('wztlaw_message');
                require plugin_dir_path(__FILE__).'template/message.php';
                break;    
        }
        require plugin_dir_path(__FILE__).'template/footer.php';
    }
    
}
?>