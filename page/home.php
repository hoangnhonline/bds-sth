<?php 
  $city_id = isset($_GET['city_id']) && (int) $_GET['city_id'] > 0 ?  $_GET['city_id'] : 1;
  $cityArr = $model->getList('city', -1, -1);
?>
<section class="section-top-home-block clearfix">


    <section class="slideshow-block col-md-9">
      <div class="body-wrap">
        <div class="flexslider">
           <ul class="slides">
            <?php 
            $arrBanner = $model->getListBannerByPosition(1);
            foreach($arrBanner as $banner){              
            ?>
            <li><img src="<?php echo $banner['image_url']; ?>" alt=""></li>
            <?php } ?>             
           </ul>
        </div>
      </div>
    </section><!-- End /.slideshow-block -->
    
    
    <section class="news-highlight-home-block col-md-3" style="border:1px solid #C1F1D6;padding:0px; margin-right: 12px;">
      <h3 class="tit-block" style="background-color:#055699;color: #FBFDFC;">Tìm kiếm</h3>
      <div class="col-md-12">       
  
        <div class="form-group">
         
          <select class="form-control selectpicker show-tick" data-live-search="true" id="type" name="type">
            <option value='0'>-- Loại hình --</option>
            <option value='2'>BĐS bán</option>
            <option value='1'>BĐS cho thuê</option>
          </select>
        </div>
        <div class="form-group">
         
          <select class="form-control selectpicker show-tick" data-live-search="true" name="type_id" id="type_id">
            <option data-alias="" value='0'>-- Loại nhà đất --</option>
          </select>
        </div>
        <div class="form-group">         
          <select class="form-control selectpicker" name="city_id" id="city_id" data-live-search="true">
            <option data-alias="" value='0'>-- Chọn Tỉnh/TP --</option>
            <?php foreach ($cityArr['data'] as $key => $value) {
              ?>
              <option data-alias="<?php echo $value['alias']; ?>" value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
              <?php
            }?>
          </select>
        </div>
        <div class="form-group">         
          <select class="form-control selectpicker show-tick" name="district_id" id="district_id" data-live-search="true">
            <option data-alias="" value='0'>-- Chọn Quận/Huyện --</option>
          </select>
        </div>
        <div class="form-group">         
          <select class="form-control selectpicker show-tick" name="price_id" id="price_id" data-live-search="true">
            <option data-alias="" value='0'>-- Chọn khoảng giá --</option>
          </select>
        </div>
        <button type="button" class="btn btn-primary" id="btnSearch" style="float:right"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> &nbsp;Tìm kiếm</button>
        <div class="clearfix" style="margin-bottom:20px"></div>
     
    </div>
    </section><!-- End /.slideshow -->
 
</section><!-- End Section -->



