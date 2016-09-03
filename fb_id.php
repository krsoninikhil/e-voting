<?php 
require 'facebook.php';
ini_set('max_execution_time', 300);
$facebook = new Facebook(array(
  'appId'  => '461832590585508',
  'secret' => 'b9f37dbe3cdb5304921376d0ae7f644b',
  'allowSignedRequest' => false
));
$accessToken = $facebook->getAccessToken();
$facebook->setAccessToken($accessToken);
$user = $facebook->getUser();
//echo $user.'fb_id';
//$group_id= "165724543493694";
// $myvar = sprintf('%.0f', $group_id);    //to store the large integer.
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl();
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
	$user_name= $user_profile['name'];
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }

} else {
 $loginUrl = $facebook->getLoginUrl(array('scope' => 'user_groups'));
} /*echo '<a href="<?php echo $loginUrl; ?>">login</a>';  */

/*function verify_voter($user, $group_id){
    $status= 0;
    $url = "https://graph.facebook.com/".$group_id."/members?access_token=461832590585508|b9f37dbe3cdb5304921376d0ae7f644b";
    $response = file_get_contents($url);
    $obj = json_decode($response);   //print_r($obj);
    
	$i=0;
    foreach($obj->data as $value) {
        if ($value->id == $user)  $status= 1;  //found
		$i++;
    }  
	
    return $status; 
} */ 

  /*if(!$user){ ?><a href="<?php echo $loginUrl; ?>">login</a> <?php } else echo  '<a href="'.$logoutUrl.'">logout</a>';  */
 
  function verify_voter($user, $group_id){
    $status= 0;
    global $facebook;
   // echo $user;
    try {
      // Proceed knowing you have a logged in user who's authenticated.
      $info = $facebook->api("/".$user."/groups?access_token=461832590585508|b9f37dbe3cdb5304921376d0ae7f644b");
      foreach($info['data'] as $group){
       //print_r("id".$group['id']);
      // $group['id'].'<br>';
      if($group['id']== $group_id){
        //echo $group['name'];
        $status= 1;
        break;
      }
    }
    
    } catch (FacebookApiException $e) {
      error_log($e);
      $user = null;
    }
    
    return $status;
  }
  //$id= 100002072353174;
// echo verify_voter( $user, '312360685582662');

 ?>