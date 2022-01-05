<?php 
	session_start(); 
	if(!isset($_SESSION['user'])){
		message("Login before you play a song.","info");
		header("Location: login.php");
		die();
	}


	include 'files/functions.php';
	require_once("files/header.php"); 

	$user_id = $_SESSION['user']['user_id'];
	$song_id = $_GET['song'];
	record_dowload($conn,$song_id,$user_id);


	$song =$_GET['song'];
	$s = get_top_song_by_song_id($conn,$song);
?> 

<div class="container">  
	<ul class="list-group mt-md-3">
	  <li class="list-group-item">
	  	<h2 class="display-4"><b>İndirilenler</b> <?php echo $s['song_name']; ?> <b>By</b> <?php echo $s['artist_name']; ?></h2>
	  </li>
  		  <li class="list-group-item">
	  		  	<a class="btn btn-dark btn-block" href="uploads/<?php echo $s['song_mp3']; ?>" download>Mp3 İndir</a> 
		  </li>

  		  <li class="list-group-item">
	  		  	<a class="btn btn-dark btn-block" href="index.php">Ana Sayfa</a> 
		  </li>
	</ul>
</div>


<?php require_once("files/footer.php"); ?> 