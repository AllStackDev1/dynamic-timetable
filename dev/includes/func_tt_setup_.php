<?php
    include_once('../adodb/adodb.inc.php');
    // include_once('Lib/connect.php');    
    // include_once('_func_generalclass_.php');general_Class     
    //class TimeTablePeriodsSetup extends general_Class{
    include_once('func_generalfunc_.php');
        
class TimeTableSetup extends Academic_MainClass{
 
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

    function isPeriodAllocated($sz_range="",$sz_dayidArrtoStr="",$sz_branchid="",$sz_schoolid="") {
        
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();

        $strSQL = "SELECT * FROM `acc_timetable_tb` WHERE sz_range = '$sz_range' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'  AND sz_day IN('$sz_dayidArrtoStr')";
        // $conn->debug=true;
        $rs= $conn->Execute($strSQL);
        $retval = $rs->RecordCount();
        return $retval;
    }

    function isTeacherFree($sz_range="",$sz_teacherid="",$sz_dayidArrtoStr="",$sz_branchid="",$sz_schoolid="") {
        
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();

        $strSQL = "SELECT * FROM `acc_timetable_tb` WHERE sz_range = '$sz_range' AND sz_branchid = '$sz_branchid' AND sz_teacherid = '$sz_teacherid' AND sz_schoolid = '$sz_schoolid'  AND sz_day IN('$sz_dayidArrtoStr')";
        // $conn->debug=true;
        $rs= $conn->Execute($strSQL);
        $retval = $rs->RecordCount();
        return $retval;
    }

    function isClassRoomFree($sz_range="",$sz_roomno="",$sz_dayidArrtoStr="",$sz_branchid="",$sz_schoolid="") {
        
        if ($sz_roomno == '' || $sz_roomno == "" || $sz_roomno == null) {
            
            return 0;
        }

        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();

        $strSQL = "SELECT * FROM `acc_timetable_tb` WHERE sz_range = '$sz_range' AND sz_roomno = '$sz_roomno' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'  AND sz_day IN('$sz_dayidArrtoStr')";
        // $conn->debug=true;
        $rs= $conn->Execute($strSQL);
        $retval = $rs->RecordCount();
        return $retval;
    }

