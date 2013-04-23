<?php
class YZXXModel extends Model{
	protected $_validate = array(
		array('YZXX_SFZH','require','业主账号必须填写！',1,'',4), //登录是验证业主姓名
	);
}
?>