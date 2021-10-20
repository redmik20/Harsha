window.ParsleyValidator.addValidator('check_city_name', function (value, requirement) { 
	   var bod=$.ajax({
		url: base_url+"superadmin/validation/check_city_name", 
		global: false,
		type: "POST",
		data: ({'city_name' : value}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_city_name', 'City already exists please enter another one...');


window.ParsleyValidator.addValidator('check_edit_city_name', function (value, requirement) { 
	var city_id=$('#city_id').val();
	   var bod=$.ajax({
		url: base_url+"superadmin/validation/check_edit_city_name", 
		global: false,
		type: "POST",
		data: ({'city_name' : value,'city_id':city_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_city_name', 'City already exists please enter another one...');

window.ParsleyValidator.addValidator('check_society_name', function (value, requirement) { 
	var city_id=$('#city_id').val();
	   var bod=$.ajax({
		url: base_url+"superadmin/validation/check_society_name", 
		global: false,
		type: "POST",
		data: ({'society_name' : value,'city_id':city_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_society_name', 'Society already exists please enter another one...');

window.ParsleyValidator.addValidator('check_edit_society_name', function (value, requirement) { 
	var city_id=$('#city_id').val();
	var society_id=$('#society_id').val();
	   var bod=$.ajax({
		url: base_url+"superadmin/validation/check_edit_society_name", 
		global: false,
		type: "POST",
		data: ({'society_name' : value,'city_id':city_id,'society_id':society_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_society_name', 'Society already exists please enter another one...');

window.ParsleyValidator.addValidator('check_admin_email', function (value, requirement) { 
	
	   var bod=$.ajax({
		url: base_url+"superadmin/validation/check_admin_email", 
		global: false,
		type: "POST",
		data: ({'email' : value}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_admin_email', 'Email already exists please enter another one...');

window.ParsleyValidator.addValidator('check_admin_mobile', function (value, requirement) { 
	
	   var bod=$.ajax({
		url: base_url+"superadmin/validation/check_admin_mobile", 
		global: false,
		type: "POST",
		data: ({'mobile' : value}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_admin_mobile', 'Mobile already exists please enter another one...');



window.ParsleyValidator.addValidator('check_edit_admin_mobile', function (value, requirement) { 
	var admin_id=$('#admin_id').val();

	   var bod=$.ajax({
		url: base_url+"superadmin/validation/check_edit_admin_mobile", 
		global: false,
		type: "POST",
		data: ({'mobile' : value,'admin_id':admin_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_admin_mobile', 'Mobile already exists please enter another one...');

window.ParsleyValidator.addValidator('check_edit_admin_email', function (value, requirement) { 
	var admin_id=$('#admin_id').val();

	   var bod=$.ajax({
		url: base_url+"superadmin/validation/check_edit_admin_email", 
		global: false,
		type: "POST",
		data: ({'email_id' : value,'admin_id':admin_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_admin_email', 'Email already exists please enter another one...');

window.ParsleyValidator.addValidator('check_building_name', function (value, requirement) { 
	var admin_id=$('#admin_id').val();

	   var bod=$.ajax({
		url: base_url+"admin/validation/check_building_name", 
		global: false,
		type: "POST",
		data: ({'building_name' : value,'admin_id':admin_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_building_name', 'Name already exists please enter another one...');

window.ParsleyValidator.addValidator('check_edit_building_name', function (value, requirement) { 
	var admin_id=$('#admin_id').val();
    var building_id=$('#building_id').val();

	   var bod=$.ajax({
		url: base_url+"admin/validation/check_edit_building_name", 
		global: false,
		type: "POST",
		data: ({'building_name' : value,'admin_id':admin_id ,'building_id':building_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_building_name', 'Name already exists please enter another one...');

window.ParsleyValidator.addValidator('check_flat_name', function (value, requirement) { 
	var admin_id=$('#admin_id').val();
	var building_id=$('#building_id').val();

	   var bod=$.ajax({
		url: base_url+"admin/validation/check_flat_name", 
		global: false,
		type: "POST",
		data: ({'flat_name' : value,'admin_id':admin_id,'building_id':building_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_flat_name', 'Flat Name already exists please enter another one...');

window.ParsleyValidator.addValidator('check_edit_flat_name', function (value, requirement) { 
	var admin_id=$('#admin_id').val();
	var building_id=$('#building_id').val();
	var flat_id=$('#flat_id').val();

	   var bod=$.ajax({
		url: base_url+"admin/validation/check_edit_flat_name", 
		global: false,
		type: "POST",
		data: ({'flat_name' : value,'admin_id':admin_id,'flat_id':flat_id,'building_id':building_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_flat_name', 'Flat Name already exists please enter another one...');

window.ParsleyValidator.addValidator('check_residence_name', function (value, requirement) { 
		var admin_id=$('#admin_id').val();

	var bod=$.ajax({
		url: base_url+"admin/validation/check_residence_name", 
		global: false,
		type: "POST",
		data: ({'residence_type' : value,'admin_id':admin_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_residence_name', 'Residence type already exists please enter another one...');

window.ParsleyValidator.addValidator('check_edit_residence_name', function (value, requirement) { 
	var residence_id=$('#residence_id').val();
	var admin_id=$('#admin_id').val();

	   var bod=$.ajax({
		url: base_url+"admin/validation/check_edit_residence_name", 
		global: false,
		type: "POST",
		data: ({'residence_type' : value,'residence_id':residence_id,'admin_id':admin_id,}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_residence_name', 'Residence type already exists please enter another one...');

window.ParsleyValidator.addValidator('check_localservice_name', function (value, requirement) { 
	var admin_id=$('#admin_id').val();

	var bod=$.ajax({
		url: base_url+"admin/validation/check_localservice_name", 
		global: false,
		type: "POST",
		data: ({'name' : value,'admin_id':admin_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_localservice_name', 'Name already exists please enter another one...');

window.ParsleyValidator.addValidator('check_edit_localservice_name', function (value, requirement){ 
	var local_service_id=$('#local_service_id').val();
	var admin_id=$('#admin_id').val();

	   var bod=$.ajax({
		url: base_url+"admin/validation/check_edit_localservice_name", 
		global: false,
		type: "POST",
		data: ({'name' : value,'local_service_id':local_service_id,'admin_id':admin_id,}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_localservice_name', 'Name already exists please enter another one...');

window.ParsleyValidator.addValidator('check_security_mobile', function (value, requirement) { 
	var admin_id=$('#admin_id').val();
	var bod=$.ajax({
		url: base_url+"admin/validation/check_security_mobile", 
		global: false,
		type: "POST",
		data: ({'mobile' : value,'admin_id':admin_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_security_mobile', 'Mobile already exists please enter another one...');

window.ParsleyValidator.addValidator('check_edit_security_mobile', function (value, requirement) { 
	var admin_id=$('#admin_id').val();
	var security_id=$('#security_id').val();
	var bod=$.ajax({
		url: base_url+"admin/validation/check_edit_security_mobile", 
		global: false,
		type: "POST",
		data: ({'mobile' : value,'admin_id':admin_id,'security_id':security_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_security_mobile', 'Mobile already exists please enter another one...');

window.ParsleyValidator.addValidator('check_user_lservice_name', function (value, requirement) { 
	var admin_id=$('#admin_id').val();

	var bod=$.ajax({
		url: base_url+"admin/validation/check_user_lservice_name", 
		global: false,
		type: "POST",
		data: ({'name' : value,'admin_id':admin_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_user_lservice_name', 'Name already exists please enter another one...');

window.ParsleyValidator.addValidator('check_edit_user_lservice_name', function (value, requirement){ 
	var local_service_id=$('#local_service_id').val();
	var admin_id=$('#admin_id').val();

	   var bod=$.ajax({
		url: base_url+"admin/validation/check_edit_user_lservice_name", 
		global: false,
		type: "POST",
		data: ({'name' : value,'local_service_id':local_service_id,'admin_id':admin_id,}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_user_lservice_name', 'Name already exists please enter another one...');

window.ParsleyValidator.addValidator('check_staff_mobile_name', function (value, requirement) { 
	var admin_id=$('#admin_id').val();
	var bod=$.ajax({
		url: base_url+"admin/validation/check_staff_mobile_name", 
		global: false,
		type: "POST",
		data: ({'mobile' : value,'admin_id':admin_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_staff_mobile_name', 'Mobile already exists please enter another one...');

window.ParsleyValidator.addValidator('check_edit_staff_mobile_name', function (value, requirement) { 
	var admin_id=$('#admin_id').val();
	var staff_id=$('#staff_id').val();
	var bod=$.ajax({
		url: base_url+"admin/validation/check_edit_staff_mobile_name", 
		global: false,
		type: "POST",
		data: ({'mobile' : value,'admin_id':admin_id,'staff_id':staff_id}),
		dataType: "html",
		async:false,
		success: function(msg){}
	}).responseText; 
	if(bod == 0){ 
		return false;
	}else{
		return true;
	}
	}, 32).addMessage('en','check_edit_staff_mobile_name', 'Mobile already exists please enter another one...');

