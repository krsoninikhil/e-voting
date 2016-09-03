<?php  
 require 'connect.php';
 require 'hits_counter.php';
    if(isset($_POST['voter'])){       
      $election= $_POST['election'];
	  session_start();                            //for getting the voter onto elction candidate page.
	  session_destroy();
	  session_start();
	  $_SESSION['elect']= $election;
	  //$location= $election.".php";
	  header("location:elect.php");
	}
			
		
?>

<html>
    <head> 
	    <title>eVoting - vote simply</title>
		<script src="jquery.js"></script>
	    <script>
		
		</script>
		<link rel="stylesheet" type="text/css" href="style_main.css" />
		<link rel="icon" type="image/jpg" href="images/favicon.jpg">
	</head>
 <body ><div id="parent">
    
	<div id="info">
		<div id="info_content">
			<h1>Let&#8217;s vote,</h1>
			<span id="tag">no more <strong>PARCHI</strong> voting, Use your facebook account and simply vote.</span>
			<hr>
			Want to choose your CR, use facebook.<br /><br />
			Have an unending arguments, let them voted.<br /><br />
			want to eliminate some one from getting into trip with your group, but cant say "no" directly, voteout him.
			<p>To organise a election simply create a open facebook group and add all them, who you think can vote.</p>
		</div>
	</div>
	<div  id="page" align="center">
		    <div id="voter">
			    <span class="vote"> want to vote, select your election</span> 
					<form action="index.php" method="post" >
						<select name="election" ><?php 
							$show_elections= mysql_query("SELECT `election` FROM `elections` ORDER BY `id` DESC ");
							while( $e_name= mysql_fetch_assoc($show_elections)){
								echo "<option>".$e_name['election']."</option>";
							}
							?>
						</select>
						<input type="submit" name="voter" value="Continue..." />
					</form><br />
			</div>
			<div id="form"><div style="background-color: gba(0,0,0,0.8); margin:0; padding:0;">
			    <h1>Organise...</h1><hr><br />
				<form action="step2.php" method="post" >
			 		<input name="name" type="text" placeholder="Name your election"  size="35" value="<?php if(isset($name)) echo $name;?>" maxlength="50" required/><img src="images/q.png" title="Give a unique name, which is not in the above list"><br /><br />
					<input name="group_id" type="text" placeholder="Id of facebook group of authrised voters" size="35" value="<?php if(isset($group_id)) echo $group_id;?>" maxlength="25" required/><img src="images/q.png" title="make sure the group is open group"><br />
					<span id="lookupid">you can find the id of your group at <a href="http://lookup-id.com/" target="_blank">lookup-id.com</a></span><br /><br />
					<input name="organiser" type="text" placeholder="your name" size="35" value="<?php if(isset($organiser)) echo $organiser;?>" maxlength="25" required/><img src="images/q.png" title="So that voters can know"><br /><br />
					<input name="number" type="number" placeholder="no of candidates" id="number" min="2" required><br /><br />
					<input type="submit" value="NEXT > " name="next" align="right" ><br /><br />
				   
				</form> </div>
			 </div>
				
			    <div class="footer"><a href="contact.php">Feedback - Contact </a>| All Rights Reserved.
						<!-- |  <a href="https:\\www.facebook.com/nikhil.krsoni"> krsoni</a> -->
	            </div>
		    
	</div>
</div>
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