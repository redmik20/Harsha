<!DOCTYPE html>
<html>
<head>
    <title>Link</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body {
            margin-top: 50px;
            margin-left: 10%;
        }

        .signin {
            background-color: #2176ef;
            color: #FFF;
            width: 10%;
            padding: 10px 20px;
            display: block;
            height: 39px;
            border-radius: 20px;
            margin-top: 0px;
            margin-left: 8%;
            border: none;
            text-transform: uppercase;
            transition: all 0.5s ease-in-out;
        }

        .signin:hover {
            background-color: #3fe3d9;
            box-shadow: 0px 4px 35px -5px #2176ef;
            cursor: pointer;
        }

        .signin:focus {
            outline: none;
        }

        h2 {

            margin-bottom: 20px;
            margin-left: 10px;
        }

        #ll {
            margin-right: 8%;
            margin-top: 60px;
        }

        @media screen and (max-width: 600px) {

            .signin {
                background-color:  #2176ef;
                color: #FFF;
                width: 50%;
                padding: 0;
                display: block;
                height: 39px;
                border-radius: 10px;
                margin-top: 20px;
                margin-left: 17%;
                border: none;
                text-transform: uppercase;
                transition: all 0.5s ease-in-out;

            }

            #no {
                margin-bottom: 10px;
            }
            .mani{
               margin-left: 14%;
            }
        }
    </style>
</head>

<body>
    <div class="container-fluid">
         <form class="form-horizontal" role="form" name="myform" id="myform" method="post" action="<?php echo base_url()?>admin/payment" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-3"> </div>
            <div class="col-sm-4">
                <h2 style="text-align:center;">Course Details</h2>
                <div class="row">
                    <table class="table table-borderless" style="border: none;">
                        <tr style="border: none;">
                            <td>Student&nbsp;Name*</td>
                            <td>:</td>
                            <td><b><?php echo $record['student_name'];?></b></td>
                        </tr>
                        <input type="hidden" name="row_id" value="<?php echo $record['id'];?>"></input>
                        <tr>
                            <td>Mobile&nbsp;Number*</td>
                            <td>:</td>
                            <td><b><?php echo $record['mobile_no'];?></b></td>
                        </tr>
                        <tr>
                            <td>Batch&nbsp;Details* </td>
                            <td>:</td>
                            <td><b><?php echo $batch['batch_name']?></b></td>
                        </tr>
                        <tr>
                            <td>Valid&nbsp;From* </td>
                            <td>:</td>
                            <td><b><?php $valid_from=$record['valid_from'];
                echo date("d-m-Y", strtotime($valid_from)); ?></b></td>
                        </tr>
                        <tr>
                            <td>Valid&nbsp;To* </td>
                            <td>:</td>
                            <td><b><?php 
                $valid_to=$record['valid_to'];
                echo date("d-m-Y", strtotime($valid_to)); ?></b></td>
                        </tr>
                        
                        <tr>
                            <td>Material&nbsp;Status* </td>
                            <td>:</td>
                            <td><b><?php echo $record['material_status'];
                  ?></b></td>
                        </tr>
                        <tr>
                            <td>Final &nbsp;fee* </td>
                            <td>:</td>
                            <td><b><?php echo $record['final_fee'];
                         ?>.00</b></td>
                        </tr>
                        <tr>
                            <td>Registration &nbsp;Fee* </td>
                            <td>:</td>
                            <td><b><?php echo $record['student_paid_amt']; 
                        ?>.00</b></td>
                        </tr>
                        <tr>
                            <td><b style="color:red">*Please Pay your due fees with in 2 classes of attendance </td>
                         </b></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="col-sm-2" id="ll">
                <div class="row">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <?php if($record['student_image_path'] != ''){?>
                        <img class="mani" src="<?php echo  base_url().$record['student_image_path'];?>" alt="Card image" style="width:70%;border-radius: 20px;">
                        <?php }else{?>
                            <img class="mani" src="<?php echo base_url('storage/no_image.jpg');?>" alt="Card image" style="width:70%;border-radius: 20px;">
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"> </div>
             <input type="submit" name="submit" class="signin" value="Pay" />
        </div>
    </form>
    </div>

</body>

</html>