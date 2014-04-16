<?
foreach($arResult["ITEMS"] as $k=>$arItem)
{
	$picId = intval($arItem["PREVIEW_PICTURE"]["ID"]);
	if($picId == 0)
		$picId = intval($arItem["DETAIL_PICTURE"]["ID"]);
	
	if($picId > 0)
	{
		$img = CFile::ResizeImageGet($picId, array('width'=>190, 'height'=>300), BX_RESIZE_IMAGE_PROPORTIONAL, true);
		$arResult["ITEMS"][$k]["RESIZED_IMG"] = $img;
	}
		
}
?>