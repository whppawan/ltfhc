<?php
	$text = 'This is a value';
	$from ='en';
	$to =$_GET['language'];
	$gt = file_get_contents('http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=' . urlencode($text) . '&langpair=' . $from . '|' . $to);
	
	$json = json_decode($gt,true);
	echo"<pre>";print_r($json);die;
	echo json_encode($json);
	?>