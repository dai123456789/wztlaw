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
<form class="layui-form" action="" onsubmit="return false">
   
    <div class="layui-form-item">
	    <label class="layui-form-label">首页特效</label>
	    <div class="layui-input-block" >
	    	<?php 
	    		if(isset($wztlaw_index['is_texiao']) && ($wztlaw_index['is_texiao']==1)){
	    			 echo '<input type="checkbox" name="close" lay-skin="switch" lay-text="开|关" checked="">';
	    		}else{
	    			echo '<input type="checkbox" name="close" lay-skin="switch" lay-text="开|关">';
	    		}
	    	?>
	    </div>
	 </div>
	 <div class="layui-form-item">
	    <label class="layui-form-label">古腾堡编辑器</label>
	    <div class="layui-input-block" >
	    	<?php 
	    		if(isset($wztlaw_index['gu']) && ($wztlaw_index['gu']==1)){
	    			 echo '<input type="checkbox" name="gu" lay-skin="switch" lay-text="开|关" checked="">';
	    		}else{
	    			echo '<input type="checkbox" name="gu" lay-skin="switch" lay-text="开|关">';
	    		}
	    	?>
	    </div>
	 </div>
		<div class="layui-form-item">
         <label class="layui-form-label">小工具侧边栏背景色</label>
	     <div class="layui-input-block">
          <div class="layui-input-inline" style="width: 120px;">
            <input type="text" value="<?php if(isset($wztlaw_index['bg']) && $wztlaw_index['bg']){echo $wztlaw_index['bg']; }else{echo '#BC1515';}?>" placeholder="请选择颜色" class="layui-input" id="test-form-input" name="bg">
          </div>
          <div class="layui-inline" style="left: -11px;">
            <div id="test-form"></div>
          </div>
        </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">小工具侧边栏字体颜色</label>
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
         <label class="layui-form-label">鼠标事件颜色</label>
	     <div class="layui-input-block">
          <div class="layui-input-inline" style="width: 120px;">
            <input type="text" value="<?php if(isset($wztlaw_index['mouse']) && $wztlaw_index['mouse']){echo $wztlaw_index['mouse']; }else{echo '#BC1515';}?>" placeholder="请选择颜色" class="layui-input" id="test-form-input2" name="mouse">
          </div>
          <div class="layui-inline" style="left: -11px;">
            <div id="test-form2"></div>
          </div>
        </div>
	</div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        	<input type="hidden" name="wztlaw" value="2">
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
        ,color: '<?php if(isset($wztlaw_index['bg']) && $wztlaw_index['bg']){echo $wztlaw_index['bg']; }else{echo '#BC1515';}?>'
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
      colorpicker.render({
        elem: '#test-form2'
        ,color: '<?php if(isset($wztlaw_index['mouse']) && $wztlaw_index['mouse']){echo $wztlaw_index['mouse']; }else{echo '#BC1515';}?>'
        ,done: function(color){
          $('#test-form-input2').val(color);
        }
      });
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
        form.on('radio(type)',function(data){
           
            if(data.elem.value==2){
                $('.zd').css('display','block');
            }else{
                 $('.zd').css('display','none');
            }

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