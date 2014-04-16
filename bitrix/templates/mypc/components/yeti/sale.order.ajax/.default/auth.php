<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<script>
<!--
function ChangeGenerate(val)
{
	if(val)
	{
		document.getElementById("sof_choose_login").style.display='none';
	}
	else
	{
		document.getElementById("sof_choose_login").style.display='block';
		document.getElementById("NEW_GENERATE_N").checked = true;
	}

	try{document.order_reg_form.NEW_LOGIN.focus();}catch(e){}
}
//-->
</script>
<div id="order_form_div" class="order-checkout">
                <div class="checkout-auth-cols clearfix">
	<ul class="left-col">
		<li><h2 class="black-subheader grey"><i class="icon-login3"></i><?if($arResult["AUTH"]["new_user_registration"]=="Y"):?><?echo GetMessage("STOF_2REG")?><?endif;?></h2></li>
		<li>
			<div class="ordering-wrap checkout-auth-wrap">
				<div class="double-border-wrap">
					<div class="double-border">
						<div class="in">
							<form method="post" action="" name="order_auth_form">
								<?=bitrix_sessid_post()?>
								<?foreach ($arResult["POST"] as $key => $value){?><input type="hidden" name="<?=$key?>" value="<?=$value?>" /><?}?>
								<ul>
									<li>
										<?echo GetMessage("STOF_LOGIN_PROMT")?>
									</li>
									<li>
										<label>
											<span class="title">Эл. почта</span>
											<p class="input-text-wrap normal-size"><input type="text" name="USER_LOGIN" maxlength="30" value="<?=$arResult["AUTH"]["USER_LOGIN"]?>" class="input-text" /></p>
										</label>
									</li>
									<li>
										<label>
											<span class="title">Пароль</span>
											<p class="input-text-wrap normal-size"><input type="password" name="USER_PASSWORD" maxlength="30" class="input-text" /></p>
										</label>
									</li>
									<li>
										<a href="<?=$arParams["PATH_TO_AUTH"]?>?forgot_password=yes&back_url=<?= urlencode($APPLICATION->GetCurPageParam()); ?>"><?echo GetMessage("STOF_FORGET_PASSWORD")?></a>
									</li>
									<li>
										<button type="submit" class="yellow-btn6"><?echo GetMessage("STOF_NEXT_STEP")?></button>
										<input type="hidden" name="do_authorize" value="Y">
									</li>
								</ul>
							</form>
						</div>
					</div>
				</div>
			</div>
		</li>
	</ul>
	<ul class="right-col">
		<li><h2 class="black-subheader grey"><i class="icon-reg3"></i><?if($arResult["AUTH"]["new_user_registration"]=="Y"):?><?echo GetMessage("STOF_2NEW")?><?endif;?></h2></li>
		<li>
			<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?>
			<div class="ordering-wrap checkout-auth-wrap">
				<div class="double-border-wrap">
					<div class="double-border">
						<div class="in">
							<form method="post" action="" name="order_reg_form">
								<?=bitrix_sessid_post()?>
								<?foreach ($arResult["POST"] as $key => $value){?><input type="hidden" name="<?=$key?>" value="<?=$value?>" /><?}?>
								<ul>
									<li>
										<label>
											<span class="title"><?echo GetMessage("STOF_NAME")?></span>
											<p class="input-text-wrap normal-size"><input type="text" name="NEW_NAME" size="40" value="<?=$arResult["AUTH"]["NEW_NAME"]?>" class="input-text" /></p>
										</label>
									</li>
									<li>
										<label>
											<span class="title"><?echo GetMessage("STOF_LASTNAME")?></span>
											<p class="input-text-wrap normal-size"><input type="text" name="NEW_LAST_NAME" size="40" value="<?=$arResult["AUTH"]["NEW_LAST_NAME"]?>" class="input-text" /></p>
										</label>
									</li>
									<li>
										<label>
											<span class="title">E-Mail</span>
											<p class="input-text-wrap normal-size"><input type="text" name="NEW_EMAIL" size="40" value="<?=$arResult["AUTH"]["NEW_EMAIL"]?>" class="input-text" /></p>
										</label>
									</li>
									<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
										<li>
											<label>
												<p class="radio-wrap">
													<label><input type="radio" id="NEW_GENERATE_N" name="NEW_GENERATE" value="N" OnClick="ChangeGenerate(false)"<?if ($_POST["NEW_GENERATE"] == "N") echo " checked";?> /> Задать пароль</label>
													<label><input type="radio" id="NEW_GENERATE_Y" name="NEW_GENERATE" value="Y" OnClick="ChangeGenerate(true)"<?if ($POST["NEW_GENERATE"] != "N") echo " checked";?> /> Сгенерировать пароль автоматически</label>
												</p>
											</label>
										</li>
									<?endif;?>
								</ul>
								
								
								
								<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
									<div id="sof_choose_login">
								<?endif;?>
									<ul>
										<li>
											<label>
												<span class="title"><?echo GetMessage("STOF_PASSWORD")?></span>
												<p class="input-text-wrap normal-size"><input type="password" name="NEW_PASSWORD" class="input-text" autocomplete="off" /></p>
											</label>
										</li>
										<li>
											<label>
												<span class="title"><?echo GetMessage("STOF_RE_PASSWORD")?></span>
												<p class="input-text-wrap normal-size"><input type="password" name="NEW_PASSWORD_CONFIRM" class="input-text" autocomplete="off" /></p>
											</label>
										</li>
									</ul>
								<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
									</div>
								<?endif;?>
								
								
								<?if($arResult["AUTH"]["new_user_registration_email_confirmation"] != "Y"):?>
									<script language="JavaScript">
									<!--
									ChangeGenerate(<?= (($_POST["NEW_GENERATE"] != "N") ? "true" : "false") ?>);
									//-->
									</script>
								<?endif;?>
								<?
								if($arResult["AUTH"]["captcha_registration"] == "Y") //CAPTCHA
								{
									?>
									<ul class="captcha-wrap2">
										<li>
											<?=GetMessage("CAPTCHA_REGF_TITLE")?><br/>
											<input type="hidden" name="captcha_sid" value="<?=$arResult["AUTH"]["capCode"]?>">
											<img src="/bitrix/tools/captcha.php?captcha_sid=<?=$arResult["AUTH"]["capCode"]?>" width="180" height="40" alt="CAPTCHA">
											<label>
												<span class="title"><?=GetMessage("CAPTCHA_REGF_PROMT")?></span>
												<p class="input-text-wrap normal-size"><input type="text" name="captcha_word" maxlength="50" value="" class="input-text" autocomplete="off" /></p>
											</label>
										</li>
									</ul>
									<?
								}
								?>
								<ul>
									<li>	
										<button type="submit" class="yellow-btn6"><?echo GetMessage("STOF_NEXT_STEP")?></button>
										<input type="hidden" name="do_register" value="Y">
									</li>
									<li>
										<?if($arResult["AUTH"]["new_user_registration"]=="Y"):?><?echo GetMessage("STOF_EMAIL_NOTE")?><?endif;?>
									</li>
									<li>
										<?echo GetMessage("STOF_PRIVATE_NOTES")?>
									</li>
								</ul>
								
							</form>
						</div>
					</div>
				</div>
			</div>
			<?endif;?>
		</li>
	</ul>
</div>
</div>
