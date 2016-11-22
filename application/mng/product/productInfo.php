<?
	$product = new Product();

	$idx	= Request::get('idx', Request::REQUEST | Request::XSS_CLEAR);
	$mode	= Request::get('mode', Request::REQUEST | Request::XSS_CLEAR);
	$proName	= Request::get('proName', Request::REQUEST | Request::XSS_CLEAR);
	$proPrice	= Request::get('proPrice', Request::REQUEST | Request::XSS_CLEAR);

	if($mode == "insert"){
		$setBeen = array($proName, $proPrice, date("Y-m-d H:i:s"));
		$product->addProduct($setBeen);
	}else if($mode == "modify"){
		$whereBeen = array(":idx"=>$idx);
		$setBeen = array($proName, $proPrice);
		$product->updateProduct($setBeen, $whereBeen);
	}else if($mode == "delete"){
		$whereBeen = array(":idx" => $idx);
		$product->deleteProduct($whereBeen);
	}
?>