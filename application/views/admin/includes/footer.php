<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">

<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>			

</a>		
</div><!-- /.main-container -->								
<script type="text/javascript">								
function showHelp(){ 									
		var hiv=$("#hiv").val();									
		if(hiv==0){									   
		$("#help").show();									   
		$("#hiv").val('1');									   
		return false;									
		}else{									   
		$("#help").hide();									   
		$("#hiv").val('0');									   
		return false;									
		}								
}								
</script>	
</body>

	     <!-- <script src="<?php echo site_url();?>assets/admin/js/jquery.2.1.1.min.js"></script> -->

<script src="<?php echo base_url();?>assets/admin/datatables/jquery.dataTables.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/datatables/dataTables_custom.js" type="text/javascript"></script>
<!--Load JQuery-->
<script src="<?php echo base_url();?>assets/admin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/datatables/dataTables.bootstrap.min.js"></script>

			<script type="text/javascript">
				window.jQuery || document.write("<script src='<?php echo site_url();?>assets/admin/js/jquery.min.js'>"+"<"+"/script>");
			</script>

		
		
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='<?php echo site_url();?>assets/admin/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		
		<!-- Bootstrap script -->
		<script src="<?php echo site_url();?>assets/admin/js/bootstrap.min.js"></script>
		<script src="<?php echo site_url();?>assets/admin/js/ace-elements.min.js"></script>
		<script src="<?php echo site_url();?>assets/admin/js/ace.min.js"></script>
		<script src="<?php echo site_url();?>assets/admin/js/bootstrap-datepicker.min.js"></script>
		<script src="<?php echo site_url();?>assets/admin/js/bootstrap-timepicker.min.js"></script>
		<script src="<?php echo site_url();?>assets/admin/js/moment.min.js"></script>
		<script src="<?php echo site_url();?>assets/admin/js/daterangepicker.min.js"></script>
		<script src="<?php echo site_url();?>assets/admin/js/bootstrap-wysiwyg.min.js"></script>

		<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/jquery.toast.js"></script>

		<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/bootbox.min.js"></script>
		
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/admin/js/check_validation.js"></script>
		<!-- inline scripts related to this page -->

<script type="text/javascript">

			jQuery(function($){
	
				$('#editor1').ace_wysiwyg({
					toolbar:
					[
						{
							name:'font',
							title:'Custom tooltip',
							values:['Some Special Font!','Arial','Verdana','Comic Sans MS','Custom Font!']
						},
						null,
						{
							name:'fontSize',
							title:'Custom tooltip',
							values:{1 : 'Size#1 Text' , 2 : 'Size#1 Text' , 3 : 'Size#3 Text' , 4 : 'Size#4 Text' , 5 : 'Size#5 Text'} 
						},
						null,
						{name:'bold', title:'Custom tooltip'},
						{name:'italic', title:'Custom tooltip'},
						{name:'strikethrough', title:'Custom tooltip'},
						{name:'underline', title:'Custom tooltip'},
						null,
						'insertunorderedlist',
						'insertorderedlist',
						'outdent',
						'indent',
						null,
						{name:'justifyleft'},
						{name:'justifycenter'},
						{name:'justifyright'},
						{name:'justifyfull'},
						null,
						{
							name:'createLink',
							placeholder:'Custom PlaceHolder Text',
							button_class:'btn-purple',
							button_text:'Custom TEXT'
						},
						{name:'unlink'},
						null,
						{
							name:'insertImage',
							placeholder:'Custom PlaceHolder Text',
							button_class:'btn-inverse',
							//choose_file:false,//hide choose file button
							button_text:'Set choose_file:false to hide this',
							button_insert_class:'btn-pink',
							button_insert:'Insert Image'
						},
						null,
						{
							name:'foreColor',
							title:'Custom Colors',
							values:['red','green','blue','navy','orange'],
							/**
								You change colors as well
							*/
						},
						/**null,
						{
							name:'backColor'
						},*/
						null,
						{name:'undo'},
						{name:'redo'},
						null,
						'viewSource'
					],
					//speech_button:false,//hide speech button on chrome
					
					'wysiwyg': {
						hotKeys : {} //disable hotkeys
					}
					
				}).prev().addClass('wysiwyg-style2');
				
				//handle form onsubmit event to send the wysiwyg's content to server
				$('#myform').on('submit', function(){
					//put the editor's html content inside the hidden input to be sent to server
					$('input[name=description]' , this).val($('#editor1').html());
					return true;
				});
				
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true,
					
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
			
				//or change it into a date range picker
				$('.input-daterange').datepicker({autoclose:true});
			
			
				//to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
				$('input[name=date-range-picker]').daterangepicker({
					'applyClass' : 'btn-sm btn-success',
					'cancelClass' : 'btn-sm btn-default',
					locale: {
						applyLabel: 'Apply',
						cancelLabel: 'Cancel',
					}
				})
				.prev().on(ace.click_event, function(){
					$(this).next().focus();
				});
			
			
				$('#timepicker1').timepicker({
					minuteStep: 1,
					showSeconds: true,
					showMeridian: false
				}).next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				$('#date-timepicker1').datetimepicker().next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
				
				$('[data-toggle="buttons"] .btn').on('click', function(e){
					var target = $(this).find('input[type=radio]');
					var which = parseInt(target.val());
					var toolbar = $('#editor').prev().get(0);
					if(which == 1 || which == 2 || which == 3) {
						toolbar.className = toolbar.className.replace(/wysiwyg\-style(1|2)/g , '');
						if(which == 1) $(toolbar).addClass('wysiwyg-style1');
						else if(which == 2) $(toolbar).addClass('wysiwyg-style2');
					}
				});
			
			});
		</script>
