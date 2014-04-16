<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
//printAdmin($arParams);
foreach($arResult["ITEMS"] as $cell=>$arElement)
{
	$shortName = $arElement["PROPERTIES"]["SHORT_NAME"]["VALUE"];
	if(!empty($shortName))
	{
		$arResult["ITEMS"][$cell]["NAME"] = $shortName;
	}
	
	$productType = $arElement["PROPERTIES"]["PRODUCT_TYPE"]["VALUE"];
	if(!empty($productType) && strlen($productType) < 50)
	{
		$arResult["ITEMS"][$cell]["NAME"] = $productType." ".$arResult["ITEMS"][$cell]["NAME"];
	}
	
	$arResult["ITEMS"][$cell]["DETAIL_PAGE_URL"] = CYetiProcessor::getCatalogDetailURL($arElement["ID"],98, "/catalog/"/*$arParams["CATALOG_SEF_FOLDER"]*/);

	$fid = intval($arElement["PREVIEW_PICTURE"]["ID"]);
	if($fid == 0) $fid = intval($arElement["DETAIL_PICTURE"]["ID"]);
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
		$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 180, "height" => 180),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arFilter);
		$arResult["ITEMS"][$cell]["PHOTO"] = $arFileTmp["src"];
	}
	else 
	{// вставляем пустую картинку
		$arResult["ITEMS"][$cell]["PHOTO"] = SITE_TEMPLATE_PATH."/images/emptyphoto190.png";
	}
}


?>