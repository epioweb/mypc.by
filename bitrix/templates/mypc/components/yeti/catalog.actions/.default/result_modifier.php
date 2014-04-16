<?
foreach($arResult["ITEMS"] as $k=>$arItem)
{
	$fid = intval($arItem["PREVIEW_PICTURE"]);
	if($fid == 0) $fid = intval($arItem["DETAIL_PICTURE"]);
	if($fid == 0 && is_array($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) && count($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"]) > 0)
	{
		$fid = array_pop($arItem["PROPERTIES"]["MORE_PHOTO"]["VALUE"]);
		$fid = intval($fid);
	}
	
	if($fid > 0)
	{
		$arFilter = array("name" => "sharpen", "precision" => 30);
		$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 190, "height" => 190),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arFilter);
		$arResult["ITEMS"][$k]["PHOTO"] = $arFileTmp["src"];
	}
}
/*
foreach($arResult["ITEMS"] as $keyItem => $arItem):
   $this->SetViewTarget("price_".$keyItem);?>
<strong>
<?
      if($GLOBALS['_SESSION']['CATALOG_CURRENCY'] =='USD') :
         echo formatToBYR($arItem['PRICE']['PRICE']['PRICE']);
      else:
         echo convertPriceToUSD($arItem['PRICE']['PRICE']['PRICE']);
      endif;
?>
</strong>
<?
   $this->EndViewTarget();
endforeach;
*/
?>