<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script> 
<script type="text/javascript">
$(document).ready(function() { 
   //Подсказка с номерами кошельков
   $("#wmb_payment, .tip").mouseover(function(){ 
      $(".tip").show();
   });
   $("#wmb_payment, .tip").mouseout(function(){ 
      $(".tip").hide();
   });

  });
</script>

<?//printAdmin($arResult);?>


<!--
    <script src="js/jquery-1.8.3.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui-1.10.4.custom.min.js" type="text/javascript"></script>

    <script src="js/jquery.carouFredSel-6.2.0-packed.js" type="text/javascript"></script>
    <script src="js/jquery.placeholder.min.js" type="text/javascript"></script>
    <script src="js/jquery.formstyler.min.js" type="text/javascript"></script>
    <script src="js/jquery.dotdotdot-1.5.4.js" type="text/javascript"></script>
    <script src="js/jquery.tools.min.js" type="text/javascript"></script>
    <script src="js/jquery.prettyPhoto.js" type="text/javascript"></script>
    <script src="js/jquery.raty.js" type="text/javascript"></script>
-->







<div class="product-cols clearfix detailPageProduct">
	<div class="product-left-col">
		<div class="images">
			<!-- Большая картинка -->
			<div id="full-image-wrap">
				<div id="full-image" class="frame">
					<?
					if(is_array($arResult["PHOTOS"]) && count($arResult["PHOTOS"]) > 0)
					{
						foreach($arResult["PHOTOS"] as $ph)
						{
							?>
							<a href="<?=$ph["ORIGINAL"]?>" rel="prettyPhoto[gal1]"><img src="<?=$ph["BIG"]?>" alt=""/><i class="zoom"></i></a>
							<?
						}
					}
					else
					{
						?>
						<div style="width:100%;height:100%;background:url(<?=SITE_TEMPLATE_PATH?>/images/emptyphoto190.png) center center no-repeat;"></div>
						<?
					}
					?>
				</div>
			</div>
			<?
			if(is_array($arResult["PHOTOS"]) && count($arResult["PHOTOS"]) > 0)
			{
				?>
				<!-- Миниатюры -->
				<div id="thumbs">
					<div id="thumbs-container">
						<?
						foreach($arResult["PHOTOS"] as $ph)
						{
							?>
							<div>
								<img src="<?=$ph["THUMB"]?>" alt="" width="<?=$ph["THUMB_SZ"]["W"]?>" height="<?=$ph["THUMB_SZ"]["H"]?>" />
							</div>
							<?
						}
						?>
					</div>
					<div id="thumbs-left"></div>
					<div id="thumbs-right"></div>
				</div>
				<?
			}
			?>
		</div>
	</div>
	
	<div class="product-main-col">
		<?
		if(!empty($arResult["~PREVIEW_TEXT"]))
		{
			?>
			<div class="product-description">
				<h3 class="product-subheader">Краткое описание:</h3>
				<p><?=$arResult["~PREVIEW_TEXT"]?></p>
			</div>
			<?
		}
		?>
		<div class="product-details clearfix">

			<div class="product-cost">
				<?ob_start();?>
				<h3 class="product-subheader">Стоимость:</h3>
				<p class="product-price">#PRICE_HTML#</p>
                                <p class="product-grey-price">
                                   <?=($GLOBALS['_SESSION']['CATALOG_CURRENCY'] == 'USD') ? (formatToBYR($arResult['PRICES']['BASE']['DISCOUNT_VALUE'])) : convertPriceToUSD($arResult['PRICES']['BASE']['VALUE']);?>
                                </p>
				<?
				$html = ob_get_clean();
				ShowUncachedContent("price-block-detail",array("id"=>$arResult["ID"],"priceHTML"=>$html));
				?>
                                <div class="product-action-links">
					<div>
					<?
					ob_start(); ?><a href="/ajax.php?action=add2compare&id=<?=$arResult["ID"]?>" class="compare-link compare-link-btn"><i class="icon icon-compare2"></i>Добавить к сравнению</a><? $compareHTML = ob_get_clean();
					ob_start(); ?><a href="/catalog/compare/?IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>" class="compare-link"><i class="icon icon-compare"></i>В сравнении</a><? $incompareHTML = ob_get_clean();
					ShowUncachedContent("compare-link-section",array("id"=>$arResult["ID"],"iblock_id"=>$arParams["IBLOCK_ID"],"compareHTML"=>$compareHTML,"incompareHTML"=>$incompareHTML));
					?>
					</div>
					<div>
						<a href="<?=$APPLICATION->GetCurPageParam("print=Y",array());?>" rel="nofollow" class="print-link" target="_blank">Версия для печати</a>
					</div>
				</div>
