<?php
include('connect.php');
$id = $_GET['id'];
$result=mysql_query("select * from items where id='$id'") or die (mysql_error());
    // output data of each row
    while($row = mysql_fetch_array($result)){
        $data[] = $row;
    }
    header('Content-type: json');
		echo json_encode($data, JSON_PRETTY_PRINT);
?>