<?php $this->load->view(ADMIN.'include/header'); ?>
    <section class="content-header">
        <h1><?= $opr ?> Product</h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <?php $this->load->view(ADMIN.'include/message'); ?>
        <!-- Default box -->
        <div class="box">
            <?php if(isset($edit['CardId'])){ ?>
                <form role="form" action="<?= base_url(ADMIN.'Product/Editprocess') ?>" method="post" enctype="multipart/form-data">

                <input type="hidden" name="CardId" value="<?= $edit['CardId'] ?>">
                <input type="hidden" name="OldImage" value="<?= $edit['Image'] ?>">
            <?php } else { ?>
                <form role="form" action="<?= base_url(ADMIN.'Product/saveprocess') ?>" method="post" enctype="multipart/form-data">
            <?php } ?>
                <div class="box-header with-border">
                <h3 class="box-title">
                    <a href="<?= base_url(ADMIN.'Product') ?>" class="btn btn-info btn-md text-center"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Back To Product</a>
                </h3>
                </div>
                <div class="box-body">
                    <div class="row">
                      <div class="col-lg-6">
                      <div class="form-group">
                          <label for="">Category</label>
                          <select name="CId" id="CId" class="form-control">
                            <option value="">Select Category</option>
                            <?php if(count($categories) > 0){ foreach ($categories as $key => $cate) { ?>
                            <option value="<?= $cate['CateId'] ?>" <?php if(isset($edit['CId']) && $cate['CateId'] == $edit['CId']){ echo 'selected="selected"'; }?>><?= $cate['Name'] ?></option>
                          <?php } } ?>
                           </select>
                            <span id="CId-error" class="text-danger pull-right"></span>
                        </div>
                        <div class="form-group">
                          <label>Sub Category</label>
                          <select name="SubCateId" id="SubCateId" class="form-control">
                            <option value="">Select Sub Category</option>
                           </select>
                            <span id="SubCateId-error" class="text-danger pull-right"></span>
                        </div>
                        <div class="form-group">
                          <label>Title</label>
                          <input type="text" class="form-control" id="Title" name="Title" placeholder="Enter Title" value="<?= isset($edit['Title'])?$edit['Title']:set_value('Title') ?>">
                          <span id="Title-error" class="text-danger pull-right"></span>
                        </div>
                        <div class="form-group">
                          <label>Card Name</label>
                          <input type="text" class="form-control" id="CardName" name="CardName" placeholder="Enter Card Name" value="<?= isset($edit['CardName'])?$edit['CardName']:set_value('CardName') ?>">
                          <span id="CardName-error" class="text-danger pull-right"></span>
                        </div>
                        <div class="form-group">
                          <label>Description</label>
                          <textarea name="Description" id="Description" class="form-control" placeholder="Enter Description"><?= isset($edit['Description'])?$edit['Description']:set_value('Description') ?></textarea>
                          <span id="Description-error" class="text-danger pull-right"></span>
                        </div>
                        
                        <div class="row">
                          <div class="col-xs-9">
                              <div class="form-group">
                                  <label>Image</label>
                                  <input type="file" name="Image" id="Image" class="Image">
                                  <p class="help-block">(Valid File Type: JPEG , PNG).</p>
                                  <span id="Image-error" class="text-danger pull-right"></span>
                              </div>
                          </div>
                          <div class="col-xs-3">
                          <?php $path = isset($edit['Image'])?$edit['Image']:'' ?>
                              <img src="<?= base_url(PRODUCTPATH.$path) ?>" id="PreviewImage" alt="Image" style="height: 100px; width: 100%; border-radius: 10%;"/>
                          </div>
                        </div>
                        <div class="form-group">
                          <label>Image Alt Tag</label>
                          <input type="text" name="ImageAlt" id="ImageAlt" class="form-control" placeholder="Enter Image Alt" value="<?= isset($edit['ImageAlt'])?$edit['ImageAlt']:set_value('ImageAlt') ?>">
                          <span id="ImageAlt-error" class="text-danger pull-right"></span>
                        </div>
                        <div class="form-group">
                          <label>Overview</label>
                          <textarea name="Overview" id="Overview" class="form-control" placeholder="Enter Overview"><?= isset($edit['Overview'])?$edit['Overview']:set_value('Overview') ?></textarea>
                          <span id="Overview-error" class="text-danger pull-right"></span>
                        </div>
                      </div><!-- col-lg-6 -->
                      <div class="col-lg-6">
                        <div class="form-group">
                          <label>Link</label>
                          <input type="text" class="form-control" id="Link" name="Link" placeholder="Enter Link" value="<?= isset($edit['Link'])?$edit['Link']:set_value('Link') ?>">
                          <span id="Link-error" class="text-danger pull-right"></span>
                        </div>
                        <div class="form-group">
                          <label>Pricing Text</label>
                          <textarea name="PricingText" id="PricingText" class="form-control" placeholder="Enter Pricing Text"><?= isset($edit['PricingText'])?$edit['PricingText']:set_value('PricingText') ?></textarea>
                          <span id="PricingText-error" class="text-danger pull-right"></span>
                        </div>
                        <div class="form-group">
                          <label>Sizing Text</label>
                          <textarea name="SizingText" id="SizingText" class="form-control" placeholder="Enter Sizing Text"><?= isset($edit['SizingText'])?$edit['SizingText']:set_value('SizingText') ?></textarea>
                          <span id="SizingText-error" class="text-danger pull-right"></span>
                        </div>
                      </div>
                    </div><!-- row -->
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <button type="submit" id="Add" class="btn btn-primary"><?= $opr ?></button>
                    <a href="<?= base_url(ADMIN.'Product') ?>" id="Cancel" class="btn btn-danger pull-right">Cancel</a>
                </div>
            </form>
            <!-- /.box-footer-->
        </div>
      <!-- /.box -->
