<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if($arResult["FORM_TYPE"] == "login")
{
	?>
	<div id="login-and-reg-links">
		<a href="<?=$arParams["REGISTER_URL"]?>" class="reg-link">
			<i class="icon icon-reg"></i>
			<span>Регистрация</span>
		</a>
		<a href="/auth/" class="login-link popup-link" rel="#login-window">
			<i class="icon icon-login"></i>
			<span>Логин</span>
		</a>
	</div>
	<?
	$showErrors = ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'] && $_REQUEST["forgot_password"] != "yes" && $_REQUEST["change_password"] != "yes" && $_REQUEST["register"] != "yes" && $_REQUEST["AUTH_FORM_PAGE"] != "Y");
	
	
	if($arParams["AJAX_LOGIN"] != "Y") ob_start();
	?>
	<!-- Callback Window ------------------------------------------------------>
	<div id="login-window" class="overlay callback-window">
		<div class="callback-window2">
		    <div class="overlay-header">
		        <h3>АВТОРИЗАЦИЯ</h3>
		    </div>
		    <div class="overlay-body center">
		    	<div class="b-login-form-wr">
		    		<?
		    		if($arParams["AJAX_LOGIN"] == "Y")
					{
						$GLOBALS['APPLICATION']->RestartBuffer(); 
						ob_start();
					}
					?>
			        <form class="overlay-callback-form" name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
			        	<?if($arResult["BACKURL"] <> ''):?>
							<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
						<?endif?>
						<?foreach ($arResult["POST"] as $key => $value):?>
							<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
						<?endforeach?>
						<input type="hidden" name="AUTH_FORM" value="Y" />
						<input type="hidden" name="TYPE" value="AUTH" />
						
						<?
						if ($showErrors)
						{
							$arResult['ERROR_MESSAGE']["MESSAGE"] = preg_replace("#логин#u","адрес электронной почты",$arResult['ERROR_MESSAGE']["MESSAGE"]);
							?>
							<style>
							#login-window .overlay-header{padding-bottom:0px;}
							</style>
							<div class="very-important-message" style="padding:10px;color: #a00;font-size: 12pt;">
								<p style="margin:0;padding:0;"><?=$arResult['ERROR_MESSAGE']["MESSAGE"]?></p>
							</div>
							<?
							if($arParams["AJAX_LOGIN"] != "Y")
							{
								?>
								<script>
								$(function(){
									$(".login-link.popup-link").click();
								});
								</script>
								<?
							}
						}
						?>
						<div class="field" style="margin-bottom: 12px;">
			        		<span class="title">Электронная почта:</span>
			                <p class="input-text-wrap callback-size">
			                	<input  class="input-text" type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>"/>
			                </p>
			            </div>
			            
			            <div class="field" style="margin-bottom: 12px;color:#fff;">
			                <span class="title">Пароль:</span>
			                <p class="input-text-wrap callback-size">
			                	<input type="password" class="input-text" name="USER_PASSWORD" maxlength="50"/>
			                </p>
			                 <p class="checkbox-wrap" style="margin-top: 10px">
								<label><input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" /><span class="item">Запомнить меня</span></label>
								<noindex style="float:right;"><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow">Забыли?</a></noindex>
							</p>
			            </div>
			            
			            <?if($arResult["CAPTCHA_CODE"]):?>
							<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
							<div class="field" style="margin-bottom: 12px;">
				                <span class="title">Введите код с картинки:</span>
				                <img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="120" height="40" alt="CAPTCHA" />
				                <p class="input-text-wrap callback-size" style="float: right;width: 95px!important;height: 37px;">
				                	<input type="text" name="captcha_word" maxlength="50" value="" class="input-text" style="font-size: 16pt;" />
				                </p>
				            </div>
						<?endif?>
			            <div class="field callback-btn-wrap" style="margin:0 0 12px;">
			            	<button type="submit" id="login-btn" class="yellow-btn3"><span>Войти</span></button>
			            </div>
			            <input type="hidden" name="Login" value="Y" />
			        </form>
			        <?
					if($arParams["AJAX_LOGIN"] == "Y")
					{
						echo ob_get_clean();
						return;
					}
					?>
		        </div>
		    </div>
	    </div>
	</div>
	<!-- End Callback Window -->
	<?
	if($arParams["AJAX_LOGIN"] != "Y")
	{
		$html = ob_get_clean();
		$APPLICATION->AddViewContent("footer_contents", $html);
	}	
}
else
{
	?>
	<div id="login-and-reg-links">
		<a href="<?=$arResult["PROFILE_URL"]?>" class="reg-link" title="<?=GetMessage("AUTH_PROFILE")?>">
			<i class="icon icon-reg"></i>
			<span><?=$arResult["USER_NAME"]?></span>
		</a>
		&nbsp;<a href="?logout=yes" title="Выйти" style="padding-right:3px;"><img style="vertical-align: top;" src="<?=SITE_TEMPLATE_PATH?>/images/exit-link.png" /></a>
	</div>
	<?
	if($arParams["AJAX_LOGIN"] == "Y")
	{
		$GLOBALS['APPLICATION']->RestartBuffer();
		?>
		<div class="success" style="color:#fff;">
			<p>Вы авторизованы!</p>
			<p>Вы можете войти в личный кабинет<br/>
				или перейти к просмотру сайта</p>
		</div>
		<script>
		setTimeout("location.reload();",2000);
		</script>
		<?
		return;
	}
}
?>