<?//printAdmin($USER->getID());?>
<script>
		$(function(){
			$("#subscribe-button").live("click",function(e){
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
				var prodID = <?=$arResult["ID"]?>;
				var btnObj = $(this);
                                var email   = $('#email').val();

				//btnObj.html("<img src='/images/load_blue.gif'/>");
				$.post("/subscribeAjax.php", {action:"subscribeProduct", prodID:prodID, email: email},function(data){
					if(data == "ERROR")
					{
						btnObj.html("Сообщить о появлении на складе");
					}
					else
					{
                                                $("#subscribe-wrp").html(data);
						//$("#block-basket-wrapper").load("/ajax.php?action=updateBasketBlock");
					}
				});
			});
		})
</script>
                                <?if($arResult["CATALOG_PRICE_1"] == '' || $arResult["CATALOG_PRICE_1"] == 0.00):?>
                                   <div class="not-available">
                                   <?=GetMessage("NOT_AVAILABLE")?>                                      
                                      <br/><br/>
                                      <a href="#" class="yellow-btn5 notice-btn"><?=GetMessage("NOTIFY")?></a>
                                   </div>
                                <?else: 
				///////////////////////////////////////////////////////////////////////// Кнопка покупки
				ob_start();?>
                                   <a href="/ajax.php?action=add2cartDetail&id=<?=$arResult["ID"]?>" class="yellow-btn2 buyBtnLink"><i class="icon icon-cart3"></i>В корзину</a><?
				$buyHTML = ob_get_clean();
				ob_start();
				?>
                                   <a href="/personal/cart/" class="grey-btn2 in-cart">Уже в корзине</a>
                                   <?	$inbasketHTML = ob_get_clean();
				   ShowUncachedContent("buy-link-section",array("id"=>$arResult["ID"],"buyHTML"=>$buyHTML,"inbasketHTML"=>$inbasketHTML));
				   //////////////////////////////////////////////////////////////////////////////////////////////////////
				endif;?>


			</div>



			<div class="product-payment-col">
				<!-- Платежные системы -->
				<div id="payments-box">
					<h3 class="product-subheader">Принимаем оплату:</h3>
					<ul id="payments" class="clearfix">
<!--
						<li><a href="#"><img src="<?=SITE_TEMPLATE_PATH?>/images/pay-visa.png" alt="Visa" /></a></li>
						<li><a href="#"><img src="<?=SITE_TEMPLATE_PATH?>/images/pay-mastercard.png" alt="Mastercard" /></a></li>
-->
						<li>
                                                   <div class="tip">
                                                      <b>В317252200636</b> <i>(белорусские рубли)</i>                                                                                                                                                         </br>
                                                      <b>Z299891268573</b> <i>(доллары США)</i>
                                                   </div>
                                                   <a id="wmb_payment" href="javascript:void()">
                                                      <img src="<?=SITE_TEMPLATE_PATH?>/images/pay-webmoney.png" alt="Webmoney"/>
                                                   </a>
                                                </li>
<!--
						<li><a href="#"><img src="<?=SITE_TEMPLATE_PATH?>/images/pay-easy-pay.png" alt="EasyPay" /></a></li>
						<li><a href="#"><img src="<?=SITE_TEMPLATE_PATH?>/images/pay-sms.png" alt="SMS" /></a></li>
-->
						<li><a href="javascript:void()"><img src="<?=SITE_TEMPLATE_PATH?>/images/pay-cash.png" alt="Наличные" /></a></li>
					</ul>
					<div class="center">
						<?
						$callProduct = $arResult["NAME"]." [".$arResult["PROPERTIES"]["ARTNUMBER"]["VALUE"]."]";
						?>
						<a href="javascript:void(0);" 
							rel="#callback-window" 
							data-product="<?=htmlspecialcharsEx($callProduct)?>" 
							class="popup-link grey-btn product-call-order">
							<i class="icon icon-phone-2"></i>Заказ по телефону
						</a>
						
						<a href="/credit/" class="grey-btn product-credit-buy">
							<i class="icon icon-credit"></i>Купить в кредит</a>
					</div>
				</div>
			</div>

		</div>

		<div class="product-rating clearfix">
			<!--DETAIL_RATING_<?=$arResult["ID"]?>-->
		</div>
	</div>

