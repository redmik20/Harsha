<style>
table {
   border-collapse: collapse;
   width: 100%;
}

th, td {
   text-align: left;
   padding: 6px;
}

tr:nth-child(even){background-color: #f2f2f2}

th {
   background-color: #944bb5;
   color: white;
}
</style>
<!-- <h3><strong>Account Type: <?=$accountName;?></strong></h3>
<hr> -->
<table>
   <tr>
       <th>S.No</th>
       <th>Name</th>
       <th>Mobile</th>
       <th>Email Id</th>
   </tr>

<?php
if(!empty($users))
{
 foreach($users as $key=>$user)
 {
   ?>
   <tr>    
       <td><?=$key+1;?></td>
       <td><?=$user->name;?></td>
       <td><?=$user->mobile;?></td>
       <td><?=$user->email_id;?></td>
     </tr>       
    <?php   
 }
}
else
{
  ?>
  <tr>
    <td colspan="6">
      No users Found
  </td>
</tr>
  <?php
}
?>

</table><br>
<!-- <button id="printme">Print me</button> --> 
<script type="text/javascript">
  function printData()
  {
     var divToPrint=document.getElementById("printTable");
     newWin= window.open("");
     newWin.document.write(divToPrint.outerHTML);
     newWin.print();
     newWin.close();
  }

  $('#printme').on('click',function(){
  printData();
  });
</script>
