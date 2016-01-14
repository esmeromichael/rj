<?php
include('connect.php');
$result=mysql_query("select inventories.id, inventories.item_name, inventories.brand, categories.id as category_name, categories.name as category_name, inventories.date_manufactured, inventories.date_expired,
					inventories.item_cost, inventories.qoh from inventories left outer join categories on inventories.category = categories.id") or die (mysql_error());
    // output data of each row
    while($row = mysql_fetch_array($result)){
        $data[] = $row;
    }
    header('Content-type: json');
		echo json_encode($data, JSON_PRETTY_PRINT);
?>