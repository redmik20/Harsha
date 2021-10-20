<!DOCTYPE html>
<html>
<head>
    <title>studentDetails</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    


</head>

<body>
    <div class="container">
        <div class="row" style="text-align: center; margin-top: 250px">
            <div class="col-sm-3" style="margin-left:50px;">
                <a href="<?php echo base_url('admin/payment_approvals/payments/Pending')?>" ><button type="button" id="pending"
                        onclick="pending()" class="btn btn-warning"
                        style="width: 100%;height: 70px;margin-top: 20px;color: white;margin-left:50px;background-color: orange">Pending</button></a>
            </div>
            <div class="col-sm-3" style="margin-left:50px;">
                <a href="<?php echo base_url('admin/payment_approvals/payments/Approved')?>" ><button type="button" class="btn btn-success" id="approval"
                        onclick="approval()"
                        style="width: 100%; height: 70px;margin-top: 20px;color: white;margin-left:50px;">Approval</button></a>
            </div>
            <div class="col-sm-3" style="margin-left:50px;">
                <a href="<?php echo base_url('admin/payment_approvals/payments/Rejected')?>" ><button type="button" class="btn btn-danger"
                        id="rejected" onclick="rejected()"
                        style="width: 100%;height: 70px ;margin-top: 20px;color: white;margin-left:50px;">Rejected</button></a>
            </div>
        </div>

        

    </div>
</body>
