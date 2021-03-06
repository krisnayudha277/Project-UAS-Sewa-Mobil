<?php
header("Access-Control-Allow-origin: *");
header("Content-Type: application/json; charset=UTF-8");

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$stmt = $user->read();
$num = $stmt->rowCount();

if ($num>0) {
	$users_arr = array();
	$users_arr["records"] = array();

	while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
		extract($row);
		$user_item = array(
			"id_user" => $id_user,
			"username" => $username,
			"name" => $name,
			"nik" => $nik,
			"email" => $email,
			"no_telp" => $no_telp,
			"jenis_kelamin" => $jenis_kelamin,
			"alamat" => $alamat,
			"password" => $password
		);
		array_push($users_arr["records"], $user_item);
	}

	http_response_code(200);
	echo json_encode($users_arr);
}else{
	http_response_code(404);
	echo json_encode(
		array("message" => "User Tidak Di Temukan")
	);

}
?>