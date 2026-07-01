<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}

include "../config.php";


// Add Skill

if(isset($_POST['add'])){

    $skill_name = $_POST['skill_name'];
    $skill_level = $_POST['skill_level'];


    mysqli_query($conn,
    "INSERT INTO skills(skill_name,skill_level)
    VALUES('$skill_name','$skill_level')");


    $success = "Skill added successfully";

}



// Delete Skill

if(isset($_GET['delete'])){

    $id = $_GET['delete'];


    mysqli_query($conn,
    "DELETE FROM skills WHERE id=$id");


    header("Location: skills.php");

    exit();

}



// Get Skills

$result = mysqli_query($conn,
"SELECT * FROM skills");


?>


<!DOCTYPE html>
<html>

<head>

<title>Skills Management</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body class="bg-light">


<div class="container mt-5">


<div class="card shadow">


<div class="card-header bg-primary text-white">


<h3>

Manage Skills

</h3>


</div>


<div class="card-body">


<a href="dashboard.php" class="btn btn-secondary mb-3">

← Dashboard

</a>



<?php

if(isset($success)){

echo "

<div class='alert alert-success'>

$success

</div>

";

}

?>



<form method="POST" class="row g-3 mb-4">


<div class="col-md-6">

<input 
type="text"
name="skill_name"
class="form-control"
placeholder="Skill Name"
required>

</div>



<div class="col-md-4">


<input 
type="number"
name="skill_level"
class="form-control"
placeholder="Percentage"
min="1"
max="100"
required>


</div>



<div class="col-md-2">


<button 
class="btn btn-primary w-100"
name="add">

Add

</button>


</div>


</form>





<table class="table table-bordered">


<tr>

<th>Skill</th>

<th>Level</th>

<th>Progress</th>

<th>Action</th>

</tr>



<?php while($row=mysqli_fetch_assoc($result)){ ?>


<tr>


<td>

<?php echo $row['skill_name']; ?>

</td>



<td>

<?php echo $row['skill_level']; ?>%

</td>



<td>


<div class="progress">


<div class="progress-bar"
style="width:<?php echo $row['skill_level']; ?>%">


<?php echo $row['skill_level']; ?>%


</div>


</div>


</td>



<td>


<a 
href="skills.php?delete=<?php echo $row['id']; ?>"
class="btn btn-danger btn-sm"
onclick="return confirm('Delete this skill?')">

Delete

</a>


</td>


</tr>


<?php } ?>


</table>



</div>


</div>


</div>



</body>

</html>