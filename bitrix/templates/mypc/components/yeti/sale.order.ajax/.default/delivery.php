<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(!empty($arResult["DELIVERY"]))
{
	?>
	<label>
		<span class="title">Способ доставки</span>
		<p class="radio-wrap">
		<?
		foreach ($arResult["DELIVERY"] as $delivery_id => $arDelivery)
		{
			if ($delivery_id !== 0 && intval($delivery_id) <= 0)
			{
				?>
				<?if (strlen($arDelivery["DESCRIPTION"]) > 0):?><br /><small><?=nl2br($arDelivery["DESCRIPTION"])?></small><br /><?endif;?>
				<?
				foreach ($arDelivery["PROFILES"] as $profile_id => $arProfile)
				{
					?>
					<label for="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>">
						<?=$arDelivery["TITLE"]?><br/>
						<input type="radio" id="ID_DELIVERY_<?=$delivery_id?>_<?=$profile_id?>" name="<?=$arProfile["FIELD_NAME"]?>" value="<?=$delivery_id.":".$profile_id;?>" <?=$arProfile["CHECKED"] == "Y" ? "checked=\"checked\"" : "";?> onchange="submitForm();" />
						<small><b><?=$arProfile["TITLE"]?></b><?if (strlen($arProfile["DESCRIPTION"]) > 0):?><br /><?=nl2br($arProfile["DESCRIPTION"])?><?endif;?></small>
						<?
						$APPLICATION->IncludeComponent('bitrix:sale.ajax.delivery.calculator', '', array(
							"NO_AJAX" => $arParams["DELIVERY_NO_AJAX"],
							"DELIVERY" => $delivery_id,
							"PROFILE" => $profile_id,
							"ORDER_WEIGHT" => $arResult["ORDER_WEIGHT"],
							"ORDER_PRICE" => $arResult["ORDER_PRICE"],
							"LOCATION_TO" => $arResult["USER_VALS"]["DELIVERY_LOCATION"],
							"LOCATION_ZIP" => $arResult["USER_VALS"]["DELIVERY_LOCATION_ZIP"],
							"CURRENCY" => $arResult["BASE_LANG_CURRENCY"],
						), null, array('HIDE_ICONS' => 'Y'));
						?>
					</label>
					<?
				}
			}	
			else
			{
				$price = floatval($arDelivery["PRICE"]);
				?>
				<label>
					<input type="radio" id="ID_DELIVERY_ID_<?= $arDelivery["ID"] ?>" name="<?=$arDelivery["FIELD_NAME"]?>" value="<?= $arDelivery["ID"] ?>"<?if ($arDelivery["CHECKED"]=="Y") echo " checked";?> onchange="submitForm();" >
					<?= $arDelivery["NAME"] ?> <?if($price>0){?>&mdash; <?=$arDelivery["PRICE_FORMATED"]?><?}?>
					<span style="display:inline-block;margin-left:23px;">
					<?
					if (strlen($arDelivery["PERIOD_TEXT"])>0)
					{
						?><span style="display:block;"><?=$arDelivery["PERIOD_TEXT"]?></span><?
					}
					
					if (strlen($arDelivery["DESCRIPTION"])>0)
					{
						?><span style="display:block;"><?=$arDelivery["DESCRIPTION"]?></span><?
					}
					?>
					</span>
				</label>
				<?
			}
		}
		?>
		</p>
	</label>
	<?
}
?>