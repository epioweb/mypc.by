<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if (!empty($arResult["ORDER"]))
{
	
	if(intval($arResult["ORDER_ID"]) > 0 && !empty($arParams["SUBSCRIBE_RUBRIC"]) && $_SESSION["ORDER_SUBSCRIBE"] == "Y" && CModule::IncludeModule("subscribe"))
	{
		$RUBRIC_ID = $arParams["SUBSCRIBE_RUBRIC"];
		if(!is_array($RUBRIC_ID)) $RUBRIC_ID = array($RUBRIC_ID);
		TrimArr($RUBRIC_ID);
		if(count($RUBRIC_ID) > 0)
		{
			$email = "";
			$orderPropsRs = CSaleOrderPropsValue::GetOrderProps($arResult["ORDER_ID"]);
			while($orderProp = $orderPropsRs->Fetch())
			{
				if($orderProp["IS_EMAIL"] == "Y")
				{
					$email = $orderProp["VALUE"];
				}
			}
	
			if(!empty($email) && check_email($email))
			{
				if($subscription = CSubscription::GetByEmail($email)->fetch())
				{
					$rubrics = CSubscription::GetRubricArray($subscription["ID"]);
					$rubrics = array_merge($rubrics,$RUBRIC_ID);
					$subscr = new CSubscription;
					$subscr->Update($subscription["ID"], array("ACTIVE"=>"Y","RUB_ID"=>$rubrics));
				}
				else
				{
					global $USER;
					$subscr = new CSubscription;
					$subscrFields = array(
						"FORMAT" => "html",
						"EMAIL" => $email,
						"ACTIVE" => "Y",
						"RUB_ID" => $RUBRIC_ID,
						"SEND_CONFIRM" => "N",
						"CONFIRMED" => "Y",
					);
						
					if($USER->IsAuthorized()) $subscrFields["USER_ID"] = $USER->GetID();
					$ID = $subscr->Add($subscrFields);
				}
			}
		}
		
		unset($_SESSION["ORDER_SUBSCRIBE"]);
	}
	?>
	<!-- Заказ принят -->
	<div class="product-header cart-header">
		<h2><i class="icon icon-cart4"></i>ВАШ ЗАКАЗ ПРИНЯТ!</h2>
	</div>
	<div class="ordering-wrap ordering-success">
		<div class="double-border-wrap">
			<div class="double-border">
				<h3>Благодарим Вас за покупку!</h3>
				<p class="order-num">Номер Вашего заказа: <span><?=$arResult["ORDER_ID"]?></span></p>
				<p>В ближайшее время наш менеджер свяжется с Вами!</p>
				<p>С уважением, интернет-магазин “Мой Компьютер”</p>
				<?
				if (!empty($arResult["PAY_SYSTEM"]))
				{
					?>
					<div style="margin-top: 30px;">
						<div>
							<?=GetMessage("SOA_TEMPL_PAY")?>: <?= $arResult["PAY_SYSTEM"]["NAME"] ?>
						</div>
						<?
						if (strlen($arResult["PAY_SYSTEM"]["ACTION_FILE"]) > 0)
						{
							?>
							<div>
								<?
								if ($arResult["PAY_SYSTEM"]["NEW_WINDOW"] == "Y")
								{
									?>
									<script language="JavaScript">
										window.open('<?=$arParams["PATH_TO_PAYMENT"]?>?ORDER_ID=<?= $arResult["ORDER_ID"] ?>');
									</script>
									<?= GetMessage("SOA_TEMPL_PAY_LINK", Array("#LINK#" => $arParams["PATH_TO_PAYMENT"]."?ORDER_ID=".$arResult["ORDER_ID"])) ?>
									<?
								}
								else
								{
									if (strlen($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"])>0)
									{
										include($arResult["PAY_SYSTEM"]["PATH_TO_ACTION"]);
									}
								}
								?>
							</div>
							<?
						}
						?>
					</div>
					<?
				}
				?>
				
			</div>
		</div>
	</div>
	<?	
}
else
{
	?>
	<div class="product-header cart-header">
		<h2 style="color:#c03"><?=GetMessage("SOA_TEMPL_ERROR_ORDER")?></h2>
	</div>
	<div class="ordering-wrap">
		<div class="double-border-wrap">
			<div class="double-border" style="padding:30px;">
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST", Array("#ORDER_ID#" => $arResult["ORDER_ID"]))?>
				<?=GetMessage("SOA_TEMPL_ERROR_ORDER_LOST1")?>
			</div>
		</div>
	</div>
	<?
}
?>