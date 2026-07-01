<?php

session_start();

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include "../config.php";

$success = "";
$error = "";

// --------------------
// Delete Resume
// --------------------
if (isset($_GET['delete'])) {

    $result = mysqli_query($conn, "SELECT * FROM resume LIMIT 1");
    $row = mysqli_fetch_assoc($result);

    if ($row) {

        $filepath = "../uploads/" . $row['resume_file'];

        if (file_exists($filepath)) {
            unlink($filepath);
        }

        mysqli_query($conn, "DELETE FROM resume");

        $success = "Resume deleted successfully.";
    }
}

// --------------------
// Upload Resume
// --------------------
if (isset($_POST['upload'])) {

    if ($_FILES['resume']['error'] == 0) {

        $file = $_FILES['resume']['name'];
        $temp = $_FILES['resume']['tmp_name'];

        $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

        if ($extension == "pdf") {

            // Delete old resume if exists
            $old = mysqli_query($conn, "SELECT * FROM resume LIMIT 1");
            $oldData = mysqli_fetch_assoc($old);

            if ($oldData) {

                $oldFile = "../uploads/" . $oldData['resume_file'];

                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }

                mysqli_query($conn, "DELETE FROM resume");
            }

            $newFile = time() . "_" . $file;

            if (move_uploaded_file($temp, "../uploads/" . $newFile)) {

                mysqli_query($conn, "INSERT INTO resume(resume_file) VALUES('$newFile')");

                $success = "Resume uploaded successfully.";

            } else {

                $error = "Failed to upload resume.";

            }

        } else {

            $error = "Only PDF files are allowed.";

        }

    } else {

        $error = "Please choose a PDF file.";

    }
}

// --------------------
// Fetch Resume
// --------------------
$result = mysqli_query($conn, "SELECT * FROM resume LIMIT 1");
$data = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Resume Management</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body class="bg-light">

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <h3>Resume Management</h3>

        </div>

        <div class="card-body">

            <a href="dashboard.php" class="btn btn-secondary mb-3">
                ← Back to Dashboard
            </a>

            <?php if ($success != "") { ?>

                <div class="alert alert-success">
                    <?php echo $success; ?>
                </div>

            <?php } ?>

            <?php if ($error != "") { ?>

                <div class="alert alert-danger">
                    <?php echo $error; ?>
                </div>

            <?php } ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">

                    <label class="form-label">
                        Select Resume (PDF)
                    </label>

                    <input
                        type="file"
                        name="resume"
                        class="form-control"
                        accept=".pdf"
                        required>

                </div>

                <button
                    type="submit"
                    name="upload"
                    class="btn btn-primary">

                    Upload Resume

                </button>

            </form>

            <hr>

            <h4>Current Resume</h4>

            <?php if ($data) { ?>

                <div class="alert alert-info">

                    <strong><?php echo $data['resume_file']; ?></strong>

                </div>

                <a
                    href="../uploads/<?php echo $data['resume_file']; ?>"
                    target="_blank"
                    class="btn btn-success">

                    View Resume

                </a>

                <a
                    href="resume.php?delete=1"
                    class="btn btn-danger"
                    onclick="return confirm('Are you sure you want to delete the resume?');">

                    Delete Resume

                </a>

            <?php } else { ?>

                <div class="alert alert-warning">

                    No resume uploaded.

                </div>

            <?php } ?>

        </div>

    </div>

</div>

</body>

</html>