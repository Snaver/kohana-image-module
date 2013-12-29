<?php defined('SYSPATH') or die('No direct script access.'); ?>
<!DOCTYPE html>
<html class="no-js">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<meta name="description" content="">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="stylesheet" href="http://bxslider.com/lib/jquery.bxslider.css" type="text/css" />
		
		<!-- jQuery library (served from Google) -->
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script src="http://malsup.github.io/jquery.cycle2.js"></script>
		<script src="http://malsup.github.io/jquery.cycle2.carousel.js"></script>
		<script src="http://malsup.github.io/jquery.cycle2.tile.js"></script>
		
		<style>
			/* apply a natural box layout model to all elements */
			*, *:before, *:after {
				-moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box;
			}
					
			.container {
				width:900px;
				margin:0 auto;
			}
			
			#cycle-1 div { width:100%; }
			#cycle-2 .cycle-slide img { border:3px solid transparent; }
			#cycle-2 .cycle-slide-active img { border:3px solid Red; }
			
			#slideshow-1,#slideshow-2 { width: 100%; margin: auto; overflow:hidden; }
			#slideshow-2 { margin-top: 10px }
			.cycle-slideshow img { width: 100%; height: auto; display: block; }
		</style>
		<script>
			$(function(){
				var slideshows = $('.cycle-slideshow').on('cycle-next cycle-prev', function(e, opts) {
				    // advance the other slideshow
				    slideshows.not(this).cycle('goto', opts.currSlide);
				});
				
				$('#cycle-2 .cycle-slide').click(function(){
				    var index = $('#cycle-2').data('cycle.API').getSlideIndex(this);
				    slideshows.cycle('goto', index);
				});
			});
		</script>
	</head>
	<body>
		<h1 style="float:left;">Slider test</h1>
		<div class="container">
			<div id="slideshow-1">
			    <p>
			        <a href="#" class="cycle-prev">&laquo; prev</a> | <a href="#" class="cycle-next">next &raquo;</a>
			        <span class="custom-caption"></span>
			    </p>
			   	<div id="cycle-1" data-cycle-auto-height="container" data-cycle-fx="scrollHorz" class="cycle-slideshow" data-cycle-slides="> div" data-cycle-timeout="0" data-cycle-prev="#slideshow-1 .cycle-prev" data-cycle-next="#slideshow-1 .cycle-next" data-cycle-caption="#slideshow-1 .custom-caption" data-cycle-caption-template="Slide {{slideNum}} of {{slideCount}}" data-cycle-fx="tileBlind">
			        <div>
			        	<?=image::tag('square.png',array('file' => MODPATH.'image/tests/media/square.png','width' => 900));?>
			        </div>
			        <div>
			        	<?=image::tag('test_1.jpg',array('file' => MODPATH.'image/tests/media/test_1.jpg','width' => 900));?>
			        </div>
			        <div>
			        	<?=image::tag('bungieftw-2.jpg',array('file' => MODPATH.'image/tests/media/bungieftw-2.jpg','width' => 900));?>
			        </div>
			        <div>
			        	<?=image::tag('Master_Chief_Coagulation.jpg',array('file' => MODPATH.'image/tests/media/Master_Chief_Coagulation.jpg','width' => 900));?>
			        </div>
			        <div>
			        	<?=image::tag('Scout.jpg',array('file' => MODPATH.'image/tests/media/Scout.jpg','width' => 900));?>
			        </div>
			    </div>
			</div>
			
			<div id="slideshow-2">
			    <div id="cycle-2" data-cycle-auto-height="container" class="cycle-slideshow" data-cycle-slides="> div" data-cycle-timeout="0" data-cycle-prev="#slideshow-2 .cycle-prev" data-cycle-next="#slideshow-2 .cycle-next" data-cycle-caption="#slideshow-2 .custom-caption" data-cycle-caption-template="Slide {{slideNum}} of {{slideCount}}" data-cycle-fx="carousel" data-cycle-carousel-visible="5" data-cycle-carousel-fluid=true data-allow-wrap="false">
			        <div>
			        	<?=image::tag('square.png',array('file' => MODPATH.'image/tests/media/square.png','height' => 174,'width' => 174,));?>
			        </div>
			        <div>
			        	<?=image::tag('test_1.jpg',array('file' => MODPATH.'image/tests/media/test_1.jpg','height' => 174,'width' => 174));?>
			        </div>
			        <div>
			        	<?=image::tag('bungieftw-2.jpg',array('file' => MODPATH.'image/tests/media/bungieftw-2.jpg','height' => 174,'width' => 174));?>
			        </div>
			        <div>
			        	<?=image::tag('Master_Chief_Coagulation.jpg',array('file' => MODPATH.'image/tests/media/Master_Chief_Coagulation.jpg','height' => 174,'width' => 174));?>
			        </div>
			        <div>
			        	<?=image::tag('Scout.jpg',array('file' => MODPATH.'image/tests/media/Scout.jpg','height' => 174,'width' => 174));?>
			        </div>
			    </div>
			</div>
			<br />
			<br />
			<br />
			<br />
		</div>
	</body>
</html>