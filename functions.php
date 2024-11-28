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

    function getCollegeAbbreviation($deptName) {
        $ignoreWords = ['of', 'and'];
        $words = explode(' ', $deptName);
        $abbreviation = '';
        foreach ($words as $word) {
            if (!in_array(strtolower($word), $ignoreWords)) {
                $abbreviation .= strtoupper($word[0]);
            }
        }
        return $abbreviation;
    }

    function insertStudentInfo($studentID, $lrn, $sex, $civilStatus, $dob, $pob, $religion, $nationality, $address, $contactNo, $course, $section) {
        $con = openCon(); // Assumes a function `openCon()` for database connection
    
        // Prepare the SQL query to prevent SQL injection
        $query = $con->prepare("
            INSERT INTO student_info 
            (stud_id, LRN, Sex, Civil_Status, Date_of_Birth, Place_of_Birth, Religion, Nationality, Address, Contact_Number, Course, Section) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        // Bind parameters to the query
        $query->bind_param(
            "ssssssssssss", 
            $studentID,
            $lrn, 
            $sex, 
            $civilStatus, 
            $dob, 
            $pob, 
            $religion, 
            $nationality, 
            $address, 
            $contactNo, 
            $course, 
            $section 
        );
        
        // Execute the query
        if ($query->execute()) {
            echo "Student information inserted successfully.";
        } else {
            echo "Error inserting student information: " . $query->error;
        }
        
        // Close the connection
        closeCon($con); // Assumes a function `closeCon()` for closing the connection
    }

    function addStudentUser($studentID, $password, $name) {
        $con = openCon(); // Assumes a function `openCon()` for database connection
    
        if ($con) {
            // Securely hash the password
            $hashedPassword = md5($password); // Note: Consider using a stronger hashing algorithm like bcrypt or Argon2
    
            // Use prepared statements to prevent SQL injection
            $stmt = $con->prepare("INSERT INTO student_users (stud_id, password, name) VALUES (?, ?, ?)");
    
            if ($stmt) {
                // Bind parameters to the query
                $stmt->bind_param("sss", $studentID, $hashedPassword, $name);
    
                // Execute the query
                if ($stmt->execute()) {
                    echo "New student record created successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
    
                // Close the prepared statement
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $con->error;
            }
    
            closeCon($con); // Assumes a function `closeCon()` for closing the connection
        } else {
            echo "Failed to connect to the database.";
        }
    }

    function addStudentClearance($studentID, $library, $osa, $cashier, $studentCouncil, $dean) {
        $con = openCon();
    
        $sql = "INSERT INTO student_clearance (stud_id, Library, OSA, Cashier, Student_Council, Dean) 
                VALUES (?, ?, ?, ?, ?, ?)";
    
        $stmt = mysqli_prepare($con, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'ssssss', $studentID, $library, $osa, $cashier, $studentCouncil, $dean);
            if (mysqli_stmt_execute($stmt)) {
                echo "Student clearance record added successfully.";
            } else {
                echo "Error: " . mysqli_stmt_error($stmt);
            }
            mysqli_stmt_close($stmt);
        } else {
            echo "Error: " . mysqli_error($con);
        }
    
        closeCon($con);
    }

    // Function to fetch student details by stud_id
    function getStudentDetails($stud_id) {
        // Open the connection
        $con = openCon();

        // Query to fetch the student details using stud_id
        $sql = "SELECT si.stud_id, su.name, si.Section, si.Course
                FROM student_info si
                LEFT JOIN student_users su ON si.stud_id = su.stud_id
                WHERE si.stud_id = ?";

        $query = $con->prepare($sql);
        $query->bind_param("s", $stud_id);
        $query->execute();
        $result = $query->get_result();

        // Check if a student is found
        if ($result->num_rows > 0) {
            // Return the student data
            return $result->fetch_assoc();
        } else {
            // Return null or false if no student is found
            return null;
        }

        // Close the connection
        closeCon($con);
    }

    function updateClearanceStatus($stud_id, $status, $column) {
        // Assuming you already have a function to open the connection
        $con = openCon();

        // Update the student clearance status
        $sql = "UPDATE student_clearance SET $column = ? WHERE stud_id = ?";
        $query = $con->prepare($sql);
        $query->bind_param("is", $status, $stud_id);  // "is" means integer and string parameters
        $query->execute();

        // Close the connection
        closeCon($con);
    }


    function getStudentStatus($stud_id, $col_name) {
        $con = openCon();
    
        // Sanitize the column name to avoid SQL injection
        $valid_columns = ['Library', 'OSA', 'Cashier', 'Student_Council', 'Dean']; // List of valid column names
        if (!in_array($col_name, $valid_columns)) {
            closeCon($con);
            return null;  // If the column name is invalid, return null
        }
    
        // Construct the SQL query with the sanitized column name
        $sql = "SELECT $col_name FROM student_clearance WHERE stud_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('s', $stud_id);  // 's' means it's a string
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $status = $row[$col_name];  // Get the value of the specified column
        } else {
            $status = null;
        }
    
        closeCon($con);
    
        return $status;
    }

    function fetchStudentsByCourses($courses, $currentDept) {
        $con = openCon();
    
        if (empty($courses)) {
            error_log("No courses selected.");
            return [];
        }
    
        // Clearance order
        $clearanceOrder = ['Library', 'OSA', 'Cashier', 'Student Council', 'Dean'];
    
        // Determine preceding departments
        $currentIndex = array_search($currentDept, $clearanceOrder);
        if ($currentIndex === false) {
            error_log("Invalid department: $currentDept");
            return [];
        }
        $precedingDepartments = array_slice($clearanceOrder, 0, $currentIndex);
    
        // Build approval condition
        $approvalConditions = [];
        foreach ($precedingDepartments as $dept) {
            $approvalConditions[] = "sc.`$dept` = 1";
        }
        $approvalCondition = !empty($approvalConditions) ? implode(" AND ", $approvalConditions) : "1=1";
        error_log("Approval condition: $approvalCondition");
    
        // Escape and list courses
        $coursesEscaped = array_map(function($course) use ($con) {
            return "'" . $con->real_escape_string($course) . "'";
        }, $courses);
        $coursesList = implode(",", $coursesEscaped);
    
        // Build SQL query
        $sql = "SELECT si.stud_id, su.name, si.Section, si.Course, sc.`$currentDept`
                FROM student_info si
                LEFT JOIN student_clearance sc ON si.stud_id = sc.stud_id
                LEFT JOIN student_users su ON si.stud_id = su.stud_id
                WHERE si.Course IN ($coursesList) AND ($approvalCondition)";
    
        error_log("SQL Query: $sql");
    
        $stmt = $con->prepare($sql);
        if (!$stmt) {
            error_log("Error preparing statement: " . $con->error);
            return [];
        }
    
        $stmt->execute();
        $result = $stmt->get_result();
        $students = [];
        while ($row = $result->fetch_assoc()) {
            $students[] = $row;
        }
    
        $stmt->close();
        closeCon($con);
    
        return $students;
    }  

?>