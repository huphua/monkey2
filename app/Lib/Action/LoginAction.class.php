<?php
class LoginAction extends Action {

    public function index(){
    	//$USR_YZXX = M('USR_YZXX'); // 实例化Data数据模型
        //dump($USR_YZXX->select());
        if(cookie('rm') ==1){
            $this->assign('rm',"1");
            $this->assign('username',  cookie('sfzh'));
        }else{
            $this->assign('username',"");
            $this->assign('rm',"0");
        }        
        $this->next = session('next');
        $this->assign('next',session('next'));
        $this->display();
    }

    public function login(){        
    	    $YZXX = D("Lyb");        
    		$condition = array();
    		$condition['LYB_BH'] = $this->_post('lyb_bh');
    		$yz = $YZXX->where($condition)->find();
    		if($yz){    			
    			if($yz['LYB_MM']==md5($this->_post('lyb_mm'))){
                    session('yzxx_sfzh', $yz['LYB_BH']);
                    session('yzxx_xm', $yz['LYB_FZR1']);
                    cookie('sfzh', $yz['LYB_BH'], 2592000);
                    cookie('mm', $yz['LYB_MM'], 2592000);
                    cookie('rm', $this->_post('remember_me'), 2592000);
                    $next = session('next');
                    $_url = $next ? $next : U('/Index');
                    echo '<script type="text/javascript">window.location.href="' . $_url . '";</script>';
                    exit;
	    			//$this->success('登录成功！',$next?$next:U('/Index'));
    			}
    			else
                 $this->error('密码错误！');
    		}
    		else
    			$this->error('楼宇信息不存在！');
    }

    public function logout(){
        session('yzxx_sfzh',null);
        session('yzxx_xm',null);
        session('next',null);
        cookie('mm',null);
        if(cookie('rm') !=1){
            cookie('sfzh',null);   
        }
   		$this->success('登出成功！',U('index'));
    }
}
?>