<?php
class InvoiceProducts extends BaseClass{
	public $Id;
	public $InvoiceId;
	public $ProductName;
	public $Price;
	public $Quantity;
	public $Totalprice;
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

	public function loadInvoiceProducts($Condition = '')
	{
		
				
		$SQL = "SELECT * FROM tblinvoiceproducts ";

		if($Condition) 
			$SQL .= " WHERE " . $Condition;
		

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->Id = $row['Id'];
				$this->InvoiceId = $row['InvoiceId'];
				$this->ProductName = $row['ProductName'];
				$this->Price = $row['Price'];
				$this->Quantity = $row['Quantity'];
				$this->Totalprice = $row['Totalprice'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}

	public function addInvoiceProducts() 
	{
  		$SQL = " INSERT INTO tblinvoiceproducts 
				SET 
					InvoiceId = " . $this->InvoiceId . ", 
					ProductName = '" . $this->ProductName . "' ,
					Price = " . $this->Price . " ,
					Quantity = " . $this->Quantity . " ,
					Totalprice = '" . $this->Totalprice . "' ,
					Status = " . $this->Status . " 
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}

	public function updateInvoiceProducts() 
	{
  		$SQL = " UPDATE tblinvoiceproducts 
				SET 
					InvoiceId = " . $this->InvoiceId . ", 
					ProductName = '" . $this->ProductName . "' ,
					Price = " . $this->Price . " ,
					Quantity = " . $this->Quantity . " ,
					Totalprice = '" . $this->Totalprice . "' ,
					Status = " . $this->Status . " 
					WHERE Id=".$this->Id;
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			return parent::GetDALInstance()->SQLQuery($SQL);
	}

	

	public function archiveInvoiceProducts($IdArray) 
	{
  		$SQL = " UPDATE tblinvoiceproducts 
				SET 
					Status = 0 
				WHERE InvoiceId IN (" . $IdArray . ")

			";
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
		return parent::GetDALInstance()->SQLQuery($SQL);
	}

	public function GetProductsList($InvoiceId)
		{
			
				$SQL = "SELECT *
						FROM tblinvoiceproducts  
						WHERE Status = 1  AND InvoiceId=".$InvoiceId;
						

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

}
