<?php
class DealStatus extends BaseClass
{
	
	public $Id;
	public $StatusText;
	public $Status;
	
	
	
  	public function loadDealStatus($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tbldealstatus WHERE Id = " . $Id . " AND Status = 1  ";

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
		
		
	public function addDealStatus() 
	{
			$SQL = " INSERT INTO tbldealstatus 
				SET 
					StatusText = '" . $this->StatusText . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateDealStatus($Id) 
	{
		$SQL = " UPDATE tbldealstatus 
			SET 
					StatusText = '" . $this->StatusText . "', 
					Status = " . $this->Status . "
			";
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}


	public function loadAllDealStatus() 
  	{
		
				
		$SQL = "SELECT * FROM tbldealstatus WHERE Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}
	

	public function getStatusText($Id)
	{
		$SQL = "SELECT * FROM tbldealstatus Where Id=".$Id;
		
		parent::GetDALInstance()->SQLQuery($SQL);

            $row = parent::GetDALInstance()->GetRow(false);
            return $row['StatusText'];

           return false;
	}
	
	public function getStatusId($Id)
	{
		$SQL = "SELECT * FROM tbldealstatus Where Id=".$Id;
		
		parent::GetDALInstance()->SQLQuery($SQL);

            $row = parent::GetDALInstance()->GetRow(false);
            return $row['Id'];

           return false;
	}
}
?>