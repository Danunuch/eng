<!DOCTYPE html>
<script src="https://cdn.tiny.cloud/1/2c646ifr40hywrvj32dwwml8e5qmxxr52qvzmjjq7ixbrjby/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
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

$contact = $conn->prepare("SELECT * FROM contact");
$contact->execute();
$row_contact = $contact->fetchAll();
$contact_row = array_reverse($row_contact);

$about = $conn->prepare("SELECT * FROM about");
$about->execute();
$row_about = $about->fetch(PDO::FETCH_ASSOC);


if (isset($_POST['save'])) {
$img = $_FILES['img'];


$allow = array('jpg', 'jpeg', 'png', 'webp');
$extention1 = explode(".", $img['name']); //เเยกชื่อกับนามสกุลไฟล์
$fileActExt1 = strtolower(end($extention1)); //แปลงนามสกุลไฟล์เป็นพิมพ์เล็ก
$fileNew1 = rand() . "." . "webp";
$filePath1 = "upload/upload_contact/" . $fileNew1;

if (in_array($fileActExt1, $allow)) {
    if ($img['size'] > 0 && $img['error'] == 0) {
        if (move_uploaded_file($img['tmp_name'], $filePath1)) {
            $img1 = $conn->prepare("UPDATE about SET img = :img");
            $img1->bindParam(":img", $fileNew1);
            $img1->execute();

            if ($img1) {
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
                echo "<meta http-equiv='refresh' content='1.5;url=contact'>";
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
                echo "<meta http-equiv='refresh' content='1.5;url=contact'>";
            }
        }
    }
} 

}
if (isset($_POST['change-status'])) {
    $message_id =  $_POST['message_id'];
    $check = $_POST['check'];
    $edit_status = $conn->prepare("UPDATE contact SET status = :status WHERE id = :id");
    $edit_status->bindParam(":status", $check);
    $edit_status->bindParam(":id", $message_id);
    $edit_status->execute();

    if ($edit_status) {
        echo "<script>
        $(document).ready(function() {
            Swal.fire({
                text: 'Change Status Success',
                icon: 'success',
                timer: 10000,
                showConfirmButton: false
            });
        })
        </script>";
         echo "<meta http-equiv='refresh' content='1;url=contact'>";
            
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
    <link rel="stylesheet" href="css/about_us.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="css/slide.css?v=<?php echo time(); ?>">
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
                <h3>Message</h3>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Message</h4>
                    </div>
                    <div class="card-body">
                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr align="center">
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Phone</th>
                                        <th scope="col">Message</th>
                                        <th scope="col">Status</th>
                                    </tr>
                                </thead>
                                <?php foreach ($contact_row as $contact_row) { ?>

                                    <tbody>
                                        <tr>
                                            <td align="center"><?php echo $contact_row['username'] ?></td>
                                            <td align="center"><?php echo $contact_row['email'] ?></td>
                                            <td align="center"><?php echo $contact_row['tel'] ?></td>
                                            <td align="center"><a type="input" data-bs-toggle="modal" class="btn btn-info " href="#message<?php echo $contact_row['id'] ?>"><i class="bi bi-eye"></i></a></td>
                                            <td align="center"><a type="input" data-bs-toggle="modal" class="btn" <?php if ($contact_row['status'] == "on") {
                                                                                                                        echo 'style = "background-color: green ; color : white;"';
                                                                                                                    } else {
                                                                                                                        echo 'style = "background-color: red; color : white;"';
                                                                                                                    } ?> href="#status<?php echo $contact_row['id'] ?>"><i class="bi bi-gear"></i></a></td>

                                        </tr>
                                    </tbody>
                                    <div class="modal fade" id="message<?php echo $contact_row['id']; ?>" data-bs-backdrop="static" aria-hidden="true">

                                        <div class="modal-dialog  modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">ข้อความจากคุณ <?php echo $contact_row['username']; ?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-message">
                                                        <form method="post">
                                                            <p><?php echo $contact_row['message']; ?></p>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>


                                    <div class="modal fade" id="status<?php echo $contact_row['id']; ?>" data-bs-backdrop="static" aria-hidden="true">
                                        <div class="modal-dialog  modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel"><?php echo "Manage Status";?></h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="form-check form-switch">
                                                        <form method="post">
                                                            <div class="switch-box">
                                                                <span><?php echo "Not Read";?></span>
                                                                <input type="hidden" name="message_id" value="<?php echo $contact_row['id']; ?>">
                                                                <input class="form-check-input" id="switch-check" name="check" type="checkbox" <?php if ($contact_row['status'] == "on") {
                                                                                                                                                    echo "checked";
                                                                                                                                                } else {
                                                                                                                                                    echo "";
                                                                                                                                                } ?>>
                                                                <span><?php echo "Read";?></span>
                                                            </div>
                                                            <div class="box-btn">
                                                                <button name="change-status" class="btn btn-status" type="submit">Save</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                <?php   } ?>
                            </table>
                        </div>

                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr align="center">
                                        <th scope="col" width="70%">Photo</th>
                                        <th scope="col">Manage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td align="center"> <img src="upload/upload_contact/<?php echo $row_about['img'] ?>" alt="" width="40%"></td>
                                        <td align="center"><a type="input" data-bs-toggle="modal" class="btn btn-edit " href="#about_us<?php echo $row_about['id'] ?>"><i class="bi bi-pencil-square"></i></a></td>
                                    </tr>
                                </tbody>
                                <div class="modal fade" id="about_us<?php echo $row_about['id'] ?>" data-bs-backdrop="static" aria-hidden="true">
                                    <div class="modal-dialog modal-lg  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit contact</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data">


                                                    <div class="content d-flex justify-content-center align-item-center">
                                                        <div class="title-img">
                                                            <span id="upload-img">Photo</span>
                                                            <div class="group-pos">
                                                                <input type="hidden" name="id" value="<?php echo $row_about['id'] ?>">
                                                                <input type="file" name="img" id="imgInput-cover" class="form-control">
                                                                <!-- <button type="button" class="btn reset" id="reset1">ยกเลิก</button> -->
                                                            </div>
                                                            <span class="file-support">Only file support ('jpg', 'jpeg', 'png','webp').</span>
                                                            <div id="gallery-cover">
                                                                <div class='box-edit-img-cover'>
                                                                    <span class='del-edit-img'></span>
                                                                    <img class='edit-img-cover' id='previewImg-cover' src='upload/upload_contact/<?php echo $row_about['img'] ?>'>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-center-align-item-center">
                                                        <button type="submit" name="save" class="btn btn-save">Save</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>





                            </table>
                        </div>
                    </div>
                </div>

            </section>
            <?php include('footer.php'); ?>
        </div>
    </div>
    <script src="assets/js/bootstrap.js"></script>
    <script src="assets/js/app.js"></script>

    <script>
        let imgInput = document.getElementById('imgInput-cover');
        let previewImg = document.getElementById('previewImg-cover');

        imgInput.onchange = evt => {
            const [file] = imgInput.files;
            if (file) {
                previewImg.src = URL.createObjectURL(file);
            }
        }
    </script>
    <!-- 
    <script>
        $(document).ready(function() {
            $('#reset1').click(function() {
                $('#imgInput-cover').val(null);
                $('#previewImg-cover').attr("src", "");
                $('.previewImg').addClass('none');
                $('.box-edit-img').addClass('none');
            });

        });
    </script> -->
</body>

</html>