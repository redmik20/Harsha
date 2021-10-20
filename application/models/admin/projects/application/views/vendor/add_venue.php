<div class="my-3 my-md-5">
    <div class="container">
      <div class="row">
        <div class="col-12">        
        <form action="<?=base_url();?>vendor/home/submit_venue_details" method="post" id="validation" enctype="multipart/form-data" class="card" onsubmit="return validate()">
            <div class="card-header">
              <h3 class="card-title">Add Venue</h3>
            </div>
            <?php if($this->session->flashdata('success') != "") : ?>
              <div class="alert alert-success" role="alert">
                <button type="button" class="close" data-dismiss="alert"><span class="sr-only">Close</span></button>
                <?=$this->session->flashdata('success');?>
              </div>
            <?php endif; ?>
            <?php echo validation_errors(); ?>            
            <div class="card-body">
                <div class="col-md-12">
              
                 <div class="form-group">
                   <h3><label>Add Venue Image</label></h3> 
                  <i>Best Resolution <b>300x170 </b> , else images will be stretched</i>
                  <!--<div class="custom-file file-upload">
                    <input type="file" class="custom-file-input" id="img1" name="example-file-input-custom">
                    <label class="custom-file-label">Choose file</label>
                     <img id="img1p"  src="#" alt="your image" />
                  </div>-->

                  <div id="image-preview" class="image-preview  alert alert-info">
                  <label for="image-upload" id="image-label">Choose File</label>
                  <input type="file" name="image" id="image-upload" required="" />
                  </div>                
                </div>
                
                
                <hr />
                <h3><label>Enter Details</label></h3> 
                <div class="row">

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-label">Venue Name</label>
                      <input type="text" class="form-control" name="venue_name" id="venue_name" placeholder="Text.." required="">
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-label">Select Venue Type</label>
                      <select class="select2 form-control" data-placeholder="Venue Type" name="category_id" id="category_id" onchange="get_event_types(this.value)" required="">
                        <option value="">Select Venue Type</option>
                        <?php
                        if(!empty($categories))
                        {
                          foreach($categories as $cat)
                          {
                            ?>
                            <option value="<?=$cat->id.'-'.$cat->capacity;?>"><?=$cat->title;?></option>
                            <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group"> 
                      <label class="form-label">Address</label> 
                      <div class="input-icon mb-3">
                        <input type="text" class="form-control address" placeholder="Search for..." name="address" id="address" required="" autocomplete="off">
                        <!-- <span class="input-icon-addon">
                          <i class="fe fe-map"></i>
                        </span> -->
                        <input type="hidden" name="lat" id="lat">
                        <input type="hidden" name="lng" id="lng">
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-12">
                    <div class="row" id="event_typess">
                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="form-label">Select Event Types</label> 
                          <div class="">
                            <select class="select2 form-control" data-placeholder="Select Event Types" multiple id="event_types" name="event_types[]" required="">
                              <option value="">Select Event Types</option>
                            </select>
                          </div>
                        </div>
                      </div>  

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="form-label">Select Amenities</label> 
                          <div class="">
                            <select class="select2 form-control" data-placeholder="Select Amenities" multiple id="amenities" name="amenities[]" required="">
                              <option value="">Select Amenities</option>
                            </select>
                          </div>
                        </div>
                      </div>

                      <div class="col-lg-4">
                        <div class="form-group">
                          <label class="form-label">Select Services</label> 
                          <div class="">
                            <select class="select2 form-control" data-placeholder="Select Services" multiple id="services" name="services[]" required="">
                              <option value="">Select Services</option>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-label">Select City</label>
                      <select class="select2 form-control" data-placeholder="City" name="city_id" id="city_id" onchange="get_areas(this.value)" required="">
                        <option value="">Select City</option>
                        <?php
                        if(!empty($cities))
                        {
                          foreach($cities as $city)
                          {
                            ?>
                            <option value="<?=$city->id;?>"><?=$city->title;?></option>
                            <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-label">Select Area</label>
                      <select class="select2 form-control" data-placeholder="Area" name="area_id" id="area_id" required="">
                        <option value="">Select Area</option>
                        <?php
                        if(!empty($areas))
                        {
                          foreach($areas as $area)
                          {
                            ?>
                            <option value="<?=$area->id;?>"><?=$area->title;?></option>
                            <?php
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>

                  <div class="col-lg-4" id="">
                    <div class="form-group">
                      <label class="form-label">Capacity</label>
                      <div class="row">
                        <div class="col-md-6">
                          <input type="number" class="form-control" name="from" placeholder="From" id="from" required="" min="0">
                        </div>
                        <div class="col-md-6" id="to_div">
                          <input type="number" class="form-control" name="to" id="to" placeholder="To" required="" min="0">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-md-6">
                          <label class="form-label">Price</label>  
                          <input type="number" class="form-control" name="price" id="price" placeholder="Price" required="" min="0">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label">Discount %</label>  
                          <input type="number" class="form-control" name="discount_percentage" id="discount_percentage" placeholder="Discount" required="" min="0">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6">
                    <div class="form-group">
                      <label class="form-label">Description</label>
                      <input type="text" class="form-control" name="description" id="description" placeholder="Text.." required="">
                    </div>
                  </div>

                  <div class="col-lg-6" id="booking_type">
                    <div class="form-group">
                      <div class="form-label">Select your booking type</div>
                      <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="booking_type" id="booking_type" value="delayed" checked>
                          <span class="custom-control-label">Delayed Booking</span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="booking_type" id="booking_type" value="instant">
                          <span class="custom-control-label">Instant Booking</span>
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6" id="venue_type">
                    <div class="form-group">
                      <div class="form-label">Select your venue type</div>
                      <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio custom-control-inline">
                          <input type="checkbox" class="custom-control-input" name="venue_type[]" id="venue_type" value="Indoor" checked>
                          <span class="custom-control-label">Indoor</span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                          <input type="checkbox" class="custom-control-input" name="venue_type[]" id="venue_type" value="Outdoor">
                          <span class="custom-control-label">Outdoor</span>
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6" id="ac_nonac">
                    <div class="form-group">
                      <div class="form-label">Select AC/ Non AC</div>
                      <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="ac" id="ac" value="ac" checked>
                          <span class="custom-control-label">AC</span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="ac" id="ac" value="non_ac">
                          <span class="custom-control-label">Non AC</span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="ac" id="ac" value="both">
                          <span class="custom-control-label">Both</span>
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="col-lg-6" id="veg_nonveg">
                    <div class="form-group">
                      <div class="form-label">Select Veg/ Non Veg</div>
                      <div class="custom-controls-stacked">
                        <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="veg" id="veg" value="veg" checked>
                          <span class="custom-control-label">Veg</span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="veg" id="veg" value="non_veg">
                          <span class="custom-control-label">Non Veg</span>
                        </label>
                        <label class="custom-control custom-radio custom-control-inline">
                          <input type="radio" class="custom-control-input" name="veg" id="veg" value="both">
                          <span class="custom-control-label">Both</span>
                        </label>
                      </div>
                    </div>
                  </div>

                  <div class="clearfix"></div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-label">Contact No</label>
                      <input typ="text" class="form-control" name="contact_number" id="contact_number" placeholder="Contact No" required="" minlength="10" maxlength="10">
                    </div>
                  </div>

                  <div class="col-lg-4">
                    <div class="form-group">
                      <label class="form-label">Email Id</label>
                      <input type="email" class="form-control" name="email_id" id="email_id" placeholder="Email Id" required="">
                    </div>
                  </div>
                  <div class="clearfix"></div>

                  <div class="col-lg-12">
                    <hr /> 
                  </div>

                </div>

              <div id="slots">
                <div class="col"></div>
                <h3><label>Enter Slots</label></h3> 

                <div id="row">
              <div class="row" id="row1" style="margin-bottom: -10px">
              <div class="col-md-4 alert alert-info">
              <label class="form-label">From time</label>
                <div class="row">
                  <div class="col-lg-4">
                    <input type="number" class="form-control" name="start_hour[]" id="start_hour" placeholder="Hour" required="" min="0" max="12">
                  </div>
                  <div class="col-lg-4">
                    <input type="number" class="form-control" name="start_minute[]" id="start_minute" placeholder="Min" required="" min="0" max="59">
                  </div>
                  <div class="col-lg-4">
                   <!-- <input type="text" class="form-control" name="start_type[]" id="start_type" placeholder="am/pm" required=""> -->
                   <select name="start_type[]" id="start_type" required="" class="form-control">
                     <option value="am">am</option>
                     <option value="pm">pm</option>
                   </select>
                  </div>
                  </div>
                  <br />
                  </div>
                  <div class="col-md-4 alert alert-info">
              <label class="form-label">To time</label>
                <div class="row">
                  <div class="col-lg-4">
                    <input type="number" class="form-control" name="end_hour[]" id="end_hour" placeholder="Hour" required="" min="0" max="12">
                  </div>
                  <div class="col-lg-4">
                    <input type="number" class="form-control" name="end_minute[]" id="end_minute" placeholder="Min" required="" min="0" max="59">
                  </div>
                  <div class="col-lg-4">
                   <!-- <input type="text" class="form-control" name="end_type[]" id="end_type" placeholder="am/pm" required=""> -->
                   <select name="end_type[]" id="end_type" required="" class="form-control">
                     <option value="am">am</option>
                     <option value="pm">pm</option>
                   </select>
                  </div>
                  </div>
                  
                  <br />
                  </div>
                    <div class="col-lg-2  alert alert-info">
                    <label class="form-label">Enter Amount</label>
                    <input type="number" class="form-control" name="amount[]" id="amount" placeholder="Rs/-" required="" min="0">
                  </div>
              
                <div class="col-lg-2  alert alert-info slot_capacityy" id="slot_capacityy" style="display: none">
                <label class="form-label">Slot Capacity</label>
                    <input type="number" class="form-control slot_capacity" name="slot_capacity[]" id="slot_capacity" placeholder="Slot Capacity" readonly="" min="1" disabled="" required="">
                  </div>
                  </div>
                  </div>

                  <div class="col-lg-12 mb-2">
                    <a class='btn btn-primary pull-right add_field_button'><i class="fe fe-plus-circle text-white"></i></a>
                    <br /><br />
                  </div>
                  </div>
                 <!-- <div class="col-lg-12  alert alert-info">
                  <label class="form-label">Enter Terms & Condtions</label>
                  <textarea class="form-control" name="example-text-input" placeholder="Terms & Conditions"></textarea>
                  </div> -->
                  <div class="row">
                  <div class="form-group">
                   <h3><label>Add Images</label></h3>
                   <i>Best Resolution <b> 750X425 </b>, else images will be stretched</i>                   
                  <!--<div class="custom-file file-upload">
                    <input type="file" class="custom-file-input" id="img1" name="example-file-input-custom">
                    <label class="custom-file-label">Choose file</label>
                     <img id="img1p"  src="#" alt="your image" />
                  </div>-->

                <div class="row">
                  <div class="col-md-2">
                    <div id="image-preview1" class="image-preview  alert alert-info">
                      <label for="image-upload" id="image-label1">Choose File</label>
                      <input type="file" name="banners[]" class="image-file" id="image-upload1" />
                    </div>
                  </div>
                  <div class="col-md-2">
                   <div id="image-preview2" class="image-preview  alert alert-info">
                      <label for="image-upload" id="image-label2">Choose File</label>
                      <input type="file" name="banners[]" class="image-file" id="image-upload2" />
                    </div>
                  </div>

                  <div class="col-md-2">
                   <div id="image-preview3" class="image-preview  alert alert-info">
                      <label for="image-upload" id="image-label3">Choose File</label>
                      <input type="file" name="banners[]" class="image-file" id="image-upload3" />
                    </div>
                  </div>
                  <div class="col-md-2">
                   <div id="image-preview4" class="image-preview  alert alert-info">
                      <label for="image-upload" id="image-label4">Choose File</label>
                      <input type="file" name="banners[]" class="image-file" id="image-upload4" />
                    </div>
                  </div>

                  <div class="col-md-2">
                   <div id="image-preview5" class="image-preview  alert alert-info">
                      <label for="image-upload" id="image-label5">Choose File</label>
                      <input type="file" name="banners[]" class="image-file" id="image-upload5" />
                    </div>
                  </div>
                  <div class="col-md-2">
                   <div id="image-preview6" class="image-preview  alert alert-info">
                      <label for="image-upload" id="image-label6">Choose File</label>
                      <input type="file" name="banners[]" class="image-file" id="image-upload6" />
                    </div>
                  </div>

                  </div>
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
            require(['jquery', 'selectize'], function ($, selectize) {
                $(document).ready(function () {
                    $('#input-tags').selectize({
                        delimiter: ',',
                        persist: false,
                        create: function (input) {
                            return {
                                value: input,
                                text: input
                            }
                        }
                    });

                    $('#select-beast').selectize({});

                    $('#select-users').selectize({
                        render: {
                            option: function (data, escape) {
                                return '<div>' +
                                  '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                                  '<span class="title">' + escape(data.text) + '</span>' +
                                  '</div>';
                            },
                            item: function (data, escape) {
                                return '<div>' +
                                  '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                                  escape(data.text) +
                                  '</div>';
                            }
                        }
                    });

                    $('#select-countries').selectize({
                        render: {
                            option: function (data, escape) {
                                return '<div>' +
                                  '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                                  '<span class="title">' + escape(data.text) + '</span>' +
                                  '</div>';
                            },
                            item: function (data, escape) {
                                return '<div>' +
                                  '<span class="image"><img src="' + data.image + '" alt=""></span>' +
                                  escape(data.text) +
                                  '</div>';
                            }
                        }
                    });
                });
            });

            function get_event_types(category_id)
            {
              //alert(category_id);
              var index = category_id.split('-');
              var category_id = index[0];
              var capacity = index[1];
              if(capacity === "Yes")
              {
                $('.slot_capacity').attr("readonly", false);
                $('.slot_capacity').val('');
                $('#from').attr("placeholder", "Capacity");
                $('#to_div').hide();
              }
              else
              {
                $('.slot_capacity').attr("readonly", true);
                $('.slot_capacity').val('0');
                $('#to_div').show();
                $('#from').attr("placeholder", "From");
              }
              $.ajax( {
                  type: 'POST',
                  url: "<?=base_url();?>vendor/home/get_event_types",
                  data: {category_id:category_id, type:'events'},
                  beforeSend: function( xhr ) {
                      xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                      $("#wait").css("display", "block");
                  },
                  success: function(data) { //alert(data);exit;
                      //alert(data);
                      $('#event_types').html(data);   
                      $("#wait").css("display", "none");
                      //location.reload();
                      return false;
                  }
              });

              $.ajax( {
                  type: 'POST',
                  url: "<?=base_url();?>vendor/home/get_event_types",
                  data: {category_id:category_id, type:'amenities'},
                  beforeSend: function( xhr ) {
                      xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                      $("#wait").css("display", "block");
                  },
                  success: function(data) { //alert(data);exit;
                      //alert(data);
                      $('#amenities').html(data);   
                      $("#wait").css("display", "none");
                      //location.reload();
                      return false;
                  }
              });

              $.ajax( {
                  type: 'POST',
                  url: "<?=base_url();?>vendor/home/get_event_types",
                  data: {category_id:category_id, type:'services'},
                  beforeSend: function( xhr ) {
                      xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                      $("#wait").css("display", "block");
                  },
                  success: function(data) { //alert(data);exit;
                      //alert(data);
                      $('#services').html(data);   
                      $("#wait").css("display", "none");
                      //location.reload();
                      return false;
                  }
              });

              if(category_id == 4)
              {
                $('#booking_type').show();
                $('#venue_type').show();
                $('#ac_nonac').show();
                $('#veg_nonveg').show();
                $('#slots').show();
                $('.slot_capacityy').hide();
                $('.slot_capacity').attr('readonly', true);
                $('.slot_capacity').attr('disabled', true);
              }
              else if(category_id == 5)
              {
                $('#booking_type').show();
                $('#venue_type').show();
                $('#ac_nonac').show();
                $('#veg_nonveg').show();
                $('#slots').show();
                $('.slot_capacityy').show();
                $('.slot_capacity').attr('readonly', false);
                $('.slot_capacity').attr('disabled', false);
              }
              else if(category_id == 6)
              {
                $('#booking_type').show();
                $('#venue_type').show();
                $('#ac_nonac').hide();
                $('#veg_nonveg').hide();
                $('#slots').show();
                $('.slot_capacityy').show();
                $('.slot_capacity').attr('readonly', false);
                $('.slot_capacity').attr('disabled', false);
              }
              else if(category_id == 7)
              {
                $('#booking_type').show();
                $('#venue_type').show();
                $('#ac_nonac').hide();
                $('#veg_nonveg').hide();
                $('#slots').hide();
                $('.slot_capacityy').hide();
                $('.slot_capacity').attr('readonly', true);
                $('.slot_capacity').attr('disabled', true);
              }
              else if(category_id == 8)
              {
                $('#booking_type').show();
                $('#venue_type').show();
                $('#ac_nonac').hide();
                $('#veg_nonveg').hide();
                $('#slots').hide();
                $('.slot_capacityy').hide();
                $('.slot_capacity').attr('readonly', true);
                $('.slot_capacity').attr('disabled', true);
              }
              else if(category_id == 9)
              {
                $('#booking_type').show();
                $('#venue_type').show();
                $('#ac_nonac').show();
                $('#veg_nonveg').hide();
                $('#slots').show();
                $('.slot_capacityy').hide();
                $('.slot_capacity').attr('readonly', true);
                $('.slot_capacity').attr('disabled', true);
              }
              else if(category_id == 10)
              {
                $('#booking_type').show();
                $('#venue_type').hide();
                $('#ac_nonac').show();
                $('#veg_nonveg').hide();
                $('#slots').show();
                $('.slot_capacityy').hide();
                $('.slot_capacity').attr('readonly', true);
                $('.slot_capacity').attr('disabled', true);
              }
              else
              {
                $('#booking_type').show();
                $('#venue_type').show();
                $('#ac_nonac').show();
                $('#veg_nonveg').show();
                $('#slots').show();
                $('.slot_capacityy').hide();
                $('.slot_capacity').attr('readonly', true);
                $('.slot_capacity').attr('disabled', true);
              }

            }

            function get_areas(city_id)
            {              
              $.ajax( {
                  type: 'POST',
                  url: "<?=base_url();?>vendor/home/get_areas",
                  data: {city_id:city_id},
                  beforeSend: function( xhr ) {
                      xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
                      $("#wait").css("display", "block");
                  },
                  success: function(data) { //alert(data);exit;
                      //alert(data);
                      $('#area_id').html(data);   
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
            image: {
                required : true,
            },
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
            to: {
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
            // banners: {
            //     required : true,
            // },
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

      var wrapper         = $("#row"); //Fields wrapper
      var add_button      = $(".add_field_button"); //Add button ID
      
      var html = '<div class="row" id="row1" style="margin-bottom: -10px"><div class="col-md-4 alert alert-info"><label class="form-label">From time</label><div class="row"><div class="col-lg-4"><input type="number" class="form-control" name="start_hour[]" id="start_hour" placeholder="Hour" required="" min="0" max="12"></div><div class="col-lg-4"><input type="number" class="form-control" name="start_minute[]" id="start_minute" placeholder="Min" required="" min="0" max="59"></div><div class="col-lg-4"><select name="start_type[]" id="start_type" required="" class="form-control"><option value="am">am</option><option value="pm">pm</option></select></div></div><br /></div><div class="col-md-4 alert alert-info"><label class="form-label">To time</label><div class="row"><div class="col-lg-4"><input type="number" class="form-control" name="end_hour[]" id="end_hour" placeholder="Hour" required="" min="0" max="12"></div><div class="col-lg-4"><input type="number" class="form-control" name="end_minute[]" id="end_minute" placeholder="Min" required="" min="0" max="59"></div><div class="col-lg-4"><select name="end_type[]" id="end_type" required="" class="form-control"><option value="am">am</option><option value="pm">pm</option></select></div></div><br /></div><div class="col-lg-2  alert alert-info"><label class="form-label">Enter Amount</label><input type="number" class="form-control" name="amount[]" id="amount" placeholder="Rs/-" required="" min="0"></div><div class="col-lg-2  alert alert-info slot_capacityy" id="slot_capacityy"><label class="form-label">Slot Capacity</label><input type="number" class="form-control slot_capacity" name="slot_capacity[]" id="slot_capacity" placeholder="Slot Capacity" readonly="" min="1" disabled="" required=""></div></div>';//alert(html);
      var x = 1; //initlal text box count
      $(add_button).click(function(e){ //on add input button click
        //alert();          

          e.preventDefault();
          if(x < max_fields){ //max input box allowed
              x++; //text box increment
              $(wrapper).append(html+'<div class="col-lg-12 mb-2"><a class="pull-right remove_field"><i class="fe fe-minus-circle text-red"></i></a><br></div>'); //add input box
          }
          var cat_id = $( "#category_id option:selected" ).val();
          var res = cat_id.split("-");//alert(res[0]);
          if(res[0] == 5 || res[0] == 6)
          {
            $('.slot_capacityy').show();
            $('.slot_capacity').attr('readonly', false);
            $('.slot_capacity').attr('disabled', false);
          }
          else
          {
            $('.slot_capacityy').hide();
            $('.slot_capacity').attr('readonly', true);
            $('.slot_capacity').attr('disabled', true);
          }
      });      
      $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
          e.preventDefault(); $(this).parent().prev('div #row1').remove(); $(this).parent().remove(); x--;
      });
  });

    function validate(){

  valid = true;

     if($(".image-file").val() == ''){
         // your validation error action
        alert('Choose atleast one bottom image!');
        return false;

     }
     else if($("#lat").val() == '')
     {
        alert('Auto detect the address!');
        return false;
     }

    return valid //true or false
}
$("#from").keyup(function(){
  var from = $(this).val();
  $("#to").val('');
    $("#to").attr({
             "min" : from
          });
});
</script>
<script type="text/javascript" src="https://maps.google.com/maps/api/js?key=AIzaSyAfCn9TmThyShrH92gcEiu4ytQJrhPe0kc&sensor=false&libraries=places&language=en-AU"></script>
<script type="text/javascript">
   function initialize() {
       var input = document.getElementById('address');
       var autocomplete = new google.maps.places.Autocomplete(input);
       google.maps.event.addListener(autocomplete, 'place_changed', function () {
           var place = autocomplete.getPlace();
           var lat = place.geometry.location.lat();
           var long = place.geometry.location.lng()
          
           //alert('latitude'+' '+lat+','+ 'longitude'+' '+long);
           document.getElementById('lat').value = place.geometry.location.lat();
           document.getElementById('lng').value = place.geometry.location.lng();
           //alert("This function is working!");
           //alert(place.name);
          // alert(place.address_components[0].long_name);
       });
   }
   google.maps.event.addDomListener(window, 'load', initialize); 
 </script>
 <style type="text/css">
   .image-preview label.error{
    font-size: 15px !important;
    bottom: -100px;
    border: none;
    border-radius: 0px;
    background: none;
    color: #f00;
    text-transform: none;
   }
   .remove_field
   {
    cursor: pointer;
   }
 </style>