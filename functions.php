<?php 

    function checkUserSessionIsActive() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start(); 
        }
    }

    checkUserSessionIsActive();

    function openCon() {
        $con = mysqli_connect("localhost", "root", "", "digital-clearance");  
        if (!$con) {
            die("Connection failed: " . mysqli_connect_error());
        } 
        return $con;
    }

    function closeCon($con) {
        return mysqli_close($con);
    }

    function addStudentUser() {
        $con = openCon();
        if ($con) {
            $studentID = '0121302381'; // Example student ID
            $hashedPassword = md5('Nucum0121302381'); // Example password, securely hashed
            $name = 'Karl John L. Nucum'; // Example name
    
            $sql = "INSERT INTO student_users (stud_id, password, name) VALUES ('$studentID', '$hashedPassword', '$name')";
    
            if (mysqli_query($con, $sql)) {
                //echo "New student record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
    
            closeCon($con);
        } else {
            echo "Failed to connect to the database.";
        }
    }

    function getUsersByTable($tableName, $idColumn) {
        $con = openCon();
        $sql = "SELECT $idColumn, password FROM $tableName";
        $result = mysqli_query($con, $sql);
        $users = [];
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[$row[$idColumn]] = $row['password'];
            }
        }
        closeCon($con);
        return $users;
    }

    function validateLoginCredentials($id, $password, $type) {
        $errorArray = [];
        $users = [];
    
        if ($type === 'Faculty') {
            $users = getUsersByTable('faculty_users', 'dept_id');
        } elseif ($type === 'Student') {
            $users = getUsersByTable('student_users', 'stud_id');
        }
    
        if (empty($id)) {
            $errorArray['id'] = 'ID is required!';
        }
        if (empty($password)) {
            $errorArray['password'] = 'Password is required!';
        }
        if (empty($errorArray)) {
            if (!isset($users[$id]) || $users[$id] !== md5($password)) {
                $errorArray['credentials'] = 'Incorrect ID or password!';
            }
        }
    
        return $errorArray;
    }
    

    function displayErrors($errors) {
        if (empty($errors)) {
            return ''; 
        } 
        $output = '
        <div class="alert alert-danger alert-dismissible fade show mx-auto my-3" style="margin-bottom: 20px;" role="alert">
            <strong>System Errors:</strong> Please correct the following errors.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <hr>
            <ul>';
        foreach ($errors as $error) {
            $output .= '<li>' . htmlspecialchars($error) . '</li>';
        }
        $output .= '</ul></div>';
        return $output;
    }

    // Function to get user name from faculty_users
    function getFacultyUserNameById($idNumber) {
        $con = openCon();
        $query = "SELECT name FROM faculty_users WHERE dept_id = '$idNumber'";
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            closeCon($con);
            return $row['name']; // Return the name if found
        }

        closeCon($con);
        return null; // Return null if no name is found
    }

    // Function to get user name from student_users
    function getStudentUserNameById($idNumber) {
        $con = openCon();
        $query = "SELECT name FROM student_users WHERE stud_id = '$idNumber'";  
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            closeCon($con);
            return $row['name']; // Return the name if found
        }

        closeCon($con);
        return null; // Return null if no name is found
    }



?>