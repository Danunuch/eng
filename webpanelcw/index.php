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



$stmt = $conn->prepare("SELECT * FROM content");
$stmt->execute();
$row_content = $stmt->fetch(PDO::FETCH_ASSOC);

if (isset($_POST['save'])) {
    $content = $_POST['content'];
    $img = $_FILES['img'];

    $allow = array('jpg', 'jpeg', 'png', 'webp');
    $extention1 = explode(".", $img['name']); //เเยกชื่อกับนามสกุลไฟล์
    $fileActExt1 = strtolower(end($extention1)); //แปลงนามสกุลไฟล์เป็นพิมพ์เล็ก
    $fileNew1 = rand() . "." . "webp";
    $filePath1 = "upload/upload_content/" . $fileNew1;

    if (in_array($fileActExt1, $allow)) {
        if ($img['size'] > 0 && $img['error'] == 0) {
            if (move_uploaded_file($img['tmp_name'], $filePath1)) {
                $con1 = $conn->prepare("UPDATE content SET img = :img, content = :content");
                $con1->bindParam(":img", $fileNew1);
                $con1->bindParam(":content", $content);
                $con1->execute();

                if ($con1) {
                    echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            text: 'Edit Success',
                            icon: 'success',
                            timer: 10000,
                            showConfirmButton: false
                        });
                    })
                    </script>";
                    echo "<meta http-equiv='refresh' content='2;url=index'>";
                } else {
                    echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            text: 'Something Went Wrong',
                            icon: 'error',
                            timer: 10000,
                            showConfirmButton: false
                        });
                    })
                    </script>";
                    echo "<meta http-equiv='refresh' content='2;url=index'>";
                }
            }
        }
    } else {
        $con1 = $conn->prepare("UPDATE content SET  content = :content");
        $con1->bindParam(":content", $content);
        $con1->execute();

        if ($con1) {
            echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    text: 'Edit Success',
                    icon: 'success',
                    timer: 10000,
                    showConfirmButton: false
                });
            })
            </script>";
            echo "<meta http-equiv='refresh' content='2;url=index'>";
        } else {
            echo "<script>
            $(document).ready(function() {
                Swal.fire({
                    text: 'Something Went Wrong',
                    icon: 'error',
                    timer: 10000,
                    showConfirmButton: false
                });
            })
            </script>";
            echo "<meta http-equiv='refresh' content='2;url=index'>";
        }
    }
}

// if (isset($_POST['del-img'])) {
//     $img_id = $_POST['del-img'];
//     $delete_img = $conn->prepare("DELETE FROM content WHERE id = :id");
//     $delete_img->bindParam(":id", $img_id);
//     $delete_img->execute();

//     if ($delete_img) {
//         echo "<meta http-equiv='refresh' content='0;url=index?id=$id'>";
//     }



// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ENGLISH FLUENCY COMMUNICATION</title>

    <link rel="stylesheet" href="assets/css/main/app.css">
    <link rel="stylesheet" href="assets/css/main/app-dark.css">
    <link rel="stylesheet" href="css/index.css?v=<?php echo time(); ?>">
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
                <h3>Home</h3>
            </div>
            <section class="section">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Home</h4>
                    </div>
                    <div class="card-body">

                        <div class="box-intro py-4 ">
                            <div class="box-btn-content">
                                <button type="input" data-bs-toggle="modal" href="#content" class="btn btn-edit-content">Edit</button>
                            </div>
                            <div class="row align-items-center">

                                <div class="col-lg-6 d-flex justify-content-center align-item-center">
                                    <img class=" img-fluid mb-4" src="upload/upload_content/<?php echo $row_content['img']; ?>">
                                </div>
                                <div class="col-lg-6">
                                    <?php echo $row_content['content']; ?>
                                </div>
                                <div class="modal fade" id="content" data-bs-backdrop="static" aria-hidden="true">
                                    <div class="modal-dialog modal-lg  modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Content</h1>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post" enctype="multipart/form-data">
                                                    <span>Content</span>
                                                    <div class="content-text">
                                                        <textarea name="content"><?php echo $row_content['content'] ?></textarea>
                                                        <script>
                                                            tinymce.init({
                                                                selector: 'textarea',
                                                                height: "400",
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
                                                    <span>Photo</span>
                                                    <div class="content d-flex justify-content-center align-item-center">
                                                        <div class="title-img">
                                                            <span id="upload-img">รูปภาพ</span>
                                                            <div class="group-pos">
                                                                <input type="file" name="img" id="imgInput-cover" class="form-control">
                                                                <button type="button" class="btn reset" id="reset1">ยกเลิก</button>
                                                            </div>
                                                            <span class="file-support">รองรับเฉพาะไฟล์นามสกุล ('jpg', 'jpeg', 'png','webp').</span>
                                                            <div id="gallery-cover">
                                                                <div class='box-edit-img-cover'>
                                                                    <span class='del-edit-img'></span>
                                                                    <img class='edit-img-cover' id='previewImg-cover' src='upload/upload_content/<?php echo $row_content['img'] ?>'>
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
</body>

</html>