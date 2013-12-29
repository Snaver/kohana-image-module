<?php defined('SYSPATH') OR die('No direct access allowed.');

/**
 * Image Controller
 *
 * Handles incoming image request URL
 * 
 */
class Image_Controller extends Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Main method
	 * 
	 * /images/file_name.jpg?q=hashed_params
	 * 
	 */
	public function index($file_name)
	{
		if($_GET && array_key_exists('q', $_GET)){
			try {
				$parameters = image::decrypt_parameters($_GET['q']);
				
				if($parameters){
					// Parse parameters
					$parameters = $this->parseParameters($parameters);
					
					// Check file param is there
					if($parameters['file']){
						
						// create a new image resource from file, will throw exception if any problems occur.
						$image = image::make($parameters['file']);
						
						// If image requirement is exact (Width and Height)
						if($parameters['width'] && $parameters['height']){
							
							// Source dimension size check
							if($image->width > $parameters['width'])
							{
								image::resize($image,$parameters['width'],$parameters['height']);
								
								// Check resulting image matches image requirement
								if($image->width != $parameters['width'] || $image->height != $parameters['height']){
									$image = image::center_image($image,$parameters['width'],$parameters['width']);
								}
							}
							elseif($image->height > $parameters['height'])
							{
								image::resize($image,$parameters['width'],$parameters['height']);
								
								// Check resulting image matches image requirement
								if($image->width != $parameters['width'] || $image->height != $parameters['height']){
									$image = image::center_image($image,$parameters['width'],$parameters['width']);
								}
							}
							elseif($image->width < $parameters['width'])
							{
								$image = image::center_image($image,$parameters['width'],$parameters['width']);
							}
							elseif($image->height < $parameters['height'])
							{
								$image = image::center_image($image,$parameters['width'],$parameters['width']);
							}
							
							//image::grab($image,$parameters['width'],$parameters['height']);
							
						}
						// If image requirement is just the width
						elseif($parameters['width'])
						{
							
							// Source dimension size check
							if($image->width < $parameters['width']){							
								$image = image::center_image($image,$parameters['width'],$image->height);
							} else {
								image::resize($image,$parameters['width'],null);
							}
							
						}
						// If image requirement is just the height
						elseif($parameters['height'])
						{
							
							// Source dimension size check
							if($image->height < $parameters['height']){							
								$image = image::center_image($image,$parameters['height'],$image->width);
							} else {
								image::resize($image,null,$parameters['height']);
							}
							
						}
												
						// If debug param is present and true, then output image details instead of image
						if($parameters['debug']){
							echo Kohana::debug($image,$parameters);exit;
						}
						
						// Finished, output image
						image::output($image);
						
					}
				}
				
				// If we get here, throw an error..
				image::error_image();
			} catch (Exception $e) {
				image::error_image();
			}
		}
	}
	
	/**
	 * Setup parameters
	 * 
	 */
	private function parseParameters($params){
		return array(
			'debug'		=> array_key_exists('debug', $params) && $params['debug'] != '' ? $params['debug'] : false,
			'file'		=> array_key_exists('file', $params) && $params['file'] != '' ? $params['file'] : null,
			'width'		=> array_key_exists('width', $params) && $params['width'] != '' ? $params['width'] : null,
			'height'	=> array_key_exists('height', $params) && $params['height'] != '' ? $params['height'] : null,
			'type'		=> array_key_exists('type', $params) && $params['type'] != '' ? $params['type'] : null,
		);
	}

	public function __call($function, $segments)
	{
		
	}

}