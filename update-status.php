<?php 

    include 'functions.php'; 

    $deptAccount = $_SESSION['user_name'];

    $stud_id = isset($_GET['stud_id']) ? $_GET['stud_id'] : '';
    $student = getStudentDetails($stud_id);
    $currentStatus = getStudentStatus($stud_id, $deptAccount);

    $deptName = isset($_GET['deptName']) ? $_GET['deptName'] : '';

    $status = '';
    $comment = '';

    if (isset($_POST['updateButton'])) {
        $status = isset($_POST['radStatus']) ? $_POST['radStatus'] : '';
        $comment = isset($_POST['commentArea']) ? trim($_POST['commentArea']) : '';

        if ($status === 'Approve') {
            updateClearanceStatus($stud_id, 1, $deptAccount, $comment);
        } elseif ($status === 'Decline') {
            updateClearanceStatus($stud_id, 0, $deptAccount, $comment);
        }
        header("Location: student-list.php?deptName=" . urlencode($deptName));
        exit();
    }

    $comment = trim(getStudentComment($stud_id));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/update-status.css">
    <link rel="icon" href="images/logo.png">
    <script src="https://kit.fontawesome.com/a082745512.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title>Update Status</title>
</head>
<body>
    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <div class="head">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-10 text-white " href="#">Update Status</a>
        </div>
        <div class=" me-5 ">
            <a href="logout.php" class="text-light">               
                <i class="fa-solid fa-right-from-bracket fs-5 p-1">Logout</i>               
            </a>
        </div>
    </header>
    <nav class="container mt-4">
        <div class="nav-title">
            Update Student Status
        </div>
        <div aria-label="breadcrumb">
            <ol class="breadcrumb mt-2">
                <li class="breadcrumb-item"><a href="dashboard-faculty.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="student-list.php?deptName=<?php echo urlencode($deptName); ?>">Student List</a></li>
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
            <form method="post" class="">
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radStatus" value="Approve" id="approveRadio" 
                    <?php if ($currentStatus == 1) echo 'checked'; ?>>
                    <label class="form-check-label text-success" for="approveRadio">
                        Approve
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="radStatus" value="Decline" id="declineRadio" 
                    <?php if ($currentStatus == 0) echo 'checked'; ?>>
                    <label class="form-check-label text-danger" for="declineRadio">
                        Decline
                    </label>
                <div class="mb-3 mt-2">
                    <label for="commentArea" class="form-label">Comment:</label>
                    <textarea class="form-control" name="commentArea" id="commentArea" rows="3" onclick="this.setSelectionRange(0, 0)">
                        <?php echo htmlspecialchars(trim($comment)); ?>
                    </textarea>
                </div>
                <div class="pb-3 ps-3">
                    <a href="student-list.php?deptName=<?php echo urlencode($deptName); ?>" class="btn btn-secondary btn-lg">Cancel</a>
                    <button type="submit" name="updateButton" class="btn btn-success btn-lg">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>

        window.onload = function() {
            const commentTextarea = document.getElementById('commentArea');
            if (commentTextarea) {
                commentTextarea.value = commentTextarea.value.trim();
            }
        };
        // Get the radio buttons and textarea
        const approveRadio = document.getElementById('approveRadio');
        const declineRadio = document.getElementById('declineRadio');
        const commentTextarea = document.getElementById('commentArea');

        // Function to toggle textarea based on radio button selection
        function toggleTextarea() {
            if (approveRadio.checked) {
                commentTextarea.disabled = true; // Disable textarea when 'Approve' is selected
            } else if (declineRadio.checked) {
                commentTextarea.disabled = false; // Enable textarea when 'Decline' is selected
            }
        }

        // Add event listeners to the radio buttons
        approveRadio.addEventListener('change', toggleTextarea);
        declineRadio.addEventListener('change', toggleTextarea);

        toggleTextarea();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>