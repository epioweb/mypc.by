<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
if(!$arResult["NavShowAlways"]) {
	if ($arResult["NavRecordCount"] == 0 || ($arResult["NavPageCount"] == 1 && $arResult["NavShowAll"] == false)) return;
}

$strNavQueryString = ($arResult["NavQueryString"] != "" ? $arResult["NavQueryString"]."&amp;" : "");
$strNavQueryStringFull = ($arResult["NavQueryString"] != "" ? "?".$arResult["NavQueryString"] : "");
?>

<!-- Постраничная навигация -->
<ul class="paginator">
<?
$pg = $arResult["nStartPage"];
if($arResult["NavPageNomer"] > 1)
{
	?><li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageNomer"]-1?>">пред.</a></li><?
}


if($arResult["NavPageNomer"] > 3 && $arResult["nStartPage"] != 1)
{
	?><li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=1">1</a></li><?
	if($arResult["NavPageNomer"] > 4)
	{
		?><li>...</li><?
	}
	
}

while($pg <= $arResult["nEndPage"])
{
	if ($pg == $arResult["NavPageNomer"])
	{
		?><li><span><?=$pg?></span></li><?
	}
	else
	{
		?><li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$pg?>"><?=$pg?></a></li><?
	}
	$pg++;
}

if($arResult["NavPageNomer"] < $arResult["NavPageCount"]-2 && $arResult["NavPageCount"] != $arResult["nEndPage"])
{
	if($arResult["NavPageNomer"] < $arResult["NavPageCount"]-3)
	{
		?><li>...</li><?
	}
	?><li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageCount"]?>"><?=$arResult["NavPageCount"]?></a></li><?
	
}

if($arResult["NavPageNomer"] < $arResult["NavPageCount"])
{
	?><li><a href="<?=$arResult["sUrlPath"]?>?<?=$strNavQueryString?>PAGEN_<?=$arResult["NavNum"]?>=<?=$arResult["NavPageNomer"]+1?>">след.</a></li><?
}
?>
</ul>










