<style>
	#results{ font-weight: bold; }
	#winner{ width: 300px; margin: 0 auto; text-align: center; }
	#other{ width: 200px; float: left; text-align: center;}
	body{font-family: ubuntu, arial;}
	#heading{ font-weight: 300; text-align: center; }
	#winner img, #tie img{ max-height: 230px; max-width: 230px; }
	#tie { width: 280px; margin: 0 auto; float: left; text-align: center;}
	#tie_outter, #other_outter{ margin: 0 auto; }
</style>
<link rel="icon" type="image/jpg" href="images/favicon.jpg">
<title>eVoting - result</title>
<?php 
require 'connect.php';
session_start();

if(isset($_SESSION['elect'])){ 
	$election= $_SESSION['elect'];
	$voters= $election.'_voters';

	$q2= "SELECT `name`, `votes`, `image` FROM `$election` ";            // fetching the dead line.
	if($q2_run= mysql_query( $q2 )) {  //echo 'info fetched';
		$i= -1;
		while($data= mysql_fetch_assoc($q2_run)){
			$i++;
			$name[$i]= $data['name'];
			$votes[$i]= $data['votes'];
			$image[$i]= $data['image'];
		}
		// arranging votes in descending order
		for($k=0; $k<=$i; $k++){
			for($l=$k+1; $l<=$i; $l++){
				if($votes[$k] < $votes[$l]){
					$temp= $votes[$k];
					$votes[$k]= $votes[$l];
					$votes[$l]= $temp; 

					$temp_name= $name[$k];
					$name[$k]= $name[$l];
					$name[$l]= $temp_name;

					$temp_image= $image[$k];
					$image[$k]= $image[$l];
					$image[$l]= $temp_image; 
				}
			}
		}
		// checking for tie
		$tie= 0;
		for($c=0; $c <= $i-1; $c++){ //echo $votes[0].' '.$votes[1];
			if($votes[$c] == $votes[$c+1]){
			  	$tie= 1;
			  	//echo 'if';
			} else {  //echo 'else';
				break;
			}
		}
		//var_dump($votes);
		//echo $tie;
		if($tie== 1){ 
			echo '<h1 id="heading">Election for '.$_SESSION['elect'].' is tie ';
			if(($c+1)== 2) echo 'between'; 
			else echo 'among';
			echo '</h1>';
			echo '<div id="tie_outter" style="width:'.(($c+1)*280).'px;">';

			for($k=0; $k <= $c; $k++){
				echo '<div id="tie">';
				echo '<img src="images/'.$image[$k].'"><br />'.$name[$k].'<br /><span id="results">Total votes </span>'. $votes[$k];
				echo '</div>';		
			}

			echo '<div style="clear:both;"></div></div>';

		} else{ 
			echo '<h1 id="heading">Congratulation! Winner of <i>'.$election.'</i> is '.$name[0].'</h1>';
			echo '<div id="winner">
					<img src="images/'.$image[0].'"><br />'.$name[0].'<br /><span id="results">Total votes </span>'. $votes[0].'
				  </div>';
		}
		
		echo '<br /><hr><br /><br />';
		echo '<div id="other_outter" style="width:'.(200*($i-$c)).'px;">';
		for($k= $c+1; $k <= $i; $k++){
			echo '<div id="other">
					<img src="images/'.$image[$k].'"  height="150" width="150"><br />'.$name[$k].'<br /><span id="results">Total votes </span>'. $votes[$k].'
			      </div>';
		}
		echo '<div style="clear:both;"></div></div>';
	} else echo mysql_error();

} else header('location: index.php');

?>
<html>
<head></head>
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