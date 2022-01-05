<?php 
session_start();
include("files/functions.php");
$username = $_POST['username'];
$password = $_POST['password'];
$u = get_user_by_username($conn,$username);
if(empty($u)){
	message("Böyle bir kullanıcı bulunamadı.","danger");
	header('location: login.php');
	die();
} 

$hash = $u['password'];
if(password_verify($password, $hash)){ 
	message("Başarıyla hesabınıza giriş yapıldı.","success");
	$_SESSION['user'] = $u;
	header("Location: my_account.php");
	die();
}else{
	message("Yanlış şifreyi kullandınız.","danger");
	header('location: login.php');
	die();
}