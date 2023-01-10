<?php
require_once('webpanelcw/config/engfluency_db.php');
error_reporting(0);


$slide_img = $conn->prepare("SELECT * FROM slide_img");
$slide_img->execute();
$row_slide_img = $slide_img->fetchAll();


$slide_text = $conn->prepare("SELECT * FROM slide_text");
$slide_text->execute();
$row_slide_text = $slide_text->fetch(PDO::FETCH_ASSOC);

$about = $conn->prepare("SELECT * FROM about");
$about->execute();
$row_about = $about->fetch(PDO::FETCH_ASSOC);
?>

<div id="bootstrap-touch-slider" class="carousel bs-slider fade control-round indicators-line" data-ride="carousel" data-pause="false" data-interval="5000">
	<div class="carousel-indicators">
		<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
		<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
		<button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
	</div>
	<div class="carousel-inner" role="listbox">
		<div class="item  active ">
			<img src="webpanelcw/upload/upload_slide/<?php echo $row_slide_img[0]['img']; ?>" alt="บริษัท อิงลิช ฟลูเอนซี่ คอมมูนิเคชั่น จำกัด Slide" class="slide-image object-fit_cover" />
			<div class="slide-text">
				<div class="container">
					<div class="boxtext " data-animation="animated fadeInLeft">
						<?php echo $row_slide_text['slide_text']; ?>

					</div>
					<br>
					<a href="" class="btn btn-danger btn-lg px-5" data-animation="animated fadeInLeft">

						<span class="material-icons-sharp">
							wifi_calling_3
						</span>

						: <?php echo $row_about['tel']?>
					</a>
				</div>
			</div>
		</div>
		<div class="item ">
			<img src="webpanelcw/upload/upload_slide/<?php echo $row_slide_img[1]['img']; ?>" alt="บริษัท อิงลิช ฟลูเอนซี่ คอมมูนิเคชั่น จำกัด Slide" class="slide-image object-fit_cover" />
			<div class="slide-text">
				<div class="container">
					<div class="boxtext " data-animation="animated fadeInLeft">
						<?php echo $row_slide_text['slide_text']; ?>
					</div>
					<br>
					<a href="" class="btn btn-danger btn-lg px-5" data-animation="animated fadeInLeft">

						<span class="material-icons-sharp">
							wifi_calling_3
						</span>

						: <?php echo $row_about['tel']?>
					</a>
				</div>
			</div>
		</div>
		<div class="item ">
			<img src="webpanelcw/upload/upload_slide/<?php echo $row_slide_img[2]['img']; ?>" alt="บริษัท อิงลิช ฟลูเอนซี่ คอมมูนิเคชั่น จำกัด Slide" class="slide-image object-fit_cover" />
			<div class="slide-text">
				<div class="container">
					<div class="boxtext " data-animation="animated fadeInLeft">
						<?php echo $row_slide_text['slide_text']; ?>
					</div>
					<br>
					<a href="" class="btn btn-danger btn-lg px-5" data-animation="animated fadeInLeft">
						<span class="material-icons-sharp">
							wifi_calling_3
						</span>


						: <?php echo $row_about['tel']?>
					</a>
				</div>
			</div>
		</div>
	</div>
</div>