<?php

    include_once('../adodb/adodb.inc.php');
    //include_once('connect.php');
    include_once("_databaselogger_.php");
    //include_once('../defines/defines.php');
    //include_once('_logger_.php');



class Main_GeneralClass extends databaseTransLogger{


private $username;
private $userpass;
private $OrgIdentity;

 function __construct($username,$szpassword)
 {
	 $this->username = $username;
	 $this->userpass = $szpassword;

    parent::__construct($username,$szpassword);
    parent::set_dbuserName($username);
    parent::set_dbpassword($szpassword);

 }


}


?>
