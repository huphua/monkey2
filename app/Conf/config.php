<?php
return array(

	'DB_TYPE' => 'sqlsrv',
	'DB_HOST'=>'localhost',
	'DB_NAME'=>'M5G2HKL7K0010548',
	//'DB_DSN' => 'sqlsrv:Server=localhost;Database=M5G2HKL7K0010548',
	'DB_USER' => 'sa',
	'DB_PWD' => 'asdasd',
	'DB_PREFIX' => 'USR_',
	'DB_PORT' => '',

	'SESSION_AUTO_START'=>true,
	
	'URL_MODEL'			=>	1, // 如果你的环境不支持PATHINFO 请设置为3
    'DEFAULT_MODULE'	=>	'Index',
    //启用路由功能
	'URL_ROUTER_ON'		=>	true,
	//路由定义
	'URL_ROUTE_RULES'	=> 	array(
	),

	//'LAYOUT_ON'=>true,
	'LOG_RECORD' => true, // 开启日志记录
	'LOG_LEVEL'  =>'EMERG,ALERT,CRIT,ERR', // 只记录EMERG ALERT CRIT ERR 错误

	'LOAD_EXT_CONFIG' => 'static',
);
?>