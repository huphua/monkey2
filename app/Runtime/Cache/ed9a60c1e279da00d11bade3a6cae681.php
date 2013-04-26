<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>诚信评估表 - 租户管理 - 业主管理平台</title>
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
    <a href="#" class="userset dib cw mr20 pl10 pr10" style=" line-height:25px; background:#68b0e0"> <i class="user_icon mr5 vt" ></i>
      用户设置
    </a>
    <a href="#" class="userset dib cw mr20 pl10 pr10" style=" line-height:25px; background:#68b0e0"> <i class="out_icon mr5 vt" ></i>
      退出登录
    </a>
  </div>
</div>
<div class="navt pl50"><i class="tx_icon vt mr5"></i>欢迎您：<span style="color:#faf702;" class="mr50">蔡景松</span>今天是：2013年4月6日</div>
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
            <ul class="breadcrumb">
                <li>
                    <a href="<?php echo U('/Index');?>">首页</a> <span class="divider">/</span>
                </li>
                <li>
                    <a href="<?php echo U('/Tenant/Index');?>">租户管理</a> <span class="divider">/</span>
                </li>
                <li class="active">诚信评估表<li/>
            </ul>
        </div>
        <div class="m_content pl50 pr50 pt10">
            <form class="well form-inline" action="<?php echo U('/Tenant/NewCreditEvaluation');?>" method="get">
                <select class="span3" name="zhht">
                    <option value="" selected="true">选择合同</option>
                    <?php if(is_array($ht)): $i = 0; $__LIST__ = $ht;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["ZHHT_HTBH"]); ?>">合同编号 <?php echo ($vo["ZHHT_HTBH"]); ?> 承租人 <?php echo ($vo["ZHHT_CCZF"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <select class="span3" name="pgmb">
                    <option value="" selected="true">选择项目评估模板</option>
                    <?php if(is_array($xm)): $i = 0; $__LIST__ = $xm;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["CXSZ_DJBH"]); ?>">项目评估模板 <?php echo ($vo["CXSZ_PGMBMC"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <button type="submit" class="btn btn-primary btn-small"><i class="icon-plus icon-white"></i> 增加</button>
            </form>
            <?php if($list): ?><table class="table table-striped">
                    <thead>
                        <tr>
                            <th class="w160 pt10 pb10 f14 lt1 brf">项目编号</th>
                            <th class="w160 pt10 pb10 f14 lt1 brf">项目名称</th>
                            <th class="w160 pt10 pb10 f14 lt1 brf">项目得分</th>
                            <th class="w160 pt10 pb10 f14 lt1 brf">租户姓名</th>
                            <th class="w160 pt10 pb10 f14 lt1 brf">身份证号码</th>
                            <th class="w160 pt10 pb10 f14 lt1 brf">审核状态</th>
                            <th class="w160 pt10 pb10 f14 lt1 brf">审核人</th>
                            <!--<th></th>-->
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                            <td class="tl pt10 pb10 p130 f14 bdbc"><?php echo ($vo["XPGD_XMBH"]); ?></td>
                            <td class="tl pt10 pb10 p130 f14 bdbc"><?php echo ($vo["CXLX_XMMC"]); ?></td>
                            <td class="tl pt10 pb10 p130 f14 bdbc"><?php echo (number_format($vo["XPGD_XMDF"])); ?></td>
                            <td class="tl pt10 pb10 p130 f14 bdbc"><?php echo ($vo["ZHXX_XM"]); ?></td>
                            <td class="tl pt10 pb10 p130 f14 bdbc"><?php echo ($vo["CXPG_SFZH"]); ?></td>
                            <td class="tl pt10 pb10 p130 f14 bdbc"><?php echo ($vo["STATU_NAME"]); ?></td>
                            <td class="tl pt10 pb10 p130 f14 bdbc"><?php echo ($vo["CXPG_SHR"]); ?></td>
                            <!--<td>
                                    <div class="btn-group">
                    <a class="btn btn-small" href="<?php echo U('/Tenant/NewBlackList?zhbh='.$vo['CXPG_ZHBH']);?>"><i class="icon-plus"></i>黑名单</a>
                                    </div>
                            </td>-->
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                    </tbody>
                </table>
                <div class="page">
                    <?php echo ($page); ?>
                </div>
                <?php else: ?>
                <div class="alert alert-info">
                    <a class="close" data-dismiss="alert">×</a>
                    <h4 class="alert-heading">提示!</h4>
                    暂无记录！
                </div><?php endif; ?>
        </div>
    <div class="m_bottom mb50"></div>

  
  </div>
</body>
</html>