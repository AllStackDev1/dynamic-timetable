<?php

    function SubmitForm($db="",$fname="",$lname="",$email="",$phone="",$dob="")
    {
        $strSQL 	= "INSERT INTO `contactform`(`id`, `fname`, `lname`, `email`, `phone`, `dob`) VALUES ('','$fname','$lname','$email','$phone','$dob')";
		$query 		= mysqli_query($db, $strSQL);

		if($query) {
			echo '{"success": true, "message": "Data Successfully Saved"}';
		} else {
			echo '{"success": false, "message": "Error while saving data. Please try again"}';
		}	
    }

    function GetContactFormList($db="")
    {
		$strSQL 	= "SELECT * FROM `contactform`";
		$query 		= mysqli_query($db, $strSQL);
		$numrows 	= @mysqli_num_rows($query);

		if($numrows > 0) {
		    while($row = mysqli_fetch_assoc($query)) {

				$rows[] = $row;
			}
			echo json_encode($rows);
		}else {
			echo '{"success": false, "message": "No Record Found"}';
		}
	}

	function Delete($db="",$id="")
	{
		$strSQL 	= "DELETE FROM `contactform` WHERE `contactform`.`id` = '$id'";
		$query 		= mysqli_query($db, $strSQL);

		if($query) {
			echo '{"success": true, "message": "Data Successfully Deleted"}';
		} else {
			echo '{"success": false, "message": "Error while Deleting data. Please try again"}';
		}	
	}

