<?php
//var_dump($slots);
if(!empty($slots))
{
	foreach($slots as $slot)
	{
		?>
		<li>
			<a href="javascript:void(0)" data-toggle="modal" data-target="#modal_basic" onclick="fnItems('<?=$slot['slot_id'];?>')" class="wow pulse <?php echo ($slot['booking_status'] == "available")?"green":"red" ;?> <?php echo ($slot['booked_type'] == "offline")?"orange":"" ;?>" data-wow-delay="1s" data-index="<?=$slot['slot_id'];?>">
				<span><i class="fa fa-clock-o" aria-hidden="true"></i> Time <?=date('h:i A', strtotime($slot['start_time']));?> - <?=date('h:i A', strtotime($slot['end_time']));?></span> 
				<span><i class="fa fa-users" aria-hidden="true"></i> Capacity 
				<?php 
				if($slot['slot_capacity'] == 0)
				{
					echo $details['people_capacity'];
				}
				else
				{
					echo $slot['slot_capacity'];
					echo "<br> Booked";
					echo $slot['capacity_booked'];
				}
				?>

				</span>
				<span class="price"><i class="fa fa-inr" aria-hidden="true"></i> <?=$slot['amount'];?></span>
				<span class="select"><?=ucfirst($slot['booking_status']);?></span>
			</a>
		</li>
		<?php
	}
}
?>

<script type="text/javascript">
    // $(document).ready(function () {
    //     $('#b_slots li a').click(function () { //alert();
    //     	var a = $(this).data("index");
    //         if ($(this).hasClass('active')) {
    //             $(this).removeClass('active');
    //             $(this).parent('li').removeClass("animated bounceIn");
                
    //             //$('#slot_id').val('');
    //             function test() {
    //             	$('#slot_id').val();
    //                 $(this).parent('li').addClass("animated bounceOut").delay(100).queue(function (next) {
    //                     $(this).removeClass("animated bounceOut").dequeue();
    //                     $('#slot_id').val('');
    //                     // next();
    //                 });
    //             }
    //             setTimeout($.proxy(test, this), 100);
    //         }
    //         else {
    //             $('.batches ul li a.active').removeClass('active ');
    //             $('#slot_id').val('');
    //             //$(this).addClass('active');
    //             function test() {
    //                 $(this).addClass('active');
    //                 $(this).parent('li').addClass("animated bounceIn");
    //                 $('#slot_id').val(a);
    //             }
    //             setTimeout($.proxy(test, this), 100);
    //         }
    //     });

    //     // $('.batches ul li a .remaining-capacity').hide();
    //     // $('.batches ul li a').hover(function () {
    //     //     //$(this).parent().find('ul').slideToggle();
    //     //     $(this).find('.remaining-capacity').slideToggle().delay(1000);
    //     //     $(this).find('.total-capacity').slideToggle();
    //     // });
    // });
    function fnItems(slot_id) 
	{//alert(slot_id);
	 var date = $('#c_datepicker').val(); //alert(date);
	 $.ajax({
	   type:'post',
	   url : '<?php echo base_url(); ?>vendor/home/slot_booked_users',
	   data : {slot_id:slot_id, date:date},
	   beforeSend: function( xhr ) {
	     xhr.overrideMimeType( "text/plain; charset=x-user-defined" );
	     $("#wait").css("display", "block");
	   },
	     success : function(data) {//alert(data);
	     $(".show_items").html(data);
	     $("#wait").css("display", "none");
	     return false;
	     }
	   });         
	}
</script>
<style type="text/css">
	.batches ul li a.green {
		background: #fff;
		border-color: #077e15;
		border-left-color: rgb(126, 49, 177);
		border-left: 2px solid #077e15;
		color: #077e15;
		transform: scale(1.03);
	}
	.batches ul li a.red {
		background: #fff;
		border-color: #c90606;
		border-left-color: rgb(126, 49, 177);
		border-left: 2px solid #c90606;
		color: #c90606;
		transform: scale(1.03);
	}
	.batches ul li a.orange {
		background: #fff;
		border-color: #FFA500;
		border-left-color: rgb(126, 49, 177);
		border-left: 2px solid #FFA500;
		color: #FFA500;
		transform: scale(1.03);
	}
</style>
<div class="modal" id="modal_basic" tabindex="-1" role="dialog" aria-labelledby="defModalHead" aria-hidden="true">
   <div class="modal-dialog">
     <div class="modal-content">
       <div class="modal-header">
         
         <h4 class="modal-title" id="defModalHead" style="float:left">Users List</h4>
       </div>
       <div class="modal-body show_items">

       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
   </div>
 </div>
</div>