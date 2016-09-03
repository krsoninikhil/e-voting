<?php ob_start(); ?>
<link rel="stylesheet" type="text/css" href="style_main.css" />
<link rel="icon" type="image/jpg" href="images/favicon.jpg">
<style>
	input[type="file"]{ border:0; width: 180px;}
	html{background-image: none; }
	#page{ width:600px; }
	#form h1{ margin-bottom: 0; padding-bottom: 0; }
	#form span{ font-size: 17; }
	#deadline{ font-size: 5; }
	#page{ background-image: url('images/details.png'); background-repeat: no-repeat; background-position: center; }
	#form{ background-color: rgba(255,255,255,0.8); }

</style>
<?php require 'connect.php'; 
	session_start(); 
	//if(isset($_SESSION['empty'])) echo 'set'; else echo 'not set';
	if(isset($_POST['next']) || isset($_SESSION['empty'])){   //echo 'first';  	// this data will come from index.php  ( processing data of index.php )
		if(isset($_POST['next'])){ //echo 'submit';
	     	$name= $_POST['name'];
			$group_id= $_POST['group_id'];
			$organiser= $_POST['organiser'];
			$number= $_POST['number'];
		} else{   //echo 'empty';
			$name= $_SESSION['name'];
			$group_id= $_SESSION['group_id'];
			$organiser= $_SESSION['organiser'];
			$number= $_SESSION['number'];
			//unset($_SESSION['empty']);
		}
		if(!empty($name) && !empty($group_id) && !empty($organiser) &&  !empty($number)){
		   // mysql_query("INSERT INTO elections VALUES ('', '$name', '$organiser', '$group_id' , '$number')" );        // for inserting the election name and the organiser into the database;
			if(isset($_POST['next'])){ //echo 'session set';
				$_SESSION['name']= $name;
				$_SESSION['group_id']= $group_id;
				$_SESSION['organiser']= $organiser;
				$_SESSION['number']= $number;
			} //else echo 'already set';
			echo ' <div  id="page" align="center">
					  <div id="form">
					  <h1>Give your candidates detail</h1><span>just name and a image for him may be his sign</span><hr><br />
				      <form action="step2.php" method="post" enctype="multipart/form-data">';
			for( $i= 1; $i<=$number; $i++) {
				echo '<input name="candidate'.$i.'" type="text"  size="30" maxlength="20" value="';
					if(isset($_SESSION['candi_name'.$i])) {echo $_SESSION['candi_name'.$i]; unset($_SESSION['candi_name'.$i]);}
				echo '"  placeholder="Name of candidate '.$i.'" required/> 
						<input name="image'.$i.'" type="file"><br /><br />';
			}
			echo   	  '<span id="deadline">deadline for your voters<span><br /><br /><input type="datetime-local" name="time" id="time" title="DD-MM-YYYY  PM  10:10" required/><br /><br />
					  <input type="submit" value="Done" name="done" align="right" ><br /><br />
				      </form>
			          </div> 
					  <div class="footer"><a href="contact.php">Feedback - Contact </a>| All Rights Reserved.
						<!--| <a href="https://www.facebook.com/nikhil.krsoni" target="_blank"> krsoni</a>-->
	                  </div>
	                </div>';
		} else  {
			header('location: index.php');
			//echo "* All fields are required.<br /><br />";                                                                             
		}
	}
	//echo $name;
	// now processing the own data
	
if(isset($_POST['done'])){     //echo 'done'; 
		$number= $_SESSION['number'];
		for ($j = 1; $j <= $number; $j++){
				$candi_name[$j]= $_POST['candidate'.$j];
				$_SESSION['candi_name'.$j]= $candi_name[$j];
				//$image[$j]= $_FILES['image'.$j]['name'];

				if(!empty($image[$j])){
					$image[$j]= $_FILES['image'.$j]['name'].'-'.$candi_name[$j].'-'.$j.'-'.$number.'.jpg';
					$tmp= $_FILES['image'.$j]['tmp_name'];
					$location= 'images/'.$image[$j];
					if(move_uploaded_file($tmp, $location)){
					  // echo "uploaded";
					}else{
					   echo "image uploading failed";  //.mysql_error();
					}
				} else{
					$image[$j]= 'default.jpg';
				}
		}

		$time= $_POST['time'];

		for ($j = 1; $j <= $number; $j++){
				if(empty($candi_name[$j]) || empty($time)){ 
					echo '<script>alert("Atleast give there name, it will help the voters");</script>';
					$_SESSION['empty']= 1;
					header('location:step2.php'); 
					die();
				}

		}
		
		$name= $_SESSION['name'] ;
		$group_id= $_SESSION['group_id'] ;
		$organiser= $_SESSION['organiser'] ;   // echo 'organiser'.$organiser;
		
		$p= "CREATE TABLE ".mysql_real_escape_string($name)." (id int NOT NULL AUTO_INCREMENT,PRIMARY KEY(id), name varchar(20), votes int, image text)";
		if(mysql_query($p)) { //echo "table created";			//creating table for each electione
			$voters_table= $name.'_voters';                   // creating tabel for storing the voters info for each election 
			if(mysql_query("CREATE TABLE ".$voters_table." (id int NOT NULL AUTO_INCREMENT,PRIMARY KEY(id), name varchar(20), fb_id bigint, candi int )")){
				for ($j = 1; $j <= $number; $j++){
					mysql_query("INSERT INTO `$name` VALUES ('', '".mysql_real_escape_string($candi_name[$j])."', '0', '".mysql_real_escape_string($image[$j])."' )" );        //for inserting the election name and the organiser into the database;
					//echo 'all table created';
					$_SESSION['elect']= $name; 
					header('location: elect.php');
				}
			}
			if(mysql_query("INSERT INTO elections VALUES ('', '".mysql_real_escape_string($name)."', '".mysql_real_escape_string($organiser)."', '".mysql_real_escape_string($group_id)."', '".mysql_real_escape_string($time)."','' )" )) { //echo 'election name inserted';        //for inserting the election name and the organiser into the database;
			} else echo mysql_error();
		} else echo '<br />This election name is already been taken or is invalid. <a href="index.php">change name</a>';//.mysql_error();
}
?>

<html>
    <head> 
	    <title>Organise step2</title>
		<script src="jquery.js"></script>
	    <script>
		
		</script>
		
		
	</head>
 <body>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51363502-2', 'auto');
  ga('send', 'pageview');

</script>
 </body>
 </html>