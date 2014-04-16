<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
function PrintPropsForm($arSource=Array(), $locationTemplate = ".default")
{
	if (!empty($arSource))
	{
		$group3 = array("DELIVERY_HOUSING","DELIVERY_PORCH","DELIVERY_APARTMENT");
		foreach($arSource as $arProperties)
		{
			if(!in_array($arProperties["CODE"],$group3))
			{
				?><li><?
			}
			elseif($arProperties["CODE"] == "DELIVERY_HOUSING")
			{
				?><li class="input-three-cols clearfix"><?
			}
			?>
				<label>
					<span class="title">
						<?= $arProperties["NAME"]?>
						<?
						if($arProperties["REQUIED_FORMATED"]=="Y")
						{
							?><span class="sof-req">*</span><?
						}
						?>
					</span>
					<?
					if($arProperties["TYPE"] == "CHECKBOX")
					{
						?>
						<input type="hidden" name="<?=$arProperties["FIELD_NAME"]?>" value="">
						<input type="checkbox" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" value="Y"<?if ($arProperties["CHECKED"]=="Y") echo " checked";?>>
						<?
					}
					elseif($arProperties["TYPE"] == "TEXT")
					{
						$size = "normal-size";
						if(in_array($arProperties["CODE"],$group3))
							$size = "small-size";
						?>
						<p class="input-text-wrap <?=$size?>"><input placeholder="<?=$arProperties["DESCRIPTION"]?>" type="text" maxlength="250" value="<?=$arProperties["VALUE"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" class="input-text" /></p>
						<?
					}
					elseif($arProperties["TYPE"] == "SELECT")
					{
						?>
						<p class="select-wrap">
							<select name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
							<?
							foreach($arProperties["VARIANTS"] as $arVariants)
							{
								?>
								<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
								<?
							}
							?>
							</select>
						</p>
						<?
					}
					elseif ($arProperties["TYPE"] == "MULTISELECT")
					{
						?>
						<p class="select-multiple-wrap">
							<select multiple name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>" size="<?=$arProperties["SIZE1"]?>">
							<?
							foreach($arProperties["VARIANTS"] as $arVariants)
							{
								?>
								<option value="<?=$arVariants["VALUE"]?>"<?if ($arVariants["SELECTED"] == "Y") echo " selected";?>><?=$arVariants["NAME"]?></option>
								<?
							}
							?>
							</select>
						</p>
						<?
					}
					elseif ($arProperties["TYPE"] == "TEXTAREA")
					{
						?>
						<p class="textarea-wrap normal-size"><textarea class="textarea" rows="<?=$arProperties["SIZE2"]?>" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>"><?=$arProperties["VALUE"]?></textarea></p>
						<?
					}
					elseif ($arProperties["TYPE"] == "LOCATION")
					{
						$value = 0;
						if (is_array($arProperties["VARIANTS"]) && count($arProperties["VARIANTS"]) > 0)
						{
							foreach ($arProperties["VARIANTS"] as $arVariant)
							{
								if ($arVariant["SELECTED"] == "Y")
								{
									$value = $arVariant["ID"];
									break;
								}
							}
						}

						$GLOBALS["APPLICATION"]->IncludeComponent(
							"bitrix:sale.ajax.locations",
							"popup",
							array(
								"AJAX_CALL" => "N",
								"COUNTRY_INPUT_NAME" => "COUNTRY",//.$arProperties["FIELD_NAME"],
								"REGION_INPUT_NAME" => "REGION",//.$arProperties["FIELD_NAME"],
								"CITY_INPUT_NAME" => $arProperties["FIELD_NAME"],
								"CITY_OUT_LOCATION" => "Y",
								"LOCATION_VALUE" => $value,
								"ORDER_PROPS_ID" => $arProperties["ID"],
								"ONCITYCHANGE" => ($arProperties["IS_LOCATION"] == "Y" || $arProperties["IS_LOCATION4TAX"] == "Y") ? "submitForm()" : "",
								"SIZE1" => $arProperties["SIZE1"],
							),
							null,
							array('HIDE_ICONS' => 'N')
						);
					}
					elseif ($arProperties["TYPE"] == "RADIO")
					{
						?>
						<p class="radio-wrap">
						<?
						foreach($arProperties["VARIANTS"] as $arVariants)
						{
							?>
							<label>
								<input type="radio" name="<?=$arProperties["FIELD_NAME"]?>" id="<?=$arProperties["FIELD_NAME"]?>_<?=$arVariants["VALUE"]?>" value="<?=$arVariants["VALUE"]?>"<?if($arVariants["CHECKED"] == "Y") echo " checked";?>>
								<?=$arVariants["NAME"]?>
							</label>
							<?
						}
						?>
						</p>
						<?
					}
					?>
				</label>
			<?
			if(!in_array($arProperties["CODE"],$group3))
			{
				?></li><?
			}
			elseif($arProperties["CODE"] == "DELIVERY_APARTMENT")
			{
				?></li><?
			}
		}
		return true;
	}
	return false;
}

if(!empty($arResult["ORDER_PROP"]["USER_PROFILES"]))
{
	?>
	<li>
		<span class="title"><?=GetMessage("SOA_TEMPL_PROP_CHOOSE")?></span>
		<p class="select-wrap">
		<select name="PROFILE_ID" id="ID_PROFILE_ID" onChange="SetContact(this.value)">
			<option value="0"><?=GetMessage("SOA_TEMPL_PROP_NEW_PROFILE")?></option>
			<?
			foreach($arResult["ORDER_PROP"]["USER_PROFILES"] as $arUserProfiles)
			{
				?>
				<option value="<?= $arUserProfiles["ID"] ?>"<?if ($arUserProfiles["CHECKED"]=="Y") echo " selected";?>><?=$arUserProfiles["NAME"]?></option>
				<?
			}
			?>
		</select>
		</p>
	</li>
	<?
}

PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_N"], $arParams["TEMPLATE_LOCATION"]);
PrintPropsForm($arResult["ORDER_PROP"]["USER_PROPS_Y"], $arParams["TEMPLATE_LOCATION"]);
?>
<li>
	<label>
		<span class="title">Комментарий к заказу</span>
		<p class="textarea-wrap normal-size">
			<textarea class="textarea" rows="4" name="ORDER_DESCRIPTION"><?=$arResult["USER_VALS"]["ORDER_DESCRIPTION"]?></textarea>
		</p>
	</label>
</li>