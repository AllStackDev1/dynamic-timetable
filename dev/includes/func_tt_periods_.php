<?php
    include_once('../adodb/adodb.inc.php');
    // include_once('Lib/connect.php');	
    // include_once('_func_generalclass_.php');general_Class  	 
	//class TimeTablePeriodsSetup extends general_Class{
    include_once('func_generalfunc_.php');
        
class TimeTablePeriodsSetup extends Academic_MainClass{
 
    private $username;
    private $userpass;

    function __construct($username,$szpassword)
    {
        
        $this->username = $username;
        $this->userpass = $szpassword;
        
        parent::__construct($username,$szpassword);	
        parent::set_dbuserName($username);
        parent::set_dbpassword($szpassword);
        
        // parent::set_App('iKolilu');
    }
    function PeriodExist($sz_range="",$sz_branchid="",$sz_schoolid="")
    {
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        // //create an instance of the connection to the database.
        $conn = $db->mysql_conn();

        $strSQL = "SELECT * FROM `aca_timeperiod_db` WHERE sz_range = '$sz_range' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'";
        //$conn->debug=true;
        $rs= $conn->Execute($strSQL);
        $retval = $rs->RecordCount();
        
        return $retval;
    }

    function FristPeriodExist($sz_branchid="",$sz_schoolid="")
    {
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        // //create an instance of the connection to the database.
        $conn = $db->mysql_conn();

        $strSQL = "SELECT * FROM `aca_timeperiod_db` WHERE sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'";
        //$conn->debug=true;
        $rs= $conn->Execute($strSQL);
        $retval = $rs->RecordCount();
        
        return $retval;
    }

    function GetTimeDiff($sz_starttime="",$sz_endtime="")
    {

        $date1 = DateTime::createFromFormat('H:i A', $sz_starttime)->getTimestamp(); 
        $date2 = DateTime::createFromFormat('H:i A', $sz_endtime)->getTimestamp();

        $sz_duration = abs($date1 - $date2)/60 .' MINS';

        return $sz_duration;
    }

    function AddData($sz_title="",$sz_starttime="",$sz_endtime="")
    {

       $sz_range = $sz_starttime . ' - ' . $sz_endtime;

        // this defines the connection to the database.
        $db = new MainConnect($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $periodExist = $this->PeriodExist($sz_range,$_SESSION['szbranch'],$_SESSION['org']);
        if($periodExist > 0)
        {
            return -2;
        }

        $fristPeriodExist = $this->FristPeriodExist($_SESSION['szbranch'],$_SESSION['org']);
        if($fristPeriodExist == 0)
        {
            $sz_count = 1;
            $sz_duration = $this->GetTimeDiff($sz_starttime,$sz_endtime);

            $strSQL[0] = "INSERT INTO `aca_timeperiod_db`(`sz_count`, `sz_title`, `sz_starttime`, `sz_endtime`, `sz_range`, `sz_duration`, `sz_branchid`, `sz_schoolid`) VALUES ('$sz_count','$sz_title','$sz_starttime','$sz_endtime','$sz_range','$sz_duration','".$_SESSION['szbranch']."','".$_SESSION['org']."')";
            $retval = $db->RunSQLWithTrans($strSQL);   
            return $retval;
        }else
        {
            $strSQL = "SELECT `sz_count` FROM `aca_timeperiod_db` WHERE sz_branchid = '".$_SESSION['szbranch']."' AND sz_schoolid = '".$_SESSION['org']."'";
            
            $rs = $conn->Execute($strSQL);
            if($rs)
            {
                $sys_info = $rs->GetArray();
                $myLastElement = end($sys_info);
            }

            $sz_count = $myLastElement['sz_count'];

            $sz_count = (int)$sz_count + 1;
            $sz_duration = $this->GetTimeDiff($sz_starttime,$sz_endtime);

            $querySQL[0] = "INSERT INTO `aca_timeperiod_db`(`sz_count`, `sz_title`, `sz_starttime`, `sz_endtime`, `sz_range`, `sz_duration`, `sz_branchid`, `sz_schoolid`) VALUES ('$sz_count','$sz_title','$sz_starttime','$sz_endtime','$sz_range','$sz_duration','".$_SESSION['szbranch']."','".$_SESSION['org']."')";
            $retval = $db->RunSQLWithTrans($querySQL);
            return $retval;
        }
    }
    
    function GetAllData(){
        //this defines the connection to the database.
        $db = new MainConnect($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL = "select id, sz_title, sz_starttime, sz_endtime from aca_timeperiod_db where sz_schoolid = '".$_SESSION['org']."' and sz_branchid='".$_SESSION['szbranch']."'";
        $rs = $conn->Execute($strSQL);
        if($rs)
        {
            $sys_info = $rs->GetArray();
        }
        return $sys_info;  
    }
    
    function UpdateData($id="",$sz_title="",$sz_starttime="",$sz_endtime="")
    {
        $sz_range = $sz_starttime . ' - ' . $sz_endtime;
        //this defines the connection to the database.
        $db = new MainConnect($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $sz_duration = $this->GetTimeDiff($sz_starttime,$sz_endtime);

        $strSQL[0] = "UPDATE `aca_timeperiod_db` SET `sz_title`='$sz_title', `sz_starttime`='$sz_starttime', `sz_endtime`='$sz_endtime', `sz_range`='$sz_range', `sz_duration`='$sz_duration'
        WHERE id = '$id' and sz_schoolid='".$_SESSION['org']."' and sz_branchid='".$_SESSION['szbranch']."'";
        $retval = $db->RunSQLWithTrans($strSQL);	 
        return $retval;
    }
    
    function DeleteData($id="")
    {
        //this defines the connection to the database.
        $db = new MainConnect($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL[0] = "delete from aca_timeperiod_db where id='$id' and sz_schoolid='".$_SESSION['org']."' and sz_branchid ='".$_SESSION['szbranch']."'";
        $retval = $db->RunSQLWithTrans($strSQL);	 
        return $retval;
    }
    
    function  GetData($periodid="")
    {
        //this defines the connection to the database.
        $db = new  connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL = "select id, sz_title, sz_starttime, sz_endtime from aca_timeperiod_db where id = '$periodid' and sz_branchid = '".$_SESSION['szbranch']."'  and sz_schoolid = '".$_SESSION['org']."'";
        //$conn->debug=true;
        $rs = $conn->Execute($strSQL);
        
        if($rs){
        $prg_info = $rs->GetArray();
        }
        return $prg_info;
    }

 }
 
?>