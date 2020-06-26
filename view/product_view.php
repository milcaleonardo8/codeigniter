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
      <h1> Product </h1>
    </section>
    <!-- Main content -->
    <section class="content">
    <?php $this->load->view(ADMIN.'include/message'); ?>
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Product</h3>
        </div>
        <div class="box-body">
        <div class="row">
          <div class="col-lg-3">
             <a class="btn btn-success" href="<?= base_url(ADMIN.'Product/add') ?>">Add Product</a>
          </div>
        </div><br >
        <table id="Table" class="table table-responsive">
          <thead>
            <tr>
              <th>Sr. No.</th>
              <th>Name</th>
              <th>Description</th>
              <th>Category</th>
              <th>Image</th>
              <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if(count($products)){ $i = 0; foreach ($products as $key => $product) { $i++; 
              $active =$product['CardId'].",tblcard,CardId,".ADMIN."Product";
              $data = base64_encode($active);
              ?>
              <tr>
                <td><?= $i ?></td>
                <td><?php
                if(strlen($product['CardName']) > 30) { 
                  echo '<span title="'.$product['CardName'].'">'.substr($product['CardName'],0,70)."....</span>"; } else {
                    echo $product['CardName']; }  ?></td>
                <td><?php
                if(strlen($product['Description']) > 30) { 
                  echo '<span title="'.$product['Description'].'">'.substr($product['Description'],0,70)."....</span>"; } else {
                    echo $product['Description'];
                }  ?></td>
                <td><?= $product['CateName'] ?></td>
                <td><img src="<?= base_url(PRODUCTPATH.$product['Image']) ?>" alt="No Image Available" height="100" width="200" /></td>
                <td>
                <a href="<?= base_url(ADMIN.'Product/add/'.md5($product['CardId'])) ?>" class="Edit" data-id="<?= $product['CardId'] ?>"><span class="fa fa-edit fa-cwarning"></span></a>&nbsp;&nbsp;
                <a href="<?= base_url(ADMIN.'Product/DeleteProduct/'.$data) ?>" class="Delete" onclick="return myconfirm();"><span class="fa fa-remove fa-cdanger"></span></a>&nbsp;&nbsp;
                <a href="<?= base_url(ADMIN.'Product/view/'.md5($product['CardId'])) ?>" class="View" ><span class="fa fa-info-circle fa-aqua"></span></a>
                </td>
            </tr>
            <?php } } ?>
            </tbody>
          </table>
        </div><!-- /.box-body -->
      </div>
      <!-- /.box -->
<?php $this->load->view(ADMIN.'include/footer'); ?>
<script type="text/javascript">
  $(document).ready(function(){
    
  });
</script>