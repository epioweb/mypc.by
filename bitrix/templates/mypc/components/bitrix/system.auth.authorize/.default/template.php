<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="ordering-wrap login-wrap">
	<div class="double-border-wrap">
		<div class="double-border">
			<div class="login">
				<h2 class="line-header">ВХОД НА САЙТ</h2>
				<?
				ShowMessage($arParams["~AUTH_RESULT"]);
				ShowMessage($arResult['ERROR_MESSAGE']);
				?>

				<form name="form_auth" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
					<input type="hidden" name="AUTH_FORM" value="Y" />
					<input type="hidden" name="AUTH_FORM_PAGE" value="Y">
					<input type="hidden" name="TYPE" value="AUTH" />
					<?if (strlen($arResult["BACKURL"]) > 0):?>
						<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
					<?endif?>
					<?foreach ($arResult["POST"] as $key => $value):?>
						<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
					<?endforeach?>
					
					<table class="login-table fields-table">
						<tr>
							<td><span class="title">Логин</span></td>
							<td>
								<p class="input-text-wrap normal-size large">
									<input type="text" name="USER_LOGIN" maxlength="255" value="<?=$arResult["LAST_LOGIN"]?>" class="input-text" />
								</p>
							</td>
						</tr>
						<tr>
							<td><span class="title">Пароль</span></td>
							<td>
								<p class="input-text-wrap normal-size large">
									<input type="password" name="USER_PASSWORD" maxlength="255"  class="input-text" />
								</p>
							</td>
						</tr>
						<?
						if ($arResult["STORE_PASSWORD"] == "Y")
						{
							?>
							<tr>
								<td></td>
								<td>
									<label class="checkbox-label">
									<input type="checkbox" id="USER_REMEMBER" name="USER_REMEMBER" value="Y" checked class="formstyler"/>
										Запомнить меня на этом компьютере
									</label>
								</td>
							</tr>
							<?
						}
						
						if($arResult["CAPTCHA_CODE"])
						{
							?>
							<tr>
								<td><span class="title"><?echo GetMessage("AUTH_CAPTCHA_PROMT")?></span></td>
								<td>
									<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
									<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br/>
									<p class="input-text-wrap normal-size large" style="width: 162px!important;">
										<input class="input-text" type="text" name="captcha_word" maxlength="50" value="" size="15" />
									</p>
								</td>
							</tr>
							<?
						}
						?>
						<tr>
							<td></td>
							<td class="login-btn-wrap">
								<input type="hidden" name="Login" value="Y" />
								<button type="submit" class="yellow-btn4 login-btn"><i class="icon icon-login2"></i>Войти</button>
							</td>
						</tr>
						<?
						if ($arParams["NOT_SHOW_LINKS"] != "Y")
						{
							?>
							<tr>
								<td></td>
								<td class="links-wrap">
									<noindex>
									<a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow" class="forgot-pass-link">Забыли свой пароль?</a><br/>
									<a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow" class="register-link">Зарегистрироваться</a>
									</noindex>
								</td>
							</tr>
							<?
						}
						?>
						<tr>
							<td></td>
							<td>Если вы впервые на сайте, заполните, пожалуйста, регистрационную форму.</td>
						</tr>
					</table>

				</form>
				<?
				if($arResult["AUTH_SERVICES"])
				{
					?>
					<?$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "",
						array(
							"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
							"CURRENT_SERVICE"=>$arResult["CURRENT_SERVICE"],
							"AUTH_URL"=>$arResult["AUTH_URL"],
							"POST"=>$arResult["POST"],
							"SUFFIX" => "main",
						),
						$component,
						array("HIDE_ICONS"=>"Y")
					);?>
					<?
				}
				?>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
<?if (strlen($arResult["LAST_LOGIN"])>0):?>
try{document.form_auth.USER_PASSWORD.focus();}catch(e){}
<?else:?>
try{document.form_auth.USER_LOGIN.focus();}catch(e){}
<?endif?>
</script>

