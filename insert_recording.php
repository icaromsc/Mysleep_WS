<?php 
/** * Including and configuring database connection */

include_once 'MySQL.php'; 

$database = 'yourDataBase'; 

$username = 'yourUserName'; 

$password = '$$$$$$'; 
// * Receiving message and decoding json * *  



//$js = array("id_user_facebook"=>"1391044094281431","id_user_google"=>"","name"=>"Ícaro Castro","email"=>"icaromsc@hotmail.com","smartphone_info"=>"");

//$enc = json_encode($js);

//$str = file_get_contents('http://angelo.inf.ufrgs.br/snorlax/insert_recording.json');



$data = json_decode(file_get_contents('php://input'), true); 


//$data=json_decode($str,true); 



if(isset($data)){ 
/** * verify if json info are on database and return id user on json response */ 
	
	$db = new MySQL($database, $username, $password); 
	
	$table = 'recordings';
	$arrayToInsert = [ 'id_recording_app' => $data['id_recording_app'],'status'=> 'M', 
	'id_user' => $data['id_user'], 'date_start' => $data['date_start'], 'date_stop' => $data['date_stop'], 
	'n_files'=> $data['n_files']]; 
	
	$db->insert($table, $arrayToInsert); 
	
	$id = $db->lastInsertID(); 
	
	$response = array("result"=>$db->lastInsertID()); 
	
	echo json_encode($response); 
	 

} else { 
	
	$response = array("result"=>0); 
	
	echo json_encode($response); 

}
?>