<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="ordering-wrap registration-wrap">
	<div class="double-border-wrap">
		<div class="double-border">
			<div class="registration">
				<?
				ShowMessage($arParams["~AUTH_RESULT"]);
				if($arResult["USE_EMAIL_CONFIRMATION"] === "Y" && is_array($arParams["AUTH_RESULT"]) &&  $arParams["AUTH_RESULT"]["TYPE"] === "OK")
				{
					?><div class="field"><?echo GetMessage("AUTH_EMAIL_SENT")?></div><?
				}
				else
				{
					if($arResult["USE_EMAIL_CONFIRMATION"] === "Y")
					{
						?><div class="field"><?echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")?></div><?
					}
					?>
					<form method="post" action="<?=$arResult["AUTH_URL"]?>" name="bform">
						<?
						if (strlen($arResult["BACKURL"]) > 0){?><input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" /><?}
						?>
						<input type="hidden" name="AUTH_FORM" value="Y" />
						<input type="hidden" name="TYPE" value="REGISTRATION" />
						
						<ul class="registration-fields">
							<li>
								<label>
									<span class="title">Имя</span>
									<p class="input-text-wrap normal-size large">
										<input type="text" name="USER_NAME" maxlength="50" value="<?=$arResult["USER_NAME"]?>" class="input-text" />
									</p>
								</label>
							</li>
							<li>
								<label>
									<span class="title">Фамилия</span>
									<p class="input-text-wrap normal-size large">
										<input type="text" name="USER_LAST_NAME" maxlength="50" value="<?=$arResult["USER_LAST_NAME"]?>" class="input-text" />
									</p>
								</label>
							</li>
							<li>
								<label>
									<span class="title">Логин (мин. 3 символа) <span class="required">*</span></span>
									<p class="input-text-wrap normal-size large">
										<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" class="input-text"/>
									</p>
								</label>
							</li>
							<li>
								<label>
									<span class="title">Пароль <span class="required">* **</span></span>
									<p class="input-text-wrap normal-size large">
										<input type="password" name="USER_PASSWORD" maxlength="50" value="<?=$arResult["USER_PASSWORD"]?>" class="input-text"/>
									</p>
								</label>
							</li>
							<li>
								<label>
									<span class="title">Подтверждение пароля <span class="required">*</span></span>
									<p class="input-text-wrap normal-size large">
										<input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>" class="input-text"/>
									</p>
								</label>
							</li>
							<li>
								<label>
									<span class="title">E-mail <span class="required">*</span></span>
									<p class="input-text-wrap normal-size large">
										<input type="text" name="USER_EMAIL" maxlength="255" value="<?=$arResult["USER_EMAIL"]?>" class="input-text"/>
									</p>
								</label>
							</li>
							
							<?
							if($arResult["USER_PROPERTIES"]["SHOW"] == "Y")
							{
								foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField)
								{
									?>
									<li>
										<label>
											<span class="title">
												<?=strLen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?>
												<?=$arUserField["EDIT_FORM_LABEL"]?><?if ($arUserField["MANDATORY"]=="Y"):?><span class="required">*</span><?endif;?>
											</span>
											<p class="input-text-wrap normal-size large">
												<?$APPLICATION->IncludeComponent(
													"bitrix:system.field.edit",
													$arUserField["USER_TYPE"]["USER_TYPE_ID"],
													array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField, "form_name" => "bform"), null, array("HIDE_ICONS"=>"Y"));?>
											</p>
										</label>
									</li>
									<?
								}
							}
							
							if ($arResult["USE_CAPTCHA"] == "Y")
							{
								?>
								<li class="captcha-field">
									<span class="title">Защита от автоматической регистрации</span>
									<div class="captcha-wrap">
										<div class="captcha">
											<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" />
										</div>
										<label>
											<span class="title">Введите слово<br/> на картинке <span class="required">*</span></span>
											<p class="input-text-wrap captcha-size large">
												<input type="text" name="captcha_word" maxlength="50" value="" class="input-text"/>
											</p>
										</label>
										<input type="hidden" name="captcha_sid" value="<?=$arResult["CAPTCHA_CODE"]?>" />
									</div>
								</li>
								<?
							}
							?>
							<li>
								<input type="hidden" name="Register" value="Y"/>
								<button class="yellow-btn2" type="submit"><i class="icon icon-reg2"></i>Регистрация</button>
							</li>
						</ul>
	
					</form>
					<div class="field-info"><span class="required">**</span> Пароль должен быть не менее 6 символов длиной</div>
					<div class="field-info"><span class="required">*</span>&nbsp; Обязательные поля</div>
					<?
				}
				?>
				</div>
		</div>
	</div>
</div>