<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}

include "../config.php";


// Add Project

if(isset($_POST['add'])){


    $title = $_POST['title'];
    $description = $_POST['description'];
    $technologies = $_POST['technologies'];
    $github_link = $_POST['github_link'];
    $live_link = $_POST['live_link'];


    $image = "";


    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){


        $image = time() . "_" . $_FILES['image']['name'];


        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../assets/images/".$image
        );

    }



    mysqli_query($conn,

    "INSERT INTO projects

    (title,description,technologies,github_link,live_link,image)

    VALUES

    ('$title',
    '$description',
    '$technologies',
    '$github_link',
    '$live_link',
    '$image')"

    );


    $success = "Project added successfully";

}



// Delete Project

if(isset($_GET['delete'])){


    $id = $_GET['delete'];


    mysqli_query($conn,

    "DELETE FROM projects WHERE id=$id"

    );


    header("Location: projects.php");

    exit();


}



// Fetch Projects

$result = mysqli_query($conn,

"SELECT * FROM projects"

);


?>



<!DOCTYPE html>
<html>

<head>

<title>Projects Management</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body class="bg-light">



<div class="container mt-5">


<div class="card shadow">



<div class="card-header bg-primary text-white">

<h3>

Manage Projects

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





<form method="POST" enctype="multipart/form-data">



<div class="row">



<div class="col-md-6 mb-3">


<label class="form-label">

Project Title

</label>


<input 
type="text"
name="title"
class="form-control"
required>


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Technologies

</label>


<input 
type="text"
name="technologies"
class="form-control"
placeholder="PHP, MySQL, Bootstrap">


</div>





<div class="col-md-12 mb-3">


<label class="form-label">

Description

</label>


<textarea
name="description"
class="form-control"
rows="4"></textarea>


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

GitHub Link

</label>


<input 
type="text"
name="github_link"
class="form-control">


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Live Demo Link

</label>


<input 
type="text"
name="live_link"
class="form-control">


</div>





<div class="col-md-12 mb-3">


<label class="form-label">

Project Image

</label>


<input 
type="file"
name="image"
class="form-control">


</div>



</div>



<button 
name="add"
class="btn btn-primary">

Add Project

</button>


</form>



<hr>




<h4 class="mb-3">

Existing Projects

</h4>



<div class="row">



<?php while($row=mysqli_fetch_assoc($result)){ ?>



<div class="col-md-4 mb-4">


<div class="card h-100 shadow-sm">



<?php if($row['image']!=""){ ?>


<img 
src="../assets/images/<?php echo $row['image']; ?>"
class="card-img-top"
height="180"
style="object-fit:cover;">


<?php } ?>



<div class="card-body">


<h5 class="card-title">

<?php echo $row['title']; ?>

</h5>



<p>

<?php echo $row['description']; ?>

</p>



<p>

<b>Tech:</b>

<?php echo $row['technologies']; ?>

</p>



<a href="<?php echo $row['github_link']; ?>"
target="_blank"
class="btn btn-dark btn-sm">

GitHub

</a>



<a href="<?php echo $row['live_link']; ?>"
target="_blank"
class="btn btn-success btn-sm">

Live

</a>



<a href="projects.php?delete=<?php echo $row['id']; ?>"
onclick="return confirm('Delete this project?')"
class="btn btn-danger btn-sm">

Delete

</a>



</div>


</div>


</div>



<?php } ?>



</div>



</div>


</div>


</div>


</body>

</html>