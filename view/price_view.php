<?php $this->load->view(ADMIN.'include/header'); ?>
<style>
.table  { margin-top: 20%; }
.row .col-md-6 p {text-align: justify;}
</style>
    <section class="content-header">
      <h1> Price Listing Page </h1>
    </section>
    <!-- Main content -->
    <section class="content">
    <?php $this->load->view(ADMIN.'include/message'); ?>
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Price Listing Page</h3>
        </div>
        <div class="box-body">
        <div class="row">
          <div class="col-lg-2">
             <a href="<?= base_url(ADMIN.'Service') ?>" class="btn btn-info">Service</a>
          </div>
          <div class="col-lg-2">
             <!-- <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AddPrice">Add Price</button> -->
          </div>
        </div><br>
        <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#All">All</a></li>
          <li><a data-toggle="tab" href="#Category">Category Wise</a></li>
        </ul>
        <div class="tab-content">
          <div id="All" class="tab-pane fade in active">
            <h3>All Listing</h3>
             <table class="table table-responsive table-striped Table">
              <thead>
                <tr>
                  <td>Sr. No. </td>
                  <td>Service</td>
                  <td>Quantity</td>
                  <td>Price</td>
                  <td>Category</td>
                </tr>
                </thead>
                <tbody>
                <?php if(count($prices)){ $i = 0; foreach ($prices as $key => $price) { $i++; 
                  $active = $price['PriceId'].",tblprice,PriceId,".ADMIN."Price";
                  $data = base64_encode($active);
                  ?>
                  <tr>
                    <td style="width:10%;"><?= $i ?></td>
                    <td style="width:20%;"><?php
                    if(strlen($price['ServiceName']) > 30) { 
                      echo '<span title="'.$price['ServiceName'].'">'.substr($price['ServiceName'],0,70)."....</span>"; } else {
                        echo $price['ServiceName'];
                      }  ?></td>
                    <td  style="width:15%;"><?= $price['Quantity'] ?></td>
                    <td  style="width:15%;"><?= $price['Price'] ?></td> 
                    <td  style="width:40%;"><?php if($price['SubCateId'] != '0' && $price['SubCateId'] != ''){ echo $this->common->get_one_value('tblsubcategory',array('CateId'=>$price['SubCateId']),'Name').'('.$price['CategoryName'].')'; } else { echo $price['CategoryName']; }?></td>
                </tr>
                <?php } } ?>
                </tbody>
              </table>
          </div>
          <div id="Category" class="tab-pane fade">
                <h3>Category Wise Listing</h3>
                <table class="table table-responsive table-striped" id="Table1">
                    <thead>
                        <tr>
                            <td>Sr. No. </td>
                            <td>Name</td>
                            <td>Slug</td>
                            <td>View</td>
                        </tr>
                    </thead>
                <tbody>
                    <?php if(count($categories)){ $i = 0; foreach ($categories as $key => $cate) { $i++; 
                        $subs = $this->common->get_all_record('tblsubcategory',array('MainCateId'=>$cate['CateId']));
                        if(count($subs) > 0){
                          $j = $i;
                          foreach ($subs as $sub) { 
                            echo '<tr><td>'.$j.'</td><td>'.$sub['Name'].'('.$cate['Name'].')</td><td>'.$sub['Slug'].'</td><td><a href="'.base_url(ADMIN.'Price/view_category_sub/'.md5($sub['CateId'])).'" title="'.$sub['Name'].'" class="btn btn-info" >Click To View</a></td></tr>';
                            $j++;
                          }
                      } else { ?>
                  <tr>
                    <td><?= $i ?></td>
                    <td><?= $cate['Name'] ?></td>
                    <td><?= $cate['Slug'] ?></td>
                    <td><a href="<?= base_url(ADMIN.'Price/view_category/'.md5($cate['CateId'])) ?>" title="<?= $cate['Name'] ?>" class="btn btn-info" >Click To View</a></td>
                  </tr>
                <?php  } } }//if category ?>
                </tbody>
                </table>
          </div>
        </div><!-- tab-content -->
        </div><!-- /.box-body -->
      </div><!-- /.box -->
    
    <!-- Add Price modal -->
    <div id="AddPrice" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Price</h4> -->
                </div>
                <div class="modal-body">
                    <form role="form" action="<?= base_url(ADMIN.'Price/saveprocess') ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="Category" id="Category" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php if(count($categories) > 0){ foreach ($categories as $key => $category) { ?>
                                        <option value="<?= $category['CateId'] ?>">
                                            <?= $category['Name'] ?>
                                        </option>
                                        <?php } } ?>
                                </select>
                                <span id="Category-error" class="text-danger pull-right"></span>
                            </div>
                            <div class="form-group">
                                <label>Service</label>
                                <select name="SId" id="SId" class="form-control">
                                    <option value="">Select Service</option>

                                </select>
                                <span id="SId-error" class="text-danger pull-right"></span>
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" name="Quantity" id="Quantity" class="form-control" placeholder="Enter Quantity">
                                <span id="Quantity-error" class="text-danger pull-right"></span>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" name="Price" id="Price" class="form-control" placeholder="Enter Price">
                                <span id="Price-error" class="text-danger pull-right"></span>
                            </div>
                        </div>
                        <button type="submit" id="Add" class="btn btn-primary">Add</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Price modal End -->

    <!-- Edit Price modal -->
    <div id="EditPrice" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Price</h4>
                </div>
                <div class="modal-body">
                    <form role="form" action="<?= base_url(ADMIN.'Price/editprocess') ?>" method="post">
                        <input type="hidden" name="PriceId" id="PriceId">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Category</label>
                                <select name="ECategory" id="ECategory" class="form-control">
                                    <option value="">Select Category</option>
                                    <?php if(count($categories) > 0){ foreach ($categories as $key => $category) { ?>
                                        <option value="<?= $category['CateId'] ?>">
                                            <?= $category['Name'] ?>
                                        </option>
                                        <?php } } ?>
                                </select>
                                <span id="ECategory-error" class="text-danger pull-right"></span>
                            </div>
                            <div class="form-group">
                                <label>Service</label>
                                <select name="ESId" id="ESId" class="form-control">
                                    <option value="">Select Service</option>
                                </select>
                                <span id="ESId-error" class="text-danger pull-right"></span>
                            </div>
                            <div class="form-group">
                                <label>Quantity</label>
                                <input type="text" name="EQuantity" id="EQuantity" class="form-control" placeholder="Enter Quantity" />
                                <span id="EQuantity-error" class="text-danger pull-right"></span>
                            </div>
                            <div class="form-group">
                                <label>Price</label>
                                <input type="text" name="EPrice" id="EPrice" class="form-control" placeholder="Enter Price" />
                                <span id="EPrice-error" class="text-danger pull-right"></span>
                            </div>
                        </div>
                        <button type="submit" id="Edit" class="btn btn-primary">Edit</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!-- Edit Price modal End-->


