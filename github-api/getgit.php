<html>
<head>
<meta charset="UTF-8" />
<title>Elastos wallet</title>
<meta name="X-Frame-Options" contect="SAMEORIGIN">
<script src="jquery-3.3.1.min.js"></script>
<link rel="stylesheet" href="codemirror.css">  <!-- 引入CSS文件 -->
 <script src="codemirror.js"></script>  <!-- 引入JS文件 -->
<style>
::-webkit-scrollbar {
width: 5px;
}
::-webkit-scrollbar-track {
background-color: #eaeaea;
border-left: 1px solid #ccc;
}
::-webkit-scrollbar-thumb {
background-color: #ccc;
}
::-webkit-scrollbar-thumb:hover {
background-color: #aaa;
}
::-webkit-scrollbar-thumb:active{
background-color:#999;
}
#dirtree li:first-child{margin-top:10px;}
</style>
</head>
<body style="margin:0 auto;padding:0 auto;">
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
$jsonstr =  viewsite("https://api.github.com/repos/elastos/Elastos.ORG.Wallet.Mobile/contents");
//var_dump($aaaa);
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
/* $al = count($arrall1);
for($l=0;$l<count($arrall2);$l++){
	$arrall1[$al+$l] = $arrall2[$l];
} */

if(isset($arrall1)){
	$al = count($arrall1);
	if(isset($arrall2)){
		for($l=0;$l<count($arrall2);$l++){
			$arrall1[$al+$l] = $arrall2[$l];
		}
	}else{
		//$arrall1 = [];
	}
	//echo json_encode($arrall1);
}else{
		$al = 0;
	if(isset($arrall2)){
		for($l=0;$l<count($arrall2);$l++){
			$arrall1[$al+$l] = $arrall2[$l];
		}
	}else{
		$arrall1 = [];
	}
	//echo json_encode($arrall1);
}
?>
<div style="width:100%;height:auto;">
	<div style="float:left;width:20%;height:650px;margin-top:50px">
		<div id="curpath" style="border-bottom: 1px solid #999;height:45px;line-height:40px;text-align:left;padding-left:10px;font-size:12px;overflow-x:auto;overflow-y:hidden;">当前目录：根<span class='' style='cursor:hand;' curi='' _href=''>.</span>/</div>
		<ul id="dirtree" style="padding-top:5px;list-style-type:none;margin:0px;padding:0px;margin-left:20px;overflow:scroll;min-height:600px; ">
			<?php for($w=0;$w<count($arrall1);$w++){ ?>
				<?php if($arrall1[$w]['type']=="dir"){ ?>
					<li style="font-size:12px;cursor:hand ;" class="jumpurl" cate="1" curp="<?php echo $arrall1[$w]['dirpath'];?>" jurl="<?php echo $arrall1[$w]['path'];?>"  hurl="<?php echo $arrall1[$w]['html_url'];?>"><img src="dir.png" style="width:15px;height:15px;" /><span><?php echo $arrall1[$w]['name'];?></span></li>
				<?php }elseif($arrall1[$w]['type']=="file"){ ?>
					<li style="font-size:12px;cursor:hand ;"  class="jumpurl"  cate="2" curp="<?php echo $arrall1[$w]['dirpath'];?>"  jurl="<?php echo $arrall1[$w]['c_url'];?>" hurl="<?php echo $arrall1[$w]['html_url'];?>" ><img src="file.png" style="width:15px;height:15px;" /><span><?php echo $arrall1[$w]['name'];?></span></li>
				<?php }?>
			<?php }?>
			
		</ul>
	</div>
	<div style="border:0px solid #999;width:75%;float:left;height:650px; overflow:hidden;margin-top:50px;padding:2px;-webkit-scrollbar-arrow-color:#f4ae21;">
	<div  style="border-bottom:1px solid #aaa;height:42px;line-height:40px;text-align:left;padding-left:10px;font-size:12px;width:100%;"><div style="float:left;font-size:14px;">代码</div><div style="float:right;font-size:14px;"><a href="https://github.com/elastos/Elastos.ORG.Wallet.Mobile/blob/master/README.md" style="text-decoration:none;color:#444;" target="_blank" id="githuburl">&nbsp;&nbsp;Edit on github&nbsp;&nbsp;</a></div><img src="githublogo.svg" style="width:25px;height:40px;float:right;" /></div>
	<textarea id="code" name="code" style="border:1px solid #999;margin-top:40px;" ><?php
	$c = file_get_contents("https://raw.githubusercontent.com/elastos/Elastos.ORG.Wallet.Mobile/master/README.md"); 
	echo $c;?></textarea>
	</div>
