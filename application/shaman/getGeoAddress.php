<?
	$address = Request::get('address', Request::REQUEST | Request::XSS_CLEAR);

    $url = 'http://apis.daum.net/local/geo/addr2coord?apikey='.MAPAPINUM.'&q='.urlencode($address).'&output=json';
    $handle = curl_init();
	curl_setopt($handle, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
	curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($handle, CURLOPT_URL, $url);
	curl_setopt ($handle, CURLOPT_RETURNTRANSFER, 1);

    $response = curl_exec($handle);
    $responseDecoded = json_decode($response);
	echo $responseDecoded->{'channel'}->{'item'}[0]->{'point_y'}."|".$responseDecoded->{'channel'}->{'item'}[0]->{'point_x'};
?>