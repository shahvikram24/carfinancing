<?php
class TblMail extends BaseClass
{
	
	public $Id;
	public $ContactInfoId;
	public $TemplateId;
	public $DateSent;
	public $Status;
	
	
	
  	public function loadMail($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tblmail WHERE Id = " . $Id . " AND Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->ContactInfoId = $row['ContactInfoId'];
				$this->TemplateId = $row['TemplateId'];
				$this->DateSent = $row['DateSent'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
	public function addMail() 
	{
			$SQL = " INSERT INTO tblmail 
				SET 
					ContactInfoId = " . $this->ContactInfoId . ", 
					TemplateId = " . $this->TemplateId . ", 
					DateSent = '" . $this->DateSent . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateMail($Id) 
	{
		$SQL = " UPDATE tblmail 
			SET 
					ContactInfoId = " . $this->ContactInfoId . ", 
					TemplateId = " . $this->TemplateId . ", 
					DateSent = '" . $this->DateSent . "', 
					Status = " . $this->Status . "
			";
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}

	public function loadAllMail($Condition = '') 
  	{
		
				
		$SQL = "SELECT * FROM tblmail WHERE Status = 1  ";

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
		$SQL = "SELECT * FROM tblmail Where Id=".$Id;
		
		parent::GetDALInstance()->SQLQuery($SQL);

            $row = parent::GetDALInstance()->GetRow(false);
            return ($row) ? $row[$Column] : false;
	}

	public function loadMailNotification($Condition = '') 
  	{
		
				
		$SQL = "SELECT m.Id as tblMailId, m.DateSent, t.Title, t.FileName, t.Color 
				FROM tblmail m 
				JOIN tbltemplate t ON t.Id = m.TemplateId 

				WHERE m.Status = 1  ";

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
}
?>