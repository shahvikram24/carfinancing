<?
class DB_manager{
    /**
     * this class manages db interaction
     */
     var $db,/**
     * which data base to use
     */
     $db_usr,/**
     * DB user name
     */
     $db_pw,/**
     * DB password
     */
     $db_connection,/**
     * db connection, for future reference
     */
     $db_host;
    /**
     * where the db is, defaults to local
     */
    
     function DB_manager($the_db, $user_db, $pass_db){
        /**
         * instantiator
         */
         $this -> db = $the_db;
         $this -> db_usr = $user_db;
         $this -> db_pw = $pass_db;
         $this -> db_host = "localhost";
         }
    
     function db_connect (){
        /**
         * Connects to the DB
         */
         $connection = mysql_connect($this -> db_host, $this -> db_usr, $this -> db_pw)
         or print('Cannot connect to MYSQL server');
         $select = mysql_select_db($this -> db, $connection);
         $error1 = mysql_errno();
         $error2 = mysql_error();
         if (strlen($error2)){
             print ("ERROR: $error1 : $error2");
             }
         if (!$select){
            print("cannot select ");
        }
         $this -> db_connection = $connection;
         }
    
     function get_db (){
        /**
         * returns the connection variable
         */
         return $this -> db_connection;
         }
    
     function set_db ($ndb){
        /**
         * changes which DB is being used, must reconnect after
         */
         $this -> db = $ndb;
         return true;
         }
    
     function set_usr ($nusr){
        /**
         * changes the user, must reconect after
         */
         $this -> db_usr = $nusr;
         return true;
         }
    
     function set_pw ($npw){
        /**
         * changes the password, must reconnect for changes to carry
         */
         $this -> db_pw = $npw;
         return true;
         }
    
     function set_host($nhost){
        /**
         * alters the host location ,must reconnect to have changes
         */
         $this -> db_host = $nhost;
         return true;
         }
    
     function commit($query){
        /**
         * sens query to DB
         */
         $result = mysql_query($query);
         if (!$result){
             $error1 = mysql_errno();
             $error2 = mysql_error();
             print("$error1 :: $error2 <br><br>");
             return false;
             }
         return $result;
        
         }
    
    
    }
?>