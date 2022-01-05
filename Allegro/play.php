<?php 
	session_start(); 
	if(!isset($_SESSION['user'])){
		message("Şarkı çalmadan önce giriş yapmalısınız.","info");
		header("Location: login.php");
		die();
	}


	include 'files/functions.php';

	$user_id = $_SESSION['user']['user_id'];
	$song_id = $_GET['song'];
	record_view($conn,$song_id,$user_id);





	require_once("files/header.php"); 

	$song =$_GET['song'];
	$s = get_top_song_by_song_id($conn,$song);
	$artist_id = $s['artist_id'];
?> 

<div class="container">  
	<ul class="list-group mt-md-3">
	  <li class="list-group-item">
	  	<h2 class="display-4"><?php echo $s['song_name']; ?></h2>
	  </li>
  		  <li class="list-group-item">
		  	<div class="row">
		  		<div class="col-md-2">
		  			<img class="img-fluid rounded"  src="uploads/<?php echo $s['song_photo']; ?>" alt="">
		  		</div>
		  		<div class="col-md-4">
		  			<div class="row">
		  				<div class="col-12">
		  					<b>Şarkı Başlığı:</b> <?php echo $s['song_name']; ?>
		  				</div>
		  				<div class="col-12">
		  					<b>Sanatçı: </b>
			  					<a class="text-dark" href="artist.php?artist_id=<?= $s['artist_id'] ?>" title="<?= $a['artist_name'] ?>"> 
		  							<?php echo $s['artist_name']; ?> 
		  						</a>
		  				</div>
		  				<div class="col-12">
		  					<b>Görüntülenme: </b> <?php echo $s['view_count']; ?>
		  				</div>
		  				<div class="col-12">
		  					<b>İndirilenler: </b> <?php echo $s['download_count']; ?>
		  				</div>
		  			</div>
		  		</div>
		  		<div class="col-md-4">
		  			<audio controls>
					  <source src="horse.ogg" type="audio/ogg">
					  <source src="uploads/<?php echo $s['song_mp3']; ?>" type="audio/mpeg">
					Tarayıcınız desteklememektedir.
					</audio> 
		  		</div>
		  		<div class="col-md-2">
			  		<a class="btn btn-dark btn-block" target="_blank" href="download.php?song=<?= $song_id ?>">Mp3 İndir</a> 
		  		</div>
		  	</div>
		  </li>


	
 
	</ul>


 




	<!-- Latest songs -->
	<ul class="list-group mt-md-3">
	  <li class="list-group-item">
		<h2 class="display-4">Related Songs</h2>
	  </li>
	 <li class="list-group-item">


	 <!-- Laetset songs -->
	 <div class="row">

	  	<?php 
		  	$latest_songs = get_by_artist_id($conn,$artist_id);
	  		$i = 0; foreach ($latest_songs as $key => $s): 
		  	if($i>5)
		  		break;
		  	$i++; ?>

			 	<div class="col-6 col-md-2 rounded mt-3">
			 		<a href="play.php?song=<?php echo($s['song_id']); ?>" title=""><img class="img-fluid rounded"   src="uploads/<?php echo $s['song_photo']; ?>" alt=""></a>
			 	</div>

	 	<?php endforeach ?>
	 </div>

	</li>

	</ul>


</div>


<?php require_once("files/footer.php"); ?> 