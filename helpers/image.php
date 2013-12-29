<?php defined('SYSPATH') or die('No direct script access.');

// import the Intervention Image Class
use Intervention\Image\Image;

class image_Core {
	
	/**
	 * image::error_image()
	 * 
	 * Generates a Red 20x20 image and outputs it. Execution stops here.
	 * 
	 */
	public function error_image(){
		$image = new Image(null, 20, 20, '#ff0000');
		
		self::output($image);
	}
	
	/**
	 * Create a blank canvas with the given width/height with transparent background
	 * 
	 * 
	 */
	public function canvas($width,$height){
		return Image::canvas($width, $height);
	}
	
	public function make($file){
		return Image::make($file);
	}
	
	public function create($file){
		return new Image($file);
	}
	
	public function center_image(&$image,$canvas_width,$canvas_height){
		$canvas = image::canvas($canvas_width,$canvas_height);
								
		$canvas->insert($image,0,0,'center');
		
		$image = $canvas;
		
		// Set type PNG
		$image->type = 3;
		
		return $image;
	}
	
	public function resize(&$image,$width,$height,$ratio = true){
		return $image->resize($width, $height, $ratio);
	}
	
	public function grab(&$image,$width,$height){
		return $image->grab($width, $height);
	}
	
	/**
	 * image::output()
	 *
	 * Finished with image so send HTTP header and output image data
	 * 
	 * $image Object
	 */
	public function output(&$image){
		die($image->response());
	}
	
	/**
	 * image::tag()
	 *
	 * Generates complete image tag
	 * 
	 * $file_name	- Image name to be used in URL
	 * $parameters	- Image parameters
	 * $attributes	- Image tag attributes (Class etc)
	 */
	public function tag($file_name, $parameters, $attributes = array(),$debug = true){
		
		// Add image paramters to image tag for easy debugging
		if($debug){
			$attributes = array_merge($attributes,arr::add_prefix($parameters, 'data-'));
		}
		
		return html::image(
			self::src($file_name, $parameters),
			$attributes,
			false
		);
	}
	
	/**
	 * image::src()
	 *
	 * Returns correctly structured image URL, i.e:
	 * /images/file_name.jpg?q=hashed_params
	 * 
	 * $file_name	- Image name to be used in URL
	 * $parameters	- Image parameters
	 */
	public function src($file_name, $parameters){
		$query_string = http_build_query($parameters,'', '&amp;');
		
		if($query_string){
			$encrypted_parameters = self::encrypt_parameters($parameters);
			if($encrypted_parameters){
				return "image/$file_name?q=$encrypted_parameters";	
			}
		}
			
		return false;
	}
	
	/**
	 * image::encrypt_parameters()
	 *
	 * Serializes, encrypts and encodes parameters ready for use in URL request.
	 * http://blog.justin.kelly.org.au/simple-mcrypt-encrypt-decrypt-functions-for-p/
	 * 
	 * $parameters Array
	 */
	public function encrypt_parameters($parameters){
		$data = serialize($parameters);
		
		if($data){
			return urlencode(
				trim(
					base64_encode(
						mcrypt_encrypt(
							MCRYPT_RIJNDAEL_256,
							Kohana::config('image.crypt_pass'),
							$data,
							MCRYPT_MODE_ECB,
							mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)
						)
					)
				)
			);
		} else {
			return false;
		}
	}
	
	/**
	 * image::decrypt_parameters()
	 *
	 * Decrypt parameters. http://blog.justin.kelly.org.au/simple-mcrypt-encrypt-decrypt-functions-for-p/
	 * 
	 * $data
	 */
	public function decrypt_parameters($data){	
		$parameters = trim(
			mcrypt_decrypt(
				MCRYPT_RIJNDAEL_256,
				Kohana::config('image.crypt_pass'),
				base64_decode($data),
				MCRYPT_MODE_ECB,
				mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)
			)
		);
			
		if($parameters && !empty($parameters) && self::is_serialized($parameters)){
			return unserialize($parameters);
		} else {
			return false;
		}
	}
	
	/**
	* Borrowed from WP. Thanks.
	* 
	* Check value to find if it was serialized.
	*
	* If $data is not an string, then returned value will always be false.
	* Serialized data is always a string.
	*
	* @since 2.0.5
	*
	* @param mixed $data Value to check to see if was serialized.
	* @param bool $strict Optional. Whether to be strict about the end of the string. Defaults true.
	* @return bool False if not serialized and true if it was.
	*/
	private function is_serialized( $data, $strict = true ) {
		// if it isn't a string, it isn't serialized
		if ( ! is_string( $data ) )
			return false;
		$data = trim( $data );
	 	if ( 'N;' == $data )
			return true;
		$length = strlen( $data );
		if ( $length < 4 )
			return false;
		if ( ':' !== $data[1] )
			return false;
		if ( $strict ) {
			$lastc = $data[ $length - 1 ];
			if ( ';' !== $lastc && '}' !== $lastc )
				return false;
		} else {
			$semicolon = strpos( $data, ';' );
			$brace     = strpos( $data, '}' );
			// Either ; or } must exist.
			if ( false === $semicolon && false === $brace )
				return false;
			// But neither must be in the first X characters.
			if ( false !== $semicolon && $semicolon < 3 )
				return false;
			if ( false !== $brace && $brace < 4 )
				return false;
		}
		$token = $data[0];
		switch ( $token ) {
			case 's' :
				if ( $strict ) {
					if ( '"' !== $data[ $length - 2 ] )
						return false;
				} elseif ( false === strpos( $data, '"' ) ) {
					return false;
				}
				// or else fall through
			case 'a' :
			case 'O' :
				return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
			case 'b' :
			case 'i' :
			case 'd' :
				$end = $strict ? '$' : '';
				return (bool) preg_match( "/^{$token}:[0-9.E-]+;$end/", $data );
		}
		return false;
	}
}