<?php 
	session_start(); 
	if(isset($_SESSION['user'])){
		//echo("<pre>Logged in");
		//print_r($_SESSION['user']); 
	}else{
		header("Location: login.php");
		die();
	}
	include 'files/functions.php';
	$songs = get_all_songs($conn);
?>
<?php require_once("files/header.php"); ?> 

<div class="container">
 
	<div class="row">
		<?php include 'files/admin_side_bar.php'; ?>
		<div class="col-md-8">
			<h2>Tüm Şarkılar</h2>

			<a href="admin_song_upload.php" class="btn btn-dark float-right mt-md-3 mb-md-3">
				Yeni Şarkı Ekle
			</a>
 
			<table class="table table-bordered">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col" style="width: 30%;">Kapak</th>
			      <th scope="col">Şarkı Başlığı</th>
			      <th scope="col" style="width: 20%;">Sanatçı</th>
			      <th scope="col" style="width: 20%;">Aksiyonlar</th>
			    </tr>
			  </thead>
			  <tbody>
			  	<?php foreach ($songs as $key => $a): ?>
				    <tr>
				      <th scope="row"><img class="img-fluid rounded" width="100%" src="uploads/<?php echo $a['song_photo']; ?>" alt=""></th>
				      <td><?php 
				      	echo $a['song_name']; 
				      ?></td>
				      <td><?php 
				      	echo $a['artist_name']; 
				      ?></td>
				      <td><div class="btn-group btn-group-sm">
				      	<a target="_blank" href="play.php?song=<?php echo($a['song_id']); ?>" title="<?php echo $a['song_name']; ?> By <?php echo $a['artist_name']; ?>" class="btn btn-primary"  >Görüntüle</a>
				      	<a href="admin_edit_song.php?song_id=<?php echo($a['song_id']); ?>" class="btn btn-dark" title="">Düzenle</a>
				      	<a href="admin_delete_process.php?song_id=<?php echo($a['song_id']); ?>" class="btn btn-danger" title="">Sil</a>
				      </div></td>
				    </tr> 
			  	<?php endforeach ?>
			  </tbody>
			</table>

	 

		</div>
	</div>

</div>


<?php require_once("files/footer.php"); ?> 

  