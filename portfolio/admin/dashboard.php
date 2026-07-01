<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}

include "../config.php";


// Dashboard Counts

$skills = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM skills")
);


$projects = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM projects")
);


$certifications = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM certifications")
);


$messages = mysqli_fetch_assoc(
    mysqli_query($conn,
    "SELECT COUNT(*) AS total FROM contact_messages")
);


?>


<!DOCTYPE html>
<html>

<head>

<title>Admin Dashboard</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">


<style>

body{

background:#f4f6f9;

}


.sidebar{

min-height:100vh;
background:#111827;

}


.sidebar h3{

color:white;

}


.sidebar a{

display:block;
padding:15px 20px;
color:white;
text-decoration:none;

}


.sidebar a:hover{

background:#2563eb;

}


.card-box{

border:none;
border-radius:15px;
transition:.3s;

}


.card-box:hover{

transform:translateY(-5px);

}

</style>


</head>


<body>


<div class="container-fluid">


<div class="row">


<!-- Sidebar -->

<div class="col-md-3 col-lg-2 sidebar">


<h3 class="text-center mt-4">

Portfolio Admin

</h3>


<hr class="text-white">


<a href="dashboard.php">

<i class="fa fa-home"></i>
Dashboard

</a>


<a href="profile.php">

<i class="fa fa-user"></i>
Profile

</a>


<a href="skills.php">

<i class="fa fa-code"></i>
Skills

</a>


<a href="projects.php">

<i class="fa fa-folder"></i>
Projects

</a>


<a href="certifications.php">

<i class="fa fa-certificate"></i>
Certificates

</a>


<a href="resume.php">

<i class="fa fa-file"></i>
Resume

</a>


<a href="messages.php">

<i class="fa fa-envelope"></i>
Messages

</a>


<a href="logout.php">

<i class="fa fa-right-from-bracket"></i>
Logout

</a>


</div>




<!-- Main Content -->


<div class="col-md-9 col-lg-10 p-4">


<h2>

Welcome,
<?php echo $_SESSION['admin']; ?>

</h2>


<p class="text-muted">

Manage your portfolio website

</p>



<div class="row mt-4">



<!-- Skills -->


<div class="col-md-6 col-lg-3 mb-4">


<div class="card card-box shadow p-3">


<h5>

<i class="fa fa-code text-primary"></i>

Skills

</h5>


<h2>

<?php echo $skills['total']; ?>

</h2>


<a href="skills.php">

Manage Skills

</a>


</div>


</div>





<!-- Projects -->


<div class="col-md-6 col-lg-3 mb-4">


<div class="card card-box shadow p-3">


<h5>

<i class="fa fa-folder text-success"></i>

Projects

</h5>


<h2>

<?php echo $projects['total']; ?>

</h2>


<a href="projects.php">

Manage Projects

</a>


</div>


</div>





<!-- Certifications -->


<div class="col-md-6 col-lg-3 mb-4">


<div class="card card-box shadow p-3">


<h5>

<i class="fa fa-certificate text-warning"></i>

Certificates

</h5>


<h2>

<?php echo $certifications['total']; ?>

</h2>


<a href="certifications.php">

Manage Certificates

</a>


</div>


</div>





<!-- Messages -->


<div class="col-md-6 col-lg-3 mb-4">


<div class="card card-box shadow p-3">


<h5>

<i class="fa fa-envelope text-danger"></i>

Messages

</h5>


<h2>

<?php echo $messages['total']; ?>

</h2>


<a href="messages.php">

View Messages

</a>


</div>


</div>



</div>


</div>


</div>


</div>


</body>

</html>