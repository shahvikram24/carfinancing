<?php
class Often extends BaseClass
{
	public $Id;
	public $OftenType;
	public $Status;
	

	
	
  	public function loadOften() {
		
				
	$SQL = "SELECT * FROM tbloften order by Id";
	//echo $SQL;
			
			$ResultSet = new ResultSet();
				if($ResultSet->LoadResult($SQL))
					return $ResultSet;
				else
					return false;

		}

	public function getOftenType($Id)
	{
		$SQL = "SELECT * FROM tbloften Where Id=".$Id;
		
		parent::GetDALInstance()->SQLQuery($SQL);

            $row = parent::GetDALInstance()->GetRow(false);
            return $row[1];

             return false;

	}
}