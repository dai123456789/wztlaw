<style>
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
<form class="layui-form" action="" onsubmit="return false">
    <div style="margin:20px 110px" class="lunbo_list">
      <?php 
      $i =0;
      if(isset($wztlaw_index['pic']) && $wztlaw_index['pic']){
      foreach($wztlaw_index['pic'] as $key=>$val){
        ++$i;
        echo '<div class="layui-collapse" lay-accordion="">
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">'.$val['url'].'</h2>
                <div class="layui-colla-content">
             <div class="layui-form-item">
                     <label class="layui-form-label">名称</label>
                   <div class="layui-input-block">
                    <input type="text" name="name'.$i.'"   autocomplete="off" placeholder="" class="layui-input" value="'.$val['name'].'">
                   </div>
              </div>
            
              <div class="layui-form-item">
                     <label class="layui-form-label">跳转链接</label>
                   <div class="layui-input-block">
                    <input type="text" name="url'.$i.'"   autocomplete="off" placeholder="" class="layui-input" value="'.$val['url'].'">
                   </div>
                   <span style="color:red;margin-left:110px">跳转链接请填写http(s)://</span>
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
    <div class="layui-form-item lunbo_add" >
      <label class="layui-form-label"></label>
      <button type="button" class="layui-btn lunbo_add_hdp layui-btn-normal"><i class="layui-icon layui-icon-addition"></i>添加链接</button>
      <span style="color:red">提示：点击添加链接会新增一个添加友情链接的窗口</span>
    </div>
    <div class="layui-form-item">
        <div class="layui-input-block">
        	<input type="hidden" name="wztlaw" value="9">
        	<input type="hidden" name="action" value="<?php echo $wztlaw; ?>">
          <input type="hidden" name="wzt_num" value="<?php if(isset($wztlaw_index['pic'])){echo count($wztlaw_index['pic']);}else{echo 0;}?>">
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



       
       var num = <?php if(isset($wztlaw_index['pic'])){echo count($wztlaw_index['pic']);}else{echo 0;}?>;
       //添加业务
       $('.lunbo_add_hdp').click(function(){
          ++num;
          $('input[name="wzt_num"]').val(num);
          $('.lunbo_list .layui-colla-content').removeClass('layui-show');
          $('.lunbo_list').append(`
            <div class="layui-collapse" lay-accordion="">
              <div class="layui-colla-item">
                <h2 class="layui-colla-title">链接</h2>
                <div class="layui-colla-content layui-show">
                 <div class="layui-form-item">
                     <label class="layui-form-label">名称</label>
                   <div class="layui-input-block">
                    <input type="text" name="name`+num+`"   autocomplete="off" placeholder="" class="layui-input" value="">
                   </div>
              </div>
                <div class="layui-form-item">
                     <label class="layui-form-label">跳转链接</label>
                   <div class="layui-input-block">
                    <input type="text" name="url`+num+`"   autocomplete="off" placeholder="" class="layui-input" value="">
                   </div>
                   <span style="color:red;margin-left:110px">跳转链接请填写http(s)://</span>
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
        //删除链接
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