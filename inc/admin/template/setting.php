<style>
    .layui-btn {
        background-color: #32cdff;
    }
</style>
<div style="padding-top:20px">
<form class="layui-form" action="" submit="return false">
    <div class="layui-form-item">
        <label class="layui-form-label">电脑端logo</label>
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="test1">上传图片</button>
            <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
                <?php if(isset($wztlaw_theme['pc_logo']) && $wztlaw_theme['pc_logo']){
                        echo '<img class="layui-upload-img" id="demo1" style="width:200px" src="'.$wztlaw_theme['pc_logo'].'">';
                    }else{
                        echo '<img class="layui-upload-img" id="demo1" style="width:200px">';
                    }
                ?>
                
                <p id="demoText"></p>
                
            </div>
            <p class="delete_pic"><img src="<?php echo  get_template_directory_uri().'/assets/images/'?>cha.png" style="position:relative;width:24px;height:24px;top:-224px;left:299px"></p>
           <span style="color:red;margin-left:110px">提示：请上传270(270~726)X64尺寸的图片</span>
        </div>
    </div>
     <div class="layui-form-item">
         <label class="layui-form-label">alt描述</label>
	     <div class="layui-input-block">
	      <input type="text" name="pc_alt"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_theme['pc_alt'])){echo $wztlaw_theme['pc_alt'];}?>" style="width:36%">
	     </div>
	</div>
     <div class="layui-form-item">
        <label class="layui-form-label">手机端logo</label>
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="test2">上传图片</button>
            <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
            <?php if(isset($wztlaw_theme['mobile_logo']) && $wztlaw_theme['mobile_logo']){
                        echo '<img class="layui-upload-img" id="demo2" style="width:200px" src="'.$wztlaw_theme['mobile_logo'].'">';
                    }else{
                        echo '<img class="layui-upload-img" id="demo2" style="width:200px">';
                    }
                ?>
            <p id="demoText"></p>
            </div>
            <p class="delete_pic2"><img src="<?php echo  get_template_directory_uri().'/assets/images/'?>cha.png" style="position:relative;width:24px;height:24px;top:-224px;left:299px"></p>
            <span style="color:red;margin-left:110px">提示：请上传46(46~185)x46尺寸的图片</span>
        </div>
    </div>
     <div class="layui-form-item">
         <label class="layui-form-label">alt描述</label>
	     <div class="layui-input-block">
	      <input type="text" name="mobile_alt"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_theme['mobile_alt'])){echo $wztlaw_theme['mobile_alt'];}?>" style="width:36%">
	     </div>
	</div>

	<div class="layui-form-item">
        <label class="layui-form-label">favicon</label>
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="test3">上传图片</button>
            <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
                <?php if(isset($wztlaw_theme['favicon']) && $wztlaw_theme['favicon']){
                        echo '<img class="layui-upload-img" id="demo3" style="width:200px" src="'.$wztlaw_theme['favicon'].'">';
                    }else{
                        echo '<img class="layui-upload-img" id="demo3" style="width:200px">';
                    }
                ?>
            <p id="demoText"></p>
            </div>
            <p class="delete_pic3"><img src="<?php echo  get_template_directory_uri().'/assets/images/'?>cha.png" style="position:relative;width:24px;height:24px;top:-224px;left:299px"></p>
            <span style="color:red;margin-left:110px">提示：主要是浏览器标签图标，利于SEO加分</span>
        </div>
    </div>
    	<div class="layui-form-item">
         <label class="layui-form-label">头部背景色</label>
	     <div class="layui-input-block">
          <div class="layui-input-inline" style="width: 120px;">
            <input type="text" value="<?php if(isset($wztlaw_theme['bg']) && $wztlaw_theme['bg']){echo $wztlaw_theme['bg']; }else{echo '#fff';}?>" placeholder="请选择颜色" class="layui-input" id="test-form-input" name="bg">
          </div>
          <div class="layui-inline" style="left: -11px;">
            <div id="test-form"></div>
          </div>
        </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">头部字体颜色</label>
	     <div class="layui-input-block">
          <div class="layui-input-inline" style="width: 120px;">
            <input type="text" value="<?php if(isset($wztlaw_theme['color']) && $wztlaw_theme['color']){echo $wztlaw_theme['color']; }else{echo '#333';}?>" placeholder="请选择颜色" class="layui-input" id="test-form-input1" name="color">
          </div>
          <div class="layui-inline" style="left: -11px;">
            <div id="test-form1"></div>
          </div>
        </div>
	</div>
    <div class="layui-form-item">
    <div class="layui-input-block">
    	<input type="hidden" name="wztlaw" value="1">
    	<input type="hidden" name="pc_logo" value="<?php if(isset($wztlaw_theme['pc_logo'])){echo $wztlaw_theme['pc_logo'];} ?>">
    	<input type="hidden" name="mobile_logo" value="<?php if(isset($wztlaw_theme['mobile_logo'])){echo $wztlaw_theme['mobile_logo'];} ?>">
    	<input type="hidden" name="favicon" value="<?php if(isset($wztlaw_theme['favicon'])){echo $wztlaw_theme['favicon'];} ?>">
    	<input type="hidden" name="action" value="<?php echo $wztlaw; ?>">
    	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce($wztlaw);?>">
      <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
    </div>
    </div>