    function AddData($sz_days="",$sz_range="",$sz_itemid="",$sz_item="",$sz_teacherid="",$sz_teachername="",$sz_roomno="",$sz_group="",$sz_class="",$sz_term="",$sz_acayear=""){

        $count = count($sz_days);
        $sz_dayidArrtoStr = implode("','", $sz_days);

        //this defines the connection to the database.
        $db = new MainConnect($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();

        // Check to see if a period has already been allocated to some thing on that particular day
        $isperiodAllocated = $this->isPeriodAllocated($sz_range,$sz_dayidArrtoStr,$_SESSION['szbranch'],$_SESSION['org']); 
        
        if($isperiodAllocated > '0')
        {
            return -2; // Period Has Already Been Allocated To an Item
        }

        if ( $sz_teacherid == '0') 
        { //Period with no teacher assigned: Free Period, Break Period, Assembly Period, Close Period

            $strSQL[0] = "INSERT INTO `acc_timetable_tb`(`sz_range`, `sz_itemid`, `sz_item`, `sz_teacherid`, `sz_teachername`, `sz_day`, `sz_roomno`, `sz_group`, `sz_class`, `sz_branchid`, `sz_schoolid`, `sz_term`, `sz_acayear`) VALUES"; 
            for($i = 0; $i < $count; $i++) {
                $strSQL[0] .= "('$sz_range','$sz_itemid','$sz_item','$sz_teacherid','$sz_teachername','$sz_days[$i]','$sz_roomno','$sz_group','$sz_class','".$_SESSION['szbranch']."','".$_SESSION['org']."','$sz_term','$sz_acayear')";
                if($i < ($count -1 )){
                    $strSQL[0] .=",";
                }
            }
            $retval = $db->RunSQLWithTrans($strSQL);
            return $retval;

        }else
        {
            // Check to see if a teacher has already been allocated to a class on a particular period of the day 
            $isteacherFree = $this->isTeacherFree($sz_range,$sz_teacherid,$sz_dayidArrtoStr,$_SESSION['szbranch'],$_SESSION['org']); 
            
            if($isteacherFree > '0')
            {
                return -3; // Teacher Has Already Been Assigned to a Class a particular period of the day

            }else{

                $isclassFree = $this->isClassRoomFree($sz_range,$sz_roomno,$sz_dayidArrtoStr,$_SESSION['szbranch'],$_SESSION['org']); 
                
                if($isclassFree > '0')
                {
                    return -4; // Room for lecture Has Already Been Assign for use at a particular period of the day to Another Item
                }

                $strSQL[0] = "INSERT INTO `acc_timetable_tb`(`sz_range`, `sz_itemid`, `sz_item`, `sz_teacherid`, `sz_teachername`, `sz_day`, `sz_roomno`, `sz_group`, `sz_class`, `sz_branchid`, `sz_schoolid`, `sz_term`, `sz_acayear`) VALUES"; 
                
                for($i = 0; $i < $count; $i++) {
                    $strSQL[0] .= "('$sz_range','$sz_itemid','$sz_item','$sz_teacherid','$sz_teachername','$sz_days[$i]','$sz_roomno','$sz_group','$sz_class','".$_SESSION['szbranch']."','".$_SESSION['org']."','$sz_term','$sz_acayear')";
                    if($i < ($count -1 )){
                        $strSQL[0] .=",";
                    }
                }

                $retval = $db->RunSQLWithTrans($strSQL);   
                return $retval;
            }
        }
    }

    function DeletePeriod($sz_periodid="",$sz_class="",$sz_branchid="",$sz_schoolid=""){

        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL[0] = "DELETE FROM `acc_timetable_tb` WHERE sz_periodid = '$sz_periodid' AND sz_class = '$sz_class' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'";
        $retval = $db->RunSQLWithTrans($strSQL);
        return $retval;
    }

    function DeleteDayPeriod($sz_periodid="",$sz_dayid="",$sz_class="",$sz_branchid="",$sz_schoolid=""){

        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL[0] = "DELETE FROM `acc_timetable_tb` WHERE sz_periodid = '$sz_periodid' AND sz_class = '$sz_class' AND sz_dayid = '$sz_dayid' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'";
        $retval = $db->RunSQLWithTrans($strSQL);
        return $retval;
    }

    function DropPeriods($sz_class="",$sz_branchid="",$sz_schoolid=""){
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL[0] = "DELETE FROM `acc_periods` WHERE sz_class = '$sz_class' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid'";
        $retval = $db->RunSQLWithTrans($strSQL);
        return $retval;
    }

    function DeleteGroupT($sz_group="",$sz_class=""){
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL[0] = "DELETE FROM `acc_timetable_tb` WHERE sz_group = '$sz_group' AND  sz_class = '$sz_class' AND sz_branchid = '".$_SESSION['szbranch']."' AND sz_schoolid = '".$_SESSION['org']."'";
        $retval = $db->RunSQLWithTrans($strSQL);
        return $retval;
    }

    function DeleteClassT($sz_class=""){
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL[0] = "DELETE FROM `acc_timetable_tb` WHERE sz_class = '$sz_class' AND sz_branchid = '".$_SESSION['szbranch']."' AND sz_schoolid = '".$_SESSION['org']."'";
        $retval = $db->RunSQLWithTrans($strSQL);
        return $retval;
    }

    function DeleteTimetable(){
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL = "DELETE FROM `acc_timetable_tb`";
        // $conn->debug=true;
        $retval = $db->RunSQLWithTrans($strSQL);
        // return $retval;
        print_r($retval);
    }

    function GetAllData($sz_class){
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();

        $strSQL = "SELECT `sz_range` FROM `aca_timeperiod_db` WHERE sz_branchid = '".$_SESSION['szbranch']."' AND sz_schoolid = '".$_SESSION['org']."'";
        // $conn->debug=true;
        $rs= $conn->Execute($strSQL);
        $retval = $rs->RecordCount();

        // $strSQL[0] = "SELECT * FROM `acc_timetable_tb` WHERE"; 
                
        // for($i = 0; $i < $retval; $i++) {
        //     $strSQL[0] .= "sz_range = '$i' AND sz_class = '$sz_class' AND  sz_branchid = '".$_SESSION['szbranch']."' AND sz_schoolid = '".$_SESSION['org']."'";
        //     if($i < ($count -1 )){
        //         $strSQL[0] .=",";
        //     }
        // }

        for($i = 0; $i < $retval; $i++){
            $strSQL2[$i] = "SELECT * FROM `acc_timetable_tb` WHERE sz_range = '$i' AND sz_class = '$sz_class' AND  sz_branchid = '".$_SESSION['szbranch']."' AND sz_schoolid = '".$_SESSION['org']."'";
        }
        // print_r($strSQL2);

        // $strSQL = "SELECT * FROM `acc_timetable_tb` WHERE sz_range = '7:30 - 8:00'";
        $conn->debug=true;
        $rs = $conn->Execute($strSQL);
        if($rs){
           $sys_info = $rs->GetArray();
        }
         print_r($sys_info);
    }

    function  GetTimeTableData($count="",$sz_range="",$sz_class="",$sz_term=""){
        $sz_count = $count + 1;
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL[0] = "SELECT `sz_day`, `sz_item` FROM `acc_timetable_tb` WHERE sz_range = '$sz_range'  AND sz_class = '$sz_class' AND sz_term = '$sz_term' AND sz_branchid = '".$_SESSION['szbranch']."'
        AND sz_schoolid = '".$_SESSION['org']."' ORDER BY FIELD(`sz_day`, 'MONDAY', 'TUESDAY', 'WEDNESDAY', 'THURSDAY', 'FRIDAY', 'SATURDAY', 'SUNDAY')";
        
        $rs = $conn->Execute($strSQL[0]);
        if($rs){
            $sys_details = $rs->GetArray();
        }

        $value = '{"term":"'.$sz_term.'","sz_period":"PERIOD '.$sz_count.'",';
        for($i = 0; $i < count($sys_details); $i++) {
            $value .= '"sz_range":"'.$sz_range.'",';
            $value .= '"sz_'.strtolower($sys_details[$i]['sz_day']).'":"'.$sys_details[$i]['sz_item'].'",';  
        }
        $value = chop($value, ",");
        $value .= '}';
        return $value;
        
    }
   
    function UpdateData($sz_period="",$sz_dayid="",$sz_teacherid="",$sz_per_allo="",$sz_class="",$sz_branchid="",$sz_schoolid=""){
        //this defines the connection to the database.
        $db = new connection($this->username,$this->userpass);
        //create an instance of the connection to the database.
        $conn = $db->mysql_conn();
        $strSQL[0] = " UPDATE `acc_timetable_tb` SET `sz_per_allo`='$sz_per_allo',`sz_teacherid`='$sz_teacherid' WHERE sz_class = '$sz_class' AND sz_branchid = '$sz_branchid' AND sz_schoolid = '$sz_schoolid' AND sz_period = '$sz_period' AND sz_dayid = '$sz_dayid'";
        $retval = $db->RunSQLWithTrans($strSQL);     
         return $retval;            
    }
 }
 
?>