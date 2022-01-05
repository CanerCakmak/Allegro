<?php 
	session_start(); 
	include 'files/functions.php';
	if(isset($_SESSION['user'])){
		 
	}else{
		header("Location: login.php");
		die();
	}

	if(isset($_POST['song_name'])){
		$file_name = "";  
  
		$song_photo = "";
		$song_mp3 = "";

		if(isset($_FILES['song_photo']['error'])){
			if($_FILES['song_photo']['error'] == 0){
		 
				$target_dir = "uploads/";
				
				$song_photo = time()."_".rand(100000,10000000).rand(100000,10000000)."_".$_FILES["song_photo"]["name"];

				$song_photo = str_replace(" ", "_", $song_photo);
				$song_photo = urlencode($song_photo);
 

				$source = $_FILES["song_photo"]["tmp_name"];
				$destinatin = $target_dir.$song_photo;
				
				 if(move_uploaded_file($source, $destinatin)){
				 	 
				 }else{
				 	$song_photo = "";
				 }
			}
		}


		if(isset($_FILES['song_mp3']['error'])){
			if($_FILES['song_mp3']['error'] == 0){
		 
				$target_dir = "uploads/";
				
				$song_mp3 = time()."_".rand(100000,10000000).rand(100000,10000000)."_".$_FILES["song_mp3"]["name"];

				$song_mp3 = str_replace(" ", "_", $song_mp3);
				$song_mp3 = urlencode($song_mp3);
 

				$source = $_FILES["song_mp3"]["tmp_name"];
				$destinatin = $target_dir.$song_mp3;
				
				 if(move_uploaded_file($source, $destinatin)){
				 	 
				 }else{
				 	$song_mp3 = "";
				 }
			}
		}

		$song_date = time();

		$song_name = $_POST['song_name'];
		$aritst_id = $_POST['aritst_id'];
 
		$SQL = "INSERT INTO songs(
						song_mp3,song_photo,aritst_id,song_name
					)VALUES(
						'{$song_mp3}','{$song_photo}','{$aritst_id}','{$song_name}'
					)
				";

		if($conn->query($SQL)){ 
			message("Yeni şarkı başarıyla eklendi.","success");
		}else{ 
			message("Yeni şarkı eklenirken bir hata oluştu.","warning");
		}

		header("Location: admin_songs.php");
		die();
	}

	$artists = get_all_artists($conn);
?>
<?php require_once("files/header.php"); ?> 
<div class="container">
	
<!-- 
		song_date		
 -->
	<div class="row pl-0">
		<?php include 'files/admin_side_bar.php'; ?>
		<div class="col-md-8">
			<h2>Yeni Şarkı Yükle</h2>

			<form method="post" action="admin_song_upload.php" enctype="multipart/form-data">
			  <div class="form-group">
			    <label for="song_name">Şarkı Adı</label>
			    <input type="text" name="song_name" class="form-control" id="song_name"  placeholder="Şarkı ismi girin"> 
			  </div>


			  <div class="form-group">
			    <label for="aritst_id">Sanatçı Adı</label>
			    <select name="aritst_id" required="" class="form-control">
			    	<option value=""></option>
			    	<?php foreach ($artists as $key => $a): ?>
			    		<option value="<?php echo($a['artist_id']); ?>"><?php echo($a['artist_name']); ?></option>
			    	<?php endforeach ?>
			    </select>
			  </div>
 

 			  <div class="form-group">
			    <label for="song_photo">Şarkı Kapağı</label>
			    <input type="file"  name="song_photo" class="form-control" id="song_photo"> 
			  </div>


 			  <div class="form-group">
			    <label for="song_mp3">Şarkı mp3 Dosyası</label>
			    <input type="file" accept=".mp3" name="song_mp3" class="form-control" id="song_mp3"> 
			  </div>

			  <button type="submit" class="float-right mt-md-3 btn btn-lg btn-dark">Ekle</button>

			</form>

		</div>
	</div>

</div>


<?php require_once("files/footer.php"); ?> 

  