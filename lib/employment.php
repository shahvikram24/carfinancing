<?php
class Employment extends BaseClass
{
	
	public $Id;
	public $EmpStatusId =0;
	public $EmpTypeId =0;
	public $OrganizationName='';
	public $JobTitle='';
	
	public $Address1='';
	public $Address2='';
	public $City='';
	public $Province='';
	public $Postal='';
	public $Country='';
	public $Phone1='';

	public $EmpYears='';
	public $EmpMonths='';
	public $GrossIncome=0.00;	
	public $OtherIncome=0.00;
	public $FrequencyId=0;
	public $OtherIncomeTypeId=0;
	public $Timestamp;
	public $Status=0;
	
	function __construct()
		{
			parent::__construct();
			
		}
	
  	public function loadEmployment($Id) 
  	{
		
				
		$SQL = "SELECT * FROM tblemployment WHERE Id = " . $Id . " AND Status = 1  ";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				$this->Id = $row['Id'];
				$this->EmpStatusId = $row['EmpStatusId'];
				$this->EmpTypeId = $row['EmpTypeId'];
				$this->OrganizationName = $row['OrganizationName'];
				$this->JobTitle = $row['JobTitle'];
				$this->Address1 = $row['Address1'];
				$this->Address2 = $row['Address2'];
				$this->Postalcode = $row['Postal'];
				$this->City = $row['City'];
				$this->Province = $row['Province'];
				$this->Country = $row['Country'];
				$this->Phone1 = $row['Phone1'];

				$this->EmpYears = $row['EmpYears'];
				$this->EmpMonths = $row['EmpMonths'];
				$this->GrossIncome = $row['GrossIncome'];
				$this->OtherIncome = $row['OtherIncome'];
				$this->FrequencyId = $row['FrequencyId'];
				$this->OtherIncomeTypeId = $row['OtherIncomeTypeId'];
				$this->Status = $row['Status'];
				
				
				return $this;
			}
			return false;

	}
		
		
	public function addEmployment() 
	{
			$SQL = " INSERT INTO tblemployment 
				SET 
					EmpStatusId = " . $this->EmpStatusId . ", 
					EmpTypeId = " . $this->EmpTypeId . ", 
					OrganizationName = '" . $this->OrganizationName . "', 
					JobTitle = '" . $this->JobTitle . "', 
					Address1 = '" . $this->Address1 . "', 
					Address2 = '" . $this->Address2 . "', 
					Postal = '" . $this->Postal . "', 
					City = '" . $this->City . "', 
					Province = '" . $this->Province . "', 					
					Phone1 = '" . $this->Phone1 . "', 

					EmpYears = '" . $this->EmpYears . "', 
					EmpMonths = '" . $this->EmpMonths . "', 
					GrossIncome = " . $this->GrossIncome. ", 
					OtherIncome = " . $this->OtherIncome . ", 
					FrequencyId = " . $this->FrequencyId . ", 
					OtherIncomeTypeId = " . $this->OtherIncomeTypeId . ", 
					
					Status = " . $this->Status . "
					";
			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateEmployment($Id) 
	{
		$SQL = " UPDATE tblemployment 
		SET 
			EmpStatusId = " . $this->EmpStatusId . ", 
					EmpTypeId = " . $this->EmpTypeId . ", 
					OrganizationName = '" . $this->OrganizationName . "', 
					JobTitle = '" . $this->JobTitle . "', 
					Address1 = '" . $this->Address1 . "', 
					Address2 = '" . $this->Address2 . "', 
					Postal = '" . $this->Postal . "', 
					City = '" . $this->City . "', 
					Province = '" . $this->Province . "', 					
					Phone1 = '" . $this->Phone1 . "', 

					EmpYears = '" . $this->EmpYears . "', 
					EmpMonths = '" . $this->EmpMonths . "', 
					GrossIncome = " . $this->GrossIncome. ", 
					OtherIncome = " . $this->OtherIncome . ", 
					FrequencyId = " . $this->FrequencyId . ", 
					OtherIncomeTypeId = " . $this->OtherIncomeTypeId . ", 
					
					Status = " . $this->Status . "
					";
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}
	
	
}
?>