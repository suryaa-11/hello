<?php

session_start();

include "../config.php";


$error = "";


if(isset($_POST['login'])){


    $username = $_POST['username'];
    $password = $_POST['password'];



    $query = mysqli_query($conn,
    "SELECT * FROM admin WHERE username='$username' AND password='$password'");


    if(mysqli_num_rows($query) > 0){


        $_SESSION['admin'] = $username;


        header("Location: dashboard.php");

        exit();


    }
    else{


        $error = "Invalid username or password";


    }


}


?>


<!DOCTYPE html>
<html>


<head>

<title>Admin Login</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<style>


body{

    height:100vh;
    background:linear-gradient(135deg,#2563eb,#111827);
    display:flex;
    justify-content:center;
    align-items:center;

}


.login-box{

    width:400px;
    background:white;
    padding:35px;
    border-radius:15px;
    box-shadow:0 10px 30px rgba(0,0,0,.3);

}


</style>


</head>


<body>



<div class="login-box">


<h2 class="text-center mb-4">

Admin Login

</h2>



<?php

if($error!=""){

echo "

<div class='alert alert-danger'>

$error

</div>

";

}

?>



<form method="POST">


<div class="mb-3">

<label class="form-label">

Username

</label>


<input 
type="text"
name="username"
class="form-control"
required>

</div>




<div class="mb-3">

<label class="form-label">

Password

</label>


<input 
type="password"
name="password"
class="form-control"
required>


</div>




<button 
name="login"
class="btn btn-primary w-100">


Login


</button>


</form>


</div>



</body>


</html>