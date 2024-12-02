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
            return $row['name']; 
        }

        closeCon($con);
        return null; 
    }

    function getStudentUserNameById($idNumber) {
        $con = openCon();
        $query = "SELECT name FROM student_users WHERE stud_id = '$idNumber'";  
        $result = mysqli_query($con, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            closeCon($con);
            return $row['name']; 
        }

        closeCon($con);
        return null; 
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

    function insertStudentInfo($lrn, $sex, $civilStatus, $dob, $pob, $religion, $nationality, $address, $contactNo, $course, $section, $studentID) {
        $con = openCon(); 

        $query = $con->prepare("
            INSERT INTO student_info 
            (LRN, Sex, Civil_Status, Date_of_Birth, Place_of_Birth, Religion, Nationality, Address, Contact_Number, Course, Section, stud_id) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $query->bind_param(
            "ssssssssssss",   
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
            $section,
            $studentID
        );
        
        if ($query->execute()) {
            echo "Student information inserted successfully.";
        } else {
            echo "Error inserting student information: " . $query->error;
        }
        closeCon($con);
    }

    function addStudentUser($studentID, $password, $name) {
        $con = openCon();
    
        if ($con) {
            $hashedPassword = md5($password); 
    
            $stmt = $con->prepare("INSERT INTO student_users (stud_id, password, name) VALUES (?, ?, ?)");
            if ($stmt) {
                $stmt->bind_param("sss", $studentID, $hashedPassword, $name);
                if ($stmt->execute()) {
                    echo "New student record created successfully.";
                } else {
                    echo "Error: " . $stmt->error;
                }
                $stmt->close();
            } else {
                echo "Error preparing statement: " . $con->error;
            }
            closeCon($con);
        } else {
            echo "Failed to connect to the database.";
        }
    }

    function addStudentClearance($studentID, $library, $osa, $cashier, $studentCouncil, $dean, $comment) {
        $con = openCon();
    
        $sql = "INSERT INTO student_clearance (stud_id, Library, OSA, Cashier, `Student Council`, Dean, Comment) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, 'sssssss', $studentID, $library, $osa, $cashier, $studentCouncil, $dean, $comment);
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

    function getStudentDetails($stud_id) {
        $con = openCon();

        $sql = "SELECT si.stud_id, su.name, si.Section, si.Course
                FROM student_info si
                LEFT JOIN student_users su ON si.stud_id = su.stud_id
                WHERE si.stud_id = ?";

        $query = $con->prepare($sql);
        $query->bind_param("s", $stud_id);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
        closeCon($con);
    }

    function updateClearanceStatus($stud_id, $status, $column, $comment) {
        $con = openCon();
        
        $column = "`" . str_replace("`", "``", $column) . "`"; 
        $sql = "UPDATE student_clearance SET $column = ?, Comment = ? WHERE stud_id = ?";
        
        $query = $con->prepare($sql);
        $query->bind_param("iss", $status, $comment, $stud_id);
        
        $query->execute();
        closeCon($con);
    }
    

    function getStudentComment($stud_id) {
        $con = openCon();

        $sql = "SELECT comment FROM student_clearance WHERE stud_id = ?";
        $query = $con->prepare($sql);
        $query->bind_param("i", $stud_id);  
        $query->execute();
        $result = $query->get_result();
        $comment = '';

        if ($row = $result->fetch_assoc()) {
            $comment = $row['comment'];
        }
        closeCon($con);
        return $comment;
    }
    
    function getStudentStatus($stud_id, $col_name) {
        $con = openCon();
    
        $valid_columns = ['Library', 'OSA', 'Cashier', 'Student_Council', 'Dean']; 
        if (!in_array($col_name, $valid_columns)) {
            closeCon($con);
            return null; 
        }
    
        $sql = "SELECT $col_name FROM student_clearance WHERE stud_id = ?";
        $stmt = $con->prepare($sql);
        $stmt->bind_param('s', $stud_id);  
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $status = $row[$col_name];  
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
        $clearanceOrder = ['Library', 'OSA', 'Cashier', 'Student Council', 'Dean'];
        $currentIndex = array_search($currentDept, $clearanceOrder);
        if ($currentIndex === false) {
            error_log("Invalid department: $currentDept");
            return [];
        }
        $precedingDepartments = array_slice($clearanceOrder, 0, $currentIndex);
        $approvalConditions = [];
        foreach ($precedingDepartments as $dept) {
            $approvalConditions[] = "sc.`$dept` = 1";
        }
        $approvalCondition = !empty($approvalConditions) ? implode(" AND ", $approvalConditions) : "1=1";
        error_log("Approval condition: $approvalCondition");
    
        $coursesEscaped = array_map(function($course) use ($con) {
            return "'" . $con->real_escape_string($course) . "'";
        }, $courses);
        $coursesList = implode(",", $coursesEscaped);
    
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

    function getStudentInfo($studentID) {
        $con = openCon();

        $query = "SELECT * FROM student_info WHERE stud_id = ?";
        $stmt = $con->prepare($query);
        $stmt->bind_param("s", $studentID);
        $stmt->execute();
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        } else {
            return null;
        }
        closeCon($con);
    }

    function getClearanceStatus($stud_id) {
        $con = openCon();

        $sql = "SELECT Library, OSA, Cashier, `Student Council`, Dean 
                FROM student_clearance 
                WHERE stud_id = ?";
        
        $query = $con->prepare($sql);
        $query->bind_param("i", $stud_id);
        $query->execute();
        $result = $query->get_result();
    
        $clearanceData = [];
        while ($row = $result->fetch_assoc()) {
            $clearanceData[] = $row;
        }
        if (empty($clearanceData)) {
            echo "No clearance data found for student ID: $stud_id";
        }
        closeCon($con);
        return $clearanceData;
    }

    function getApprovedCount($stud_id) {
        $con = openCon();
        
        $sql = "SELECT Library, OSA, Cashier, `Student Council`, Dean 
                FROM student_clearance 
                WHERE stud_id = ?";
        
        $query = $con->prepare($sql);
        $query->bind_param("i", $stud_id);
        $query->execute();
        $result = $query->get_result();
    
        $approvedCount = 0;
    
        if ($row = $result->fetch_assoc()) {
            foreach (['Library', 'OSA', 'Cashier', 'Student Council', 'Dean'] as $department) {
                if ($row[$department] == 1) {
                    $approvedCount++;
                }
            }
        }
        closeCon($con);
        return $approvedCount;
    }

    function getDepartmentComment($stud_id) {
        $con = openCon();

        $sql = "SELECT comment FROM student_clearance WHERE stud_id = ?";
        $query = $con->prepare($sql);
        $query->bind_param("i", $stud_id);
        $query->execute();
        $result = $query->get_result();
        
        $comment = "";
        if ($row = $result->fetch_assoc()) {
            $comment = $row['comment']; 
        }
        closeCon($con); 
        return $comment;
    }

    function changePassword($studentID, $oldPassword, $newPassword) {
        $con = openCon();
        $errorArray = [];  // Initialize error array
        
        // Validate password strength (for example, minimum 8 characters, mix of letters and numbers)
        if (strlen($newPassword) < 8) {
            $errorArray['password'] = "New password must be at least 8 characters long.";
        }
    
        if (empty($errorArray)) {
            // Hash the old password to compare it with the database
            $oldPasswordHashed = $oldPassword;  // Still using MD5 as per the requirement
            $newPasswordHashed = md5($newPassword);  // MD5 hash for the new password
    
            // Prepare query to fetch the user with the old password
            $stmt = $con->prepare("SELECT password FROM student_users WHERE stud_id = ?");
            $stmt->bind_param("s", $studentID);
            $stmt->execute();
            $stmt->store_result();
            
            if ($stmt->num_rows > 0) {
                $stmt->bind_result($storedPassword);
                $stmt->fetch();
                
                // Compare the hashed old password with the stored one
                if ($oldPasswordHashed === $storedPassword) {
                    // Check if the new password is different from the old one
                    if ($oldPasswordHashed === $newPasswordHashed) {
                        $errorArray['password'] = "New password cannot be the same as the old password.";
                    }
                    
                    // If no errors, update the password in the database
                    if (empty($errorArray)) {
                        $updateStmt = $con->prepare("UPDATE student_users SET password = ? WHERE stud_id = ?");
                        $updateStmt->bind_param("ss", $newPasswordHashed, $studentID);
                        
                        if ($updateStmt->execute()) {
                            $updateStmt->close();
                            $stmt->close();
                            $con->close();
                            return ['status' => 'success', 'message' => "Password updated successfully."];
                        } else {
                            $updateStmt->close();
                            $stmt->close();
                            $con->close();
                            return ['status' => 'error', 'message' => "Error updating password: " . $con->error];
                        }
                    }
                } else {
                    // Old password is incorrect
                    $stmt->close();
                    $con->close();
                    return ['status' => 'error', 'message' => "Old password does not match our records."];
                }
            } else {
                // No matching user found
                $stmt->close();
                $con->close();
                return ['status' => 'error', 'message' => "No user found with the provided student ID."];
            }
        }
        
        // Return errors if found
        $con->close();
        return ['status' => 'error', 'message' => $errorArray];
    }
    

    // Function to validate the old password
    function validatePasswordCredentials($studentID, $oldPassword) {
        $errors = [];
        $storedOldPassword = getOldPassword($studentID);  // Get the current hashed password from the database

        // Check if the old password matches the stored password (MD5 hash)
        if (md5($oldPassword) !== $storedOldPassword) {
            $errors['oldPassword'] = "Incorrect old password.";
        }

        return $errors;
    }

    function getOldPassword($studentID) {
        // Open the database connection
        $con = openCon();
    
        // Prepare the query to fetch the user's old password
        $stmt = $con->prepare("SELECT password FROM student_users WHERE stud_id = ?");
        $stmt->bind_param("s", $studentID);  // Bind the studentID parameter
        $stmt->execute();
        $result = $stmt->get_result();
    
        // Check if a user with the provided studentID exists
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $oldPassword = $row['password'];  // Get the old password
        } else {
            $oldPassword = null;  // Return null if the student ID doesn't exist
        }
    
        // Close the prepared statement and the database connection
        $stmt->close();
        $con->close();
    
        return $oldPassword;
    }
    
    
    

?>