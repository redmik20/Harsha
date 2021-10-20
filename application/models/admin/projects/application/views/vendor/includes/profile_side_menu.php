<div class="card-body text-center">
<h3 class="mb-3"><?=$this->session->userdata('name');?></h3>
<p class="mb-4">
<?=$this->session->userdata('email_id');?><br>
<?=$this->session->userdata('mobile');?>
</p>
</div>
<?php $uri = $this->uri->segment(2);?>
<div class="list-group list-group-transparent mb-0">
<a href="<?=base_url();?>vendor/edit_profile" class="list-group-item list-group-item-action <?php echo ($uri == "edit_profile")?"active":"";?>"><span class="icon mr-3"><i class="fe fe-user"></i></span>Profile</a>
<a href="<?=base_url();?>vendor/change_password" class="list-group-item list-group-item-action <?php echo ($uri == "change_password")?"active":"";?>"><span class="icon mr-3"><i class="fe fe-lock"></i></span>Change Password</a>
<a href="<?=base_url();?>vendor/home/vendor_logged_out" class="list-group-item list-group-item-action"><span class="icon mr-3"><i class="fe fe-log-out"></i></span>LogOut</a>
</div>