<?php
class Frequency extends BaseClass
{
	
	public $Id;
	public $Frequency;
	public $Status;
	
	
	
  	public function loadFrequency($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tblfrequency WHERE Id = " . $Id . " AND Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->Frequency = $row['Frequency'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
	public function addFrequency() 
	{
			$SQL = " INSERT INTO tblfrequency 
				SET Id = '" . $this->Id . "', 
					Frequency = '" . $this->Frequency . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateFrequency($Id) 
	{
		$SQL = " UPDATE tblfrequency 
			SET Id = '" . $this->Id . "', 
					Frequency = '" . $this->Frequency . "', 
					Status = " . $this->Status . "
			";
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}


	public function loadAllFrequency() 
  	{
		
				
		$SQL = "SELECT * FROM tblfrequency WHERE Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}
	
	public function getFrequency($Id)
	{
		$SQL = "SELECT * FROM tblfrequency Where Id=".$Id;
		
		parent::GetDALInstance()->SQLQuery($SQL);

            $row = parent::GetDALInstance()->GetRow(false);
            return $row['Frequency'];

           return false;
	}
	
}
?>