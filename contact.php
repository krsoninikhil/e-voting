<?php
  if(isset($_POST['submit'])){
    $name= $_POST['name'];
    $email= $_POST['email'];
    $subject= 'voting';// $_POST['subject'];
    $message=$_POST['message'];
    if(!empty($name) && !empty($email) && !empty($message)){
      $to= 'krsoninikhil@gmail.com';
      $header= 'From:'.$name.' <'.$email.'>';
      if(mail($to,$subject,$message,$header)) {
        ?>
        <script> alert('Your has been message successfully sent. Soon we will get in touch.');</script>
        <?php
        //echo '<a href="home.php">back</a>';
        header("Location: index.php");
      } else{
        //echo '<b>Sorry! can\'t send your message at this time. Please try later.</b>';
        ?>
        <script> alert('Sorry! can\'t send your message at this time.\nPlease try later.');</script>
        <?php
      }
    }else{
      //echo '<b>Please, fill all the fields...</b>';
        ?>
        <script> alert('Please, fill all the fields...');</script>
        <?php
    }
  }
?>
<html>
<head><style>
  #contact{ border: 1px solid #343434; padding: 25px 75px; width: 600px; margin: 80px auto; font-family: arial; }
  input{padding: 3px; font-size: 16px; font-family: arial; }
  input[type="text"]{ width: 600px;}
  textarea{ width: 600px; resize:none;}
</style>
<title>Contact</title>
<link rel="icon" type="image/jpg" href="images/favicon.jpg"></head>
<body>
  <div id="contact">
<h2 align="center">We will be happy to say Hello! </h2>

<form action="contact.php" method="POST">

<input type="text" name="name" maxlength="40"  placeholder="Name" ><br />
<input type="text" name="email" maxlength="50" placeholder="Email"><br />
<textarea rows="5" name="message" placeholder="Your message"></textarea> <br />
<input type="submit" name="submit" value="Send"> <br><br>
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


