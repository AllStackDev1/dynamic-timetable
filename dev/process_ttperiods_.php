<?php
@session_start();
//include_once("_ss_manager_setup_class_.php");
//  include_once('Lib/connect.php');
 include_once("includes/func_tt_periods_.php");
 
  $_SESSION['org'] = 'GSISSCHOOL';
  $_SESSION['szbranch'] = '5';
  $_SESSION['userid'] = 'Nedu';
  $_SESSION["username"] = '';
  $_SESSION["password"] = '';
  
$c_user = isset($_SESSION["userid"]) ? $_SESSION["userid"] : false;	   
if(!$c_user) 
{
     session_destroy();
     ob_start();
     header("Location: ../eUserLog/index.html");
     ob_flush();
}


 $btn = isset($_REQUEST["btn"]) ? $_REQUEST["btn"] : false;	 
   
 if(!$btn) 
 {
     echo '{"success":false,"error":"No command"}';
     exit;
 }	
 
 $db = new connection($_SESSION["username"],$_SESSION["password"]);
 $func = new TimeTablePeriodsSetup($_SESSION["username"],$_SESSION["password"]);
 

 if($btn == "Load")
 {
    
     $fields[0] = 'id';
     $fields[1] = 'sz_period'; //sz_period, sz_starttime, sz_endtime
     $fields[2] = 'sz_starttime';
     $fields[3] = 'sz_endtime';
     $fields[4] = 'sz_classid';
     $fields[5] = 'sz_branchid';
     $fields[6] = 'sz_schoolid';
     
        
     $ret = $func->GetAllData(); 
     $retval = $db->RunCodeReturnJson($fields,$ret);
     
     return $retval;
 } else if($btn == "Save")
 {
      $sz_title      = $_REQUEST['tt_period'];
      $sz_starttime  = $_REQUEST['pstartstime'];
      $sz_endtime    = $_REQUEST['penddtime'];
         
     $retval = $func-> AddData($sz_title,$sz_starttime,$sz_endtime);

  if($retval == 1){
    echo "{success: true,errors:{reason:'Data Successfully Saved'}}";
  }else if($retval == -2)
  {
       echo "{success: true,errors:{reason:'Period Already Allocated'}}";
  }else
  {
    echo "{failure: true,errors:{reason:'Error Saving Data'}}";
  }
    
 }else if($btn == "Update")
 {
    $id            = $_REQUEST['pall_tpid'];
    $sz_title      = $_REQUEST['tt_period'];
    $sz_starttime  = $_REQUEST['pstartstime'];
    $sz_endtime    = $_REQUEST['penddtime'];

    $retval = $func->UpdateData($id,$sz_title,$sz_starttime,$sz_endtime);

    if($retval == 1){

      echo "{success: true,errors:{reason:'Data Successfully Updated'}}";
    }else {

      echo "{failure: true,errors:{reason:'Error Updating Data'}}";
    }
    
 }else if($btn == "Edit")
 {
      $id = $_REQUEST['id'];
       $res = $func->GetData($id);
	
	 if(count($res) > 0)
        {
		////sz_period, sz_starttime, sz_endtime
            $fields[0] = 'id';
            $fields[1] = 'sz_period';
            $fields[2] = 'sz_starttime';
            $fields[3] = 'sz_endtime';
          
	
		$retval = $db->RunCodeReturnJsonRC($fields,$res);
		echo $retval;
	 }else
	 {
			echo "{success: false,errors:{reason:'No Record Found..'}}";
     }
     
 }else if ($btn == "Delete")
{
 
   $id = $_REQUEST['id'];
   $records = $func->DeleteData($id);
  
   if ($records == 1)
{
echo "{success: true,errors:{reason:'Data Successfully Deleted'}}";
}

else{
 
 echo "{failure: true,errors:{reason:'Errror Deleting Data'}}";
 
}
}
 