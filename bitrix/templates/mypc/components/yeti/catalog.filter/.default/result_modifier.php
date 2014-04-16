<?
$proFilters = array();
foreach($arResult["FILTER_ITEMS"] as $k=>$arItem)
{
	if($arItem["VIEW_TYPE"] == "select" || $arItem["VIEW_TYPE"] == "checkbox")
	{
		if(count($arItem["LIST_VALUES"]) == 0)
		{
			unset($arResult["FILTER_ITEMS"][$k]);
			continue;
		}
	}
	
	
	if($arItem["PRO_FILTER"] == "Y")
	{
		$proFilters[] = $arItem;
		unset($arResult["FILTER_ITEMS"][$k]);
	}
}

if(count($proFilters) > 0)
{
	
	foreach($proFilters as $k=>$arItem)
	{
		if($arItem["ACTIVE"] == "Y")
		{
			$arResult["FILTER_ITEMS"][] = $arItem;// дополнительные активные фильтры размещаем в конец списка
			unset($proFilters[$k]);
		}
	}
	
	$arResult["HIDED_CNT"] = count($proFilters);
	
	$arResult["FILTER_ITEMS"] = array_merge($arResult["FILTER_ITEMS"],$proFilters);// дополнительные фильтры размещаем в конец списка
}

?>