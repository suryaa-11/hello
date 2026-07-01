<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}

include "../config.php";


// Add Certificate

if(isset($_POST['add'])){


    $title = $_POST['title'];
    $organization = $_POST['organization'];
    $certificate_date = $_POST['certificate_date'];


    $image = "";


    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){


        $image = time() . "_" . $_FILES['image']['name'];


        move_uploaded_file(

            $_FILES['image']['tmp_name'],

            "../assets/images/".$image

        );


    }



    mysqli_query($conn,

    "INSERT INTO certifications

    (title,organization,certificate_date,image)

    VALUES

    ('$title',
    '$organization',
    '$certificate_date',
    '$image')"

    );


    $success = "Certificate added successfully";


}



// Delete Certificate

if(isset($_GET['delete'])){


    $id = $_GET['delete'];


    mysqli_query($conn,

    "DELETE FROM certifications WHERE id=$id"

    );


    header("Location: certificates.php");

    exit();


}



// Fetch Certificates

$result = mysqli_query($conn,

"SELECT * FROM certifications"

);


?>


<!DOCTYPE html>
<html>

<head>

<title>Certificates Management</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body class="bg-light">



<div class="container mt-5">



<div class="card shadow">


<div class="card-header bg-primary text-white">


<h3>

Manage Certificates

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

Certificate Title

</label>


<input

type="text"

name="title"

class="form-control"

required>


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Organization

</label>


<input

type="text"

name="organization"

class="form-control"

required>


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Certificate Date

</label>


<input

type="date"

name="certificate_date"

class="form-control">


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Certificate Image

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

Add Certificate

</button>




</form>



<hr>



<h4>

Existing Certificates

</h4>




<div class="row mt-3">



<?php while($row=mysqli_fetch_assoc($result)){ ?>



<div class="col-md-4 mb-4">



<div class="card shadow-sm h-100">



<?php if($row['image']!=""){ ?>


<img

src="../assets/images/<?php echo $row['image']; ?>"

class="card-img-top"

height="180"

style="object-fit:cover;">


<?php } ?>




<div class="card-body">



<h5>

<?php echo $row['title']; ?>

</h5>



<p>

<b>Organization:</b>

<?php echo $row['organization']; ?>

</p>



<p>

<b>Date:</b>

<?php echo $row['certificate_date']; ?>

</p>




<a

href="certificates.php?delete=<?php echo $row['id']; ?>"

onclick="return confirm('Delete this certificate?')"

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