</form>
</div>
<script>
jQuery(document).ready(function($){
    layui.use(['form','layer','element','colorpicker'], function(){
      var element = layui.element
      var form = layui.form
      ,layer = layui.layer
      ,colorpicker = layui.colorpicker;
      
     colorpicker.render({
        elem: '#test-form'
        ,color: '<?php if(isset($wztlaw_theme['bg']) && $wztlaw_theme['bg']){echo $wztlaw_theme['bg']; }else{echo '#fff';}?>'
        ,done: function(color){
          $('#test-form-input').val(color);
        }
      });
      colorpicker.render({
        elem: '#test-form1'
        ,color: '<?php if(isset($wztlaw_theme['color']) && $wztlaw_theme['color']){echo $wztlaw_theme['color']; }else{echo '#333';}?>'
        ,done: function(color){
          $('#test-form-input1').val(color);
        }
      });
      $('.delete_pic').click(function(){
         $(this).prev('div').find('img').attr('src','');
         $('input[name="pc_logo"]').val('');
      })
      $('.delete_pic2').click(function(){
         $(this).prev('div').find('img').attr('src','');
         $('input[name="mobile_logo"]').val('');
      })
      $('.delete_pic3').click(function(){
         $(this).prev('div').find('img').attr('src','');
         $('input[name="favicon"]').val('');
      })
        $('#test1').click(function(){     
            event.preventDefault();   
            
            upload_frame = wp.media({   
                title: '添加图片',   
                button: {   
                    text: '选择图片',   
                },   
                multiple: false   
            });   
            upload_frame.on('select',function(){   
                attachment = upload_frame.state().get('selection').first().toJSON(); 
                
                $('input[name="pc_logo"]').val(attachment.url);   
                $('#demo1').attr('src',attachment.url);
            });    
            upload_frame.open();   
        }) 
        $('#test2').click(function(){     
            event.preventDefault();   
            
            upload_frame = wp.media({   
                title: '添加图片',   
                button: {   
                    text: '选择图片',   
                },   
                multiple: false   
            });   
            upload_frame.on('select',function(){   
                attachment = upload_frame.state().get('selection').first().toJSON(); 
                
                $('input[name="mobile_logo"]').val(attachment.url);   
                $('#demo2').attr('src',attachment.url);
            });    
            upload_frame.open();   
        }) 
        $('#test3').click(function(){     
            event.preventDefault();   
            
            upload_frame = wp.media({   
                title: '添加图片',   
                button: {   
                    text: '选择图片',   
                },   
                multiple: false   
            });   
            upload_frame.on('select',function(){   
                attachment = upload_frame.state().get('selection').first().toJSON(); 
                
                $('input[name="favicon"]').val(attachment.url);   
                $('#demo3').attr('src',attachment.url);
            });    
            upload_frame.open();   
        }) 
       
        form.on('submit(demo1)', function(data){
           var index = layer.load(1, {
              shade: [0.7,'#111'] //0.1透明度的白色背景
            });
            $.ajax({
                url:'',
                data:{data:JSON.stringify(data.field)},
                type:'post',
                dataType:'json',
                success:function(data){
                    
                    if(data.msg==1){
                        layer.close(index);
                        layer.alert('保存成功');
                        location.reload();
                        
                    }else{
                        layer.close(index);
                        layer.msg('保存失败，请刷新后重试');
                    }
                }
            })
            
            return false;
        });
         
         
         
    });
});
</script>

  
