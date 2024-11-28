<?php

    include 'functions.php'; 

    $checkStudent = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Student';
    $studentName = $_SESSION['user_name'];

    

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/dashboard-student.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="icon" href="images/logo.png">
    <script src="https://kit.fontawesome.com/a082745512.js" crossorigin="anonymous"></script>
    <title>Student Dashboard</title>
</head>
<body> 
    <header class="navbar sticky-top bg-dark flex-md-nowrap p-0 shadow" data-bs-theme="dark">
        <div class="head">
            <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-10 text-white " href="#"><?php echo $_SESSION['user_name'] . " - Dashboard"; ?></a>
        </div>
        <div class=" me-5 ">
            <a href="index.php" class="text-light">               
                <i class="fa-solid fa-right-from-bracket fs-5 p-1">Logout</i>               
            </a>
        </div>
    </header>
    

        
    <div class="container pt-3 ps-5 mt-4 custom-shadow position-relative">
        <p class="" style="font-size: 40px;">
        <?php echo $_SESSION['user_name']; ?>
        </p>
        <div class="d-flex justify-content-between custom-info">
        <div>   
        <div style="display: flex; gap:10px;">
            <p class="fw-bold">Student ID:</p>
            <p>0122303926</p>
        </div>
        <div style="display: flex; gap:10px;">
            <p class="fw-bold">LRN:</p>
            <p>0122303926</p>
        </div>
        <div style="display: flex; gap:10px;">
            <p class="fw-bold">Sex:</p>
            <p>Male</p>
        </div>
        <div style="display: flex; gap:10px;">
            <p class="fw-bold">Civil Status:</p>
            <p>Single</p>
        </div>
        </div> 
        <div>
        <div style="display: flex; gap:10px;">
            <p class="fw-bold">Date of Birth:</p>
            <p>0122303926</p>
        </div>
        <div style="display: flex; gap:10px;">
            <p class="fw-bold">Place of Birth:</p>
            <p>0122303926</p>
        </div>
        <div style="display: flex; gap:10px;">
            <p class="fw-bold">Religion:</p>
            <p>Male</p>
        </div>
        <div style="display: flex; gap:10px;">
            <p class="fw-bold">Nationality:</p>
            <p>Single</p>
        </div>
        </div>
        <div>
        <div style="display: flex; gap:10px;">
            <p class="fw-bold">Permanent Address:</p>
            <p>0122303926</p>
        </div>
        <div style="display: flex; gap:10px;">
            <p class="fw-bold">Contact No:</p>
            <p>0122303926</p>
        </div>
        </div>
        <div class="position-absolute end-0 me-5  top-0 mt-4">
            <img src="images/user-stud.png" alt="" height="200px">
        </div>
        </div>
    </div>
    <div class="container d-flex mt-5">
    <div class="container custom-shadow pt-5 pb-5" style="width: 30%;">
            <div class="skill ps-5">
                <div class="outer">
                    <div class="inner">
                        <div id="number">
                            
                        </div>
                    </div>
                </div>

                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="160px" height="160px">
                    <defs>
                        <linearGradient id="GradientColor">
                        <stop offset="0%" stop-color="#e91e63" />
                        <stop offset="100%" stop-color="#673ab7" />
                        </linearGradient>
                    </defs>
                    <circle cx="80" cy="80" r="70" stroke-linecap="round" id="progress-circle"/>
                </svg>
            </div>
        </div>
        <div class="container">
            <table class="table table-striped custom-shadow">
                <thead>
                    <tr class="table-dark">
                        <th>Dept ID</th>
                        <th>Dept Name</th>
                        <th>Status</th>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>2009998887</th>
                        <th>Library</th>
                        <th class="text-danger">Decline</th>
                        <th><button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">View Comment</button></th>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal" tabindex="-1" id="exampleModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Modal title</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Modal body text goes here.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <script>
       let number = document.getElementById("number");
        let progressCircle = document.getElementById("progress-circle");

        let counter = 0; // Start from 0 or any initial value
        let targetValue = 100; // Desired end value
        let maxCounter = 100; // Maximum percentage (100%)
        let maxDashOffset = 472; // Full circle dasharray value (circumference of the circle)

        // Set the initial state of the progress circle
        number.innerHTML = counter + "%";
        progressCircle.style.strokeDashoffset = maxDashOffset; // Start from 100% hidden

        // Animate the circle and counter to the target value
        let interval = setInterval(() => {
            if (counter >= targetValue) { // Stop the animation at the target value
                clearInterval(interval);
            } else {
                counter += 1; // Increment the counter
                number.innerHTML = counter + "%"; // Update the percentage text

                // Gradually reduce the stroke-dashoffset
                let dashOffset = maxDashOffset - (maxDashOffset * counter) / maxCounter;
                progressCircle.style.strokeDashoffset = dashOffset; // Apply the new offset
            }
        }, 30); // Adjust the speed of animation



    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>