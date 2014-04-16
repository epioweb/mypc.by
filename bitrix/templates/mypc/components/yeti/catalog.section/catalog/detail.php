<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$GLOBALS["APPLICATION"]->SetDirProperty("HIDE_MAINPAGETITLE","Y");// прячем основной заголовок страницы

$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", Array("START_FROM" => "0","PATH" => "","SITE_ID" => "-"),false);


?>
<div class="product-header">
	<h1><?$APPLICATION->ShowTitle(false)?></h1>
	<?
	$artNumber = $arResult["PRODUCT"]["PROPERTY_ARTNUMBER_VALUE"];
	if(!empty($artNumber))
	{
		?><span class="part-number">Артикул: <?=$artNumber?></span><?
	}
	?>
</div>
<?
$mainProperties = false;
$menuSections = $arResult["MENU_SECTION_CHAIN"];
$curSection = array_pop($menuSections);
if(is_array($curSection))
{
	if(is_array($curSection["UF_LIST_PROP_CODES"]))
	{
		$mainProperties = $curSection["UF_LIST_PROP_CODES"];
	}
}

ob_start();
$ElementID = $APPLICATION->IncludeComponent(
	"bitrix:catalog.element",
	"",
	Array(
		"MAIN_PROPERTIES" => $mainProperties,
		"ADD_SECTIONS_CHAIN"=>"N",
		"IBLOCK_TYPE" => $arResult["CATALOG_IBLOCK"]["IBLOCK_TYPE_ID"],
		"IBLOCK_ID" => $arResult["CATALOG_IBLOCK"]["ID"],
		"PROPERTY_CODE" => $arResult["DETAIL_PROP_CODES"],
		"META_KEYWORDS" => "SEO_KEYWORDS",
		"META_DESCRIPTION" => "SEO_DESCRIPTION",
		"BROWSER_TITLE" => "SEO_TITLE",
		"BASKET_URL" => "/personal/cart/",
		"ACTION_VARIABLE" => "action",
		"PRODUCT_ID_VARIABLE" => "id",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"CACHE_TYPE" => "A",
		"CACHE_TIME" => "86400",
		"CACHE_GROUPS" => "Y",
		"SET_TITLE" => "N",
		"SET_STATUS_404" => "Y",
		"PRICE_CODE" => array("BASE"),
		"USE_PRICE_COUNT" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"PRICE_VAT_INCLUDE" => "Y",
		"PRICE_VAT_SHOW_VALUE" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"LINK_IBLOCK_TYPE" => "",
		"LINK_IBLOCK_ID" => "",
		"LINK_PROPERTY_SID" => "",
		"LINK_ELEMENTS_URL" => "",

		"OFFERS_CART_PROPERTIES" => array(),
		"OFFERS_FIELD_CODE" => array("NAME"),
		"OFFERS_PROPERTY_CODE" => array("COLOR","WIDTH"),
		"OFFERS_SORT_FIELD" => "sort",
		"OFFERS_SORT_ORDER" => "asc",

		"ELEMENT_ID" => $arResult["PRODUCT"]["ID"],
		"ELEMENT_CODE" => "",
		"SECTION_ID" => $arResult["CURRENT_SECTION"]["ID"],
		"SECTION_CODE" => $arResult["CURRENT_SECTION"]["CODE"],
		"SECTION_URL" => "",
		"DETAIL_URL" => "",
		'CONVERT_CURRENCY' => "N",
		'CURRENCY_ID' => "",
		'USE_ELEMENT_COUNTER' => "Y",
		"USE_COMPARE" => "N",
		"COMPARE_URL" => "",
		"COMPARE_NAME" => "",
		"DISPLAY_DETAIL_IMG_WIDTH" => "280",
		"DISPLAY_DETAIL_IMG_HEIGHT" => "280",
		"DISPLAY_MORE_PHOTO_WIDTH" => "580",
		"DISPLAY_MORE_PHOTO_HEIGHT" => "580",
		"DISPLAY_IMG_WIDTH" => "180",
		"DISPLAY_IMG_HEIGHT" => "225",
		"SHARPEN" => "30",
		//forum reviews
		"USE_REVIEW" => "Y",
		"USE_CAPTCHA" => "Y",
		"FORUM_ID" => 1,
		"AJAX_POST" => "Y",
		"SHOW_RATING" => "Y",
		"SHOW_MINIMIZED" => "Y",

	),
	false
);
$content = ob_get_clean();

