<?php

 class Database_class extends PDO
 {

	 private $DB_HOST = DB_HOST;
	 private $DB_USER = DB_USER;
	 private $DB_PASS = DB_PASS;
	 private $DB_NAME = DB_NAME;
	 
	 protected $CONNECTION;
		 
	 // COSTRUCTOR TO CREATE SERVER CONNECTION WITH DATABASE
	 function __construct()
	 {		
		$this->connect();	
	 }
	 
	 
	// DECONSTRUCT TO DISCONNECT SERVER AND DATABASE CONNECT
	function __destruct()
	{
		$this->disconnect();		
	}	
	
	// DATABASE CONNECTION **************************
	function connect()
	{
		parent::__construct('mysql:host='.$this->DB_HOST.';dbname='.$this->DB_NAME, $this->DB_USER, $this->DB_PASS);
        
		$this->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
        // always disable emulated prepared statement when using the MySQL driver
        $this->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
		
	}
	
	// DISCONNECT SERVER FROM DATABASE *****************
	function disconnect()
	{
		//mysql_close($this->CONNECTION);
		//$this->CONNECTION = null;
	}
	
		
	
}

?>