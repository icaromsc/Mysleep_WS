<?php
  
    
$data = date("d-m-y");
    
$hora = date("H:i:s");
    
$arquivo = "logs/log_$data.txt";

    
$file_path = "uploads/";
     
    
$file_path = $file_path . basename( $_FILES['uploadedfile']['name']);
    

if(move_uploaded_file($_FILES['uploadedfile']['tmp_name'], $file_path)) {
        
	echo "success";
        
	$texto = "[$hora]> recebido com sucesso \n";
    
} else{
        
	echo "fail";
        
	$texto = "[$hora]> erro ao receber arquivo \n";
    
}

    

$manipular = fopen("$arquivo","a+b");
    
fwrite($manipular, "\n" . $texto);
    
fwrite($manipular, "File path: " . $file_path . "\n");
    
fclose($manipular);

 ?>
