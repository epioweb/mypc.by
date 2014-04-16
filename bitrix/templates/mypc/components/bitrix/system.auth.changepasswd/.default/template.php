<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="ordering-wrap pass-recover-wrap">
	<div class="double-border-wrap">
		<div class="double-border">
			<div class="pass-recover">

				<form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
					<?ShowMessage($arParams["~AUTH_RESULT"]);?>
					<?if (strlen($arResult["BACKURL"]) > 0): ?>
					<input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
					<? endif ?>
					<input type="hidden" name="AUTH_FORM" value="Y">
					<input type="hidden" name="TYPE" value="CHANGE_PWD">
					
					<table class="pass-recover-table fields-table">
						<tr>
							<td><span class="title"><?=GetMessage("AUTH_LOGIN")?></span></td>
							<td>
								<p class="input-text-wrap normal-size large">
									<input type="text" name="USER_LOGIN" maxlength="50" class="input-text" value="<?=$arResult["LAST_LOGIN"]?>" />
								</p>
							</td>
						</tr>
						<tr>
							<td><span class="title"><?=GetMessage("AUTH_CHECKWORD")?></span></td>
							<td>
								<p class="input-text-wrap normal-size large">
									<input type="text" name="USER_CHECKWORD" maxlength="50" class="input-text" value="<?=$arResult["USER_CHECKWORD"]?>" />
								</p>
							</td>
						</tr>
						<tr>
							<td><span class="title"><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?></span></td>
							<td>
								<p class="input-text-wrap normal-size large">
									<input type="password" name="USER_PASSWORD" maxlength="50" class="input-text" value="<?=$arResult["USER_PASSWORD"]?>" />
								</p>
								<div><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></div>
							</td>
						</tr>
						
						<tr>
							<td><span class="title"><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?></span></td>
							<td>
								<p class="input-text-wrap normal-size large">
									<input type="password" name="USER_CONFIRM_PASSWORD" maxlength="50" class="input-text" value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>"  />
								</p>
								<div><?echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];?></div>
							</td>
						</tr>
						
						<tr>
							<td></td>
							<td class="recover-btn-wrap">
								<input type="hidden" name="change_pwd" value="Y" />
								<button class="yellow-btn4 recover-btn"><i class="icon icon-recover2"></i>Изменить</button>
							</td>
						</tr>
						<tr>
							<td></td>
							<td class="links-wrap">
								<a href="<?=$arResult["AUTH_AUTH_URL"]?>" class="auth-link">Авторизация</a>
							</td>
						</tr>
					</table>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
document.bform.USER_LOGIN.focus();
</script>