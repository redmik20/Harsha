<!-- START BREADCRUMB -->

<ul class="breadcrumb">

  <li><a href="#">Home</a></li>

  <li><a href="<?php echo base_url()?>register/users">Users</a></li>

  <li class="active">User Courses</li>

</ul>

<!-- END BREADCRUMB -->



<!-- PAGE CONTENT WRAPPER -->

<div class="page-content-wrap">

  <div class="row">

    <div class="col-md-12">

     </br>
</br>

    <div class="panel-heading">

            <h2 class="panel-title">User Courses</h2>            

          </div>
   

 <div class="panel-body">

    <div class="table-responsive">

      <table class="table table-bordered">

        <thead>

          <tr>

            <th>S NO</th>
            <th>User Name</th>
            <th>User Mobile</th>  
            <th>COURSE NAME</th>
            <th>QUIZ TYPE</th>
            <th>Reset Exams</th>
          </tr>

        </thead>

        <tbody>

<?php foreach ($user_exmas as $key=> $res): ?>
                            <tr>
                                <td><?php echo  $key+1; ?></td>
                                <td><?php echo  $res['name'] ?></td>
                                <td><?php  echo  $res['mobile'] ?></td>
                                <td><?php echo  $res['course'] ?></td>
                                <td><?php echo  $res['payment_type'] ?></td>
                                <td><a title="Click to UserExams" href="<?php echo base_url()?>admin/register/viewUserExams/<?php echo $res['user_id']?>/<?php echo $res['exam_id']?>" class="btn btn-success btn-condensed">Reset Exams</a></td>
                            </tr>
                        <?php endforeach; ?>

          

          

        </tbody>

      </table> 

    </div>

    </div>

    </div>

      <div class="panel-footer">
            <a href="<?=base_url();?>admin/register/users" class="btn btn-primary pull-right" style="margin-left:10px;">Back</a>    
           
          </div>
<!--<div class="container">
            <h2 class="text-primary">User Courses</h2>
               <table class="table table-bordered">
                        <tr>
                            <th>S NO</th>
                            <th>User Name</th>
                            <th>User Mobile</th>  
                            <th>COURSE NAME</th>
                            <th>QUIZ TYPE</th>
                        </tr>
                <tbody>
                        <?php foreach ($user_exmas as $key=> $res): ?>
                            <tr>
                                <td><?php echo  $key+1; ?></td>
                                <td><?php echo  $res['name'] ?></td>
                                <td><?php  echo  $res['mobile'] ?></td>
                                <td><?php echo  $res['course'] ?></td>
                                <td><?php echo  $res['payment_type'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
               <p></p> 
            </div>-->
        </div>
        





    </div>

  </div>

</div>



