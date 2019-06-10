<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class CurlCallController extends Controller
{

	public static function curl($url, $header = '')
	{
		$curl = curl_init();
		curl_setopt_array($curl, array(
		    CURLOPT_URL => $url,
		    CURLOPT_SSL_VERIFYPEER => false,
		    CURLOPT_RETURNTRANSFER => true,
		    CURLOPT_ENCODING => "",
		    CURLOPT_TIMEOUT => 30000,
		    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		    CURLOPT_CUSTOMREQUEST => "GET",
		    CURLOPT_HTTPHEADER => array(
		        'Content-Type: application/json',
		        $header
		    ),
		));
		$response = curl_exec($curl);
		$err = curl_error($curl);
		curl_close($curl);

		if ($err) {
		   	return "cURL Error #:" . $err;
		} else {
		   	return $response;
		}
	}

}