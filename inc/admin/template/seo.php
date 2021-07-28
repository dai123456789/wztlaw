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
    <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
      <legend>文章设置</legend>
    </fieldset>
    <div class="layui-form-item">
        <label class="layui-form-label"></label>
        <div class="layui-input-block">
            <input type="radio" name="type" value="1" title="手动填写" <?php if(!isset($wztlaw_index['type']) || (isset($wztlaw_index['type'] ) && $wztlaw_index['type']==1)){echo 'checked=""';} ?> lay-filter="type">
            <input type="radio" name="type" value="2" title="自动获取" lay-filter="type" <?php if(isset($wztlaw_index['type'] ) && $wztlaw_index['type']==2){echo 'checked=""';} ?>>
        </div>
    </div>
    <div style="display:<?php if(isset($wztlaw_index['type'] ) && $wztlaw_index['type']==2){echo 'block';}else{echo 'none';} ?>" class="zd">
    
	<div class="layui-form-item">
         <label class="layui-form-label">描述截取字数</label>
	     <div class="layui-input-block">
	      <input type="text" name="num"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['num'])){echo $wztlaw_index['num'];}?>">
	     </div>
	</div>
	</div>
	 <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
      <legend>全局设置</legend>
    </fieldset>
		 <div class="layui-form-item">
	    <label class="layui-form-label">是否开启title后缀</label>
	    <div class="layui-input-block" >
	    	<?php 
	    		if(isset($wztlaw_index['is_ex']) && ($wztlaw_index['is_ex']==1)){
	    			 echo '<input type="checkbox" name="is_ex" lay-skin="switch" lay-text="开|关" >';
	    		}else{
	    			echo '<input type="checkbox" name="is_ex" lay-skin="switch" lay-text="开|关" checked="">';
	    		}
	    	?>
	    </div>
	 </div>
	<div class="layui-form-item">
         <label class="layui-form-label">Title后缀分隔符</label>
	     <div class="layui-input-block">
	      <input type="text" name="ex"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['ex'])){echo $wztlaw_index['ex'];}?>">
	     </div>
	</div>
    <div class="layui-form-item">
         <label class="layui-form-label">seo标题</label>
	     <div class="layui-input-block">
	      <input type="text" name="title"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['title'])){echo $wztlaw_index['title'];}?>">
	     </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">seo关键词</label>
	     <div class="layui-input-block">
	      <input type="text" name="keywords"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['keywords'])){echo $wztlaw_index['keywords'];}?>">
	     </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">seo描述</label>
	     <div class="layui-input-block">
	       <textarea placeholder="请输入内容" class="layui-textarea" name="description"><?php if(isset($wztlaw_index['description'])){echo $wztlaw_index['description'];}?></textarea>
	     </div>
	</div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        	<input type="hidden" name="wztlaw" value="14">
        	<input type="hidden" name="action" value="<?php echo $wztlaw; ?>">
        	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce($wztlaw);?>">
          <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
        </div>
    </div>
</form>
<div style="line-height: 30px;margin-left: 110px;color: red;">
    <div>1、如果您wordpress已经设置了网站标题，该标题可以留空不用填写，否则会被替换</div>
    <div>2、多个关键词请您用英文逗号隔开，SEO建议核心词只填写1-5个，过多会触发关键词堆砌问题</div>
    <div>3、描述，请填写200字以内且包含关键词的内容，不要写无关的描述，不利于SEO优化。因为他涉及关键词密度问题</div>
</div>
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