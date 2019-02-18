<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

require_once 'controllar_.php';
require_once 'func_contactform.php';

// client request..
$apiPathURL = trim($_SERVER['REQUEST_URI']);

$construct = new CreateFunction($apiPathURL);

$functionName = $construct->GetEndPoint();

$db = new mysqli('localhost','root', '','contact_form');

switch($functionName) {
	case 'SubmitForm':
		$fname 	= $_REQUEST['fname'];
		$lname 	= $_REQUEST['lname'];
		$email 	= $_REQUEST['email'];
		$phone 	= $_REQUEST['phone'];
		$dob 	= $_REQUEST['dob'];
		return SubmitForm($db,$fname,$lname,$email,$phone,$dob);
		break;
	case 'GetContactFormList':
		return GetContactFormList($db);
		break;
	case 'RemoveItem':
		$id 	= $_REQUEST['id'];
		return Delete($db,$id);
		break;
	default:
		echo '{"success": false, "message": "No End Point Found"}';
}
