



<!-- PAGE CONTENT WRAPPER -->

<div class="page-content-wrap">

  <div class="row">

    <div class="col-md-12">

      <?php 

      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');

      echo form_open_multipart('admin/register/update_questions', $attributes); 

      ?>

        <div class="panel panel-default">

          <div class="panel-heading">

            <h2 class="panel-title">View questions</h2>            

          </div>

          <?php if($this->session->flashdata('success') != "") : ?>                

            <div class="alert alert-success" role="alert">

              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

              <?=$this->session->flashdata('success');?>

            </div>

          <?php endif; ?>

          <div class="panel-body">



             <div class="form-group">

              <label class="col-md-3 col-xs-12 control-label">questions </label>

              <div class="col-md-6 col-xs-12" style="top: 8px;">

               <?=$row['0']['question'];?>

              </div>

            </div>       



            <div class="form-group">

              <label class="col-md-3 col-xs-12 control-label">options</label>

              <div class="col-md-6 col-xs-12" style="top: 8px;">

               <?=$row['0']['options'];?>

              </div>

            </div>     

            <div class="form-group">

              <label class="col-md-3 col-xs-12 control-label">questions Answer</label>

              <div class="col-md-6 col-xs-12" style="top: 8px;">

               <?=$row['0']['answer'];?>

              </div>

            </div>     



</div>

