<?php
class TenantAction extends BaseAction {

    public function Index(){
        redirect(U('/Tenant/Contract'));
    }

    //租金记录列表
    public function RentRecord(){
        import('ORG.Util.Page');// 导入分页类
        $zjjl = M('zjjl');
        $condition = "ZJJL_SFZH='".session('yzxx_sfzh')."'";
        $nowPage = $this->_get('p','intval',1);
        if($nowPage<=0) $nowPage = 1;
        $counts  = $zjjl->where($condition)->count();
        $Page = new Page($counts);// 实例化分页类 传入总记录数
        $show = $Page->show();// 分页显示输出
        $list=$zjjl->where($condition)->order('ZJJL_DJBH desc')->page($nowPage.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display();
    }

    public function DetailRentRecord(){
        $djbh = $this->_get('id');
        if(!$djbh) $this->error('参数错误！');
        $condition = array();
        $condition['ZJJF_SFZH'] = session('yzxx_sfzh');
        $condition['ZJJF_DJBH'] = $djbh;
        $this->detail=M('zjjl')->where($condition)->find();
        if(!$this->detail) $this->error('找不到租金记录！');
        $this->ht = M('zhht')->where("ZHHT_HTBH='".$this->detail['ZJJL_HTBH']."' AND ZHHT_SFZHM1='".session('yzxx_sfzh')."' AND ZHHT_SHZT='A'")->field('ZHHT_HTBH,ZHHT_ZHBH,ZHHT_CCZF')->find();
        $this->display();
    }

    public function RemoveRentRecord(){
        $djbh = $this->_get('id');
        if(!$djbh) $this->error('参数错误！');
        $condition = array();
        $condition['ZJJF_SFZH'] = session('yzxx_sfzh');
        $condition['ZJJF_DJBH'] = $djbh;
        $result=M('zjjl')->where($condition)->delete();
        $this->success('删除租金记录成功！',U('/Tenant/RentRecord'));
    }


    //添加租金记录
    public function NewRentRecord(){
        $this->ht = M('zhht')->where("ZHHT_SFZHM1='".session('yzxx_sfzh')."' AND ZHHT_SHZT='A'")->field('ZHHT_HTBH,ZHHT_ZHBH,ZHHT_CCZF')->select();
        $this->display();
    }

    public function SaveRentRecord(){
        $zjjl = M('zjjl');
        $data = $this->_post();
        if(isset($data['ZJJL_DJBH'])){
            $result = $zjjl->where(array('ZJJL_DJBH'=>$data['ZJJL_DJBH']))->save($data);
            //dump($zjjl->getLastSql());exit;
            
        }
        else{
            $data['ZJJL_SFZH'] = session('yzxx_sfzh');
            $data['ZJJL_DJBH'] = create_djbh($zjjl,'ZJJL');
            $data['ZJJL_ZJE'] = $data['ZJJL_ZJ']+$data['ZJJL_DF']+$data['ZJJL_SF'];
            $result = $zjjl->add($data);
        }
        //dump($zjjl->getLastSql());exit;
        if($result)
            $this->success('保存成功！',U('/Tenant/RentRecord'));
        else
            $this->error('保存失败！');
    }

    //合同列表
    public function Contract(){
    	$Data = M('zhht');
		import('ORG.Util.Page');// 导入分页类
		$nowPage = $this->_get('p','intval',1);
		if($nowPage<=0) $nowPage = 1;
        $condition = array();
        $condition['zhht_sfzhm1'] = session('yzxx_sfzh');
		$counts  = $Data->where($condition)->count();
		$Page = new Page($counts);// 实例化分页类 传入总记录数
		$Page->setConfig('header','份合同');
		$show = $Page->show();// 分页显示输出
		$list=$Data->where($condition)->order('zhht_htbh desc')->page($nowPage.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
        $this->display();
    }

    //详细合同
    public function DetailContract(){
    	$htbh = $this->_get('htbh');
    	if($htbh){
	    	$Data = M('zhht');
	    	$detail = $Data->where("ZHHT_HTBH='$htbh'")->find();
	    	if($detail){
	    		$sql = "SELECT T0.*,T1.QY_QYMC AS HHTD_QXMC,T2.LYB_MC AS HHTD_LYMC,T3.FW_FHJC AS HHTD_FHJC,TT._RECORD_NUM FROM USR_ZHHT_D AS T0 
 LEFT OUTER JOIN USR_QY AS T1 ON T0.HHTD_QX = T1.QY_QYBH
 LEFT OUTER JOIN USR_LYB AS T2 ON T0.HHTD_LY = T2.LYB_BH
 LEFT OUTER JOIN USR_FW AS T3 ON T0.HHTD_FH = T3.FW_FH LEFT OUTER JOIN TEMP_LIST TT ON T0.HHTD_NUM= TT._RECORD_NUM WHERE T0.HHTD_ZBDH='$htbh'  ORDER BY HHTD_NUM
";
				$detail['house'] = $Data->query($sql);
		    	$this->assign('detail',$detail);
		    	$this->display();
		    }
		    else
	    		$this->error('合同不存在！');
	    }
	    else
	    	$this->error('非法参数！');
    }

    //诚信评估表
    public function CrediteValuation(){
    	$Data = M('cxpg');
		import('ORG.Util.Page');// 导入分页类
		$size = 10;
		$nowPage = $this->_get('p','intval',1);
		if($nowPage<=0) $nowPage = 1;
        $condition = array();
        $condition['CXPG_SFZH'] = session('yzxx_sfzh');
		$counts  = $Data->where($condition)->count();
		$Page = new Page(intval($counts),$size);// 实例化分页类 传入总记录数
		$show = $Page->show();// 分页显示输出
		
		// 进行分页数据查询
		$list = $Data->where($condition)->order('cxpg_czsj desc')->join('LEFT OUTER JOIN USR_CXPG_D ON CXPG_DJBH = XPGD_ZBDH')->join('LEFT OUTER JOIN SYS_AUDITESTATUS ON CXPG_SHZT = STATU_ID')->join('LEFT OUTER JOIN USR_CXLX ON XPGD_XMBH = CXLX_XMBH')->join('LEFT OUTER JOIN USR_YZXX ON CXPG_SFZH = YZXX_SFZH')->join('LEFT OUTER JOIN USR_ZHXX ON XPGD_JCPZ = ZHXX_DJBH')->page($nowPage.','.$Page->listRows)->select();
        //$list = $Data->join('USR_CXPG ON XPGD_ZBDH = CXPG_DJBH')->join('USR_ZHHT ON CXPG_ZHBH = ZHHT_ZHBH')->join('USR_CXLX ON CXLX_XMBH = XPGD_XMBH')->order('cxpg_czsj desc')->page($nowPage.','.$Page->listRows)->select();
        //dump($Data->getLastSql());
		$xm = get_pfxm();
		$ht = M('zhht')->where("ZHHT_SFZHM1='".session('yzxx_sfzh')."' AND ZHHT_SHZT='A'")->field('ZHHT_HTBH,ZHHT_ZHBH,ZHHT_CCZF')->select();
		$this->assign('xm',$xm);//项目
		$this->assign('ht',$ht);//合同
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
        $this->display();
    }

    //新增诚信评估
    public function NewCreditEvaluation(){
    	$pgmb = $this->_get('pgmb');
    	$zhht = $this->_get('zhht');
    	if(!$pgmb || !$zhht){
    		$this->error('参数错误！');
    		exit;
    	}
    	$ht = M('zhht')->where("ZHHT_SFZHM1='".session('yzxx_sfzh')."' AND ZHHT_SHZT='A' AND ZHHT_HTBH='".$zhht."'")->field('ZHHT_HTBH,ZHHT_ZHBH,ZHHT_CCZF')->find();
    	$xm = get_pfxm($pgmb);
    	$this->assign('ht',$ht);//dump($Data->getLastSql());
    	$this->assign('xm',$xm);
    	$this->display();
    }

    //保存诚信评估
    public function SaveCreditEvaluation(){
    	$xm = get_pfxm($this->_post('pgmb'));
    	//dump($xm);
    	$data = array();
    	$xmdf=$this->_post('xmdf');
    	$qkms=$this->_post('qkms');
    	$bz=$this->_post('bz');
    	$zdf = 0;//总得分
    	$djbh = create_djbh(M('cxpg'),'CXPG');//主表单号

    	//评估项目
    	foreach($xm['item'] as $key=>$item){
    		$data[]=array(
    			'XPGD_ZBDH'=>$djbh,//主表单单号
    			'XPGD_XMBH'=>$item['CXLX_XMBH'],//项目编号
    			'XPGD_XMDF'=>intval($xmdf[$item['CXLX_XMBH']]),//项目得分
    			'XPGD_QKMS'=>$qkms[$item['CXLX_XMBH']],//描述情况
    			'XPGD_BZ'=>$bz[$item['CXLX_XMBH']],//备注
    			'XPGD_PJRQ'=>date('Y-m-d'),//评价日期
    			'XPGD_JCPZ'=>$this->_post('zhbh'),//租户编号
    		);
    		$zdf += intval($xmdf[$item['CXLX_XMBH']]);
    	}

    	//评估主表
    	$data_cxpg = array(
    		'CXPG_DJBH'=>$djbh,//单据编号
    		'CXPG_DJRQ'=>date('Y-m-d H:i:s'),//单据日期
    		'CXPG_CZY'=>'系统',//操作员
    		'CXPG_CZYID'=>'SYSTEM',//操作员ID
    		'CXPG_SFZH'=>session('yzxx_sfzh'),//身份证号码(租客)
    		'CXPG_HTBH'=>$this->_post('htbh'),//合同编号
    		'CXPG_ZHBH'=>$this->_post('zhbh'),//租户编号
    		'CXPG_ZDF'=>$zdf,//总得分
    		'CXPG_PGMB'=>$this->_post('pgmb'),//评估模板编号
    	);
    	M('cxpg')->startTrans();//开启事务支持
    	$save_cxpg = M('cxpg')->add($data_cxpg);
    	//dump($data_cxpg);
    	//dump($data);
    	if($save_cxpg){
    		foreach($data as $key=>$item){
    			$save_cxpg_d = M('cxpg_d')->add($item);
    			//dump($save_cxpg_d);
    			if(!$save_cxpg_d) break;
    		}
    		//M('cxpg')->rollback(); 
    		//exit;
    		//dump($data);
    		//dump(M('cxpg_d')->getLastSql());
    		if($save_cxpg_d){
    			M('cxpg_d')->commit();
    			$this->success('诚信评估提交成功！',U('/Tenant/CreditEvaluation'));
    		}
    		else{
    			M('cxpg_d')->rollback(); 
    			M('cxpg')->rollback(); 
    			$this->error('诚信评估项目评分提交失败！');
    		}
    	}
    	else{
    		M('cxpg')->rollback(); 
    		$this->error('诚信评估提交失败！');
    	}

    	
    	//dump($this->_post());
    }

    //新添加黑名单
    public function NewBlackList(){
    	$zhbh = $this->_get('zhbh');
        $this->zhbh=$zhbh;
    	if($zhbh){
            $zh = M('zhxx')->join('USR_ZHHT ON ZHXX_DJBH=ZHHT_ZHBH')->where("ZHHT_SFZHM1='".session('yzxx_sfzh')."' AND ZHHT_SHZT='A' AND ZHXX_SHZT='A' AND ZHXX_DJBH='".$zhbh."'")->field('ZHHT_HTBH,ZHHT_ZHBH,ZHXX_XM')->find();
            if(!$zh) $this->error('租户不存在!');
            if(M('cxhmd')->where("HMD_JCPZ='".$zh['ZHHT_ZHBH']."'")->count()>0) $this->error('租户已经存在黑名单中!');
        }
        else{
            $zh = M('zhxx')->join('USR_ZHHT ON ZHXX_DJBH=ZHHT_ZHBH')->where("ZHHT_SFZHM1='".session('yzxx_sfzh')."' AND ZHHT_SHZT='A' AND ZHXX_SHZT='A'")->field('ZHHT_HTBH,ZHHT_ZHBH,ZHXX_XM,ZHXX_DJBH')->select();
        }
        $this->zh=$zh;
    	$this->display();
    }

    //保存黑名单
    public function SaveBlackList(){
    	$data = array(
    		'HMD_JCPZ'  => $this->_post('zhbh'),
            'HMD_SFZH'  => $this->_post('HMD_SFZH'),
            'HMD_XM'    => $this->_post('HMD_XM'),
            'HMD_ZHXB'  => $this->_post('HMD_ZHXB'),
            'HMD_SY'    => $this->_post('sy'),
    		'HMD_CZSJ'  => date('Y-m-d H:i:s'),
    		'HMD_CZY'   => '系统',
    		'HMD_CZYID' => 'SYSTEM',
    	);
        //if(M('cxhmd')->where("HMD_JCPZ='".$this->_post('zhbh')."'")->count()>0) $this->error('租户已经存在黑名单中!');
    	if(M('cxhmd')->add($data)){
    		$this->success('黑名单提交成功！',U('/Tenant/CreditEvaluation'));
    	}
    	else
    		$this->error('黑名单提交失败！');
    }

    //黑名单
    public function BlackList(){
        $hmd = M('cxhmd');
        import('ORG.Util.Page');
        $condition = array();
        $condition['zhht_sfzhm1']=session('yzxx_sfzh');
        $count = $hmd->where($condition)->count();
        $nowPage = $this->_get('p','intval',1);
        if($nowPage<=0) $nowPage = 1;
        $pripage=10;
        $Page = new Page($count,$pripage);
        $this->list = $hmd->field('hmd_jcpz,zhht_cczf,HMD_YZSHF,hmd_sy,hmd_czy,hmd_czsj')->join('usr_zhht on zhht_zhbh=hmd_jcpz')->where($condition)->page($nowPage.','.$Page->listRows)->select();
        $this->page = $Page->show();
        $this->nowpage='211';
        $this->pripage =$pripage;
        $this->assign("currentpage",$Page->getnowPage());
        $this->display();//dump($this->list);
    }

    //管理费对账单（字表查询）
    public function Bill(){
        import('ORG.Util.Page');
        $d = M('fylr_d','t_');
        $join = array();
        $join[] = 'LEFT OUTER JOIN USR_LYB ON FYLRZB_LY = LYB_BH';
        $join[] = 'LEFT OUTER JOIN T_SFXM_D ON FYLRZB_BZDM = SFXMZB_DM ';
        $join[] = 'LEFT OUTER JOIN SYS_BILLSTATUS ON FYLRZB_STATUS=STATUS_ID';
        $condition = array();
        $condition['FYLRZB_SHZT']='A';
        $condition['USR_LYB.LYB_SFZH']=session('yzxx_sfzh');
        $order = 'FYLRZB_MPBH';
        $fields = 'T_FYLR_D.*,LYB_MC AS FYLRZB_LYMC,SFXMZB_GSMC AS FYLRZB_BZMC,STATUS_NAME';
        $count = $d->join($join)->where($condition)->count();
        if($nowPage<=0) $nowPage = 1;
        $Page = new Page($count);
        $this->list=$d->field($fields)->join($join)->order($order)->where($condition)->page($nowPage.','.$Page->listRows)->select();
        $this->page = $Page->show();
        $this->display();
    }

    //管理费对账单 (主表查询)
    public function Bill2(){
        $fylr = M('fylr','T_');
        import('ORG.Util.Page');

        //查询条件
        $condition = array();
        $condition['USR_LYB.LYB_SFZH']=session('yzxx_sfzh');
        $condition['FYLR_SHZT']='A';
        
        //join操作
        $join = array();
        $join[] = 'LEFT OUTER JOIN T_FYLR_D ON FYLR_ID = FYLRZB_ID';
        $join[] = 'LEFT OUTER JOIN T_SFXM ON FYLR_XMBH = SFXM_XMBH';
        $join[] = 'LEFT OUTER JOIN USR_QY ON FYLR_XQBH = QY_QYBH';
        $join[] = 'LEFT OUTER JOIN USR_LYB ON FYLRZB_LY = LYB_BH';
        $join[] = 'LEFT OUTER JOIN SYS_BILLSTATUS ON FYLRZB_STATUS = STATUS_ID';

        //字段
        $fields = 'FYLR_ID,FYLR_XMBH,SFXM_XMMC,FYLR_XQBH,QY_QYMC,FYLRZB_LY,LYB_MC,FYLR_TOTAL,FYLR_JFSR,FYLR_RQ,STATUS_NAME,FYLRZB_JE';

        $count = $fylr->join($join)->where($condition)->count();
        $nowPage = $this->_get('p','intval',1);
        if($nowPage<=0) $nowPage = 1;
        $Page = new Page($count);
        $this->list=$fylr->field($fields)->join($join)->order('FYLR_JFSR')->where($condition)->page($nowPage.','.$Page->listRows)->select();
        $this->page = $Page->show();
        $this->display();
        //dump($fylr->getLastSql());
    }

    //对账单详情
    public function DetailBill(){
        $id = $this->_get('id');
        if($id){
            //join
            $join = array();
            $join[] = 'LEFT OUTER JOIN USR_QY ON FYLR_XQBH = QY_QYBH';
            $join[] = 'LEFT OUTER JOIN T_SFXM ON FYLR_XMBH = SFXM_XMBH';
            $join[] = 'LEFT OUTER JOIN USR_LYB ON FYLR_LY = LYB_BH';
            $join[] = 'LEFT OUTER JOIN SYS_BILLSTATUS ON FYLR_STATUS=STATUS_ID';

                //字段
            $fields = 'FYLR_DATE,FYLR_TOTAL,FYLR_XQBH,FYLR_CJR,FYLR_CJSJ,FYLR_CZSJ,FYLR_ID,FYLR_JFQX,FYLR_JFSR,FYLR_RQ,FYLR_ZDR,FYLR_XMBH,QY_QYMC,SFXM_XMMC,STATUS_NAME';

            //条件
            //查询条件
            $condition = array();
            //$condition['USR_LYB.LYB_SFZH']=session('yzxx_sfzh');
            $condition['FYLR_SHZT']='A';
            $condition['FYLR_ID']=$id;

            $fylr = M('fylr','t_');
            $this->detail = $fylr->where($condition)->field($fields)->join($join)->find();
            if(!$this->detail) $this->errror('找不到对账单！');
            $nowPage = $this->_get('p','intval',1);
            $list = $this->get_bills($id,$nowPage);
            $this->list = $list['list'];
            $this->page = $list['page'];
            $this->display();
        }
        else
            $this->error('参数错误！');
    }

    //获取对账单状态列表
    protected function get_bill_status($id=null){
        $model = M('billstatus','sys_');
        $fields = 'STATUS_ID,STATUS_NAME';
        $order = 'STATUS_ID';
        $status = $model->field($fields)->order($order)->select();
        $return = array();
        foreach($status as $key=>$item){
            $return[$item['STATUS_ID']]=$item;
        }
        if($id){
            return $return[$id];
        }
        else
            return $return;

        //SELECT STATUS_ID,STATUS_NAME FROM SYS_BILLSTATUS ORDER BY STATUS_ID
    }

    protected function get_bills($FYLRZB_ID,$nowPage=1){
        if($FYLRZB_ID){
            import('ORG.Util.Page');
            $d = M('fylr_d','t_');
            $join = array();
            $join[] = 'LEFT OUTER JOIN USR_LYB ON FYLRZB_LY = LYB_BH';
            $join[] = 'LEFT OUTER JOIN T_SFXM_D ON FYLRZB_BZDM = SFXMZB_DM ';
            $join[] = 'LEFT OUTER JOIN SYS_BILLSTATUS ON FYLRZB_STATUS=STATUS_ID';
            $condition = array();
            $condition['FYLRZB_ID'] = $FYLRZB_ID;
            $condition['USR_LYB.LYB_SFZH']=session('yzxx_sfzh');
            $order = 'FYLRZB_MPBH';
            $fields = 'T_FYLR_D.*,LYB_MC AS FYLRZB_LYMC,SFXMZB_GSMC AS FYLRZB_BZMC,STATUS_NAME';
            $count = $d->join($join)->where($condition)->count();
            if($nowPage<=0) $nowPage = 1;
            $Page = new Page($count);
            $list=$d->field($fields)->join($join)->order($order)->where($condition)->page($nowPage.','.$Page->listRows)->select();
            //dump($d->getLastSql());
            return array('page'=>$Page->show(),'list'=>$list);
        }
    }
}
?>