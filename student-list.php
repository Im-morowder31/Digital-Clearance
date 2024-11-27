<?php 
    $headerTitle = 'Student List';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/student-list.css">
    <title>College of Computing and Information Sciences</title>
</head>
<body>
    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <div class="head">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-10 text-white " href="#"><?= htmlspecialchars($headerTitle) ?></a>
        </div>
    </header>
    
    
    <nav aria-label="breadcrumb" class="mt-5 mb-5 ms-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard-faculty.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Student List</li>
        </ol>
        <div class="nav-title">
            College of Computing and Information Sciences
        </div>
    </nav>

    <table class="table table-striped text-center">
        <thead>
            <tr class="table-dark">
                <th>ID</th>
                <th>Name</th>
                <th>Section</th>
                <th>Course</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>200938002</th>
                <th>Shane Kian Castillo</th>
                <th>3A</th>
                <th>BSIT</th>
                <th class="text-success">Approved</th>
                <th><button class="btn btn-outline-info">Update Status</button></th>
            </tr>
            <tr>
                <th>200938002</th>
                <th>Shane Kian Castillo</th>
                <th>3A</th>
                <th>BSIT</th>
                <th class="text-success">Approved</th>
                <th><button class="btn btn-outline-info">Update Status</button></th>
            </tr>
            <tr>
                <th>200938002</th>
                <th>Shane Kian Castillo</th>
                <th>3A</th>
                <th>BSIT</th>
                <th class="text-danger">Declined</th>
                <th><button class="btn btn-outline-info">Update Status</button></th>
            </tr>
            <tr>
                <th>200938002</th>
                <th>Shane Kian Castillo</th>
                <th>3A</th>
                <th>BSIT</th>
                <th class="text-danger">Declined</th>
                <th><button class="btn btn-outline-info">Update Status</button></th>
            </tr>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>
</html>