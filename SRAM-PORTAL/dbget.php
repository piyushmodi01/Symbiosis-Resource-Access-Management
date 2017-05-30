<?php

$prn=$_GET['prn'];
$password=$_GET['password'];


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



$sql="select name,password from studentdatabase where prn='$prn' and password = '$password'";

$result=mysqli_query($link,$sql);

if (!$result) 
{ 
	echo "Wrong Query" . mysqli_error($link); 
}

else if($result->num_rows == 0)
    {
        echo 'invalid';
    }
else
{
    
    while($row=mysqli_fetch_array($result)) 
	{ 
        
		echo $row['name'];
	} 
    
    
}




mysqli_close($link);


?>