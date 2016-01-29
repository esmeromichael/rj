<?php
include('connect.php');
include('session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Purchase</title>
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
                    <li class="active"><a href="purchase.php">PURCHASE</a></li>
                    <li><a href="sales.php">SALES</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>

                </ul>
            </div>
        </div>
    </div>
    <br><br>
    <div class="container">
    <div class="" style="height:20px; width:100%;">
        <?php

            $con=mysql_connect("localhost","root","");
            if(isset($_POST['save'])) {
                $header_date = $_POST['po_date'];
                $header_supplier_id = $_POST['supplier_id'];
                $header_doc_no = $_POST['doc_no'];
                $header_remarks = $_POST['remarks'];
                $header_total = $_POST['grndttl_val'];

                $details_itemid = $_POST['details_itemid'];
                $details_qty = $_POST['details_qty'];
                $details_date_manufactured = $_POST['details_date_manufactured'];
                $details_date_expired = $_POST['details_date_expired'];
                $details_unit_price = $_POST['details_unit_price'];
                $details_total = $_POST['details_total'];
                $count = count($details_itemid);

                $sql2 = "INSERT INTO purchase_headers(supplier_id,po_date,remarks,total_amt,doc_no)VALUES
                        ('$header_supplier_id','$header_date','$header_remarks','$header_total','$header_doc_no')";
                mysql_query($sql2,$con);

                $res =  mysql_insert_id();

                if($count > 0){
                    for($i=0;$i<$count;$i++){
                        $sql = " INSERT INTO purchase_details(po_id,item_id,qty,date_manufactured,date_expired,unit_price,total)
                        VALUES
                        ('$res','$details_itemid[$i]','$details_qty[$i]','$details_date_manufactured[$i]','$details_date_expired[$i]','$details_unit_price[$i]','$details_total[$i]')";
                        mysql_query($sql,$con);

                        mysql_query("UPDATE inventories SET qoh=qoh+'$details_qty[$i]',item_cost='$details_unit_price[$i]' WHERE id='$details_itemid[$i]'");
                        mysql_query("UPDATE items SET item_cost='$details_unit_price[$i]' WHERE id='$details_itemid[$i]'");
                    }
                    echo "<div class='alert alert-success'>
                          <strong>Success!</strong> Purchase successfully added.
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
         <form class="form-horizontal" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" >
         <h5 style="margin-top:3%;">Create New Purchase.</h5>
            <div class="form-group">
                <label class="control-label col-sm-2">PO No:</label>
                <div class="col-sm-2">
                    <input type="text" readonly class="form-control" name="pr_no" placeholder="New">
                </div>
                <label class="control-label col-sm-4"></label>
                <div class="col-sm-2">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Supplier:</label>
                <div class="col-sm-3">
                   <select class="supplier" data-width="100%" style=""  name="supplier_id" required tabindex="1">
                    <option value="" selected="selected">Search ...</option>
                </select>
                </div>
                <label class="control-label col-sm-1">PO Date</label>
                <div class="col-sm-2">
                    <input type="text" class="form-control" id="pr_date" name="po_date" value="<?php echo date("Y-m-d");?>">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Document No:</label>
                <div class="col-sm-3">
                    <input type="text" class="form-control"  name="doc_no"  tabindex="4">
                </div>
                <label class="control-label col-sm-4"></label>
                <div class="col-sm-2">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Remarks:</label>
                <div class="col-sm-6">
                    <input type="text" class="form-control"  name="remarks"  tabindex="4">
                </div>
                <label class="control-label col-sm-4"></label>
                <div class="col-sm-2">
                </div>
            </div>

            <fieldset class="form-horizontal">
                <legend align="left"><b>Order Items</b></legend>
                    <table class="table" style="width:100%;">
                        <thead>
                            <tr>
                                <th width="24.6%" style="text-align: center;">Item Description</th>
                                <th width="9%" style="text-align: center;">Qty</th>
                                <th width="9%" style="text-align: center;">Date Manufactured</th>
                                <th width="9%" style="text-align: center;">Date Expired</th>
                                <th width="9%" style="text-align: center;">Unit Price</th>
                                <th width="9%" style="text-align: center;">Total</th>
                                <th width="3%" style="text-align: center;"></th>
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
                                    <input type="text" class="form-control datepicker date_manufactured" value="" name="date_manufactured" >
                                </td>
                                <td>
                                    <input type="text" class="form-control datepicker2 date_expired" value="" name="date_expired" >
                                </td>
                                <td>
                                    <input type="text" class="unit_price form-control"  value="0.00" style="text-align:right;" onkeypress="return isNumberKey(event, this);" tabindex="5">
                                </td>
                                <td>
                                   <input type="text" class="total form-control" id="disc" value="0.00" style="text-align:right;" onkeypress="return isNumberKey(event, this);" tabindex="5"  readonly>
                                </td>
                                <td>
                                    <a href="" id="add" class="add" tabindex="7"><i class="fa fa-plus-circle fa-2x"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
            </fieldset>
            <fieldset class="form-horizontal" style="margin-left:-14px;">
                <div class="tab-content">
                    <div class="tab-pane active" id="tab1" style="">
                        <table class="subsortsortable table" style="width:100%">
                             <tbody class="subcontent"></tbody>
                        </table>
                    </div>
                </div>
            </fieldset>
            <div class="form-horizontal">
                <div class="form-group">
                  <label class="control-label col-sm-10"><strong>Total:</strong></label>
                    <div class="col-sm-2 grandtotal">
                        <label class="form-control col-sm-2 grndttl" style="text-align:right; font-weight: bold;" value="0.00"><strong>0.00</strong></label>
                        <input type="hidden" class="grndttl_val form-control" name="grndttl_val" id="disc" value="0.00" style="text-align:right;">
                    </div>
                </div>
            </div>
             <div class="modal-footer">
                <button class="btn btn-lg btn-primary btn-sm save" type="submit" name="save"  style="font-weight:200;border-radius:2px solid;"><img src="assets/img/save1.png">&nbsp;Save</button>
            </div>
        </form>
    </div>
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
        $('.save').on('click',function(){
            var rowCount = $('.subsortsortable tr').length;
            if(rowCount > 0){
                return true;
            }
            else{
                alert('Has no items. Please select items to be save.');
                return false;
            }
        })
            function grandtotal(){
              var total = 0;
              var grandtotal = 0;
                $('.details_total').each(function() {
                    var q = $(this).val();
                    total += parseFloat(q)
                    grandtotal = total.toFixed(2);
                });
                $('div.grandtotal .grndttl').text(grandtotal);
                $('div.grandtotal .grndttl_val').val(grandtotal);
            }

            $( "#pr_date" ).datepicker({ dateFormat: 'yy-mm-dd' });

            $(".datepicker").datepicker({
                dateFormat: "MM d, yy",
                yearRange: "1950:2050",
                changeYear: true,
                changeMonth: true,
            });

            $(".datepicker2").datepicker({
                dateFormat: "MM d, yy",
                yearRange: "1950:2050",
                changeYear: true,
                changeMonth: true,
            });

            $(".details_date_manufactured").datepicker({
                dateFormat: "MM d, yy",
                yearRange: "1950:2050",
                changeYear: true,
                changeMonth: true,
            });

            $(".details_date_expired").datepicker({
                dateFormat: "MM d, yy",
                yearRange: "1950:2050",
                changeYear: true,
                changeMonth: true,
            });

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

            $.getJSON('suppliers.php', function(data){
                data = $.map(data, function(items) {
                return {id: items.id, text: items.name };
                });
                $(".supplier").select2({
                    minimumInputLength: 1,
                    multiple: false,
                    data: data
                });
            });

            $('.itemdesc').on('change',function(e){
                var id = e.target.value;
                $.get('selectitems.php?id=' + id, function(data){
                    $.each(data, function(index, item){
                        $('.qty').val("0.00");
                        $('.date_manufactured').empty()
                        $('.date_expired').empty();
                        $('.unit_price').val("0.00");
                        $('.total').val("0.00");
                        $('.date_manufactured').val(item.date_manufactured);
                        $('.date_expired').val(item.date_expired);
                    })
                })
            })

            $('.add').on('click',function() {
                var itemdesctext = $(".itemdesc option:selected").text();
                var itemdescid = $(".itemdesc option:selected").val();
                var qty =  $(".qty").val();
                var date_manu = $('.date_manufactured').val();
                var date_exp = $('.date_expired').val();
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
                                    <td width="24.6%">\
                                        <input type="hidden" name="details_itemid[]" class="details_itemid" value="'+itemdescid+'" style="">\
                                        <label style="" class="">'+itemdesctext+'</label> \
                                    </td>\
                                    <td width="9%">\
                                        <input type="text" class="details_qty form-control" name="details_qty[]" value="'+qty+'" style="text-align:right;" onkeypress="return isNumberKey(event, this);">\
                                    </td>\
                                    <td width="9%">\
                                        <input type="text" class="form-control  details_date_manufactured" value="'+date_manu+'" name="details_date_manufactured[]" >\
                                    </td>\
                                    <td width="9%">\
                                        <input type="text" class="form-control  details_date_expired"  name="details_date_expired[]" value="'+date_exp+'">\
                                    </td>\
                                    <td width="9%">\
                                        <input type="text" class="form-control details_unit_price"  name="details_unit_price[]" value="'+unit_price+'" style="text-align:right;" onkeypress="return isNumberKey(event, this);">\
                                    </td>\
                                    <td width="9%">\
                                        <input type="text" class="form-control details_total"  name="details_total[]" value="'+total+'" style="text-align:right;" readonly>\
                                    </td>\
                                    <td width="3%">\
                                        <a href="" class="btnDelete1 fa fa-trash-o fa-lg" style=""></a> \
                                    </td>\
                                    </tr>')
                    $('.qty').val("0.00");
                    $('.date_manufactured').val('0000-00-00');
                    $('.date_expired').val('0000-00-00');
                    $('.unit_price').val("0.00");
                    $('.total').val("0.00");
                    $('.itemdesc').select2("val", null);
                    grandtotal();
                    $(".details_date_manufactured").datepicker({
                        dateFormat: "MM d, yy",
                        yearRange: "1950:2050",
                        changeYear: true,
                        changeMonth: true,
                    });

                    $(".details_date_expired").datepicker({
                        dateFormat: "MM d, yy",
                        yearRange: "1950:2050",
                        changeYear: true,
                        changeMonth: true,
                    });
                    return false;
                }

            });

            $('tbody.subcontent').on('click','.btnDelete1',function(){
                $(this).parent().parent().remove();
                grandtotal();
                return false;
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

            $('.unit_price').on('keyup',function(e){
                var price = $(this).val();
                var qty =  $('.qty').val();

                var total = 0;
                var totalamt = 0;
                total = qty * price;
                totalamt = total.toFixed(2);
                $('.total').val(totalamt);
            })

            $('.unit_price').on('change',function(e){
                var $this = $(this);
                $this.val(parseFloat($this.val()).toFixed(2));
            })

            $('table.subsortsortable tbody.subcontent').on('keyup','.details_qty',function(e){
                var unit_price = $(this).closest('tr').find(".details_unit_price").val();
                var qty = $(this).val();
                var total = 0;
                var totalamt = 0;
                total = qty * unit_price;
                totalamt = total.toFixed(2);
                $(this).closest('tr').find(".details_total").val(totalamt);
            })

            $('table.subsortsortable tbody.subcontent').on('change','.details_qty',function(e){
                var $this = $(this);
                $this.val(parseFloat($this.val()).toFixed(2));
            })

            $('table.subsortsortable tbody.subcontent').on('keyup','.details_unit_price',function(e){
                var qty = $(this).closest('tr').find(".details_qty").val();
                var unit_price = $(this).val();
                var total = 0;
                var totalamt = 0;
                total = qty * unit_price;
                totalamt = total.toFixed(2);
                $(this).closest('tr').find(".details_total").val(totalamt);
            })

            $('table.subsortsortable tbody.subcontent').on('change','.details_unit_price',function(e){
                var $this = $(this);
                $this.val(parseFloat($this.val()).toFixed(2));
            })

            function isNumberKey(evt, element){
                var charCode = (evt.which) ? evt.which : event.keyCode
                if ((charCode != 46 || $(element).val().indexOf('.') != -1) &&
                    (charCode < 48 || charCode > 57))
                    return false;
                return true;
            }

        </script>
</body>
</html>
