<div id="wait" style="display:none;width:69px;height:89px;position:absolute;top:50%;left:50%;padding:2px; z-index:99999999"><img src='<?=base_url();?>assets/img/demo_wait.gif' width="64" height="64" /></div>
    <div class="my-3 my-md-5">
        <div class="container">
            <div class="row row-cards row-deck my-venues">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1 class="page-title">
                            Calendar
                        </h1>
                    </div>
                    <div class="card">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="p-20">
                                    <div class="contents grid-contents available-rooms">
                                        <div class="content wide">
                                            <div class="inner">
                                                <div class="col-sm-5 col-md-2">
                                                    <a class="thumbnailz" href="#">
                                                        <img src="assets/images/author/80x80-1.jpg" alt="" class="responsive-image" />
                                                    </a>
                                                </div>
                                                <div class="">
                                                    <div class="entry">
                                                        <article class="entry-content">
                                                            <h2 class="title-4 no-margin"><?=$details['venue_name'];?></h2>
                                                            <!-- <p class="no-margin"><span class="theme-color fw-600 fsz-15"><?=$details['address'];?></span> </p> -->
                                                            <p><?=$details['description'];?></p>
                                                            <!-- <p>
                                                                <span class="rating fsz-11">
                                                                    <span class="star active"></span>
                                                                    <span class="star active"></span>
                                                                    <span class="star active"></span>
                                                                    <span class="star active"></span>
                                                                    <span class="star active"></span>
                                                                </span>
                                                            </p> -->
                                                        </article>
                                                    </div><!-- /.entry -->	
                                                </div>
                                            </div>
                                        </div><!-- /.content -->
                                    </div>
                                    <div class="overview mb-30">
                                        <div class="info">
                                            <h2 class="title-4 fw-600">Addition Info.</h2>
                                            <ul class="list-unstyled">
                                                <li> <i class="fa fa-map-marker theme-color-bg"></i> <span><?=$details['address'];?></span> </li>
                                                <li> <i class="fa fa-bolt theme-color-bg"></i> <span><?=ucfirst($details['booking_type']);?></span> </li>
                                                <li> <i class="fa fa-inr theme-color-bg"></i><span><?=$details['price'];?></span> </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <input type="hidden" name="venue_id" id="venue_id" value="<?=$details['id'];?>">
                                    <input type="hidden" name="category_id" id="category_id" value="<?=$details['category_id'];?>">
                                    <div class="batches">
                                        <h2 class="title-4 fw-600 pull-left"><i class="fa fa-check" aria-hidden="true"></i>  Available slots</h2>
                                        <form class="col-lg-2 pull-right">
                                            <div class="form-group">
                                                <div class="row">
                                                <input class="dpd1 form-control border" required="" readonly  autocomplete="off" data-date-format="dd-mm-yyyy" placeholder="Select date" type="text" name="date" id="c_datepicker">
                                                <!-- <span class="fa fa-chevron-down theme-color"></span> -->
                                                </div>
                                            </div>
                                        </form>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                                <div class="clearfix"></div>
                            </div>  
                            <!-- <div class="col-md-4">
                                <div class="p-20">
                                    <form role="form" action="<?=base_url();?>" method="post" id="place_offline_order">
                                        <br style="clear:both">

                                        <div class="form-group">
                                            <input type="number" class="form-control" id="capacity" name="capacity" placeholder="No of Guests" required>
                                        </div>
                                        <h3 style="margin-bottom: 25px;">Customer Details</h3>
                                        <div class="form-group">
                                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="number" class="form-control" id="mobile" name="mobile" placeholder="Mobile Number" minlength="10" maxlength="10" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control" id="email_id" name="email_id" placeholder="Email" required>
                                        </div>

                                        <input type="hidden" name="venue_id" id="venue_id" value="<?=$this->uri->segment(3);?>">
                                        <input type="hidden" name="slot_id" id="slot_id" value="">
                                        <input type="hidden" name="date" id="date" value="">
                                        <input type="hidden" name="amount_paid" id="amount_paid" value="<?=$details['token_amount'];?>">
                                        <input type="hidden" name="category_id" id="category_id" value="<?=$details['category_id'];?>">
                                        <input type="hidden" name="vendor_id" id="vendor_id" value="<?=$details['vendor_id'];?>">
                                        <input type="hidden" name="capacity_applicable" id="capacity_applicable" value="<?=$details['capacity_applicable'];?>">
                                        <button type="submit" id="submit" name="submit" class="btn btn-primary w-100">Book Venue</button>
                                    </form>
                                </div>
                            </div> -->
                            <div class="col-md-11">
                                <div class="batches">
                                    <hr />
                                    <ul id="b_slots">
                                    <li>
                                        No slots available!
                                    </li>
                                    <!-- <li><a href="javascript:void(0)" class="wow pulse" data-wow-delay="1s"><span><i class="fa fa-clock-o" aria-hidden="true"></i> Time</span> <span><i class="fa fa-users" aria-hidden="true"></i> Capacity</span><span class="price"><i class="fa fa-inr" aria-hidden="true"></i> 10000</span><span class="select">Select this Slot</span><span class="selected">Selected <i class="fa fa-check" aria-hidden="true"></i> </span></a></li>
                                    <li><a href="javascript:void(0)" class="wow pulse" data-wow-delay="1.5s"><span><i class="fa fa-clock-o" aria-hidden="true"></i> Time</span> <span><i class="fa fa-calendar" aria-hidden="true"></i> Capacity</span><span class="price"><i class="fa fa-inr" aria-hidden="true"></i> 8600</span><span class="select">Select this Slot</span><span class="selected">Selected <i class="fa fa-check" aria-hidden="true"></i> </span></a></li>
                                    <li><a href="javascript:void(0)" class="wow pulse" data-wow-delay="2s"><span><i class="fa fa-clock-o" aria-hidden="true"></i> Time</span> <span><i class="fa fa-calendar" aria-hidden="true"></i> Capacity</span><span class="price"><i class="fa fa-inr" aria-hidden="true"></i> 4500</span><span class="select">Select this Slot</span><span class="selected">Selected <i class="fa fa-check" aria-hidden="true"></i> </span></a></li> -->
                                </ul>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
            <div class="clearfix"></div>

        </div>
    </div>
