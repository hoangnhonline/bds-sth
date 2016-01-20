<?php
require_once "model/Page.php";

$model = new Page;

$link = "index.php?mod=page&act=list";

$limit = 20;

$arrTotal = $model->getListPage(-1, -1);

require_once "model/Tinh.php";

$modelTinh = new Tinh;

$total_page = ceil($arrTotal['total'] / $limit);



$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;



$offset = $limit * ($page - 1);



$arrList = $model->getListPage($offset, $limit);

?>



<div class="row">

    <div class="col-md-12">

    <button class="btn btn-primary btn-sm right" onclick="location.href='index.php?mod=page&act=form'">Tạo mới</button>        

         <div class="box-header">

                <h3 class="box-title">Danh sách trang</h3>

            </div><!-- /.box-header -->

        <div class="box">

            <div class="box_search">             

                

            </div>

            <div class="box-body">

                <table class="table table-bordered table-striped">

                    <tbody><tr>

                        <th style="width: 10px">No.</th>

                        <th width="300">Tiêu đề</th>    
                        <th width="300">Điểm đến HOT</th>                                           

                        <th style="width: 40px">Action</th>

                    </tr>

                    <?php

                    $i = ($page-1) * $limit; 

                    if(!empty($arrList['data'])){                   

                    foreach($arrList['data'] as $row){

                    $i++;

                    ?>

                    <tr>

                        <td><?php echo $i; ?></td>

                        <td>

                            <a href="index.php?mod=page&act=form&page_id=<?php echo $row['page_id']; ?>">

                                <?php echo $row['page_title_vi']; ?> 

                            </a>

                       

                        </td>
                        <td><?php echo $modelTinh->getTinhNameByID($row['tinh_id']); ?></td>
                       
                        <td style="white-space:nowrap">                            

                            <a href="index.php?mod=page&act=form&page_id=<?php echo $row['page_id']; ?>">

                                <i class="fa fa-fw fa-edit"></i>

                            </a>

                            <a href="javascript:;" alias="<?php echo $row['page_title_vi']; ?>" id="<?php echo $row['page_id']; ?>" mod="page" class="link_delete" >    

                                <i class="fa fa-fw fa-trash-o"></i>

                            </a>    

                            

                        </td>

                    </tr>      

                    <?php } }else{ ?>              

                    <tr>

                        <td colspan="8" class="error_data">Không tìm thấy dữ liệu!</td>

                    </tr>

                    <?php } ?>

                </tbody></table>

            </div><!-- /.box-body -->

            <div class="box-footer clearfix">

                <!--

                <ul class="pagination pagination-sm no-margin pull-right">

                    <li><a href="#">«</a></li>

                    <li><a href="#">1</a></li>

                    <li><a href="#">2</a></li>

                    <li><a href="#">3</a></li>

                    <li><a href="#">»</a></li>

                </ul>-->

                <?php echo $model->phantrang($page, PAGE_SHOW, $total_page, $link); ?>

            </div>

        </div><!-- /.box -->                           

    </div><!-- /.col -->

   

</div>