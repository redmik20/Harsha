<footer class="footer">
        <div class="container">
          <div class="row align-items-center flex-row-reverse">
            <div class="col-auto ml-lg-auto">
              <!-- <div class="row align-items-center">
                <div class="col-auto">
                  <ul class="list-inline list-inline-dots mb-0">
                    <li class="list-inline-item"><a href="#">Terms & Conditions</a></li>
                    <li class="list-inline-item"><a href="#">Privacy Poicy</a></li>
                  </ul>
                </div>
                <div class="col-auto">
                  <a href="#" class="btn btn-outline-primary btn-sm"><i class="fe fe-phone"></i> Contact Us</a>
                </div>
              </div> -->
            </div>
            <div class="col-12 col-lg-auto mt-3 mt-lg-0 text-center">
              Copyright © 2018 | Smart Venue All rights reserved.
            </div>
          </div>
        </div>
      </footer>
    </div>

 <!-- <script src="<?=base_url();?>assets/vendor/assets/plugins/maps-google/plugin.js"></script>
    <!-- Input Mask Plugin -->
    <!-- <script src="<?=base_url();?>assets/vendor/assets/plugins/input-mask/plugin.js"></script> -->
    <!-- <script src="<?=base_url();?>assets/js/jquery-3.0.0.min.js"></script> -->
    <script src="<?=base_url();?>assets/js/jquery.validate.min.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    
        
  <!--------------- Multy select dropdown ---------------->
    <!-- <script src="<?=base_url();?>assets/vendor/assets/js/vendors/jquery-3.2.1.min.js" type="text/javascript"></script> -->    
         
    <script>
        requirejs.config({
            baseUrl: '.'
        });
    </script>
    <script type="text/javascript">
      $(document).ready(function () {

      $('.table-responsive .item-action.dropdown').parent().addClass("navbar");
      $.uploadPreview({
      input_field: "#image-upload",
      preview_box: "#image-preview",
      label_field: "#image-label"
      });
      });
    </script>

      <!--<script>
        $( function() {
        $( ".datepicker" ).datepicker();
        } );
      </script>-->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

      <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
    <script src="<?=base_url();?>assets/vendor/assets/js/dashboard.js"></script>

    <script src="<?=base_url();?>assets/vendor/assets/plugins/charts-c3/plugin.js"></script>

    <!-- Google Maps Plugin -->
    <script src="<?=base_url();?>assets/vendor/assets/plugins/input-mask/plugin.js"></script>  
    <!--------------- preview uploaded image -------------->
    <script src="http://opoloo.github.io/jquery_upload_preview/assets/js/jquery.uploadPreview.js"></script>

         <style>
         .close-preview
         {
             position:absolute;
             z-index:9999;
             top:10px;
             right:10px;
             padding:2px 7px;
             border-radius:50%;
             background:rgba(255,255,255,.7 );
             color:#444;
             
             }
         </style>
    <script>
        requirejs.config({
            baseUrl: '.'
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            $(".close-preview").click(function () {
                //alert();
                //$(".image-file").attr("src", "../assets/images/hall.jpg");
            });

            $.uploadPreview({
                input_field: "#image-upload",
                preview_box: "#image-preview",
                label_field: "#image-label"
            });
            $.uploadPreview({
                input_field: "#image-upload1",
                preview_box: "#image-preview1",
                label_field: "#image-label1"
            });
            $.uploadPreview({
                input_field: "#image-upload2",
                preview_box: "#image-preview2",
                label_field: "#image-label2"
            });
            $.uploadPreview({
                input_field: "#image-upload3",
                preview_box: "#image-preview3",
                label_field: "#image-label3"
            });
            $.uploadPreview({
                input_field: "#image-upload4",
                preview_box: "#image-preview4",
                label_field: "#image-label4"
            });
            $.uploadPreview({
                input_field: "#image-upload5",
                preview_box: "#image-preview5",
                label_field: "#image-label5"
            });
            $.uploadPreview({
                input_field: "#image-upload6",
                preview_box: "#image-preview6",
                label_field: "#image-label6"
            });
            $.uploadPreview({
                input_field: "#image-upload7",
                preview_box: "#image-preview7",
                label_field: "#image-label7"
            });
            $.uploadPreview({
                input_field: "#image-upload8",
                preview_box: "#image-preview8",
                label_field: "#image-label8"
            });

           
        });
    </script>

<script type="text/javascript">
  $(document).ready(function () { //alert();
  $('#datepickerr').datepicker({dateFormat: 'dd-mm-yy', minDate:0, startDate: "+0d", onSelect: function(dateText, inst) { //alert();
  //$(this).datepicker('hide');
  var date = $('#datepickerr').val();
  var venue_id = $('#venue_id').val();//alert(venue_id);
  $.ajax({
  type:'post',
  url : '<?php echo base_url(); ?>vendor/home/temporary_slots_ajax',
  data : {date:date, venue_id:venue_id},
  beforeSend: function( xhr ) {
  xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
  $("#wait").css("display", "block");
  },
  success : function(data) {
  $("#t_slots").html(data);
  $("#form-footer").show();
  $("#wait").css("display", "none");
  return false;
  }
  });
  }
  });

  $('#datepickerrr').datepicker({ dateFormat: 'dd-mm-yy', minDate:0, startDate: "+0d", onSelect: function(dateText, inst) {
    var date = $('#datepickerrr').val();
    var venue_id = $('#venue_id').val();
    var category_id = $('#category_id').val();
    $.ajax({
    type:'post',
    url : '<?php echo base_url(); ?>vendor/home/book_offline_ajax',
    data : {date:date, venue_id:venue_id, category_id:category_id},
    beforeSend: function( xhr ) {
    xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
    $("#wait").css("display", "block");
    },
    success : function(data) {
    $("#b_slots").html(data);
    $("#date").val(date);
    $("#wait").css("display", "none");
    return false;
    }
    });
    } 
  });

  $('#c_datepicker').datepicker({ dateFormat: 'dd-mm-yy', minDate:0, startDate: "+0d", onSelect: function(dateText, inst) {
  //$(this).datepicker('hide');
  var date = $('#c_datepicker').val();
  var venue_id = $('#venue_id').val();
  var category_id = $('#category_id').val();
  $.ajax({
  type:'post',
  url : '<?php echo base_url(); ?>vendor/home/calendar_ajax',
  data : {date:date, venue_id:venue_id, category_id:category_id},
  beforeSend: function( xhr ) {
  xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
  $("#wait").css("display", "block");
  },
  success : function(data) {
  $("#b_slots").html(data);
  $("#date").val(date);
  $("#wait").css("display", "none");
  return false;
  }
  });
}
  });

  });


</script>
<script type="text/javascript">
window.onload = function()
{
    if (window.jQuery)
    {
        // alert('jQuery is loaded');
        // location.reload();
    }
    else
    {
        alert('jQuery is not loaded');
        location.reload();
    }
}
</script>
  
  </body>
</html>

