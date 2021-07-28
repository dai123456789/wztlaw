<div class="layui-layout layui-layout-admin" style="padding-top:20px">
    <div class="layui-header" style="background-image: linear-gradient(to right,#845cf4, #b2aae0);">
      <div style="color:#fff;line-height:60px;margin-left:18px">沃之涛科技 官网：www.rbzzz.com(可接定制开发、网站、小程序、公众号、seo/sem优化)交流QQ群：531749531 客服QQ：1500351892 微信：kelerkgibo</div>

      <ul class="layui-nav layui-layout-right">
        
        <li class="layui-nav-item"><a href="">说明文档</a></li>
      </ul>
  </div>
  <style>
    .wzt_slider{
      width:100%;
      background:#f5f5f5;
      /*background: linear-gradient(#fefefe,#f5f5f5);*/
    }
    .wzt_slider li{
      height:50px;
      line-height:50px;
      padding-left:20px;
      border-bottom:1px solid #ccc;
    }
    .wzt_slider li.layui-this{
      background:#fff;
    }
    .wzt_slider li.layui-this a{
      color:#000;
    }
  </style>
      <div class="layui-col-xs2" >
          <ul class="wzt_slider">
             <li <?php if($wzt_page ==1){echo 'class="layui-this"';}?> lay-id="1"><a href="/wp-admin/admin.php?page=wztlaw&law_page=1"><i class="layui-icon layui-icon-set" style="font-size: 14px; color: #222;margin-right:2px"></i>头部设置</a></li>
              <li <?php if($wzt_page ==2){echo 'class="layui-this"';}?> lay-id="2"><a href="/wp-admin/admin.php?page=wztlaw&law_page=2"><i class="layui-icon layui-icon-home" style="font-size: 14px; color: #222;margin-right:2px"></i>常规设置</a></li>
              <li <?php if($wzt_page ==14){echo 'class="layui-this"';}?> lay-id="14"><a href="/wp-admin/admin.php?page=wztlaw&law_page=14"><i class="layui-icon layui-icon-home" style="font-size: 14px; color: #222;margin-right:2px"></i>seo设置</a></li>
              <li <?php if($wzt_page ==3){echo 'class="layui-this"';}?> lay-id="3"><a href="/wp-admin/admin.php?page=wztlaw&law_page=3"><i class="layui-icon layui-icon-form" style="font-size: 14px; color: #222;margin-right:2px"></i>轮播管理</a></li>
              <li <?php if($wzt_page ==4){echo 'class="layui-this"';}?> lay-id="4"><a href="/wp-admin/admin.php?page=wztlaw&law_page=4"><i class="layui-icon layui-icon-praise" style="font-size: 14px; color: #222;margin-right:2px"></i>关于我们</a></li>
              <li <?php if($wzt_page ==5){echo 'class="layui-this"';}?> lay-id="5"><a href="/wp-admin/admin.php?page=wztlaw&law_page=5"><i class="layui-icon layui-icon-cart-simple" style="font-size: 14px; color: #222;margin-right:2px"></i>业务范围</a></li>
              <li <?php if($wzt_page ==10){echo 'class="layui-this"';}?> lay-id="10"><a href="/wp-admin/admin.php?page=wztlaw&law_page=10"><i class="layui-icon layui-icon-component" style="font-size: 14px; color: #222;margin-right:2px"></i>首页图文</a></li>
              <li <?php if($wzt_page ==15){echo 'class="layui-this"';}?> lay-id="15"><a href="/wp-admin/admin.php?page=wztlaw&law_page=15"><i class="layui-icon layui-icon-praise" style="font-size: 14px; color: #222;margin-right:2px"></i>公司优势</a></li>
              <li <?php if($wzt_page ==16){echo 'class="layui-this"';}?> lay-id="16"><a href="/wp-admin/admin.php?page=wztlaw&law_page=16"><i class="layui-icon layui-icon-carousel" style="font-size: 14px; color: #222;margin-right:2px"></i>图册展示</a></li>
              <li <?php if($wzt_page ==17){echo 'class="layui-this"';}?> lay-id="17"><a href="/wp-admin/admin.php?page=wztlaw&law_page=17"><i class="layui-icon layui-icon-group" style="font-size: 14px; color: #222;margin-right:2px"></i>人才招聘</a></li>
              <li <?php if($wzt_page ==18){echo 'class="layui-this"';}?> lay-id="18"><a href="/wp-admin/admin.php?page=wztlaw&law_page=18"><i class="layui-icon layui-icon-util" style="font-size: 14px; color: #222;margin-right:2px"></i>数字模块</a></li>
              <li <?php if($wzt_page ==6){echo 'class="layui-this"';}?> lay-id="6"><a href="/wp-admin/admin.php?page=wztlaw&law_page=6"><i class="layui-icon layui-icon-picture" style="font-size: 14px; color: #222;margin-right:2px"></i>图片展示</a></li>
              <li <?php if($wzt_page ==7){echo 'class="layui-this"';}?> lay-id="7"><a href="/wp-admin/admin.php?page=wztlaw&law_page=7"><i class="layui-icon layui-icon-list" style="font-size: 14px; color: #222;margin-right:2px"></i>首页资讯</a></li>
              <li <?php if($wzt_page ==19){echo 'class="layui-this"';}?> lay-id="19"><a href="/wp-admin/admin.php?page=wztlaw&law_page=19"><i class="layui-icon layui-icon-slider" style="font-size: 14px; color: #222;margin-right:2px"></i>留言列表</a></li>
              <li <?php if($wzt_page ==8){echo 'class="layui-this"';}?> lay-id="8"><a href="/wp-admin/admin.php?page=wztlaw&law_page=8"><i class="layui-icon layui-icon-form" style="font-size: 14px; color: #222;margin-right:2px"></i>底部设置</a></li>
              <li <?php if($wzt_page ==12){echo 'class="layui-this"';}?> lay-id="12"><a href="/wp-admin/admin.php?page=wztlaw&law_page=12"><i class="layui-icon layui-icon-dialogue" style="font-size: 14px; color: #222;margin-right:2px"></i>社交工具</a></li>
              <li <?php if($wzt_page ==9){echo 'class="layui-this"';}?> lay-id="9"><a href="/wp-admin/admin.php?page=wztlaw&law_page=9"><i class="layui-icon layui-icon-link" style="font-size: 14px; color: #222;margin-right:2px"></i>友情链接</a></li>
              <li <?php if($wzt_page ==13){echo 'class="layui-this"';}?> lay-id="13"><a href="/wp-admin/admin.php?page=wztlaw&law_page=13"><i class="layui-icon layui-icon-fonts-code" style="font-size: 14px; color: #222;margin-right:2px"></i>添加代码</a></li>
             
          </ul>
      </div>
      <div class="layui-col-xs10" style="background:#fff">