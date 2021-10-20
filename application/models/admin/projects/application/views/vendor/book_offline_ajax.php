<?php
if(!empty($slots))
{
	foreach($slots as $slot)
	{
		?>
		<li>
			<a href="javascript:void(0)" class="wow pulse <?php echo ($slot['booking_status'] == "available")?"green":"red" ;?>" data-wow-delay="1s" data-index="<?=$slot['slot_id'];?>" data-left="<?=$slot['slot_capacity'] - $slot['capacity_booked'];?>">
				<span><i class="fa fa-clock-o" aria-hidden="true"></i> Time <?=date('h:i A', strtotime($slot['start_time']));?> - <?=date('h:i A', strtotime($slot['end_time']));?></span> 
                <?php
                //echo $category_id;
                //echo $slot['people_capacity'];
                if($category_id == 4 || $category_id == 9 || $category_id == 10)
                {
                    ?>
    				<span>
                    <i class="fa fa-users" aria-hidden="true"></i> Capacity <?=$slot['people_capacity'];?>
                    </span>
                    <?php
                }
                else
                {
                    ?>
                    <span>
                    <i class="fa fa-users" aria-hidden="true"></i> Capacity <?=$slot['slot_capacity'];?><br>
                    <i class="fa fa-users" aria-hidden="true"></i> Booked <?=$slot['capacity_booked'];?> - Left <?=$slot['slot_capacity'] - $slot['capacity_booked'];?>
                    </span>
                    <?php
                }
                ?>
				<span class="price"><i class="fa fa-inr" aria-hidden="true"></i> <?=$slot['amount'];?></span>
				<span class="select">Select this Slot</span>
				<span class="selected">Selected <i class="fa fa-check" aria-hidden="true"></i> </span>                
			</a>
		</li>
		<?php
	}
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#b_slots li a').click(function () { //alert();
        	var a = $(this).data("index");
            var left = $(this).data("left");
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).parent('li').removeClass("animated bounceIn");
                
                //$('#slot_id').val('');
                function test() {
                	$('#slot_id').val();
                    $(this).parent('li').addClass("animated bounceOut").delay(100).queue(function (next) {
                        $(this).removeClass("animated bounceOut").dequeue();
                        $('#slot_id').val('0');
                        // next();
                    });
                }
                setTimeout($.proxy(test, this), 100);
            }
            else {
                $('.batches ul li a.active').removeClass('active ');
                $('#slot_id').val('0');
                //$(this).addClass('active');
                function test() {
                    $(this).addClass('active');
                    $(this).parent('li').addClass("animated bounceIn");
                    $('#slot_id').val(a);
                    $('#left_capacity').val(left);
                }
                setTimeout($.proxy(test, this), 100);
            }
        });

        // $('.batches ul li a .remaining-capacity').hide();
        // $('.batches ul li a').hover(function () {
        //     //$(this).parent().find('ul').slideToggle();
        //     $(this).find('.remaining-capacity').slideToggle().delay(1000);
        //     $(this).find('.total-capacity').slideToggle();
        // });
    });
</script>
<style type="text/css">
    .batches ul li a.green 
    {
        background: #fff;
        border-color: #077e15;
        border-left-color: rgb(126, 49, 177);
        border-left: 2px solid #077e15;
        color: #077e15;
        transform: scale(1.03);
    }
    .batches ul li a.red 
    {
        background: #fff;
        border-color: #c90606;
        border-left-color: rgb(126, 49, 177);
        border-left: 2px solid #c90606;
        color: #c90606;
        transform: scale(1.03);
        pointer-events: none;
        cursor: default;
        text-decoration: none;
        color: black;
    }
</style>