<script type="text/javascript">
			$('#id-input-file-1 , #id-input-file-2').ace_file_input({
					no_file:'No File ...',
					btn_choose:'Choose',
					btn_change:'Change',
					droppable:false,
					onchange:null,
					thumbnail:false //| true | large
					//whitelist:'gif|png|jpg|jpeg'
					//blacklist:'exe|php'
					//onchange:''
					//
				});
		</script>
<script type="text/javascript">	

	function getNameForSEOTags(value) {		
var rental_type = $("#rental_type").val();		
		if(value !=''){				
		$('#title_tag').val(rental_type);		
		$('#description_tag').val(rental_type);		
		$('#keywords_tag').val(rental_type);		
		}else{			
		$('#title_tag').val('');			
		$('#description_tag').val('');			
		$('#keywords_tag').val('');		
		}	
	}		

	
	function getbatchs(course_id){
    //alert(exam_id);
    $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/student/getbatchs',
      data: {course_id: course_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ //alert(data);
        $("#batch_id").html(data);
        $("#wait").css("display", "none");
      }
    });
  }

 function getbatchdates(batch_id){

 	 $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/student/getbatchsdates',
      data: {batch_id: batch_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ 
      	var json = $.parseJSON(data); 
      	//alert(json.valid_from);
      	 //$('#namaBarang').val(response);
        $("#batch_start_date").val(json.valid_from);
        $("#batch_end_date").val(json.valid_to);
        $("#wait").css("display", "none");
      }
    });

 }

 function getmmbscolleges(state_id){

 	 $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/student/getmmbscolleges',
      data: {state_id: state_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ 
      	$("#college_mbbs").html(data);
        $("#wait").css("display", "none");
      }
    });

 }

 function getOrganisations(state_id){

 	 $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/common/get_organisations',
      data: {state_id: state_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ 
      	$("#organisation_id").html(data);
        $("#wait").css("display", "none");
      }
    });

 }

 function getCenters(org_id){

 	var state_id=$("#state_id").val();

 	 $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/common/get_centers',
      data: {state_id: state_id,org_id:org_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ 
      	$("#center_id").html(data);
        $("#wait").css("display", "none");
      }
    });

 }

  function getAttachments(center_id){

 	var state_id=$("#state_id").val();
	var organisation_id=$("#organisation_id").val();
	var center_id=$("#center_id").val();

 	 $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/common/get_attachments',
      data: {state_id: state_id,organisation_id:organisation_id,center_id:center_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ 
      	$("#attachment_id").html(data);
        $("#wait").css("display", "none");
      }
    });

 }
 
function getCourses(center_id){

 	var state_id=$("#state_id").val();
	var organisation_id=$("#organisation_id").val();
	var center_id=$("#center_id").val();

 	 $.ajax({
      type: 'post',
      url: '<?=base_url();?>admin/common/get_courses',
      data: {state_id: state_id,organisation_id:organisation_id,center_id:center_id},
      beforeSend: function(xhr){
        xhr.overrideMimeType("text/plain; charset=utf-8");
        $("#wait").css("display", "block");
      },
      success: function(data){ 
      	$("#course_id").html(data);
        $("#wait").css("display", "none");
      }
    });

 }

</script>

<?php 

$msg='';

$icon='';

$icon='';

if($this->session->flashdata('success')!='')

{

$msg=$this->session->flashdata('success');

$heading='Success';

$icon='success';

}

else if($this->session->flashdata('error')!=''){

$msg=$this->session->flashdata('error');

$heading='Error';

$icon='error';

}

else if(isset($error) && $error!=''){

$msg=$error;

$heading='Error';

$icon='error';

}

else if(isset($success) && $success!=''){

$msg=$success;

$icon='success';

$heading='Success';

}

?>

<script type="text/javascript">

jQuery(function($) {
	
<?php if($msg!=''){?>

    $.toast({

    heading: '<?php echo $heading;?>',

    text: '<?php echo $msg;?>',

    showHideTransition: 'fade',

    position: 'top-center',

    icon: '<?php echo $icon;?>'

    });

<?php } ?>



});

</script>



<style type="text/css">

  .td_action

  {

    width: 100px;

  }

  .td_action_extra

  {

    width: 135px;

  }

</style>

<script  type="text/javascript">

  var base_url='<?php echo base_url()?>';

</script>






<script type="text/javascript">

$(document).ready(function(){



$('#myform').parsley();

});



</script>			
</html>
