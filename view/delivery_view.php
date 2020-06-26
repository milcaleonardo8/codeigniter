<?php $this->load->view(ADMIN.'include/header'); ?>
    <style>
    table>thead>tr>td:nth-child(1),table>tbody>tr>td:nth-child(1)
    {
      width:7% !important;
    }
    table>thead>tr>td,table>tbody>tr>td
    {
      width:23.25%;
    }
    .row .col-md-6 p , #DetailDelivery table > tbody > tr > td span{text-align: justify;}
    </style>
    <section class="content-header">
        <h1> Product Delivery </h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php $this->load->view(ADMIN.'include/message'); ?>
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Product Delivery</h3>
            </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-3">
                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#AddDelivery">Add Delivery</button>
                </div>
            </div>
        <br>
            <table id="Table" class="table table-responsive table-striped">
                <thead>
                    <tr>
                        <td>Sr. No. </td>
                        <td>Title</td>
                        <td>Description</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if(count($deliveries)){ $i = 0; foreach ($deliveries as $key => $delivery) { $i++; 
                      $active = $delivery['DeliveryId'].",tbldelivery,DeliveryId,".ADMIN."Delivery";
                      $data = base64_encode($active); ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?php
                            if(strlen($delivery['Title']) > 30) { 
                              echo '<span title="'.$delivery['Title'].'">'.substr($delivery['Title'],0,70)."....</span>"; } else {
                                echo $delivery['Title'];
                              }  ?>
                        </td>
                        <td><?php
                            if(strlen($delivery['Description']) > 30) { 
                              echo '<span title="'.$delivery['Description'].'">'.substr($delivery['Description'],0,70)."....</span>"; } else {
                                echo $delivery['Description'];
                              } ?>
                        </td>
                        <td>
                            <a href="javascript:void(0);" class="Edit" data-id="<?= $delivery['DeliveryId'] ?>">
                                <span class="fa fa-edit fa-cwarning"></span>
                            </a>&nbsp;&nbsp;
                            <a href="<?= base_url(ADMIN.'CategorySection/DeleteRecord/'.$data) ?>" class="Delete" onclick="return myconfirm();">
                                <span class="fa fa-remove fa-cdanger"></span>
                            </a>&nbsp;&nbsp;
                            <a href="javascript:void(0);" class="View" data-id="<?= $delivery['DeliveryId'] ?>">
                                <span class="fa fa-eye fa-aqua"></span>
                            </a>
                        </td>
                    </tr>
                <?php } } ?>
                </tbody>
            </table>
        </div> <!-- /.box-body -->
    </div>
      <!-- /.box -->
    <!-- Add Detail -->
    <div id="AddDelivery" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Delivery</h4>
                </div>
                <div class="modal-body">
                    <form role="form" action="<?= base_url(ADMIN.'Delivery/saveprocess') ?>" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" id="Title" name="Title" placeholder="Enter Title">
                                <span id="Title-error" class="text-danger pull-right"></span>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="Description" id="Description" class="form-control" placeholder="Enter Description"></textarea>
                                <span id="Description-error" class="text-danger pull-right"></span>
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
    <!-- Add Detail End-->
    
    <!-- Edit Detail -->
    <div id="EditDelivery" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Delivery</h4>
                </div>
                <div class="modal-body">
                    <form role="form" action="<?= base_url(ADMIN.'Delivery/editprocess') ?>" method="post">
                        <input type="hidden" name="DeliveryId" id="DeliveryId">
                        <div class="box-body">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" id="ETitle" name="ETitle" placeholder="Enter Title">
                                <span id="ETitle-error" class="text-danger pull-right"></span>
                            </div>
                            <div class="form-group">
                                <label>Description</label>
                                <textarea name="EDescription" id="EDescription" class="form-control" placeholder="Enter Description"></textarea>
                                <span id="EDescription-error" class="text-danger pull-right"></span>
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
    <!-- Edit Detail End-->

    <!-- Detail -->
    <div id="DetailDelivery" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Delivery</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-responsive table-striped detail">
                        <tr>
                            <td>
                                <label>Title</label>
                            </td>
                            <td><span id="DTitle"></span></td>
                        </tr>
                        <tr>
                            <td>
                                <label>Description</label>
                            </td>
                            <td><span id="DDescription"></span></td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->
<?php $this->load->view(ADMIN.'include/footer'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    $('#Table').on('click','.Edit',function(){
        var id = $(this).data('id');
        $('#DeliveryId').val(id);
        ajax_desc(id,'ETitle','EDescription','val');
        $('#EditDelivery').modal('show');
    });

    /*View Detail Script Start*/
    $('#Table').on('click','.View',function(){
        var id = $(this).data('id');
        ajax_desc(id,'DTitle','DDescription');
        $('#DetailDelivery').modal('show');
    });
    $('#Add').click(function(event) {
        if(requireandmessage('Title','Title') || requireandmessage('Description','Description')){
            return false;
        }
    });
    $('#Edit').click(function(event) {
      if(requireandmessage('ETitle','ETitle') || requireandmessage('EDescription','EDescription')){
        return false;
      }
    });
    $('#AddDelivery').on('hidden.bs.modal', function () {
        $(this).find("input,textarea,select").val('').end();
    });
  });

  //Function For Fill The Description And Short Description
  function ajax_desc(id,name1,name2,val = 'html') {
    $.ajax({
          type: 'POST', 
          url: baseurl+'Delivery/GetDesc', 
          data: { DId: id }, 
          dataType: 'json',
          success: function (data) {
            console.log(data);
            if(data['status']){
              if(val == 'val'){
                $('#'+name1).val(data['Title']);
                $('#'+name2).val(data['Description']);
              } else {
                $('#'+name1).html(data['Title']);
                $('#'+name2).html(data['Description']);
              }
            }
          }
      });
  }
</script>