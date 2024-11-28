<?php 

    include 'functions.php'; 

    $pageName = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Dashboard';
    $pageTitle = "Department - " . $pageName;
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="styles/dashboard-faculty-main.css">
    <link rel="icon" href="images/logo.png">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">
    <title><?php echo $pageTitle ?> </title>
</head>

<body style="background-color: whitesmoke;">
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
    <main >
        <div class="container mt-5 text-center">
            <div class="row g-5 justify-content-center">
                <div class="col-4">
                    <a href="student-list.php?deptName=COLLEGE OF COMPUTING AND INFORMATION SCIENCES" class="text-decoration-none">
                        <div class="ccis">                       
                            <img src="images/ccis.png" alt="" height="80px">                                           
                            <p>COLLEGE OF COMPUTING AND INFORMATION SCIENCES</p>
                        </div>
                    </a>  
                </div>
                <div class="col-4">
                    <a href="student-list.php?deptName=COLLEGE OF CRIMINOLOGY" class="text-decoration-none">
                        <div class="crim">
                            <img src="images/CRIM.png" alt="" height="80px">                                             
                            <p>COLLEGE OF CRIMINOLOGY</p>
                        </div>
                    </a>    
                </div>
                <div class="col-4">
                    <a href="student-list.php?deptName=COLLEGE OF NURSING" class="text-decoration-none">
                        <div class="nursing">
                            <img src="images/NURSING.png" alt="" height="80px">                                              
                            <p>COLLEGE OF NURSING</p>
                        </div>
                    </a>    
                </div>
                <div class="col-4">
                    <a href="student-list.php?deptName=COLLEGE OF EDUCATION" class="text-decoration-none">
                        <div class="educ">
                            <img src="images/EDUC.png" alt="" height="80px">                       
                            <p>COLLEGE OF EDUCATION</p>
                        </div>
                    </a>
                </div>
                <div class="col-4">
                    <a href="student-list.php?deptName=COLLEGE OF ENGINEERING" class="text-decoration-none">
                        <div class="engr">
                            <img src="images/ENGR.png" alt="" height="80px">                        
                            <p>COLLEGE OF ENGINEERING</p>
                        </div>
                    </a>
                </div>
                <div class="col-4">
                    <a href="student-list.php?deptName=COLLEGE OF BUSINESS" class="text-decoration-none">
                        <div class="buss">
                            <img src="images/BUSS.png" alt="" height="80px">                        
                            <p>COLLEGE OF BUSINESS</p>
                        </div>
                    </a>
                </div>
                <div class="col-4">
                    <a href="student-list.php?deptName=COLLEGE OF HOSPITALITY MANAGEMENT" class="text-decoration-none">
                        <div class="hos">
                            <img src="images/HOSPI.png" alt="" height="80px">                        
                            <p>COLLEGE OF HOSPITALITY MANAGEMENT</p>
                        </div>
                    </a>
                </div>
                <div class="col-4">
                    <a href="student-list.php?deptName=COLLEGE OF ARTS AND SOCIAL SCIENCES" class="text-decoration-none">
                        <div class="cass">                        
                            <img src="images/SOCART.png" alt="" height="80px">                        
                            <p>COLLEGE OF ARTS AND SOCIAL SCIENCES</p>
                        </div>
                    </a>
                </div> 
            </div>
        </div>  
    </main>
    <br>
    <br>
    <br>
    <br>
    <hr>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>