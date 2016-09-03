<?php 
    require_once 'connect.php';
	require 'ip_address.php';
	
	$q_ip_already= "SELECT `hits` FROM `hits_counter` WHERE `ip`  = '$ip' ";
	$r_ip_already= mysql_query( $q_ip_already );
	if(mysql_num_rows( $r_ip_already ) == 1 ){
	    $hits= mysql_result( $r_ip_already, 0, 'hits');
		$ip_hits_update=  $hits + 1;
		
		$q_update = "UPDATE `hits_counter` SET `hits` = '$ip_hits_update'  WHERE `ip`= '$ip' ";
		mysql_query( $q_update );
		//echo 'ip already exist';
    } else if( mysql_num_rows( $r_ip_already ) == 0 ){
	    $hits= 1;
	    $q_ip_store= "INSERT INTO `hits_counter` (`id`,`ip`,`hits`) VALUES ('', '$ip', '$hits')";
		if(mysql_query( $q_ip_store )) {//echo 'ip inserted';
		//echo ' so ip doesn\'t exist';
		}
	} else{ echo 'something else is happening.';}
	//echo $hits;	
	
?>