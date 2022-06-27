<?php 
namespace App\Lib\Compress;
use CURLFile;
class Resmushit
{
	
	public function makesmash($url,$mime,$file_name,$qlty=70)
	{
		$output = new CURLFile($url, $mime, $file_name);
		$data = ["files" => $output];
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'http://api.resmush.it/?qlty='.$qlty);
		curl_setopt($ch, CURLOPT_POST,1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			$result = curl_error($ch);
		}
		curl_close ($ch);

		$arr_result = json_decode($result);
		if ($arr_result == null) {
			return false;
		}
		$imagedata['size_less']=$arr_result->src_size - $arr_result->dest_size;
		$imagedata['src']=$arr_result->dest;

		return $imagedata;
	}
	
}


 ?>