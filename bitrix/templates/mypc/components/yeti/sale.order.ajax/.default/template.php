<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(intval($_REQUEST["ORDER_ID"]) > 0)
{
	
}
else
{
	?>
	<!-- Оформление заказа -->
	<div class="product-header cart-header">
		<h2><i class="icon icon-cart4"></i>Оформление заказа</h2>
	</div>
	<?
}
?>
<a name="order_fform"></a>
<div id="order_form_div" class="order-checkout">
<NOSCRIPT>
	<div class="errortext"><?=GetMessage("SOA_NO_JS")?></div>
</NOSCRIPT>
<?
if(!$USER->IsAuthorized() && $arParams["ALLOW_AUTO_REGISTER"] == "N")
{
	if(!empty($arResult["ERROR"]))
	{
		
		foreach($arResult["ERROR"] as $k=>$v)
		{
			$v = str_replace("логин","адрес эл.почты",$v);
			$arResult["ERROR"][$k] = $v;
		}
		
		?>
		<div class="very-important-message">
			<p><?=implode("<br/>",$arResult["ERROR"]);?></p>
			<b></b>
		</div>
		<?
	}
	elseif(!empty($arResult["OK_MESSAGE"]))
	{
		?>
		<div class="important-message">
			<p><?=implode("<br/>",$arResult["OK_MESSAGE"]);?></p>
			<b></b>
		</div>
		<?
	}

	include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/auth.php");
}
else
{
	if($arResult["USER_VALS"]["CONFIRM_ORDER"] == "Y")
	{
		if(strlen($arResult["REDIRECT_URL"]) > 0)
		{
			?>
			<script>
			<!--
			window.top.location.href='<?=CUtil::JSEscape($arResult["REDIRECT_URL"])?>';
			//-->
			</script>
			<?
			die();
		}
		else
		{
			include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/confirm.php");
		}
	}
	else
	{
		?>
		<script>
		<!--
		function zedOrderInit()
		{
			$('#ORDER_FORM input[type="checkbox"], #ORDER_FORM select').styler({
				browseText: 'Выбрать файл',
				singleSelectzIndex: '809'
			});
		}
		
		function submitForm(val)
		{
			if(val != 'Y') 
				BX('confirmorder').value = 'N';
			
			var orderForm = BX('ORDER_FORM');
			
			BX.ajax.submitComponentForm(orderForm, 'order_form_content', true);
			BX.submit(orderForm);

			return true;
		}
		function SetContact(profileId)
		{
			BX("profile_change").value = "Y";
			submitForm();
		}
		//-->
		</script>
		<?if($_POST["is_ajax_post"] != "Y")
		{
			?>
			<form action="" method="POST" name="ORDER_FORM" id="ORDER_FORM">
			<?=bitrix_sessid_post()?>
			<div id="order_form_content">
			<?
		}
		else
		{
			$APPLICATION->RestartBuffer();
		}
		
		if(!empty($arResult["ERROR"]) && $arResult["USER_VALS"]["FINAL_STEP"] == "Y")
		{
			?>
			<div class="very-important-message">
				<p><?=implode("<br/>",$arResult["ERROR"]);?></p>
				<b></b>
			</div>
			<script>
				top.BX.scrollToNode(top.BX('ORDER_FORM'));
			</script>
			<?
		}
		?>
		<div class="ordering-wrap">
			<div class="double-border-wrap">
				<div class="double-border">
					<div class="ordering personal-data-cols clearfix">
						<ul class="left-col">
							<?
							if(count($arResult["PERSON_TYPE"]) > 1)
							{
								?>
								<li>
									<label>
										<span class="title">Кем Вы являетесь?</span>
										<p class="select-wrap normal-size">
											<select name="PERSON_TYPE" onChange="submitForm()" class="formstyler">
												<option value=""> --- Выберите тип плательщика --- </option>
												<?
												foreach($arResult["PERSON_TYPE"] as $v)
												{
													if(preg_match("#физ#ui",$v["NAME"]))$v["NAME"] = "Физическим лицом";
													elseif(preg_match("#юрид#ui",$v["NAME"]))$v["NAME"] = "Юридическим лицом";
													?>
													<option value="<?= $v["ID"] ?>" <?if ($v["CHECKED"]=="Y") echo " selected=\"selected\"";?> ><?= $v["NAME"] ?></option>
													<?
												}
												?>
											</select>
											<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$arResult["USER_VALS"]["PERSON_TYPE_ID"]?>">
										</p>
									</label>
								</li>
								<?
							}
							else
							{
								?>
								<li style="margin:0;">
								<?
								if(IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"]) > 0)
								{
									?>
									<input type="hidden" name="PERSON_TYPE" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>">
									<input type="hidden" name="PERSON_TYPE_OLD" value="<?=IntVal($arResult["USER_VALS"]["PERSON_TYPE_ID"])?>">
									<?
								}
								else
								{
									foreach($arResult["PERSON_TYPE"] as $v)
									{
										?>
										<input type="hidden" id="PERSON_TYPE" name="PERSON_TYPE" value="<?=$v["ID"]?>">
										<input type="hidden" name="PERSON_TYPE_OLD" value="<?=$v["ID"]?>">
										<?
									}
								}
								?>
								</li>
								<?
							}
							?>
							<li>
								<?
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/delivery.php");
								?>
							</li>
							<li>
								<?
								include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/paysystem.php");
								?>
							</li>
							<li>
								<label class="terms-checkbox" style="display: block;">
									<input type="checkbox" name="TERMS_ACCEPTED" value="Y"><span class="terms">Ознакомлен с <a href="/include/guarantees.php" class="ajax-modal">публичным договором и с условиями гарантии</a></span>
								</label>
								<label class="subscribe-checkbox">
									<input type="checkbox" name="SUBSCRIBE" value="Y">Подписаться на рассылку
								</label>
							</li>
							<li class="order-total">
								<p>Общая стоимость заказа:</p>
								<p class="total"><?=$arResult["ORDER_TOTAL_PRICE_FORMATED"]?></p>
								<button type="submit" class="yellow-btn2" onClick="submitForm('Y');">Оформить заказ</button>
								<input type="hidden" name="submitbutton" value="Y">
							</li>
						</ul>
						<ul class="right-col">
							<?
							include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/props.php");
							?>
						</ul>
						<img src="<?=SITE_TEMPLATE_PATH?>/images/1px.gif" onload="top.zedOrderInit();">
					</div>
				</div>
			</div>
		</div>
		<?
		//include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/summary.php");
		?>
		<?if($_POST["is_ajax_post"] != "Y")
		{
			?>
				</div>
				<input type="hidden" name="confirmorder" id="confirmorder" value="Y">
				<input type="hidden" name="profile_change" id="profile_change" value="N">
				<input type="hidden" name="is_ajax_post" id="is_ajax_post" value="Y">
			</form>
			<?if($arParams["DELIVERY_NO_AJAX"] == "N"):?>
				<script language="JavaScript" src="/bitrix/js/main/cphttprequest.js"></script>
				<script language="JavaScript" src="/bitrix/components/bitrix/sale.ajax.delivery.calculator/templates/.default/proceed.js"></script>
			<?endif;?>
			<?
		}
		else
		{
			?>
			<script>
				top.BX('confirmorder').value = 'Y';
				top.BX('profile_change').value = 'N';
			</script>
			<?
			die();
		}
	}
}
?>
</div>