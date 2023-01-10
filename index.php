<?php
require_once('webpanelcw/config/engfluency_db.php');
error_reporting(0);


$content = $conn->prepare("SELECT * FROM content");
$content->execute();
$row_content = $content->fetch(PDO::FETCH_ASSOC);


$description = $conn->prepare("SELECT * FROM description");
$description->execute();
$row_description = $description->fetchAll();

$about = $conn->prepare("SELECT * FROM about");
$about->execute();
$row_about = $about->fetch(PDO::FETCH_ASSOC);

$service = $conn->prepare("SELECT * FROM service");
$service->execute();
$row_service = $service->fetch(PDO::FETCH_ASSOC);
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

    <?php  include("slide.php"); ?>





    <section id="intro-section">

      <div class="container">


        <div class="box-intro py-4 px-md-4">


          <div class="row align-items-center">
            <div class="col-lg-6">
              <img class=" img-fluid mb-4" src="webpanelcw/upload/upload_content/<?php echo $row_content['img'] ?>">
            </div>
            <div class="col-lg-6">
              <?php echo $row_content['content'] ?>

            </div>
          </div>


        </div>


      </div>

    </section>

    <section id="detail-section">
      <div class="container">



        <div class="text-center">
          <div class="mb-5">
            <h2><span>รายละเอียด</span>เบื้องต้น</h2>
          </div>
        </div>







        <?php /*$Text_detail = array(
          '1' => "ดูแลงาน Visa และ Work Permit",
          '2' => "ช่วยจัดหาที่พักอาศัยของครูชาวต่างชาติ",
          '3' => "มีครูสอนทดแทน (Substitute) ทำให้การ สอนต่อเนื่อง ไม่ขาดครู",
          '4' => "มีการติดตาม ประเมินผล",
          '5' => "ให้คำปรึกษา รับฟังคำติ – ชม เกี่ยวกับครูชาวต่างชาติ"
        );*/ ?>





        <div class="row detail_slick">

          <?php for ($i = 0; $i < count($row_description); $i++) { ?>
            <div class="col-lg-4">

              <div class="item-detail">
                <div class="img-detail">

                  <img class="img-fluid img-detail-img" src="webpanelcw/upload/upload_description/<?= $row_description[$i]['img'] ?>">



                  <div class="icon-detail">
                    <img class="img-fluid" data-lazy="upload/icon-detail0<?= $i+1 ?>.png">
                  </div>


                </div>

                <div class="text-detail">
                  <h4><?= $row_description[$i]['title'] ?></h4>
                </div>
              </div>

            </div>
          <?php } ?>


        </div>







        <div class="text-center mt-5">
          <a href="tel:021024083" class="box-tel">
            <span class="material-icons-sharp text-danger">
              phone_in_talk
            </span> : <?php echo $row_about['tel']?>
          </a>
        </div>



      </div>

    </section>








    <section id="service-section" class="bg-parallax" style="background:url(images/service-section.jpg) no-repeat top center; background-size:cover;">
      <div class="container">
        <img class="img-fluid" src="webpanelcw/upload/upload_service/<?php echo $row_service['img'];?>">


        <div class="row">

          <div class="col-lg-6 p-lg-0">



            <div class="item-service">
              <div class="images-service">
                <img class="lazy img-fluid" data-src="upload/service01.jpg">
              </div>







              <div class="text-service">
                <?php echo $row_service['content1']?>


                <a href="" class="btn-service">
                  <span class="material-icons-sharp">
                    task_alt
                  </span>
                  กดเพื่อรับข้อเสนอที่ถูกใจ</a>
              </div>
            </div>
          </div>



          <div class="col-lg-6 p-lg-0">



            <div class="item-service">
              <div class="images-service">
                <img class="lazy img-fluid" data-src="upload/service02.jpg">
              </div>







              <div class="text-service">
              <?php echo $row_service['content2']?>


                <a href="tel:0998887777" class="btn-service">
                  <span class="material-icons-sharp">
                    call
                  </span>

                  โทรเลย <?php echo $row_about['tel']?></a>
              </div>
            </div>
          </div>



          <div class="col-lg-12 p-0 f-h">
            <img class="lazy img-fluid" data-src="images/footer-h.svg">
          </div>




        </div>





      </div>
    </section>




  </main>



  <?php include("footer.php"); ?>



</body>

</html>