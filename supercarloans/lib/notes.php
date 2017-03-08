<?php

class Notes extends  BaseClass {
    public $Id = -1;
    public $Notes = '';
    public $DatePosted = '';
    public $Status = 0;
    
    
    function __construct() {
        parent::__construct();
    }

    public function InsertNotes() {

        
        $FileVersion = NullCheck($this->FileVersion);

        $SQL = "INSERT INTO tblnotes 
                SET 
                    Notes='".$this->Notes."', 
                    DatePosted='".$this->DatePosted."', 
                    Status=".$this->Status;
        
        $this->Id = parent::GetDALInstance()->SQLQuery($SQL, 2);

        return $this->Id;
    }

    

    
   
    public function LoadNotes($NotesId) {
        if(NumberCheck($NotesId)) {
            $SQL = "SELECT * FROM tblnotes WHERE Id=$NotesId";
            parent::GetDALInstance()->SQLQuery($SQL);
            $row = parent::GetDALInstance()->GetRow();
            if($row) {
                $this->Id = $row["Id"];
                $this->Notes = $row["Notes"];
                $this->DatePosted = $row["DatePosted"];
                $this->Status=$row["Status"];
               
                return true;
            }
        }

        return false;
    }

    


   
    public function LoadNotesInfo($Column, $Value) {
        if(NumberCheck($Value)) {
            $SQL = "SELECT N.* FROM tblnotes N 
                    JOIN tblnotesrelation NR ON NR.NotesId = N.Id 
                    WHERE NR.".$Column."= " . $Value . 
                    " ORDER BY N.DatePosted DESC ";

                    //echo "<br/><br/><br/><br/><br/><br/>".$SQL;
            parent::GetDALInstance()->SQLQuery($SQL);
            $row = parent::GetDALInstance()->GetRow(false);
                


            $ResultSet = new ResultSet();
            if($ResultSet->LoadResult($SQL))
                return $ResultSet;

        }
        
        return false;

    }

   
}

?>
