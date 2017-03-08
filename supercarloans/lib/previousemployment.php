<?php
class PreviousEmployment extends BaseClass
{
	
	public $Id;
	public $Name = '';
	public $PrevEmpYears ='';
	public $PrevEmpMonths ='';
	public $Timestamp;
	public $Status=0;
	
	
	
  	public function loadPreviousEmployment($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tblpreviousemployment WHERE Id = " . $Id . " AND Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->Name = $row['Name'];
				$this->PrevEmpYears = $row['PrevEmpYears'];
				$this->PrevEmpMonths = $row['PrevEmpMonths'];
				
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
	public function addPreviousEmployment() 
	{
			$SQL = " INSERT INTO tblpreviousemployment 
				SET 
					Name = '" . $this->Name . "', 
					PrevEmpYears = '" . $this->PrevEmpYears . "', 
					PrevEmpMonths = '" . $this->PrevEmpMonths . "', 
					
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updatePreviousEmployment($Id) 
	{
		$SQL = " UPDATE tblpreviousemployment 
			SET 
					Name = '" . $this->Name . "', 
					PrevEmpYears = '" . $this->PrevEmpYears . "', 
					PrevEmpMonths = '" . $this->PrevEmpMonths . "', 
					
					Status = " . $this->Status . "
					";
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}

	public function loadAllPreviousEmployment() 
  	{
		
				
		$SQL = "SELECT * FROM tblpreviousemployment WHERE Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}
	
	
}
?>