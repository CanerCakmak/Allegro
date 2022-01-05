<?php 
	session_start(); 
	include 'files/functions.php';
	if(isset($_SESSION['user'])){
		 
	}else{
		header("Location: login.php");
		die();
	}

	if(isset($_POST['artist_name'])){
		$file_name = "";  

		if(isset($_FILES['artist_photo']['error'])){
			if($_FILES['artist_photo']['error'] == 0){
		 
				$target_dir = "uploads/";
				
				$file_name = time()."_".rand(100000,10000000).rand(100000,10000000)."_".$_FILES["artist_photo"]["name"];

				$file_name = str_replace(" ", "_", $file_name);
 

				$source = $_FILES["artist_photo"]["tmp_name"];
				$destinatin = $target_dir.$file_name;
				
				 if(move_uploaded_file($source, $destinatin)){
				 	 
				 }else{
				 	$file_name = "";
				 }
			}
		}

		$artist_name = $_POST['artist_name'];
		$artist_biography = $_POST['artist_biography'];

		$SQL = "INSERT INTO artist(
						artist_name,artist_biography,artist_photo
					)VALUES(
						'{$artist_name}','{$artist_biography}','{$file_name}'
					)
				";

		if($conn->query($SQL)){
			message("Yeni sanatçı başarıyla eklendi.","success");
		}else{
			message("Yeni sanatçı eklenirken hata oluştu.","warning");
		}

		header("Location: admin_artists.php");
		die();
	}

?>
<?php require_once("files/header.php"); ?> 

<div class="container">
	

	<div class="row pl-0">
		<?php include 'files/admin_side_bar.php'; ?>
		<div class="col-md-8">
			<h2>Yeni Sanatçı Ekleme</h2>

			<form method="post" action="artist_add_new.php" enctype="multipart/form-data">
			  <div class="form-group">
			    <label for="artist_name">Sanatçı Adı</label>
			    <input type="text" name="artist_name" class="form-control" id="artist_name" aria-describedby="emailHelp" placeholder="Sanatçının Adını Giriniz"> 
			  </div>
			  <div class="form-group">
			    <label for="artist_biography">Sanatçı Hakkında</label>
			    <textarea name="artist_biography" class="form-control" id="artist_biography"></textarea>
			  </div>
 
 			  <div class="form-group">
			    <label for="artist_photo">Sanatçının Fotoğrafı</label>
			    <input type="file" accept=".png,.jpg,.jpeg,.gif" name="artist_photo" class="form-control" id="artist_photo" placeholder="Email Giriniz"> 
			  </div>

			  <button type="submit" class="float-right mt-md-3 btn btn-lg btn-dark">Yeni Sanatçı Ekle</button>

			</form>

		</div>
	</div>

</div>


<?php require_once("files/footer.php"); ?> 

  