<style>
    .layui-btn {
        background-color: #32cdff;
    }
</style>
<div style="padding-top:20px">
<form class="layui-form" action="" onsubmit="return false">
    <div class="layui-form-item">
         <label class="layui-form-label">热线电话</label>
	     <div class="layui-input-block">
	      <input type="text" name="mobile"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['mobile'])){echo $wztlaw_index['mobile'];}?>">
	     </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">公司地址</label>
	     <div class="layui-input-block">
	      <input type="text" name="address"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['address'])){echo $wztlaw_index['address'];}?>">
	     </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">备案年份</label>
	     <div class="layui-input-block">
	      <input type="text" name="year"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['year'])){echo $wztlaw_index['year'];}?>">
	     </div>
	</div>
    <div class="layui-form-item">
         <label class="layui-form-label">公司备案</label>
         <div class="layui-input-block">
          <input type="text" name="copy"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['copy'])){echo $wztlaw_index['copy'];}?>">
         </div>
    </div>
	<div class="layui-form-item">
         <label class="layui-form-label">邮箱</label>
	     <div class="layui-input-block">
	       <input type="text" name="email"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['email'])){echo $wztlaw_index['email'];}?>">
	     </div>
	</div>
      <div class="layui-form-item">
        <label class="layui-form-label">二维码</label>
        <div class="layui-upload">
            <button type="button" class="layui-btn" id="test1" >上传图片</button>
            <input type="hidden" name="qrcode" value="<?php  if(isset($wztlaw_index['qrcode']) && $wztlaw_index['qrcode']){echo $wztlaw_index['qrcode'];}?>" >
            <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
                    <img class="layui-upload-img" id="demo1" style="width:200px" src="<?php if(isset($wztlaw_index['qrcode']) && $wztlaw_index['qrcode']){echo $wztlaw_index['qrcode'];}?>">
                
                <p id="demoText"></p>
            </div>
            <p class="delete_pic"><img src="<?php echo  get_template_directory_uri().'/assets/images/'?>cha.png" style="position:relative;width:24px;height:24px;top:-224px;left:299px"></p>
        </div>
    </div>
    <div class="layui-form-item">
         <label class="layui-form-label">alt描述</label>
	     <div class="layui-input-block">
	      <input type="text" name="alt"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['alt'])){echo $wztlaw_index['alt'];}?>">
	     </div>
	</div>
		<div class="layui-form-item">
         <label class="layui-form-label">底部背景色</label>
	     <div class="layui-input-block">
          <div class="layui-input-inline" style="width: 120px;">
            <input type="text" value="<?php if(isset($wztlaw_index['bg']) && $wztlaw_index['bg']){echo $wztlaw_index['bg']; }else{echo '#005595';}?>" placeholder="请选择颜色" class="layui-input" id="test-form-input" name="bg">
          </div>
          <div class="layui-inline" style="left: -11px;">
            <div id="test-form"></div>
          </div>
        </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">底部字体颜色</label>
	     <div class="layui-input-block">
          <div class="layui-input-inline" style="width: 120px;">
            <input type="text" value="<?php if(isset($wztlaw_index['color']) && $wztlaw_index['color']){echo $wztlaw_index['color']; }else{echo '#fff';}?>" placeholder="请选择颜色" class="layui-input" id="test-form-input1" name="color">
          </div>
          <div class="layui-inline" style="left: -11px;">
            <div id="test-form1"></div>
          </div>
        </div>
	</div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        	<input type="hidden" name="wztlaw" value="8">
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
        ,color: '<?php if(isset($wztlaw_index['bg']) && $wztlaw_index['bg']){echo $wztlaw_index['bg']; }else{echo '#005595';}?>'
        ,done: function(color){
          $('#test-form-input').val(color);
        }
      });
      colorpicker.render({
        elem: '#test-form1'
        ,color: '<?php if(isset($wztlaw_index['color']) && $wztlaw_index['color']){echo $wztlaw_index['color']; }else{echo '#fff';}?>'
        ,done: function(color){
          $('#test-form-input1').val(color);
        }
      });
       $('.delete_pic').click(function(){
            $(this).prev('div').find('img').attr('src','');
            $('input[name="qrcode"]').val('');
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
                
                $('input[name="qrcode"]').val(attachment.url);   
                $('#demo1').attr('src',attachment.url);
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