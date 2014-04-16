<?
if(is_array($arResult["SECTION_LIST"]))
{
	if(is_array($arResult["MENU_SECTION_CHAIN"]) &&	count($arResult["MENU_SECTION_CHAIN"]) == 0)
	{
		$APPLICATION->SetTitle("Все категории");
	}
	elseif(is_array($arResult["MENU_SECTION_CHAIN"]) &&	count($arResult["MENU_SECTION_CHAIN"]) > 0)
	{
		$sec = array_pop($arResult["MENU_SECTION_CHAIN"]);
		$APPLICATION->AddChainItem($sec["NAME"]);// чтобы ссылка на каталог была активной
	}
	?>
	<div class="white-wrap">
		<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/include/social_widgets.php"), false);?>
	</div>
	<?
}
?>