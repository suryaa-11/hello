<?php

session_start();

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

include "../config.php";


// Delete Message

if(isset($_GET['delete'])){

    $id = (int)$_GET['delete'];

    mysqli_query($conn,"DELETE FROM contact_messages WHERE id=$id");

    header("Location: messages.php");
    exit();

}


// Fetch Messages

$result = mysqli_query($conn,"SELECT * FROM contact_messages ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html>

<head>

<title>Messages Management</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

<div class="card shadow">

<div class="card-header bg-primary text-white">

<h3>

<i class="fa fa-envelope"></i>

Contact Messages

</h3>

</div>

<div class="card-body">

<a href="dashboard.php" class="btn btn-secondary mb-3">

<i class="fa fa-arrow-left"></i>

Back to Dashboard

</a>

<?php

if(mysqli_num_rows($result)>0){

?>

<div class="table-responsive">

<table class="table table-bordered table-hover align-middle">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Subject</th>

<th>Message</th>

<th>Date</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php

while($row=mysqli_fetch_assoc($result)){

?>

<tr>

<td><?php echo $row['id']; ?></td>

<td><?php echo htmlspecialchars($row['name']); ?></td>

<td><?php echo htmlspecialchars($row['email']); ?></td>

<td><?php echo htmlspecialchars($row['subject']); ?></td>

<td style="max-width:300px;">

<?php echo nl2br(htmlspecialchars($row['message'])); ?>

</td>

<td>

<?php echo $row['created_at']; ?>

</td>

<td>

<a

href="messages.php?delete=<?php echo $row['id']; ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Delete this message?');">

<i class="fa fa-trash"></i>

Delete

</a>

</td>

</tr>

<?php

}

?>

</tbody>

</table>

</div>

<?php

}else{

?>

<div class="alert alert-info">

No messages received yet.

</div>

<?php

}

?>

</div>

</div>

</div>

</body>

</html>