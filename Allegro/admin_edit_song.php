<?php 
	session_start(); 
	include 'files/functions.php';
	if(isset($_SESSION['user'])){
		 
	}else{
		header("Location: login.php");
		die();
	}

	if(isset($_POST["song_name"])){ 
		$song_id = $_POST['song_id'];
		$song =  get_top_song_by_song_id($conn,$song_id);
 
		$song_photo = $song['song_photo'];
		$song_mp3 = $song['song_mp3'];
	 
		if(isset($_FILES['song_photo']['error'])){
			if($_FILES['song_photo']['error'] == 0){
		 
				$target_dir = "uploads/";
				
				$song_photo = time()."_".rand(100000,1000000).rand(10000,10000000)."_".$_FILES["song_photo"]["name"];

				$song_photo = str_replace(" ", "_", $song_photo);
				$song_photo = urlencode($song_photo);
 

				$source = $_FILES["song_photo"]["tmp_name"];
				$destinatin = $target_dir.$song_photo;
				
				 if(move_uploaded_file($source, $destinatin)){
				 	if(file_exists($target_dir.$song['song_photo'])){
				 		unlink($target_dir.$song['song_photo']);
				 	} 
				 }else{ 
				 	$song_photo = $song['song_photo'];
				 }
			}
		}
 

		if(isset($_FILES['song_mp3']['error'])){
			if($_FILES['song_mp3']['error'] == 0){
		 
				$target_dir = "uploads/";
				
				$song_mp3 = time()."_".rand(100000,1000000).rand(10000,10000000)."_".$_FILES["song_mp3"]["name"];

				$song_mp3 = str_replace(" ", "_", $song_mp3);
				$song_mp3 = urlencode($song_mp3);
 

				$source = $_FILES["song_mp3"]["tmp_name"];
				$destinatin = $target_dir.$song_mp3;
				
				 if(move_uploaded_file($source, $destinatin)){
				 	if(file_exists($target_dir.$song['song_mp3'])){
				 		unlink($target_dir.$song['song_mp3']);
				 	} 
				 }else{ 
				 	$song_mp3 = $song['song_mp3'];
				 }
			}
		}

		$song_name = $_POST['song_name'];
		$aritst_id = $_POST['aritst_id'];
		
		$sql = "UPDATE songs SET 
					song_name = '{$song_name}',
					aritst_id = '{$aritst_id}',
					song_photo = '{$song_photo}',
					song_mp3 = '{$song_mp3}'
				WHERE 
					song_id = {$song_id}
		";

		if($conn->query($sql)){ 
			message("Şarkı başarılı bir şekilde güncellenmiştir.","success");
		}else{ 
			message("Şarkı güncellenirken bir şeyler ters gitti.","warning");
		}
		header("Location: admin_songs.php");
		die();
	}

	
	$artists = get_all_artists($conn);
	$song_id = $_GET['song_id'];

	$song =  get_top_song_by_song_id($conn,$song_id);
?>
<?php require_once("files/header.php"); ?> 
<div class="container">
	
<!-- 
	song_date 
 -->
	<div class="row pl-0">
		<?php include 'files/admin_side_bar.php'; ?>
		<div class="col-md-8">
			<h2>Güncelleme  <?php echo($song['song_name']); ?> by <?php echo($song['artist_name']); ?> </h2>

			<form method="post" action="admin_edit_song.php" enctype="multipart/form-data">
			  <div class="form-group">
			    <label for="song_name">Şarkı Adı</label>
			    <input type="text" name="song_name" value="<?php echo($song['song_name']); ?>" class="form-control" id="song_name"  placeholder="Şarkı adı giriniz"> 
			  </div>

			  <input type="text" name="song_id" hidden="" readonly="" value="<?= $song_id ?>" >

			  <div class="form-group">
			    <label for="aritst_id">Sanatçı adı</label>
			    <select name="aritst_id" required="" class="form-control">
			    	<option value=""></option>
			    	<?php foreach ($artists as $key => $a): ?>
			    		
			    		<?php if($a['artist_id'] == $song['artist_id']){ ?>
			    			<option selected="" value="<?php echo($a['artist_id']); ?>"><?php echo($a['artist_name']); ?></option>
			    		<?php }else{ ?>
			    			<option value="<?php echo($a['artist_id']); ?>"><?php echo($a['artist_name']); ?></option>
			    		<?php } ?>
			    		
			    	<?php endforeach ?>
			    </select>
			  </div>
 

 			  <div class="form-group">
			   <div class="row">
			   		<div class="col-md-6">
			   			<label for="song_photo">Şarkı kapağı</label>
					    <input type="file"  name="song_photo" class="form-control" id="song_photo"> 
			   		</div>
			   		<div class="col-md-6">
			   			<img class="rounded" width="100" src="uploads/<?php echo($song['song_photo']); ?>" alt="">
			   		</div>
			   </div>
			  </div>


 			  <div class="form-group">
			   <div class="row">
			   		<div class="col-md-6">
					    <label for="song_mp3">Şarkı mp3 dosyası</label>
					    <input type="file" accept=".mp3" name="song_mp3" class="form-control" id="song_mp3">
			   		</div>
			   		<div class="col-md-6">
			   			<br>
					    <audio controls>
							  <source src="horse.ogg" type="audio/ogg">
							  <source src="uploads/<?php echo $song['song_mp3']; ?>" type="audio/mpeg">
							Tarayıcınız şarkıyı desteklememektedir.
						</audio> 
			   		</div>
			   </div>	 
			  </div>

			  <button type="submit" class="float-right mt-md-3 btn btn-lg btn-dark">Şarkıyı Güncelle</button>

			</form>

		</div>
	</div>

</div>


<?php require_once("files/footer.php"); ?> 

  