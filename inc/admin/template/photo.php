<style>
    .layui-form-onswitch {
        border-color: #32cdff;
        background-color: #32cdff;
    }
    .layui-btn {
        background-color: #32cdff;
    }
    .layui-btn-danger {
        background-color: #FF5722;
    }
    .layui-btn-normal {
        background-color: #1E9FFF;
    }
</style>
<div style="padding-top:20px">
<form class="layui-form" action="" submit="return false">
	<div class="layui-form-item">
	    <label class="layui-form-label">是否开启</label>
	    <div class="layui-input-block" >
	    	<?php 
	    		if(isset($wztlaw_index['lunbo_open']) && ($wztlaw_index['lunbo_open']==1)){
	    			 echo '<input type="checkbox" name="lunbo_open" lay-skin="switch" lay-text="开|关" checked="" lay-filter="lunbo_open">';
	    		}else{
	    			echo '<input type="checkbox" name="lunbo_open" lay-skin="switch" lay-text="开|关" lay-filter="lunbo_open">';
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
         <label class="layui-form-label">模块标题</label>
	     <div class="layui-input-block">
	      <input type="text" name="title"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['title'])){echo $wztlaw_index['title'];}?>">
	     </div>
	  </div>
	<div style="margin:20px 110px" class="lunbo_list">
		<?php 
			$i =0;
			if(isset($wztlaw_index['pic']) && $wztlaw_index['pic']){
			foreach($wztlaw_index['pic'] as $key=>$val){
				++$i;
				echo '<div class="layui-collapse" lay-accordion="">
        			<div class="layui-colla-item">
        				<h2 class="layui-colla-title">图册</h2>
        				<div class="layui-colla-content">
							<div class="layui-form-item">
						        <label class="layui-form-label">图片</label>
						        <div class="layui-upload" style="position: relative;">
						            <button type="button" class="layui-btn" id="test'.$i.'" onclick="test('.$i.')">上传图片</button>
						            <input type="hidden" name="test'.$i.'" value="'.$val['test'].'">
						            <div style="position: absolute;top: 50px;left: 330px;color: red;">推荐尺寸 390*500</div>
						            <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
						               		<img class="layui-upload-img" id="demo'.$i.'" style="width:200px" src="'.$val['test'].'">
						                
						                <p id="demoText"></p>
						            </div>
						        </div>
						    </div>
						    <div class="layui-form-item">
                                 <label class="layui-form-label">alt描述</label>
                        	     <div class="layui-input-block">
                        	      <input type="text" name="pc_alt'.$i.'"   autocomplete="off" placeholder="" class="layui-input" value="'.$val['pc_alt'].'" style="width:36%">
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
        		</div>';
			}
		}
			
		?>
	</div>
	<div class="layui-form-item lunbo_add" <?php if(isset($wztlaw_index['lunbo_open']) && ($wztlaw_index['lunbo_open']==1)){}else{echo 'style="display:none"';}?>>
	    <label class="layui-form-label"></label>
	  	<button type="button" class="layui-btn lunbo_add_hdp layui-btn-normal"><i class="layui-icon layui-icon-addition"></i>添加图片</button>
	  	<span style="color:red">提示：点击添加图片会新增一张图片添加窗口</span>
	</div>
	<div class="layui-form-item">
	    <div class="layui-input-block">
	    	<input type="hidden" name="wztlaw" value="16">
	    	<input type="hidden" name="wzt_num" value="<?php if(isset($wztlaw_index['pic'])){echo count($wztlaw_index['pic']);}else{echo 0;}?>">
	    	<input type="hidden" name="action" value="<?php echo $wztlaw; ?>">
	    	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce($wztlaw);?>">
	      <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
	    </div>
    </div>
</form>
</div>
<script>
function test(i){
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
        jQuery('body').find('input[name="test'+i+'"]').val(attachment.url);   
        jQuery('body').find('#demo'+i).attr('src',attachment.url);
    });    
    upload_frame.open();   
}
function mobile_test(i){
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
            
            jQuery('body').find('input[name="mobile_test'+i+'"]').val(attachment.url);   
            jQuery('body').find('#mobile_demo'+i).attr('src',attachment.url);
        });    
        upload_frame.open();   
}
jQuery(document).ready(function($){
    layui.use(['form','layer','element'], function(){
      var element = layui.element
      var form = layui.form
      ,layer = layui.layer
      	//是否开启幻灯片
        form.on('switch(lunbo_open)',function(data){
            if(data.elem.checked){
                $('.lunbo_add').css('display','block');
            }else{
                 $('.lunbo_add').css('display','none');
            }

        })
        var num = <?php if(isset($wztlaw_index['pic'])){echo count($wztlaw_index['pic']);}else{echo 0;}?>;
        //添加幻灯片
        $('.lunbo_add_hdp').click(function(){
        	++num;
        	$('input[name="wzt_num"]').val(num);
        	$('.lunbo_list .layui-colla-content').removeClass('layui-show');
        	$('.lunbo_list').append(`
        		<div class="layui-collapse" lay-accordion="">
        			<div class="layui-colla-item">
        				<h2 class="layui-colla-title">图册</h2>
        				<div class="layui-colla-content layui-show">
							<div class="layui-form-item">
						        <label class="layui-form-label">图片</label>
						        <div class="layui-upload">
						            <button type="button" class="layui-btn" id="test`+num+`" onclick="test(`+num+`)">上传图片</button>
						            <input type="hidden" name="test`+num+`" >
						            <div class="layui-upload-list" style="border:1px dashed #ccc;width:200px;height:200px;overflow:hidden;margin-left:110px;line-height:200px">
						               		<img class="layui-upload-img" id="demo`+num+`" style="width:200px">
						                
						                <p id="demoText"></p>
						            </div>
						        </div>
						    </div>
						    <div class="layui-form-item">
                                 <label class="layui-form-label">alt描述</label>
                        	     <div class="layui-input-block">
                        	      <input type="text" name="pc_alt`+num+`"   autocomplete="off" placeholder="" class="layui-input" value="" style="width:36%">
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
        	layui.element.render();
        	form.render();
        })
        //删除幻灯片
        $('body').on('click','.lunbo_delete',function(){
        	$(this).parents('.layui-collapse').remove();
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
