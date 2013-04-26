<?php

class BaseAction extends Action {
	//判断是否登录
	public function _initialize(){
        $sfzh = cookie('sfzh');
        $mm   = cookie('mm');
        if($sfzh && $mm){
            $YZXX = D("yzxx");
            $condition = array();
            $condition['YZXX_SFZH'] = $sfzh;
            $condition['YZXX_MM']=$mm;
            $yz = $YZXX->where($condition)->find();
            if($yz){
                session('yzxx_sfzh',$yz['YZXX_SFZH']);
                session('yzxx_xm',$yz['YZXX_XM']);
            }
        }
        $_param = $this->_get();
        $url = $_param['_URL_'];
        unset($_param['_URL_']);
        $next = U($url,$_param);
        session('next',$next);
        if(!session('yzxx_sfzh')) {
            //$this->error("请先登录！",U("Login/index"));
            echo '<script type="text/javascript">window.location.href="' . U('Login/index') . '";</script>';
            exit;
        }
        //赋值page-header
        //require  "Conf/menu_inc.php";
        import('Conf.menu_inc',APP_PATH,'.php');
        import('Conf.lang_inc',APP_PATH,'.php');        
        include APP_PATH.'Conf/menu_inc.php';
        include APP_PATH.'Conf/lang_inc.php';
        ksort($modules);
        foreach ($modules as $key=>$module) {
            $menu[$key]['url'] = $module;
            $menu[$key]['lang'] = $LANG[$key];
        }        
        $now = '今日是：'.date('Y年m月d日',time());
        $this->assign('now',$now);
        $this->assign('menu',$menu);
        //var_dump($menu);
        //$this->assign('next',session('next'));
        //赋值page-footer
    }
}
?>