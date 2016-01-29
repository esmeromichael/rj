<?php
include('session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sales</title>
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/font-awesome-animation.css" rel="stylesheet" />
    <link href="assets/css/simplePagination.css" rel="stylesheet" />
    <link href="assets/css/style2.css" rel="stylesheet" />
    <link href="assets/css/select2.min.css" rel="stylesheet" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />
</head>
<body>
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav nav-pills" style="display:left;">
                    <li><a href="index.php">ITEMS</a></li>
                    <li><a href="purchase.php">PURCHASE</a></li>
                    <li class="active"><a href="sales.php">SALES</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                </ul>
            </div>
        </div>
    </div>
    <br><br>
    <div class="container" style="">
    <div class="" style="height:25px; width:100%;">
        <?php
            include('connect.php');
            if(isset($_POST['save'])) {
                $header_date = $_POST['so_date'];
                $header_customer = $_POST['customer'];
                $header_address = $_POST['address'];
                $header_total = $_POST['grndttl_val'];
                $header_cash = $_POST['grndttl_cash'];
                $header_change = $_POST['grndttl_change'];
                $details_itemid = $_POST['details_itemid'];
                $details_qty = $_POST['details_qty'];
                $details_unit_price = $_POST['details_unit_price'];
                $details_total = $_POST['details_total'];
                $count = count($details_itemid);

                $sql2 = "INSERT INTO sale_headers(customer_name,address,so_date,total,cash,change_amount)
                VALUES
                ('$header_customer','$header_address','$header_date','$header_total','$header_cash','$header_change')";
                mysql_query($sql2);
                $res =  mysql_insert_id();

                if($count > 0){
                    for($i=0;$i<$count;$i++){
                        $sql = " INSERT INTO sale_details(so_id,item_id,qty,price,total)
                        VALUES
                        ('$res','$details_itemid[$i]','$details_qty[$i]','$details_unit_price[$i]','$details_total[$i]')";
                        mysql_query($sql);

                        mysql_query("UPDATE inventories SET qoh=qoh-'$details_qty[$i]' WHERE id='$details_itemid[$i]'");
                    }
                    echo "<div class='alert alert-success'>
                          <strong>Success!</strong> Sales successfully added.
                        </div>";
                }
                else{
                    echo "<div class='alert alert-danger'>
                              <strong>Danger!</strong> Empty! Please try again.
                            </div>";
                }
            }
         ?>
         </div>
     <h5 style="margin-top:3%;">Create New Sales.</h5>
        <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >

            <div class="form-group">
                <label class="control-label col-sm-2">Sold To:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" name="customer" placeholder="Customer" value="">
                </div>
                <label class="control-label col-sm-4"></label>
                <div class="col-sm-2">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Sales Date:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control" id="so_date" name="so_date" value="<?php echo date("Y-m-d");?>">
                </div>
                <label class="control-label col-sm-1">Address</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control"  name="address" placeholder="Address" value="">
                </div>
            </div>
            <div class="container" style="margin-top:10px;">
                <div class="form-group">
                    <div class="control-label col-sm-10">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><a href="#"><i class="fa fa-desktop"></i>&nbsp;&nbsp;Item(s) List</a><a class="subhead"></a></h3>
                            </div>
                            <div class="mainbody panel-body">
                                <table class="maintable table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th width="45%">Item</th>
                                            <th width="15%">Qty</th>
                                            <th width="20%">Price</th>
                                            <th width="20%">Total</th>
                                            <th width="5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <select class="itemdesc" name="itemdesc" data-width="100%" style="background-color: #faf2cc;" >
                                                    <option value="" selected="selected">Search ...</option>
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="qty form-control" id="qty" placeholder="0.00" value="0.00" style="text-align:right;" onkeypress="return isNumberKey(event, this);" tabindex="2">
                                            </td>
                                            <td>
                                                <input type="text" class="unit_price form-control"  value="0.00" style="text-align:right;" readonly="" onkeypress="return isNumberKey(event, this);" tabindex="5">
                                            </td>
                                            <td>
                                                <input type="text" class="total form-control" id="disc" value="0.00" style="text-align:right;" onkeypress="return isNumberKey(event, this);" tabindex="5"  readonly>
                                            </td>
                                            <td>
                                                <a href="" id="add" class="add" tabindex="7"><i class="fa fa-plus-circle fa-2x"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody class="subcontent"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <div class="form-horizontal" style="margin-left:8%;">
        <div class="form-group">
          <label class="control-label col-sm-1"><strong>Total:</strong></label>
            <div class="col-sm-2 grandtotal">
                <input type="text" class="grndttl_val form-control" name="grndttl_val"  value="0.00" style="text-align:right;" readonly="">
            </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-1"><strong>Cash:</strong></label>
            <div class="col-sm-2 grandcash">
                <input type="text" class="grndttl_cash form-control" name="grndttl_cash"  value="0.00" style="text-align:right;" required>
            </div>
        </div>
        <div class="form-group">
          <label class="control-label col-sm-1"><strong>Change:</strong></label>
            <div class="col-sm-2 grandchange">
                <input type="text" class="grndttl_change form-control" name="grndttl_change" value="0.00" style="text-align:right;" readonly="">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button class="btn btn-lg btn-primary btn-sm save" type="submit" name="save"  style="font-weight:200;border-radius:2px solid;"><img src="assets/img/save1.png">&nbsp;Save</button>
    </div>
     </form>
    <br><br><br>
    <footer class="footer">
        <nav class="navbar navbar-inverse navbar-fixed-bottom">
           <label style="font-size:60%;margin-left:1%; color:#ffffff;"> 2015 esmeromichael@yahoo.com | All Right Reserved  | Published by <a href="#"></a>M.E </label>
        </nav>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/simplePagination.js"></script>
    <script type="text/javascript">
        $( "#so_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
        $.getJSON('getitems.php', function(data){
                data = $.map(data, function(items) {
                return {id: items.id, text: items.item_name };
                });
                $(".itemdesc").select2({
                    minimumInputLength: 1,
                    multiple: false,
                    data: data
                });
            });

        $('.itemdesc').on('change',function(e){
            var id = e.target.value;
            $.get('selecteditems2.php?id=' + id, function(data){
                $.each(data, function(index, item){
                    if(item.qoh > 0){
                        $('.qty').val("0.00");
                        $('.unit_price').val("0.00")
                        $('.total').val("0.00");
                        $('.unit_price').val(item.item_cost);
                        return true;
                    }
                    else{
                        alert('Out of stock');
                        return false;
                    }
                })
            })
        })

        $('.qty').on('keyup',function(e){
            var price = $('.unit_price').val();
            var qty = $(this).val();
            var total = 0;
            var totalamt = 0;
            total = qty * price;
            totalamt = total.toFixed(2);
            $('.total').val(totalamt);
        })
        $('.qty').on('change',function(e){
            var $this = $(this);
            $this.val(parseFloat($this.val()).toFixed(2));
        })

        $('.add').on('click',function() {
                var itemdesctext = $(".itemdesc option:selected").text();
                var itemdescid = $(".itemdesc option:selected").val();
                var qty =  $(".qty").val();
                var unit_price =  $('.unit_price').val();
                var total =  $('.total').val();

                if(!$('.itemdesc').val()){
                    alert('Please select items');
                    return false;
                }
                else if($('.qty').val() == "0.00"){
                    alert('Please fill quantity');
                    return false;
                }
                else{
                    $('tbody.subcontent').append('<tr>\
                                    <td>\
                                        <input type="hidden" name="details_itemid[]" class="details_itemid" value="'+itemdescid+'" style="">\
                                        <label style="" class="">'+itemdesctext+'</label> \
                                    </td>\
                                    <td>\
                                        <input type="text" class="details_qty form-control" name="details_qty[]" value="'+qty+'" style="text-align:right;" onkeypress="return isNumberKey(event, this);">\
                                    </td>\
                                    <td>\
                                        <input type="text" class="form-control details_unit_price"  name="details_unit_price[]" value="'+unit_price+'" style="text-align:right;" onkeypress="return isNumberKey(event, this);">\
                                    </td>\
                                    <td>\
                                        <input type="text" class="form-control details_total"  name="details_total[]" value="'+total+'" style="text-align:right;" readonly>\
                                    </td>\
                                    <td>\
                                        <a href="" class="btnDelete1 fa fa-trash-o fa-lg" style=""></a> \
                                    </td>\
                                    </tr>')
                    $('.qty').val("0.00");
                    $('.unit_price').val("0.00");
                    $('.total').val("0.00");
                    $('.itemdesc').select2("val", null);
                    grandtotal();
                    return false;
                }
            });

            function grandtotal(){
              var total = 0;
              var grandtotal = 0;
                $('.details_total').each(function() {
                    var q = $(this).val();
                    total += parseFloat(q)
                    grandtotal = total.toFixed(2);
                });
                $('div.grandtotal .grndttl_val').val(grandtotal);
            }

            $('tbody.subcontent').on('click','.btnDelete1',function(){
                $(this).parent().parent().remove();
                grandtotal();
                return false;
            })

            $('.grndttl_cash').on('keyup',function(){
                var cash = $(this).val();
                var total = $('.grndttl_val').val();
                var totalamount = 0;
                var totalamount2 = 0;
                totalamount = cash - total;
                totalamount2 = totalamount.toFixed(2);
                $('.grndttl_change').val(totalamount2);
            })

            $('.grndttl_cash').on('change',function(){
                var $this = $(this);
                $this.val(parseFloat($this.val()).toFixed(2));
            })

            $('.save').on('click',function(){
            var rowCount = $('.subcontent tr').length;
            if(rowCount > 0){
                if($('.grndttl_cash').val() == "0.00"){
                    alert('Please pay your amount!');
                    return false;
                }
                return true;
            }
            else{
                alert('Has no items. Please select items to be save.');
                return false;
            }
        })
    </script>
</body>
</html>