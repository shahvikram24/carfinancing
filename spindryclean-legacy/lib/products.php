<?php
class Products extends BaseClass{
	public $Id;
	public $ProductName;
	public $Price;
	public $Status;


			/*
					Status = 0 :	Archived
					Status = 1 :	Active / Enabled
					Status = 2 :	Disabled

			*/

	public function __construct()
	{
		$Status = 1;
	}

	public function loadProducts($Condition = '')
	{
		
				
		$SQL = "SELECT * FROM tblproducts ";

		if($Condition) 
			$SQL .= " WHERE " . $Condition;
		

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->Id = $row['Id'];
				$this->ProductName = $row['ProductName'];
				$this->Price = $row['Price'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}

	public function addProducts() 
	{
  		$SQL = " INSERT INTO tblproducts 
				SET 
					ProductName = '" . $this->ProductName . "', 
					Price = " . $this->Price . ", 
					Status = " . $this->Status . " 
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}

	public function updateProducts() 
	{
  		$SQL = " UPDATE tblproducts 
				SET 
					ProductName = '" . $this->ProductName . "', 
					Price = " . $this->Price . ", 
					Status = " . $this->Status . " 
					WHERE Id=".$this->Id;
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			return parent::GetDALInstance()->SQLQuery($SQL);
	}

	public function GetProductsList()
		{
			
				$SQL = "SELECT * FROM tblproducts P
						WHERE P.Status IN (1) 
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

	public function archiveProducts($IdArray) 
	{
  		$SQL = " UPDATE tblproducts 
				SET 
					Status = 0 
				WHERE Id IN (" . $IdArray . ")

			";
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
		return parent::GetDALInstance()->SQLQuery($SQL);
	}


}