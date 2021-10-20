<!-- <style>
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
   background-color: #4CAF50;
   color: white;
}
</style> -->
<!-- <h3><strong>Account Type: <?=$accountName;?></strong></h3>
<hr> -->


<table class="table" style="text-align: center">
   <tr>
    <th style="text-align: center">S.No</th>
    <th style="text-align: center">Title</th>
    <th style="text-align: center">Price</th>
    <th style="text-align: center">Quantity</th>
    <th style="text-align: center">Total</th>
   </tr>
   <?php
   if(!empty($capacity))
   {
    foreach($capacity as $key => $row)
    {
      ?>
     <tr>
       <td style="text-align: center"><?=$key + 1;?></td>
       <td style="text-align: center"><?=$row->title;?></td>
       <td style="text-align: center"><?=$row->price;?></td>
       <td style="text-align: center"><?=$row->quantity;?></td>
       <td style="text-align: center"><?=$row->total;?></td>
     </tr>
     <?php
     }
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
