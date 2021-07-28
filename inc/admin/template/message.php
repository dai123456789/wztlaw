<style>
    .layui-table-view {
        
        margin-left: 35px;
    }
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
<div style="padding-top:20px;">
    <form class="layui-form" action="" onsubmit="return false">
      <div class="layui-form-item">
        <label class="layui-form-label">留言开关</label>
        <div class="layui-input-block">
            <?php if(isset($wztlaw_index['open']) && $wztlaw_index['open']==1){?>
          <input type="checkbox" checked="" name="open" lay-skin="switch" lay-filter="switchTest" lay-text="开|关">
          <?php }else{?>
          <input type="checkbox"  name="open" lay-skin="switch" lay-filter="switchTest" lay-text="开|关">
          <?php }?>
        </div>
      </div>
      <div class="layui-form-item">
        <div class="layui-input-block">
            <input type="hidden" name="wztlaw" value="19">
        	<input type="hidden" name="action" value="<?php echo $wztlaw; ?>">
        	<input type="hidden" name="nonce" value="<?php echo wp_create_nonce($wztlaw);?>">
          <button type="submit" class="layui-btn" lay-submit="" lay-filter="demo1">保存</button>
        </div>
      </div>
    </form>
    <div class="layui-form" >
    <table class="layui-hide" id="test" lay-filter="test" lay-id="test" style="width:100%"></table>
    </div>
</div>
<script type="text/html" id="toolbarDemo">
  <a class="layui-btn layui-btn-danger layui-btn-xs" lay-event="getCheckData">删除选中数据</a>
</script>
<script>
jQuery(document).ready(function($){
layui.use(['form','layer','table'], function(){
  var form = layui.form
  ,layer = layui.layer;

    //监听提交
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
  
  var table = layui.table;
  
  table.render({
    elem: '#test'
    ,toolbar:'#toolbarDemo'
     ,defaultToolbar: []
    ,url:'<?php echo  admin_url( 'admin.php?page=wztlaw&message=1' );?>'
    ,cellMinWidth: 80 //全局定义常规单元格的最小宽度，layui 2.2.1 新增
    ,cols: [[
      {type:'checkbox',fixed: 'left'},
      {field:'id', width:50, title: 'ID'}
      ,{field:'name', width:80, title: '姓名'}
      ,{field:'mobile', width:130, title: '电话'}
      ,{field:'email', min_width:100, title: '邮箱'}
      ,{field:'address', min_width:100,title: '地址'} //minWidth：局部定义当前单元格的最小宽度，layui 2.2.1 新增
      ,{field:'content', min_width:100,title: '留言'}
    ]]
     ,page: { //支持传入 laypage 组件的所有参数（某些参数除外，如：jump/elem） - 详见文档
      layout: [  'prev', 'page', 'next', 'skip','count'] //自定义分页布局
      //,curr: 5 //设定初始在第 5 页
      ,groups: 10 //只显示 1 个连续页码
      ,first: false //不显示首页
      ,last: false //不显示尾页  
      ,limit:35
      
    }
    ,request:{
        pageName:'pages',
    },
  });
  table.on('toolbar(test)', function(obj){
        var checkStatus = table.checkStatus(obj.config.id);
        switch(obj.event){
          case 'getCheckData':
            var data = checkStatus.data;
            if(data.length==0){
                layer.msg('您没有选择数据！');return;
            }
            var index = layer.load(1, { shade: [0.7,'#111'] });
            $.ajax({
    	  		url:'',
    	  		data:{data:'{"wztlaw":"20","nonce":"<?php echo wp_create_nonce($wztlaw);?>","action":"<?php echo $wztlaw; ?>","value":'+JSON.stringify(data)+'}',},
    	  		type:'post',
    	  		dataType:'json',
    	  		success:function(data){
    	  			layer.close(index);
    	  			if(data.msg==1){
    	  			    layer.msg('删除成功',function(){
        						location.reload()
        				});
    	  			}else{
    	  			    layer.msg('删除失败');
    	  			}
    	  		}
    	    })
          break;
        };
      });
});
})
</script>
 