</div>
<script>
var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
	lineNumbers : true,
	mode: "application/xml",
	theme: "custom"
});
editor.setSize("auto",'600px');
$(document).ready(function(){
	//$(".jumpurl").click(function(){
	$(document).on("click",".jumpurl",function(){	
		if($(this).attr("cate")=="2"){
			url = $(this).attr("jurl");
			html_url = $(this).attr("hurl");
			$("#githuburl").attr("href",html_url);
			$.get(
				url,
				{},
				function(data){
					editor.getDoc().setValue(data);
					editor.refresh();
					$("#code").html(data);
				}
			)
		}else{
			$("#dirtree").html("<li style='width:100%:height:200px;text-align:left;'><img src='loadingl.gif' style='width:160px;height:120px' /></li>");
			path = $(this).attr("curp");
			var narr = path.split("/");
			var spanhtml = "";
			for(var i=0;i<narr.length;i++){
				spanhtml = spanhtml+"<span class='' style='cursor:hand;' curi='"+i+"' _href='"+ narr[i] +"'>/"+ narr[i] +"</span>";
			}
			$("#curpath").html("<span class='' style='cursor:hand;' curi='' _href=''>根.</span>"+spanhtml);
		url = "http://ela.chat/github/getgitdir.php";
		console.log("路径:https://api.github.com/repos/elastos/Elastos.ORG.Wallet.Mobile/contents/"+path);
			$.get(
				url,
				{furl:"https://api.github.com/repos/elastos/Elastos.ORG.Wallet.Mobile/contents/"+path},
				function(data){
					var data = $.parseJSON(data);
					var html = "";
					for(var i=0;i<data.length;i++){
						if(data[i]['type']=="dir"){
							html = html+'<li  style="font-size:12px;cursor:hand;"  class="jumpurl" cate="1" curp="'+ data[i]['dirpath'] +'" jurl="'+data[i]['path']+'" hurl="'+ data[i]['html_url'] +'"><img src="dir.png" style="width:15px;height:15px;" /><span>'+ data[i]['name'] +'</span></li>';
						}else if(data[i]['type']=="file"){
							html = html+'<li style="font-size:12px;cursor:hand;"  class="jumpurl" cate="2" curp="'+ data[i]['dirpath'] +'" jurl="'+data[i]['c_url']+'" hurl="'+ data[i]['html_url'] +'"><img src="file.png" style="width:15px;height:15px;" /><span>'+ data[i]['name'] +'</span></li>';
						}
						
					}
					//console.log(html);
					$("#dirtree").html(html);
				}
			)
		}
	})
	$(document).on("click","#curpath span",function(){
			var curi = $(this).attr("curi");
			var urls = $(this).attr("_href");
			path = "";
			$(this).nextAll().remove();
			if(urls!=""){
				$("#curpath span").each(function(){
					if($(this).attr("curi")<=curi){
						path = path+"/"+$(this).attr("_href");
					}
				});	
			}
		url = "http://ela.chat/github/getgitdir.php";
		$("#dirtree").html("<li style='width:100%:height:200px;text-align:left;'><img src='loadingl.gif' style='width:160px;height:120px' /></li>");
		$.get(
			url,
			{furl:"https://api.github.com/repos/elastos/Elastos.ORG.Wallet.Mobile/contents"+path},
			function(data){
				var data = $.parseJSON(data);
				var html = "";
				for(var i=0;i<data.length;i++){
					if(data[i]['type']=="dir"){
						html = html+'<li style="font-size:12px;cursor:hand;"  class="jumpurl" cate="1" curp="'+ data[i]['dirpath'] +'" jurl="'+data[i]['path']+'" hurl="'+ data[i]['html_url'] +'"><img src="dir.png" style="width:15px;height:15px;" /><span>'+ data[i]['name'] +'</span></li>';
					}else if(data[i]['type']=="file"){
						html = html+'<li style="font-size:12px;cursor:hand;"  class="jumpurl" cate="2" curp="'+ data[i]['dirpath'] +'" jurl="'+data[i]['c_url']+'" hurl="'+ data[i]['html_url'] +'"><img src="file.png" style="width:15px;height:15px;" /><span>'+ data[i]['name'] +'</span></li>';
					}
					
				}
				console.log(html);
				$("#dirtree").html(html);
			}
		)
	})
	$(document).on("mouseover",".jumpurl",function(){
		$(this).css("background-color","#e5e5e5");
	})
	$(document).on("mouseout",".jumpurl",function(){
		$(this).css("background-color","#fff");
	})
});
</script>
</body>
</html>