<?php $this->load->view(ADMIN.'include/footer'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    <?php if(isset($edit['CardId'])){ ?>
        setTimeout(function(){ 
        $('#CId').trigger('change');
        var id = '<?= $edit['SubCateId'] ?>';
            window.setTimeout(function() {
                $('#SubCateId option[value='+id+']').attr('selected','selected');
        },  1000);
      }, 1000);
    <?php } ?>
    $('#Overview').ckeditor();
    $('#PricingText').ckeditor();
    $('#SizingText').ckeditor();
    $('#Add').click(function(event) {
        if(isemptyselect('CId','Category') || requireandmessage('CardName','Name') || requireandmessage('Title1',' Title 1') || requireandmessage('DescriptionTitle1','DescriptionTitle 1') || requireandmessage('Title2',' Title 2') || requireandmessage('DescriptionTitle2','DescriptionTitle 2') ){
        return false;
        }
    });
    $(".Image").on("change", function (event) {
        var id = $(this).attr("id");
        filename = event.target.files[0].name;
        file = filename.split(".").pop().toLowerCase();
        $("#Preview"+id).fadeIn("fast").attr('src','');
        if(file == "jpg" || file == "png" || file == "jpeg"){
            var tmppath = URL.createObjectURL(event.target.files[0]);
            $("#Preview"+id).fadeIn("fast").attr('src',tmppath);
            $('#'+id+'-error').html('');
        } else {
          $('#'+id+'-error').html("Please Select Correct File Only.!!!");
          $(this).val("");
        }
    });
    $("#CId").change(function(e) {
      var cateid = $(this).val();
      $.ajax({
        type: 'POST', 
        url: baseurl+'Product/getsubcategory', 
        data: { cateid: cateid }, 
        dataType: 'json',
        success: function (data) {
          console.log(data);
          if(data['status']){
              $('#SubCateId').html(data['Description']);
          } else {
            $('#SubCateId').html('<option value="">Select Sub Category</option>');
          }
        }
      });
    });
  });
</script>