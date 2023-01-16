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

$description = $conn->prepare("SELECT * FROM description");
$description->execute();
$row_description = $description->fetchAll();

if (isset($_POST['save'])) {
    $title = $_POST['title'];
    $img = $_FILES['img'];
    $des_id = $_POST['des_id'];

    $allow = array('jpg', 'jpeg', 'png', 'webp');
    $extention1 = explode(".", $img['name']); //เเยกชื่อกับนามสกุลไฟล์
    $fileActExt1 = strtolower(end($extention1)); //แปลงนามสกุลไฟล์เป็นพิมพ์เล็ก
    $fileNew1 = rand() . "." . "webp";
    $filePath1 = "upload/upload_description/" . $fileNew1;

    if (in_array($fileActExt1, $allow)) {
        if ($img['size'] > 0 && $img['error'] == 0) {
            if (move_uploaded_file($img['tmp_name'], $filePath1)) {
                $description = $conn->prepare("UPDATE description SET title = :title , img = :img WHERE id=:id");
                $description->bindParam(":title", $title);
                $description->bindParam(":img", $fileNew1);
                $description->bindParam(":id", $des_id);

                $description->execute();

                if ($description) {
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
                    echo "<meta http-equiv='refresh' content='1.5;url=description'>";
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
                    echo "<meta http-equiv='refresh' content='1.5;url=description'>";
                }
            }
        }
    } else {
        $description = $conn->prepare("UPDATE description SET title = :title WHERE id=:id");
        $description->bindParam(":title", $title);
        $description->bindParam(":id", $des_id);
        $description->execute();

        if ($description) {
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
            echo "<meta http-equiv='refresh' content='1.5;url=description'>";
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
            echo "<meta http-equiv='refresh' content='1.5;url=description'>";
        }
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
                <h3>Description</h3>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Description</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr align="center">
                                        <th scope="col" width="20%">Photo</th>
                                        <th scope="col" width="50%">Title</th>
                                        <th scope="col">Manage</th>
                                    </tr>
                                </thead>
                                <?php foreach ($row_description as $row_description) { ?>

                                    <tbody>
                                        <tr>
                                            <td align="center"> <img src="upload/upload_description/<?php echo $row_description['img'] ?>" alt="" width="50%"></td>
                                            <td align="center"><?php echo $row_description['title'] ?></td>
                                            <td align="center"><a type="input" data-bs-toggle="modal" class="btn btn-edit" href="#about_us<?php echo $row_description['id'] ?>"><i class="bi bi-pencil-square"></i></a></td>
                                        </tr>
                                    </tbody>
                                    <div class="modal fade" id="about_us<?php echo $row_description['id'] ?>" data-bs-backdrop="static" aria-hidden="true">
                                        <div class="modal-dialog modal-lg  modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Description</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post" enctype="multipart/form-data">
                                                        <span>Title</span>
                                                        <input type="hidden" name="des_id" value="<?php echo $row_description['id'] ?>">
                                                        <input type="text" class="form-control mb-2" name="title" value="<?php echo $row_description['title'] ?>"><br>

                                                        <div class="content d-flex justify-content-center align-item-center">
                                                            <div class="title-img">
                                                                <span id="upload-img">Photo</span>
                                                                <div class="group-pos">
                                                                    <input type="file" name="img" id="imgInput-cover" class="form-control">
                                                                    <button type="button" class="btn reset" id="reset1">ยกเลิก</button>
                                                                </div>
                                                                <span class="file-support">Only file support ('jpg', 'jpeg', 'png','webp').</span>
                                                                <div id="gallery-cover">
                                                                    <div class='box-edit-img-cover'>
                                                                        <span class='del-edit-img'></span>
                                                                        <img class='edit-img-cover' id='previewImg-cover' src='upload/upload_description/<?php echo $row_description['img'] ?>'>
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
                                <?php   } ?>




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

    <script>
        $(document).ready(function() {
            $('#reset1').click(function() {
                $('#imgInput-cover').val(null);
                $('#previewImg-cover').attr("src", "upload/upload_description/<?php echo $row_description['img'] ?>");
                // $('.previewImg').addClass('none');
                // $('.box-edit-img').addClass('none');
            });

        });
    </script>
</body>

</html>