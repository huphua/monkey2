<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>首页<?php if((count($msg)) != "0"): ?>(<?php echo (count($msg)); ?>)<?php endif; ?> - 业主管理平台</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="stylesheet" type="text/css" href="__ROOT__/static/css/global.css?v=<?php echo (C("CSS_GLOBAL_VER")); ?>" />
<link rel="stylesheet" type="text/css" href="__ROOT__/static/css/bootstrap.css" /><link rel="stylesheet" type="text/css" href="__ROOT__/static/css/bootstrap-responsive.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/static/css/base.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/static/css/admin.css" />
<script type="text/javascript" src="__ROOT__/static/js/global.js?v=<?php echo (C("JS_GLOBAL_VER")); ?>"></script>
<script type="text/javascript" src="__ROOT__/static/js/jquery.js"></script><script type="text/javascript" src="__ROOT__/static/js/bootstrap.js"></script>
<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

  
  <script type="text/javascript">
$(function(){
  var leftWidth = $("#left-side").outerWidth();
  var winWidth = $(window).width();
  $("#r-content").css('width', winWidth - leftWidth);
  $(window).resize(function() {
    $("#r-content").css('width', winWidth - leftWidth);
  }); 
});
</script>
</head>

<body>
<div class="header rel">
  <div class="ml50 fl">
    <img src="__ROOT__/static/images/logo.jpg" />
  </div>
  <div class="snav fr pr50 pt50">
    <a href="<?php echo U('/Yzxx/Setting');?>" class="userset dib cw mr20 pl10 pr10" style=" line-height:25px; background:#68b0e0"> <i class="user_icon mr5 vt" ></i>
      用户设置
    </a>
    <a href="<?php echo U('/Login/Logout');?>" class="userset dib cw mr20 pl10 pr10" style=" line-height:25px; background:#68b0e0"> <i class="out_icon mr5 vt" ></i>
      退出登录
    </a>
  </div>
</div>
<div class="navt pl50"><i class="tx_icon vt mr5"></i>欢迎您：<span style="color:#faf702;" class="mr50">蔡景松</span><?php echo ($now); ?></div>
<div id="left-side" class="mt10 fl">
  <div class="left_top cw">
      <i class="gl_icon vt mr5  mt10"></i>管理信息
    </div>
    <ul class="left_main">
      <?php if(is_array($menu)): $k = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$m): $mod = ($k % 2 );++$k;?><li>
          <a href="<?php echo ($m["url"]); ?>" class="li_<?php echo ($key); ?> dib tin mb10"><?php echo ($m["lang"]); ?></a>
        </li><?php endforeach; endif; else: echo "" ;endif; ?>
     </ul> 
    <div class="left_bottom"></div>
</div>
  <div class="w980 auto mt10">
	  
  <div class="m_top pt10 pl20 pr10 pb10 cw">
     欢迎使用业主管理系统！ <!--<i class="bhome_icon vt"></i><a href="#" class="cw">首页</a> <span class="pl5 pr5">/</span> <a href="#" class="cw">租户管理</a> <span class="pl5 pr5">/</span> <a href="#" class="cw">合同列表</a>--> 
  </div>
  <div class="m_content pl50 pr50 pt10">
    <table>
      <thead>
        <tr>
          <th class="w160 pt10 pb10 f14 lt1 brf">提醒类型</th>           
          <th class="w160 pt10 pb10 f14 lt1 brf">到期时间</th>            
          <th class="pt10 pb10 f14 lt1">提醒内容</th>
        </tr>
      </thead>
      <tbody>
        <?php if(is_array($msg)): $i = 0; $__LIST__ = $msg;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td class="tl pt10 pb10 p130 f14 bdbc"><i class="<?php switch($vo["type"]): case "租户合同": ?>ht_icon<?php break; case "黑名单": ?>hm_icon<?php break; case "管理费欠费": ?>fy_icon<?php break; endswitch;?> mr5"></i><?php echo ($vo["type"]); ?></td>
          <td class="tc f14 bdbc"><?php if($vo["expired"] != 0): echo (date('Y-m-d',$vo["expired"])); else: ?>无<?php endif; ?></td>
          <td class="tl p10 f14 bdbc"><?php echo ($vo["info"]); if(($vo["url"]) != ""): ?><a href="<?php echo ($vo["url"]); ?>" class="more p5 m15 f12 cw">详情</a><?php endif; ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
      </tbody>
    </table>
    <!--
    <div class="page tr p20"><span class="bsc c3" style="padding:3px 5px;">44 条记录 1/3 页</span><a href="#" class="bsc  c3 ml5 ml5">下一页</a><a href="#" class="bsc  c3 ml5 ml5">1</a><a href="#" class="bsc c3 ml5 ml5 a_h">2</a><a href="#" class="bsc  c3 ml5 ml5">3</a></div>
    -->
  </div>
  <div class="m_bottom mb50"></div>

  
  </div>
</body>
</html>