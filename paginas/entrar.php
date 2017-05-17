<?php 
$username = $_POST['username']; 
$password = $_POST['password']; 
$submit = $_POST['login']; 

if ($submit){
	
    $con = mysql_connect("127.0.0.1","root","ascent"); 
    mysql_select_db("auth", $con); 
    $result = mysql_query("SELECT * FROM account"); 
     
    while ($row = mysql_fetch_array($result)) 
		{ 
         
			$username = $row['username']; 
			$password = $row['sha_pass_hash']; 
			
			header("location:../index.html");  
		}

} 
?>