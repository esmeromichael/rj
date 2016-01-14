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
    <title>Home</title>
    <link href="assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="assets/css/font-awesome-animation.css" rel="stylesheet" />
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/jquery-ui.css" rel="stylesheet" />
    <link href="assets/css/simplePagination.css" rel="stylesheet" />
    <link href="assets/css/select2.min.css" rel="stylesheet" />
    <link href="assets/css/select2-bootstrap.min.css" rel="stylesheet" />
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
                <a class="navbar-brand" href="#">RJ GWAPO</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav nav-pills" style="display:left;">
                    <li><a href="index.php">HOME</a></li>
                    <li class="active"><a href="purchase.php">PURCHASE</a></li>
                    <li><a href="Gallery.html">SALES</a></li>
                    <li><a href="logout.php">LOGOUT</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="container" style="margin-top:5%;">
         <form class="form-horizontal" method="POST" action="" >
            <fieldset class="form-horizontal">
          <legend align="left"><b>Order Items</b></legend>
            <div class="">
                <div>
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
                                    <select class="itemdesc form-control" id="itemdesc" name="itemdesc" data-width="100%" style="background-color: #faf2cc;width:295px;" tabindex="1">
                                        <option value="" selected="selected">Search ...</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" class="qty form-control" id="qty" placeholder="0.00" style="text-align:right;" onkeypress="return isNumberKey(event, this);" tabindex="2">
                                </td>
                                <td>
                                    <input type="text" class="form-control datepicker date_manufactured" value="" name="date_manufactured" >
                                </td>
                                <td>
                                    <input type="text" class="form-control datepicker2 date_expired"  name="date_expired" >
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
                </div>
            </div>
        </fieldset>
        <fieldset class="fielddrag" style="margin-left:-14px;">
        <div class="tab-content">
            <div class="tab-pane active" id="tab1" style="">
                <table id="subsortsortable" style="width:100%">
                    <tbody class="content"></tbody>
                </table>
            </div>
        </div>
    </fieldset>
         </form>
    </div>
    <footer class="footer">
        <nav class="navbar navbar-inverse navbar-fixed-bottom">
           <label style="font-size:60%;margin-left:1%;"> 2015 esmeromichael@yahoo.com | All Right Reserved  | Published by <a href="#"></a>M.E </label>
        </nav>
    </footer>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/simplePagination.js"></script>
    <script src="assets/plugins/bootstrap.min.js"></script>
    <script src="assets/js/select2.min.js"></script>
        <script type="text/javascript">
            $( ".datepicker" ).datepicker({
                dateFormat: "MM d, yy",
                yearRange: "1950:2050",
                changeYear: true,
                changeMonth: true,
            });

            $( ".datepicker2" ).datepicker({
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
                        $('.unit_price').val(item.item_cost);
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
                $('tbody.content').append('<tr>\
                                    <td>\
                                        <input type="hidden" name="details_itemid[]" class="details_itemid" value="'+itemdescid+'" style="">\
                                        <label style="" class="">'+itemdesctext+'</label> \
                                    </td>\
                                    <td>\
                                        <input type="text" class="details_qty form-control" name="details_qty[]" value="'+qty+'" style="text-align:right;" onkeypress="return isNumberKey(event, this);">\
                                    </td>\
                                    <td>\
                                        <input type="text" class="form-control _details_datepicker details_date_manufactured" value="'+date_manu+'" name="details_date_manufactured[]" >\
                                    </td>\
                                    <td>\
                                        <input type="text" class="form-control datepicker2 date_expired"  name="date_expired[]" value="'+date_exp+'">\
                                    </td>\
                                    <td>\
                                        <input type="text" class="form-control details_unit_price"  name="details_unit_price[]" value="'+unit_price+'">\
                                    </td>\
                                    <td>\
                                        <input type="text" class="form-control details_total"  name="details_total[]" value="'+total+'">\
                                    </td>\
                                    <td>\
                                        <a href="" class="btnDelete1 fa fa-trash-o fa-lg" style=""></a> \
                                    </td>\
                                    </tr>')
                $('.qty').val("0.00");
                $('.date_manufactured').val('0000-00-00');
                $('.date_expired').val('0000-00-00');
                $('.unit_price').val("0.00");
                $('.total').val("0.00");
                $('.itemdesc').select2("val", null);
                return false;
            });

            $('tbody.content').on('click','.btnDelete1',function(){
                $(this).parent().parent().remove();
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
                var qty =  $('.unit_price').val();
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

            $('.tbody.content').on('change','.details_qty',function(e){
                var unit_price = $(this).closest('tr').find(".details_unit_price").val();
                alert('dggfdsfg')
                var total = 0;
                var totalamt = 0;
                total = qty * price;
                totalamt = total.toFixed(2);
                $('.total').val(totalamt);
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
