<?php

class logger{


public static function createReportFile($reportfilePath="")
{
   if (!file_exists($reportfilePath)) {
          mkdir($reportfilePath, 0777, true);
        }	
}

public static function createLogFile($logFilePath="",$filename="")
{
        @$logFile = $logFilePath.$_SESSION['org'];
        if (!file_exists($logFile)) {
          mkdir($logFile, 0777, true);
        }
	$filename = $logFile."/".$filename;
	//echo $filename;
	$eXist = logger::FileExist($filename);	
	if($eXist == false)
	{
	    //print "Creating the File <br>";
    	$create = fopen($filename, 'w');
		$close = fclose($create);
	}
	
	//print "Returning ".$filename ."<br>";
    return $filename;
}

public static function FileExist($fileName = "")
{
    if(file_exists($fileName))
	{
	    //print "File Already Exist ... <br>";
		return true;
	}else 
	{
	    //print  "File will be created... <br>";
	  	return false;
	}
}

public static function LogSQLFile($fileName="",$data="")
{
 
  
   $Hndl = fopen($fileName,'a');
   fwrite($Hndl,$data,strlen($data));
   //echo "Success, wrote ($data) to file ($fileName)";
   fclose($Hndl);

}

}
?>