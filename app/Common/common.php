<?php
//获取评分项目
function get_pfxm($bh=NULL,$ttl=300){
	$xm = S('CXPGPFXM');
	if(!$xm){
		$xm = array();
		$data = M('cxsz_d')->join('USR_CXSZ ON CXSZ_DJBH=XSZD_ZBDH')->join('USR_CXLX ON XSZD_XMBH=CXLX_XMBH')->where("CXSZ_SHZT='A'")->field('CXLX_XMBH,CXLX_XMMC,CXSZ_DJBH,CXSZ_PGMBMC,CXSZ_SFMR')->select();
		foreach($data as $key=>$item){
			$xm[$item['CXSZ_DJBH']]['CXSZ_DJBH']=$item['CXSZ_DJBH'];
			$xm[$item['CXSZ_DJBH']]['CXSZ_PGMBMC']=$item['CXSZ_PGMBMC'];
			$xm[$item['CXSZ_DJBH']]['CXSZ_SFMR']=$item['CXSZ_SFMR'];
			$xm[$item['CXSZ_DJBH']]['item'][]=array('CXLX_XMBH'=>$item['CXLX_XMBH'],'CXLX_XMMC'=>$item['CXLX_XMMC']);
		}
		S('CXPGPFXM',$xm,$tto);//5分钟换乘
	}
	if($bh)
		return $xm[$bh];
	else
		return $xm;
}

//生成单据编号
//$tblObj 数据表对象
//$p 前缀
function create_djbh($tblObj,$p){
	$djbh = "$p".date('ym').'-';
    $count = $tblObj->where("CXPG_DJBH like '$djbh%'")->count();
    //dump($count);
    $djbh .= sprintf("%04d",++$count);
    return $djbh;
}
?>