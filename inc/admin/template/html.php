<style>
    .layui-btn {
        background-color: #32cdff;
    }
</style>
<div style="padding-top:20px">
<form class="layui-form" action="" onsubmit="return false">
	<div class="layui-form-item">
         <label class="layui-form-label">添加代码到头部</label>
	     <div class="layui-input-block">
	       <textarea placeholder="请输入代码" class="layui-textarea" name="head_html"><?php if(isset($wztlaw_index['head_html'])){echo $wztlaw_index['head_html'];}?></textarea>
	     </div>
	</div>
	<div class="layui-form-item">
         <label class="layui-form-label">添加代码到页脚</label>
	     <div class="layui-input-block">
	       <textarea placeholder="请输入代码" class="layui-textarea" name="foot_html"><?php if(isset($wztlaw_index['foot_html'])){echo $wztlaw_index['foot_html'];}?></textarea>
	     </div>
	</div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        	<input type="hidden" name="wztlaw" value="13">
        	<input type="hidden" name="action" value="<?php echo $wztlaw; ?>">
        	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce($wztlaw);?>">
          <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">提交</button>
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