<div class='col-md-home' style="padding:0px;">
  <section class="latest-room-block-home">
  <div class="">
    <h1 class="title-section"><span>Phòng cho thuê đang và sắp trống</span></h1>
    
    <div class="aaaaa">
      <!-- Nav tabs -->
      <ul class="met_filters met_portfolio_filters">
        <li><a href="cho-thue-phong/ho-chi-minh.html" data-filter="*" class="activePortfolio">Tất cả</a></li>
        <?php 
        $arrDistrictDetail = array();
        $arrDistrict = $model->getListDistrictHaveRoom($city_id);
       
        if(!empty($arrDistrict)){
          $str_id = implode(',', $arrDistrict);

          $arrDistrictDetail = $model->getListDistrictByString($city_id, $str_id);
        }
        
        if(!empty($arrDistrictDetail)){
          foreach ($arrDistrictDetail as $id => $district) {            
            $detailCity = $model->getDetail('city', $district['city_id']);
        ?>
        <li>
          <a href="cho-thue-phong/<?php echo $detailCity['alias']; ?>/<?php echo $district['alias'] ?>.html" class="">
          <?php echo $district['name'] ?>
          </a>
        </li>
        <?php } } ?>                  
      </ul>
    </div>
    <div class="clearfix"></div>
          
          <div class="body-main col-md-12 content_room">
         <?php           
         
           $roomTotalArr = $model->getList("objects", -1, -1, array('city_id' => $city_id, 'object_type' => 1));
          
          $total_record_room = $roomTotalArr['total'];

          $total_page_room = ceil($total_record_room / 24);         

          $page = 1;

          $offset = 0;

          $roomArr = $model->getList("objects", 0, 24, array('city_id' => $city_id, 'object_type' => 1));
        
          ?>
            <ul class="list" id="list-room-home">
              <?php if(!empty($roomArr['data'])){
                foreach ($roomArr['data'] as $key => $value) {                        
                  //var_dump("<pre>", $value);                         
              ?>
              <li class="col-md-3 col-sm-4 col-sx-4 li_content_room">
                <div class="room-item">
               <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html" class="info">
                  <div class="thumb view-first" style="position:relative">
                  <?php if($value['status']==1){ ?>
                  <label class="label label-success lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đang trống</label>                            
                  <?php } ?> 
                  <?php if($value['status']==2){ ?>
                  <label class="label label-info lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đã cọc</label>                            
                  <?php } ?>    
                  <?php if($value['status']==3){ ?>
                  <label class="label label-warning lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đang ở</label>                            
                  <?php } ?>
                  <?php if($value['status']==4){ ?>
                  <label class="label label-danger lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Chờ gia hạn</label>                            
                  <?php } ?>         
                      <img class="lazy" data-original="<?php echo $value['image_url']; ?>" style="height:150px;width:100%" alt="<?php echo $value['name']; ?>">
                      <div class="mask">   

                        <ul>
                          <?php if($value['object_type'] == 1) { ?>
			  <li><span class="bold">Diện tích</span>: <?php echo $value['area']; ?> m2<li>
                          <li><span class="bold">Số người ở</span> : <?php echo $value['max_person']; ?></li>
                          <li><span class="bold">Tầng</span> : <?php echo $value['floor']; ?></li>
                          <?php } ?>
                         
                        </ul>                          
                     
                      </div>                          
                  </div>
		   </a>
                  <div class="body-text">         
                    <p class="address"><?php echo $model->getNameById('district', $value['district_id']); ?>, <?php echo $model->getNameById('city', $value['city_id']); ?></p>
                    <p class="price"><span class="name">Giá: </span> <span class="num"><?php echo number_format($value['price_1']); ?> VNĐ</span></p>
                    <p class="room-number"><span class="name">Phòng:</span> 
                      <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html">
                          <span class="num"><?php echo $value['name']; ?></span>
                      </a>
                    </p>
                  </div>
                </div>
              </li>
              <?php } } ?>
            </ul>
			<div class="clearfix"></div>
            <?php if($total_page_room >0){ ?>
              <ul class="phan-trang">
                <?php for($i=1; $i<=$total_page_room ; $i++){ ?>
                <li class="page <?php if($i==1) echo "active"; ?>" data-page="<?php echo $i; ?>" 
                  data-city="<?php echo $city_id; ?>" data-object-type="1" data-parent="list-room-home">
                  <span><?php echo $i; ?></span>
                </li>
                <?php } ?>
              </ul>
              <?php } ?>
          </div>
        
  </div><!-- End /.container -->
</section><!-- End Section -->      
<div class="clearfix"></div>
<section class="latest-room-block-home" style="margin-top:20px">
  <div class="">
    <h1 class="title-section"><span>Nhà cho thuê đang và sắp trống</span></h1>
    
    <div class="aaaaa">
      <!-- Nav tabs -->
     
      <ul class="met_filters met_portfolio_filters">
        <li><a href="cho-thue-nha-nguyen-can/ho-chi-minh.html" data-filter="*" class="activePortfolio">Tất cả</a></li>
        <?php 
        $arrDistrictDetail = array();
      
        $arrDistrict = $model->getListDistrictHaveHouse($city_id);                
    
        if(!empty($arrDistrict)){
          $str_id = implode(',', $arrDistrict);

          $arrDistrictDetail = $model->getListDistrictByString($city_id, $str_id);
        }
        
        if(!empty($arrDistrictDetail)){
          foreach ($arrDistrictDetail as $id => $district) {
           $detailCity = $model->getDetail('city', $district['city_id']);
        ?>
        <li>
          <a href="cho-thue-nha-nguyen-can/<?php echo $detailCity['alias']; ?>/<?php echo $district['alias'] ?>.html" class="">
          <?php echo $district['name'] ?>
          </a>
        </li>
        
        <?php } } ?>                  
      </ul>
    </div>
    <div class="clearfix"></div>
         
          <div class="body-main col-md-12 content_room">
           <?php                             
          $houseTotalArr = $model->getList("objects", -1, -1, array('city_id' => $city_id, 'object_type' => 2));
          $total_record_house = $houseTotalArr['total'];

          $total_page_house = ceil($total_record_house / 24);         

          $page = 1;

          $offset = 0;
          $houseArr = $model->getList("objects", 0, 24, array('city_id' => $city_id, 'object_type' => 2));
        
          ?>
            <ul class="list" id="list-house-home">
              
              <?php if(!empty($houseArr['data'])){
                foreach ($houseArr['data'] as $key => $value) {                        
              ?>
              <li class="col-md-3 col-sm-4 col-sx-4 li_content_room">
                <div class="room-item">
                  <div class="thumb view-first" style="position:relative">
                  <?php if($value['status']==1){ ?>
                  <label class="label label-success lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đang trống</label>                            
                  <?php } ?> 
                  <?php if($value['status']==2){ ?>
                  <label class="label label-info lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đã cọc</label>                            
                  <?php } ?>    
                  <?php if($value['status']==3){ ?>
                  <label class="label label-warning lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Đang ở</label>                            
                  <?php } ?>
                  <?php if($value['status']==4){ ?>
                  <label class="label label-danger lable-lg" style="position:absolute; top : 5px; right: 5px;font-size:15px">Chờ gia hạn</label>                            
                  <?php } ?>                                              
                      <img class="lazy" data-original="<?php echo $value['image_url']; ?>" style="height:150px;width:100%" alt="<?php echo $value['name']; ?>">
                      <div class="mask">                              
                          <ul>
                          <li><span class="bold">Số phòng ngủ</span> : <?php echo $value['no_room']; ?></li>
                          <li><span class="bold">Số WC</span> : <?php echo $value['no_wc']; ?></li>
                          </ul>
                          <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html" class="info">Chi tiết</a>
                      </div>                          
                  </div>
                  <div class="body-text">
                    <p class="acreage"><span class="name">Diện tích:</span> <span class="num"><?php echo $value['area']; ?></span></p>
                    <p class="address"><?php echo $model->getNameById('district', $value['district_id']); ?>, <?php echo $model->getNameById('city', $value['city_id']); ?></p>
                    <p class="price"><span class="name">Giá: </span> <span class="num"><?php echo number_format($value['price']); ?> VNĐ</span></p>
                    <p class="room-number"><span class="name">Nhà:</span> 
                      <a href="chi-tiet/<?php echo $value['alias']; ?>-<?php echo $value['id']; ?>.html">
                        <span class="num"><?php echo $value['name']; ?></span>
                      </a>
                    </p>
                  </div>
                </div>
              </li>
              <?php } } ?>
              
            </ul>
			<div class="clearfix"></div>
              <?php if($total_page_house >0){ ?>
                <ul class="phan-trang">
                  <?php for($i=1; $i<=$total_page_house ; $i++){ ?>
                  <li class="page <?php if($i==1) echo "active"; ?>" data-page="<?php echo $i; ?>" 
                    data-city="<?php echo $city_id; ?>" data-object-type="2" data-parent="list-house-home">
                    <span><?php echo $i; ?></span>
                  </li>
                  <?php } ?>
                </ul>
                <?php } ?>
          </div>
          
  </div><!-- End /.container -->
