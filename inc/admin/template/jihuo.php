<form class="layui-form" action="" onsubmit="return false" style="margin-top:50px">
  <div class="layui-form-item">
    <label class="layui-form-label">激活码</label>
    <div class="layui-input-block">
      <input type="text" name="key" lay-verify="title" autocomplete="off" placeholder="请输入激活码" class="layui-input" style="width:36%">
    </div>
  </div>
 <div class="layui-form-item" style="margin-top:50px">
    <div class="layui-input-block">
        <input type="hidden" name="wztlaw" value="11">
    	<input type="hidden" name="action" value="wztlaw">
    	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('wztlaw');?>">
      <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">立即提交</button>
    </div>
  </div>
</form>
 <fieldset class="layui-elem-field layui-field-title" style="margin-top: 20px;">
  <legend>官方信息</legend>
</fieldset>
<div>
    <p style="color:red">官网：www.rbzzz.com(可接定制开发、网站、小程序、公众号、seo/sem优化)交流QQ群：531749531 客服QQ：1500351892 微信：kelerkgibo</p>
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
                        layer.alert('激活成功');
                        location.reload();
                    }else{
                        layer.close(index);
                        layer.msg('激活失败，请刷新后重试');
                    }
                }
            })
            
            return false;
        });
         
         
         
    });
});
</script>