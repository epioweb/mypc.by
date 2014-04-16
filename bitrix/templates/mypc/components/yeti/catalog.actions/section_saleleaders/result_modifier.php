<?
foreach($arResult["ITEMS"] as $k=>$arItem)
{
	$fid = intval($arItem["PREVIEW_PICTURE"]);
	if($fid == 0) $fid = intval($arItem["DETAIL_PICTURE"]);
	if($fid == 0 && is_array($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) && count($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) > 0)
	{
		$fid = array_shift($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"]);
		$fid = intval($fid);
	}
	
	if($fid > 0)
	{
		$arFilter = array("name" => "sharpen", "precision" => 30);
		$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 200, "height" => 180),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arFilter);
		$arResult["ITEMS"][$k]["PHOTO"] = $arFileTmp["src"];
	}
	else
	{// вставляем пустую картинку
		$arResult["ITEMS"][$k]["PHOTO"] = SITE_TEMPLATE_PATH."/images/emptyphoto190.png";
	}
}
?>