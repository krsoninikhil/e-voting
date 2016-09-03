<?php  
//require 'facebook.php';
require 'fb_id.php';
//session_start();
require 'connect.php';
ob_start();
	if(isset($_POST['logout'])){
		$user= 0;
		if(isset($_SESSION['candi'])) session_destroy(); 
		header('Location:'.$logoutUrl);
		//echo 'logout'.$logoutUrl;
	}

	
  
   if(isset($_SESSION['elect'])){ 
   	$election= $_SESSION['elect'];
	$voters= $election.'_voters';

	$q2= "SELECT `open_till`, `group_id` FROM `elections` WHERE `election`='$election' ";            // fetching the dead line.
	if($q2_run= mysql_query( $q2 )) {  //echo 'info fetched';
	} else echo mysql_error();
	$time= mysql_result( $q2_run, 0, 'open_till' );
	$group_id= mysql_result( $q2_run, 0, 'group_id' );
	date_default_timezone_set('Asia/Kolkata');
	$open_till= strtotime($time);
	//echo 'opentill'.$open_till.'current'.time();


	if($open_till <= time()){             //check for the deadline.
		header('Location: result.php');
	}
	
	$q1= "SELECT * FROM `$election`";
	if($q1_run= mysql_query( $q1 )) {  //echo 'info fetched';
	} else echo mysql_error();
	$number= -1;
	while ( $info = mysql_fetch_assoc($q1_run) ){
		$number++;
		$name[$number]= $info['name'];
		$image[$number]= $info['image'];
	}
	
	

 /* function present_votes(){
	 $query_present_no_of_votes="SELECT `votes` FROM `voting` WHERE `id`='$candi_id' ";
	 $q_run= mysql_query($query_present_no_of_votes);
	 $present_no_of_votes= mysql_result($q_run, '0', 'votes');
	 return $present_no_of_votes;
	 } */
//verifying the voter
 function voted(){
    if($_SESSION['candi']){
	     ?> <script src="jquery.js"></script>
		 <script>$(document).ready( function(){
		                       $("#change_vote").show();
							   $("#save_vote").css("display","none");
							   });</script>
		 <?php
		 
	}
 }
   // $user=1;
    if($user){    //echo $user;
	    $query_checking_voted= "SELECT `candi` FROM `$voters` WHERE `fb_id`= '$user' ";  
        $q_checking_voted_running= mysql_query($query_checking_voted);		
        if(mysql_num_rows($q_checking_voted_running) == 1) {                                                                     // checking if user is already voted to change the button value to "change vote"
							    //echo 'already voted';
							    $previous_candi_id= mysql_result($q_checking_voted_running, 0,'candi');                     //if voted then getting the id to whom he voted
								$previous_candi_id= chr($previous_candi_id/19);
								$_SESSION['candi']= $previous_candi_id;
		                        voted();
		}
	}
		if (isset($_POST['vote']) || isset($_POST['change_vote'])){ 
			$candi_id= htmlspecialchars(@$_POST['candidate']);

			if($user){
			    //echo 'user id in index.php'.$user;
				//if(1){
				$test= verify_voter($user, $group_id);
				print_r($test);
			   if (verify_voter($user, $group_id)){                                           // verifying the user
			  	    if(!empty($candi_id)){ 
			  	    	$candi_id_code= ord($candi_id)*19;
			
						if(!isset($_SESSION['candi'])) {
							//$query_storing_candi= "INSERT INTO `voters` (`id`,`fb_id`,`candi`) VALUES ('','$user','$candi_id') ";      // queries
							//mysql_query($query_storing_candi);
							//$_SESSION['candi']= $candi_id;
							//$query_checking_voted= "SELECT `candi` FROM `voters` WHERE `fb_id`= '$user' ";           
							/* $q_checking_voted_running= mysql_query($query_checking_voted);
							if(mysql_num_rows($q_checking_voted_running) == 1) {                                                                     // checking if user is already voted
							   echo 'already voted';
								 $previous_candi_id= mysql_result($q_checking_voted_running, 0,'candi');                     //if voted then getting the id to whom he voted
								 $_SESSION['candi']= $previous_candi_id;
							}else{ */
								$_SESSION['candi']= $candi_id; 

								$query_storing_candi= "INSERT INTO `$voters` (`id`,`name`,`fb_id`,`candi`) VALUES ('','$user_name','$user','".mysql_real_escape_string($candi_id_code)."') ";           //if not then get him in database with his candidate id
								mysql_query($query_storing_candi);
							//}
						}
						 //$_SESSION['candi']= 0;
						// if(!isset($_SESSION['candi'])) 
						 if(isset($_POST['change_vote'])){
							 $previous_id= $_SESSION['candi'];
							 $query_no_of_votes="SELECT `votes` FROM `$election` WHERE `id`='$previous_id' ";
							 $query_run= mysql_query($query_no_of_votes);
							 $no_of_votes= mysql_result($query_run, '0', 'votes');
							 //echo 'current no of votes of previously voted candidates'.$no_of_votes.'at present';
							 //echo 'current no of votes of previously voted candidates'.$no_of_votes.'at present';
							 $new_votes= $no_of_votes-1;
							 $query_change="UPDATE `$election` SET `votes`='$new_votes'  WHERE `id`= '$previous_id' "; 
							 mysql_query($query_change);
							 //echo 'vote of'.$previous_id.'changed to'.$new_votes.'previous votes updated';
							 $_SESSION['candi']= $candi_id;

							 $query_changing_candidate= "UPDATE `$voters` SET `candi`='$candi_id_code' WHERE `fb_id`= '$user' ";
							 mysql_query($query_changing_candidate);
							
						 } 
						 
						 //echo $candi_id_array= $candi_id - 1;
						 //++$vote[$candi_id_array];
						 $query_present_no_of_votes="SELECT `votes` FROM `$election` WHERE `id`='$candi_id' ";
						 $q_run= mysql_query($query_present_no_of_votes);
						 $present_no_of_votes= mysql_result($q_run, 0, 'votes');
						 $votes_of_voted_candidate= $present_no_of_votes+1;
						
						 //echo $present_no_of_votes.'votes present ';
						// echo 'votes of your present candidate are changed from'.$present_no_of_votes.' to '.$votes_of_voted_candidate;
						 $query= "UPDATE  `$election` SET `votes`= '$votes_of_voted_candidate' WHERE `id`='$candi_id' ";
							 mysql_query($query);
					   
						 //voted();  
						header('Location:confirm.html');
					} else{ echo  '<script>alert("First select your candidate");</script>';
					}
				} else { header('Location: unauthrised.php');  
				}
			}else echo '<script> alert("You must login to continue.");</script>';
			
		}
		if(@isset($_SESSION['candi'])) {voted(); } 
		
       // if(isset($_SESSION['candi'])){ echo 'session'.$_SESSION['candi'].'exist'; }
    //echo $election;

  } else header('location: index.php');


