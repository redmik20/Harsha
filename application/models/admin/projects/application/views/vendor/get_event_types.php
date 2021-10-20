<div class="col-lg-4">
  <div class="form-group">
    <label class="form-label">Select Event Types</label> 
    <div class="">
      <select class="select2 form-control" data-placeholder="Select Event Types" multiple id="event_types" name="event_types[]">
        <option value="">Select Event Types</option>
        <?php
        if(!empty($event_types))
        {
          foreach($event_types as $et)
          {
            ?>
            <option value="<?=$et->id;?>"><?=$et->title;?></option>
            <?php
          }
        }
        ?>
      </select>
    </div>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label class="form-label">Select Amenities</label>
    <div class="">
      <select class="select2 form-control" data-placeholder="Select Amenities" multiple id="amenities" name="amenities[]">
        <option value="">Select Amenities</option>
        <?php
        if(!empty($amenities))
        {
          foreach($amenities as $am)
          {
            ?>
            <option value="<?=$am->id;?>"><?=$am->title;?></option>
            <?php
          }
        }
        ?>
      </select>
    </div>
  </div>
</div>

<div class="col-lg-4">
  <div class="form-group">
    <label class="form-label">Select Services</label> 
    <div class="">
      <select class="select2 form-control" data-placeholder="Select Services" multiple id="services" name="services[]">
        <option value="">Select Services</option>
        <?php
        if(!empty($services))
        {
          foreach($services as $ser)
          {
            ?>
            <option value="<?=$ser->id;?>"><?=$ser->title;?></option>
            <?php
          }
        }
        ?>
      </select>
    </div>
  </div>
</div>