<?
$currency = ($_SESSION["CATALOG_CURRENCY"] == "USD")?"USD":"BYR";

foreach($arResult["ITEMS"]["AnDelCanBuy"] as $k => $arBasketItems)
{
	$priceCurrency = $arBasketItems["CURRENCY"];
	
	$price1Val = floatval($arBasketItems["PRICE"]);
	if($priceCurrency != $currency) $price1Val = CCurrencyRates::ConvertCurrency($price1Val, $priceCurrency, $currency);
	$arBasketItems["PRICE_FORMATED"] = CurrencyFormat($price1Val,$currency);
	$arBasketItems["PRICE_FORMATED"] = str_replace("&nbsp;"," ",$arBasketItems["PRICE_FORMATED"]);
	$arBasketItems["PRICE_FORMATED"] = preg_replace("#[0-9\s]+#i",'<strong>$0</strong>',$arBasketItems["PRICE_FORMATED"]);
	
	$priceVal = floatval($arBasketItems["PRICE"]) * floatval($arBasketItems["QUANTITY"]);
	if($priceCurrency != $currency) $priceVal = CCurrencyRates::ConvertCurrency($priceVal, $priceCurrency, $currency);
	$arBasketItems["PRICE_ALL_F"] = CurrencyFormat($priceVal,$currency);
	$arBasketItems["PRICE_ALL_F"] = str_replace("&nbsp;"," ",$arBasketItems["PRICE_ALL_F"]);
	$arBasketItems["PRICE_ALL_F"] = preg_replace("#[0-9\s]+#i",'<strong>$0</strong>',$arBasketItems["PRICE_ALL_F"]);
	
	if($productObj = CIBlockElement::GetByID($arBasketItems["PRODUCT_ID"])->getnextelement())
	{
		$arElement = $productObj->GetFields();
		$arElement["PROPERTIES"] = $productObj->GetProperties();
		if(is_array($arElement["PROPERTIES"]["ARTNUMBER"]))
		{
			$arBasketItems["ARTNUMBER"] = $arElement["PROPERTIES"]["ARTNUMBER"]["VALUE"];
		}
		
		
		$fid = intval($arElement["PREVIEW_PICTURE"]);
		if($fid == 0) $fid = intval($arElement["DETAIL_PICTURE"]);
		if($fid == 0)
		{
			$photos = $arElement["PROPERTIES"]["MORE_PHOTO"]["VALUE"];
			if(is_array($photos) && count($photos) > 0)
			{
				$fid = array_shift($photos);
				$fid = intval($fid);
			}
		}
		
		if($fid > 0)
		{
			$arFilter = array("name" => "sharpen", "precision" => 30);
			$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 120, "height" => 120),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arFilter);
			$arBasketItems["PHOTO"] = $arFileTmp["src"];
		}
		else 
		{
			$arBasketItems["PHOTO"] = SITE_TEMPLATE_PATH."/images/emptyphoto190.png";
		}
		
		$arBasketItems["DETAIL_PAGE_URL"] = CYetiProcessor::getCatalogDetailURL($arElement["ID"],98, "/catalog/");
		
	}
	
	
	//PR($arBasketItems);
	$arResult["ITEMS"]["AnDelCanBuy"][$k] = $arBasketItems;
}

$baseCurrency = CCurrency::GetBaseCurrency();
$allSum = floatval($arResult["allSum"]);
if($baseCurrency != $currency) $allSum = CCurrencyRates::ConvertCurrency($allSum, $baseCurrency, $currency);
$arResult["allSum_FORMATED"] = CurrencyFormat($allSum,$currency);
?>