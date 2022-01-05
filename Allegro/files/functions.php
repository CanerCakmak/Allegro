<?php 
$conn = new mysqli("localhost","root","","allegro");

function get_user_by_username($conn,$username){
	$sql = "SELECT * FROM users WHERE username = '{$username}'";
 	$res = $conn->query($sql);
 	$data = $res->fetch_assoc();
 	if($data==null){
 		return array(); 
 	}else{
 		return $data;
 	}
}



// son şarkıları getirme
function get_latest_songs($conn){
	$songs = get_all_songs($conn);
	$_songs = array( );
 
	foreach ($songs as $key => $song) {
		$song['view_count'] = get_song_views($conn,$song['song_id']);
		$song['download_count'] = get_song_downloads($conn,$song['song_id']);
		array_push($_songs, $song);
	}

	$i  = 0;
	$j  = 0;

	for($j = 0; $j < (count($_songs) - 1);$j++) {
		for($i = 0; $i < (count($_songs) - 1);$i++) {
			if($_songs[$i]['song_id'] < $_songs[$i+1]['song_id'] ){
				$temp = $_songs[$i];
				$_songs[$i] = $_songs[$i+1];
				$_songs[$i+1] = $temp;
			}
		}
	}

 
 
  
 	return $_songs;
}




// top 10 şarkıyı id ile çağırma
function get_top_song_by_song_id($conn,$song_id){

	$sql = "SELECT * FROM artist,songs
			WHERE
				songs.aritst_id = artist.artist_id AND
				song_id = {$song_id}				
			ORDER BY artist_name ASC";
 	$res = $conn->query($sql);
 	$song = $res->fetch_assoc();
	$song['view_count'] = get_song_views($conn,$song_id);
	$song['download_count'] = get_song_downloads($conn,$song_id);

 	return $song;
}



// top 10 şarkı çağırma
function get_by_artist_id($conn,$artist_id){
	$songs = get_all_songs($conn);
	$_songs = array( );
 
	foreach ($songs as $key => $song) {
		$song['view_count'] = get_song_views($conn,$song['song_id']);
		$song['download_count'] = get_song_downloads($conn,$song['song_id']);
		if($artist_id == $song['artist_id']){
			array_push($_songs, $song);
		}
	}

	$i  = 0;
	$j  = 0;

	for($j = 0; $j < (count($_songs) - 1);$j++) {
		for($i = 0; $i < (count($_songs) - 1);$i++) {
			if($_songs[$i]['view_count'] < $_songs[$i+1]['view_count']){
				$temp = $_songs[$i];
				$_songs[$i] = $_songs[$i+1];
				$_songs[$i+1] = $temp;
			}
		}
	} 
 	return $_songs;
}




// top 10 şarkı çağırma
function get_top_songs($conn){
	$songs = get_all_songs($conn);
	$_songs = array( );
 
	foreach ($songs as $key => $song) {
		$song['view_count'] = get_song_views($conn,$song['song_id']);
		$song['download_count'] = get_song_downloads($conn,$song['song_id']);
		array_push($_songs, $song);
	}

	$i  = 0;
	$j  = 0;

	for($j = 0; $j < (count($_songs) - 1);$j++) {
		for($i = 0; $i < (count($_songs) - 1);$i++) {
			if($_songs[$i]['view_count'] < $_songs[$i+1]['view_count']){
				$temp = $_songs[$i];
				$_songs[$i] = $_songs[$i+1];
				$_songs[$i+1] = $temp;
			}
		}
	} 
 	return $_songs;
}


//şarkı indirilme sayısı
function get_song_downloads($conn,$song_id){
	$sql = "SELECT count(download_id) AS download  FROM downloads WHERE song_id = {$song_id}";
 	$res = $conn->query($sql);
 	$views = array();  
  	$data = $res->fetch_assoc(); 
  	return $data['download'];
}



//şarkı görüntülenme sayısı
function get_song_views($conn,$song_id){
	$sql = "SELECT count(view_id) AS view_count  FROM views WHERE song_id = {$song_id}";
 	$res = $conn->query($sql);
 	$views = array();  
  	$data = $res->fetch_assoc(); 
  	return $data['view_count'];
}


// Tüm şarkıları çağırma
function get_all_songs($conn){
	$sql = "SELECT * FROM artist,songs
			WHERE
				songs.aritst_id = artist.artist_id
			ORDER BY artist_name ASC";
 	$res = $conn->query($sql);
 	$songs = array();  
  	while ($data = $res->fetch_assoc()) {
  		array_push($songs, $data);
 	}
 	return $songs;
}



//trigger: görüntülenme sayısı arttırma
function record_view($conn,$song_id,$user_id){
	$view_time = time();
	$sql = "INSERT INTO `views` 
			(song_id,user_id,view_time)
			VALUES 
			(
				{$song_id},{$user_id},'{$view_time}'
			)
	";

 	if($conn->query($sql)){

 	}else{

 	}
 	
}



//trgger: indirme sayısı arttırma
function record_dowload($conn,$song_id,$user_id){
	$download_time = time();
	$sql = "INSERT INTO `downloads` 
			(song_id,user_id,download_time)
			VALUES 
			(
				{$song_id},{$user_id},'{$download_time}'
			)
	";

 	if($conn->query($sql)){

 	}else{

 	}
 	
}




function get_artist_by_artist_id($conn,$artist_id){
	$sql = "SELECT * FROM artist WHERE artist_id = {$artist_id};";
 	$res = $conn->query($sql);
 	$data = $res->fetch_assoc(); 
 	return $data;
}





function get_all_artists($conn){
	$sql = "SELECT * FROM artist ORDER BY artist_name ASC";
 	$res = $conn->query($sql);
 	$artists = array();  
  	while ($data = $res->fetch_assoc()) {
  		array_push($artists, $data);
 	}
 	return $artists;
}


function message($body,$type){
	$_SESSION['message']['body'] = $body;
	$_SESSION['message']['type'] = $type;
}