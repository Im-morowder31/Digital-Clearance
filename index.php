<?php 

    include 'functions.php'; 

    $idNumber = "";
    $password = "";
    $errorArray = [];

    /*// Example student data to be inserted
    $studentID = '0122303926';
    $password = 'Beltran0122303926';
    $name = 'John Andre Beltran';

    $lrn = '0000';
    $sex = 'Male';
    $civilStatus = 'Single';
    $dob = 'May 9, 2001';
    $pob = 'Angeles city, Pampanga';
    $religion = 'Roman Catholic';
    $nationality = 'Filipino';
    $address = '1106 cubul sapalibutad, Angeles city';
    $contactNo = '09942072292';
    $course = 'BSIT';
    $section = 'CCIS7E';

    $library = 0;
    $osa = 0;
    $cashier = 0;
    $studentCouncil = 0;
    $dean = 0;
    $comment = '';

    insertStudentInfo($lrn, $sex, $civilStatus, $dob, $pob, $religion, $nationality, $address, $contactNo, $course, $section, $studentID);
    addStudentClearance($studentID, $library, $osa, $cashier, $studentCouncil, $dean, $comment);
    addStudentUser($studentID, $password, $name);*/

    if (isset($_POST['loginButton'])) { 
        $idNumber = htmlspecialchars(stripslashes(trim($_POST['userID'])));
        $password = htmlspecialchars(stripslashes(trim($_POST['password'])));
        $type = $_POST['radUser'];

        $errorArray = validateLoginCredentials($idNumber, $password, $type);

        if (empty($errorArray)) {
            $_SESSION['idNumber'] = $idNumber;
            $_SESSION['user_type'] = $type;

            if ($type === 'Faculty') {
                $facultyName = getFacultyUserNameById($idNumber); 
                if ($facultyName) {
                    $_SESSION['user_name'] = $facultyName; 
                } else {
                    $_SESSION['user_name'] = 'Unknown Faculty'; 
                }
                header('Location: dashboard-faculty.php'); // Redirect to faculty dashboard
            } 
            elseif ($type === 'Student') {
                $studentName = getStudentUserNameById($idNumber); 
                if ($studentName) {
                    $_SESSION['user_name'] = $studentName; 
                } else {
                    $_SESSION['user_name'] = 'Unknown Student'; 
                }
                header('Location: dashboard-student.php'); 
            }
        }   
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/icons/icon.ico">
    <link rel="stylesheet" href="styles/styles.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" href="images/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://kit.fontawesome.com/a082745512.js" crossorigin="anonymous"></script>
    <title>Login</title>
</head>
<body>
    <div class="z-3">
        <?php echo displayErrors($errorArray); ?>
    </div>
    <div class="container glass z-0">
        <img src="images/logo.png" alt="Logo" height="120px">
        <h1>Systems Plus</h1>
        <div class="form">
            <form method="post">
            <div class="input-box">
                <span class="icon">
                    <ion-icon name="mail"></ion-icon>
                </span>
                <input type="number" placeholder=" " step="1" name="userID" value="<?php echo isset($idNumber) ? $idNumber : ''; ?>" required>
                <label>Student ID</label>
            </div>

            <div class="input-box">
                <span class="icon">
                    <ion-icon name="lock-closed"></ion-icon>
                </span>
                <input type="password" placeholder=" " name="password" value="<?php echo isset($password) ? $password : ''; ?>" required>
                <label>Password</label>
            </div>

                <div class="login-select">
                    <p>Login as: </p>
                    <div class="radio">
                        <input type="radio" id="Student" name="radUser" value="Student" <?php echo (isset($_POST['radUser']) && $_POST['radUser'] == 'Student') ? 'checked' : ''; ?> checked>
                        <label for="Student">Student</label>
                        <input type="radio" id="Faculty" name="radUser" value="Faculty" <?php echo (isset($_POST['radUser']) && $_POST['radUser'] == 'Faculty') ? 'checked' : ''; ?>>
                        <label for="Faculty">Faculty</label>
                    </div>
                </div>
                </div>
                <button type="submit" name="loginButton">Login</button>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>