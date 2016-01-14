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
			<div class="nav navbar-nav">
				<ul class="nav nav-pills" style="display:left;">
					<li class="active"><a href="index.php">ITEMS</a></li>
					<li><a href="purchase.php">PURCHASE</a></li>
					<li><a href="Gallery.html">SALES</a></li>
					<li><a href="logout.php">LOGOUT</a></li>
				</ul>
			</div>

			<div class="col-md-3" style="text-align:right;">
				<a class="dropdown-toggle" href="#" data-toggle="modal" data-target="#myModalSaveItems">
				<i class="fa fa-file fa-2x" style="margin-top:5px; color:#ffffff;" title="Create New Price Advice"></i></a>
			</div>
		</div>
	</div>
	<div class="container" style="margin-top:5%;">
		<div class="flash-message">
			<?php
				include('connect.php');
				 if(isset($_POST['submit'])) {
				 	$itemname = $_POST['item_name'];
				 	$brand = $_POST['brand'];
				 	$category = $_POST['category'];
				 	$con=mysql_connect("localhost","root","");
				 	$sql = " INSERT INTO items(item_name,brand,category)VALUES('$itemname','$brand','$category')";
					mysql_query($sql,$con);
					$sql1 = " INSERT INTO inventories(item_name,brand,category)VALUES('$itemname','$brand','$category')";
					mysql_query($sql1,$con);
					echo "<p class='alert-sucess'>Item sucessfully added. </p>";
					echo "<meta http-equiv='refresh' content='0;url=$_SERVER[REQUEST_URL]'>";
				}
				 if(isset($_POST['submit2'])){
					$id = $_POST['id2'];
					$itemname = $_POST['item_name2'];
				 	$brand = $_POST['brand2'];
				 	$category = $_POST['category2'];
				 	$dateman = date('Y-m-d', strtotime($_POST['date_manufactured']));
				 	$dateexp = date('Y-m-d', strtotime($_POST['date_expired']));
				 	$itemcost = $_POST['item_cost'];
				 	mysql_query("UPDATE inventories SET item_name='$itemname',brand='$brand',category='$category',item_cost='$itemcost',date_manufactured='$dateman',date_expired='$dateexp' WHERE id='$id'");
				 	echo "<p class='alert-sucess'>Item sucessfully update. </p>";
					echo "<meta http-equiv='refresh' content='0;url=$_SERVER[REQUEST_URL]'>";
				}
			?>
		</div>
	<h5>This is the Items Tab. Click on the Item ID to view details</h5>
		<table class="items table table-striped table-hover">
			<thead>
				<tr>
					<th width="5%">Item ID</th>
					<th width="34%">Item Name</th>
					<th width="7%">Brand</th>
					<th width="7%">Category</th>
					<th width="15%">Date Manufactured</th>
					<th width="15%">Date Expired</th>
					<th width="5%">Qoh</th>
					<th width="7%">price</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
			<tfoot>
				<div id="page-selection" class="pagination" style="text-align:left; position:fixed; bottom: 60px;width:auto;"></div>
			</tfoot>
			<div class="loading"></div>
		</table>
	</div>
	<footer class="footer">
		<nav class="navbar navbar-inverse navbar-fixed-bottom">
		   <label style="font-size:60%;margin-left:1%;"> 2015 esmeromichael@yahoo.com | All Right Reserved  | Published by <a href="#"></a>M.E </label>
		</nav>
	</footer>
	<!-- This section is for modal function -->
	<div class="modal fade" id="myModalSaveItems" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Create New Item(s)</b></h4>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-body form-horizontal">
                	<div class="form-group">
            		    <label class="col-md-3 control-label">Name</label>
                    	<div class="col-md-6">
                    	    <input type="text" class="form-control" name="item_name" required>
                    	</div>
            		</div>
            		<div class="form-group">
            		    <label class="col-md-3 control-label">Brand</label>
                    	<div class="col-md-6">
                    	    <input type="text" class="form-control" name="brand" required>
                    	</div>
            		</div>
            		<div class="form-group">
            		    <label class="col-md-3 control-label">Category</label>
                    	<div class="col-md-6">
                    	    <select name="category" class="form-control">
                    	    	<?php
								include('connect.php');
								$sql = "SELECT * FROM categories";
								$result = mysql_query($sql);
								while ($row1 = mysql_fetch_array($result))
								{
								 echo "<option value='" . $row1['id'] . "'>" . $row1['name'] . "</option>";
								}
							?>
                    	    </select>
                    	</div>
            		</div>
                </div>
                <div class="modal-footer">
                     <button class="btn btn-lg btn-primary btn-sm" name="submit" type="submit">Save</button>
                </div>
                </form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="myModalUpdateItems" role="dialog" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title"><b>Update Item(s)</b></h4>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <div class="modal-body form-horizontal modal2">
                	<div class="form-group">
            		    <label class="col-md-3 control-label">Name</label>
                    	<div class="col-md-6">
                    		<input type="hidden" class="form-control id2" value="" name="id2" >
                    	    <input type="text" class="form-control item_name2" value="" name="item_name2" >
                    	</div>
            		</div>
            		<div class="form-group">
            		    <label class="col-md-3 control-label">Brand</label>
                    	<div class="col-md-6">
                    	    <input type="text" class="form-control brand2" value="" name="brand2" >
                    	</div>
            		</div>
            		<div class="form-group">
            		    <label class="col-md-3 control-label">Category</label>
                    	<div class="col-md-6">
                    	    <select name="category2" class="form-control category2" value="">
                    	    </select>
                    	</div>
            		</div>
            		<div class="form-group">
            		    <label class="col-md-3 control-label">Date Manufactured</label>
                    	<div class="col-md-6">
                    	    <input type="text" class="form-control datepicker date_manufactured" value="" name="date_manufactured" >
                    	</div>
            		</div>
            		<div class="form-group">
            		    <label class="col-md-3 control-label">Date Expired</label>
                    	<div class="col-md-6">
                    	    <input type="text" class="form-control datepicker2 date_expired"  name="date_expired" >
                    	</div>
            		</div>
            		<div class="form-group">
            		    <label class="col-md-3 control-label">Item Cost</label>
                    	<div class="col-md-6">
                    	    <input type="text" class="form-control item_cost"  name="item_cost" >
                    	</div>
            		</div>
                </div>
                <div class="modal-footer">
                     <button class="btn btn-lg btn-primary btn-sm" name="submit2" type="submit">Update</button>
                </div>
                </form>
			</div>
		</div>
	</div>
	<script src="assets/js/jquery-ui.min.js"></script>
	<script src="assets/js/jquery-ui.js"></script>
	<script src="assets/js/jquery-1.10.2.js"></script>
	<script src="assets/js/simplePagination.js"></script>
	<script src="assets/plugins/bootstrap.min.js"></script>
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

			$('.loading').show();
			$.getJSON('displayitems.php', function(data){
			$('table.items tbody').empty();
			$.each(data, function(key, value){
				function pad (str, max) {
					str = str.toString();
					return str.length < max ? pad("0" + str, max) : str;
				}
				$('table.items tbody').append('<tr> \
						<td> <a class="updateItems dropdown-toggle" href="#" data-toggle="modal" data-target="#myModalUpdateItems" data-name="'+value.item_name+'" data-brand="'+value.brand+'" data-category="'+value.category+'" data-id="'+value.id+'" data-datemanu="'+value.date_manufactured+'" data-dateexpired="'+value.date_expired+'" data-itemcost="'+value.item_cost+'">'+pad(value.id,8)+'</a></td> \
						<td class="cuts">'+value.item_name+'</td> \
						<td>'+value.brand+'</td> \
						<td>'+value.category_name+'</td> \
						<td class="cuts">'+value.date_manufactured+'</td> \
						<td class="cuts">'+value.date_expired+'</td> \
						<td>'+value.qoh+'</td> \
						<td class="cuts">'+value.item_cost+'</td> \
					</tr>');
			});
			$('.loading').hide();
			var items = $("table.table tbody tr");
			var numItems = items.length;
			var perPage = 10;
			items.slice(perPage).hide();
			dothings(items, numItems, perPage);
		});

	function dothings(items, numItems, perPage){
		$(".pagination").pagination({
			items: numItems,
			itemsOnPage: perPage,
			cssStyle: "light-theme",
			hrefTextPrefix: '#',
			onPageClick: function(pageNumber) {
				var showFrom = perPage * (pageNumber - 1);
				var showTo = showFrom + perPage;
				items.hide()
					 .slice(showFrom, showTo).show();
			}
		});
	}

	$(document).on("click", ".updateItems", function () {
    	// get data-id attribute of the clicked element
    	var id = $(this).data('id');
    	var item_name = $(this).data('name');
    	var brand = $(this).data('brand');
    	var category =  $(this).data('category');
    	var date_manu = $(this).data('datemanu');
    	var date_expire = $(this).data('dateexpired');
    	var item_cost = $(this).data('itemcost');
    	//populate the textbox
    	$(".id2").val(id);
    	$(".item_name2").val(item_name);
    	$(".brand2").val(brand);
    	$('.category2').empty();
    	$.getJSON('displaycategories.php', function(data){
    		$.each(data, function(key, value){
    			$('.category2').append('<option value="'+value.id+'">'+value.name+'</option>');
    		})
    	})
    	$(".date_manufactured").val(date_manu);
    	$(".date_expired").val(date_expire);
    	$(".item_cost").val(item_cost);
	});

	</script>
</body>
</html>
