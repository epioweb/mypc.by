<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$GLOBALS["APPLICATION"]->SetDirProperty("HIDE_MAINPAGETITLE","Y");// прячем основной заголовок страницы
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
$basePrice = CCatalogGroup::GetBaseGroup();
$catGroupID = $basePrice["ID"];

$menuSections = $arResult["MENU_SECTION_CHAIN"];
$curSection = array_pop($menuSections);
?>
<!-- Две колонки -->
<div class="two-cols clearfix">
	<!-- Центральная колонка -->
	<div class="main-col">
		<?
		$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", Array("START_FROM" => "0","PATH" => "","SITE_ID" => "-"),false);
		
		
		$show_mode = $APPLICATION->get_cookie("CATALOG_SHOW_MODE");
		$show_mode = ($show_mode == "grid")?"grid":"list";
		?>
		<div class="category-header">
			<h1><?$APPLICATION->ShowTitle(false)?></h1>
			<ul class="display-type">
				<li><a href="#" title="Список" class="<?=$show_mode=="list"?"active":""?> list-type">Список</a></li>
				<li><a href="#" title="Сетка" class="<?=$show_mode=="grid"?"active":""?> grid-type">Сетка</a></li>
			</ul>
		</div>
		<?
		$SECTION_ID = false;
		$sectionProperties = array();
		
		if(is_array($arResult["CURRENT_SECTION"]))
		{
			$SECTION_ID = $arResult["CURRENT_SECTION"]["ID"];
			if(is_array($curSection))
			{
				if(is_array($curSection["UF_LIST_PROP_CODES"]))
				{
					$sectionProperties = array_slice($curSection["UF_LIST_PROP_CODES"],0,4);// первые 4 основные свойства
				}
			}
		}
		else
		{
			if(is_array($curSection))
			{
				$SECTION_ID = $curSection["ID"];
				if(is_array($curSection["UF_LIST_PROP_CODES"]))
				{
					$sectionProperties = array_slice($curSection["UF_LIST_PROP_CODES"],0,4);// первые 4 основные свойства
				}
			}
		}
		?>

		<?$APPLICATION->IncludeComponent("yeti:catalog.actions", "section_saleleaders", array(
	"IBLOCK_TYPE" => "content_mypc",
	"IBLOCK_ID" => $arParams["IBLOCK_ID"],
	"SECTION_ID" => $SECTION_ID,
	"ACTION_PROPERTY_CODE" => "SALELEADER",
	"MAX_CNT" => "10",
	"SEF_FOLDER" => "/catalog/",
	"CATALOG_GROUP_ID" => $catGroupID
	),
	false
);?>
		
		<!-- Выбор сортировки -->
		<?
		$arSortTypes = array(
			"price" => array("NAME"=>"По цене","FIELD"=>"CATALOG_PRICE_".$catGroupID,"ORDER"=>"ASC"),
			"name" => array("NAME"=>"По названию","FIELD"=>"NAME","ORDER"=>"ASC"),
			"popular" => array("NAME"=>"По популярности","FIELD"=>"PROPERTY_rating","ORDER"=>"DESC"),
		);
		
		if(empty($_SESSION["CATALOG_SORT_TYPE"])) $_SESSION["CATALOG_SORT_TYPE"] = "price";
		if(empty($_SESSION["CATALOG_SORT_ORDER"])) $_SESSION["CATALOG_SORT_ORDER"] = $arSortTypes["price"]["ORDER"];
		$currentSortType = &$_SESSION["CATALOG_SORT_TYPE"];
		$currentSortOrder = &$_SESSION["CATALOG_SORT_ORDER"];
		
		if(!empty($_REQUEST["sort"]))
		{
			$sort = trim($_REQUEST["sort"]);
			list($currentSortType,$currentSortOrder) = explode("-",$sort);
		}
		
		
		
		if(empty($currentSortType)) $currentSortType = "price";
		if(empty($currentSortOrder)) $currentSortOrder = "asc";
		
		if(!isset($arSortTypes[$currentSortType]))
		{
			$currentSortType = "price";
			$currentSortOrder = $arSortTypes["price"]["ORDER"];
		}
		?>
		<!-- Выбор сортировки -->
		<div class="sorting-types-wrap">
			<h4>Сортировка:</h4>
			<ul class="sorting-types">
				<?
				foreach($arSortTypes as $sCode=>$sInfo)
				{
					$selected = ($sCode == $currentSortType)?"class=\"active\"":"";
					$sortOrder = ToLower($sInfo["ORDER"]);
					if(!empty($selected))
					{
						$sortOrder = (ToLower($currentSortOrder) == "asc")?"desc":"asc";
					}
					$url = $GLOBALS["APPLICATION"]->GetCurPageParam("sort=".$sCode."-".$sortOrder,array("sort"));
					?>
					<li><a href="<?=$url?>" <?=$selected?> ><?=$sInfo["NAME"]?></a></li>
					<?
				}
				?>
			</ul>
		</div>
		<?
		$sortField = $arSortTypes[$currentSortType]["FIELD"];
		$sortFieldOrder = $currentSortOrder;
		
		ob_start();
		$currency = ($_SESSION["CATALOG_CURRENCY"] == "USD")?"USD":"BYR";
		?>
		<div class="b-filter-params-wrapper">
		<?$APPLICATION->IncludeComponent(
			"yeti:catalog.filter",
			"",
			Array(
				"MENU_IBLOCK_ID" => $arParams["IBLOCK_ID"],
				"MENU_SECTION_ID" => $curSection["ID"],
				"CATALOG_SECTION_ID" => $arResult["CURRENT_SECTION"]["ID"],
				"CATALOG_GROUP_ID" => $catGroupID,
				"PRICE_CURRENCY" => $currency,
				"FILTER_NAME" => "sectionFilter",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000000",
				"CACHE_NOTES" => "",
				"CACHE_GROUPS" => "Y",
			),
			false
		);?>
		</div>
		<?
		$filterHtml = ob_get_clean();
		
		$cacheFilter = "Y";// если просто листают каталог, то кешируем
		if(is_array($GLOBALS["sectionFilter"]) && count($GLOBALS["sectionFilter"]) > 0)
		{
			$cacheFilter = "N";// пользовательские настройки фильтра не кешируем
		}
		
		if(!is_array($GLOBALS["sectionFilter"]))
			$GLOBALS["sectionFilter"] = array();
			
		$GLOBALS["sectionFilter"][">CATALOG_PRICE_".$catGroupID] = 0;
		?>
		<div class="b-ajax-section-wrapper" style="position:relative;">
			<?
			if($_REQUEST["AJAX_SECTION_CALL"] == "Y")
			{
				$GLOBALS['APPLICATION']->RestartBuffer();
			}
			?>
			<div class="loading-wrapper" style="display:none;position:absolute;top:0;left:0;width:100%;height:100%;z-index: 100;">
				<div class="loading-field" style="opacity:0.5;position:absolute;top:0;left:0;width:100%;height:100%;z-index:120;"></div>
			</div>
			<?$APPLICATION->IncludeComponent("bitrix:catalog.section", ".default", array(
	"IBLOCK_TYPE" => "catalog",
	"IBLOCK_ID" => $arResult["CATALOG_IBLOCK"]["ID"],
	"SECTION_ID" => $arResult["CURRENT_SECTION"]["ID"],
	"SECTION_CODE" => $arResult["CURRENT_SECTION"]["CODE"],
	"SECTION_USER_FIELDS" => array(
		0 => "",
		1 => "",
	),
	"ELEMENT_SORT_FIELD" => $sortField,
	"ELEMENT_SORT_ORDER" => $sortFieldOrder,
	"ELEMENT_SORT_FIELD2" => "id",
	"ELEMENT_SORT_ORDER2" => "desc",
	"FILTER_NAME" => "sectionFilter",
	"INCLUDE_SUBSECTIONS" => "Y",
	"SHOW_ALL_WO_SECTION" => "Y",
	"HIDE_NOT_AVAILABLE" => "N",
	"PAGE_ELEMENT_COUNT" => "12",
	"LINE_ELEMENT_COUNT" => "3",
	"PROPERTY_CODE" => array(
		0 => "",
		1 => "NEWPRODUCT",
		2 => "SALELEADER",
		3 => "SPECIALOFFER",
		4 => "",
	),
	"OFFERS_LIMIT" => "5",
	"SECTION_URL" => "",
	"DETAIL_URL" => "",
	"BASKET_URL" => "/personal/cart/",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"PRODUCT_QUANTITY_VARIABLE" => "quantity",
	"PRODUCT_PROPS_VARIABLE" => "prop",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "360000",
	"CACHE_GROUPS" => "Y",
	"SET_META_KEYWORDS" => "Y",
	"META_KEYWORDS" => "UF_KEYWORDS",
	"SET_META_DESCRIPTION" => "Y",
	"META_DESCRIPTION" => "UF_META_DESCRIPTION",
	"BROWSER_TITLE" => "-",
	"ADD_SECTIONS_CHAIN" => "N",
	"DISPLAY_COMPARE" => "N",
	"SET_TITLE" => "N",
	"SET_STATUS_404" => "Y",
	"CACHE_FILTER" => "N",
	"PRICE_CODE" => array(
		0 => "BASE",
	),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"PRODUCT_PROPERTIES" => array(
	),
	"USE_PRODUCT_QUANTITY" => "N",
	"CONVERT_CURRENCY" => "N",
	"PAGER_TEMPLATE" => "",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "Y",
	"PAGER_TITLE" => "Товары",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "360000",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);
			?>
			<?
			$currentSection = end($arResult["MENU_SECTION_CHAIN"]);
			if(!empty($currentSection["DESCRIPTION"]))
			{
				?>
				<!-- О категории  ------->
				<div class="about-category">
					<h3 class="about-category-header"><?=$currentSection["NAME"]?></h3>
					<p><?=$currentSection["DESCRIPTION"]?></p>
				</div>
				<?
			}
			
			
			if($_REQUEST["AJAX_SECTION_CALL"] == "Y")
			{
				require $_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php";
				exit;
			}
			?>
		</div>
	</div>
	<!-- Левая колонка -->
	<div class="side-col">
		
		<?=$filterHtml?>
		
		<div class="b-compare-list-wr">
		<?$APPLICATION->IncludeComponent("bitrix:catalog.compare.list", "template1", Array(
	"AJAX_MODE" => "Y",	// Включить режим AJAX
	"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
	"MENU_IBLOCK_ID" => $arResult["IBLOCK_ID"],
	"IBLOCK_TYPE" => $arResult["CATALOG_IBLOCK"]["IBLOCK_TYPE_ID"],	// Тип инфоблока
	"IBLOCK_ID" => $arResult["CATALOG_IBLOCK"]["ID"],	// Инфоблок
	"NAME" => "",	// Уникальное имя для списка сравнения
	"DETAIL_URL" => "",	// URL, ведущий на страницу с содержимым элемента раздела
	"COMPARE_URL" => "/catalog/compare/",	// URL страницы с таблицей сравнения
	"CATALOG_SEF_FOLDER" => $arResult["COMPONENT_SEF_FOLDER"]
	),
	false
);
		?>
		</div>
		<?
		$relatedSections = $curSection["UF_RELATED_SECTIONS"];
		if(is_array($relatedSections) && count($relatedSections) > 0)
		{
			$relSec = array();
			
			$obCache = new CPHPCache; 
			$life_time = 3600; 
			$cache_id = "RELATED_SECTIONS_".$curSection["ID"];
			if($obCache->InitCache($life_time, $cache_id, "/"))
			{
				$vars = $obCache->GetVars();
				$relSec = $vars["RELATED_SECTIONS"];
			}
			else
			{
				$rs = CIBlockSection::GetList(array(),array("ID"=>$relatedSections,"GLOBAL_ACTIVE"=>"Y","ACTIVE"=>"Y"));
				while($sec = $rs->fetch())
				{
					$chRs = CIBlockSection::GetNavChain($sec["IBLOCK_ID"],$sec["ID"]);
					$sectionUrl = $arResult["COMPONENT_SEF_FOLDER"];
					while($r = $chRs->fetch())
					{
						$sectionUrl .= $r["CODE"]."/";
					}
					$sec["URL"] = $sectionUrl;
					$relSec[$sec["ID"]] = $sec;
				}
			}

			if($obCache->StartDataCache())
			{
				$obCache->EndDataCache(array("RELATED_SECTIONS" => $relSec)); 
			}
			
			if(is_array($relSec) && count($relSec) > 0)
			{
				?>
				<!-- Смежные категории -->
	            <div class="sidebar-block-wrap">
	                <div class="similar-categories typical sidebar-white-block">
	                    <h2>Смежные категории</h2>
	                    <ul class="links-list">
	                        <?
							foreach($relSec as $sec)
							{
								?><li><a href="<?=$sec["URL"]?>"><?=$sec["NAME"]?></a></li><?
							}
							?>
	                    </ul>
	                </div>
	            </div>
				<?
			}
		}
		
		if(is_array($curSection["UF_POP_BRANDS"]) && count($curSection["UF_POP_BRANDS"]) > 0)
		{
			$GLOBALS["brandsFilter"] = array(
				"ID" => $curSection["UF_POP_BRANDS"],
			);
			?>
			<?$APPLICATION->IncludeComponent("bitrix:news.list", "section_popular_brands", array(
				"IBLOCK_TYPE" => "zed_content",
				"IBLOCK_ID" => "108",
				"NEWS_COUNT" => "100",
				"SORT_BY1" => "NAME",
				"SORT_ORDER1" => "ASC",
				"SORT_BY2" => "SORT",
				"SORT_ORDER2" => "ASC",
				"FILTER_NAME" => "brandsFilter",
				"FIELD_CODE" => array(),
				"PROPERTY_CODE" => array(),
				"CHECK_DATES" => "N",
				"DETAIL_URL" => "",
				"AJAX_MODE" => "N",
				"AJAX_OPTION_JUMP" => "N",
				"AJAX_OPTION_STYLE" => "N",
				"AJAX_OPTION_HISTORY" => "N",
				"CACHE_TYPE" => "A",
				"CACHE_TIME" => "36000",
				"CACHE_FILTER" => "Y",
				"CACHE_GROUPS" => "Y",
				"PREVIEW_TRUNCATE_LEN" => "",
				"ACTIVE_DATE_FORMAT" => "d.m.Y",
				"SET_TITLE" => "N",
				"SET_STATUS_404" => "N",
				"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
				"ADD_SECTIONS_CHAIN" => "N",
				"HIDE_LINK_WHEN_NO_DETAIL" => "N",
				"PARENT_SECTION" => "",
				"PARENT_SECTION_CODE" => "",
				"DISPLAY_TOP_PAGER" => "N",
				"DISPLAY_BOTTOM_PAGER" => "N",
				"PAGER_TITLE" => "Новости",
				"PAGER_SHOW_ALWAYS" => "N",
				"PAGER_TEMPLATE" => "",
				"PAGER_DESC_NUMBERING" => "N",
				"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
				"PAGER_SHOW_ALL" => "N",
				"DISPLAY_DATE" => "Y",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PICTURE" => "Y",
				"DISPLAY_PREVIEW_TEXT" => "Y",
				"AJAX_OPTION_ADDITIONAL" => ""
				),
				false,
				array("HIDE_ICONS"=>"Y")
			);?>
			<?
		}
		?>
	</div>
</div>

<?
if(is_array($arResult["CURRENT_SECTION"]))
{
	if(!empty($arResult["CURRENT_SECTION"]["UF_SEO_TITLE_ZED"]))
		$APPLICATION->SetPageProperty("title", $arResult["CURRENT_SECTION"]["UF_SEO_TITLE_ZED"]);
	if(!empty($arResult["CURRENT_SECTION"]["UF_SEO_DESC_ZED"]))
		$APPLICATION->SetPageProperty("description", $arResult["CURRENT_SECTION"]["UF_SEO_DESC_ZED"]);
	if(!empty($arResult["CURRENT_SECTION"]["UF_SEO_KW_ZED"]))
		$APPLICATION->SetPageProperty("keywords", $arResult["CURRENT_SECTION"]["UF_SEO_KW_ZED"]);
}
elseif(is_array($arResult["MENU_SECTION_CHAIN"]) && count($arResult["MENU_SECTION_CHAIN"]) > 0)
{
	$lastItem = end($arResult["MENU_SECTION_CHAIN"]);
	if(!empty($lastItem["UF_SEO_TITLE"]))
		$APPLICATION->SetPageProperty("title", $lastItem["UF_SEO_TITLE"]);
	if(!empty($lastItem["UF_SEO_DESC"]))
		$APPLICATION->SetPageProperty("description", $lastItem["UF_SEO_DESC"]);
	if(!empty($lastItem["UF_SEO_KEYWORDS"]))
		$APPLICATION->SetPageProperty("keywords", $lastItem["UF_SEO_KEYWORDS"]);

}
?>