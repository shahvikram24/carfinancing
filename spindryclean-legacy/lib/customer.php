<?php
class Customer extends BaseClass{
	public $Id;
	public $BusinessName;
	public $StripeId = false;
	public $FirstName;
	public $LastName;
	public $Address1;
	public $Address2;
	public $City;
	public $Province;
	public $Postalcode;
	public $Cellphone;
	public $Approved;
	public $CreateDate;
	public $Timestamp;
	public $Status;

	public $CardBrand;
	public $CardLastFour;
	
	
  	public function loadcustomer($Id, $Condition = false) {
		
				
	$SQL = "SELECT * FROM tblcustomer WHERE Id = " . $Id . " AND Status = 1  ";

	if($Condition) 
		$SQL .= " AND Approved IN (1,2) ";
	else
		$SQL .= " AND Approved IN (1) ";

	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);
			
	//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

			if($row)
			{
				$this->Id = $row['Id'];
				$this->BusinessName = $row['BusinessName'];
				$this->StripeId = $row['StripeId'];
				$this->FirstName = $row['FirstName'];
				$this->LastName = $row['LastName'];
				$this->Address1 = $row['Address1'];
				$this->Address2 = $row['Address2'];
				$this->City = $row['City'];
				$this->Province = $row['Province'];
				$this->Postalcode = $row['Postalcode'];
				$this->Cellphone = $row['Cellphone'];
				$this->Approved = $row['Approved'];
				$this->CreateDate = $row['CreateDate'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				$this->CardBrand = $row['CardBrand'];
				$this->CardLastFour = $row['CardLastFour'];
				
				
				
				return $this;
			}
			return false;

		}
		
		
		public function addCustomer() 
		{
      		$SQL = " INSERT INTO tblcustomer 
					SET Id = '" . $this->Id . "', 
						BusinessName = '" . $this->BusinessName . "', 
						StripeId = '" . $this->StripeId . "',	
						FirstName = '" . $this->FirstName . "', 
						LastName = '" . $this->LastName . "', 
						Address1 = '" . $this->Address1 . "', 
						Address2 = '" . $this->Address2 . "', 
						City = '" . $this->City . "', 
						Province = '" . $this->Province . "', 
						Postalcode = '" . $this->Postalcode . "', 
						Cellphone = '" . $this->Cellphone . "', 
						Approved = " . $this->Approved . ", 
						CreateDate = NOW(), 
						Timestamp = null,
						CardBrand = '" . $this->CardBrand . "',  
						CardLastFour = '" . $this->CardLastFour . "', 

						Status = " . $this->Status . "
						";
				//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
				$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
				return $this->Id;
		}
		
		
		public function UpdateCustomer($Id) 
		{
      			$SQL = " UPDATE tblcustomer 
				SET Id = '" . $this->Id . "', 
						BusinessName = '" . $this->BusinessName . "', 
						StripeId = '" . $this->StripeId . "',	
						FirstName = '" . $this->FirstName . "', 
						LastName = '" . $this->LastName . "', 
						Address1 = '" . $this->Address1 . "', 
						Address2 = '" . $this->Address2 . "', 
						City = '" . $this->City . "', 
						Province = '" . $this->Province . "', 
						Postalcode = '" . $this->Postalcode . "', 
						Cellphone = '" . $this->Cellphone . "', 
						Approved = " . $this->Approved . ", 
						CreateDate = '" . $this->CreateDate . "', 
						Timestamp = null, 
						CardBrand = '" . $this->CardBrand . "',  
						CardLastFour = '" . $this->CardLastFour . "', 
						Status = " . $this->Status . "
						
						
						WHERE Id=".$Id;
						
						//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
						
				parent::GetDALInstance()->SQLQuery($SQL);
		        return parent::GetDALInstance()->AffectedRows();
		
		}
  		
	public function GetCustomerList()
		{
			
				$SQL = "SELECT C.*, L.EmailId
						FROM tblcustomer C 
						JOIN tbllogin L ON L.CustomerId=C.Id 
						WHERE C.Status = 1  AND C.Approved = 1
						Order By CreateDate
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

	

	public function GetRejectedCustomerList()
		{
			
				$SQL = "SELECT C.*, L.EmailId
						FROM tblcustomer C 
						JOIN tbllogin L ON L.CustomerId=C.Id 
						WHERE C.Status = 1  AND C.Approved = 3
						Order By CreateDate
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

	public function GetPendingCustomerLsit()
		{
			
				$SQL = "SELECT C.*, L.EmailId
						FROM tblcustomer C 
						JOIN tbllogin L ON L.CustomerId=C.Id
						WHERE C.Status = 1  AND L.Status=0 AND C.Approved = 2
						Order By C.CreateDate
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}
		

	public function loadcustomerCheck($Id) 
	{
		
				
	$SQL = "SELECT * FROM tblcustomer WHERE Id = " . $Id ;
	parent::GetDALInstance()->SQLQuery($SQL);
	$row = parent::GetDALInstance()->GetRow(false);
			

			if($row)
			{
				$this->Id = $row['Id'];
				$this->BusinessName = $row['BusinessName'];
				$this->StripeId = $row['StripeId'];
				$this->FirstName = $row['FirstName'];
				$this->LastName = $row['LastName'];
				$this->Address1 = $row['Address1'];
				$this->Address2 = $row['Address2'];
				$this->City = $row['City'];
				$this->Province = $row['Province'];
				$this->Postalcode = $row['Postalcode'];
				$this->Cellphone = $row['Cellphone'];
				$this->Approved = $row['Approved'];
				$this->CreateDate = $row['CreateDate'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				$this->CardBrand = $row['CardBrand'];
				$this->CardLastFour = $row['CardLastFour'];
				
				
				return $this;
			}
			return false;

	}

	public function getStripeId($Id)
		{
			$SQL = "SELECT IFNULL(StripeId,'') AS StripeId FROM tblcustomer WHERE Id=".$Id;
			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow(false);
			//extract($row);

			//echo "<br/>" . $SQL;
			if($row['StripeId'] == '' )
				return true;
			else
				return false;
		}

	public function getName($Id)
	{
		$SQL = "SELECT FirstName, LastName FROM tblcustomer WHERE Id=".$Id;
		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
		//extract($row);


		if($row)
			return $row['FirstName'] . " " . $row['LastName'];
		else
			return false;
	}

	public function getPhoneNumber($Id)
	{
		$SQL = "SELECT Cellphone FROM tblcustomer WHERE Id=".$Id;
		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
		//extract($row);


		if($row)
			return $row['Cellphone'] ;
		else
			return false;
	}

	public function getCustomerCount($Month)
	{
		$SQL = "SELECT count(*) AS Count FROM tblcustomer 
				WHERE MONTHNAME(CreateDate)='".$Month . "'";
		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
		
		//echo "<br/>" . $SQL;


		if($row)
			return $row['Count'] ;
		else
			return false;
	}
  	
}
?>