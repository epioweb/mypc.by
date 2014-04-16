<?
$CURPAGE = $APPLICATION->GetCurPage();
?><!DOCTYPE html>
<!--[if IE 8 ]><html class="ie8"><![endif]-->
<!--[if IE 9 ]><html class="ie9"><![endif]-->
<!--[if (gte IE 10)|!(IE)]><!--><html><!--<![endif]-->
<head>
    <meta name="viewport" content="width=1000, initial-scale=1, maximum-scale=1" />
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" /><!--игнорирует дополнение skype-тулбар в браузере-->
    <title><?$APPLICATION->ShowTitle()?></title>
    <?$APPLICATION->ShowHead()?>
    
    <?
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/style.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/prettyPhoto.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/page11-14.css");
    $APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery.fancybox.css");
    
    if(!preg_match("#\/personal\/cart\/#",$CURPAGE))
    {
    	$APPLICATION->SetAdditionalCSS(SITE_TEMPLATE_PATH."/css/jquery-ui-1.10.4.custom.min.css");
    }
    
    
    
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-1.8.3.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery-ui-1.10.4.custom.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.carouFredSel-6.2.1.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.placeholder.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.formstyler.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.dotdotdot-1.5.4.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.tools.min.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.prettyPhoto.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.raty.js");
    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/jquery.fancybox-1.3.4.pack.js");

    $APPLICATION->AddHeadScript(SITE_TEMPLATE_PATH."/js/scripts.js");
    ?>
    
    <script type="text/javascript" src="//vk.com/js/api/openapi.js?101"></script>
    <script type="text/javascript">VK.init({apiId: 3948352, onlyWidgets: true});</script>
    
</head>
<body>
<!-- facebook -->	
<div id="fb-root"></div>
<script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/ru_RU/all.js#xfbml=1&appId=";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
<!-- /facebook -->
	
