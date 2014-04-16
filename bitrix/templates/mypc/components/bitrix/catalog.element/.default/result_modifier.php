<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

$productType = $arResult["PROPERTIES"]["PRODUCT_TYPE"]["VALUE"];
if(!empty($productType) && strlen($productType) < 50)
{
	$arResult["NAME"] = $productType." ".$arResult["NAME"];
}


$arPhotoFilter = array("name" => "sharpen", "precision" => 30);

$photoResizer = function($arPhoto) {
	$fid = intval($arPhoto["ID"]);
	if($fid == 0)return false;
	$photo = array();
	$photo["ORIGINAL"] = $arPhoto["SRC"];
	$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 370, "height" => 370),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arPhotoFilter);
	$photo["BIG"] = $arFileTmp["src"];
	$sz = getimagesize($_SERVER["DOCUMENT_ROOT"].$arFileTmp["src"]);
	$photo["BIG_SZ"] = array("W"=>$sz[0],"H"=>$sz[1]);
	$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 79, "height" => 79),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arPhotoFilter);
	$photo["THUMB"] = $arFileTmp["src"];
	$sz = getimagesize($_SERVER["DOCUMENT_ROOT"].$arFileTmp["src"]);
	$photo["THUMB_SZ"] = array("W"=>$sz[0],"H"=>$sz[1]);
	return $photo;
};

$photos = array();
if(is_array($arResult["DETAIL_PICTURE"]))
{
	$photo = $photoResizer($arResult["DETAIL_PICTURE"]);
	if(is_array($photo)) $photos[] = $photo;
}
elseif(is_array($arResult["PREVIEW_PICTURE"]))
{
	$photo = $photoResizer($arResult["PREVIEW_PICTURE"]);
	if(is_array($photo)) $photos[] = $photo;
}

if(is_array($arResult["MORE_PHOTO"]) && count($arResult["MORE_PHOTO"]) > 0)
{
	$phIDs = array();
	foreach($arResult["MORE_PHOTO"] as $k => $ph)
	{
		if(in_array($ph["ID"], $phIDs)) unset($arResult["MORE_PHOTO"][$k]);
		else
		{
			$phIDs[] = $ph["ID"];
		}
	}
	
	foreach($arResult["MORE_PHOTO"] as $ph)
	{
		$photo = $photoResizer($ph);
		if(is_array($photo)) $photos[] = $photo;
	}
}

$arResult["PHOTOS"] = $photos;







?>