</div>
</div>
<script src="<?php echo base_url(); ?>assets/js/jquery.validate.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery-validate-additional-methods.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#b_slots li a').click(function () { //alert();
            if ($(this).hasClass('active')) {
                $(this).removeClass('active');
                $(this).parent('li').removeClass("animated bounceIn");
                function test() {
                    $(this).parent('li').addClass("animated bounceOut").delay(100).queue(function (next) {
                        $(this).removeClass("animated bounceOut").dequeue();
                        // next();
                    });
                }
                setTimeout($.proxy(test, this), 100);
            }
            else {
                $('.batches ul li a.active').removeClass('active ');
                //$(this).addClass('active');
                function test() {
                    $(this).addClass('active');
                    $(this).parent('li').addClass("animated bounceIn");
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

        // $("#place_offline_order").validate({
        //   rules: {
        //     // simple rule, converted to {required:true}            
        //     name: {
        //         required : true,
        //     },
        //     mobile: {
        //       required : true,
        //       number:true,
        //       minlength:10,
        //       maxlength:10              
        //     },
        //     email_id: {
        //       required : true,
        //       myEmail:true
        //     }
        //   },          
        //   submitHandler: function(form) {
        //       //$("#btnSubmit").prop('disabled', true);
        //       form.submit();
        //   }
        // });

        // $("#place_offline_order").submit(function()
        // { //alert();
        //     var date = $("#date").val();
        //     var slot_id = $("#slot_id").val();
        //     if(date == "")
        //     {
        //         alert('Please select date!');
        //         return false;
        //         exit;
        //     }
        //     if(slot_id == "")
        //     {
        //         alert('Please select a slot!');
        //         return false;
        //         exit;
        //     }                
        //     var form_data = $("#place_offline_order").serialize();//alert(form_data);
        //     $.ajax({
        //         url: "<?=base_url();?>vendor/home/place_offline_order",
        //         data: form_data,
        //         type: "POST",
        //         success: function(user_id) 
        //         { 
        //             alert('Offline order placed successfully');
        //             location.reload();
        //             return false;                      
        //         }
        //     });    
        // });  
    });
</script>