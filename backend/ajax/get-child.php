<?php 
session_start();
require_once "../model/Backend.php";
$model = new Backend();
$id = (int) $_POST['id'];
$column = $_POST['column'];
$table = $_POST['table'];
$type = isset($_POST['type']) ? $_POST['type'] : "form";
$arrCustom = array();
if($table=="district"){	
	if($_SESSION['level']==1){
	    $arrCustom['user_id'] = -1;    
	}else{
	    $arrCustom['user_id'] = $_SESSION['user_id'];    
	}
}
$arrResult = $model->getChild($table, $column, $id, -1, $arrCustom);

echo $type=='form' ? "<option value='0'>--chọn--</option>" : "<option value='0'>--Tất cả--</option>";
if(!empty($arrResult)){
	foreach ($arrResult as $key => $value) {
		echo "<option value='".$key."'>".$value['name']."</option>";
	}
}
?>