<?php

session_start();

if(!isset($_SESSION['admin'])){

    header("Location: login.php");
    exit();

}

include "../config.php";


// Save Profile

if(isset($_POST['save'])){


    $name = $_POST['name'];
    $title = $_POST['title'];
    $about = $_POST['about'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $github = $_POST['github'];
    $linkedin = $_POST['linkedin'];



    // Image Upload

    $image = "";


    if(isset($_FILES['image']) && $_FILES['image']['name'] != ""){


        $image = time() . "_" . $_FILES['image']['name'];


        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../assets/images/".$image
        );


    }



    $check = mysqli_query($conn,
    "SELECT * FROM profile");


    if(mysqli_num_rows($check)>0){


        if($image != ""){


            $query = "

            UPDATE profile SET

            name='$name',
            title='$title',
            about='$about',
            email='$email',
            phone='$phone',
            address='$address',
            github='$github',
            linkedin='$linkedin',
            image='$image'

            ";


        }
        else{


            $query = "

            UPDATE profile SET

            name='$name',
            title='$title',
            about='$about',
            email='$email',
            phone='$phone',
            address='$address',
            github='$github',
            linkedin='$linkedin'

            ";


        }


    }
    else{


        $query = "

        INSERT INTO profile

        (name,title,about,email,phone,address,github,linkedin,image)

        VALUES

        ('$name',
        '$title',
        '$about',
        '$email',
        '$phone',
        '$address',
        '$github',
        '$linkedin',
        '$image')

        ";


    }


    mysqli_query($conn,$query);


    $success = "Profile updated successfully";


}



// Get Profile Data

$result = mysqli_query($conn,
"SELECT * FROM profile");


$data = mysqli_fetch_assoc($result);



?>


<!DOCTYPE html>
<html>

<head>

<title>Profile Management</title>


<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


</head>


<body class="bg-light">



<div class="container mt-5">


<div class="card shadow">


<div class="card-header bg-primary text-white">

<h3>

Manage Profile

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

Name

</label>


<input 
type="text"
name="name"
class="form-control"
value="<?php echo $data['name'] ?? ''; ?>"
required>


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Title

</label>


<input 
type="text"
name="title"
class="form-control"
value="<?php echo $data['title'] ?? ''; ?>">


</div>





<div class="col-md-12 mb-3">


<label class="form-label">

About

</label>


<textarea
name="about"
class="form-control"
rows="5"><?php echo $data['about'] ?? ''; ?></textarea>


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Email

</label>


<input 
type="email"
name="email"
class="form-control"
value="<?php echo $data['email'] ?? ''; ?>">


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

Phone

</label>


<input 
type="text"
name="phone"
class="form-control"
value="<?php echo $data['phone'] ?? ''; ?>">


</div>





<div class="col-md-12 mb-3">


<label class="form-label">

Address

</label>


<input 
type="text"
name="address"
class="form-control"
value="<?php echo $data['address'] ?? ''; ?>">


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

GitHub

</label>


<input 
type="text"
name="github"
class="form-control"
value="<?php echo $data['github'] ?? ''; ?>">


</div>





<div class="col-md-6 mb-3">


<label class="form-label">

LinkedIn

</label>


<input 
type="text"
name="linkedin"
class="form-control"
value="<?php echo $data['linkedin'] ?? ''; ?>">


</div>





<div class="col-md-12 mb-3">


<label class="form-label">

Profile Image

</label>


<input 
type="file"
name="image"
class="form-control">



</div>




</div>




<button 
class="btn btn-primary"
name="save">

Save Profile

</button>




</form>





<?php

if(!empty($data['image'])){


echo "

<hr>

<h5>Current Image</h5>

<img src='../assets/images/".$data['image']."' 
width='150'
class='rounded'>

";

}

?>



</div>


</div>


</div>


</body>


</html>