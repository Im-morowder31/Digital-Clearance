<?php

    include 'functions.php'; 

    $checkStudent = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Student';
    $studentName = $_SESSION['user_name'];

    echo $studentName;

?>