?>
<html>
<head><title>eVoting - choose the candidate</title>
<script src="jquery.js"></script>
<link rel="icon" type="image/jpg" href="images/favicon.jpg">
 <script>
	
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '461832590585508',
          status     : true,
          xfbml      : true
        });
		};
		(function(d, s, id){
         var js, fjs = d.getElementsByTagName(s)[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement(s); js.id = id;
         js.src = "//connect.facebook.net/en_US/all.js";
         fjs.parentNode.insertBefore(js, fjs);
       }(document, 'script', 'facebook-jssdk'));
	   
</script>
<script>
//$(document).ready(function(){
	
//});
function change_already_head(value){
	if(value== 1){
		$("#already_head").show();
	} else{
		$("#already_head").hide();
	}
}



</script>
     
<style> 
html, body{margin: 0; padding: 0; background-color: #dddddd;}
	

#page{width:1130px; margin-left:auto;margin-right:auto; position:relative; //margin-top:-20px;
}
#head{//background-color:red; 
	color:white;font-family:monotype corsiva; font-weight:bold; text-align:center; padding-top:1px; 
	font-size:48;}
#contestants{float:left; padding:20px; font-family:lato, arial; font-size:20; }
#updates{//background-color:blue; 
	//border:1px solid black; 
	padding:10px; font-size:20px; width:225px; float: left; 
	margin-left:50px; 
	margin-right:0; margin-top: 30px;}
#like{text-align:right;}
#change_vote{display:none;}
#note{ font-family: lato, arial; clear:both; //margin-top:300px; 
	//background-color:yellow; 
	margin: auto; padding:35px;}
#images{ width:750px; border-right:1px solid black; margin-top: 20px;  //background-color:red;
	 float:left; padding: 30px; padding-top: 0; }
#matter{ background-color: orange; width:100%; }
#matter h1{font-family: monotype corsiva;}
#header{ width: 100%; background-color:#454545; 
	text-align:center; font-size:30; font-family:ubuntu,lato, arial; 
	color: white; padding:20px 0; margin-top:-10px; //margin-bottom: 20px; 
	border-bottom: 1px solid #005555;}
h1{ padding-top:0px; padding-bottom: 0px; //margin:10;
 	font-size: 50;}
