<?
$catSefFolder = $arParams["CATALOG_SEF_FOLDER"];
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
$basePrice = CCatalogGroup::GetBaseGroup();

foreach($arResult["SECTIONS"] as $k=>$sec)
{
	$filtr = array(
		"IBLOCK_ID"=>$sec["IBLOCK_ID"],
		">CATALOG_PRICE_".$basePrice["ID"] => 0,
		"SECTION_ID" => $sec["ID"],
		"INCLUDE_SUBSECTIONS" => "Y",
		"ACTIVE" => "Y",
		"SECTION_GLOBAL_ACTIVE" => "Y",
	);
	$cnt = CIBlockElement::GetList(false,$filtr,array());;
	if($cnt == 0)
	{
		unset($arResult["SECTIONS"][$k]);
		continue;
	}
	
	$arResult["SECTIONS"][$k]["SECTION_PAGE_URL"] = $catSefFolder.$sec["CODE"]."/";
	$fid = intval($sec["PICTURE"]["ID"]);
	if($fid > 0)
	{
		$arFilter = array("name" => "sharpen", "precision" => 30);
		$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 230, "height" => 200),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arFilter);
		$arResult["SECTIONS"][$k]["PHOTO"] = $arFileTmp["src"];
	}
}
?>