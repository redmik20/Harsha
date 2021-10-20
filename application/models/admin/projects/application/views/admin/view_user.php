<!-- START BREADCRUMB -->

<ul class="breadcrumb">

  <li><a href="#">Home</a></li>

  <li><a href="#">Users</a></li>

  <li class="active">View User</li>

</ul>

<!-- END BREADCRUMB -->



<!-- PAGE CONTENT WRAPPER -->

<div class="page-content-wrap">

  <div class="row">

    <div class="col-md-12">

      <?php 

      $attributes = array('class' => 'form-horizontal', 'id' => 'validation');

      echo form_open_multipart('admin/register/update_chapters', $attributes); 

      ?>

        <div class="panel panel-default">

          <div class="panel-heading">

            <h2 class="panel-title">View User</h2>            

          </div>

          <?php if($this->session->flashdata('success') != "") : ?>                

            <div class="alert alert-success" role="alert">

              <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

              <?=$this->session->flashdata('success');?>

            </div>

          <?php endif; ?>

          <div class="panel-body">

               <div class="form-group">

             <label for="title" class="col-md-3 col-xs-12 control-label">User Name: </label>

              <div class="col-md-6 col-xs-12 margintop7"><?=$user_details['0']->name;?></div>

            </div>   



            <div class="form-group">

             <label for="title" class="col-md-3 col-xs-12 control-label">User Email: </label>

              <div class="col-md-6 col-xs-12 margintop7"><?=$user_details['0']->email_id;?></div>

            </div>   

            <div class="form-group">

             <label for="title" class="col-md-3 col-xs-12 control-label">User Mobile: </label>

              <div class="col-md-6 col-xs-12 margintop7"><?=$user_details['0']->mobile;?></div>

            </div>  

            <div class="form-group">

             <label for="title" class="col-md-3 col-xs-12 control-label"> Gender: </label>

              <div class="col-md-6 col-xs-12 margintop7"><?=$user_details['0']->gender;?></div>

            </div> 

           <div class="form-group">

             <label for="title" class="col-md-3 col-xs-12 control-label"> College: </label>

              <div class="col-md-6 col-xs-12 margintop7"><?=$user_details['0']->college;?></div>

            </div> 

            <div class="form-group">

             <label for="title" class="col-md-3 col-xs-12 control-label"> Location: </label>

              <div class="col-md-6 col-xs-12 margintop7"><?=$user_details['0']->location;?></div>

            </div> 

             <div class="form-group">

             <label for="title" class="col-md-3 col-xs-12 control-label">user  profile: </label>

              <div ><img src="<?=base_url().$user_details['0']->image ?>" height="150" width="200" alt="Logo"/>

              </div>

            

            </div>

            <!--<div class="form-group">-->

            <!--  <label class="col-md-3 col-xs-12 control-label">Image</label>-->

            <!--  <div class="col-md-6 col-xs-12" style="top: 8px;">-->

            <!--    <img src="<?=base_url().$row['0']['image'];?>" alt="image" height="50" width="50">-->

            <!--  </div>-->

            <!--</div>     -->

           

            <div class="form-group">

             <label for="title" class="col-md-3 col-xs-12 control-label"> Status: </label>

              <div class="col-md-6 col-xs-12 margintop7"><?=$user_details['0']->status;?></div>

            </div> 

             <div class="form-group">

             <label for="title" class="col-md-3 col-xs-12 control-label"> Courses: </label>
             <?php if(!empty($user_exams)){
              foreach($user_exams as $ue){?>
              <?php $exam_id=$ue['exam_id'];
              $res=$this->db->query("select * from exams where id='".$exam_id."' ")->row_array();?>

              <div class="col-md-6 col-xs-12 margintop7"><?php echo $res['name'];?></div>,
              <?php } }else {?>
                  No courses are assigned;
              <?php }?>
            </div> 

          </div>

        </div>

      </form>



    </div>

  </div>

</div>
<!--<div class="container">
            <h2 class="text-primary">User Tests</h2>
               <table class="table table-bordered">
                        <tr>
                            <th>Id</th>
                            <th>COURSE NAME</th>
                            <th>CATEGORY NAME</th>  
                            <th>TEST SERIES QUIZ NAME</th>
                            <th>DESCRIPTION</th>
                            <th>QUIZ TYPE</th>
                        </tr>
						<tbody>
                        <?php foreach ($get_tests as $res): ?>
                            <tr>
                                <td><?php echo  $res['id'] ?></td>
                                <td><?php echo  $res['name'] ?></td>
                                <td><?php  echo  $res['title'] ?></td>
                                <td><?php echo  $res['topic_name'] ?></td>
                                <td><?php echo  $res['description'] ?></td>
                                <td><?php echo  $res['quiz_type'] ?></td>
                               </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
               <p><?php echo $links; ?></p> 
            </div>
        </div>-->


