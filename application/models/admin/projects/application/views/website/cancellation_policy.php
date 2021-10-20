<table class="table">
  <tr>
    <th>From</th>
    <th>To</th>
    <th>Cancellation Allowed</th>
    <th>Refund</th>
  </tr>
  <?php
  if(!empty($policy))
  {
    foreach($policy as $row)
    {
      ?>
      <tr>
        <td><?=$row->from;?></td>
        <td><?=$row->to;?></td>
        <td><?=$row->cancellation_allowed;?></td>
        <td><?=$row->refund;?> %</td>
      </tr>
      <?php
    }
  }
  else
  {
    ?>
    <tr>
      <td colspan="4">
      No data found
      </td>
    </tr>
    <?php
  }
  ?>
</table>