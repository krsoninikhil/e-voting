<?php
	 
	if(mysql_connect('localhost','nikhil102','Veera102')){
		if(!mysql_select_db('evoting')){
		  echo 'Cannot connect to the database';
		}
	  }else{
		  echo 'Cannot connect to the server, please try later';
	  }
?>