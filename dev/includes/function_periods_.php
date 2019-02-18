<?php
    include_once('../adodb/adodb.inc.php');
    include_once('Lib/connect.php');
    include_once('func_generalfunc_.php');
	
class TimeTablePeriodsSetup extends Academic_MainClass{
 
private $username;
private $userpass;
 	
    function __construct($username,$szpassword){
    	
    	$this->username = $username;
    	$this->userpass = $szpassword;
    	
        parent::__construct($username,$szpassword);
        parent::set_dbuserName($username);
        parent::set_dbpassword($szpassword);
    	
       parent::set_App('iKolilu');
    }

    function PeriodExist($szperiod="",$sz_starttime="",$sz_endtime="")
     {
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        //sz_classgroup
        $part = null;
       
        $strSQL = "select * from aca_timeperiod_db where sz_period='$szperiod' and sz_starttime='$sz_starttime' and sz_endtime='$sz_endtime' and  sz_branchid = '".$_SESSION['szbranch']."' and sz_schoolid = '".$_SESSION['org']."' ".$part;
        //$conn->debug=true;
        $rs= $conn->Execute($strSQL);
        $retval = $rs->RecordCount();
        return $retval;
     }
 
    function AddData($sz_start,$sz_end,$sz_classid,$sz_branchid,$sz_schoolid){
        
        $sz_period = $sz_start . ' - ' . $sz_end;
         $db = new Mysqli('localhost', 'root', '', 'ikolilu_a' );
         $SQL =  mysqli_query($db,"SELECT * FROM `acc_periods` WHERE sz_period = '$sz_period' AND sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'");
                if (mysqli_num_rows($SQL) > 0) {
                    return -2;
                }else{
                    $db = new Mysqli('localhost', 'root', '', 'ikolilu_a' );
                    $SQL =  mysqli_query($db,"SELECT * FROM `acc_periods` WHERE sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'");
                    if (mysqli_num_rows($SQL) == 0) {
                        $sz_periodid = 1;
                        //this defines the connection to the database.
                        $db = new connection($this->username,$this->userpass);
                        //create an instance of the connection to the database.
                        $conn = $db->mysql_conn();
                        $strSQL[0] = "INSERT INTO `acc_periods`(`id`,`sz_period`,`sz_periodid`,`sz_classid`,`sz_branchid`,`sz_schoolid`) VALUES ('','$sz_period','$sz_periodid','$sz_classid','$sz_branchid','$sz_schoolid')";
                        $retval = $db->RunSQLWithTrans($strSQL);   
                        return $retval;
                    }else{
                        $SQL =  mysqli_query($db,"SELECT `sz_periodid` FROM `acc_periods` WHERE sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'");
                        while ($query = mysqli_fetch_array($SQL)) {
                            $sz_periodid = $query['sz_periodid'];
                        }
                        $sz_periodid = $sz_periodid + 1;
                        //this defines the connection to the database.
                        $db = new connection($this->username,$this->userpass);
                        //create an instance of the connection to the database.
                        $conn = $db->mysql_conn();
                        $strSQL[0] = "INSERT INTO `acc_periods`(`id`,`sz_period`,`sz_periodid`,`sz_classid`,`sz_branchid`,`sz_schoolid`) VALUES ('','$sz_period','$sz_periodid','$sz_classid','$sz_branchid','$sz_schoolid')";
                        $retval = $db->RunSQLWithTrans($strSQL);   
                        return $retval;
                    }

                }
    }

    function GetAllData(){
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL = "SELECT * FROM  `acc_periods`";
        //$conn->debug=true;
    	$rs = $conn->Execute($strSQL);
        if($rs){
    	   $sys_info = $rs->GetArray();
    	}
    	return @$sys_info;  
    }
     
    /*function UpdateData($sz_classid,$sz_branchid,$sz_schoolid){
         //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL[0] = "UPDATE `acc_period` SET `start` = '$start', `end` = '$end', `duration` = '$duration', `period_id` = '$period_id', `periods_bf_f_break` = '$periods_bf_f_break', `periods_bf_s_break` = '$periods_bf_s_break',`f_break` = '$f_break', `s_break` = '$s_break', `periods_per_day` = '$periods_per_day' WHERE `sz_classid` = '$sz_classid' AND `sz_branchid` = '$sz_branchid' AND `sz_schoolid` = '$sz_schoolid'";
    	$retval = $db->RunSQLWithTrans($strSQL);	 
    	return $retval;
     
     }*/
     
    function DeleteData($sz_classid,$sz_branchid,$sz_schoolid){
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL[0] = "DELETE FROM `acc_periods` WHERE sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'";
        $retval = $db->RunSQLWithTrans($strSQL);	 
    	return $retval;
    }
     
    function  GetData($sz_classid="",$sz_branchid="",$sz_schoolid=""){
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL = "SELECT * FROM  `acc_periods` WHERE sz_classid = '$sz_classid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'";
        $rs = $conn->Execute($strSQL); 
    	if($rs){
    		$sys_details = $rs->GetArray();
    	}
    	return $sys_details;  
    }
 
 
}
 

 

?>