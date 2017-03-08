<?php
class Mortgage extends BaseClass
{
	
	public $Id;
	public $MortgageType='';
	public $MortgagePayment=0.00;
	public $MortgageAmount=0.00;
	public $MortgageHolder='';
	public $MarketValue=0.00;
	public $Timestamp;
	public $Status=0;
	
	
	
  	public function loadMortgage($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tblmortgage WHERE Id = " . $Id . " AND Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->MortgageType = $row['MortgageType'];
				$this->MortgagePayment = $row['MortgagePayment'];
				$this->MortgageAmount = $row['MortgageAmount'];
				$this->MortgageHolder = $row['MortgageHolder'];
				$this->MarketValue = $row['MarketValue'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
	public function addMortgage() 
	{
			$SQL = " INSERT INTO tblmortgage 
				SET 
					MortgageType = " . $this->MortgageType . ", 
					MortgagePayment = " . $this->MortgagePayment . ", 
					MortgageAmount = " . $this->MortgageAmount . ", 
					MortgageHolder = '" . $this->MortgageHolder . "', 
					MarketValue = " . $this->MarketValue . ", 
					
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateMortgage($Id) 
	{
		$SQL = " UPDATE tblmortgage 
			SET 
					MortgageType = " . $this->MortgageType . ", 
					MortgagePayment = " . $this->MortgagePayment . ", 
					MortgageAmount = " . $this->MortgageAmount . ", 
					MortgageHolder = '" . $this->MortgageHolder . "', 
					MarketValue = " . $this->MarketValue . ", 
					
					Status = " . $this->Status . "
					";
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}

	public function loadAllMortgage() 
  	{
		
				
		$SQL = "SELECT * FROM tblmortgage WHERE Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}
	
	
}
?>