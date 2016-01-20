<?php 

$url = "../index.php?mod=page&act=list";

require_once "../model/Page.php";

$model = new Page;
$page_id = (int) $_POST['page_id'];

$page_title_vi = $model->processData($_POST['page_title_vi']);

$page_title_en = $model->processData($_POST['page_title_en']);



$content_vi = $_POST['content_vi'];
$content_en = $_POST['content_en'];


$tinh_id = (int) $_POST['tinh_id'];


if($page_id > 0) {	

	$model->updatePage($page_id,$page_title_vi,$page_title_en,$content_vi,$content_en,1,$tinh_id);

	header('location:'.$url);

}else{

	$model->insertPage($page_title_vi,$page_title_en,$content_vi,$content_en,1,$tinh_id);

	header('location:'.$url);

}



?>