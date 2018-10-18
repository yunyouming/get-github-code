<?php 
function viewsite($url){
	// 1. 初始化
	 $ch = curl_init();
	 // 2. 设置选项，包括URL
	 curl_setopt($ch,CURLOPT_URL,$url);
	 curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
	 curl_setopt($ch,CURLOPT_SSL_VERIFYPEER ,false);
	 curl_setopt($ch,CURLOPT_SSL_VERIFYHOST ,false);
	 curl_setopt($ch,CURLOPT_USERAGENT, "elastos");
	 curl_setopt($ch,CURLOPT_HEADER,0);
	 // 3. 执行并获取HTML文档内容
	 $output = curl_exec($ch);
	 if($output === FALSE ){
	 echo "CURL Error:".curl_error($ch);
	 }
	 // 4. 释放curl句柄
	 curl_close($ch);
	 return $output;
}
if($_GET['furl']!=""){
	$jsonstr =  viewsite($_GET['furl']);
}else{
	$jsonstr =  viewsite("https://api.github.com/repos/elastos/Elastos.ORG.Wallet.Mobile/contents");
}
//echo $jsonstr;
$arr = json_decode($jsonstr,true);
$j = 0;
$k = 0;
for($i=0;$i<count($arr);$i++){
	if($arr[$i]['type']=="dir"){
		//echo "目录：".$arr[$i]['name']."<br>";
		$arrall1[$j]['name'] = $arr[$i]['name'];
		$arrall1[$j]['type'] = $arr[$i]['type'];
		$arrall1[$j]['html_url'] = $arr[$i]['html_url'];
		$arrall1[$j]['c_url'] = "";
		$arrall1[$j]['path'] = "https://api.github.com/repos/elastos/Elastos.ORG.Wallet.Mobile/contents/".$arr[$i]['path'];
		$arrall1[$j]['dirpath'] = $arr[$i]['path'];
		$j = $j+1;
	}elseif($arr[$i]['type']=="file"){
		//echo "文件".$arr[$i]['name']."<br>";
		$arrall2[$k]['name'] = $arr[$i]['name'];
		$arrall2[$k]['type'] = $arr[$i]['type'];
		$arrall2[$k]['html_url'] = $arr[$i]['html_url'];
		$arrall2[$k]['c_url'] = $arr[$i]['download_url'];
		$arrall2[$k]['path'] = "";
		$arrall2[$k]['dirpath'] = "";
		$k = $k+1;
		
	}
}
if(isset($arrall1)){
	$al = count($arrall1);
	if(isset($arrall2)){
		for($l=0;$l<count($arrall2);$l++){
			$arrall1[$al+$l] = $arrall2[$l];
		}
	}else{
		//$arrall1 = [];
	}
	echo json_encode($arrall1);
}else{
	$al = 0;
	if(isset($arrall2)){
		for($l=0;$l<count($arrall2);$l++){
			$arrall1[$al+$l] = $arrall2[$l];
		}
	}else{
		$arrall1 = [];
	}
	echo json_encode($arrall1);
}
?>