<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
//delayed function must return a string
if(empty($arResult)) return "";
$strReturn = '<!-- Хлебные крошки --> <ul class="breadcrumbs">';

foreach ($arResult as $k=>$v)
{
	if(empty($v["TITLE"])) unset($arResult[$k]);
}

for($index = 0, $itemSize = count($arResult); $index < $itemSize; $index++)
{
	$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
	if(!empty($title))
	{
		if($index < $itemSize - 1)
		{
			if($arResult[$index]["LINK"] <> "")
				$strReturn .= '<li><a href="'.$arResult[$index]["LINK"].'">'.$title.'</a> <span class="divider">»</span></li> ';
			else
				$strReturn .= '<li>'.$title.' <span class="divider">»</span></li> ';
		}
		else
		{
			$strReturn .= '<li><a href="'.$arResult[$index]["LINK"].'">'.$title.'</a></li> ';
		}
	}	
}
$strReturn .= '</ul>';
return $strReturn;
?>