<?php $this->load->view(ADMIN.'include/footer'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('.Table').DataTable();
    $('#Table1').DataTable({
      "bAutoWidth": false, 
      "aoColumns": [
          { "sWidth": "10%" },
          { "sWidth": "20%" },
          { "sWidth": "30%" },
          { "sWidth": "40%"}
        ]
    });
   
    $('[data-toggle="tooltip"]').tooltip();
    $('.Table').on('click','.Edit',function(){
        var id = $(this).data('id');
        $('#PriceId').val(id);
        $('#ECategory').val($('#CategoryId'+id).val());
        $('#ECategory').trigger('change');
        window.setTimeout(function() {
            $('#ESId option[value='+$('#SId'+id).val()+']').attr('selected','selected');
        }, 2000);
      
        $('#EQuantity').val($('#Quantity'+id).val());
        $('#EPrice').val($('#Price'+id).val());
        $('#EditPrice').modal('show');
    });

    /*Fetch Dategory*/
    $('#Category,#ECategory').change(function(e) {
        e.preventDefault();
        var id = $(this).val();
        $.ajax({
            type: 'POST', 
            url: baseurl+'Price/GetCate', 
            data: { id: id }, 
            dataType: 'json',
            success: function (data) {
            if(data['status']){
                $('#SId').html(data['result']);
                $('#ESId').html(data['result']);
            }
          }
      });
    });
    /*Fetch Dategory End*/
    
    $('#Add').click(function(event) {
        if(isemptyselect('SId','SId') || requireandmessage('Quantity','Quantity') || requireandmessage('Price','Price')){
            return false;
        }
    });
    $('#Edit').click(function(event) {
        if(isemptyselect('ESId','SId') || requireandmessage('EQuantity','Quantity') || requireandmessage('EPrice','Price')){
            return false;
        }
    });
    $('#AddPrice,#EditPrice').on('hidden.bs.modal', function () {
        $(this).find("input,textarea,select").val('').end();
    });
  });
</script>