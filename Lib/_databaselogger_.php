<?php
@session_start();
include('../adodb/adodb.inc.php');
include_once("_logger_.php");

//@include_once("../defines/defines.php");
class databaseTransLogger
{

	private $usename;
	private $_databaseName;
	private $_dbserverName;
	private $_dbuserName;
	private $_dbpassword;



function __construct($username="",$password="")
{
   $this->_dbuserName  = $username;
   $this->_dbpassword = $password;
}

public function get_databaseName()
{
	return $this->_databaseName;
}
public function set_databaseName($_databaseName)
{
	$this->_databaseName = $_databaseName;
}



public function get_dbserverName()
{
	return $this->_dbserverName;
}

public function set_dbserverName($_dbserverName)
{
	$this->_dbserverName = $_dbserverName;
}

public function get_dbuserName()
{
 return $this->_dbuserName;
}
public function set_dbuserName($_dbuserName)
{
	$this->_dbuserName = $_dbuserName;
}

public function get_dbpassword()
{
 return $this->_dbpassword;
}
public function set_dbpassword($_dbpassword)
{
	$this->_dbpassword = $_dbpassword;
}


//create the mySQL connection on demand
function mysql_conn()
{
	 try{

		 $db = ADONewConnection('mysql'); 
		 $db->Connect('localhost','root','','ikolilu_tt_db');

		 $GLOBALS['Mysqli'] = new Mysqli('localhost', 'root', '', 'ikolilu_tt_db');
	  }catch(Exception $e)
		  {
			  return -1;
		  }
 return $db;
}

function connectAsAdminToDatabase()
{
	     $db = ADONewConnection('mysql');
	     $db->Connect('','','','');

		 return $db;
}

function mysql_remoteconn()
{
	$db = ADONewConnection('mysql');
	$db->Connect('','','','');

 return $db;
}


