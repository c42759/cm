<?php
if (isset($_GET['action'])) {
	$a = $_GET['action'];
} else {
	$a = false;
}

switch ($a) {
	case 'saveName':
		echo json_encode(saveName($_POST['name']));
		break;
	case 'saveNumber':
		echo json_encode(saveNumber($_POST['number']));
		break;
	case 'saveEmail':
		echo json_encode(saveEmail($_POST['email']));
		break;

	default:
		echo json_encode([
			'status' => false,
			'message' => 'Your command doesn\' exist.'
		]);
		break;
}

function saveName ($value) {
	return save ("name.txt", $value);
}

function saveNumber ($value) {
	return save ("number.txt", $value);
}

function saveEmail ($value) {
	return save ("email.txt", $value);
}

function save ($file, $value) {
	$toReturn = [
		'status' => false,
		'message' => ""
	];

	if (!empty($value)) {
		file_put_contents($file, $value . PHP_EOL, FILE_APPEND | LOCK_EX);
		$toReturn['status'] = true;
	} else {
		$toReturn['message'] = 'We found some problems with the value.';
	}

	return $toReturn;
}
