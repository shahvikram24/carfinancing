<?PHP

class DAL {
    //TODO: Create a concurrency manager w00t!
    //Set the DAL to call passwords, iv, etc from an unsubversioned file

    private $MySQLi;
    private $Query;

    // @var MySQLi_STMT
    public $Result;
    private $SQLStrictMode = true;
    private $QueryCount;
    private $RealQueryCount;
    private $TransactionInProgress = false;
    private $EnableCache = false;
    private $CurrentServer;



    function __construct($SQLStrictMode = 'EXPLICIT') {
        global $EnableCache;

        register_shutdown_function(array($this, "__ShutDownCheck"));

        if(isset($EnableCache) && is_bool($EnableCache)) {
            $this->EnableCache = $EnableCache;
        }

        $this->CurrentServer = CurrentServer();
        $this->SQLStrictMode = ($SQLStrictMode === false) ? false : true;

        $this->QueryCount = 0;
        $this->RealQueryCount = 0;
        $this->Result = "";
        $this->Connection();

    }

    function getQuery(){
        return $this->Query;
    }

    function TransactionInProgress() {
        return $this->TransactionInProgress;
    }

    function FreeResult() {
        if( $this->Result ) {

            do {
                if ($result = $this->MySQLi->store_result()) {

                    $result->close();

                }
            } while( $this->MySQLi->next_result() );
        }


        $this->Result->close();
    }

    function ThrowException($ExceptionTypeId, $Message) {
        throw new Exception($Message);
    }

    private function getUserName($Key) {
        
            if($this->CurrentServer == "live")
                return 'carfinancing';
            else if($this->CurrentServer == "vstudiozzz")
              return 'carfinancing';
            else
                return "root";

    }

    private function getHost($Key) {
            return "localhost";
       
    }

    private function getPassword($Key) {
            if($this->CurrentServer == "live")
                return 'Y6g6z%6q';
            else if($this->CurrentServer == "vstudiozzz")
              return 'Toqm41$8';
            else
                return "root";

       
    }

    private function getDatabase($Key) {
        
        if($this->CurrentServer == "live")
            return 'carfinancing';
        else if($this->CurrentServer == "vstudiozzz")
          return 'carfinancing';
        else
            return "carfinancing";

       
    }

    function Connection() {
        /*echo "DB=".$this->getDatabase("SecretKeyToAccessTheDatabase")."<br />Host=".$this->getHost("SecretKeyToAccessTheHostName")."<br />Username=".$this->getUserName("SecretKeyToAccessTheUserName")."<br />Password=".$this->getPassword("SecretKeyToAccessThePassword")."<br />Server=".$_SERVER['SERVER_NAME'];
				exit;*/

        $this->MySQLi = new mysqli($this->getHost("SecretKeyToAccessTheHostName"), $this->getUserName("SecretKeyToAccessTheUserName"), $this->getPassword("SecretKeyToAccessThePassword"),$this->getDatabase("SecretKeyToAccessTheDatabase"));

        if(mysqli_connect_errno())
            $this->ThrowException(1, mysqli_connect_error());
    }

    function CloseConnection() {
        $this->MySQLi->close();
    }

    function BeginTransaction($TransactionIsolationLockLevel = 3) {
        $this->MySQLi->autocommit(false);
        $this->TransactionInProgress = true;

        $SQL = "";

        switch($TransactionIsolationLockLevel) {
            case 1:
            // Barely transactional, this setting allows for so-called 'dirty reads', where queries inside one transaction are affected by uncommitted changes in another transaction
                $SQL = "SET SESSION TRANSACTION ISOLATION LEVEL READ UNCOMMITTED;";
                break;
            case 2:
            // Committed updates are visible within another transaction. This means identical queries within a transaction can return differing results. This is the default in some DBMS's
                $SQL = "SET SESSION TRANSACTION ISOLATION LEVEL READ COMMITTED;";
                break;
            case 3:
            // The default isolation level in MySQL, this level eliminates dirty reads and unrepeatable reads. Phantom reads are still theoretically possible, but in reality are almost impossible to reproduce.
                $SQL = "SET SESSION TRANSACTION ISOLATION LEVEL REPEATABLE READ;";
                break;
            case 4:
            // Eliminates phantom reads as well to offer the most secure isolation between transactions; it's also the slowest.
                $SQL = "SET SESSION TRANSACTION ISOLATION LEVEL SERIALIZABLE;";
                break;
        }

        if($SQL != "")
            $this->SQLQuery($SQL);
        $this->SQLQuery("BEGIN;");
    }

    function RollbackTransaction() {
        $this->TransactionInProgress = false;
        $this->SQLQuery("ROLLBACK;");
        //$this->MySQLi->rollback();
        $this->MySQLi->autocommit(true);
    }

    function CommitTransaction() {
        $this->TransactionInProgress = false;
        $this->SQLQuery("COMMIT;");
        //$this->MySQLi->commit();
        $this->MySQLi->autocommit(true);
    }

    public function __ShutDownCheck() {
        if($this->TransactionInProgress)
            $this->RollbackTransaction();
    }

    function SQLQuery($Query, $QueryType = 0, $FlagTableAsHit = true) {

        /*

				Query Type
				0 = Normal mode. Best for simple select statements
				1 = Use transactions !! DEPRECATED !! USE DAL->BeginTransaction() instead
				2 = return the last id generated with LAST_INSERT_ID()

        */
        $QueryTypeString = strtoupper(substr($Query, 0, 6));


        if($this->SQLStrictMode && ($QueryTypeString == 'UPDATE' || $QueryTypeString == 'DELETE') && !strripos($Query, 'where')) {
            $this->ThrowException(1, $QueryTypeString.' statements must include a WHERE clause');
        }

        $this->Query = $Query;
        $this->Result = $this->MySQLi->query($Query);

        if (!$this->Result) {
            //var_dump($Query);
            $this->ThrowException(1, $this->MySQLi->error);
            return false;
        }
        
        $this->QueryCount += 1;

        switch($QueryType) {
            case 2:
                return $this->MySQLi->insert_id;
                break;
        }

        return true;

    }

    function RowCount() {
        return $this->Result->num_rows;
    }

    function AffectedRows() {
        return $this->MySQLi->affected_rows;
    }

    function GetArray($RemoveSlashes = true, $ReturnColumn = false, $ResultType = 3) {
        $ResultType = ($ResultType < 1 || $ResultType > 4) ? 3 : $ResultType;

        if ($this->RowCount() > 0 ) {
            //$ReturnColumn = ($ReturnColumn === false && $this->MySQLi->field_count == 1) ? 0 : $ReturnColumn;
            $returnArray = array();

            while($row = $this->Result->fetch_array($ResultType)) {
                if($RemoveSlashes)
                    $row = RemoveSlashesArray($row);

                if(NumberCheck($ReturnColumn))
                    $returnArray[] = $row[$ReturnColumn];
                else
                    $returnArray[] = $row;
            }

            return $returnArray;

        }
        else {
            return false;
        }

    }

    function ResetRow($Row = 0) {
        $this->Result->data_seek($Row);
    }

    function GetRow($RemoveSlashes = true) {
        if ($this->RowCount() > 0) {

            $row = $this->Result->fetch_array();

            if($RemoveSlashes)
                $row = RemoveSlashesArray($row);

            return $row;
        }

        return false;
    }

    function QueryCount() {
        return $this->QueryCount;
    }

    function __sleep() {
        $this->QueryCount = 0;
        $this->MySQLi = false;
        $this->Query = false;
        $this->RealQueryCount = 0;
    }

}

?>
