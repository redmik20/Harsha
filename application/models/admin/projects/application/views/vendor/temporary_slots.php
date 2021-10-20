<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div>
<div class="my-3 my-md-5">
  <div class="container">
    <div class="row row-cards row-deck my-venues">

      <div class="col-md-12">
       <div class="page-header">
        <h1 class="page-title">
         Edit Temperory Slots
       </h1>
     </div>
     <?php if($this->session->flashdata('success') != "") : ?>
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span class="sr-only">Close</span></button>
                <?=$this->session->flashdata('success');?>
              </div>
            <?php endif; ?>
     <div class="card">
       <div class="col-md-12">
         <div class="p-20">
          <div class="batches">
            <h2 class="title-4 fw-600 pull-left"><i class="fa fa-check" aria-hidden="true"></i>  Available slots</h2>

            <form class="" method="post" action="<?=base_url();?>vendor/home/add_temporary_slot">
              <div class="form-group collg-3 pull-right">
                <div class="row">
                  <input class="dpd1 form-control border datepicker" autocomplete="off" readonly  id="datepickerr" autocomplete="off" required="" data-date-format="dd-mm-yyyy" placeholder="Select date" type="text" required="" name="date" >                                                    
                  <!-- <span class="fa fa-chevron-down theme-color"></span> -->
                    
                </div>
              </div>
              <input type="hidden" name="venue_id" id="venue_id" value="<?=$this->uri->segment(3);?>">
          
          <div class="clearfix"></div>
          <hr />
          <div id="t_slots">
          <?php
          if(!empty($slots))
          {
            ?>
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Time</th>
                  <th scope="col">Capacity</th>
                  <th scope="col">Actual Price</th>
                  <th scope="col">Temporary Price</th>
                  <th scope="col">Edit</th>
                </tr>
              </thead>
              <tbody>
                <?php
                foreach($slots as $slot)
                {
                  ?>
                  <tr>
                    <th scope="row">1</th>
                    <td>10:00am - 2:00pm</td>
                    <td>1000</td>
                    <td>10,000/-</td>
                    <td class="lable">15,000/-</td>
                    <td class="input"><input type="text" class="form-control" placeholder="Update Temporary Price" id="price" name="price" /></td>
                  </tr>
                  <?php
                }
              ?>
              </tbody>
            </table>            
            <?php
          }
          else
          {
            echo "No slots available!";
          }
          ?>          
          </div>
          <div class="form-footer" id="form-footer" style="display: none">
              <button type="submit" class="btn btn-primary btn-block">Submit</button>
            </div>
          </form>
          </div>
          <div class="clearfix"></div>
        </div>  
      </div>

    </div>
  </div>
  <div class="clearfix"></div>

</div>
</div>
</div>
</div>