ob_start();
$GLOBALS["APPLICATION"]->IncludeComponent("bitrix:iblock.vote","stars",Array(
	"IBLOCK_TYPE" => $arResult["CATALOG_IBLOCK"]["IBLOCK_TYPE_ID"],
	"IBLOCK_ID" => $arResult["CATALOG_IBLOCK"]["ID"],
	"ELEMENT_ID" => $ElementID,
	"MAX_VOTE" => "5",
	"VOTE_NAMES" => array("1","2","3","4","5"),
	"SET_STATUS_404" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "3600"
),
	false,
	array("HIDE_ICONS"=>"Y")
);
$htmlRating = ob_get_clean();
$content = str_replace("<!--DETAIL_RATING_".$ElementID."-->",$htmlRating,$content);
///////////////////////////////////////
ob_start();
$APPLICATION->IncludeComponent("bitrix:main.include", "", array(
	"AREA_FILE_SHOW" => "file",
	"PATH" => "/include/detail_middle_block.php"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);
$html = ob_get_clean();
$content = str_replace("<!--DETAIL_MIDDLE_BLOCK-->",$html,$content);
ob_start();
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$GLOBALS["reviewFilter"] = array("IBLOCK_CODE"=>"product_reviews_mypc","ACTIVE"=>"Y","=PROPERTY_PRODUCT"=>$ElementID);
?>
<?$APPLICATION->IncludeComponent("bitrix:news.list", "product_review_list", array(
	"IBLOCK_TYPE" => "content_mypc",
	"IBLOCK_ID" => "117",
	"NEWS_COUNT" => "100",
	"SORT_BY1" => "ACTIVE_FROM",
	"SORT_ORDER1" => "DESC",
	"SORT_BY2" => "SORT",
	"SORT_ORDER2" => "ASC",
	"FILTER_NAME" => "reviewFilter",
	"FIELD_CODE" => array(),
	"PROPERTY_CODE" => array("PRODUCT"),
	"CHECK_DATES" => "Y",
	"DETAIL_URL" => "",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "36000",
	"CACHE_FILTER" => "N",
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
	"PAGER_TITLE" => "",
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
	false
);?>

<div class="b-product-review-wr" style="width:540px">
<?$APPLICATION->IncludeComponent("bitrix:iblock.element.add.form", "product_review", Array(
	"PRODUCT_ID" => $ElementID,
	"IBLOCK_TYPE" => "content_mypc",	// Тип инфоблока
	"IBLOCK_ID" => "117",	// Инфоблок
	"STATUS_NEW" => "ANY",	// Деактивировать элемент
	"LIST_URL" => "",	// Страница со списком своих элементов
	"USE_CAPTCHA" => "Y",	// Использовать CAPTCHA
	"USER_MESSAGE_EDIT" => "Спасибо! Ваш отзыв принят и скоро отобразится после проверки модератором.",	// Сообщение об успешном сохранении
	"USER_MESSAGE_ADD" => "Спасибо! Ваш отзыв принят и скоро отобразится после проверки модератором.",	// Сообщение об успешном добавлении
	"DEFAULT_INPUT_SIZE" => "30",	// Размер полей ввода
	"RESIZE_IMAGES" => "N",	// Использовать настройки инфоблока для обработки изображений
	"PROPERTY_CODES" => array(	// Свойства, выводимые на редактирование
		"8983",
		"PREVIEW_TEXT",
		"NAME",
		"8986",
		"8987",
	),
	"PROPERTY_CODES_REQUIRED" => array(	// Свойства, обязательные для заполнения
		"NAME",
		"PREVIEW_TEXT",
		"8987",
	),
	"GROUPS" => array("2"),
	"STATUS" => "INACTIVE",	// Редактирование возможно
	"ELEMENT_ASSOC" => "CREATED_BY",	// Привязка к пользователю
	"MAX_USER_ENTRIES" => "100000",	// Ограничить кол-во элементов для одного пользователя
	"MAX_LEVELS" => "100000",	// Ограничить кол-во рубрик, в которые можно добавлять элемент
	"LEVEL_LAST" => "Y",	// Разрешить добавление только на последний уровень рубрикатора
	"MAX_FILE_SIZE" => "0",	// Максимальный размер загружаемых файлов, байт (0 - не ограничивать)
	"PREVIEW_TEXT_USE_HTML_EDITOR" => "N",	// Использовать визуальный редактор для редактирования текста анонса
	"DETAIL_TEXT_USE_HTML_EDITOR" => "N",	// Использовать визуальный редактор для редактирования подробного текста
	"SEF_MODE" => "N",	// Включить поддержку ЧПУ
	"SEF_FOLDER" => "/catalog/",	// Каталог ЧПУ (относительно корня сайта)
	"CUSTOM_TITLE_NAME" => "Ваше имя",	// * наименование *
	"CUSTOM_TITLE_TAGS" => "",	// * теги *
	"CUSTOM_TITLE_DATE_ACTIVE_FROM" => "",	// * дата начала *
	"CUSTOM_TITLE_DATE_ACTIVE_TO" => "",	// * дата завершения *
	"CUSTOM_TITLE_IBLOCK_SECTION" => "",	// * раздел инфоблока *
	"CUSTOM_TITLE_PREVIEW_TEXT" => "Комментарий",	// * текст анонса *
	"CUSTOM_TITLE_PREVIEW_PICTURE" => "",	// * картинка анонса *
	"CUSTOM_TITLE_DETAIL_TEXT" => "",	// * подробный текст *
	"CUSTOM_TITLE_DETAIL_PICTURE" => "",	// * подробная картинка *
	),
	false,
	array("HIDE_ICONS"=>"Y")
);?>
</div>
<?
$html = ob_get_clean();
$content = str_replace("<!--DETAIL_REVIEWS-->",$html,$content);
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
ob_start();
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
$basePrice = CCatalogGroup::GetBaseGroup();
$GLOBALS["accessoriesFilter"][">CATALOG_PRICE_".$basePrice["ID"]] = 0;
?>
<?$APPLICATION->IncludeComponent("yeti:catalog.link.list", "accessories", array(
	"MENU_IBLOCK_ID" => $arResult["IBLOCK_ID"],
	"CATALOG_SEF_FOLDER" => $arResult["COMPONENT_SEF_FOLDER"],
	"IBLOCK_TYPE" => $arResult["CATALOG_IBLOCK"]["IBLOCK_TYPE_ID"],
	"IBLOCK_ID" => $arResult["CATALOG_IBLOCK"]["ID"],
	"LINK_PROPERTY_SID" => "ACCESSORIES",
	"ELEMENT_ID" => $ElementID,
	"ELEMENT_SORT_FIELD" => "rand",
	"ELEMENT_SORT_ORDER" => "rand",
	"FILTER_NAME" => "accessoriesFilter",
	"PAGE_ELEMENT_COUNT" => "3",
	"PROPERTY_CODE" => array(),
	"SECTION_URL" => "",
	"DETAIL_URL" => "",
	"BASKET_URL" => "/personal/cart/",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "300",
	"CACHE_GROUPS" => "Y",
	"SET_TITLE" => "N",
	"CACHE_FILTER" => "Y",
	"PRICE_CODE" => array(),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"CONVERT_CURRENCY" => "N",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"PAGER_TITLE" => "Товары",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>
<?
$html = ob_get_clean();
$content = str_replace("<!--DETAIL_ACCESSORIES-->",$html,$content);


//////////////////////////////////////
echo $content;
?>

<?
$GLOBALS["relatedItemsFilter"][">CATALOG_PRICE_".$basePrice["ID"]] = 0;
?>
<?$APPLICATION->IncludeComponent("yeti:catalog.link.list", "related_items", array(
	"MENU_IBLOCK_ID" => $arResult["IBLOCK_ID"],
	"CATALOG_SEF_FOLDER" => $arResult["COMPONENT_SEF_FOLDER"],
	"IBLOCK_TYPE" => $arResult["CATALOG_IBLOCK"]["IBLOCK_TYPE_ID"],
	"IBLOCK_ID" => $arResult["CATALOG_IBLOCK"]["ID"],
	"LINK_PROPERTY_SID" => "RELATED_ITEMS",
	"ELEMENT_ID" => $ElementID,
	"ELEMENT_SORT_FIELD" => "rand",
	"ELEMENT_SORT_ORDER" => "rand",
	"FILTER_NAME" => "relatedItemsFilter",
	"PAGE_ELEMENT_COUNT" => "10",
	"PROPERTY_CODE" => array(),
	"SECTION_URL" => "",
	"DETAIL_URL" => "",
	"BASKET_URL" => "/personal/cart/",
	"ACTION_VARIABLE" => "action",
	"PRODUCT_ID_VARIABLE" => "id",
	"SECTION_ID_VARIABLE" => "SECTION_ID",
	"AJAX_MODE" => "N",
	"AJAX_OPTION_JUMP" => "N",
	"AJAX_OPTION_STYLE" => "Y",
	"AJAX_OPTION_HISTORY" => "N",
	"CACHE_TYPE" => "A",
	"CACHE_TIME" => "300",
	"CACHE_GROUPS" => "Y",
	"SET_TITLE" => "N",
	"CACHE_FILTER" => "N",
	"PRICE_CODE" => array(),
	"USE_PRICE_COUNT" => "N",
	"SHOW_PRICE_COUNT" => "1",
	"PRICE_VAT_INCLUDE" => "Y",
	"CONVERT_CURRENCY" => "N",
	"DISPLAY_TOP_PAGER" => "N",
	"DISPLAY_BOTTOM_PAGER" => "N",
	"PAGER_TITLE" => "Товары",
	"PAGER_SHOW_ALWAYS" => "N",
	"PAGER_TEMPLATE" => "",
	"PAGER_DESC_NUMBERING" => "N",
	"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
	"PAGER_SHOW_ALL" => "N",
	"AJAX_OPTION_ADDITIONAL" => ""
	),
	false
);?>


