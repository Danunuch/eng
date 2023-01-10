<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
require_once('config/engfluency_db.php');
session_start();
error_reporting(0);
if (!isset($_SESSION['admin_login'])) {
    echo "<script>alert('Please Login')</script>";
    echo "<meta http-equiv='refresh' content='0;url=login'>";
}

$about = $conn->prepare("SELECT * FROM about");
$about->execute();
$row_about = $about->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['save'])) {
    $address = $_POST['address'];
    $address_en = $_POST['address_en'];
    $tel = $_POST['tel'];
    $email = $_POST['email'];

    $about = $conn->prepare("UPDATE about SET address = :address, tel = :tel, email = :email, address_en = :address_en");
    $about->bindParam(":address", $address);
    $about->bindParam(":tel", $tel);
    $about->bindParam(":email", $email);
    $about->bindParam(":address_en", $address_en);
    $about->execute();

    if ($about) {
        echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        text: 'Edit Success',
                        icon: 'success',
                        timer: 5000,
                        showConfirmButton: false
                    });
                })
                </script>";
        echo "<meta http-equiv='refresh' content='1.5;url=about_us'>";
    } else {
        echo "<script>
        $(document).ready(function() {
            Swal.fire({
                text: 'Something Went Wrong',
                icon: 'error',
                timer: 5000,
                showConfirmButton: false
            });
        })
        </script>";
        echo "<meta http-equiv='refresh' content='1.5;url=about_us'>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENGLISH FLUENCY COMMUNICATION</title>
    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/main/app-dark.css">
    <link rel="stylesheet" href="css/about_us.css">
    <!-- <link rel="shortcut icon" href="assets/images/logo/favicon.svg" type="image/x-icon"> -->
    <link rel="shortcut icon" href="../images/logo.svg" type="image/png">
    <link rel="stylesheet" href="assets/css/shared/iconly.css">
</head>

<body>
    <div id="app">
        <?php include('sidebar.php'); ?>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <h3>About Us</h3>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">About Us</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr align="center">
                                        <th scope="col">Address</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $row_about['address'] ?> <br><?php echo $row_about['address_en'] ?></td>
                                        <td><?php echo $row_about['tel'] ?></td>
                                        <td><?php echo $row_about['email'] ?></td>
                                        <td align="center"><a type="input" data-bs-toggle="modal" class="btn btn-edit " href="#about_us"><i class="bi bi-pencil-square"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="about_us" data-bs-backdrop="static" aria-hidden="true">
                    <div class="modal-dialog modal-lg  modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit About Us</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form method="post" enctype="multipart/form-data">
                                    <span>Address</span>
                                    <input type="text" class="form-control mb-2" name="address" value="<?php echo $row_about['address'] ?>">
                                    <span>Address (EN)</span>
                                    <input type="text" class="form-control mb-2" name="address_en" value="<?php echo $row_about['address_en'] ?>">
                                    <span>Phone</span>
                                    <input type="text" class="form-control mb-2" name="tel" value="<?php echo $row_about['tel'] ?>">
                                    <span>Email</span>
                                    <input type="text" class="form-control mb-2" name="email" value="<?php echo $row_about['email'] ?>">
                                    <div class="d-flex justify-content-center-align-item-center">
                                        <button type="submit" name="save" class="btn btn-save">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php include('footer.php'); ?>
        </div>
    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>

</body>

</html>