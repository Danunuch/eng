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

$service = $conn->prepare("SELECT * FROM service");
$service->execute();
$row_service = $service->fetch(PDO::FETCH_ASSOC);

//บันทึกรูปภาพ//
if (isset($_POST['save'])) {
    $id = $_POST['id'];
    $img = $_FILES['img'];


    $allow = array('jpg', 'jpeg', 'png', 'webp');
    $extention1 = explode(".", $img['name']); //เเยกชื่อกับนามสกุลไฟล์
    $fileActExt1 = strtolower(end($extention1)); //แปลงนามสกุลไฟล์เป็นพิมพ์เล็ก
    $fileNew1 = rand() . "." . "webp";
    $filePath1 = "upload/upload_service/" . $fileNew1;

    if (in_array($fileActExt1, $allow)) {
        if ($img['size'] > 0 && $img['error'] == 0) {
            if (move_uploaded_file($img['tmp_name'], $filePath1)) {
                $service = $conn->prepare("UPDATE service SET img = :img WHERE id = :id");
                $service->bindParam(":img", $fileNew1);
                $service->bindParam(":id", $id);
                $service->execute();

                if ($service) {
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
                    echo "<meta http-equiv='refresh' content='1.5;url=service'>";
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
                    echo "<meta http-equiv='refresh' content='1.5;url=service'>";
                }
            }
        }
    }
}

//บันทึกข้อความ//
if (isset($_POST['save_text'])) {
    $content1 = $_POST['content1'];
    $content2 = $_POST['content2'];

    $stmt = $conn->prepare("UPDATE service SET content1 = :content1 , content2 = :content2");
    $stmt->bindParam(":content1", $content1);
    $stmt->bindParam(":content2", $content2);
    $stmt->execute();

    if ($stmt) {
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
        echo "<meta http-equiv='refresh' content='1.5;url=service'>";
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
        echo "<meta http-equiv='refresh' content='1.5;url=service'>";
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
                <h3>Service</h3>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Service</h4>
                    </div>
                    <div class="card-body">
                        <div class="box-slide-text">
                            <div class="content-text">
                                <form method="post">
                                    <div class="btn-edit-ser">
                                        <button type="submit" name="save_text" class="btn btn-save-text">Save</button>
                                    </div>
                                    <div class="pos-text">
                                        <textarea name="content1"><?php echo $row_service['content1'] ?></textarea>
                                        <textarea name="content2"><?php echo $row_service['content2'] ?></textarea>
                                    </div>
                                </form>
                                <script>
                                    tinymce.init({
                                        selector: 'textarea',


                                        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                                        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table mergetags | addcomment showcomments | spellcheckdialog a11ycheck typography | align lineheight | checklist numlist bullist indent outdent | emoticons charmap | removeformat',
                                        tinycomments_mode: 'embedded',
                                        tinycomments_author: 'Author name',
                                        mergetags_list: [{
                                                value: 'First.Name',
                                                title: 'First Name'
                                            },
                                            {
                                                value: 'Email',
                                                title: 'Email'
                                            },
                                        ]
                                    });
                                </script>
                            </div>
                        </div> <br>
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
                                        <td align="center"> <img src="upload/upload_service/<?php echo $row_service['img'] ?>" alt="" width="40%"></td>
                                        <td align="center"><a type="input" data-bs-toggle="modal" class="btn btn-edit " href="#about_us<?php echo $row_service['id'] ?>"><i class="bi bi-pencil-square"></i></a></td>
                                    </tr>
                                </tbody>
                                <div class="modal fade" id="about_us<?php echo $row_service['id'] ?>" data-bs-backdrop="static" aria-hidden="true">
                                    <div class="modal-dialog modal-lg  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Service</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data">


                                                    <div class="content d-flex justify-content-center align-item-center">
                                                        <div class="title-img">
                                                            <span id="upload-img">Photo</span>
                                                            <div class="group-pos">
                                                                <input type="hidden" name="id" value="<?php echo $row_service['id'] ?>">
                                                                <input type="file" name="img" id="imgInput-cover" class="form-control">
                                                                <!-- <button type="button" class="btn reset" id="reset1">ยกเลิก</button> -->
                                                            </div>
                                                            <span class="file-support">Only file support ('jpg', 'jpeg', 'png','webp').</span>
                                                            <div id="gallery-cover">
                                                                <div class='box-edit-img-cover'>
                                                                    <span class='del-edit-img'></span>
                                                                    <img class='edit-img-cover' id='previewImg-cover' src='upload/upload_service/<?php echo $row_service['img'] ?>'>
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