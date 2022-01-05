<?php  
	session_start();
	include_once ("files/functions.php");
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
 
	//Şifre hashleme
	$password = password_hash($password, PASSWORD_DEFAULT);
	 
	$u  = get_user_by_username($conn,$username);
 
 
 	if(!empty($u)){
 		message("Kullanıcı adı kullanılmakta.","danger");
 		header("Location: login.php");
 		die();
 	}

 	$last_seen = time();
 	$reg_date = time();
 
 	$sql_1 = "INSERT INTO users (
 				username,
 				last_seen,
 				password,
 				first_name, 
 				photo
 				) VALUES (
 				'{$username}',
 				'{$last_seen}',
 				'{$password}',
 				'{$first_name}',
 				''
 			)";

 	if($conn->query($sql_1)){
		$u  = get_user_by_username($conn,$username);
		message("Hesabınız başarıyla oluşturuldu","success");
		$_SESSION['user'] = $u;
		header("Location: my_account.php");
		die();
 	}else{
		message("Hesabınız oluşturmaya çalışırken bir hata oldu. Lütfen tekrar deneyiniz.","danger");
		header("Location: login.php");
		die();
 	}

 ?>