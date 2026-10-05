<?php
include 'connect.php';

if(isset($_POST['signUp'])){
    $name=$_POST['name'];
    $password=$_POST['password'];
    $password=md5($password);

    $insertQuery="INSERT INTO users(name,password)
                  VALUES ('$name','$password')";
    if($conn->query($insertQuery)==TRUE){
        header("location: index.php");
    }
    else{
        echo "Error:".$conn->error;
    }
}

if(isset($_POST['signIn'])){
    $name=$_POST['name'];
    $password=$_POST['password'];
    $password=md5($password) ;
   
    $sql="SELECT * FROM users WHERE name='$name' and password='$password'";
    $result=$conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row=$result->fetch_assoc();
        $_SESSION['name']=$row['name'];
        header("Location: homepage.php");
        exit();
    }
    else{
        echo "Not Found, Incorrect Name or Password";
    }
}
?>