</section><!-- End Section -->  

<section class="col-md-6"></section>

</div>
<section class="news-highlight-home-block col-md-tt" style="padding:0px;">
  <h3 class="tit-block">Tin tức nổi bật</h3>
  <ul class="list-box">
    <?php $sql = "SELECT * FROM articles ORDER BY id DESC LIMIT 0,4"; 
    $rs = mysql_query($sql);
    while($row = mysql_fetch_assoc($rs)){
    ?>
    <li class="row">
      <div class="col-xs-4 thumb"><a href="chi-tiet-tin/<?php echo $row['alias']?>-<?php echo $row['id']; ?>.html" title=""><img src="http://batdongsan.sth.vn/<?php echo $row['image_url']; ?>" alt="" ></a></div>
      <h4 class="title"><a href="chi-tiet-tin/<?php echo $row['alias']?>-<?php echo $row['id']; ?>.html" title=""><?php echo $row['name']; ?></a><h4>
    </li>
    <?php } ?>
  </ul>
</section><!-- End /.slideshow -->
<section class="news-highlight-home-block col-md-tt" style="padding:0px;">
  <h3 class="tit-block">Hỗ trợ trực tuyến</h3>
  <ul class="list-box" id="support">
   
    <li>
      Hotline : <span class="support-value"><?php echo $arrText[1]; ?></span>
    </li>
    <li>
      CSKH : <span class="support-value"><?php echo $arrText[2]; ?></span>
    </li>
    <li>
      Skype : <a href="skype:vietsth1.11@gmail.com?chat"><img src="images/skype-icon.png" style="width:16px !important;"/> 
      <span style="color:#055699"><?php echo $arrText[3]; ?></span></a>
    </li>
    <li>
      Email : <span class="support-value"><?php echo $arrText[4]; ?></span>
    </li>
  </ul>
</section><!-- End /.slideshow -->
<style type="text/css">
#support{
  padding-left: 10px
}
#support li{
  font-size: 16px;
  font-weight: bold;
}
span.support-value{
  color:#FF3000;
}
</style>
<script type="text/javascript">
$(document).ready(function(){
  $('li.page').click(function(){
    var obj = $(this);
    
    obj.parent().find('.page').removeClass('active');
    obj.addClass('active');
    var page = $(this).attr('data-page');
    var city_id = $(this).attr('data-city');
    var object_type = $(this).attr('data-object-type');
    var parent = $(this).attr('data-parent');
    $.ajax({
      url : 'ajax/list.php',
      type : 'POST',
      data : {
        page : page,
        city_id : city_id,
        object_type : object_type
      },
      success : function(data){
        $('#' + parent).html(data);
	$('html, body').animate({
	   scrollTop: $("#" + parent).parent().parent().offset().top
	}, 500);
      }
    });
  });
});
</script>
