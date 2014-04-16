<?
$arResult["CATALOG_URL"] = $arParams["CATALOG_SEF_FOLDER"].(CYetiProcessor::getCatalogURL($arParams["IBLOCK_ID"], $arParams["MENU_IBLOCK_ID"]));

foreach($arResult["ITEMS"] as $k=>$arElement)
{
	$arElement["NAME"] = InsertSpaces($arElement["NAME"],24,"&shy;");
	$arElement["DETAIL_PAGE_URL"] =  CYetiProcessor::getCatalogDetailURL($arElement["ID"],$arParams["MENU_IBLOCK_ID"], $arParams["CATALOG_SEF_FOLDER"]);
	
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
		$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 190, "height" => 150),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arFilter);
		$arElement["PHOTO"] = $arFileTmp["src"];
	}
	else 
	{
		$arElement["PHOTO"] = SITE_TEMPLATE_PATH."/images/emptyphoto190.png";
	}
	
	$arElement["DELETE_URL"] = $GLOBALS["APPLICATION"]->GetCurPageParam("ID[]=".$arElement["ID"]."&IBLOCK_ID=".$arElement["IBLOCK_ID"]."&action=DELETE_FROM_COMPARE_RESULT",array("ID","IBLOCK_ID","action"));
	$arResult["ITEMS"][$k] = $arElement;
}


foreach($arResult["SHOW_PROPERTIES"] as $code=>$arProperty)
{
	$propEmpty = true;
	foreach($arResult["ITEMS"] as $k=>$arElement)
	{
		$arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["VALUE"];
		if(!empty($arPropertyValue))
		{
			$propEmpty = false;
			break;
		}
	}
	if($propEmpty) unset($arResult["SHOW_PROPERTIES"][$code]);
}


?>