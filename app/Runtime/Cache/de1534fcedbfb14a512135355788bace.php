<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>平安社区业主网站</title>
<link rel="stylesheet" type="text/css" href="__ROOT__/static/css/base.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/static/css/login.css" />
<script type="text/javascript" src="__ROOT__/static/js/jquery.js"></script><script type="text/javascript" src="__ROOT__/static/js/bootstrap.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/jquery-validate/jquery.validate.min.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/jquery-validate/additional-methods.min.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/jquery-validate/messages_zh.js"></script>
<script type="text/javascript" src="__ROOT__/static/js/loginjs.js"></script>
</head>
<body id="login">
  <div class="wrap">
    <div class="login-form">
      <form id ="loginform" method="post" accept-charset="utf-8" action="<?php echo U('Login/login');?>" >
        <p><input type="hidden" name="next" value="<?php echo ($next); ?>" /></p>
        <p><input id ="lyb_bh" class="text-field" type="text" name="lyb_bh" value="<?php echo ($username); ?>" /></p>
        <p><input id="lyb_mm" class="text-field" type="password" name="lyb_mm" value="" /></p>        
        <p class="rmbme"><input id='remember_me' type="checkbox" name="remember_me" value="1" <?php if($rm) echo "checked"; ?>  />记住我</p>
        <div class="alert alert-error" id="container"></div>
        <input type="submit" id ="submit" value="" /></p>
      </form>
    </div>
  </div>
</body>
</html>