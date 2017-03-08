<?php
class Occurance extends BaseClass
{
	public $Id;
	public $OccuranceType;
	public $OccuranceName;
	public $Status;
	

	
	
  	public function loadOccurance($OccuranceType) {
		
				
	$SQL = "SELECT * FROM tbloccurance 
			WHERE OccuranceType = ".$OccuranceType;

			$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;
		}


	public function getOccuranceName($Id)
	{
		$SQL = "SELECT * FROM tbloccurance Where Id=".$Id;
		
		parent::GetDALInstance()->SQLQuery($SQL);

            $row = parent::GetDALInstance()->GetRow(false);
            return $row[2];

           return false;
	}

}