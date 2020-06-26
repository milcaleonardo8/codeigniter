<?php $this->load->view(ADMIN.'include/header'); ?>
<style>
table>thead>tr>td:nth-child(1),table>tbody>tr>td:nth-child(1)
{
  width:5% !important;
}
table>thead>tr>td,table>tbody>tr>td
{
  width:19%;
}
.row .col-md-6 p {text-align: justify;}
</style>
    <section class="content-header">
        <h1>Category</h1>
    </section>
    <!-- Main content -->
    <section class="content">
        <?php $this->load->view(ADMIN.'include/message'); ?>
        <!-- Default box -->
        <div class="box">
            <div class="box-header with-border">
                <h3 class="box-title">Category</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-3">
                        <a class="btn btn-success" href="<?= base_url(ADMIN.'Category/add') ?>">Add Category</a>
                    </div>
                </div>
                <br>
                <table id="Table" class="table table-responsive">
                    <thead>
                        <tr>
                            <th>Sr. No.</th>
                            <th>Name</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(count($categories)){ $i = 0; foreach ($categories as $key => $category) { $i++; 
                            $active = $category['CateId'].",tblcategory,CateId,".ADMIN."Category";
                            $data = base64_encode($active);
                        ?>
                        <tr>
                            <td><?= $i ?></td>
                            <td><?php
                                if(strlen($category['Name']) > 30) { 
                                  echo '<span title="'.$category['Name'].'">'.substr($category['Name'],0,70)."....</span>"; } else {
                                    echo $category['Name']; }  ?>
                            </td>
                            <td><?= $category['Title1'] ?></td>
                            <td>
                                <?php
                                    if(strlen($category['DescriptionTitle1']) > 30) { 
                                      echo '<span title="'.strip_tags($category['DescriptionTitle1']).'">'.substr($category['DescriptionTitle1'],0,70)."....</span>"; } else {
                                        echo $category['DescriptionTitle1'];
                                    }  
                                ?>
                            </td>
                            <td>
                                <img src="<?= base_url(CATEIMAGE.$category['Image1']) ?>" alt="No Image Available" height="100" width="200" />
                            </td>
                            <td>
                                <a href="<?= base_url(ADMIN.'Category/add/'.md5($category['CateId'])) ?>" class="Edit" data-id="<?= $category['CateId'] ?>">
                                    <span class="fa fa-edit fa-cwarning"></span>
                                </a>&nbsp;&nbsp;
                                <a href="<?= base_url(ADMIN.'Category/DeleteRecord/'.$data) ?>" class="Delete" onclick="return myconfirm();">
                                    <span class="fa fa-remove fa-cdanger"></span>
                                </a>&nbsp;&nbsp;
                                <a href="javascript:void(0);" class="View" data-id="<?= $category['CateId'] ?>">
                                    <span class="fa fa-info-circle fa-aqua"></span>
                                </a>
                            </td>
                    </tr>
                    <?php } } ?>
                    </tbody>
                </table>
            </div> 
        </div>

    <!-- Detail Category -->
    <div id="DetailCategory" class="modal fade" role="dialog" tabindex="-1">
        <div class="modal-dialog">
        <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Detail Category</h4>
                </div>
                <div class="modal-body" id="AppendDesc"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail Category End -->

    <?php $this->load->view(ADMIN.'include/footer'); ?>

    <script type="text/javascript">
        $(document).ready(function(){
            /*Get description script start*/
            $('#Table').on('click', '.View', function(event) {
                event.preventDefault();
                var id = $(this).data('id');
                $.ajax({
                    type: 'POST', 
                    url: baseurl+'Category/GetDesc', 
                    data: { id: id }, 
                    dataType: 'json',
                    success: function (data) {
                        console.log(data);
                        if(data['status']){
                        $('#AppendDesc').html(data['result']);
                        $('#DetailCategory').modal('show');
                        }
                    }
                });
            });
            /*Get description script End*/
        });
    </script>