<?php 
if(isset($_GET['page_id'])){
    $page_id = (int) $_GET['page_id'];
    require_once "model/Page.php";
    $model = new Page;
    $detail = $model->getDetailPage($page_id);
}
require_once "model/Tinh.php";

$modelTinh = new Tinh;
$arrHot = $modelTinh->getListTinh(-1,'',1,0, 20);
?>

<script type="text/javascript" src="static/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="static/ckfinder/ckfinder.js"></script>
<script type="text/javascript" src="static/js/ajaxupload.js"></script>
<script type="text/javascript">
function BrowseServer( startupPath, functionData ){    
    var finder = new CKFinder();
    finder.basePath = 'ckfinder/'; //Đường path nơi đặt ckfinder
    finder.startupPath = startupPath; //Đường path hiện sẵn cho user chọn file
    finder.selectActionFunction = SetFileField; // hàm sẽ được gọi khi 1 file được chọn
    finder.selectActionData = functionData; //id của text field cần hiện địa chỉ hình
    //finder.selectThumbnailActionFunction = ShowThumbnails; //hàm sẽ được gọi khi 1 file thumnail được chọn    
    finder.popup(); // Bật cửa sổ CKFinder
} //BrowseServer

function SetFileField( fileUrl, data ){
    document.getElementById( data["selectActionData"] ).value = fileUrl;
    $('#hinh_dai_dien').attr('src','../' + fileUrl).show();
}
</script>
<div class="row">
    <div class="col-md-8">
        <form method="post" action="controller/Page.php">            
        <!-- Custom Tabs -->
        <button class="btn btn-primary btn-sm">Danh sách</button>
        <div style="clear:both;margin-bottom:10px"></div>
         <div class="box-header">
                <h3 class="box-title"><?php echo ($page_id > 0) ? "Cập nhật" : "Tạo mới" ?> trang</h3>
                <?php if($page_id> 0){ ?>
                <input type="hidden" value="<?php echo $page_id; ?>" name="page_id" />
                <?php } ?>
            </div><!-- /.box-header -->
        <div class="nav-tabs-custom">
            
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#tab_1">
                    <img src="<?php echo STATIC_URL?>img/vi.png"/>
                </a></li>
                <li class=""><a data-toggle="tab" href="#tab_2">
                    <img src="<?php echo STATIC_URL?>img/uk_.png"/>
                </a></li>              
                <li class="pull-right"><a class="text-muted" href="#"><i class="fa fa-gear"></i></a></li>
            </ul>
            <div class="tab-content">
                <div id="tab_1" class="tab-pane active">
                    <div class="form-group">
                        <label>Tiêu đề <span class="required"> ( * ) </span></label>
                        <input type="text" name="page_title_vi" class="form-control required" value="<?php echo isset($detail['page_title_vi'])  ? $detail['page_title_vi'] : "" ?>"/>
                    </div>                   
                    <div class="form-group">

                        <label>Nội dung <span class="required"> ( * ) </span></label>                        

                        <textarea rows="5" id="content_vi" class="form-control" name="content_vi"><?php if(isset($detail['content_vi'])) echo $detail['content_vi']; ?></textarea>

                    </div> 
                </div><!-- /.tab-pane -->
                <div id="tab_2" class="tab-pane">
                    <div class="form-group">
                        <label>Title <span class="required"> ( * ) </span></label>
                        <input type="text" name="page_title_en" class="form-control required" value="<?php echo isset($detail['page_title_en'])  ? $detail['page_title_en'] : "" ?>">
                    </div>
                    <div class="form-group">

                        <label>Content <span class="required"> ( * ) </span></label>                        

                        <textarea rows="5" id="content_en" class="form-control" name="content_en"><?php if(isset($detail['content_en'])) echo $detail['content_en']; ?></textarea>

                    </div>                     
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
            <div class="button">
                <div class="form-group">
                    <label>Điểm đến HOT</label>
                    <select class="form-control" name="tinh_id" id="tinh_id">

                        <option value="0">---chọn---</option>
                        <?php foreach($arrHot['data'] as $hot){ ?>
                        <option value="<?php echo $hot['tinh_id']; ?>" <?php echo ($detail['tinh_id']==$hot['tinh_id']) ? "selected" : ""; ?>><?php echo $hot['tinh_name_vi']; ?></option>
                        <?php } ?>                        

                    </select>
                </div>                
            </div>
            <div class="button">
                <button class="btn btn-primary btnSave" type="submit">Save</button>
                <button class="btn btn-primary" type="reset">Cancel</button>
            </div>        
        </div><!-- nav-tabs-custom -->
    </form>
    </div><!-- /.col --> 
</div>
<script type="text/javascript">
var editor = CKEDITOR.replace( 'content_vi',{
    uiColor : '#9AB8F3',
    language:'vi',
    height:400,
    skin:'office2003',
    filebrowserImageBrowseUrl : 'static/ckfinder/ckfinder.html?Type=Images',
    filebrowserFlashBrowseUrl : 'static/ckfinder/ckfinder.html?Type=Flash',
    filebrowserImageUploadUrl : 'static/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'static/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                
    toolbar:[
    ['Source','-','Save','NewPage','Preview','-','Templates'],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize', 'ShowBlocks','-','About']
    ]
});   
var editor2 = CKEDITOR.replace( 'content_en',{
    uiColor : '#9AB8F3',
    language:'vi',
    height:400,
    skin:'office2003',
    filebrowserImageBrowseUrl : 'static/ckfinder/ckfinder.html?Type=Images',
    filebrowserFlashBrowseUrl : 'static/ckfinder/ckfinder.html?Type=Flash',
    filebrowserImageUploadUrl : 'static/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
    filebrowserFlashUploadUrl : 'static/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                
    toolbar:[
    ['Source','-','Save','NewPage','Preview','-','Templates'],
    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],
    ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField'],
    ['Bold','Italic','Underline','Strike','-','Subscript','Superscript'],
    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote','CreateDiv'],
    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
    ['Link','Unlink','Anchor'],
    ['Image','Flash','Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
    ['Styles','Format','Font','FontSize'],
    ['TextColor','BGColor'],
    ['Maximize', 'ShowBlocks','-','About']
    ]
});   
</script>