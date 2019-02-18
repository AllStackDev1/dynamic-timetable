<?php
include('../adodb/adodb.inc.php');
include_once("_logger_.php");
include_once("_databaselogger_.php");

class MainConnect extends databaseTransLogger{



function __construct($username,$szpassword)
 {
      
	     parent::__construct($username,$szpassword);
	    // parent::set_dbuserName($username);
	    //parent::set_dbpassword($szpassword);
		
 }
 

function RunCodeReturnJsonAB($fields="",$res="")
{
   $col = array();
   $var = array();
   $item = array();
   //col = array("");
  for($i=0;$i<count($res);$i++)

  {
     for($u=0;$u<count($fields);$u++)

	 {
	   if($u == 0)
	   {
	        $var = "'".$fields[$u]."':'".$res[$i][$u]."'";
	   }else
	   {
		    $var = $var.",'".$fields[$u]."':'".$res[$i][$u]."'";
	   }
	 }

	 	$item[$i] = '{'.$var.'}';
  }
   echo preg_replace('/"/',' ',json_encode(Array('data'=>$item)));
}


function RunCodeReturnJson($fields="",$res="")
{
   $col = array();
   $var = array();
   
   //col = array("");
   $item = array();
  for($i=0;$i<count($res);$i++)
  {
     
     for($u=0;$u<count($fields);$u++)
	 {
	    $res[$i][$u] = $this->removeQuotesFromString($res[$i][$u]);
	   if($u == 0)
	   {
	        $var = "'".$fields[$u]."':'".$res[$i][$u]."'";
		  
	   }else
	   {
		    @$var = $var.",'".$fields[$u]."':'".$res[$i][$u]."'";
	   }
	   
	   
	 }
	 	$item[$i] = '{'.$var.'}';
		
  }
   
   echo preg_replace('/"/',' ',json_encode(Array('results'=>$item,'totalCount' => count($item))));
}


function RunCodeReturnJsonA($fields="",$res="")
{
   $col = array();
   $var = array();
   
   //col = array("");
  for($i=0;$i<count($res);$i++)
  {
     
     for($u=0;$u<count($fields);$u++)
	 {
	   if($u == 0)
	   {
	        $var = "'".$fields[$u]."':'".$res[$i][$u]."'";
		  
	   }else
	   {
		    $var = $var.",'".$fields[$u]."':'".$res[$i][$u]."'";
	   }
	   
	   
	 }
	 	$item[$i] = '{'.$var.'}';
		
  }
   
   echo preg_replace('/"/',' ',json_encode(Array('data'=>$item)));
}


function RunCodeReturnJsonRC($fields="",$res="")
{
   $col = array();
   $var = array();
   
   //col = array("");
  for($i=0;$i<count($res);$i++)
  {
     
     for($u=0;$u<count($fields);$u++)
	 {
	   if($u == 0)
	   {
	        $var = "".$fields[$u].":'".str_replace("'",'`',$res[$i][$u])."'";
		  
	   }else
	   {
		    $var = $var.",".$fields[$u].":'".str_replace("'",'`',$res[$i][$u])."'";
	   }
	   
	   
	 }
	 	$item[$i] = $var;
		
  }
   
   $retval = str_replace('"',' ',json_encode(Array('success'=>true,'data' => $item)));
   $jsonval1 = str_replace('[','{',$retval);
   $jsonval2 = str_replace (']','}',$jsonval1);
   //str_
   return $jsonval2;
}
 function RunSQL($strSQL =""){
   
     $conn = $this->mysql_conn();
	 //$conn->debug =true;
	 $ok = $conn->Execute($strSQL);
	 
	 //return $ok;
	if(!$ok)
	 {
	   return -1;
	 }else{ 
	    return 1;
	}
	   
}

function RunSQLRetRC($strSQL = "")
{
    $conn = $this->mysql_conn();
	 //$conn->debug =true;
	 $rs = $conn->Execute($strSQL);
	 
	 return $rs->RecordCount();
}

//This is KD function
function RunSQLRetRS($strSQL = "")
{
    $conn = $this->mysql_conn();
	 //$conn->debug =true;
	 $rs = $conn->Execute($strSQL);
	 
	 return $rs;
}


function RunSQLRetRSRow($strSQL = "")
{
    $conn = $this->mysql_conn();
	 //$conn->debug =true;
	 $rs = $conn->Execute($strSQL);
	 
	 if($rs->RecordCount() <= 0)
	 {
	   return -1;
	    
	   }
	    else{ 
	 return $rs->FetchRow();
	 }
}


function RunSQLRetRSArray($strSQL = "")
{
    $conn = $this->mysql_conn();
	 //$conn->debug =true;
	 $rs = $conn->Execute($strSQL);
	 
	if($rs->RecordCount() <= 0)
	 {
	   return -1;
	   }
	    else{ 
	 return $rs->GetArray();
	 }
}


  
 function RunSQLWithTransNew($strSQL="",$strSQL1="",$strSQL2="",$strSQLL="")
{
   $conn = $this->mysql_conn();
	//$conn->debug = true;
	 $conn->StartTrans();
	 $filename = logger::createLogFile();
	 
	  for($u=0;$u<count($strSQL);$u++){
	    $conn->Execute($strSQL[$u]);
		   $CheckRecord = $conn->HasFailedTrans();
		   if($CheckRecord){
		       $conn->FailTrans();
		       $conn->CompleteTrans();
		    return -1;
		   }
		    $str    =  $strSQL[$u]."\n";
	 	   logger::LogSQLFile($filename,$str);	
	       
		}
		
		for($m=0;$m<count($strSQLL);$m++){
	    $conn->Execute($strSQLL[$m]);
		   $CheckRecord = $conn->HasFailedTrans();
		   if($CheckRecord){
		       $conn->FailTrans();
		       $conn->CompleteTrans();
		    return -1;
		   }
		    $str    =  $strSQL[$m]."\n";
	 	   logger::LogSQLFile($filename,$str);
		}
	  //$conn->debug = true;	
	  for($j=0;$j<count($strSQL1);$j++){
	    $conn->Execute($strSQL1[$j]);
		   $CheckRecord = $conn->HasFailedTrans();
		   if($CheckRecord){
		       $conn->FailTrans();
		       $conn->CompleteTrans();
		    return -1;
		   }
		   $str    =  $strSQL[$j]."\n";
	 	   logger::LogSQLFile($filename,$str);
		}
	//$conn->debug = true;
	 for($k=0;$k<count($strSQL2);$k++){
	    $conn->Execute($strSQL2[$k]);
		   $CheckRecord = $conn->HasFailedTrans();
		   if($CheckRecord){
		       $conn->FailTrans();
		       $conn->CompleteTrans();
		    return -1;
		   }
		  $str    =  $strSQL[$k]."\n";
	 	   logger::LogSQLFile($filename,$str); 
		}
		
	 $conn->CompleteTrans();
	
     return 1;  	   
 }
  
function RunSQLWithTransSpecial($strSQL="")
{
   $conn = $this->mysql_conn();
	$filename = logger::createLogFile();//$conn->debug = true;
	 $conn->StartTrans();
	 
	  for($j=0;($j < count($strSQL) - 1);$j++){
		$conn->Execute($strSQL[$j]);
		   $CheckRecord = $conn->HasFailedTrans();
		   if($CheckRecord){
		       $conn->FailTrans();
		       $conn->CompleteTrans();
		    return -1;
		   }
		   $str    =  $strSQL[$j]."\n";
	 	   logger::LogSQLFile($filename,$str); 
		}
		
	 $conn->CompleteTrans();
     return 1;  	   
 } 
 
}

?>