<?php
if(!empty($pricing))
{
  foreach($pricing as $key => $price)
  {
    ?>
    <div class="col-lg-4" id="">
      <div class="form-group">
        <label class="form-label">Enter Title</label>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" name="title[]" placeholder="Title" id="title" required="" value="<?=$price->title;?>">
          </div>                       
        </div>
      </div>
    </div>

    <div class="col-lg-4" id="">
      <div class="form-group">
        <label class="form-label">Enter Price</label>
        <div class="row">
          <div class="col-md-12">
            <input type="number" class="form-control" name="price[]" placeholder="Price" id="price" required="" min="0" value="<?=$price->price;?>">
          </div>                       
        </div>
      </div>
    </div>

    <div class="col-lg-4" id="">
      <div class="form-group">
        <label class="form-label">Enter Quantity</label>
        <div class="row">
          <div class="col-md-12">
            <input type="number" class="form-control" name="quantity[]" placeholder="Quantity" id="quantity" required="" min="0" value="1" readonly="">
          </div>                       
        </div>
      </div>
    </div>
    <?php
    if($key != 0)
    {
      ?>
      <div class="col-lg-12 mb-2"><a class="pull-right remove_field"><i class="fe fe-minus-circle text-red"></i></a><br></div>
      <?php
    }
    ?>
    <?php
  }
}
else
{
  ?>
  <div class="col-lg-4" id="">
      <div class="form-group">
        <label class="form-label">Enter Title</label>
        <div class="row">
          <div class="col-md-12">
            <input type="text" class="form-control" name="title[]" placeholder="Title" id="title" required="">
          </div>                       
        </div>
      </div>
    </div>

    <div class="col-lg-4" id="">
      <div class="form-group">
        <label class="form-label">Enter Price</label>
        <div class="row">
          <div class="col-md-12">
            <input type="number" class="form-control" name="price[]" placeholder="Price" id="price" required="" min="0">
          </div>                       
        </div>
      </div>
    </div>

    <div class="col-lg-4" id="">
      <div class="form-group">
        <label class="form-label">Enter Quantity</label>
        <div class="row">
          <div class="col-md-12">
            <input type="number" class="form-control" name="quantity[]" placeholder="Quantity" id="quantity" required="" min="0" value="1" readonly="">
          </div>                       
        </div>
      </div>
    </div>
    <div class="col-lg-12 mb-2"><a class="pull-right remove_field"><i class="fe fe-minus-circle text-red"></i></a><br></div>
  <?php
}
?>