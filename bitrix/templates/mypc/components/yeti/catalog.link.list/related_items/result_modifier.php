<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
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
	
	$arResult["ITEMS"][$cell]["DETAIL_PAGE_URL"] = CYetiProcessor::getCatalogDetailURL($arElement["ID"],$arParams["MENU_IBLOCK_ID"], $arParams["CATALOG_SEF_FOLDER"]);
	
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
		$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 200, "height" => 150),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arFilter);
		$arResult["ITEMS"][$cell]["PHOTO"] = $arFileTmp["src"];
	}
}
?>