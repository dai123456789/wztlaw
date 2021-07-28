<style>
    .layui-form-radio>i {
        color:#32cdff;
    }
    .layui-form-onswitch {
        border-color: #32cdff;
        background-color: #32cdff;
    }
    .layui-btn {
        background-color: #32cdff;
    }
</style>
<div style="padding-top:20px">
<form class="layui-form" action="" onsubmit="return false">
     <div class="layui-form-item">
	    <label class="layui-form-label">是否开启</label>
	    <div class="layui-input-block" >
	    	<?php 
	    		if(isset($wztlaw_index['auto']) && ($wztlaw_index['auto']==1)){
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
                if(isset($wztlaw_index['mobile_auto']) && ($wztlaw_index['mobile_auto']==1)){
                     echo '<input type="checkbox" name="mobile_close" lay-skin="switch" lay-text="开|关" checked="">';
                }else{
                    echo '<input type="checkbox" name="mobile_close" lay-skin="switch" lay-text="开|关">';
                }
            ?>
        </div>
      </div>
      <div class="layui-form-item">
	    <label class="layui-form-label">首行缩进</label>
	    <div class="layui-input-block" >
	    	<?php 
	    		if(isset($wztlaw_index['indent']) && ($wztlaw_index['indent']==1)){
	    			 echo '<input type="checkbox" name="indent" lay-skin="switch" lay-text="开|关" checked="">';
	    		}else{
	    			echo '<input type="checkbox" name="indent" lay-skin="switch" lay-text="开|关">';
	    		}
	    	?>
	    </div>
	  </div>
    <div class="layui-form-item">
         <label class="layui-form-label">模块标题</label>
	     <div class="layui-input-block">
	      <input type="text" name="title"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['title'])){echo $wztlaw_index['title'];}?>">
	     </div>
	</div>
     <div class="layui-form-item">
         <label class="layui-form-label">英文标题</label>
         <div class="layui-input-block">
          <input type="text" name="title_en"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['title_en'])){echo $wztlaw_index['title_en'];}?>">
         </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">模块样式</label>
        <div class="layui-input-block">
          <input type="radio" name="flex" value="1" title="图片居左" <?php if((isset($wztlaw_index['flex']) && $wztlaw_index['flex'] ==1)||(!isset($wztlaw_index['flex']))){echo 'checked';}?>>
          <input type="radio" name="flex" value="2" title="图片居右" <?php if(isset($wztlaw_index['flex']) && $wztlaw_index['flex'] ==2){echo 'checked';}?>>
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">特色图像</label>
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="test1" >上传图片</button>
            <input type="hidden" name="pic" value="<?php  if(isset($wztlaw_index['pic']) && $wztlaw_index['pic']){echo $wztlaw_index['pic'];}?>" >
            <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
                    <img class="layui-upload-img" id="demo1" style="width:200px" src="<?php if(isset($wztlaw_index['pic']) && $wztlaw_index['pic']){echo $wztlaw_index['pic'];}?>">
                
                
            </div>
            <p class="delete_pic"><img src="<?php echo  get_template_directory_uri().'/assets/images/'?>cha.png" style="position:relative;width:24px;height:24px;top:-224px;left:299px"></p>
            <span style="color:red;margin-left:110px">提示：请上传540*360px尺寸的图片</span>
        </div>
    </div>
     <div class="layui-form-item">
         <label class="layui-form-label">alt描述</label>
         <div class="layui-input-block">
          <input type="text" name="alt"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['alt'])){echo $wztlaw_index['alt'];}?>">
         </div>
    </div>
	<div class="layui-form-item">
         <label class="layui-form-label">模块描述</label>
	     <div class="layui-input-block">
	       <textarea placeholder="请输入内容" class="layui-textarea" name="description"><?php if(isset($wztlaw_index['description'])){echo $wztlaw_index['description'];}?></textarea>
	     </div>
	</div>
     <div class="layui-form-item">
         <label class="layui-form-label">跳转链接</label>
         <div class="layui-input-block">
          <input type="text" name="url"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['url'])){echo $wztlaw_index['url'];}?>">
         </div>
         <span style="color:red;margin-left:110px">跳转链接请填写http(s)://</span>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        	<input type="hidden" name="wztlaw" value="4">
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
                
                $('input[name="pic"]').val(attachment.url);   
                $('#demo1').attr('src',attachment.url);
            });    
            upload_frame.open();   
        }) 
        $('.delete_pic').click(function(){
            $(this).prev('div').find('img').attr('src','');
            $('input[name="pic"]').val('');
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