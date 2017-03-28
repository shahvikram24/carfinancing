<?php
class Contact extends BaseClass
{
	
	public $id;
	public $vehicle_type_id = 1;
	public $first_name;
	public $last_name;
	public $email;
	public $phone;
	public $month_of_birth = 0;
	public $day_of_birth = 0;
	public $year_of_birth = 0;
	public $address = '';
	public $postal_code = '';
	public $province_id = 1;
	public $city = '';
	public $rent_or_own = 'rent';
	public $residence_years = 0;
	public $monthly_payment = '';
	public $company_name = '';
	public $job_title = '';
	public $work_phone = '';
	public $monthly_income = '';
	public $sin_number = '';
	public $years_on_job = 0;
	public $months_on_job = 0;
	public $notes = '';
	public $created;
	public $status = 1;

	function __construct() {
        parent::__construct();
    }
	
	
  	public function loadContact($Id) 
  	{
		
				
		$SQL = "SELECT * FROM contact WHERE id = " . $Id . " AND status IN (0,1,2,3)  ";
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);
			


			if($row)
			{
				 $this->id = $row['id'];
				 $this->vehicle_type_id = $row['vehicle_type_id'];
				 $this->first_name = $row['first_name'];
				 $this->last_name = $row['last_name'];
				 $this->email = $row['email'];
				 $this->phone = $row['phone'];
				 $this->month_of_birth = $row['month_of_birth'];
				 $this->day_of_birth = $row['day_of_birth'];
				 $this->year_of_birth = $row['year_of_birth'];
				 $this->address = $row['address'];
				 $this->postal_code = $row['postal_code'];
				 $this->province_id = $row['province_id'];
				 $this->city = $row['city'];
				 $this->rent_or_own = $row['rent_or_own'];
				 $this->residence_years = $row['residence_years'];
				 $this->monthly_payment = $row['monthly_payment'];
				 $this->company_name = $row['company_name'];
				 $this->job_title = $row['job_title'];
				 $this->work_phone = $row['work_phone'];
				 $this->monthly_income = $row['monthly_income'];
				 $this->sin_number = $row['sin_number'];
				 $this->years_on_job = $row['years_on_job'];
				 $this->months_on_job = $row['months_on_job'];
				 $this->notes = $row['notes'];
				 $this->created = $row['created'];
				 $this->status = $row['status'];

				return $this;
			}
			return false;

	}
		
		
	public function addContact() 
	{
			$SQL = " INSERT INTO contact 
				SET 
					 vehicle_type_id = " . $this->vehicle_type_id . ", 
					 first_name = '" . $this->first_name . "', 
					 last_name = '" . $this->last_name . "', 
					 email = '" . $this->email . "', 
					 phone = '" . $this->phone . "', 
					 month_of_birth = " . $this->month_of_birth . ", 
					 day_of_birth = " . $this->day_of_birth . ", 
					 year_of_birth = " . $this->year_of_birth . ", 
					 address = '" . $this->address . "', 
					 postal_code = '" . $this->postal_code . "', 
					 province_id = " . $this->province_id . ", 
					 city = '" . $this->city . "', 
					 rent_or_own = '" . $this->rent_or_own . "', 
					 residence_years = " . $this->residence_years . ", 
					 monthly_payment = '" . $this->monthly_payment . "', 
					 company_name = '" . $this->company_name . "', 
					 job_title = '" . $this->job_title . "', 
					 work_phone = '" . $this->work_phone . "', 
					 monthly_income = '" . $this->monthly_income . "', 
					 sin_number = '" . $this->sin_number . "', 
					 years_on_job = " . $this->years_on_job . ", 
					 months_on_job = " . $this->months_on_job . ", 
					 created = '" . date('Y-m-d H:i:s') . "', 
					 notes = '" . $this->notes . "', 
					 status = " . $this->status . "
					";

					 

			//echo "<br/><br/><br/><br/><br/><br/>".$SQL;		
			$this->Id = parent::GetDALInstance()->SQLQuery($SQL,2);
			return $this->Id;
	}


	public function updateContact() 
	{
		
		$SQL = " UPDATE contact 
			SET 
					vehicle_type_id = " . $this->vehicle_type_id . ", 
					 first_name = '" . $this->first_name . "', 
					 last_name = '" . $this->last_name . "', 
					 email = '" . $this->email . "', 
					 phone = '" . $this->phone . "', 
					 month_of_birth = " . $this->month_of_birth . ", 
					 day_of_birth = " . $this->day_of_birth . ", 
					 year_of_birth = " . $this->year_of_birth . ", 
					 address = '" . $this->address . "', 
					 postal_code = '" . $this->postal_code . "', 
					 province_id = " . $this->province_id . ", 
					 city = '" . $this->city . "', 
					 rent_or_own = '" . $this->rent_or_own . "', 
					 residence_years = " . $this->residence_years . ", 
					 monthly_payment = '" . $this->monthly_payment . "', 
					 company_name = '" . $this->company_name . "', 
					 job_title = '" . $this->job_title . "', 
					 work_phone = '" . $this->work_phone . "', 
					 monthly_income = '" . $this->monthly_income . "', 
					 sin_number = '" . $this->sin_number . "', 
					 years_on_job = " . $this->years_on_job . ", 
					 months_on_job = " . $this->months_on_job . ", 
					 notes = " . $this->notes . ", 
					 status = " . $this->status . "

        			WHERE id=".$this->Id;
					;
		
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;
				
		parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();

	}


	public function LeadsCount()
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM contact 
				WHERE status IN (1,2)

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	public function NewLeadsCount()
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM contact 
				WHERE status IN (2)

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
				FROM contact 
				WHERE status IN (2)

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	

	public function HiddenCount()
	{
		$SQL = "SELECT count(*) AS 'TotalLeads'
				FROM contact 
				WHERE status IN (0)

		";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["TotalLeads"] : 0;
	}

	
	public function GetFullName($Id)
	{
		$SQL = "SELECT first_name AS 'Fname', last_name AS 'Lname' 
				FROM contact 
				WHERE id = " . $Id . " AND status IN (0,1,3)

		";

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["Fname"] . " " . $row["Lname"] : 0;
		
	}

	public function GetProvince($Id)
	{
		$SQL = "SELECT name AS 'name' 
				FROM provinces 
				WHERE id = " . $Id ;

		//echo  "\n". $SQL . "\n";

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow();

		return ($row) ? $row["name"] . " " . $row["Lname"] : 0;
		
	}

	public function loadSearchInfo($Condition = '')
  	{
				
		$SQL = "SELECT C.* from contact C
				WHERE C.id NOT IN (SELECT ContactId from tbldealerpackagefeatures  
									WHERE 	Status = 1)
				  ";


		if($Condition !='')
			$SQL .= $Condition;

		$SQL .= ' ORDER BY C.id DESC';
		//echo "<br/><br/><br/><br/><br/><br/>".$SQL;

		parent::GetDALInstance()->SQLQuery($SQL);
		$row = parent::GetDALInstance()->GetRow(false);			


		$ResultSet = new ResultSet();
	    if($ResultSet->LoadResult($SQL))
	        return $ResultSet;

	    
		return false;

	}

	public function loadAssigned($Condition = '')
  	{
				
		$SQL = "SELECT C.* from contact C
				WHERE C.id IN (SELECT ContactId from tbldealerpackagefeatures  
									WHERE 	Status = 1)
				  ";


		if($Condition !='')
			$SQL .= $Condition;

		$SQL .= ' ORDER BY C.id DESC';
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