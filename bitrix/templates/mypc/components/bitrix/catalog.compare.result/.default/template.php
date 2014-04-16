<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<a name="compare_table"></a>
<div class="compare-header-wrap">
	<div id="compare-header-scroll">
		<table class="compare-header">
			<tr>
				<td class="title">
					<div style="margin-bottom: 25px;">
						<a href="<?=$arResult["CATALOG_URL"]?>" class="grey-btn3"><span>Вернуться в каталог</span></a>
					</div>
					<div class="product-compare-links">
						<?/*<a href="#" class="add-to-list">Сохранить товары в список</a>*/?>
						<a href="#" class="print-link" onClick="window.print()">Версия для печати</a>
						<?/*<a href="<?=$arResult["CATALOG_URL"]?>" class="add-link">Добавить товар</a>*/?>
						<a href="<?=$APPLICATION->GetCurPageParam("delAllCompare=Y",array("delAllCompare"))?>" class="del-all-link">Удалить все товары</a>
					</div>
					<ul class="compare-filter">
						<?
						if($arResult["DIFFERENT"]=="Y")
						{
							?>
							<li><a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=N",array("DIFFERENT")))?>">Все параметры</a></li>
							<li><a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=Y",array("DIFFERENT")))?>" class="active">Различающиеся</a></li>
							<?
						}
						else
						{
							?>
							<li><a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=N",array("DIFFERENT")))?>" class="active">Все параметры</a></li>
							<li><a href="<?=htmlspecialcharsbx($APPLICATION->GetCurPageParam("DIFFERENT=Y",array("DIFFERENT")))?>">Различающиеся</a></li>
							<?
						}
						?>
					</ul>
				</td>
				<?
				foreach($arResult["ITEMS"] as $arElement)
				{
					?>
					<td class="field">
						<h2 class="dot-dot-dot"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></h2>
						<div class="double-border-wrap image-wrap">
							<div class="double-border">
								<div class="image">
									<?
									if(!empty($arElement["PHOTO"]))
									{
										?><img src="<?=$arElement["PHOTO"]?>" alt="" /><?
									}
									else
									{
										?><img src="<?=SITE_TEMPLATE_PATH."/images/emptyphoto190.png"?>" alt="" /><?
									}
									?>
								</div>
							</div>
						</div>
					</td>
					<?
				}
				?>
			</tr>
		</table>
	</div>
</div>



<!-- Таблица сравнения товаров --->
<div class="compare-wrap">
	<div id="compare-scroll">
		<table class="compare">
			<tr>
				<td class="title dashed"></td>
				<?
				foreach($arResult["ITEMS"] as $arElement)
				{
					?>
					<td class="field del-field">
						<a href="<?=$arElement["DELETE_URL"]?>" class="del-item"><i class="del-icon"></i><span>Удалить</span></a>
					</td>
					<?
				}
				?>
			</tr>
			<tr>
				<td class="title">Рейтинг</td>
				<?
				foreach($arResult["ITEMS"] as $arElement)
				{
					?>
					<td class="field">
						<?
						$rating = floatval($arElement["PROPERTIES"]["rating"]["VALUE"]);
						?>
						<div class="rating-progress-bar">
							<div class="rating-percent" style="width: <?=round(($rating/5)*100)?>%"></div>
						</div>
					</td>
					<?
				}
				?>
			</tr>
			<tr>
				<td class="title">Стоимость</td>
				<?
				foreach($arResult["ITEMS"] as $arElement)
				{
					?>
					<td class="field">
						<?
						ob_start();
						?><span class="compare-price">#PRICE_HTML#</span><?
						$html = ob_get_clean();
						ShowUncachedContent("price-block-section",array("id"=>$arElement["ID"],"priceHTML"=>$html));
						?>
					</td>
					<?
				}
				?>
			</tr>
			<?
			foreach($arResult["SHOW_PROPERTIES"] as $code=>$arProperty)
			{
				$arCompare = Array();
				foreach($arResult["ITEMS"] as $arElement)
				{
					$arPropertyValue = $arElement["DISPLAY_PROPERTIES"][$code]["~VALUE"];
					if(is_array($arPropertyValue))
					{
						sort($arPropertyValue);
						$arPropertyValue = implode(" / ", $arPropertyValue);
					}
					$arCompare[] = $arPropertyValue;
				}
				$diff = (count(array_unique($arCompare)) > 1 ? true : false);
				if($diff || !$arResult["DIFFERENT"])
				{
					?>
					<tr>
						<td class="title"><?=$arProperty["NAME"]?>&nbsp;</td>
						<?
						foreach($arResult["ITEMS"] as $arElement)
						{
							?>
							<td class="field">
								<?=(is_array($arElement["DISPLAY_PROPERTIES"][$code]["~VALUE"])? implode("/ ", $arElement["DISPLAY_PROPERTIES"][$code]["~VALUE"]): $arElement["DISPLAY_PROPERTIES"][$code]["~VALUE"])?>
								&nbsp;
							</td>
							<?
						}
						?>
					</tr>
					<?
				}
			}
			?>
			<tr class="cart">
				<td class="title">&nbsp;</td>
				<?
				foreach($arResult["ITEMS"] as $arElement)
				{
					?>
					<td class="field">
						<?
						ob_start();
						?>
						<a href="/ajax.php?action=add2cartCompare&id=<?=$arElement["ID"]?>" class="yellow-btn add-to-cart buyBtnLink"><i class="icon icon-cart"></i>В корзину</a>
						<?
						$buyHTML = ob_get_clean();
						ob_start();
						?>
						<a href="/personal/cart/" class="simple-btn add-to-cart" style="padding:8px 20px;"><i class="icon icon-cart"></i>В корзине</a>
						<?
						$inbasketHTML = ob_get_clean();
						ShowUncachedContent("buy-link-section",array("id"=>$arElement["ID"],"buyHTML"=>$buyHTML,"inbasketHTML"=>$inbasketHTML));
						?>
					</td>
					<?
				}
				
							
				?>
			</tr>
		</table>
	</div>
</div>


<div class="compare-footer-wrap clearfix">
	<div class="fr">
		<a href="<?=$arResult["CATALOG_URL"]?>" class="grey-btn3"><span>Обратно в каталог</span></a>
		<a href="#" class="grey-btn3" id="top-link"><span>Наверх</span></a>
	</div>
	
	<a href="#"  onClick="window.print()" class="print-link">Версия для печати</a>
</div>