</div>

<!--DETAIL_MIDDLE_BLOCK-->
		
		
<?
$props = array();
if(is_array($arParams["MAIN_PROPERTIES"]) && count($arParams["MAIN_PROPERTIES"]) > 0)
{
	foreach($arParams["MAIN_PROPERTIES"] as $pCode)
	{
		if(is_array($arResult["PROPERTIES"][$pCode]))
		{
			$value = $arResult["PROPERTIES"][$pCode]["~VALUE"];
			if(is_array($value))$value = implode(", ",$value);
			$props[$pCode] = array(
				"NAME" => $arResult["PROPERTIES"][$pCode]["NAME"],
				"VALUE" => $value,
			);
		}
	}
}

$displayPropsCnt = 0;
if(is_array($arResult["DISPLAY_PROPERTIES"]))
{
	unset($arResult["DISPLAY_PROPERTIES"]["MORE_PHOTO"]);
	$displayPropsCnt = count($arResult["DISPLAY_PROPERTIES"]);
}
?>

<!-- Вкладки -->
<div class="tabs-box">
	<ul class="tab-headers">
		<?
		$first = true;
		if(count($props) > 0)
		{
			?><li class="first">Обзор</li><?
			$first = false;
		}

		if($displayPropsCnt > 0)
		{
			?><li <?=$first?"class='first'":""?>>Спецификация</li><?
			$first = false;
		}
		?>
		<li <?=$first?"class='first'":""?>>Отзывы</li>
		<?if(!empty($arResult["~DETAIL_TEXT"])){?><li>Описание</li><?}?>
		<?
		$acc = $arResult["PROPERTIES"]["ACCESSORIES"]["VALUE"];
		if(is_array($acc) && count($acc) > 0)
		{
			?><li>Аксессуары</li><?
		}
		?>
	</ul>

	<div class="tab-panes">
		<?
		if(count($props) > 0)
		{
			?>
			<!-- Обзор -->
			<div class="pane clearfix">
				<table class="review-table <?=empty($arResult["PROPERTIES"]["VIDEO_LINK"]["VALUE"])?"full":""?>">
					<?
					foreach($props as $p)
					{
						?>
						<tr>
							<td class="title"><?=$p["NAME"]?></td>
							<td class="field"><?=$p["VALUE"]?></td>
						</tr>
						<?
					}
					?>
				</table>
				<?
				if(!empty($arResult["PROPERTIES"]["VIDEO_LINK"]["VALUE"]))
				{
					?>
					<div class="review">
						<h3 class="tab-subheader">Видеообзор</h3>
						<div class="video-wrap">
							<?
							if(class_exists("CYetiYouTube"))
							{
								CYetiYouTube::insertHTMLVideo($arResult["PROPERTIES"]["VIDEO_LINK"]["VALUE"],394,242);
							}
							else
							{
								?>
								<a target="_blank" href="<?=$arResult["PROPERTIES"]["VIDEO_LINK"]["VALUE"]?>">Посмотреть видео</a>
								<?
							}
							?>
						</div>
					</div>
					<?
				}
				?>
			</div>
			<?
		}
		
		if($displayPropsCnt > 0)
		{
			?>
			<!-- Спецификации -->
			<div class="pane pane-specs clearfix">
				<table class="review-table full">
				<?
				$middle = ceil($displayPropsCnt/2);
				$i = 0;
				foreach($arResult["DISPLAY_PROPERTIES"] as $p)
				{
					/*if($i == $middle)
					{
						?></table><table class="review-table column2"><?
					}
					*/
					
					$value = $p["~VALUE"];
					if(is_array($value))$value = implode(", ",$value);
					?>
					<tr>
						<td class="title"><?=$p["NAME"]?></td>
						<td class="field"><?=$value?></td>
					</tr>
					<?
					$i++;
				}
				?>
				</table>
			</div>
			<?
		}
		?>
	
		<!-- Отзывы -->
		<div class="pane pane-reviews clearfix">
			<!--DETAIL_REVIEWS-->
		</div>
		<?
		if(!empty($arResult["~DETAIL_TEXT"]))
		{
			?>
			<!-- Описание -->
			<div class="pane pane-description clearfix">
				<?=$arResult["~DETAIL_TEXT"]?>
			</div>
			<?
		}
		?>
		<!-- Аксессуары -->
		<div class="pane pane-accessories clearfix">
			<!--DETAIL_ACCESSORIES-->
		</div>
	</div>
</div>