 function mysql_BiometricConn()
{
	$db = ADONewConnection('mysql');
	//$db->Connect('','','','');

 return $db;
}
function LoggTransactions($trans_date="",$trans_time="",$trans_user="",$strSQL="")
   {
        $logs = array();
		  //conn = new connection();

		for($r=0;$r<count($strSQL);$r++)
		{

		     $pos    = strpos($strSQL[$r],' ');
			 //print $pos;
			 $action = substr($strSQL[$r],0,$pos);
			 $thetran = str_replace("'","#",$strSQL[$r]);
			  //print $thetran;
		   	@$logs[$r] = "insert into admin_usertrans_logs_db (szaction, section, trans_date, trans_time, trans_user,trans,szstatus) values ('".$action."','TEDC','".$trans_date."','".$trans_time."','".$_SESSION['userid']."','".$thetran."','1')";

		}
		$retval = $this->RunLoggerTrans($logs);
   }

function RunLoggerTrans($strSQL="")
{
     $dfile    = date("Ymd");
     $file     = $dfile.".txt";
    $filename = logger::createLogFile(USERLOGFILEPATH,$file);
     $conn = $this->mysql_conn();

	 $conn->StartTrans();

	  for($j=0;$j<count($strSQL);$j++)
	  {
	       //$conn->debug = true;
	       $conn->Execute($strSQL[$j]);

		   $CheckRecord = $conn->HasFailedTrans();
		   if($CheckRecord){
		       $conn->FailTrans();
		       $conn->CompleteTrans();
		    return -1;
		   }
		     $str    =  $strSQL[$j].";^".$_SESSION['userid']."^".date('Y-m-d H:i:s').PHP_EOL;
		    logger::LogSQLFile($filename,$str);
		}
		$this->LoggTransactions(date("h:i:s A"),date("F j Y"),$this->username,$strSQL);
	 $conn->CompleteTrans();
     return 1;
}

function RunRemoteTrans($strSQL="")
{
	 $conn = $this->mysql_remoteconn();

	 $conn->StartTrans();

	  for($j=0;$j<count($strSQL);$j++)
	  {
	       ///$conn->debug = true;
	       $conn->Execute($strSQL[$j]);

		   $CheckRecord = $conn->HasFailedTrans();
		   if($CheckRecord){
		       $conn->FailTrans();
		       $conn->CompleteTrans();
		    return -1;
		   }
		   $str    =  $strSQL[$j].";^".$_SESSION['userid']."^".date('Y-m-d H:i:s').PHP_EOL;
	 	   logger::LogSQLFile($filename,$str);
		}
	 $conn->CompleteTrans();
	 return 1;
}
function RunSQLReturnReturnValue($strSQL="",$op="")
{
	$date     = date("Ymd");
   $file =  $date.".sql";
	 //$file = "../Logs/".$filename;

   $filename = logger::createLogFile(LOGFILEPATH,$file);

    $conn = $this->mysql_conn();
	$valret = $conn->Execute($strSQL);
	 $str    =  $strSQL.";^".$_SESSION['userid']."^".date('Y-m-d H:i:s').PHP_EOL;
	  logger::LogSQLFile($filename,$str);
	$this->LoggTransactions(date("h:i:s A"),date("F j Y"),$this->username,$strSQL);

     return $valret;

}


function db_query($strSQL="")
{
	$conn = $this->mysql_conn();
	$rs = $conn->Execute($strSQL);
    if($rs){
	   $resultset = $rs->GetArray();
	}
	return $resultset;
}


function WriteUserToDatabase($strSQL="")
{

    $date     = date("Ymd");
    $file =  $date.".sql";
	//$file = "../Logs/".$filename;

    $filename = logger::createLogFile(LOGFILEPATH,$file);
    $conn = $this->connectAsAdminToDatabase();
	//$conn->debug = true;
	$valret = $conn->Execute($strSQL);
	$str    =  $strSQL.";^".$_SESSION['userid']."^".date('Y-m-d H:i:s').PHP_EOL;
	logger::LogSQLFile($filename,$str);
	$this->LoggTransactions(date("h:i:s A"),date("F j Y"),$this->username,$strSQL);

	return $valret;
}


function RunSQLWithTrans($strSQL="",$op="",$username="")
{
   $date     = date("Ymd");
   $file =  $date.".sql";
   //$file = "../Logs/".$filename;
  // $filename = logger::createLogFile(LOGFILEPATH,$file);
    $conn = $this->mysql_conn();
	 $conn->StartTrans();
	  for($j=0;$j<count($strSQL);$j++)
	  {
		 /* if($strSQL[$j] == NULL || $strSQL[$j] == "" || $strSQL[$j] == '')
		  {
			  continue;
		  }*/
		//$conn->debug = true;
	        $conn->Execute($strSQL[$j]);
		   $CheckRecord = $conn->HasFailedTrans();
		   if($CheckRecord){
		       $conn->FailTrans();
		       //$conn->CompleteTrans();
		    return -1;
		   }
		   //@$str    =  $strSQL[$j].";^".$_SESSION['userid']."^".date('Y-m-d H:i:s').PHP_EOL;
	 	   //logger::LogSQLFile($filename,$str);
		}
	  //$conn->debug = true;
	 $conn->CompleteTrans();

	// $this->LoggTransactions(date("h:i:s A"),date("F j Y"),$username,$strSQL);

     return 1;
 }


function RunSQLWithTransRemote($strSQL="",$op="",$username="")
{
   $date     = date("Ymd");
   $file =  $date.".sql";
   //$file = "../Logs/".$filename;

   $filename = logger::createLogFile(LOGFILEPATH,$file);

    $conn = $this->mysql_remoteconn();

	 $conn->StartTrans();

	  for($j=0;$j<count($strSQL);$j++)
	  {
	       //$conn->debug = true;
	       $conn->Execute($strSQL[$j]);
		   $CheckRecord = $conn->HasFailedTrans();
		   if($CheckRecord){
		       $conn->FailTrans();
		       $conn->CompleteTrans();
		    return -1;
		   }
		   $str    =  $strSQL[$j].";^".$_SESSION['userid']."^".date('Y-m-d H:i:s').PHP_EOL;
	 	   logger::LogSQLFile($filename,$str);
		}
	  //$conn->debug = true;
	 $conn->CompleteTrans();

	 $this->LoggTransactions(date("h:i:s A"),date("F j Y"),$username,$strSQL);

     return 1;
 }

 //Clean Content
  function removeQuotesFromString($string="")
 {
    return str_replace("'","`",$string);

 }

}

?>
