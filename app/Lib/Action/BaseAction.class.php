<?php

class BaseAction extends Action {
    //判断是否登录
    public function _initialize(){
        $sfzh = cookie('sfzh');
        $mm   = cookie('mm');
        if($sfzh && $mm){
            $YZXX = D("Lyb");
            $condition = array();
            $condition['LYB_BH'] = $sfzh;
            $condition['LYB_MM']=$mm;
            $yz = $YZXX->where($condition)->find();
            if($yz){
                session('yzxx_sfzh',$yz['LYB_BH']);
                session('yzxx_xm',$yz['LYB_FZR1']);
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
        $this->assign('LANG',$LANG);
        $this->assign('name',session('yzxx_xm'));
        //var_dump($menu);
        //$this->assign('next',session('next'));
        //赋值page-footer
    }


    /**
     * 系统提示信息
     *
     * @access      public
     * @param       string      msg_detail      消息内容
     * @param       int         msg_type        消息类型， 0消息，1错误，2询问
     * @param       array       links           可选的链接
     * @param       boolen      $auto_redirect  是否需要自动跳转
     * @return      void
     */
    public function sys_msg($msg_detail, $msg_type = 0, $links = array(), $auto_redirect = true){
           if (count($links) == 0)
            {
                $links[0]['text'] = $GLOBALS['_LANG']['go_back'];
                $links[0]['href'] = 'javascript:history.go(-1)';
                $links[0]['href'] = 'javascript:history.go(-1)';
            }
            $this->assign('ur_here',     $GLOBALS['_LANG']['system_message']);
            $this->assign('msg_detail',  $msg_detail);
            $this->assign('msg_type',    $msg_type);
            $this->assign('links',       $links);
            $this->assign('default_url', $links[0]['href']);
            $this->assign('auto_redirect', $auto_redirect);

            $this->display('public:message');
            exit;


    }
}
?>