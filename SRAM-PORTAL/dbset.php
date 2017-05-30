<?php

$prn=$_GET['prn'];
$name=$_GET['sname'];
$key=$_GET['key'];


$host="localhost";
$user="root";
$pass="";
$database="dsram";


 if(!$link=@mysqli_connect($host,$user,$pass))
{
	die('Couldnt Connect :'.mysqli_error());
}
if(mysqli_select_db($link,$database))
{
   
}
else
{
 die("Unable to select database".mysqli_error($link));
}



$sql="INSERT INTO `dsram`.`studentdatabase` (`prn`, `name`, `password`) VALUES ('$prn', '$name', '$key');";

$result=mysqli_query($link,$sql);

if (!$result) 
{ 
	echo mysqli_error($link); 
}

else
{
    echo "Record entered successfully!";    
    
}




mysqli_close($link);


?>