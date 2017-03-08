<?php
class OtherIncomeType extends BaseClass
{
	
	public $Id;
	public $IncomeType;
	public $Status;
	
	
	
  	public function loadOtherIncomeType($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tblotherincometype WHERE Id = " . $Id . " AND Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->IncomeType = $row['IncomeType'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
	public function addOtherIncomeType() 
	{
			$SQL = " INSERT INTO tblotherincometype 
				SET 
					IncomeType = '" . $this->IncomeType . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateOtherIncomeType($Id) 
	{
		$SQL = " UPDATE tblotherincometype 
			SET 
					IncomeType = '" . $this->IncomeType . "', 
					Status = " . $this->Status . "
			";
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}


	public function loadAllOtherIncomeType() 
  	{
		
				
		$SQL = "SELECT * FROM tblotherincometype WHERE Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}
	
	public function getIncomeType($Id)
	{
		$SQL = "SELECT * FROM tblotherincometype Where Id=".$Id;
		
		parent::GetDALInstance()->SQLQuery($SQL);

            $row = parent::GetDALInstance()->GetRow(false);
            return $row['IncomeType'];

           return false;
	}
	
}
?>