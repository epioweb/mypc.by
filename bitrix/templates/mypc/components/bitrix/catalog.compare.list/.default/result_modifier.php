<?
foreach($arResult as $k=>$arElement)
{
	$arElement["NAME"] = InsertSpaces($arElement["NAME"],24,"&shy;");
	$arElement["DETAIL_PAGE_URL"] =  CYetiProcessor::getCatalogDetailURL($arElement["ID"],$arParams["MENU_IBLOCK_ID"], $arParams["CATALOG_SEF_FOLDER"]);
	$arResult[$k] = $arElement;
}
?>