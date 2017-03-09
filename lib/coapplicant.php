<?php
class CoApplicant extends BaseClass
{
	
	public $Id;
	public $ContactInfoId = 0;
	public $EmploymentId = 0;
	public $PreviousEmpId = 0;
	public $RelationContactId = 0;
	public $Relation = '';
	public $Timestamp;
	public $Status = 0;

	public $ContactInfoRelation = false;
	public $ContactRelation = false;
	public $EmploymentRelation = false;
	public $PreviousEmpRelation = false;

	
	
	
  	public function loadCoApplicant($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tblcoapplicant WHERE Id = " . $Id . " AND Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->ContactInfoId = $row['ContactInfoId'];
				$this->RelationContactId = $row['RelationContactId'];
				$this->EmploymentId = $row['EmploymentId'];
				$this->PreviousEmpId = $row['PreviousEmpId'];
				$this->Relation = $row['Relation'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				if(NumberCheck($this->ContactInfoId)) {
                    $this->ContactInfoRelation = new ContactInfo();
                    if(!$this->ContactInfoRelation->loadContactInfo($this->ContactInfoId))
                        $this->ContactInfoRelation = false;
                }

                if(NumberCheck($this->RelationContactId)) {
                    $this->ContactRelation = new Contact();
                    if(!$this->ContactRelation->loadContact($this->RelationContactId))
                        $this->ContactRelation = false;
                }

                if(NumberCheck($this->EmploymentId)) {
                    $this->EmploymentRelation = new Employment();
                    if(!$this->EmploymentRelation->loadEmployment($this->EmploymentId))
                        $this->EmploymentRelation = false;
                }

                if(NumberCheck($this->PreviousEmpId)) {
                    $this->PreviousEmpRelation = new PreviousEmployment();
                    if(!$this->PreviousEmpRelation->loadPreviousEmployment($this->PreviousEmpId))
                        $this->PreviousEmpRelation = false;
                }

				return $this;
			}
			return false;

	}
		
		
	public function addCoApplicant() 
	{
			$SQL = " INSERT INTO tblcoapplicant 
				SET 
					ContactInfoId = " . $this->ContactInfoId . ", 
					RelationContactId = " . $this->RelationContactId . ", 
					EmploymentId = " . $this->EmploymentId . ", 
					PreviousEmpId = " . $this->PreviousEmpId . ", 
					Relation = '" . $this->Relation . "', 
					
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateCoApplicant() 
	{
		$SQL = " UPDATE tblcoapplicant 
			SET 
					ContactInfoId = " . $this->ContactInfoId . ", 
					RelationContactId = " . $this->RelationContactId . ", 
					EmploymentId = " . $this->EmploymentId . ", 
					PreviousEmpId = " . $this->PreviousEmpId . ", 
					Relation = '" . $this->Relation . "', 
					Status=".$this->Status. " 

        			WHERE Id=".$this->Id;
		
		echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}


	public function loadAllCoApplicant($GetChildren = false) 
  	{
		
				
		$SQL = "SELECT * FROM tblcoapplicant WHERE Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);

            $Result = parent::GetDALInstance()->GetArray(false);

            if($Result) 
            {
                $ReturnArray = array();
                $ResultLength = count($Result);

                for($x = 0; $x <= $ResultLength - 1; $x++) 
                {
                    $CoApplicant = new CoApplicant();
                    $CoApplicant->Id = $Result[$x]["Id"];
                    $CoApplicant->ContactInfoId = $Result[$x]["ContactInfoId"];                    
                    $CoApplicant->EmploymentId = $Result[$x]["EmploymentId"];
                    $CoApplicant->PreviousEmpId = $Result[$x]["PreviousEmpId"];
                    $CoApplicant->RelationContactId = $Result[$x]["RelationContactId"];
                    $CoApplicant->Relation = $Result[$x]["Relation"];
                    $CoApplicant->Timestamp = $Result[$x]["Timestamp"];
                    $CoApplicant->Status = $Result[$x]["Status"];

                    if(NumberCheck($CoApplicant->ContactInfoId)) 
                    {
                    	$CoApplicant->ContactInfoRelation = new ContactInfo();
                    	if(!$CoApplicant->ContactInfoRelation->loadContactInfo($CoApplicant->ContactInfoId))
                        	$CoApplicant->ContactInfoRelation = false;
               		 }

               		 if(NumberCheck($CoApplicant->RelationContactId)) 
               		 {
	                    $CoApplicant->ContactRelation = new Contact();
	                    if(!$CoApplicant->ContactRelation->loadContact($CoApplicant->RelationContactId))
	                        $CoApplicant->ContactRelation = false;
	                }

	                if(NumberCheck($CoApplicant->EmploymentId)) 
	                {
	                    $CoApplicant->EmploymentRelation = new Employment();
	                    if(!$CoApplicant->EmploymentRelation->loadEmployment($CoApplicant->EmploymentId))
	                        $CoApplicant->EmploymentRelation = false;
	                }

	                if(NumberCheck($CoApplicant->PreviousEmpId)) 
	                {
	                    $CoApplicant->PreviousEmpRelation = new PreviousEmployment();
	                    if(!$CoApplicant->PreviousEmpRelation->loadPreviousEmployment($CoApplicant->PreviousEmpId))
	                        $CoApplicant->PreviousEmpRelation = false;
	                }

               		  $ReturnArray[] = $CoApplicant;
                }
            }
	    
		return false;

	}
	

	public function loadCoApplicantByRelationContactId($RelationContactId) 
  	{
		
				
		$SQL = "SELECT * FROM tblcoapplicant WHERE RelationContactId = " . $RelationContactId . " AND Status = 1  ";

		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->ContactInfoId = $row['ContactInfoId'];
				$this->RelationContactId = $row['RelationContactId'];
				$this->EmploymentId = $row['EmploymentId'];
				$this->PreviousEmpId = $row['PreviousEmpId'];
				$this->Relation = $row['Relation'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				if(NumberCheck($this->ContactInfoId)) {
                    $this->ContactInfoRelation = new ContactInfo();
                    if(!$this->ContactInfoRelation->loadContactInfo($this->ContactInfoId))
                        $this->ContactInfoRelation = false;
                }

                if(NumberCheck($this->RelationContactId)) {
                    $this->ContactRelation = new Contact();
                    if(!$this->ContactRelation->loadContact($this->RelationContactId))
                        $this->ContactRelation = false;
                }

                if(NumberCheck($this->EmploymentId)) {
                    $this->EmploymentRelation = new Employment();
                    if(!$this->EmploymentRelation->loadEmployment($this->EmploymentId))
                        $this->EmploymentRelation = false;
                }

                if(NumberCheck($this->PreviousEmpId)) {
                    $this->PreviousEmpRelation = new PreviousEmployment();
                    if(!$this->PreviousEmpRelation->loadPreviousEmployment($this->PreviousEmpId))
                        $this->PreviousEmpRelation = false;
                }

				return $this;
			}
			return false;

	}
	
}
?>