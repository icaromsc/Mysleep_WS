<?php 
/** * Including and configuring database connection */

include_once 'MySQL.php'; 

$database = 'yourDataBase'; 

$username = 'yourUserName'; 

$password = '$$$$$'; 


// * Receiving message and decoding json * *  
//

$js = array("id_user_facebook"=>"1391044094281431","id_user_google"=>"","name"=>"Ícaro Castro","email"=>"icaromsc@hotmail.com","smartphone_info"=>"");


//$enc = json_encode($js);

//$str = file_get_contents('http://angelo.inf.ufrgs.br/snorlax/login.json');
//$data=json_decode($str,true);




$data = json_decode(file_get_contents('php://input'), true); 



if(isset($data)){ 
/** * verify if json info are on database and return id user on json response */ 
	
	$db = new MySQL($database, 
	$username, $password); 
	
	$table = 'users'; 
	
	$arrayToSelect = ['id_user_facebook' => $data['id_user_facebook'], 'id_user_google' => $data['id_user_google']]; 	 
	
	$query = "SELECT id_user from users WHERE ";


	
	if($arrayToSelect['id_user_facebook']== null){
		
		
		$query=$query."id_user_google='".$arrayToSelect['id_user_google']."';";
	
	
	}else{

		
		$query=$query."id_user_facebook ='".$arrayToSelect['id_user_facebook']."';";
	
	}
	
	//$query = "SELECT id_user from users WHERE id_user_facebook ='".$arrayToSelect['id_user_facebook']."' OR id_user_google='".$arrayToSelect['id_user_facebook']."';";
	
	
	$result= mysql_query($query); 
	
	
	if (mysql_num_rows($result)>0) {	
		
		$row = mysql_fetch_array($result); 
		
		$response = array("result"=>$row['id_user']); 
		
		echo json_encode($response); 
	
	}else{ // nao possui cadastro 
		
		
		
		$arrayToInsert = [ 'id_user_facebook' => $data['id_user_facebook'], 'id_user_google' => $data['id_user_google'], 'name' => $data['name'], 'email' => $data['email']]; 
		
		$db->insert($table, $arrayToInsert); 
		
		
		$id = $db->lastInsertID(); 
		
		$response = array("result"=>$db->lastInsertID()); 
		
		
		echo json_encode($response); 
	
	} 


} else { 

	
	$response = array("result"=>0); 
	echo json_encode($response); 

}
?>
