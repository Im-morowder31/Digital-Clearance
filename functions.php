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

    function addUser() {
        $con = openCon();
        if ($con) {
            $email = 'user2@gmail.com';
            $hashedPassword = md5('password'); 
            $name = 'user2';
            $sql = "INSERT INTO users (email, password, name) VALUES ('$email', '$hashedPassword', '$name')";
            if (mysqli_query($con, $sql)) {
                echo "New record created successfully";
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($con);
            }
            closeCon($con);
        } else {
            echo "Failed to connect to the database.";
        }
    }

    function getFacultyUsers() {
        $con = openCon();       
        $sql = "SELECT dept_id, password FROM faculty_users";
        $result = mysqli_query($con, $sql);    
        $users = [];   
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $users[$row['dept_id']] = $row['password'];
            }
        }    
        closeCon($con);     
        return $users;
    }

    function checkLoginCredentialsFaculty($id, $password, $users) {
        return isset($users[$id]) && $users[$id] === md5($password);  
    }

    function validateLoginCredentials($id, $password) {
        $errorArray = [];
        $users = getFacultyUsers();  
        if (empty($id)) {
            $errorArray['email'] = 'ID is required!';
        } 
        if (empty($password)) {
            $errorArray['password'] = 'Password is required!';
        }
        if (empty($errorArray)) {
            if (!checkLoginCredentialsFaculty($id, $password, $users)) {
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


    
?>