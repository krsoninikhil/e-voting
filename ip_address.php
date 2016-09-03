<?php
    if(isset($_SERVER['HTTP_CLIENT_IP'])){
        $ip_client= $_SERVER['HTTP_CLIENT_IP'];
		if( !empty( $ip_client )) {
	    $ip= $ip_client;
		}
   }
   else if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		$ip_forwarded_for= $_SERVER['HTTP_X_FORWARDED_FOR']; 
	    if( !empty($ip_forwarded_for) ) {
	    $ip= $ip_forwarded_for;
		}
	}
	else if (isset($_SERVER['REMOTE_ADDR'])){
		$ip_remote= $_SERVER['REMOTE_ADDR'];
		if(!empty($ip_remote) ){
			$ip= $ip_remote;
		}
	}
	 
	// echo $ip;
?>