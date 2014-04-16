<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("keywords", "купить компьютер ноутбук в минске продажа ноутбуков компьютеры телевизоры LCD электронные книги мониторы ноутбуки компьютерный магазин мой компьютер");
$APPLICATION->SetPageProperty("description", "Высококвалифицированный персонал поможет Вам купить компьютер и компьютерную технику в нашем интернет-магазине. Магазин компьютеров и компьютерной техники «Мой компьютер» - всегда широкий выбор компьютеров и компьютерной техники, продажа по доступным ценам!");
$APPLICATION->SetTitle("Интернет-магазин компьютеров и компьютерной техники - «Мой компьютер» - продажа компьютеров в Минске");
CModule::IncludeModule("catalog");
$basePrice = CCatalogGroup::GetBaseGroup();
?>
<!-- Две колонки -->
<div class="home-two-cols clearfix">

	<!-- Центральная колонка ---------------------- -->
	<div class="home-main-col">
		<?$APPLICATION->IncludeComponent("yeti:catalog.actions", "", array(
				"IBLOCK_TYPE"=>"content_mypc",
				"IBLOCK_ID"=>98,
				"ACTION_PROPERTY_CODE"=>"SALELEADER",
				"CACHE_TYPE"=>"A",
				"CACHE_TIME"=>"3600",
				"CACHE_GROUPS"=>"Y",
				"SEF_FOLDER"=>"/catalog/",
				"MAX_CNT"=>6,
				"CATALOG_GROUP_ID"=>$basePrice["ID"],
				"BLOCK_TITLE" => "Акции и спецпредложения",
			),
			false
		);
		?>
		
		<?$APPLICATION->IncludeComponent("bitrix:news.list", "catalog_sections_mainpage", Array(
			"IBLOCK_TYPE" => "content_mypc",	// Тип информационного блока (используется только для проверки)
			"IBLOCK_ID" => "115",	// Код информационного блока
			"NEWS_COUNT" => "1000",	// Количество новостей на странице
			"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
			"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
			"SORT_BY2" => "ID",	// Поле для второй сортировки новостей
			"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
			"FILTER_NAME" => "",	// Фильтр
			"FIELD_CODE" => array(	// Поля
				0 => "",
				1 => "",
			),
			"PROPERTY_CODE" => array(	// Свойства
				0 => "URL",
				1 => "",
			),
			"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
			"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
			"AJAX_MODE" => "N",	// Включить режим AJAX
			"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
			"AJAX_OPTION_STYLE" => "Y",	// Включить подгрузку стилей
			"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
			"CACHE_TYPE" => "A",	// Тип кеширования
			"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
			"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
			"CACHE_GROUPS" => "Y",	// Учитывать права доступа
			"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
			"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
			"SET_TITLE" => "N",	// Устанавливать заголовок страницы
			"SET_STATUS_404" => "N",	// Устанавливать статус 404, если не найдены элемент или раздел
			"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
			"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
			"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
			"PARENT_SECTION" => "",	// ID раздела
			"PARENT_SECTION_CODE" => "",	// Код раздела
			"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
			"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
			"PAGER_TITLE" => "",	// Название категорий
			"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
			"PAGER_TEMPLATE" => "",	// Название шаблона
			"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
			"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
			"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
			"DISPLAY_DATE" => "N",	// Выводить дату элемента
			"DISPLAY_NAME" => "Y",	// Выводить название элемента
			"DISPLAY_PICTURE" => "Y",	// Выводить изображение для анонса
			"DISPLAY_PREVIEW_TEXT" => "Y",	// Выводить текст анонса
			"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
			),
			false
		);?>
	</div>

	<!-- Правая колонка ------------------------------------- -->
	<div class="home-right-col">
		<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/include/mainpage_sidebar_content.php"), false);?>
	</div>

</div>

<!-- Блок подписки -->
<div class="subscribe-wrap">
	<h2 class="blue-header">ПОДПИСКА НА НОВОСТИ “МОЙ КОМПЬЮТЕР”</h2>
	<div class="subscribe-block" id="subscribe-ajax-wrapper">
		<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/include/subscribe_form.php"), false,array("HIDE_ICONS"=>"Y"));?>
	</div>
	<div class="subscribe-social">
		<div>
			<div class="fb-like" data-href="https://mypc.by" data-width="100" data-height="The pixel height of the plugin" data-colorscheme="light" data-layout="button_count" data-action="like" data-show-faces="true" data-send="false"></div>
		</div>
		<div style="width: 150px;">
			<div id="vk_like"></div>
			<script type="text/javascript">VK.Widgets.Like("vk_like", {type: "button", height: 20,width:150});</script>
		</div>
		<div style="width: 110px;">
			<a href="https://twitter.com/share" class="twitter-share-button" data-via="Twit_Mypc" data-lang="ru">Твитнуть</a>
			<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
		</div>
	</div>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>