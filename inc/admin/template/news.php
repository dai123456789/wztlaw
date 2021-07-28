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
         <label class="layui-form-label">模块标题</label>
	     <div class="layui-input-block">
	      <input type="text" name="title"   autocomplete="off" placeholder="" class="layui-input" value="<?php if(isset($wztlaw_index['title'])){echo $wztlaw_index['title'];}?>">
	     </div>
	</div>
    <div class="layui-form-item">
        <label class="layui-form-label">选择分类</label>
        <div class="layui-input-block">
            <?php if($cate){foreach($cate as $key=>$val){?>
          <input type="radio" name="term_id" value="<?php echo $val->term_id;?>" title="<?php echo $val->name; ?>" <?php if((isset($wztlaw_index['term_id']) && $wztlaw_index['term_id']==$val->term_id)){echo 'checked=""';}?>>
          <?php }}else{?>
        <span>请先添加分类或者分类关联文章！</span>
        <?php  }?>
        </div>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        	<input type="hidden" name="wztlaw" value="7">
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
        form.on('submit(demo1)', function(data){
           console.log(JSON.stringify(data.field))
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