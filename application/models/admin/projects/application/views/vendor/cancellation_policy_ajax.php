<?php
if(!empty($policy))
{
  foreach($policy as $row)
  {
    ?>
    <div class="col-lg-3" id="">
      <div class="form-group">
        <label class="form-label">Enter From Day</label>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" name="from[]" placeholder="From Day (1)" id="from" required="" value="<?=$row->from;?>">
          </div>                       
        </div>
      </div>
    </div>
    <div class="col-lg-3" id="">
      <div class="form-group">
        <label class="form-label">Enter To Day</label>
        <div class="row">
          <div class="col-md-12">
            <input type="number" class="form-control" name="to[]" placeholder="To Day (7)" id="to" required="" min="0" value="<?=$row->to;?>">
          </div>                       
        </div>
      </div>
    </div>
    <div class="col-lg-3" id="">
      <div class="form-group">
        <label class="form-label">Cancellation Allowed?</label>
        <div class="row">
          <div class="col-md-12">
            <select id="cancellation_allowed" name="cancellation_allowed[]">
              <option value="yes">Yes</option>
              <option value="no">No</option>
            </select>
          </div>                       
        </div>
      </div>
    </div>
    <div class="col-lg-3" id="">
      <div class="form-group">
        <label class="form-label">Enter Refund Percentage</label>
        <div class="row">
          <div class="col-md-12">
            <input type="number" class="form-control" name="refund[]" placeholder="Refund Percentage (%)" id="refund" required="" min="0" value="<?=$row->refund;?>">
          </div>                    
        </div>
      </div>
    </div>
    <?php
  }
}
else
{
  ?>
  <div class="col-lg-3" id="">
      <div class="form-group">
        <label class="form-label">Enter From Day</label>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" name="from[]" placeholder="From Day (1)" id="from" required="">
          </div>                       
        </div>
      </div>
    </div>
    <div class="col-lg-3" id="">
      <div class="form-group">
        <label class="form-label">Enter To Day</label>
        <div class="row">
          <div class="col-md-12">
            <input type="number" class="form-control" name="to[]" placeholder="To Day (7)" id="to" required="" min="0">
          </div>                       
        </div>
      </div>
    </div>
    <div class="col-lg-3" id="">
      <div class="form-group">
        <label class="form-label">Cancellation Allowed?</label>
        <div class="row">
          <div class="col-md-12">
            <select id="cancellation_allowed" name="cancellation_allowed[]">
              <option value="yes">Yes</option>
              <option value="no">No</option>
            </select>
          </div>                       
        </div>
      </div>
    </div>
    <div class="col-lg-3" id="">
      <div class="form-group">
        <label class="form-label">Enter Refund Percentage</label>
        <div class="row">
          <div class="col-md-12">
            <input type="number" class="form-control" name="refund[]" placeholder="Refund Percentage (%)" id="refund" required="" min="0">
          </div>                    
        </div>
      </div>
    </div>
  <?php
}
?>