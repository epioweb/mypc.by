<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$arResult["TAGS_CHAIN"] = array();
if($arResult["REQUEST"]["~TAGS"])
{
	$res = array_unique(explode(",", $arResult["REQUEST"]["~TAGS"]));
	$url = array();
	foreach ($res as $key => $tags)
	{
		$tags = trim($tags);
		if(!empty($tags))
		{
			$url_without = $res;
			unset($url_without[$key]);
			$url[$tags] = $tags;
			$result = array(
				"TAG_NAME" => htmlspecialcharsex($tags),
				"TAG_PATH" => $APPLICATION->GetCurPageParam("tags=".urlencode(implode(",", $url)), array("tags")),
				"TAG_WITHOUT" => $APPLICATION->GetCurPageParam((count($url_without) > 0 ? "tags=".urlencode(implode(",", $url_without)) : ""), array("tags")),
			);
			$arResult["TAGS_CHAIN"][] = $result;
		}
	}
}


foreach($arResult["SEARCH"] as $k=>$arItem)
{
	if($arItem["MODULE_ID"] == "iblock")
	{
		$ID = intval($arItem["ITEM_ID"]);
		$IBLOCK_TYPE = $arItem["PARAM1"];
		$IBLOCK_ID = $arItem["PARAM2"];

		if($IBLOCK_TYPE == "catalog_mypc" && $ID > 0)
		{
			$arItem["IS_PRODUCT"] = "Y"; 
			$arItem["URL"] = CYetiProcessor::getCatalogDetailURL($ID,98, "/catalog/");
			if($elementObj = CIBlockElement::GetByID($ID)->getnextelement())
			{
				$arElement = $elementObj->GetFields();
				$arElement["PROPERTIES"] = $elementObj->GetProperties();

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
					$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 90, "height" => 90),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arFilter);
					$arItem["PHOTO"] = $arFileTmp["src"];
				}
			}
		}

	}


	$arResult["SEARCH"][$k] = $arItem;
}

?>