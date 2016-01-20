<html>
<head>
<meta charset="UTF-8">
<meta name="description" content="Free Web tutorials">
<meta name="keywords" content="HTML,CSS,XML,JavaScript">
<meta name="author" content="Hege Refsnes">
</head>
<body>
<?php 
error_reporting(1);
ini_set('display_errors', 1);
set_time_limit(0);
require "simplehtmldom/simple_html_dom.php";

require_once "../backend/models/Crawler.php";
$model = new Crawler;
for($i = 91; $i <= 100; $i ++){
	$url = "http://biquyetlamdep.com/trang-diem-dep/page/".$i;

	$domain = "";

	$cate_id = 5;
	$folder_name = "mat-dep";

	$arrClass = array(
		'title' => 'h1.entry-title',
		'description' => '',
		'content' => 'div.td-post-content'
	);


	$arrImgExpert = array('share-fb.gif', 'share-gg.gif');

	$arrPregReplace = array(
		'#<div class="baiviet-bailienquan">(.*?)</div>#',
		'#<div id="box_mxh_trang_bai_viet"(.*?)</div>#',
		'#<script>(.*?)</script>#',
		'#<script(.*?)</script>#',
		'#<span id="shareImage(.*?)</span>#',	
		'#<a (.*?)>#',
		'#</a>#'
	);

	$arrStrReplace = array(	
		'<!-- A generated by theme -->'
	);

	$arrElement = array('.td-ss-main-content .td-module-thumb');
	$arrLink = array();
	$arrLink = $model->getAllLink($url, $arrElement, $domain, $cate_id, $folder_name);

	$classMore = '';

	if(!empty($arrLink)){
		$model->insertPost($arrLink, $arrUrl, $arrClass, $arrImgExpert, $folder_name, $arrPregReplace, $arrStrReplace, '' , $classMore, $cate_id);
	}else{
		echo "<h1>Not found articles.</h1>";
	}
}
?>
</body>
</html>
