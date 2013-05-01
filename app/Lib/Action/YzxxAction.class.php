<?php
class YzxxAction extends BaseAction {

    public function Index(){
        $this->yzxx = M('yzxx_copy')->field('YZXX_LXDH,YZXX_LXSJ,YZXX_JJLXR,YZXX_JJLXDH,YZXX_DZYX,YZXX_SFZH')->where("yzxx_sfzh='".session('yzxx_sfzh')."'")->find();
        if($this->yzxx)
            $this->audi=true;
        else
            $this->yzxx = M('yzxx')->field('YZXX_LXDH,YZXX_LXSJ,YZXX_JJLXR,YZXX_JJLXDH,YZXX_DZYX,YZXX_SFZH')->where("yzxx_sfzh='".session('yzxx_sfzh')."'")->find();
        //dump($this->yzxx);dump(M('yzxx')->getLastSql());
        $this->display();
    }

    public function Save(){
        if(!M('yzxx_copy')->where("yzxx_sfzh='".session('yzxx_sfzh')."'")->save($this->_post())){
            //dump(M('yzxx_copy')->getLastSql());exit;
            $data = M('yzxx')->field('YZXX_LXDH,YZXX_LXSJ,YZXX_JJLXR,YZXX_JJLXDH,YZXX_DZYX,YZXX_SFZH')->where("yzxx_sfzh='".session('yzxx_sfzh')."'")->find();
            unset($data['YZXX_NUM']);
            foreach($data as $key=>$item){
                $dt = date_format($item,'Y-m-d H:i:s');
                if($dt) $data[$key]=$dt;
                //dump(gettype($item));
            }
            //exit;
            $data['YZXX_LXDH'] = $this->_post('YZXX_LXDH');
            $data['YZXX_LXSJ'] = $this->_post('YZXX_LXSJ');
            $data['YZXX_JJLXR'] = $this->_post('YZXX_JJLXR');
            $data['YZXX_JJLXDH'] = $this->_post('YZXX_LXDH');
            $data['YZXX_DZYX'] = $this->_post('YZXX_DZYX');
            $data['YZXX_SFZH'] = session('yzxx_sfzh');
            M('yzxx_copy')->add($data);
            //dump(M('yzxx_copy')->getLastSql());//exit;
        }
        $this->success('保存成功！',U('/Yzxx/Index'));
    }

    public function Changepassword(){
          $this->display();
    }

    public function SavePassword(){
          $oldpassword =!empty($_POST['oldpassword'])?md5($_POST['oldpassword']):'';
          $newpassword =!empty($_POST['newpassword'])?md5($_POST['newpassword']):'';
          $ly = M('Lyb');
          $condition = array();
          $condition['LYB_BH']=  session('yzxx_sfzh');
          $condition['LYB_MM']=  $oldpassword;
          $savetion = array();
          $savetion['LYB_MM'] = $newpassword;
          $yz = $ly->where($condition)->find();
          $wheretion = array();
          $wheretion['LYB_BH'] = session('yzxx_sfzh');
          if($yz){
              $a = $ly->where($wheretion)->save($savetion);
             if($a) {
                 $link[] = array('href' => U('/Index/index'), 'text' =>'首页');
                 $this->sys_msg('修改成功',0,$link);
             }else{
                 $this->sys_msg('修改失败，请重新输入',0);
             }

          }else{
              $this->sys_msg('原密码错误，请重新输入',0);
          }


          
    }

    public function Setting(){
        $this->sz=M('yzsz')->where("yzsz_sfzh='".session('yzxx_sfzh')."'")->find();
        //dump($this->sz);
        $this->display();
    }

    public function SaveSetting(){
        $sz=M('yzsz')->where("yzsz_sfzh='".session('yzxx_sfzh')."'")->find();
        //dump($sz);
        //dump($this->_post());exit;
        $data = array(
            'YZSZ_SFZH'=>session('yzxx_sfzh'),
            'YZSZ_SJHM'=>$this->_post('sjhm'),
            'YZSZ_DXTX'=>$this->_post('dxtx','intval',0)
         );
        if(!$sz)
            $result = M('yzsz')->add($data);
        else
            $result = M('yzsz')->where("yzsz_sfzh='".session('yzxx_sfzh')."'")->save($data);
        //dump($result);
        //dump(M('yzsz')->getLastSql());exit;
        if($result)
            $this->success('保存成功！',U('/Yzxx/Setting'));
        else
            $this->success('保存失败！');
    }
}
?>