<div id="wrapper">
	<?$APPLICATION->IncludeComponent(
	"bitrix:main.include",
	".default",
	Array(
		"AREA_FILE_SHOW" => "file",
		"PATH" => "/include/yandex_counter.php",
		"EDIT_TEMPLATE" => ""
	)
	);?>
	<?$APPLICATION->ShowPanel();?>
    <!-- Шапка -->
    <div id="header">
        <div id="header-cnt">
            <div id="inner-header">
                <div id="logo">
                	<?
                	if($CURPAGE != "/")
                	{
                		?>
                		<a href="/" title="Мой компьютер">Мой компьютер | Магазины компьютерной техники</a>
                		<?
                	}
                	?>
                </div>

                <!-- Верхняя панель -->
                <div id="top-panel">
                    <!-- Логин и регистрация -->
                    <?$APPLICATION->IncludeComponent(
                    	"bitrix:system.auth.form", 
                    	".default",
                    	array(
                    		"REGISTER_URL"           => "/auth/?register=yes",      // Страница регистрации
                    		"FORGOT_PASSWORD_URL"    => "/auth/?forgot_password=yes",      // Страница забытого пароля
                    		"PROFILE_URL"            => "/personal/profile/",      // Страница профиля
                    		"SHOW_ERRORS"            => "Y",     // Показывать ошибки
                    	)
                    );?>
                    
                    <?$APPLICATION->IncludeComponent(
                    	"bitrix:menu", 
                    	"top",
                    	array(
                    		"ROOT_MENU_TYPE"           => "top",     // Тип меню для первого уровня
                    		"MAX_LEVEL"                => "1",        // Уровень вложенности меню
                    		"CHILD_MENU_TYPE"          => "",     // Тип меню для остальных уровней
                    		"USE_EXT"                  => "N",        // Подключать файлы с именами вида .тип_меню.menu_ext.php
                    		"DELAY"                    => "N",        // Откладывать выполнение шаблона меню
                    		"ALLOW_MULTI_SELECT"       => "N",        // Разрешить несколько активных пунктов одновременно
                    		"MENU_CACHE_TYPE"          => "A",        // Тип кеширования
                    		"MENU_CACHE_TIME"          => "36000",     // Время кеширования (сек.)
                    		"MENU_CACHE_USE_GROUPS"    => "N",        // Учитывать права доступа
                    		"MENU_CACHE_GET_VARS"      => "",         // Значимые переменные запроса
                    	)
                    );
                    ?>
                    <!-- Форма поиска -->
                    <div class="search-box">
                        <form action="/search/">
                            <input type="text" name="q" class="search-input" placeholder="поиск на сайте">
                            <input type="submit" name="submit" class="search-submit" value="" >
                        </form>
                    </div>
                </div>

                <div id="header-right">

                    <!-- Телефони -->
                    <div id="header-phones">
                        <p><i class="icon icon-phone-bl"></i> <?=tplvar('header_phone_1', true);?></p>
                        <p><span><?=tplvar('header_phone_2', true);?></p>
                    </div>

                    <div class="callback">
                    	<?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/include/header_callback_order.php"), false);?>
                    </div>

                    <!-- График работы -->
                    <div class="schedule">
                        <p><i class="icon icon-schedule"></i>
                        	<?=tplvar('header_worktime', true);?>
                        </p>
                    </div>

                </div>

                <div id="header-left">

                    <!-- Выбор валюты и физ.лица -->
                    <div id="header-select">
                    	<?$APPLICATION->IncludeComponent("bitrix:main.include", ".default", array(
	"AREA_FILE_SHOW" => "file",
	"PATH" => "/include/currency_selector.php",
	"EDIT_TEMPLATE" => "standard.php"
	),
	false,
	array(
	"ACTIVE_COMPONENT" => "N"
	)
);?>
                        <!--  p class="person-type select-wrap small-height">
                            <select class="formstyler">
                                <option>Я - физ.лицо</option>
                                <option>Я - юр.лицо</option>
                            </select>
                        </p -->
                    </div>

                    <!-- Корзина -->
                    <div id="header-cart">
                    	<?$APPLICATION->IncludeComponent("bitrix:sale.basket.basket.small", ".default", array(
	"PATH_TO_BASKET" => "/personal/cart/",
	"PATH_TO_ORDER" => "/personal/order.php",
	"SHOW_DELAY" => "Y",
	"SHOW_NOTAVAIL" => "N",
	"SHOW_SUBSCRIBE" => "Y"
	),
	false
);?>
                    </div>

                    <!-- Консультант -->
                    <div id="online-support">
                        <a href="#" onclick="$('#jivo-label-text').click();return false;">консультант<br/> <span>онлайн</span></a>
                    </div>

                </div>



            </div>
        </div>
    </div>

    <!-- Навигация, Слайдер -->
    <div id="nav-wrap">
        <div id="nav-wrap-bg">
        	<?$APPLICATION->IncludeComponent(
        		"bitrix:menu", 
        		"catalog_menu",
        		array(
                	"ROOT_MENU_TYPE"           => "catalog_menu",     // Тип меню для первого уровня
        			"MAX_LEVEL"                => "2",        // Уровень вложенности меню
        			"CHILD_MENU_TYPE"          => "",     // Тип меню для остальных уровней
        			"USE_EXT"                  => "Y",        // Подключать файлы с именами вида .тип_меню.menu_ext.php
        			"DELAY"                    => "N",        // Откладывать выполнение шаблона меню
        			"ALLOW_MULTI_SELECT"       => "N",        // Разрешить несколько активных пунктов одновременно
        			"MENU_CACHE_TYPE"          => "A",        // Тип кеширования
        			"MENU_CACHE_TIME"          => "36000",     // Время кеширования (сек.)
        			"MENU_CACHE_USE_GROUPS"    => "N",        // Учитывать права доступа
        			"MENU_CACHE_GET_VARS"      => "",         // Значимые переменные запроса
				),
				false,
				array("HIDE_ICONS"=>"Y")
        	);
        	?>
        	<?
        	if($CURPAGE == "/")
        	{
        		?>
        		<?$APPLICATION->IncludeComponent(
	        		"bitrix:news.list", 
	        		"promo-slider",
	        		array(
	        			"AJAX_MODE"                          => "N",                      // Включить режим AJAX
	        			"IBLOCK_TYPE"                        => "content_mypc",                   // Тип информационного блока (используется только для проверки)
	        			"IBLOCK_ID"                          => "114",     // Код информационного блока
	        			"NEWS_COUNT"                         => "10",                     // Количество новостей на странице
	        			"SORT_BY1"                           => "SORT",            // Поле для первой сортировки новостей
	        			"SORT_ORDER1"                        => "DESC",                   // Направление для первой сортировки новостей
	        			"SORT_BY2"                           => "ACTIVE_FROM",                   // Поле для второй сортировки новостей
	        			"SORT_ORDER2"                        => "DESC",                    // Направление для второй сортировки новостей
	        			"FILTER_NAME"                        => "",                       // Фильтр
	        			"FIELD_CODE"                         => "",                       // Поля
	        			"PROPERTY_CODE"                      => array("URL"),                       // Свойства
	        			"CHECK_DATES"                        => "Y",                      // Показывать только активные на данный момент элементы
	        			"DETAIL_URL"                         => "",                       // URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
	        			"PREVIEW_TRUNCATE_LEN"               => "",                       // Максимальная длина анонса для вывода (только для типа текст)
	        			"ACTIVE_DATE_FORMAT"                 => "d.m.Y",                  // Формат показа даты
	        			"SET_TITLE"                          => "N",                      // Устанавливать заголовок страницы
	        			"SET_STATUS_404"                     => "N",                      // Устанавливать статус 404, если не найдены элемент или раздел
	        			"INCLUDE_IBLOCK_INTO_CHAIN"          => "N",                      // Включать инфоблок в цепочку навигации
	        			"ADD_SECTIONS_CHAIN"                 => "N",                      // Включать раздел в цепочку навигации
	        			"HIDE_LINK_WHEN_NO_DETAIL"           => "N",                      // Скрывать ссылку, если нет детального описания
	        			"PARENT_SECTION"                     => "",                       // ID раздела
	        			"PARENT_SECTION_CODE"                => "",                       // Код раздела
	        			"CACHE_TYPE"                         => "A",                      // Тип кеширования
	        			"CACHE_TIME"                         => "36000",               // Время кеширования (сек.)
	        			"CACHE_NOTES"                        => "", 
	        			"CACHE_FILTER"                       => "N",                      // Кешировать при установленном фильтре
	        			"CACHE_GROUPS"                       => "N",                      // Учитывать права доступа
	        			"DISPLAY_TOP_PAGER"                  => "N",                      // Выводить над списком
	        			"DISPLAY_BOTTOM_PAGER"               => "N",                      // Выводить под списком
	        			"PAGER_TITLE"                        => "",                // Название категорий
	        			"PAGER_SHOW_ALWAYS"                  => "N",                      // Выводить всегда
	        			"PAGER_TEMPLATE"                     => "",                       // Название шаблона
	        			"PAGER_DESC_NUMBERING"               => "N",                      // Использовать обратную навигацию
	        			"PAGER_DESC_NUMBERING_CACHE_TIME"    => "36000",                  // Время кеширования страниц для обратной навигации
	        			"PAGER_SHOW_ALL"                     => "N",                      // Показывать ссылку 'Все'
	        			"AJAX_OPTION_JUMP"                   => "N",                      // Включить прокрутку к началу компонента
	        			"AJAX_OPTION_STYLE"                  => "Y",                      // Включить подгрузку стилей
	        			"AJAX_OPTION_HISTORY"                => "N",                      // Включить эмуляцию навигации браузера
	        			"AJAX_OPTION_ADDITIONAL"             => "",                       // Дополнительный идентификатор
	        		),
					false,
					array("HIDE_ICONS"=>"N")
	        	);
	        	?>
        		<?
        	}
        	?>
        </div>
    </div>

    <!-- Контент -->
    <div id="content">
        <div id="inner-content">
        	<?
			$TWO_COLUMN = $APPLICATION->GetDirProperty("TWO_COLUMN");
			$TITLE_TOP = $APPLICATION->GetDirProperty("TITLE_TOP");
			$ARTICLE_PAGE = $APPLICATION->GetDirProperty("ARTICLE_PAGE");
			$NOT_SHOW_BREADCRUMB = $APPLICATION->GetDirProperty("NOT_SHOW_BREADCRUMB");
			
			if($TWO_COLUMN != "Y" && $ARTICLE_PAGE == "Y")
			{
				?><div class='article'><?
			}
			
			if($CURPAGE != "/")
			{
				if($NOT_SHOW_BREADCRUMB != "Y")
				{
					?>
					<?$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", Array("START_FROM" => "0","PATH" => "","SITE_ID" => "-"),false);?>
					<?
				}
				
				if($TWO_COLUMN !="Y" || $TITLE_TOP == "Y")
				{
					$APPLICATION->ShowViewContent("MAIN_TITLE");// будет задано в footer.php после установки всех свойств страницы/раздела
				}
			}
			
			if($TWO_COLUMN == "Y")
			{
				?>
				<!-- Две колонки -->
				<div class="two-cols clearfix">
					<!-- Центральная колонка -->
					<div class="main-col">
						<div class="article">
							<?
							if($TITLE_TOP != "Y")
							{
								$APPLICATION->ShowViewContent("MAIN_TITLE");// будет задано в footer.php после установки всех свойств страницы/раздела
							}
			}
			?>
        