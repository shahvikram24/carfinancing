<?php

require_once("../include/files.php");
$ResultSet = new ResultSet();


if(!empty($_POST['type'])){
	$type = $_POST['type'];
	$name = $_POST['name_startsWith'];
	$SQL = "SELECT Id, ProductName, Price FROM tblproducts WHERE UPPER(ProductName) LIKE '".strtoupper($name)."%'";
	
	if($ResultSet->LoadResult($SQL))
	{

		$row = array();
		for($x = 0; $x < $ResultSet->TotalResults ; $x++)
		{
            $name = $ResultSet->Result[$x]['Id'].'|'.$ResultSet->Result[$x]['ProductName'].'|'.$ResultSet->Result[$x]['Price'];
			array_push($row, $name);
		}
		
	}	
	echo json_encode($row);exit;
}


