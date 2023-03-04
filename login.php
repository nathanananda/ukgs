<?php 
require'function.php';

$cookie_name = "log";
$cookie_value = $_POST["email"];
setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 1 Hari

if(empty($_POST["email"]) || strlen($_POST["email"])<1) {
    $_SESSION["log"] = $_COOKIE["log"];
    // echo "<script>alert('test');</script>";
    // echo "<pre>".print_r(get_defined_vars(), true)."</pre>";
    header("location:index.php");
} else if ( !empty ($_POST["email"] ) ) {
    $_SESSION["log"] = $_POST["email"];
    // echo "<script>alert('test 1');</script>";
    // echo "<pre>".print_r(get_defined_vars(), true)."</pre>";
    header("location:index.php");
}



// check login 
// if(!empty($_POST["email"])) {
//     $_SESSION["log"] = $_POST["email"];
//     header("location:index.php");
// }
    
// if(!isset($_SESSION["log"])) {
    
// } else {
//     header("location:index.php");
// }


// } else {
//     header("location:login.php");
// }



?>



<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Page Title - SB Admin</title>
        <link href="dist/css/style.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-dark ">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">
                                     <h3 class="text-center font-weight-light my-4">Login <br> Portal Siswa</h3>
                                    </div>
                                    <div class="card-body">
                                        <form action="" method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="email">Email :</label>
                                                <input class="form-control py-4" id="email" type="text" name="email" placeholder="Masukan Email" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="password">Password :</label>
                                                <input class="form-control py-4" id="password" type="password" name="password" placeholder="Masukan Password" />
                                            </div>
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <button class="btn btn-primary" type="submit" name="login" id="login" >Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
