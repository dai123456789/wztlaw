<style>
    .layui-form-onswitch {
        border-color: #32cdff;
        background-color: #32cdff;
    }
    .layui-btn {
        background-color: #32cdff;
    }
</style>
<div style="padding-top:20px">
<form class="layui-form" action="" submit="return false">
     <div class="layui-form-item">
	    <label class="layui-form-label">是否开启</label>
	    <div class="layui-input-block" >
	    	<?php 
	    		if(isset($wztlaw_theme['auto']) && ($wztlaw_theme['auto']==1)){
	    			 echo '<input type="checkbox" name="close" lay-skin="switch" lay-text="开|关" checked="">';
	    		}else{
	    			echo '<input type="checkbox" name="close" lay-skin="switch" lay-text="开|关">';
	    		}
	    	?>
	    </div>
	  </div>
      <div class="layui-form-item">
        <label class="layui-form-label">手机端是否显示</label>
        <div class="layui-input-block" >
            <?php 
                if(isset($wztlaw_theme['mobile_auto']) && ($wztlaw_theme['mobile_auto']==1)){
                     echo '<input type="checkbox" name="mobile_close" lay-skin="switch" lay-text="开|关" checked="">';
                }else{
                    echo '<input type="checkbox" name="mobile_close" lay-skin="switch" lay-text="开|关">';
                }
            ?>
        </div>
      </div>
    <div class="layui-form-item">
        <label class="layui-form-label">微信二维码</label>
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="test1">上传图片</button>
            <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
                <?php if(isset($wztlaw_theme['wx']) && $wztlaw_theme['wx']){
                        echo '<img class="layui-upload-img" id="demo1" style="width:200px" src="'.$wztlaw_theme['wx'].'">';
                    }else{
                        echo '<img class="layui-upload-img" id="demo1" style="width:200px">';
                    }
                ?>
                
                <p id="demoText"></p>
                
            </div>
            <p class="delete_pic"><img src="<?php echo  get_template_directory_uri().'/assets/images/'?>cha.png" style="position:relative;width:24px;height:24px;top:-224px;left:299px"></p>
           <span style="color:red;margin-left:110px">提示：请上传150x150尺寸的图片</span>
        </div>
    </div>
     <div class="layui-form-item">
         <label class="layui-form-label">alt描述</label>
	     <div class="layui-input-block">
	      <input type="text" name="alt"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_theme['alt'])){echo $wztlaw_theme['alt'];}?>" style="width:36%">
	     </div>
	</div>
     <div class="layui-form-item">
         <label class="layui-form-label">客服QQ号码</label>
	     <div class="layui-input-block">
	      <input type="text" name="qq"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_theme['qq'])){echo $wztlaw_theme['qq'];}?>" style="width:36%">
	     </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">官方新浪微博</label>
	     <div class="layui-input-block">
	      <input type="text" name="wb"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_theme['wb'])){echo $wztlaw_theme['wb'];}?>" style="width:36%">
	     </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">邮箱</label>
	     <div class="layui-input-block">
	      <input type="text" name="email"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_theme['email'])){echo $wztlaw_theme['email'];}?>" style="width:36%">
	     </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">电话</label>
	     <div class="layui-input-block">
	      <input type="text" name="mobile"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_theme['mobile'])){echo $wztlaw_theme['mobile'];}?>" style="width:36%">
	     </div>
	</div>
    <div class="layui-form-item">
    <div class="layui-input-block">
    	<input type="hidden" name="wztlaw" value="12">
    	<input type="hidden" name="wx" value="<?php if(isset($wztlaw_theme['wx'])){echo $wztlaw_theme['wx'];} ?>">
    	<input type="hidden" name="action" value="<?php echo $wztlaw; ?>">
    	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce($wztlaw);?>">
      <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
    </div>
    </div>
</form>
</div>
<script>
jQuery(document).ready(function($){
    layui.use(['form','layer','element'], function(){
      var element = layui.element
      var form = layui.form
      ,layer = layui.layer
     
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
                
                $('input[name="wx"]').val(attachment.url);   
                $('#demo1').attr('src',attachment.url);
            });    
            upload_frame.open();   
        })
        $('.delete_pic').click(function(){
            $(this).prev('div').find('img').attr('src','');
            $('input[name="wx"]').val('');
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

  
