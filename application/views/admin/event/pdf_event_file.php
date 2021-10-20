<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>ISSM Educational Services Pvt Ltd</title>
<style type="text/css">
   .print
   {
     width:140px;
     height:35px;
     line-height:32px;
     text-align:center;
     border:none;
     border-radius:20px;
     background:#f60;
     margin-bottom:20px;
     cursor:pointer;
     color:#fff;
     font-family: 'Muli', sans-serif;
   }
</style>


  



</head>

<body>

<div id="panel">
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tb">
  <tbody>
    <tr>
      <td height="35" colspan="4" align="center" class="txt" style="font-size:20px;border-bottom:1px solid #ddd; color:#004495; font-weight:800; font-family: 'Muli', sans-serif;background-color:#649de0;color:#fff;padding: 10px 40px;"><b><span style="font-size: 30px;">Dr Bhatia Medical Coaching Institute Pvt. Ltd.</span></b><br></td> 
    </tr>   
    <tr>
      <td height="36" colspan="4">&nbsp;</td>
    </tr>
    <tr>
      <td width="3%">&nbsp;</td>
      <td colspan="2"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tb1">
        <tbody>
          <tr>
            <td><table style="border:1px solid #999999;padding: 39px 2px;" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tbody>
                <tr>
                  <td width="16%" height="25"><strong><span style="font-size:21px; color:#000; padding:30px; font-family: 'Muli', sans-serif;">State: </strong><?php echo $event['state']; ?></span></td>
                  
                  <td width="16%"><strong><span style=" font-size:21px; color:#000; padding:30px; font-family: 'Muli', sans-serif;">Organisation : </strong><?php echo $event['organisation_name']; ?></span></td>
                 
                </tr>
                <tr>
                  <td  height="90"><strong><span style="font-size:21px; color:#000; padding:30px; font-family: 'Muli', sans-serif;">Center :</strong><?php echo $event['center']; ?></span></td>
                 
                  <td><strong><span style=" font-size:21px; color:#000; padding:30px; font-family: 'Muli', sans-serif;">Batch Name : </strong><?php echo $event['batch_names']; ?></span></td>
                 
                </tr>
                <tr>
                  <td height="25"><strong><span style=" font-size:21px; color:#000; padding:30px; font-family: 'Muli', sans-serif;">Event Name : </strong><?php echo $event['event_name']; ?></span></td>
                 
                  <td><strong><span style=" font-size:21px; color:#000; padding:30px; font-family: 'Muli', sans-serif;">Start Date : </strong><?php echo date("d-m-Y", strtotime($event['start_date'])); ?></span></td>
                 
                </tr>
                <tr>
                  <td height="90"><strong><span style=" font-size:21px; color:#000; padding:30px; font-family: 'Muli', sans-serif;"></td>
                  <td height="25"><strong><span style=" font-size:21px; color:#000; padding:30px; font-family: 'Muli', sans-serif;">Start Time : </strong><?php echo date("g:i a", strtotime($event['start_time'])); ?></span></td>
                </tr>
              </tbody>
            </table></td>
          </tr>
          <tr>
            <td height="31" style="border-top:1px solid #999999;">&nbsp;</td>
          </tr>
          
          <tr>
            <td style="text-align: center;"><img src="<?php echo base_url().$event['qrcode_path']; ?>" style="border: 9px solid #000;border-radius: 5px;height: 300px;width: 300px;"></td>
          </tr>          
          <tr>
            <td>&nbsp;</td>
          </tr>
        </tbody>
      </table></td>
      <td width="3%">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
    </tr><br>
    <tr>
      <td height="32">&nbsp;</td>
      <td style=" font-size:13px; color:#000; padding:5px; font-family: 'Muli', sans-serif;" width="47%" height="32"><strong>
        Date : <?php echo date('d F Y'); ?></strong></td>

    </tr>
    
    
    
  </tbody>
</table>
</div>


</body>
</html>