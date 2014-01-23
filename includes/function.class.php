<?php
class Base_function{

	function __construct()
	{
		
	}
	
	// REQUIRED FIELD **********************************	
	function validate_req($input_value)
	{
      	if(!isset($input_value) || strlen($input_value) <=0)
		{
			return false;		
		}	
	  	return true;	
	}
	
	
	function validate_email($email) 
	{
		return eregi("^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$", $email);
	}
	
	function validte_name($input_value)
	{
		$reg_exp = "[^A-Za-z]";
		if(ereg($reg_exp,$input_value))
		{
			return false;
		}
		return true;
	}
	
	
	// CLEAN INPUT VAR *********************************
	function sanitise_input($var=null)
	{
		$var = $this->xss_clean($var);
		if($var!=null)
		{
			// Usage across all PHP versions
			if (get_magic_quotes_gpc()) 
			{
				$var = stripslashes($var);
			}
			
			// If using MySQL
			//$var = mysql_real_escape_string($var);
			
			// Convert HTML charecter in ascii
			$result = htmlspecialchars($var);
		}else
		{
			$result = '';
		}
		return $result;		
	}
	
	
	
	// XSS CLEANE INPUT  **************************
	function xss_clean($data)
	{
		// Fix &entity\n;
		$data = str_replace(array('&amp;','&lt;','&gt;'), array('&amp;amp;','&amp;lt;','&amp;gt;'), $data);
		$data = preg_replace('/(&#*\w+)[\x00-\x20]+;/u', '$1;', $data);
		$data = preg_replace('/(&#x*[0-9A-F]+);*/iu', '$1;', $data);
		$data = html_entity_decode($data, ENT_COMPAT, 'UTF-8');

		// Remove any attribute starting with "on" or xmlns
		$data = preg_replace('#(<[^>]+?[\x00-\x20"\'])(?:on|xmlns)[^>]*+>#iu', '$1>', $data);

		// Remove javascript: and vbscript: protocols
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=[\x00-\x20]*([`\'"]*)[\x00-\x20]*j[\x00-\x20]*a[\x00-\x20]*v[\x00-\x20]*a[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2nojavascript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*v[\x00-\x20]*b[\x00-\x20]*s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:#iu', '$1=$2novbscript...', $data);
		$data = preg_replace('#([a-z]*)[\x00-\x20]*=([\'"]*)[\x00-\x20]*-moz-binding[\x00-\x20]*:#u', '$1=$2nomozbinding...', $data);

		// Only works in IE: <span style="width: expression(alert('Ping!'));"></span>
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?expression[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?behaviour[\x00-\x20]*\([^>]*+>#i', '$1>', $data);
		$data = preg_replace('#(<[^>]+?)style[\x00-\x20]*=[\x00-\x20]*[`\'"]*.*?s[\x00-\x20]*c[\x00-\x20]*r[\x00-\x20]*i[\x00-\x20]*p[\x00-\x20]*t[\x00-\x20]*:*[^>]*+>#iu', '$1>', $data);

		// Remove namespaced elements (we do not need them)
		$data = preg_replace('#</*\w+:\w[^>]*+>#i', '', $data);

		do
		{
			// Remove really unwanted tags
			$old_data = $data;
			$data = preg_replace('#</*(?:applet|b(?:ase|gsound|link)|embed|frame(?:set)?|i(?:frame|layer)|l(?:ayer|ink)|meta|object|s(?:cript|tyle)|title|xml)[^>]*+>#i', '', $data);
		}
		while ($old_data !== $data);

		// we are done...
		return $data; 
	}
	
	
	
	// DOWNLOAD AND SAVE IMAGE  **************************
	function save_image($url,$name,$path)
	{	
	
	
		// check url available using get_header method...
		$url_head 	= get_headers($url);
	
		if($url_head != FALSE)
		{
			// now check url image hav not 404 error to download...
			$head_chk = strpos ($url_head[0], '404 Not Found');
			
		
			
			if($head_chk === FALSE) 
			{	$image_data = file_get_contents($url);				
				if($image_data)
				{	
					file_put_contents($path."/".$name.'.jpg',  $image_data);
					
					
					$actual_image = $path."/".$name.'.jpg';
					$actual_image_name = $name.'.jpg';
					$ext = 'jpg';
					
					$paraSize = getimagesize($actual_image);
					$width  = $paraSize[0];
					$height = $paraSize[1];
					
					if($width>=300 && $height>=300)
					{
					
						$this->cropImage($actual_image,$path.'/thumbs/244X244/'.$actual_image_name,244,244,$ext);
						$this->cropImage($actual_image,$path.'/thumbs/492X244/'.$actual_image_name,492,244,$ext);
						$this->cropImage($actual_image,$path.'/thumbs/740X244/'.$actual_image_name,740,244,$ext);
						
						return $image_name = $name.'.jpg';
					}
					
					return 'failed';
				}
			}
			
		}
		
		return 'failed';
	}
	
	// CROP IMAGE *****************
	function cropImage($image,$filename,$thumb_width,$thumb_height,$extension)
	{
		
		if($extension=="jpg" || $extension=="jpeg" )
		{
			
			$image = imagecreatefromjpeg($image);
		}
		else if($extension=="png")
		{
			
			$image = imagecreatefrompng($image);
		}
		else
		{
			$image = imagecreatefromgif($image);
		}
		

		$width = imagesx($image);
		$height = imagesy($image);

		$original_aspect = $width / $height;
		$thumb_aspect = $thumb_width / $thumb_height;

		if ( $original_aspect >= $thumb_aspect )
		{
		   // If image is wider than thumbnail (in aspect ratio sense)
		   $new_height = $thumb_height;
		   $new_width = $width / ($height / $thumb_height);
		}
		else
		{
		   // If the thumbnail is wider than the image
		   $new_width = $thumb_width;
		   $new_height = $height / ($width / $thumb_width);
		}

		$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

		// Resize and crop
		imagecopyresampled($thumb,
						   $image,
						   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
						   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
						   0, 0,
						   $new_width, $new_height,
						   $width, $height);
		imagejpeg($thumb, $filename, 80);

	}
	
	
	// DOWNLOAD FILE *****************	
	function output_file($file, $name, $mime_type='')
	{

		echo $file;
		/*
		This function takes a path to a file to output ($file),  the filename that the browser will see ($name) and  the MIME type of the file ($mime_type, optional).
		*/

		//Check the file premission
		if(!is_readable($file)) die('File not found or inaccessible!');

		$size = filesize($file);
		$name = rawurldecode($name);

		/* Figure out the MIME type | Check in array */
		$known_mime_types=array(
			"pdf" => "application/pdf",
			"txt" => "text/plain",
			"html" => "text/html",
			"htm" => "text/html",
			"exe" => "application/octet-stream",
			"zip" => "application/zip",
			"doc" => "application/msword",
			"xls" => "application/vnd.ms-excel",
			"ppt" => "application/vnd.ms-powerpoint",
			"gif" => "image/gif",
			"png" => "image/png",
			"jpeg"=> "image/jpg",
			"jpg" =>  "image/jpg",
			"php" => "text/plain"
		);

		if($mime_type=='')
		{
			$file_extension = strtolower(substr(strrchr($file,"."),1));
			if(array_key_exists($file_extension, $known_mime_types))
			{
				$mime_type=$known_mime_types[$file_extension];
			} 
			else 
			{
				$mime_type="application/force-download";
			}
		}

		//turn off output buffering to decrease cpu usage
		@ob_end_clean(); 

		// required for IE, otherwise Content-Disposition may be ignored
		if(ini_get('zlib.output_compression'))
		ini_set('zlib.output_compression', 'Off');

		header('Content-Type: ' . $mime_type);
		header('Content-Disposition: attachment; filename="'.$name.'"');
		header("Content-Transfer-Encoding: binary");
		header('Accept-Ranges: bytes');

		/* The three lines below basically make the 
		download non-cacheable */
		header("Cache-control: private");
		header('Pragma: private');
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");

		// multipart-download and download resuming support
		if(isset($_SERVER['HTTP_RANGE']))
		{
			list($a, $range) = explode("=",$_SERVER['HTTP_RANGE'],2);
			list($range) = explode(",",$range,2);
			list($range, $range_end) = explode("-", $range);
			$range=intval($range);
			
			if(!$range_end) 
			{
				$range_end=$size-1;
			} 
			else 
			{
				$range_end=intval($range_end);
			}
		/*
		------------------------------------------------------------------------------------------------------
		//This application is developed by www.webinfopedia.com
		//visit www.webinfopedia.com for PHP,Mysql,html5 and Designing tutorials for FREE!!!
		------------------------------------------------------------------------------------------------------
		*/
		$new_length = $range_end-$range+1;
		header("HTTP/1.1 206 Partial Content");
		header("Content-Length: $new_length");
		header("Content-Range: bytes $range-$range_end/$size");
		} else {
		$new_length=$size;
		header("Content-Length: ".$size);
		}

		/* Will output the file itself */
		$chunksize = 1*(1024*1024); //you may want to change this
		$bytes_send = 0;
		if ($file = fopen($file, 'r'))
		{
		if(isset($_SERVER['HTTP_RANGE']))
		fseek($file, $range);

		while(!feof($file) && 
		(!connection_aborted()) && 
		($bytes_send<$new_length)
		)
		{
		$buffer = fread($file, $chunksize);
		print($buffer); //echo($buffer); // can also possible
		flush();
		$bytes_send += strlen($buffer);
		}
		fclose($file);
		} else
		//If no permissiion
		die('Error - can not open file.');
		//die
		die();
	}


}



?>