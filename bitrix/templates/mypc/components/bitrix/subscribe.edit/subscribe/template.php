<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
foreach($arResult["MESSAGE"] as $itemID=>$itemValue)
	echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"OK"));
foreach($arResult["ERROR"] as $itemID=>$itemValue)
	echo ShowMessage(array("MESSAGE"=>$itemValue, "TYPE"=>"ERROR"));

if($arResult["ALLOW_ANONYMOUS"]=="N" && !$USER->IsAuthorized()):
	echo ShowMessage(array("MESSAGE"=>GetMessage("CT_BSE_AUTH_ERR"), "TYPE"=>"ERROR"));
else:
?>
<div class="order-info-block-wrap">
	<h2 class="black-subheader"><?echo GetMessage("CT_BSE_SUBSCRIPTION_FORM_TITLE")?></h2>
	
	<div class="ordering-wrap">
                                <div class="double-border-wrap">
                                    <div class="double-border">
                                        <div class="form-fields subscribe-info-block clearfix">
	<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
	<?echo bitrix_sessid_post();?>
	<input type="hidden" name="PostAction" value="<?echo ($arResult["ID"]>0? "Update":"Add")?>" />
	<input type="hidden" name="ID" value="<?echo $arResult["SUBSCRIPTION"]["ID"];?>" />
	<input type="hidden" name="RUB_ID[]" value="0" />

		<table cellspacing="0" class="fields-table subscribe-info-table">
			<tr>
				<td><span class="title"><?echo GetMessage("CT_BSE_EMAIL_LABEL")?></span></td>
				<td><p class="input-text-wrap normal-size large"><input type="text" name="EMAIL" value="<?echo $arResult["SUBSCRIPTION"]["EMAIL"]!=""? $arResult["SUBSCRIPTION"]["EMAIL"]: $arResult["REQUEST"]["EMAIL"];?>"  class="input-text"/></p></td>
			</tr>
			<tr>
				<td><span class="title"><?echo GetMessage("CT_BSE_FORMAT_LABEL")?></span></td>
				<td>
					<label class="radio-label inline"><input type="radio" name="FORMAT" id="MAIL_TYPE_TEXT" value="text" class="formstyler" <?if($arResult["SUBSCRIPTION"]["FORMAT"] != "html") echo "checked"?> /><?echo GetMessage("CT_BSE_FORMAT_TEXT")?></label>
					<label class="radio-label inline"><input type="radio" name="FORMAT" id="MAIL_TYPE_HTML" value="html" class="formstyler" <?if($arResult["SUBSCRIPTION"]["FORMAT"] == "html") echo "checked"?> /><?echo GetMessage("CT_BSE_FORMAT_HTML")?></label>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="divider"></td>
			</tr>
			<tr>
				<td class="va-top"><span class="title"><?echo GetMessage("CT_BSE_RUBRIC_LABEL")?></span></td>
				<td>
					<?foreach($arResult["RUBRICS"] as $itemID => $itemValue):?>
						<label class="checkbox-label semibold">
							<input type="checkbox" id="RUBRIC_<?echo $itemID?>" name="RUB_ID[]" value="<?=$itemValue["ID"]?>"<?if($itemValue["CHECKED"]) echo " checked"?> class="formstyler checkbox-style2" /><?echo $itemValue["NAME"]?>
						</label>
						<span class="info-field"><?echo $itemValue["DESCRIPTION"]?></span>
					<?endforeach;?>

					<?if($arResult["ID"]==0):?>
						<span class="info-field"><em><?echo GetMessage("CT_BSE_NEW_NOTE")?></em></span>
					<?else:?>
						<span class="info-field"><em><?echo GetMessage("CT_BSE_EXIST_NOTE")?></em></span>
					<?endif?>
					<br/><br/><br/>
					<button class="yellow-btn2 style2"><?echo ($arResult["ID"] > 0? GetMessage("CT_BSE_BTN_EDIT_SUBSCRIPTION"): GetMessage("CT_BSE_BTN_ADD_SUBSCRIPTION"))?></button>
				</td>
			</tr>
		</table>


	<?if($arResult["ID"]>0 && $arResult["SUBSCRIPTION"]["CONFIRMED"] <> "Y"):?>
	</div>
	<div>
		<div class="white-block registration-info-block subscribe-info-block2">
		<h3 class="semibold"><?echo GetMessage("CT_BSE_TITLE")?></h3>
		<p><?echo GetMessage("CT_BSE_CONF_NOTE")?></p>
		<input name="CONFIRM_CODE" type="text" class="form-control big-size" style="width: 323px; margin: -2px 15px 0 0;" value="<?echo GetMessage("CT_BSE_CONFIRMATION")?>" onblur="if (this.value=='')this.value='<?echo GetMessage("CT_BSE_CONFIRMATION")?>'" onclick="if (this.value=='<?echo GetMessage("CT_BSE_CONFIRMATION")?>')this.value=''" /> 
		<button class="grey-btn3"><span><?echo GetMessage("CT_BSE_BTN_CONF")?></span></button>
		</div>
	<?endif?>

	</form>
	</div>
	</div>
	</div>
	</div>
</div>

	<?if(!CSubscription::IsAuthorized($arResult["ID"])):?>
		<div>
			<div class="white-block registration-info-block subscribe-info-block2">
			<form action="<?=$arResult["FORM_ACTION"]?>" method="post">
			<?echo bitrix_sessid_post();?>
			<input type="hidden" name="action" value="sendcode" />

				<h3 class="semibold"><?echo GetMessage("CT_BSE_TITLE")?></h3>
				<p><?echo GetMessage("CT_BSE_SEND_NOTE")?></p>
				<input name="sf_EMAIL" type="text" class="form-control big-size" style="width: 323px; margin: -2px 15px 0 0;" value="<?echo GetMessage("CT_BSE_EMAIL")?>" onblur="if (this.value=='')this.value='<?echo GetMessage("CT_BSE_EMAIL")?>'" onclick="if (this.value=='<?echo GetMessage("CT_BSE_EMAIL")?>')this.value=''" />
				<button class="grey-btn3"><span><?echo GetMessage("CT_BSE_BTN_SEND")?></span></button>
			</form>
			</div>
		</div>
	<?endif?>


<?endif;?>