h3{margin:0; font-family: ubuntu, arial;}
#updates p{ font-family: ubuntu, sarif-sans; }
#countDown{font-size: 60; margin: 0; //background-color: red; 
		font-family: "Across the road";}
#voted_images{ width: 300px; height: 250px; overflow: auto;  background-image: url('images/vote_.jpg'); 
		background-repeat: no-repeat; background-size: 300px 200px;}
#voted_images div{ background-color: rgba(221,221,221,0.9); width: inherit; height: inherit;}
#fb_button:hover{ border: 1px solid #3b5999; }	

#group_link a{ font-size: 13px; font-family: arial; text-decoration: none; }
#group_link a:hover{ text-decoration: underline;}	
</style></head><div id="fb-root"></div>


<body>
<div id="header">
	<?php if($user) echo 'Welcome, '.$user_name.' ! select your man and click on vote button.'; 
			  else echo 'Following are the candidates for <span style="color:#CCCCFF"><i>'.$election.'</i></span>';?>
</div>

<div id="page">
   <!--<div id="head"><h1>Voting</h1></div> -->
   
   <div id="images">
     <form action="elect.php" method="post">
	<?php 
		for($i=0; $i<= $number; $i++){
			echo '<div id="contestants"><img height="200" width="200"  src="images/'.$image[$i].' " ><br /><br />
					<input type="radio" value="'.($i+1).'" name="candidate" id="candidate'.($i+1).'"> <label for="candidate'.($i+1).'">'. $name[$i].'</div>';
		}
	?>     
   </div>
   
   <div id="updates">
		<h3>Open for</h3>
		
		<iframe src="http://free.timeanddate.com/countdown/i476hoyv/n176/cf12/cm0/cu4/ct0/cs1/ca0/co0/cr0/ss0/cac333/cpc000/pcddd/tcfff/fn3/fs200/szw448/szh189/iso<?php echo $time; ?>:00/pa10" frameborder="0" width="293" height="95"></iframe>
		<br /><br />
		<input type="submit" value="Vote" name="vote" id="save_vote"><input type="submit" value="Change Vote" name="change_vote"  id="change_vote">
		</form>
	   
	   <?php if ($user){ ?>
		  <form action="elect.php" method="post"><input type="submit" value="Logout" name="logout" ></form>
		  
	   <?php } else{ ?>
	   <p>To cast your vote please</p> <a href="<?php echo $loginUrl; ?>"><img src="images/fb.png" id="fb_button"></a>
	   <?php } ?><br />
	   <span id="group_link"><a href="https://www.facebook.com/groups/<?php echo $group_id; ?>" target="_blank">visit the group of voters</a></span>
	   <p id="already_head">Already voted faces</p>
	   <div id="voted_images">
	   	<div>
		   	<?php 
		   	$q_voted_id_run= mysql_query("SELECT `fb_id`, `name` FROM `$voters`");
		   	if(mysql_num_rows($q_voted_id_run)== 0){
		   		echo '<script>change_already_head(0)</script>';
		   	}
		   	while($voted_id_array= mysql_fetch_assoc($q_voted_id_run)){
		   		$voted_id= $voted_id_array['fb_id'];
		   		$voted_name= $voted_id_array['name'];
		   		echo '<img src="https://graph.facebook.com/'.$voted_id.'/picture" title="'.$voted_name.'">';
		   	}
		   	?>
	   	</div>
	   </div>
	   	
	</div>
	
	<div style="clear:both;"></div><br /><br />
  <div id="note"><b>Note:</b><p style="font-size:16px; font-weight:700; line-height:22px;"> 1. You can change your vote as many times as you want, only last vote with in the election duration will be cosidered.<br />
                      2. Your vote is totally safe and anonymous but you have to log in to ensure that there is only one vote by each user. <br />
					  3. We will just match your group with the authorised group of voters, so click okay button when facebook ask you the permission for giving us the groups.<br /> 
					  4. Security and Privacy of your account is by 'Facebook' so you don't have to worry about your facebook account.
					</p>
   </div><div id="like"> 
     <iframe src="//www.facebook.com/plugins/like.php?href=https%3A%2F%2Fwww.facebook.com%2Fpages%2FE-Voting%2F544657225640034&amp;width=250&amp;layout=standard&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=80&amp;appId=585964214845670" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:250px; height:80px;" allowTransparency="true"></iframe>
    </div>
</div>
 
  <!--   -->
 </div>

<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-51363502-2', 'auto');
  ga('send', 'pageview');

</script>
</body></html>
</html>