			<?
			/// выставляем заголовок страницы
			$HIDE_MAINPAGETITLE = $APPLICATION->GetDirProperty("HIDE_MAINPAGETITLE");
			ob_start();
			?>
			<div class="product-header">
	            <h1><?=$APPLICATION->GetTitle(false)?></h1>
	        </div>
			<?
			$titleHtml = ob_get_clean();
			if($HIDE_MAINPAGETITLE == "Y") $titleHtml = "";
			
			$APPLICATION->AddViewContent('MAIN_TITLE', $titleHtml);
			///////////////////////////////////////////////////////////////////////////////////
			
			$TWO_COLUMN = $APPLICATION->GetDirProperty("TWO_COLUMN");
			if($TWO_COLUMN == "Y")
			{
				?>
						</div>
					</div>
					<!-- Левая колонка -->
					<div class="side-col">
						<!-- Навигация -->
						<div class="sidebar-block-wrap">
							<div class="sidebar-grey-block">
								<?
								$APPLICATION->ShowViewContent('SIDEBAR_NAV_HEADER_HTML'); // доп.заголовок для меню
								?>
								<?$APPLICATION->IncludeComponent('bitrix:menu', "sidebar_menu", array(
										"ROOT_MENU_TYPE" => "sidebar_menu",
										"MENU_CACHE_TYPE" => "Y",
										"MENU_CACHE_TIME" => "36000",
										"MENU_CACHE_USE_GROUPS" => "Y",
										"MENU_CACHE_GET_VARS" => array(),
										"MAX_LEVEL" => "1",
										"USE_EXT" => "Y",
										"CHILD_MENU_TYPE" => "", 
										"ALLOW_MULTI_SELECT" => "N"
									),
									false
								);?>
							</div>
						</div>
					</div>
				</div>
				<?
			}
			
			if($TWO_COLUMN != "Y" && $ARTICLE_PAGE == "Y")
			{
				?></div><?
			}
			
			?>
		</div><!-- /inner-content -->
    </div>

</div>

<!-- Подвал -->
<div id="footer-wrapper">
    <div id="footer">
        <div id="footer-cnt">
            <div id="inner-footer">
                <div id="footer-logo"><a href="/" title="Мой компьютер">Мой компьютер | Магазины компьютерной техники</a></div>
                <!-- Информация справа -->
                <div id="footer-right">
                    <p class="footer-phone">
                        <i class="icon icon-phone-wh"></i>
                        <?=tplvar('footer_phone_1', true);?>
                    </p>
                    <p class="footer-phone"><?=tplvar('footer_phone_2', true);?></p>
                    <?$APPLICATION->IncludeComponent("bitrix:main.include", "", array("AREA_FILE_SHOW" => "file", "PATH" => "/include/footer_social_links.php"), false);?>
                    <div id="footer-copyright"><?=tplvar('footer_copyrights', true);?></div>
                </div>

                <!-- Меню -->
                <div id="footer-nav-wrap">
                    <div class="footer-nav-item">
                    	<?$APPLICATION->IncludeComponent(
	                    	"bitrix:menu", 
	                    	"footer_menu",
	                    	array(
	                    		"ROOT_MENU_TYPE"           => "footer_personal",     // Тип меню для первого уровня
	                    		"MAX_LEVEL"                => "1",        // Уровень вложенности меню
	                    		"CHILD_MENU_TYPE"          => "",     // Тип меню для остальных уровней
	                    		"USE_EXT"                  => "N",        // Подключать файлы с именами вида .тип_меню.menu_ext.php
	                    		"DELAY"                    => "N",        // Откладывать выполнение шаблона меню
	                    		"ALLOW_MULTI_SELECT"       => "N",        // Разрешить несколько активных пунктов одновременно
	                    		"MENU_CACHE_TYPE"          => "A",        // Тип кеширования
	                    		"MENU_CACHE_TIME"          => "36000",     // Время кеширования (сек.)
	                    		"MENU_CACHE_USE_GROUPS"    => "Y",        // Учитывать права доступа
	                    		"MENU_CACHE_GET_VARS"      => "",         // Значимые переменные запроса
	                    		"MENU_TITLE" => "ЛИЧНЫЙ КАБИНЕТ",
	                    	)
	                    );
	                    ?>
                    </div>
                    <div class="footer-nav-item">
                    	<?$APPLICATION->IncludeComponent(
	                    	"bitrix:menu", 
	                    	"footer_menu",
	                    	array(
	                    		"ROOT_MENU_TYPE"           => "footer_menu",     // Тип меню для первого уровня
	                    		"MAX_LEVEL"                => "1",        // Уровень вложенности меню
	                    		"CHILD_MENU_TYPE"          => "",     // Тип меню для остальных уровней
	                    		"USE_EXT"                  => "N",        // Подключать файлы с именами вида .тип_меню.menu_ext.php
	                    		"DELAY"                    => "N",        // Откладывать выполнение шаблона меню
	                    		"ALLOW_MULTI_SELECT"       => "N",        // Разрешить несколько активных пунктов одновременно
	                    		"MENU_CACHE_TYPE"          => "A",        // Тип кеширования
	                    		"MENU_CACHE_TIME"          => "36000",     // Время кеширования (сек.)
	                    		"MENU_CACHE_USE_GROUPS"    => "N",        // Учитывать права доступа
	                    		"MENU_CACHE_GET_VARS"      => "",         // Значимые переменные запроса
	                    		"MENU_TITLE" => "МЕНЮ САЙТА",
	                    	)
	                    );
	                    ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?$APPLICATION->ShowViewContent("footer_contents");?>



<!-- Notice Window ------------------------------------------------------>
<div id="notice-window" class="overlay notice-window">
    <div class="notice-window2">
        <div class="overlay-header">
            <h3>УВЕДОМЛЕНИЕ</h3>
        </div>
        <div class="notice-body center">
            <form class="overlay-callback-form">
                <div class="field">
                    <span class="title">Введите Ваш e-mail:</span>
                    <p class="input-text-wrap callback-size">
                       <input type="text" id="email" name="email" class="input-text" />
                    </p>
                </div>
                <div class="field callback-btn-wrap">
                    <div id="subscribe-wrp"></div>
                    <a href="#" id="subscribe-button" class="yellow-btn3">
                        <span>Уведомить</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Notice Window -->






</body>
</html>