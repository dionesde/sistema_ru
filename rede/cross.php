<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$url = "http://200.132.200.1/speed.php";
		
		$cURL = curl_init();
		curl_setopt($cURL, CURLOPT_URL, $url);
		curl_setopt($cURL, CURLOPT_AUTOREFERER, true);
		curl_setopt($cURL, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($cURL, CURLOPT_TIMEOUT, 20);
		curl_setopt($cURL, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($cURL, CURLOPT_HEADER, false);
		
	    	$saida=curl_exec($cURL);
		curl_close($cURL);
		

