<?php
$name=$_POST['name'];
$phone=$_POST['phone'];
$type=$_POST['type'];
$descr=$_POST['descr'];

if(!empty($name) && !empty($phone) && !empty($type) && !empty($descr)){
	$to      = 'artuurslv@gmail.com';
	$subject = $type;
	$message = " Person name: $name \n Contact number: ".$phone."\n Asking about: ".$type."\n\n Message:\n ".$descr;
	$headers = 'From: WebsiteForm';
	// @ noņem kļūdas paziņojumu!
	@mail($to, $subject, $message, $headers);
	
	echo "Successfuly sent!";
}else{
	echo "ERROR: code 702.";
}
?>