<?php 
	session_start();  
	
	if(!isset($_GET['artist_id'])){
		header("Location: index.php");
		die();
	} 
	
	include 'files/functions.php'; 
	$artist_id = $_GET['artist_id'];
	$artist = get_artist_by_artist_id($conn,$artist_id);
   
	require_once("files/header.php"); 
?> 

<div class="container">  
	<ul class="list-group mt-md-3">
	  <li class="list-group-item">
	  	<h2 class="display-4"><?php echo $artist['artist_name']; ?></h2>
	  </li>
  		  <li class="list-group-item">
		  	<div class="row">
		  		<div class="col-md-6">
		  			<img class="img-fluid rounded"  src="uploads/<?php echo $artist['artist_photo']; ?>" alt="">
		  		</div>
		  		<div class="col-md-6">
		  			<div class="row">
		  				<div class="col-12">
		  					<b>Sanatçı Adı:</b> <?php echo $artist['artist_name']; ?>
		  				</div>
		  				<div class="col-12 ">
		  					<b>Hakkında:</b> <?php echo $artist['artist_biography']; ?>
		  				</div>  
		  			</div>
		  		</div>  
		  	</div>
		  </li>


	
 
	</ul>


 




	<!-- Latest songs -->
	<ul class="list-group mt-md-3">
	  <li class="list-group-item">
		<h2 class="display-4">Son Şarkılar <b><?php echo $artist['artist_name']; ?></b></h2>
	  </li>
	 <li class="list-group-item">


	 <!-- Laetset songs -->
	 <div class="row">

	  	<?php 
		  	$latest_songs = get_by_artist_id($conn,$artist_id);

		  	if(empty($latest_songs)){ ?>

		  			<div class="col-12">
		  				<div class="jumbotron">
			  				<h2>Üzgünüm!</h2>
			  				<hr>
			  				<p>Bu şarkıcının bir şarkısı yok!</p>
			  				<a href="index.php" class="btn btn-dark mt-3 mb-4 float-right" title="">Tüm Şarkılara Gözat</a>
			  			</div>
		  			</div>

		  	<?php }else{
		  		$i = 0; foreach ($latest_songs as $key => $s): 
			  	if($i>5)
			  		break;
			  	$i++; ?>

				 	<div class="col-6 col-md-2 rounded mt-3">
				 		<a href="play.php?song=<?php echo($s['song_id']); ?>" title=""><img class="img-fluid rounded"   src="uploads/<?php echo $s['song_photo']; ?>" alt=""></a>
				 	</div>

		 		<?php endforeach ?>
		 <?php } ?>
	 </div>

	</li>

	</ul>


</div>


<?php require_once("files/footer.php"); ?> 