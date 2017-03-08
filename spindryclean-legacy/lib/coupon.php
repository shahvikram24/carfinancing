<?php
class Coupon extends BaseClass{
	public $Id;
	public $Name;
	public $Code;
	public $Type;
	public $Discount;
	public $Total;
	public $DateStart;
	public $DateEnd;
	public $DateAdded;
	public $Status;


			/*
					Status = 0 :	Archived
					Status = 1 :	Active / Enabled
					Status = 2 :	Disabled

			*/

	public function __construct()
	{
		$Total = 0;
	}

	public function loadcoupon($Condition = '')
	{
		
				
		$SQL = "SELECT * FROM tblcoupon ";

		if($Condition) 
			$SQL .= " WHERE " . $Condition;
		

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->Id = $row['Id'];
				$this->Name = $row['Name'];
				$this->Code = $row['Code'];
				$this->Type = $row['Type'];
				$this->Discount = $row['Discount'];
				$this->Total = $row['Total'];
				$this->DateStart = $row['DateStart'];
				$this->DateEnd = $row['DateEnd'];
				$this->DateAdded = $row['DateAdded'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}

	public function addCoupon() 
	{
  		$SQL = " INSERT INTO tblcoupon 
				SET 
					Name = '" . $this->Name . "', 
					Code = '" . $this->Code . "', 
					Type = '" . $this->Type . "', 
					Discount = " . $this->Discount . ", 
					Total = " . $this->Total . ", 
					DateStart = '" . $this->DateStart . "', 
					DateEnd = '" . $this->DateEnd . "', 
					DateAdded = '" . $this->DateAdded . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}

	public function updateCoupon() 
	{
  		$SQL = " UPDATE tblcoupon 
				SET 
					Name = '" . $this->Name . "', 
					Code = '" . $this->Code . "', 
					Type = '" . $this->Type . "', 
					Discount = " . $this->Discount . ", 
					Total = " . $this->Total . ", 
					DateStart = '" . $this->DateStart . "', 
					DateEnd = '" . $this->DateEnd . "', 
					DateAdded = '" . $this->DateAdded . "', 
					Status = " . $this->Status ." 
					WHERE Id=".$this->Id;
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			return parent::GetDALInstance()->SQLQuery($SQL);
	}

	public function GetCouponList()
		{
			
				$SQL = "SELECT * FROM tblcoupon C
						WHERE C.Status IN (1,2) 
						Order By DateStart
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

	public function archiveCoupon($IdArray) 
	{
  		$SQL = " UPDATE tblcoupon 
				SET 
					Status = 0 
				WHERE Id IN (" . $IdArray . ")

			";
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
		return parent::GetDALInstance()->SQLQuery($SQL);
	}


}