<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET,POST,DELETE,PUT");
header("Access-Control-Allow-Credentials: true");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-type,Access-Control-Allow-Headers, Authorization, X-Requested-With");
include('dbconnection.php');
if($_REQUEST['xAction'])
{
	switch ($_REQUEST['xAction']) {
		case 'getAll':
			// code...
			echo getAll();
			break;
		case 'deleteRecord':
			// code...
			echo deleteRecord();
			break;

		case 'insertRecord':
			echo insertRecord();
		break;

		case 'updateRecord':
			echo updateRecord();
		break;
		
		default:
			// code...
			break;
	}
}

function getAll()
{
	global $con;
	if(isset($_REQUEST['id']))
	{
		$sql = mysqli_query($con,"SELECT * FROM students WHERE status = 1 AND id='".$_REQUEST['id']."'");
		if(mysqli_num_rows($sql) > 0)
		{
			$response = array();
			while($row = mysqli_fetch_assoc($sql)){
				$response = $row;
			}
			$data['status'] = 'success';
			$data['record'] = $response;
		}else{
			$data['status'] = 'error';
		}
	}else{

	$sql = mysqli_query($con,"SELECT * FROM students WHERE status = 1");
	
		if(mysqli_num_rows($sql) > 0)
		{
			$response = array();
			while($row = mysqli_fetch_assoc($sql)){
				$response[] = $row;
			}
			$data['status'] = 'success';
			$data['record'] = $response;
		}else{
			$data['status'] = 'error';
		}
	}
	echo json_encode($data);exit();
}

function deleteRecord()
{
	global $con;
	
	$sql = mysqli_query($con,"UPDATE students SET status = 0, dateModified = '".date('Y-m-d H:i:s')."' WHERE id='".$_REQUEST['id']."'");
	if($sql)
	{
		
		$data['status'] = 'success';
		
	}else{
		$data['status'] = 'error';
	}
	echo json_encode($data);exit();
}

function insertRecord()
{
	global $con;
	$inputData = json_decode(file_get_contents("php://input"));
	
	$hobbies = $inputData->hobbyField;
	if(isset($hobbies) && !empty($hobbies))
	{
		$hobbiesList = implode(',', $hobbies);
	}else{
		$hobbiesList = '';
	}

	if(isset($inputData->firstName) && isset($inputData->lastName) && isset($inputData->email))
	{
		$sql = mysqli_query($con,"INSERT INTO students (`firstName`,`lastName`,`email`,`password`,`gender`,`hobbies`,`country`,`dateAdded`) VALUES ('".$inputData->firstName."','".$inputData->lastName."','".$inputData->email."','".$inputData->password."','".$inputData->gender."','".$hobbiesList."','".$inputData->country."','".date('Y-m-d H:i:s')."')");
		if($sql)
		{
			$data['status'] = 'success';
			$data['message'] = 'Record Saved Successfully.';
		}else{
			$data['status'] = 'error';
			$data['message'] = 'Record not inserted.Please try after some time.';
		}
	}else{
		$data['status'] = 'validationError';
		$data['message'] = 'Please enter compulsory fields | First Name, Last Name and Email';
	}
	echo json_encode($data);exit();
}

function updateRecord()
{
	global $con;
	$inputData = json_decode(file_get_contents("php://input"));
	$hobbies = $inputData->hobbyField;
	if(isset($hobbies) && !empty($hobbies))
	{
		$hobbiesList = implode(',', $hobbies);
	}
	if(isset($inputData->firstName) && isset($inputData->lastName) && isset($inputData->email))
	{
		$sql = mysqli_query($con,"UPDATE students SET firstName = '".$inputData->firstName."', lastName = '".$inputData->lastName."', email = '".$inputData->email."', password = '".$inputData->password."', gender = '".$inputData->gender."', hobbies = '".$hobbiesList."', country = '".$inputData->country."', dateModified = '".date('Y-m-d H:i:s')."' WHERE id='".$inputData->id."'");
		if($sql)
		{
			$data['status'] = 'success';
			$data['message'] = 'Record Update Successfully.';
		}else{
			$data['status'] = 'error';
			$data['message'] = 'Record not updated.Please try after some time.';
		}
	}else{
		$data['status'] = 'validationError';
		$data['message'] = 'Please enter compulsory fields | First Name, Last Name and Email';
	}
	echo json_encode($data);exit;
}