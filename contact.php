<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php
require_once('webpanelcw/config/engfluency_db.php');

error_reporting(0);


$secret = "6LdjF1wjAAAAAFEh7x0Eq89iFIHEU5hE3TT_cqLB";


if (isset($_POST['g-recaptcha-response'])) {

  $captcha = $_POST['g-recaptcha-response'];
  $veifyResponse = file_get_contents('https://google.com/recaptcha/api/siteverify?secret=' . $secret . '&response=' . $captcha);
  $responseData = json_decode($veifyResponse);

  if (!$captcha) {

    echo "<script>alert('คุณไม่ได้ป้อน reCAPTCHA อย่างถูกต้อง')</script>";
  }

  if (isset($_POST['submit']) && $responseData->success) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $message = $_POST['message'];

    if (empty($name)) {
      echo "<script>alert('Please Enter Name')</script>";
    } else if (empty($email)) {
      echo "<script>alert('Please Enter Email')</script>";
    } else if (empty($phone)) {
      echo "<script>alert('Please Enter Phone')</script>";
    } else if (empty($message)) {
      echo "<script>alert('Please Enter Message')</script>";
    } else {
      try {
        $send_message = $conn->prepare("INSERT INTO contact(username,email,tel,message) VALUES(:username,:email,:tel,:message)");
        $send_message->bindParam(":username", $name);
        $send_message->bindParam(":email", $email);
        $send_message->bindParam(":tel", $phone);
        $send_message->bindParam(":message", $message);
        $send_message->execute();

        if ($send_message) {
          echo "<script>
          $(document).ready(function() {
              Swal.fire({
                  text: 'Send Message Success',
                  icon: 'success',
                  timer: 10000,
                  showConfirmButton: false
              });
          })
          </script>";
          echo "<meta http-equiv='refresh' content='2;url=contact'>";
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
        }
      } catch (PDOException $e) {
        echo $e->getMessage();
      }
    }
  }
}




$about = $conn->prepare("SELECT * FROM about");
$about->execute();
$row_about = $about->fetch(PDO::FETCH_ASSOC);


?>
<!DOCTYPE html>
<html lang="en" class="desktop">

<head>

  <link rel="shortcut icon" href="images/favicon.ico">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=0.85">
  <meta name="description" content="บริการจัดหาครู ชาวต่างชาติเจ้าของภาษา Native English Speaker(NES)">
  <meta name="keyword" content="บริการจัดหาครู ชาวต่างชาติเจ้าของภาษา Native English Speaker(NES)">
  <meta name="author" content="บริการจัดหาครู ชาวต่างชาติเจ้าของภาษา Native English Speaker(NES)">

  <title>บริการจัดหาครู ชาวต่างชาติเจ้าของภาษา Native English Speaker(NES)</title>


  <link href="css/spinner.css" rel="stylesheet">
  <link href="css/bootstrap.min.css" rel="stylesheet">


  <script src="js/core.min.js"></script>
  <script src="js/script.min.js"></script>
  <script src="js/jquery.min.js"></script>

  <script type="text/javascript">
    'use strict';
    var $window = $(window);
    $window.on({
      'load': function() {

        /* Preloader */
        $('.spinner').fadeOut(2500);
      },

    });
  </script>


  <script src="js/lazyload.js"></script>

</head>



<body>
  <!-- Pre loader -->
  <div class="spinner" id="loading-body">
    <div>
      <div class="bounce1"></div>
      <div class="bounce2"></div>
      <div class="bounce3"></div>
    </div>
  </div>

  <?php include("header.php"); ?>

  <main>


    <section id="contact-section" class="bg-parallax" style="background:url(images/service-section.jpg) no-repeat top center; background-size:cover;">



      <div class="container">

        <img class="img-fluid" src="webpanelcw/upload/upload_contact/<?php echo $row_about['img'] ?>">

        <div class="box-contact pb-5 px-md-4">


          <div class="bg-navigator">
            <a href="index.php">หน้าแรก</a>
            <a href="contact.php">ติดต่อเรา</a>
          </div>


          <div class="text-center">
            <div class="mb-5">
              <h2><span>ติดต่อ</span>เรา</h2>
            </div>
            <h4 class="text-danger mb-5">ฝากข้อความไว้ให้เราติดต่อท่าน</h4>
          </div>




          <form id="form_message" action="contact.php" method="post">
            <input type="hidden" name="_token" value="CuWWbZneZurP9giDfyM1iIKn0uHmfoXbkD1dQnhM">
            <div class="row">

              <div class="col-lg-4">
                <div class="form-group mb-4">
                  <input type="text" class="form-control" id="text" name="name" placeholder="กรอกชื่อ-นามสกุล">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group mb-4">
                  <input type="email" class="form-control" id="text" name="email" placeholder="กรอกอีเมล">
                </div>
              </div>
              <div class="col-lg-4">
                <div class="form-group mb-4">
                  <input type="text" class="form-control" id="text" name="phone" placeholder="กรอกเบอร์โทร" onkeypress="validate(event)" maxlength="10">
                </div>
              </div>


              <div class="col-lg-12">
                <div class="form-group mb-4">
                  <textarea class="form-control" rows="5" id="comment" name="message" placeholder="กรอกข้อความเพิ่มเติม"></textarea>
                </div>
              </div>

            </div>


            <div class="text-center">
              <div class="col-12" style="text-align: -webkit-center;">
              <div class="g-recaptcha" data-sitekey="6LdjF1wjAAAAAC3jQDEtv0r-p6dNXXzuYnfEInve" style="display: flex;justify-content: center;"></div>
              </div>
              <div class="clearfix"></div>
              <a href="" class="btn btn-danger btn-lg mt-4 px-5">
                <span class="material-icons-sharp">
                  send
                </span>
                <button type="submit" name="submit" style="background: none; color: white; font-size: 22px; border: none;">ส่งข้อความ</button></a>
            </div>
          </form>



        </div>






        <div class="row">



          <div class="col-lg-12 p-0 f-h">
            <img class="lazy img-fluid" data-src="images/footer-h.svg">
          </div>




        </div>





      </div>
    </section>



  </main>



  <?php include("footer.php"); ?>


  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>

</html>