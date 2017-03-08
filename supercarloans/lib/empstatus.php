<?php
class EmpStatus extends BaseClass
{
	
	public $Id;
	public $StatusText;
	public $Status;
	
	
	
  	public function loadEmpStatus($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tblempstatus WHERE Id = " . $Id . " AND Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->StatusText = $row['StatusText'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
	public function addEmpStatus() 
	{
			$SQL = " INSERT INTO tblempstatus 
				SET 
					StatusText = '" . $this->StatusText . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateEmpStatus($Id) 
	{
		$SQL = " UPDATE tblempstatus 
			SET 
					StatusText = '" . $this->StatusText . "', 
					Status = " . $this->Status . "
			";
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}


	public function loadAllEmpStatus() 
  	{
		
				
		$SQL = "SELECT * FROM tblempstatus WHERE Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}
	

	public function getStatusText($Id)
	{
		$SQL = "SELECT * FROM tblempstatus Where Id=".$Id;
		
		parent::GetDALInstance()->SQLQuery($SQL);

            $row = parent::GetDALInstance()->GetRow(false);
            return $row['StatusText'];

           return false;
	}
	
}
?>