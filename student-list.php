<?php 
    include 'functions.php'; 

    $headerTitle = 'Student List';
    $deptName = isset($_GET['deptName']) ? $_GET['deptName'] : 'Unknown Department';
    $pageTitle = "Students - " . getCollegeAbbreviation($deptName);
    $deptAccount = $_SESSION['user_name'];

    $deptCourses = [
        'COLLEGE OF COMPUTING AND INFORMATION SCIENCES' => ['BSCS', 'BSIT', 'BSIS', 'BSEMC'],
        'COLLEGE OF CRIMINOLOGY' => ['BSCRIM'],
        'COLLEGE OF NURSING' => ['BSN'],
        'COLLEGE OF EDUCATION' => ['BSPE'],
        'COLLEGE OF ENGINEERING' => ['BSCoE', 'BSECE'],
        'COLLEGE OF BUSINESS' => ['BSBA', 'BSA', 'BSCA', 'BSRES'],
        'COLLEGE OF HOSPITALITY MANAGEMENT' => ['BST', 'BSHM'],
        'COLLEGE OF ARTS AND SOCIAL SCIENCES' => ['BeEd', 'BSEd', 'BAC', 'BSSW']
    ];

    $courses = isset($deptCourses[$deptName]) ? $deptCourses[$deptName] : [];
    $students = fetchStudentsByCourses($courses, $deptAccount);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/student-list.css">
    <link rel="icon" href="images/logo.png">
    <script src="https://kit.fontawesome.com/a082745512.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title> <?php echo htmlspecialchars($pageTitle); ?>  </title>
</head>
<body>
    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <div class="head">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-10 text-white " href="#"><?= htmlspecialchars($headerTitle) ?></a>
        </div>
        <div class=" me-5 ">
            <a href="logout.php" class="text-light">               
                <i class="fa-solid fa-right-from-bracket fs-5 p-1">Logout</i>               
            </a>
        </div>
    </header>

    <nav aria-label="breadcrumb" class="mt-5 mb-5 ms-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard-faculty.php">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Student List</li>
        </ol>
        <div class="nav-title">
            <?php echo $deptName ?>
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
            <?php if (empty($students)): ?>
                <tr>
                    <td colspan="6" class="text-center">
                        No students found for this department.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <th><?php echo $student['stud_id']; ?></th>
                        <th><?php echo $student['name']; ?></th>
                        <th><?php echo $student['Section']; ?></th>
                        <th><?php echo $student['Course']; ?></th>
                        <th class="<?php echo ($student[$_SESSION['user_name']] == 1) ? 'text-success' : 'text-danger'; ?>">
                            <?php echo ($student[$_SESSION['user_name']] == 1) ? 'Approved' : 'Declined'; ?>
                        </th>
                        <th>
                        <a href="update-status.php?stud_id=<?php echo $student['stud_id']; ?>&deptName=<?php echo urlencode($deptName); ?>" class="btn btn-outline-info">
                            Update Status
                        </a>
                        </th>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>