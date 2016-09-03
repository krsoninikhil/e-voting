<?php 
require_once 'connect.php';
session_start();
if(isset($_SESSION['elect'])){
  $election= $_SESSION['elect'];
} else header("Location:index.php");
$q_run= mysql_query("SELECT `organiser` FROM `elections` WHERE `election`= '$election'");
$organiser= mysql_result($q_run, 0, 'organiser');

?>
<html>
   <head><title>Unauthrised Voter</title>
    <link rel="icon" type="image/jpg" href="images/favicon.jpg">
     <style>
	    #content{border: 2px solid #343434;text-align:center;position:relative;width:700px; background-color:#eeeeee; font-family:arial; color:#343434;padding:40px; margin: 100px auto;}
    h1{font-size:40;} hr{width:90%;}
    h4{margin-top:0;padding-top:0;}
    body{background-color:#dddddd;}
	 </style>
   </head>
   <body>
     <div id="content" align="center">
       <h1>You can not vote in this election.</h1><hr>
       <h4>You may not be in the facebook group of the voters created by the organiser of this election.<br>
	   Contact <?php echo $organiser; ?>, your organiser for the same. <a href="elect.php">go back</a><br />
      <a href="index.php">home</a></h4>
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