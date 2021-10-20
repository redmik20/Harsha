<div class="my-3 my-md-5">
    <div class="container">
      <div class="row">
        <div class="col-12">
        <form action="<?=base_url();?>vendor/home/submit_cancellation_policy" method="post" id="validation" enctype="multipart/form-data" class="card">
            <div class="card-header">
              <h3 class="card-title">Add Cancellation Policy</h3>
            </div>
            <?php if($this->session->flashdata('success') != "") : ?>
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span class="sr-only">Close</span></button>
                <?=$this->session->flashdata('success');?>
              </div>
            <?php endif; ?>
            <div class="card-body">
                <div class="col-md-12">
                <h3><label>Enter Details</label></h3> 
                <div class="row">
                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-label">Select Category</label>
                      <select class="select2 form-control" data-placeholder="Venue Type" name="category_id" id="category_id" required="" onchange="get_policy(this.value)">
                        <option value="">Select Category</option>
                        <?php
                        if(!empty($categories))
                        {
                          foreach($categories as $cat)
                          {
                            ?>
                            <option value="<?=$cat->id;?>"><?=$cat->title;?></option>
                            <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                    </div>
                    <!-- <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-label">Select Venues</label>
                      <select class="select2 form-control" data-placeholder="Venue Type" name="venue_id" id="venue_id" onchange="get_pricings(this.value)" required="">
                        <option value="">Select Venue</option>
                      </select>
                    </div>
                    </div> -->
                  <div class="clearfix"></div>
                  <div class="col-lg-12 row" id="policy">
                  <div class="col-lg-3" id="">
                    <div class="form-group">
                      <label class="form-label">Enter From Day</label>
                      <div class="row">
                        <div class="col-md-12">
                          <input type="text" class="form-control" name="from[]" placeholder="From Day (1)" id="from" required="">
                        </div>                       
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3" id="">
                    <div class="form-group">
                      <label class="form-label">Enter To Day</label>
                      <div class="row">
                        <div class="col-md-12">
                          <input type="number" class="form-control" name="to[]" placeholder="To Day (7)" id="to" required="" min="0">
                        </div>                       
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3" id="">
                    <div class="form-group">
                      <label class="form-label">Cancellation Allowed?</label>
                      <div class="row">
                        <div class="col-md-12">
                          <select id="cancellation_allowed" name="cancellation_allowed[]">
                            <option value="yes">Yes</option>
                            <option value="no">No</option>
                          </select>
                        </div>                       
                      </div>
                    </div>
                  </div>
                  <div class="col-lg-3" id="">
                    <div class="form-group">
                      <label class="form-label">Enter Refund Percentage</label>
                      <div class="row">
                        <div class="col-md-12">
                          <input type="number" class="form-control" name="refund[]" placeholder="Refund Percentage (%)" id="refund" required="" min="0">
                        </div>                    
                      </div>
                    </div>
                  </div>
                  </div>
                  <div class="col-lg-12 mb-2">
                    <a class='btn btn-primary pull-right add_field_button'><i class="fe fe-plus-circle text-white"></i></a>
                    <br /><br />
                  </div>
                </div>
              </div>
            
            </div>
          </div>
          <div class="card-footer text-right">
            <div class="d-flex">
              <!-- <a href="javascript:void(0)" class="btn btn-link">Cancel</a> -->
              <button type="submit" class="btn btn-primary ml-auto">Send data</button>
            </div>
          </div>
        </form>

        <script>           
            function get_policy(category_id)
            {
              $.ajax( {
                  type: 'POST',
                  url: "<?=base_url();?>vendor/home/get_policy",
                  data: {category_id:category_id},
                  beforeSend: function( xhr ) {
                      xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                      $("#wait").css("display", "block");
                  },
                  success: function(data) { //alert(data);exit;
                    //alert(data);
                    $('#policy').html(data);
                    $("#wait").css("display", "none");
                    //location.reload();
                    return false;
                  }
              });
            }
        </script>
      </div>
      </div>
      </div>

  </div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script>
  $(document).ready(function() { //alert();
      $("#validation").validate({
          rules: {
            // simple rule, converted to {required:true}
            venue_name: {
                required : true,
            },
            city_id: {
                required : true,
            },
            area_id: {
                required : true,
            },
            category_id: {
                required : true,
            },
            "event_types[]": {
                required : true,
            },
            venue_name: {
                required : true,
            },
            address: {
                required : true,
            },
            from: {
                required : true,
            },
            price: {
                required : true,
            },
            discount_percentage: {
                required : true,
            },
            description: {
                required : true,
            },
            booking_type: {
                required : true,
            },
            venue_type: {
                required : true,
            },
            "amenities[]": {
                required : true,
            },
            "services[]": {
                required : true,
            },
            contact_number: {
                required : true,
                number:true,
                minlength:10,
                maxlength:10,
            },
            email_id: {
                required : true,
                myEmail:true
            }
          },
          messages:{
            email_id: {
              remote : "Email Id already exists",
            }
          },
          submitHandler: function(form) {
              //$("#btnSubmit").prop('disabled', true);
              form.submit();
          }
        });
  });
  jQuery.validator.addMethod("myEmail", function(value, element) {
    return this.optional( element ) || ( /^[a-z0-9]+([-._][a-z0-9]+)*@([a-z0-9]+(-[a-z0-9]+)*\.)+[a-z]{2,4}$/.test( value ) && /^(?=.{1,64}@.{4,64}$)(?=.{6,100}$).*/.test( value ) );
  }, 'Please enter valid email address.');


    $(document).ready(function() {
      var max_fields      = 8; //maximum input boxes allowed

      var wrapper         = $("#policy"); //Fields wrapper
      var add_button      = $(".add_field_button"); //Add button ID
      
      var html = $("#policy").html();//alert(html);
      var x = 1; //initlal text box count
      $(add_button).click(function(e){ //on add input button click
        //alert(html);
          e.preventDefault();
          if(x < max_fields){ //max input box allowed
              x++; //text box increment
              $(wrapper).append(html); //add input box
          }
      });      
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove(); x--;
      });
  });
</script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyB-7WHSIR_GHt8IeXZFVFSevq1EO8X4aho&sensor=false&libraries=places&language=en-AU"></script>
<script type="text/javascript">
   $(document).ready(function() {
      var max_fields      = 10; //maximum input boxes allowed

      var wrapper         = $("#row"); //Fields wrapper
      var add_button      = $(".add_field_button"); //Add button ID
      
      var html = $("#row").html();//alert(html);
      var x = 1; //initlal text box count
      $(add_button).click(function(e){ //on add input button click
        //alert();
          e.preventDefault();
          if(x < max_fields){ //max input box allowed
              x++; //text box increment
              $(wrapper).append(html); //add input box
          }
      });      
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent('div').remove(); x--;
      });
  });
</script>