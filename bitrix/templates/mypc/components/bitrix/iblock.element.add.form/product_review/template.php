<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?if (strlen($arResult["MESSAGE"]) > 0):?>
	<div style="font-size:14pt; color:#339933;"><?=$arResult["MESSAGE"]?></div>
	<?
	return;
	?>
<?endif?>

<!-- Добавить новый отзыв -->
<form name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
<?=bitrix_sessid_post()?>
<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>
<div class="add-new-review">
	<h2>ДОБАВИТЬ СВОЙ ОТЗЫВ</h2>
	<?if (count($arResult["ERRORS"])):?>
		<div style="font-size:14pt; color:#c03;padding:0 0 10px;"><?=implode("<br />", $arResult["ERRORS"])?></div>
	<?endif?>
	<?
	if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"]))
	{
		foreach ($arResult["PROPERTY_LIST"] as $propertyID)
		{
			$title = "";
			if (intval($propertyID) > 0)
			{
				$title = $arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"];
			}
			else
			{
				$title = !empty($arParams["CUSTOM_TITLE_".$propertyID]) ? $arParams["CUSTOM_TITLE_".$propertyID] : GetMessage("IBLOCK_FIELD_".$propertyID);
			}
			
			if (intval($propertyID) > 0)
			{
				if (
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "T"
					&&
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] == "1"
				)
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "S";
				elseif (
					(
						$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "S"
						||
						$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] == "N"
					)
					&&
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"] > "1"
				)
					$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "T";
			}
			elseif (($propertyID == "TAGS") && CModule::IncludeModule('search'))
				$arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"] = "TAGS";

			if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y")
			{
				$inputNum = ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0) ? count($arResult["ELEMENT_PROPERTIES"][$propertyID]) : 0;
				$inputNum += $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE_CNT"];
			}
			else
			{
				$inputNum = 1;
			}

			if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
				$INPUT_TYPE = "USER_TYPE";
			else
				$INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];
			
			
			$propertyCode = $arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"];
			
			switch ($INPUT_TYPE)
			{
				case "T":
					if($propertyID == "PREVIEW_TEXT")
					{
						for ($i = 0; $i<$inputNum; $i++)
						{

							if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
							{
								$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
							}
							elseif ($i == 0)
							{
								$value = intval($propertyID) > 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];
							}
							else
							{
								$value = "";
							}
							?>
							<div class="block-form-element">
								<span class="title">Комментарий</span>
								<p class="textarea-wrap large-size"><textarea rows="4" class="textarea" name="PROPERTY[<?=$propertyID?>][<?=$i?>]"><?=$value?></textarea></p>
							</div>
							<?
						}
					}
				break;

				case "S":
				case "N":
					if($propertyID == "NAME")
					{
						for ($i = 0; $i<$inputNum; $i++)
						{
							if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
							{
								$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
							}
							elseif ($i == 0)
							{
								$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];

							}
							else
							{
								$value = "";
							}
							?>
							<div class="clearfix">
							<div class="block-form-element fl">
								<span class="title">Ваше имя</span>
								<p class="input-text-wrap modal-size"><input type="text" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" class="input-text" value="<?=$value?>" /></p>
							</div>
							<?
						}
					}
					if($propertyCode == "EMAIL")
					{
						for ($i = 0; $i<$inputNum; $i++)
						{
							if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
							{
								$value = intval($propertyID) > 0 ? $arResult["ELEMENT_PROPERTIES"][$propertyID][$i]["VALUE"] : $arResult["ELEMENT"][$propertyID];
							}
							elseif ($i == 0)
							{
								$value = intval($propertyID) <= 0 ? "" : $arResult["PROPERTY_LIST_FULL"][$propertyID]["DEFAULT_VALUE"];

							}
							else
							{
								$value = "";
							}
							?>
							<div class="block-form-element fr">
								<span class="title">Ваш e-mail</span>
								<p class="input-text-wrap modal-size"><input type="text"  name="PROPERTY[<?=$propertyID?>][<?=$i?>]" value="<?=$value?>" class="input-text" /></p>
							</div>
							</div>
							<?
						}
					}
				break;

				case "L":
					if ($arResult["PROPERTY_LIST_FULL"][$propertyID]["LIST_TYPE"] == "C")
						$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "checkbox" : "radio";
					else
						$type = $arResult["PROPERTY_LIST_FULL"][$propertyID]["MULTIPLE"] == "Y" ? "multiselect" : "dropdown";

					switch ($type)
					{
						case "checkbox":
						case "radio":
							foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
							{
								$checked = false;
								if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
								{
									if (is_array($arResult["ELEMENT_PROPERTIES"][$propertyID]))
									{
										foreach ($arResult["ELEMENT_PROPERTIES"][$propertyID] as $arElEnum)
										{
											if ($arElEnum["VALUE"] == $key) {$checked = true; break;}
										}
									}
								}
								else
								{
									if ($arEnum["DEF"] == "Y") $checked = true;
								}

								?>
								<input type="<?=$type?>" name="PROPERTY[<?=$propertyID?>]<?=$type == "checkbox" ? "[".$key."]" : ""?>" value="<?=$key?>" id="property_<?=$key?>"<?=$checked ? " checked=\"checked\"" : ""?> /><label for="property_<?=$key?>"><?=$arEnum["VALUE"]?></label><br />
								<?
							}
						break;

						case "dropdown":
						case "multiselect":
							if($propertyCode == "VOTE")
							{
								?>
								<div class="inline-form-element">
									<span class="title">Насколько Вы довольны покупкой?</span>
									<p class="select-wrap review-size">
										<select class="formstyler"  name="PROPERTY[<?=$propertyID?>]<?=$type=="multiselect" ? "[]\" size=\"".$arResult["PROPERTY_LIST_FULL"][$propertyID]["ROW_COUNT"]."\" multiple=\"multiple" : ""?>">
											<option value="0">Выберите оценку</option>
											<?
											if (intval($propertyID) > 0) $sKey = "ELEMENT_PROPERTIES";
											else $sKey = "ELEMENT";
											foreach ($arResult["PROPERTY_LIST_FULL"][$propertyID]["ENUM"] as $key => $arEnum)
											{
												$checked = false;
												if ($arParams["ID"] > 0 || count($arResult["ERRORS"]) > 0)
												{
													foreach ($arResult[$sKey][$propertyID] as $elKey => $arElEnum)
													{
														if ($key == $arElEnum["VALUE"]) {$checked = true; break;}
													}
												}
												else
												{
													if ($arEnum["DEF"] == "Y") $checked = true;
												}
												
												$arTxt = array(
													"1" => "Плохо",
													"2" => "Так себе",
													"3" => "Нормально",
													"4" => "Хорошо",
													"5" => "Отлично",
												);
												?>
												<option value="<?=$key?>" <?=$checked ? " selected=\"selected\"" : ""?>><?=$arTxt[$arEnum["VALUE"]]?></option>
												<?
											}
											?>
										</select>
									</p>
								</div>
								<?
							}
						break;

					}
				break;
				
				case "E":
					if($propertyCode == "PRODUCT")
					{
						for ($i = 0; $i<$inputNum; $i++)
						{
							$value = $arParams["PRODUCT_ID"];
							?>
							<input id="input-product-id" type="hidden" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" value="<?=$value?>" />
							<?
						}
					}
					break;
			}
		}
	}
	
	if($arParams["USE_CAPTCHA"] == "Y" && $arParams["ID"] <= 0)
	{
		?>
		<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
		<div class="block-form-element">
			<p><img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="190" height="40" alt="CAPTCHA" /></p>
			<p class="input-text-wrap captcha-size"><input type="text" name="captcha_word" class="input-text" placeholder="Введите код с картинки" /></p>
		</div>
		<?
	}
	?>
	<input type="hidden" name="iblock_submit" value="Y"/>
	<a class="yellow-btn large" href="#" id="product-review-btn">ДОБАВИТЬ</a>
</div>
</form>