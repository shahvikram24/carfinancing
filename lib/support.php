<?php


class Support extends BaseClass{
	public $Id;
	public $AffiliateId;
	public $DealerId;
	public $Subject;
	public $Message;
	public $SupportStatus;
	public $DateAdded;
	public $Status;
	
	
	function __construct()
		{
			parent::__construct();
			$this->SupportStatus = 1;
			$this->DealerId=0;
			$this->AffiliateId = 0;
		}

  	public function loadSupport($Condition = '') {
		
				
	$SQL = "SELECT * FROM tblsupport ";

	if($Condition) 
			$SQL .= " WHERE " . $Condition;

		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
	parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
			if($row)
			{
				$this->Id = $row['Id'];
				$this->AffiliateId = $row['AffiliateId'];
				$this->DealerId = $row['DealerId'];
				$this->Subject = $row['Subject'];
				$this->Message = $row['Message'];
				$this->SupportStatus = $row['SupportStatus'];
				$this->DateAdded = $row['DateAdded'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
		public function addSupport() 
		{
      		$SQL = " INSERT INTO tblsupport 
				SET 
					AffiliateId = " . $this->AffiliateId . ", 
					DealerId = " . $this->DealerId . ", 
					Subject = '" . $this->Subject . "', 
					Message = '" . $this->Message . "', 
					SupportStatus = " . $this->SupportStatus . ", 
					DateAdded = '" . $this->DateAdded . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
		}
		
		
		public function UpdateSupport() 
		{
      			$SQL = " UPDATE tblsupport 
				SET 
					AffiliateId = " . $this->AffiliateId . ", 
					DealerId = " . $this->DealerId . ", 
					Subject = '" . $this->Subject . "', 
					Message = '" . $this->Message . "', 
					SupportStatus = " . $this->SupportStatus . ", 
					DateAdded = '" . $this->DateAdded . "', 
					Status = " . $this->Status . " 
					WHERE Id=".$this->Id;
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			return parent::GetDALInstance()->SQLQuery($SQL);
		
		}

		public function GetSupportList()
		{
			
				$SQL = "SELECT * FROM tblsupport S
						WHERE Status = 1 AND SupportStatus IN (1)  
						Order By DateAdded
						";

					//echo "<br/>" . $SQL;

				$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}

		public function GetTotal($AffiliateId)
		{
			$SQL = "SELECT count(*) AS 'Total' 
					FROM tblsupport 
					WHERE Status = 1 AND SupportStatus IN (1) AND AffiliateId = " . $AffiliateId 
					
			;

			//echo  "\n". $SQL . "\n";

			parent::GetDALInstance()->SQLQuery($SQL);
			$row = parent::GetDALInstance()->GetRow();

			return ($row) ? $row['Total'] : 0;
		}

		public function archiveSupport($IdArray) 
	{
  		$SQL = " UPDATE tblsupport 
				SET 
					Status = 0 
				WHERE Id IN (" . $IdArray . ")

			";
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
		return parent::GetDALInstance()->SQLQuery($SQL);
	}

	public function getSupportCount($Month)
	{
		$SQL = "SELECT count(*) AS Count FROM tblsupport 
				WHERE MONTHNAME(DateAdded)='".$Month . "' AND Status = 1 ";
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