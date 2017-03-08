<?php

class Files extends  BaseClass {
    public $Id = -1;
    public $FileName = "";
    public $FileSize = 0;
    public $FileMIME = "";
    public $FileLocation = "";
    public $Status = 0;
    public $FileVersion = 1;
    
    /// code end

    //public $CompanyDirectory = COMPANYID;

    function __construct() {
        parent::__construct();
    }
    public function InsertFile() {

        
        $FileVersion = NullCheck($this->FileVersion);

        $SQL = "INSERT INTO tblfile SET FileName='".$this->FileName."', FileSize=".$this->FileSize.", FileMime='".$this->FileMIME."', FileLocation='".$this->FileLocation."', Status=".$this->Status.", FileVersion=".$FileVersion.", Timestamp=NULL ";
        
        $this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);

        return $this->Id;
    }

    

    
    public function UpdateFileDownloadCount() {
        $SQL = "UPDATE tblfile SET  DownloadCount = DownloadCount+1 WHERE Id=".$this->Id;
        parent::GetDALInstance()->SQLQuery($SQL);
        return parent::GetDALInstance()->AffectedRows();
    }
    
    
    
   
    public function LoadFile($FileId) {
        if(NumberCheck($FileId)) {
            $SQL = "SELECT * FROM tblfile WHERE Id=$FileId";
            parent::GetDALInstance()->SQLQuery($SQL);
            $row = parent::GetDALInstance()->GetRow();
            if($row) {
                $this->Id = $row["Id"];
                $this->FileName = $row["FileName"];
                $this->FileSize = $row["FileSize"];
                $this->FileMIME = $row["FileMIME"];
                $this->FileLocation = $row["FileLocation"];
                $this->FileVersion=$row["FileVersion"];
               
                return true;
            }
        }

        return false;
    }

    
	static function GetType($FileId) {
        if(NumberCheck($FileId)) {
            $SQL = "SELECT fileMIME FROM tblfile WHERE Id=".$FileId;
            parent::GetDALInstance()->SQLQuery($SQL);
            $row = parent::GetDALInstance()->GetRow();

            return ($row) ? $row["fileMIME"] : false;

        }

        return false;

    }


    static function GetFileVersion($FileId) {
        if(NumberCheck($FileId)) {
            $SQL = "SELECT FileVersion FROM tblfile WHERE Id=".$FileId;
            parent::GetDALInstance()->SQLQuery($SQL);
            $row = parent::GetDALInstance()->GetRow();

            return ($row) ? $row["FileVersion"] : false;

        }

        return false;

    }
	
    static function GetAvatar($FileId) {
        if(NumberCheck($FileId)) {
            $SQL = "SELECT FileLocation FROM tblfile WHERE Id=".$FileId;
            parent::GetDALInstance()->SQLQuery($SQL);
            $row = parent::GetDALInstance()->GetRow();

            return ($row) ? $row["FileLocation"] : false;

        }

        return false;

    }
	

   
    public function LoadFileInfo($OrderId) {
        if(NumberCheck($OrderId)) {
            $SQL = "SELECT F.* FROM tblfile F 
                    JOIN tblfilerelations FR ON FR.FileId = F.Id 
                    WHERE FR.OrderId= " . $OrderId;

                    //echo "<br/><br/><br/><br/><br/><br/>".$SQL;
            parent::GetDALInstance()->SQLQuery($SQL);
            $row = parent::GetDALInstance()->GetRow(false);
                


            $ResultSet = new ResultSet();
            if($ResultSet->LoadResult($SQL))
                return $ResultSet;

        }
        
        return false;

    }

    public function LoadAffiliateFileInfo($AffiliateId) {
        if(NumberCheck($AffiliateId)) {
            $SQL = "SELECT F.* FROM tblfile F 
                    JOIN tblfilerelations FR ON FR.FileId = F.Id 
                    WHERE FR.AffiliateId= " . $AffiliateId;

                    //echo "<br/><br/><br/><br/><br/><br/>".$SQL;
            parent::GetDALInstance()->SQLQuery($SQL);
            $row = parent::GetDALInstance()->GetRow(false);
                


            $ResultSet = new ResultSet();
            if($ResultSet->LoadResult($SQL))
                return $ResultSet;

        }
        
        return false;

    }

    public function FileuploadCount($OrderId) {
        $SQL = "SELECT count(*) AS Upload FROM tblfile F 
                    JOIN tblfilerelations FR ON FR.FileId = F.Id   
                    WHERE FR.OrderId= " . $OrderId;
            parent::GetDALInstance()->SQLQuery($SQL);
            $row = parent::GetDALInstance()->GetRow();

            return ($row) ? $row["Upload"] : false;

    }
}

?>
