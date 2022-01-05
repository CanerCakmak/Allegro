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
	$artists = get_all_artists($conn);
?>
<?php require_once("files/header.php"); ?> 

<div class="container">
	

	<div class="row">
		<?php include 'files/admin_side_bar.php'; ?>
		<div class="col-md-8">
			<h2>Tüm Sanatçılar</h2>
 
			<a href="artist_add_new.php" class="btn btn-dark float-right mt-md-3 mb-md-3">
				Yeni sanatçı ekle
			</a>

			<table class="table table-bordered">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col" style="width: 15%;">Fotoğraf</th>
			      <th scope="col">İsim</th>
			      
			    </tr>
			  </thead>
			  <tbody>
			  	<?php foreach ($artists as $key => $a): ?>
				    <tr>
				      <th scope="row"><img class="img-fluid rounded-circle" width="100%" src="uploads/<?php echo $a['artist_photo']; ?>" alt=""></th>
				      <td><?php 
				      	echo $a['artist_name']; 
				      ?></td>
				      
				    </tr> 
			  	<?php endforeach ?>
			  </tbody>
			</table>

	 

		</div>
	</div>

</div>


<?php require_once("files/footer.php"); ?> 

  