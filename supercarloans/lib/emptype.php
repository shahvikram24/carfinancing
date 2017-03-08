<?php
class EmpType extends BaseClass
{
	
	public $Id;
	public $Type;
	public $Status;
	
	
	
  	public function loadEmpType($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tblemptype WHERE Id = " . $Id . " AND Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->Type = $row['Type'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
	public function addEmpType() 
	{
			$SQL = " INSERT INTO tblemptype 
				SET 
					Type = '" . $this->Type . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateEmpType($Id) 
	{
		$SQL = " UPDATE tblemptype 
			SET 
					Type = '" . $this->Type . "', 
					Status = " . $this->Status . "
			";
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}

	public function loadAllEmpType() 
  	{
		
				
		$SQL = "SELECT * FROM tblemptype WHERE Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}
	
	public function getType($Id)
	{
		$SQL = "SELECT * FROM tblemptype Where Id=".$Id;
		
		parent::GetDALInstance()->SQLQuery($SQL);

            $row = parent::GetDALInstance()->GetRow(false);
            return $row['Type'];

           return false;
	}
}
?>