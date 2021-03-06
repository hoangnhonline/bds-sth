<?php 
$url = "../index.php?mod=doanhthu&act=list&contract_id=".$_POST['contract_id'];
session_start();
require_once "../model/Backend.php";
$model = new Backend;
$user_id = $_SESSION['user_id'];
$price_thue_phong = str_replace(",", "", $_POST['price']);
$arrDoanhThu['contract_id'] = $contract_id = (int) $_POST['contract_id'];
$arrDoanhThu['month'] = $month = (int) $_POST['month'];
$arrDoanhThu['year'] = $year = (int) $_POST['year'];

$arrDoanhThu['tien_phai_thu'] = $tien_phai_thu = str_replace(',', '', $_POST['tien_phai_thu']);
$arrDoanhThu['tien_nhan'] = $tien_nhan = str_replace(',', '', $_POST['tien_nhan']);
$arrDoanhThu['cong_no'] = $cong_no = str_replace(',', '', $_POST['cong_no']);
$arrDoanhThu['user_id'] = $user_id;
$arrDoanhThu['created_at'] = time();
$arrDoanhThu['updated_at'] = time();
//process doanh thu
if(isset($_POST['doanhthu_id']) && $_POST['doanhthu_id'] > 0){
	$doanhthu_id = $_POST['doanhthu_id'];
	$arrDoanhThu['id'] = $doanhthu_id;
	$model->update('doanh_thu', $arrDoanhThu);
	mysql_query("DELETE FROM contract_service_month WHERE doanhthu_id = $doanhthu_id");
}else{
	$doanhthu_id = $model->insert('doanh_thu', $arrDoanhThu);
}

//process tien thue phong
$arrContractServiceMonth = array();
$arrContractServiceMonth['doanhthu_id'] = $doanhthu_id;
$arrContractServiceMonth['service_id'] = 9999;
$arrContractServiceMonth['chi_so_cu'] = 0;
$arrContractServiceMonth['chi_so_moi'] = 0;
$arrContractServiceMonth['type'] = 1;
$arrContractServiceMonth['price'] = $price_thue_phong;
$arrContractServiceMonth['total_price'] = $price_thue_phong;
$arrContractServiceMonth['amount'] = 1;
$model->insert('contract_service_month', $arrContractServiceMonth);

// process service chi so
$arrCu = $_POST['chi_so_cu'];
$arrMoi = $_POST['chi_so_moi'];
$arrServiceIdChiSo = $_POST['service_id_chiso'];
$service_id_total_price = $_POST['service_id_total_price'];
$service_id_chi_so_price = $_POST['service_id_chi_so_price'];

$arrContractServiceMonth = array();

if(!empty($arrServiceIdChiSo)){
	foreach ($arrServiceIdChiSo as $k => $service_id) {
		$arrContractServiceMonth['doanhthu_id'] = $doanhthu_id;
		$arrContractServiceMonth['service_id'] = $service_id;
		$arrContractServiceMonth['type'] = 2;
		$arrContractServiceMonth['chi_so_cu'] = $arrCu[$k];
		$arrContractServiceMonth['chi_so_moi'] = $arrMoi[$k];
		$arrContractServiceMonth['price'] = $service_id_chi_so_price[$k];
		$arrContractServiceMonth['total_price'] = $service_id_total_price[$k];
		$arrContractServiceMonth['amount'] = $arrMoi[$k] - $arrCu[$k];	
		$model->insert('contract_service_month', $arrContractServiceMonth);
		$arrContractServiceMonth = array();
	}
}




//process service fee
$arrContractServiceMonth = array();

$arrServiceId = $_POST['service_id'];
$arrServiceFee = $_POST['service_fee'];

if(!empty($arrServiceId)){
	foreach ($arrServiceId as $key => $service_id) {
		$arrContractServiceMonth = array();
		$arrContractServiceMonth['doanhthu_id'] = $doanhthu_id;
		$arrContractServiceMonth['service_id'] = $service_id;
		$arrContractServiceMonth['chi_so_cu'] = 0;
		$arrContractServiceMonth['chi_so_moi'] = 0;
		$arrContractServiceMonth['type'] = 2;
		$arrContractServiceMonth['price'] = $arrServiceFee[$service_id];
		$arrContractServiceMonth['total_price'] = $arrServiceFee[$service_id];
		$arrContractServiceMonth['amount'] = 1;	
		$model->insert('contract_service_month', $arrContractServiceMonth);
		$arrContractServiceMonth = array();
	}
}


//process convenient fee
$arrContractConMonth = array();

$arrConId = $_POST['convenient_id'];
$arrConFee = $_POST['convenient_fee'];

if(!empty($arrConId)){
	foreach ($arrConId as $key => $convenient_id) {
		$arrContractConMonth = array();
		$arrContractConMonth['doanhthu_id'] = $doanhthu_id;
		$arrContractConMonth['service_id'] = $convenient_id;
		$arrContractConMonth['chi_so_cu'] = 0;
		$arrContractConMonth['chi_so_moi'] = 0;
		$arrContractConMonth['type'] = 3;
		$arrContractConMonth['price'] = $arrConFee[$convenient_id];
		$arrContractConMonth['total_price'] = $arrConFee[$convenient_id];
		$arrContractConMonth['amount'] = 1;	
		$model->insert('contract_service_month', $arrContractConMonth);
		$arrContractConMonth = array();
	}
}
header('location:'.$url);
?>