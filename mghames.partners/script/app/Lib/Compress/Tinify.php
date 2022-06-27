<?php 
namespace App\Lib\Compress;
use CURLFile;
class Tinify
{
	
	public function makesmash($url)
	{
		
		

		$filepath = $url;

		try {
			\Tinify\setKey(env('TINIFY_API_KEY'));
			$sourceData = file_get_contents($filepath);
			$resultData = \Tinify\fromBuffer($sourceData)->toBuffer();

			

		} catch(\Tinify\AccountException $e) {
         // Verify your API key and account limit.
			return false;
		} catch(\Tinify\ClientException $e) {
         // Check your source image and request options.
			return false;
		} catch(\Tinify\ServerException $e) {
         // Temporary issue with the Tinify API.
			return false;
		} catch(\Tinify\ConnectionException $e) {
        // A network connection error occurred.
			return false;
		} catch(Exception $e) {
         // Something else went wrong, unrelated to the Tinify API.
			return false;
		}

		
		
		$imagedata['src']=$resultData;

		return $imagedata;
	}
	
}


 ?>