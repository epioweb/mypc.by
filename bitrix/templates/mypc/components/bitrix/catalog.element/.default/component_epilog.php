<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
$productType = "";
if(!empty($arResult["PROPERTIES"]["PRODUCT_TYPE"]["VALUE"]) && strlen($arResult["PROPERTIES"]["PRODUCT_TYPE"]["VALUE"]) < 50)
{
	$productType = $arResult["PROPERTIES"]["PRODUCT_TYPE"]["VALUE"];
}

$title = $arResult["NAME"];
$shortname = $arResult["PROPERTIES"]["SHORT_NAME"]["VALUE"];
if(!empty($shortname))
{
	$title = $shortname;
	if(!empty($productType)) $title = $productType." ".$title;
}
$APPLICATION->SetPageProperty("ADDITIONAL_TITLE",$title);
?>