<?
return;
?>
<div class="bx-system-auth-form">
<?if($arResult["FORM_TYPE"] == "login"):?>

<?
if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR'])
	ShowMessage($arResult['ERROR_MESSAGE']);
?>

<form name="system_auth_form<?=$arResult["RND"]?>" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
<?if($arResult["BACKURL"] <> ''):?>
	<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
<?endif?>
<?foreach ($arResult["POST"] as $key => $value):?>
	<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
<?endforeach?>
	<input type="hidden" name="AUTH_FORM" value="Y" />
	<input type="hidden" name="TYPE" value="AUTH" />
	<table width="95%">
		<tr>
			<td colspan="2">
			<?=GetMessage("AUTH_LOGIN")?>:<br />
			<input type="text" name="USER_LOGIN" maxlength="50" value="<?=$arResult["USER_LOGIN"]?>" size="17" /></td>
		</tr>
		<tr>
			<td colspan="2">
			<?=GetMessage("AUTH_PASSWORD")?>:<br />
			<input type="password" name="USER_PASSWORD" maxlength="50" size="17" />
<?if($arResult["SECURE_AUTH"]):?>
				<span class="bx-auth-secure" id="bx_auth_secure<?=$arResult["RND"]?>" title="<?echo GetMessage("AUTH_SECURE_NOTE")?>" style="display:none">
					<div class="bx-auth-secure-icon"></div>
				</span>
				<noscript>
				<span class="bx-auth-secure" title="<?echo GetMessage("AUTH_NONSECURE_NOTE")?>">
					<div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
				</span>
				</noscript>
<script type="text/javascript">
document.getElementById('bx_auth_secure<?=$arResult["RND"]?>').style.display = 'inline-block';
</script>
<?endif?>
			</td>
		</tr>
<?if ($arResult["STORE_PASSWORD"] == "Y"):?>
		<tr>
			<td valign="top"><input type="checkbox" id="USER_REMEMBER_frm" name="USER_REMEMBER" value="Y" /></td>
			<td width="100%"><label for="USER_REMEMBER_frm" title="<?=GetMessage("AUTH_REMEMBER_ME")?>"><?echo GetMessage("AUTH_REMEMBER_SHORT")?></label></td>
		</tr>
<?endif?>
<?if ($arResult["CAPTCHA_CODE"]):?>
		<tr>
			<td colspan="2">
			<?echo GetMessage("AUTH_CAPTCHA_PROMT")?>:<br />
			<input type="hidden" name="captcha_sid" value="<?echo $arResult["CAPTCHA_CODE"]?>" />
			<img src="/bitrix/tools/captcha.php?captcha_sid=<?echo $arResult["CAPTCHA_CODE"]?>" width="180" height="40" alt="CAPTCHA" /><br /><br />
			<input type="text" name="captcha_word" maxlength="50" value="" /></td>
		</tr>
<?endif?>
		<tr>
			<td colspan="2"><input type="submit" name="Login" value="<?=GetMessage("AUTH_LOGIN_BUTTON")?>" /></td>
		</tr>
<?if($arResult["NEW_USER_REGISTRATION"] == "Y"):?>
		<tr>
			<td colspan="2"><noindex><a href="<?=$arResult["AUTH_REGISTER_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_REGISTER")?></a></noindex><br /></td>
		</tr>
<?endif?>

		<tr>
			<td colspan="2"><noindex><a href="<?=$arResult["AUTH_FORGOT_PASSWORD_URL"]?>" rel="nofollow"><?=GetMessage("AUTH_FORGOT_PASSWORD_2")?></a></noindex></td>
		</tr>
<?if($arResult["AUTH_SERVICES"]):?>
		<tr>
			<td colspan="2">
				<div class="bx-auth-lbl"><?=GetMessage("socserv_as_user_form")?></div>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "icons", 
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"SUFFIX"=>"form",
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);
?>
			</td>
		</tr>
<?endif?>
	</table>
</form>

<?if($arResult["AUTH_SERVICES"]):?>
<?
$APPLICATION->IncludeComponent("bitrix:socserv.auth.form", "", 
	array(
		"AUTH_SERVICES"=>$arResult["AUTH_SERVICES"],
		"AUTH_URL"=>$arResult["AUTH_URL"],
		"POST"=>$arResult["POST"],
		"POPUP"=>"Y",
		"SUFFIX"=>"form",
	), 
	$component, 
	array("HIDE_ICONS"=>"Y")
);
?>
<?endif?>

<?
//if($arResult["FORM_TYPE"] == "login")
else:
?>

<form action="<?=$arResult["AUTH_URL"]?>">
	<table width="95%">
		<tr>
			<td align="center">
				<?=$arResult["USER_NAME"]?><br />
				[<?=$arResult["USER_LOGIN"]?>]<br />
				<a href="<?=$arResult["PROFILE_URL"]?>" title="<?=GetMessage("AUTH_PROFILE")?>"><?=GetMessage("AUTH_PROFILE")?></a><br />
			</td>
		</tr>
		<tr>
			<td align="center">
			<?foreach ($arResult["GET"] as $key => $value):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endforeach?>
			<input type="hidden" name="logout" value="yes" />
			<input type="submit" name="logout_butt" value="<?=GetMessage("AUTH_LOGOUT_BUTTON")?>" />
			</td>
		</tr>
	</table>
</form>
<?endif?>
</div>