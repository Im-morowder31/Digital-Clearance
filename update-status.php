<?php 

    include 'functions.php'; 

    // Get the stud_id from the URL
    $stud_id = isset($_GET['stud_id']) ? $_GET['stud_id'] : '';

    // Call the function to fetch student details
    $student = getStudentDetails($stud_id);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/update-status.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Update Status</title>
</head>
<body>
    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <div class="head">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-10 text-white " href="#">Update Status</a>
        </div>
    </header>

    <nav class="container mt-4">
        <div class="nav-title">
            Update Student Status
        </div>
        <div aria-label="breadcrumb">
            <ol class="breadcrumb mt-2">
                <li class="breadcrumb-item"><a href="dashboard-faculty.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="student-list.php">Student List</a></li>
                <li class="breadcrumb-item active" aria-current="page">Update Status</li>
            </ol>
        </div>
    </nav>

    <div class="container border border-primary-subtle border-opacity-10 rounded">
        <div class="fs-5 p-2">
            Selected Student
        </div>
        <div>
            <ul class="mt-2 fw-bold">
                <li><?php echo $student['stud_id']; ?></li>
                <li><?php echo $student['name']; ?></li>
                <LI><?php echo $student['Section']; ?></LI>
                <li><?php echo $student['Course']; ?></li>
            </ul>
        </div>
        <div>
            <form action="" class="">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label text-success" for="flexRadioDefault1">
                        Approve
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                    <label class="form-check-label text-danger" for="flexRadioDefault1">
                        Decline
                    </label>
                </div>
                <div class="mb-3 mt-2">
                <label for="exampleFormControlTextarea1" class="form-label">Comment:</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                </div>
                <div class="pb-3 ps-3">
                    <a href="student-list.php" class="btn btn-secondary btn-lg">Cancel</a>
                    <button type="submit" class="btn btn-success btn-lg">Update</button>
                </div>
            </form>
        </div>
    </div>





    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>