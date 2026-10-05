<?php 
$email = $_POST['email'];
$password = $_POST['password'];
if(!empty($email)||!empty($password){
$host="localhost";
$dbusername=
$dbpassword="";
$dbname="login";

$conn=new mysqli($host,$dbusername,$dbpassword,$dbname);

if(mysqli_connect_error()){
die('connect error (' .mysqli_connect_errno().')' . mysqli_connect())
}
else{
$select="select email from LOGIN where email=? limit 1";
$insert="insert into LOGIN (email,password) values(?,?)";

$stmt=$conn->prepare($select);
$stmt->bind_param("s",$email);
$stmt->execute();
$stmt->bind_result($email);
$stmt->store_result();
$rnum=$stmt->num_rows;

if($rnum==0){
$stmt->close();
$stmt=$conn->prepare($insert);
$stmt->bind_param("ssssii",$email,$password);
$stmt->execute();
echo"new record inserted successfully";
}else{
echo"someone already registered using this email";
}
$stmt->close();
$conn->close();

}else{
echo"all fields are required";
die();
}