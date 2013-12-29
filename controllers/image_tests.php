<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Image tests Controller
 *
 * Misc image helper tests
 * 
 */
class Image_tests_Controller extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		echo '<h1>Image Tests</h1>';
		
		$params = array(
			'file' => MODPATH.'image/tests/media/bungieftw-2.jpg',
			'width' => 750,
			'height' => 750
		);
		echo Kohana::debug('bungieftw-2.jpg',$params,image::src('bungieftw-2.jpg',$params));
		echo image::tag('bungieftw-2.jpg',$params);
		
		$params = array(
			'file' => MODPATH.'image/tests/media/Sniper Canyon Redux.jpeg',
			'height' => 200,
			'width' => 200,
			'type' => 'resize'
		);
		echo Kohana::debug('Test.jpg',$params,image::src('Test.jpg',$params));
		echo image::tag('Test.jpg',$params);
		
		$params = array(
			'file' => MODPATH.'image/tests/media/test_1.jpg',
			'height' => 500,
			'width' => 500,
			'type' => 'resize'
		);
		echo Kohana::debug('Blah hah.jpg',$params,image::src('Blah hah.jpg',$params));
		echo image::tag('Blah hah.jpg',$params);
		
		$params = array(
			'file' => MODPATH.'image/tests/media/does_not_exist.jpg',
			'height' => 500,
			'width' => 500,
			'type' => 'resize'
		);
		echo Kohana::debug('h4x.jpg',$params,image::src('h4x.jpg',$params));
		echo image::tag('h4x.jpg',$params);
	}
	
	public function canvas(){
		$view = new View('canvas');
		
		$view->render(true);
	}

	public function __call($function, $segments)
	{
		
	}

}