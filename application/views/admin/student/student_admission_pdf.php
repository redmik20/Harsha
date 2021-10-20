<!DOCTYPE html>
<html>

<head>
    <title>admissionForm</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"/>
    <style>
        h2,h3 {
            text-align: center;
            background-color: #0b5ac9;
            color: white;
            padding: 5px;
        }

        .table {
            overflow: hidden;
        }
    </style>
</head>

<body>
    
        <h2 style="text-align: center">ADMISSION FORM</h2>
        <table class="table table-borderless">
       
            <tr>               
                <td><img style="width: 20%;height: 20%" src="https://hyderabadbhatia.com/storage/dbmci.png"></td>
                <td style="margin-top: 100px;margin-left: 20px;">
                    <h4 style="color: #063C88;margin-top: 50px;margin-left: 90px;">Dr Bhatia Medical Coatching Institute Pvt. Ltd.</h4>
                    <h5 style="color: #063C88;margin-left: 100px;">(A Franchisee by ISSM Educational Services Pvt. Ltd.)
                    </h5>
                    <h5 style="color: #063C88;margin-left: 60px;">(For : NEET, AIIMS, DNB, UPSC & MD/MS PG ENT. EXAM)</h5>
                    <p style="font-size:10px;margin-left: 80px;">Corp, Office, Unique Apartment, Sector 13, Rohini,
                        Delhi-110085</p>
                </td>                
            </tr> 
          </table>
        
       <table class="table table-borderless">
                      
                <tr>
                    <td><span style="font-weight: bold">Admission No</span>&nbsp;:&nbsp;<?php echo $record['admission_no'];?></td><br>
                    <td><span style="font-weight: bold">Center</span>&nbsp;:&nbsp;<?php echo $record['center'];?></td>
                    <?php if($record['image'] != ''){ ?>
                    <td rowspan="3"><img src="https://hyderabadbhatia.com/<?php echo $record['image']; ?>" alt="" style="width: 10%;height: 10%;"> </td> 
                    <?php }else{?>

                    <td rowspan="3"><img src="https://hyderabadbhatia.com/storage/no_image.jpg" alt="" style="width: 10%;height: 10%;"> </td> 

                    <?php }?>

                </tr>
                <tr>
                    <td><span style="font-weight: bold">Course</span>&nbsp;:&nbsp;<?php echo $record['course_name'];?></td><br>
                    <td><span style="font-weight: bold">Batch</span>&nbsp;:&nbsp;<?php echo $record['batch'];?></td>                 
                </tr>
                <tr>
                    <td><span style="font-weight: bold">Valid From</span>&nbsp;:&nbsp;<?php echo $record['valid_from'];?></td><br>
                    <td><span style="font-weight: bold">Valid To</span>&nbsp;:&nbsp;<?php echo $record['valid_to'];?></td>                 
                </tr>                    
        </table><br>

        <table>

        
       <tr>
            <td>
            <span style=" font-weight: bold;">StudentID</span>
            </td>
            <td>&nbsp;&nbsp;
            <span style="margin-right: 170px;margin-left: 200px;font-weight: bold;">:</span> 
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;
            <span><?php echo $record['student_dynamic_id'];?></span>
            </td> 
        </tr>
        <tr>
            <td>
            <span style=" font-weight: bold;">StudentName</span>
            </td>
            <td>&nbsp;&nbsp;
            <span style="margin-right: 170px;margin-left: 200px;font-weight: bold;">:</span> 
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;
            <span><?php echo $record['student_name'];?></span>
            </td> 
        </tr>

        <tr>
            <td>
            <span style=" font-weight: bold;">Mobile Number</span>
            </td>
            <td>&nbsp;&nbsp;
            <span style="margin-right: 170px;margin-left: 150px;font-weight: bold;">:</span>
            </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;
            <span><?php echo $record['student_mobile'];?></span>
            </td> 
        </tr>

        <tr>
            <td>
                <span style=" font-weight: bold;">Student Email Id</span>
            </td>
            <td>&nbsp;&nbsp;
                <span style="margin-right: 170px;margin-left: 180px;font-weight: bold;">:</span>
            </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;
                <span><?php echo $record['student_email'];?></span>
            </td> 
        </tr>
        <tr>
            <td>
            <span style=" font-weight: bold;">Premanent Address</span>
            </td>
            <td>&nbsp;&nbsp;
            <span style="margin-right: 170px;margin-left: 155px;font-weight: bold;">:</span>
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;
            <span><?php echo $record['permanent_address'];?></span>
            </td> 
        </tr>
        <tr>
            <td>
            <span style=" font-weight: bold;">State</span>
            </td>
            <td>&nbsp;&nbsp;
            <span style="margin-right: 170px;margin-left: 263px;font-weight: bold;">:</span>
            </td>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;
            <span><?php echo $record['state'];?></span>
            </td>     
        </tr>

        <tr>
            <td>
                <span style=" font-weight: bold;">College of MBBS</span>
            </td>
            <td>&nbsp;&nbsp;
                <span style="margin-right: 170px;margin-left: 175px;font-weight: bold;">:</span>
            </td>
            <td> &nbsp;&nbsp;&nbsp;&nbsp;
                <span><?php echo $record['college_name'];?></span>
            </td>        
        </tr>
        </table>
        <br><br>

            <h3 style="text-align: center">FEE DETAILS</h3>

       <table class="table table-borderless"> 
   
        

       
            
    
        
            <tr>
                
                <th>Receipt No.</th>&nbsp;&nbsp;
                <th>Paid Date</th>&nbsp;&nbsp;
                <th>Paid Fee(Rs.)</th>&nbsp;&nbsp;
                <th>Due Fee</th>&nbsp;&nbsp;
                <th>Staff Sign</th>
            </tr>


            <tr>

                <td>&nbsp;&nbsp;<?php echo $payment_data['receipt_id']?></td>&nbsp;&nbsp;
                <td>&nbsp;&nbsp;<?php 
                    $newDate = date("d-m-Y", strtotime($payment_data['amount_paid_date']));
                    echo $newDate;
                    ?></td>&nbsp;&nbsp;
                <td>&nbsp;&nbsp;<?php echo $payment_data['amount_paid']?></td>&nbsp;&nbsp;
                <td>&nbsp;&nbsp;<?php echo $payment_data['due_amount']?></td>&nbsp;&nbsp;
                <td><strong><img src="https://hyderabadbhatia.com/storage/sign.png" style="width: 190px;"></strong></td>
                
            </tr>
       
       </table>
            <h6 style="margin-top: 50px;margin-bottom: 10px;color: #063c88;font-size: 20px;font-weight: bold;">
                INSTRUCTIONS FOR STUDENTS :</h6>
            <p><span style="font-weight: bold;">1.</span> I/ We hereby declare that the information declared in the
                enrollment form is true and correct..
            </p>
            <p><span style="font-weight: bold;">2.</span> I/we have read the prospectus / brochure and being satisfied
                with the study system, faculty, previous examination results,infrastructure, syllabus and all other
                information of (DBMCIPL) in all respects and decided to take admission after giving due consideration to
                gigours of time, distance and studies ahead</p>
            <p><span style="font-weight: bold;">3.</span> l/we undertake that our ward (The student) will not leave the
                institute before completing the full course. In any case if the student leaves the institute during the
                course for any reason including transfer, ill- health, admission in any other college, selection for MD
                / MS distance, not able to concentrate and likes, I/We will not claim refund of fees in any eventuality
                nor DBMCIPL will be under any liability for refund of fees as the withdrawal is because of mine/our
                personal reasons. The fee once paid will not be refunded nor adjusted in any other course or with fee
                for any other student.</p>
            <p><span style="font-weight: bold;">4.</span> If any student remains absent for more than 6 (six) days
                continuously without prior written information, he/she shall be deemed to have been expelled from the
                institute. No fee or part of the fee will be refunded in such cases. The decision of Centre - in -
                charge in this regard will be final and binding on the students and parents.</p>
            <p><span style="font-weight: bold;">5.</span>DBMCIPL reserves the right to use a students photograph for
                publicity.</p>
            <p><span style="font-weight: bold;">6.</span>DBMCIPL reserves the right to make any alteration in its
                programmes / fee without any prior notice.</p>
            <p><span style="font-weight: bold;">7.</span> If a student going for installment plan need to pay their dues
                on the given dates, failing which the Institute has the authority to stop them from entering the class
                until the dues are cleared.</p>
           
            <p><span style="font-weight: bold;">8.</span>In case if any Student / parent/guardian misbehaves with any
                staff member of the Institute, can be rusticated from the Institute and no claim of refund of such
                student will be entertained.</p>
            
            <p><span style="font-weight: bold;">9.</span>All disputes to be settled in Delhi / New Delhi Jurisdiction
                only.</p>
        </div>
        <div class="row" style="margin-bottom: 20px;">
            <div class="col-sm-12" style="display: flex;">
                <div style="text-align: center;background-color:#063c88 ;color: white;padding: 20px;">I hearby declare
                    that all the particulars furnished in this application are true, correct and complete to the best of
                    my knowledge and belief. In the event of any information being found false or incorrect or
                    ineligibility being detected before or after the examination, action can be initiated against me by
                    the Telangana State Public Service Commission or Goverment of Telangana</div>
            </div>
        </div>
    </div>
    </div>
    
</body>

</html>