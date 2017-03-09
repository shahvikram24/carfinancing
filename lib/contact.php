<?php
class Contact extends BaseClass
{
	
	public $Id;
	public $ContactInfoId =0;
	public $MortgageId=0;
	public $EmploymentId=0;
	public $PreviousEmpId=0;
	public $CreateDate = '';
	public $Timestamp;
	public $Status=0;

	public $ContactInfoRelation = false;
	public $MortgageRelation = false;
	public $EmploymentRelation = false;
	public $PreviousEmpRelation = false;

	function __construct($InstantiateRelations = false) {
        parent::__construct();

        if($InstantiateRelations) {
            $this->ContactInfoRelation = new ContactInfo(true);
            $this->ContactInfoRelation->Status = 1;

             $this->MortgageRelation = new Mortgage();
            $this->MortgageRelation->Status = 1;

            $this->EmploymentRelation = new Employment();
            $this->EmploymentRelation->Status = 1;

             $this->PreviousEmpRelation = new PreviousEmployment();
            $this->PreviousEmpRelation->Status = 1;
            
            $this->CreateDate = date('Y-m-d H:i:s');
        }
    }
	
	
  	public function loadContact($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tblcontact WHERE Id = " . $Id . " AND Status IN (0,1,2)  ";
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->ContactInfoId = $row['ContactInfoId'];
				$this->MortgageId = $row['MortgageId'];
				$this->EmploymentId = $row['EmploymentId'];
				$this->PreviousEmpId = $row['PreviousEmpId'];
				$this->CreateDate = $row['CreateDate'];
				$this->Timestamp = $row['Timestamp'];
				$this->Status = $row['Status'];
				
				if(NumberCheck($this->ContactInfoId)) {
                    $this->ContactInfoRelation = new ContactInfo();
                    if(!$this->ContactInfoRelation->loadContactInfo($this->ContactInfoId))
                        $this->ContactInfoRelation = false;
                }

                if(NumberCheck($this->MortgageId)) {
                    $this->MortgageRelation = new Mortgage();
                    if(!$this->MortgageRelation->loadMortgage($this->MortgageId))
                        $this->MortgageRelation = false;
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
		
		
	public function addContact() 
	{
			$SQL = " INSERT INTO tblcontact 
				SET 
					ContactInfoId = " . $this->ContactInfoId . ", 
					MortgageId = " . $this->MortgageId . ", 
					EmploymentId = " . $this->EmploymentId . ", 
					PreviousEmpId = " . $this->PreviousEmpId . ", 
					CreateDate = '" . $this->CreateDate . "', 
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateContact() 
	{
		
		$SQL = " UPDATE tblcontact 
			SET 
					ContactInfoId = " . $this->ContactInfoId . ", 
					MortgageId = " . $this->MortgageId . ", 
					EmploymentId = " . $this->EmploymentId . ", 
					PreviousEmpId = " . $this->PreviousEmpId . ", 
					CreateDate = '" . $this->CreateDate . "', 
					Status=".$this->Status. " 

        			WHERE Id=".$this->Id;
					;
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}


	public function loadAllContact($GetChildren = false) 
  	{
		
				
		$SQL = "SELECT * FROM tblcontact WHERE Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);

            $Result = parent::GetDALInstance()->GetArray(false);

            if($Result) 
            {
                $ReturnArray = array();
                $ResultLength = count($Result);

                for($x = 0; $x < $ResultLength ; $x++) 
                {
                    $Contact = new Contact();
                    $Contact->Id = $Result[$x]["Id"];
                    $Contact->ContactInfoId = $Result[$x]["ContactInfoId"];
                    $Contact->MortgageId = $Result[$x]["MortgageId"];
                    $Contact->EmploymentId = $Result[$x]["EmploymentId"];
                    $Contact->PreviousEmpId = $Result[$x]["PreviousEmpId"];
                    $Contact->CreateDate = $row['CreateDate'];
                    $Contact->Timestamp = $Result[$x]["Timestamp"];
                    $Contact->Status = $Result[$x]["Status"];


                    if(NumberCheck($Contact->ContactInfoId)) 
                    {
                    	$Contact->ContactInfoRelation = new ContactInfo();
                    	if(!$Contact->ContactInfoRelation->loadContactInfo($Contact->ContactInfoId))
                        	$Contact->ContactInfoRelation = false;
               		 }

               		 

               		 if(NumberCheck($Contact->MortgageId)) 
               		 {
	                    $Contact->MortgageRelation = new Mortgage();
	                    if(!$Contact->MortgageRelation->loadMortgage($Contact->MortgageId))
	                        $Contact->MortgageRelation = false;
	                }

	                if(NumberCheck($Contact->EmploymentId)) 
	                {
	                    $Contact->EmploymentRelation = new Employment();
	                    if(!$Contact->EmploymentRelation->loadEmployment($Contact->EmploymentId))
	                        $Contact->EmploymentRelation = false;
	                }

	                if(NumberCheck($Contact->PreviousEmpId)) 
	                {
	                    $Contact->PreviousEmpRelation = new PreviousEmployment();
	                    if(!$Contact->PreviousEmpRelation->loadPreviousEmployment($Contact->PreviousEmpId))
	                        $Contact->PreviousEmpRelation = false;
	                }


               		  $ReturnArray[] = $Contact;


                }
                 
                return $ReturnArray;
            }
	    
		return false;

	}
	
	public function loadSearchInfo($Condition = '')
  	{
				
		$SQL = "SELECT CI.*, C.Id AS ContactId, C.Status AS 'AccountStatus' FROM tblcontact C 
				JOIN tblcontactinfo CI ON CI.Id = C.ContactInfoId 
				LEFT JOIN tblmortgage MO ON MO.Id = C.MortgageId 
				LEFT JOIN tblemployment EMP ON EMP.Id = C.EmploymentId 
				LEFT JOIN tblpreviousemployment PrevEmp ON PrevEmp.Id = C.PreviousEmpId 
				WHERE C.Status IN (1,2) 
				  ";

		if($Condition !='')
			$SQL .= $Condition;

		$SQL .= ' ORDER BY C.Id DESC';
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);			


		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}


	public function LeadsCount()
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM tblcontact 
				WHERE Status IN (1,2)

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	public function NewLeadsCount()
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM tblcontact 
				WHERE Status IN (2)

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	public function Status($Status)
    {
        
        switch($Status)
        {
            case 1: return "<a href='#' style='color:#7CB342;text-decoration:none;'>Verified</a>"; break;
            case 2: return "<a href='#' style='color:#1E88E5;text-decoration:none;'>Pending Verification</a>"; break;
            case 3: return "<a href='#' style='color:#E53935;text-decoration:none;'> Incomplete Application</a>"; break;
            default: return '';
        }
    }

    public function PendingCount($Condition = '')
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM tblcontact 
				WHERE Status IN (2)

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	public function GetId($ContactInfoId)
	{
		$SQL = "SELECT Id  
				FROM tblcontact 
				WHERE ContactInfoId = " . $ContactInfoId . " AND Status IN (0,1,3)

		";

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Id"]  : 0;
		
	}


	public function loadHiddenApplication($Condition = '') 
  	{
		
				
		$SQL = "SELECT * FROM tblcontact WHERE Status = 0 ORDER BY Timestamp DESC";

		parent::GetDALInstance()->SQLQuery($SQL);

            $Result = parent::GetDALInstance()->GetArray(false);

            if($Result) 
            {
                $ReturnArray = array();
                $ResultLength = count($Result);

                for($x = 0; $x < $ResultLength ; $x++) 
                {
                    $Contact = new Contact();
                    $Contact->Id = $Result[$x]["Id"];
                    $Contact->ContactInfoId = $Result[$x]["ContactInfoId"];
                    $Contact->MortgageId = $Result[$x]["MortgageId"];
                    $Contact->EmploymentId = $Result[$x]["EmploymentId"];
                    $Contact->PreviousEmpId = $Result[$x]["PreviousEmpId"];
                    $Contact->CreateDate = $row['CreateDate'];
                    $Contact->Timestamp = $Result[$x]["Timestamp"];
                    $Contact->Status = $Result[$x]["Status"];


                    if(NumberCheck($Contact->ContactInfoId)) 
                    {
                    	$Contact->ContactInfoRelation = new ContactInfo();
                    	if(!$Contact->ContactInfoRelation->loadContactInfo($Contact->ContactInfoId))
                        	$Contact->ContactInfoRelation = false;
               		 }

               		 

               		 if(NumberCheck($Contact->MortgageId)) 
               		 {
	                    $Contact->MortgageRelation = new Mortgage();
	                    if(!$Contact->MortgageRelation->loadMortgage($Contact->MortgageId))
	                        $Contact->MortgageRelation = false;
	                }

	                if(NumberCheck($Contact->EmploymentId)) 
	                {
	                    $Contact->EmploymentRelation = new Employment();
	                    if(!$Contact->EmploymentRelation->loadEmployment($Contact->EmploymentId))
	                        $Contact->EmploymentRelation = false;
	                }

	                if(NumberCheck($Contact->PreviousEmpId)) 
	                {
	                    $Contact->PreviousEmpRelation = new PreviousEmployment();
	                    if(!$Contact->PreviousEmpRelation->loadPreviousEmployment($Contact->PreviousEmpId))
	                        $Contact->PreviousEmpRelation = false;
	                }


               		  $ReturnArray[] = $Contact;


                }
                 
                return $ReturnArray;
            }
	    
		return false;


	}

	public function HiddenCount()
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM tblcontact 
				WHERE Status IN (0)

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	public function HiddenNotification($Condition = '') 
  	{
		$SQL = "SELECT * FROM tblcontact C
				JOIN tblcontactinfo CI ON CI.Id=C.ContactInfoId 
				WHERE C.Status = 0  AND CI.ArchiveNotification IS NOT NULL 
				 ";
		
		if($Condition !='')
			$SQL .= $Condition;
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		//$SQL .= " ORDER BY CI.ArchiveNotification DESC ";
		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			
		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}

}
?>