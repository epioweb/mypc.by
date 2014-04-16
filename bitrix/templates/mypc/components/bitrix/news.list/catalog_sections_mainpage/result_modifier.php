<?
foreach($arResult["ITEMS"] as $k=>$arItem)
{
	$picId = intval($arItem["PREVIEW_PICTURE"]["ID"]);
	if($picId == 0)
		$picId = intval($arItem["DETAIL_PICTURE"]["ID"]);
	
	if($picId > 0)
	{
		$arFilter = array("name" => "sharpen", "precision" => 30);
		$img = CFile::ResizeImageGet($picId, array('width'=>80, 'height'=>80), BX_RESIZE_IMAGE_PROPORTIONAL, true, $arFilter);
		$arResult["ITEMS"][$k]["RESIZED_IMG"] = $img;
	}
		
}
?>