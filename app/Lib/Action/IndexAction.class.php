<?php
class IndexAction extends BaseAction {

    public function index(){
        $msg = array();
        $msg += $this->get_htxx();//合同
        $msg += $this->get_glfqf();//管理费
        $msg += $this->get_hmd();//黑名单
        $this->msg = $msg;
        $this->display();
        //dump($msg);
        //$this->get_glfqf();
    }

    //租户合同提醒
    //提醒天数 按照合同表设定
    protected function get_htxx(){
        $Data = M('zhht');
        //$sql = "select * from usr_zhht where DATEDIFF(day, getdate(), zhht_htzz) between 0 and zhht_httxrq"
        $list = $Data->field('ZHHT_HTZZ,ZHHT_HTBH,ZHHT_HTMC,ZHHT_CCZF,ZHHT_HTQS')->order('zhht_htzz asc')->where('(DATEDIFF(day, getdate(), zhht_htzz) between 0 and zhht_httxrq) AND zhht_sfzhm1=\''.session('yzxx_sfzh').'\'')->select();
        $return = array();
        foreach($list as $key=>$item){
            $tmp = array(
                'type'=>'租户合同',
                'expired'=>strtotime($item['ZHHT_HTZZ']),
                'info'=>"合同编号为 $item[ZHHT_HTBH] 的合同 $item[ZHHT_HTMC] 将会在 ".date('Y-m-d',strtotime($item['ZHHT_HTZZ']))." 到期(承租方 $item[ZHHT_CCZF] ，合同期限：".date('Y-m-d',strtotime($item['ZHHT_HTQS']))." - ".date('Y-m-d',strtotime($item['ZHHT_HTZZ'])).") ",
                'url'=>U('/Tenant/DetailContract',array('htbh'=> $item['ZHHT_HTBH'])),
            );
            $return[]=$tmp;
        }
        return $return;
    }

    //管理费欠费提醒
    protected function get_glfqf(){
        $Data = M('yzxx');
        $sql = "SELECT T0.LYB_SSQY,T0.LYB_BH,T0.LYB_MC,T2.YZXX_SFZH,T2.YZXX_XM,T2.YZXX_LXSJ, T1.FYLRZB_JE,T1.FYLRZB_YFK,(T1.FYLRZB_JE-T1.FYLRZB_YFK) AS total 
        FROM  ( SELECT FYLRZB_LY, SUM(FYLRZB_JE)AS  FYLRZB_JE,SUM(FYLRZB_YFK)AS FYLRZB_YFK  
        FROM T_FYLR_D  WHERE FYLRZB_YFK='0' AND FYLRZB_SHZT='A'  GROUP BY  FYLRZB_LY )  AS T1 
        LEFT JOIN USR_LYB T0 ON T1.FYLRZB_LY=T0.LYB_BH
        LEFT JOIN USR_YZXX T2 ON T2.YZXX_SFZH=T0.LYB_SFZH 
        WHERE T2.YZXX_SFZH='".session('yzxx_sfzh')."' 
        ORDER BY T0.LYB_SSQY,T1.FYLRZB_LY";
        $list = $Data->query($sql);
        //dump($list);
        $return = array();
        foreach($list as $key=>$item){
            $tmp = array(
                'type'=>'管理费欠费',
                'expired'=>0,//欠费无到期日期
                'info'=>"您的物业 $item[LYB_MC] 还有 ".number_format((float)$item['total'],2)." 元管理费欠费需要缴清（收费金额 ".number_format((float)$item['FYLRZB_JE'],2)." 元 已付款 ".number_format((float)$item['FYLRZB_YFK'],2)." 元）",
                'url'=>'',
            );
            $return[]=$tmp;
        }
        return $return;
    }

    //获取该业主的租户是否在黑名单中
    protected function get_hmd(){
        $condition = array();
        $condition['zhht_sfzhm1']=session('yzxx_sfzh');
        $list = M('cxhmd')->field('hmd_jcpz,zhht_cczf,zhht_sfzhm,hmd_sy,hmd_czy,hmd_czsj,zhht_htbh')->join('usr_zhht on zhht_zhbh=hmd_jcpz')->where($condition)->select();
        $return = array();
        foreach($list as $key=>$item){
            $tmp = array(
                'type'=>'黑名单',
                'expired'=>'',
                'info'=>"您的租户 $item[zhht_cczf] 在我们的黑名单中，请注意(姓名 $item[ZHHT_CCZF] 租户编号 $item[hmd_jcpz])",
                'url'=>U('/Tenant/DetailContract',array('htbh'=> $item['zhht_htbh'])),
            );
            $return[]=$tmp;
        }
        return $return;
    }

    protected function get_msg(){

    }
}
?>