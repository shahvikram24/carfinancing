<?php
class Template extends BaseClass
{
	
	public $Id;
	public $Title;
	public $Filename;
	public $Type;
	public $Color;
	public $Status;
	
	
	/*

		Type:	1 = Newsletter
				2 = Incomplete Leads
				3 = Complete leads

	*/
  	public function loadTemplate($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tbltemplate WHERE Id = " . $Id . " AND Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->Title = $row['Title'];
				$this->Filename = $row['Filename'];
				$this->Type = $row['Type'];
				$this->Color = $row['Color'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
	public function addTemplate() 
	{
			$SQL = " INSERT INTO tbltemplate 
				SET 
					Title = '" . $this->Title . "', 
					Filename = '" . $this->Filename . "', 
					Type = " . $this->Type . ", 
					Color = '" . $this->Color . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateTemplate($Id) 
	{
		$SQL = " UPDATE tbltemplate 
			SET 
					Title = '" . $this->Title . "', 
					Filename = '" . $this->Filename . "', 
					Type = " . $this->Type . ", 
					Color = '" . $this->Color . "', 
					Status = " . $this->Status . "
			";
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}

	public function loadAllTemplate($Condition = '') 
  	{
		
				
		$SQL = "SELECT * FROM tbltemplate WHERE Status = 1  ";

		if($Condition !='')
			$SQL .= $Condition;
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}
	
	public function getColumn($Id,$Column)
	{
		$SQL = "SELECT * FROM tbltemplate Where Id=".$Id;
		
		parent::GetDALInstance()->SQLQuery($SQL);

            $row = parent::GetDALInstance()->GetRow(false);
            return ($row) ? $row[$Column] : false;
	}
}
?>