<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="ordering-wrap pass-recover-wrap">
	<div class="double-border-wrap">
		<div class="double-border">
			<div class="pass-recover">
				
				<?ShowMessage($arParams["~AUTH_RESULT"]);?>

				<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
					<?
					if (strlen($arResult["BACKURL"]) > 0)
					{
						?><input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" /><?
					}
					?>
					<input type="hidden" name="AUTH_FORM" value="Y">
					<input type="hidden" name="TYPE" value="SEND_PWD">
					<table class="pass-recover-table fields-table">
						<tr class="pass-recover-header">
							<td><img src="<?=SITE_TEMPLATE_PATH?>/images/lock.png" alt="" /></td>
							<td><?=GetMessage("AUTH_FORGOT_PASSWORD_1")?></td>
						</tr>
						<tr>
							<td><span class="title">Логин</span></td>
							<td>
								<p class="input-text-wrap normal-size large">
									<input type="text" name="USER_LOGIN" maxlength="50" class="input-text" value="<?=$arResult["LAST_LOGIN"]?>" />
								</p>
								<span style="padding-left: 10px;">или</span>
							</td>
						</tr>
						<tr>
							<td><span class="title">E-mail</span></td>
							<td>
								<p class="input-text-wrap normal-size large">
									<input type="text" name="USER_EMAIL" maxlength="255" class="input-text"/>
								</p>
							</td>
						</tr>
						<tr>
							<td></td>
							<td class="recover-btn-wrap">
								<input type="hidden" name="send_account_info" value="Y" />
								<button class="yellow-btn4 recover-btn"><i class="icon icon-recover2"></i>Выслать</button>
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