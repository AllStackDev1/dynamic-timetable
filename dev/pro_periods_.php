<?php
@session_start();
//include_once("_ss_manager_setup_class_.php");
 include_once('Lib/connect.php');
 include_once("includes/function_periods_.php");
 
 $_SESSION['org'] = 'GSISSCHOOL';
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
 
 //$main = new setup($_SESSION["username"],$_SESSION["profile"]);
 $db = new connection($_SESSION["username"],$_SESSION["password"]);
 $func = new ClassFunction($_SESSION["username"],$_SESSION["password"]);
 

 if($btn == "Load")
 {
   
 	 $fields[0]	 = 'id';
	 $fields[1]	 = 'sz_period';
	 $fields[2]	 = 'sz_periodid';
	 $fields[3]	 = 'sz_classid';
	 $fields[4]	 = 'sz_branchid';
	 $fields[5]	 = 'sz_schoolid';
	 
	 $records = $func->GetAllData();
	 $retval = $db->RunCodeReturnJson($fields,$records);
	echo $retval;  	

 }else 
 
 if($btn == "Save"){

	 $sz_start	 		= $_REQUEST['sz_start'];
	 $sz_end	 		= $_REQUEST['sz_end'];
	 $sz_classid 		= $_REQUEST['sz_classid'];

 
   $add = $func->AddData($sz_start,$sz_end,$sz_classid,$sz_branchid,$sz_schoolid);
   if($add == 1)
  {
    echo "{success: true,errors:{reason:'Period Succesfully Saved.'}}";
    echo '<script type="text/javascript">
    			window.location = "../period_setting.php"
          </script>';
	
  }else
  {
    echo "{success: false,errors:{reason:'Time Range Already Assigned'}}";
  }
 
 
 }else 
    if($btn == "Edit"){
	
	 $class_id   = $_REQUEST['class_id'];
         $res = $func->GetData($id);
	
	 if(count($res) > 0)
     {
		//$id,$start,$end,$duration,$period_id,$periods_bf_f_break,$periods_bf_s_break,$f_break,$s_break,$periods_per_day,$class_id ,$szbranch_id,$szschool_id
		 $param[0]	 = 'id';
		 $param[1]	 = 'start';
		 $param[2]	 = 'end';
		 $param[3]	 = 'duration';
		 $param[4]	 = 'period_id';
		 $param[5]	 = 'periods_bf_f_break';
		 $param[6]	 = 'periods_bf_s_break';
		 $param[7]	 = 'f_break'; 
		 $param[8]	 = 's_break'; 
		 $param[9]   = 'periods_per_day';
		 $param[10]  = 'class_id';  
	     $param[11]  = 'szbranch_id';
		 $param[12]  = 'szschool_id';
		
		$retval = $db->RunCodeReturnJsonRC($param,$res);
		echo $retval;
	 }else
	 {
	       echo "{success: false,errors:{reason:'No Record Found..'}}";
     }   
		
	 
	}else
	   if($btn == "Drop"){
	    
	       $class_id  	= $_REQUEST['class_id'];
	       $szbranch_id = $_REQUEST['szbranch_id'];
	       $szschool_id = $_REQUEST['szschool_id'];
	    $delete = $func->DeleteData($class_id,$szbranch_id,$szschool_id);
 
    if($delete == 1) {
    echo "{success: true,errors:{reason:'Data Succesfully Deleted.'}}";
	
    }else
    {
    echo "{success: false,errors:{reason:'Error Whiles Deleting Data'}}";
   }
 
}else
	if($btn == "Update"){
   
	 $start	 				 = $_REQUEST['start'];
	 $end	 				 = $_REQUEST['end'];
	 $duration	 			 = $_REQUEST['duration'];
	 $period_id	 			 = $_REQUEST['period_id'];
	 $periods_bf_f_break	 = $_REQUEST['periods_bf_f_break'];
	 $periods_bf_s_break	 = $_REQUEST['periods_bf_s_break'];
	 $f_break	 			 = $_REQUEST['f_break']; 
	 $s_break	 			 = $_REQUEST['s_break']; 
	 $periods_per_day  		 = $_REQUEST['periods_per_day'];
	 $class_id 				 = $_REQUEST['class_id'];  
     $szbranch_id  			 = $_REQUEST['szbranch_id'];
	 $szschool_id 			 = $_REQUEST['szschool_id'];
	
	$update = $func->UpdateData($start,$end,$duration,$period_id,$periods_bf_f_break,$periods_bf_s_break,$f_break,$s_break,$periods_per_day,$class_id,$szbranch_id,$szschool_id);
 
     if($update == 1)
	  {
    	echo "{success: true,errors:{reason:'Data Succesfully Saved.'}}";
	
  		}else
  		{
    		echo "{success: false,errors:{reason:'Error Whiles Saving Data'}}";
		}
		  
	}
		 
 
 
?>