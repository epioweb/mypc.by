<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)	die();?>
<script type="text/javascript">
<!--
var opened_sections = [<?
$arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"]."_user_profile_open"];
$arResult["opened"] = preg_replace("/[^a-z0-9_,-]/i", "", $arResult["opened"]);
if (strlen($arResult["opened"]) > 0)
{
	echo "'".implode("', '", explode(",", $arResult["opened"]))."'";
}
else
{
	$arResult["opened"] = "profile-reginfo";
	echo "'reg'";
}
?>];
//-->
var cookie_prefix = '<?=$arResult["COOKIE_PREFIX"]?>';
</script>

<?
$arResult["opened"] = explode(",",$arResult["opened"]);
?>
<div class="cabinet-tabs">
	<div class="cabinet-tab-panes">

		<div class="pane">
			
			<?ShowError($arResult["strProfileError"]);?>
			<?if ($arResult['DATA_SAVED'] == 'Y')ShowNote(GetMessage('PROFILE_DATA_SAVED'));?>
			<form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data">
				<?=$arResult["BX_SESSION_CHECK"]?>
				<input type="hidden" name="lang" value="<?=LANG?>" />
				<input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
				
				<div class="switcher-wrap <?=in_array("profile-reginfo",$arResult["opened"])?"opened":""?>" id="profile-reginfo">
					<h2 class="black-subheader">Регистрационная информация</h2>
					<div class="ordering-wrap registration-wrap">
						<div class="double-border-wrap">
							<div class="double-border">
								<div class="form-fields registration clearfix">
									<?
									if($arResult["ID"]>0)
									{
										?>
										<div class="pull-right registration-info">
											<table class="registration-info-table">
												<?
												if (strlen($arResult["arUser"]["TIMESTAMP_X"])>0)
												{
													?>
													<tr>
														<td>Дата обновления</td>
														<td><?=$arResult["arUser"]["TIMESTAMP_X"]?></td>
													</tr>
													<?
												}
												
												if (strlen($arResult["arUser"]["LAST_LOGIN"])>0)
												{
													?>
													<tr>
														<td>Последняя авторизация</td>
														<td><?=$arResult["arUser"]["LAST_LOGIN"]?></td>
													</tr>
													<?
												}
												?>
											</table>
										</div>
										<?
									}
									?>
									<table class="fields-table registration-table">
										<tr>
											<td><span class="title"><?=GetMessage('NAME')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="NAME" maxlength="50" value="<?=$arResult["arUser"]["NAME"]?>" class="input-text" /></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('LAST_NAME')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="LAST_NAME" maxlength="50" value="<?=$arResult["arUser"]["LAST_NAME"]?>" class="input-text" /></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('SECOND_NAME')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="SECOND_NAME" maxlength="50" value="<?=$arResult["arUser"]["SECOND_NAME"]?>" class="input-text"/></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('EMAIL')?> <span class="required">*</span></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="EMAIL" maxlength="50" value="<? echo $arResult["arUser"]["EMAIL"]?>" class="input-text" /></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('LOGIN')?> <span class="required">*</span></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="LOGIN" maxlength="50" value="<? echo $arResult["arUser"]["LOGIN"]?>" class="input-text"/></p></td>
										</tr>
										<?if($arResult["arUser"]["EXTERNAL_AUTH_ID"] == ''):?>
										<tr>
											<td><span class="title"><?=GetMessage('NEW_PASSWORD_REQ')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" class="input-text"/></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('NEW_PASSWORD_CONFIRM')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off"  class="input-text"/></p></td>
										</tr>
										<?endif?>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
	
				<div class="switcher-wrap <?=in_array("profile-personal",$arResult["opened"])?"opened":""?>" id="profile-personal">
					<h2 class="black-subheader"><?=GetMessage("USER_PERSONAL_INFO")?></h2>
					<div class="ordering-wrap">
						<div class="double-border-wrap">
							<div class="double-border">
								<div class="form-fields clearfix">
									<table class="fields-table registration-table">
										<tr>
											<td><span class="title"><?=GetMessage('USER_PROFESSION')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_PROFESSION" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PROFESSION"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_WWW')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_WWW" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_WWW"]?>" class="input-text"/></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_ICQ')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_ICQ" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_ICQ"]?>" class="input-text"/></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_GENDER')?></span></td>
											<td>
												<p class="select-wrap normal-size large">
													<select name="PERSONAL_GENDER" class="formstyler">
														<option value=""><?=GetMessage("USER_DONT_KNOW")?></option>
														<option value="M"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "M" ? " SELECTED=\"SELECTED\"" : ""?>><?=GetMessage("USER_MALE")?></option>
														<option value="F"<?=$arResult["arUser"]["PERSONAL_GENDER"] == "F" ? " SELECTED=\"SELECTED\"" : ""?>><?=GetMessage("USER_FEMALE")?></option>
													</select>
												</p>
											</td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage("USER_BIRTHDAY_DT")?></span></td>
											<td>
												<p class="input-text-wrap normal-size large date-field">
													<input type="text" name="PERSONAL_BIRTHDAY" value="<?=$arResult["arUser"]["PERSONAL_BIRTHDAY"]?>" class="input-text" id="date-from" />
												</p>
											</td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage("USER_PHOTO")?></span></td>
											<td>
												<?=$arResult["arUser"]["PERSONAL_PHOTO_INPUT"]?>
												<?
												if (strlen($arResult["arUser"]["PERSONAL_PHOTO"])>0)
												{
													?>
														<br />
														<?=$arResult["arUser"]["PERSONAL_PHOTO_HTML"]?>
													<?
												}
												?>
											</td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_PHONE')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_PHONE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>" class="input-text"/></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_FAX')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_FAX" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_FAX"]?>" class="input-text"/></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_MOBILE')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_MOBILE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_MOBILE"]?>"  class="input-text"/></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_PAGER')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_PAGER" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_PAGER"]?>" class="input-text"/></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_COUNTRY')?></span></td>
											<td>
												<p class="select-wrap normal-size large">
													<?=$arResult["COUNTRY_SELECT"]?>
												</p>
											</td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_STATE')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_STATE" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_STATE"]?>" class="input-text"/></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_CITY')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_CITY" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_CITY"]?>" class="input-text"/></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_ZIP')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_ZIP" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_ZIP"]?>" class="input-text"/></p></td>
										</tr>
										<tr>
											<td class="va-top"><span class="title"><?=GetMessage("USER_STREET")?></span></td>
											<td><p class="textarea-wrap normal-size"><textarea rows="5" class="textarea" name="PERSONAL_STREET"><?=$arResult["arUser"]["PERSONAL_STREET"]?></textarea></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_MAILBOX')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="PERSONAL_MAILBOX" maxlength="255" value="<?=$arResult["arUser"]["PERSONAL_MAILBOX"]?>" class="input-text"/></p></td>
										</tr>
										<tr>
											<td class="va-top"><span class="title"><?=GetMessage("USER_NOTES")?></span></td>
											<td><p class="textarea-wrap normal-size"><textarea rows="5" class="textarea" name="PERSONAL_NOTES"><?=$arResult["arUser"]["PERSONAL_NOTES"]?></textarea></p></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<div class="switcher-wrap <?=in_array("profile-work",$arResult["opened"])?"opened":""?>" id="profile-work">
					<h2 class="black-subheader"><?=GetMessage("USER_WORK_INFO")?></h2>
					<div class="ordering-wrap">
						<div class="double-border-wrap">
							<div class="double-border">
								<div class="form-fields clearfix">
									<table class="fields-table registration-table">
										<tr>
											<td><span class="title"><?=GetMessage('USER_COMPANY')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_COMPANY" maxlength="255" value="<?=$arResult["arUser"]["WORK_COMPANY"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_WWW')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_WWW" maxlength="255" value="<?=$arResult["arUser"]["WORK_WWW"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_DEPARTMENT')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_DEPARTMENT" maxlength="255" value="<?=$arResult["arUser"]["WORK_DEPARTMENT"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_POSITION')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_POSITION" maxlength="255" value="<?=$arResult["arUser"]["WORK_POSITION"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td class="va-top"><span class="title"><?=GetMessage("USER_WORK_PROFILE")?></span></td>
											<td><p class="textarea-wrap normal-size"><textarea rows="5" class="textarea" name="WORK_PROFILE"><?=$arResult["arUser"]["WORK_PROFILE"]?></textarea></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage("USER_LOGO")?></span></td>
											<td>
												<?=$arResult["arUser"]["WORK_LOGO_INPUT"]?>
												<?
												if (strlen($arResult["arUser"]["WORK_LOGO"])>0)
												{
													?>
													<br /><?=$arResult["arUser"]["WORK_LOGO_HTML"]?>
													<?
												}
												?>
											</td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_PHONE')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_PHONE" maxlength="255" value="<?=$arResult["arUser"]["WORK_PHONE"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_FAX')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_FAX" maxlength="255" value="<?=$arResult["arUser"]["WORK_FAX"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_PAGER')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_PAGER" maxlength="255" value="<?=$arResult["arUser"]["WORK_PAGER"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_COUNTRY')?></span></td>
											<td>
												<p class="select-wrap normal-size large">
													<?=$arResult["COUNTRY_SELECT_WORK"]?>
												</p>
											</td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_STATE')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_STATE" maxlength="255" value="<?=$arResult["arUser"]["WORK_STATE"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_CITY')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_CITY" maxlength="255" value="<?=$arResult["arUser"]["WORK_CITY"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_ZIP')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_ZIP" maxlength="255" value="<?=$arResult["arUser"]["WORK_ZIP"]?>" class="input-text"></p></td>
										</tr>
										<tr>
											<td class="va-top"><span class="title"><?=GetMessage("USER_STREET")?></span></td>
											<td><p class="textarea-wrap normal-size"><textarea rows="5" class="textarea" name="WORK_STREET"><?=$arResult["arUser"]["WORK_STREET"]?></textarea></p></td>
										</tr>
										<tr>
											<td><span class="title"><?=GetMessage('USER_MAILBOX')?></span></td>
											<td><p class="input-text-wrap normal-size large"><input type="text" name="WORK_MAILBOX" maxlength="255" value="<?=$arResult["arUser"]["WORK_MAILBOX"]?>" class="input-text"></p></td>
										</tr>
										
										
										<tr>
											<td class="va-top"><span class="title"><?=GetMessage("USER_NOTES")?></span></td>
											<td><p class="textarea-wrap normal-size"><textarea rows="5" class="textarea" name="WORK_NOTES"><?=$arResult["arUser"]["WORK_NOTES"]?></textarea></p></td>
										</tr>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				
				<?
				if ($arResult["INCLUDE_FORUM"] == "Y")
				{
					?>
					<div class="switcher-wrap <?=in_array("profile-forum",$arResult["opened"])?"opened":""?>" id="profile-forum">
						<h2 class="black-subheader"><?=GetMessage("forum_INFO")?></h2>
						<div class="ordering-wrap">
							<div class="double-border-wrap">
								<div class="double-border">
									<div class="form-fields clearfix">
										<table class="fields-table registration-table">
											<tr>
												<td colspan="2">
													<label class="checkbox-label" style="display: block;">
														<input type="checkbox" name="forum_SHOW_NAME" value="Y" <?if ($arResult["arForumUser"]["SHOW_NAME"]=="Y") echo "checked=\"checked\"";?> /><?=GetMessage("forum_SHOW_NAME")?>
													</label>
												</td>
											</tr>
											<tr>
												<td><span class="title"><?=GetMessage('forum_DESCRIPTION')?></span></td>
												<td><p class="input-text-wrap normal-size large"><input type="text" name="forum_DESCRIPTION" maxlength="255" value="<?=$arResult["arForumUser"]["DESCRIPTION"]?>" class="input-text"></p></td>
											</tr>
											<tr>
												<td class="va-top"><span class="title"><?=GetMessage('forum_INTERESTS')?></span></td>
												<td><p class="textarea-wrap normal-size"><textarea rows="5" class="textarea" name="forum_INTERESTS"><?=$arResult["arForumUser"]["INTERESTS"]; ?></textarea></p></td>
											</tr>
											<tr>
												<td class="va-top"><span class="title"><?=GetMessage("forum_SIGNATURE")?></span></td>
												<td><p class="textarea-wrap normal-size"><textarea rows="5" class="textarea" name="forum_SIGNATURE"><?=$arResult["arForumUser"]["SIGNATURE"]; ?></textarea></p></td>
											</tr>
											<tr>
												<td class="va-top"><span class="title"><?=GetMessage("forum_AVATAR")?></span></td>
												<td>
												<?=$arResult["arForumUser"]["AVATAR_INPUT"]?>
												<?
												if (strlen($arResult["arForumUser"]["AVATAR"])>0)
												{
												?>
													<br /><?=$arResult["arForumUser"]["AVATAR_HTML"]?>
												<?
												}
												?>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?
				}
				
				
				if ($arResult["INCLUDE_BLOG"] == "Y")
				{
					?>
					<div class="switcher-wrap <?=in_array("profile-blog",$arResult["opened"])?"opened":""?>" id="profile-blog">
						<h2 class="black-subheader"><?=GetMessage("blog_INFO")?></h2>
						<div class="ordering-wrap">
							<div class="double-border-wrap">
								<div class="double-border">
									<div class="form-fields clearfix">
										<table class="fields-table registration-table">
											<tr>
												<td><span class="title"><?=GetMessage('blog_ALIAS')?></span></td>
												<td><p class="input-text-wrap normal-size large"><input type="text" name="blog_ALIAS" maxlength="255" value="<?=$arResult["arBlogUser"]["ALIAS"]?>" class="input-text"></p></td>
											</tr>
											<tr>
												<td><span class="title"><?=GetMessage('blog_DESCRIPTION')?></span></td>
												<td><p class="input-text-wrap normal-size large"><input type="text" name="blog_DESCRIPTION" maxlength="255" value="<?=$arResult["arBlogUser"]["DESCRIPTION"]?>" class="input-text"></p></td>
											</tr>
											<tr>
												<td class="va-top"><span class="title"><?=GetMessage('blog_INTERESTS')?></span></td>
												<td><p class="textarea-wrap normal-size"><textarea rows="5" class="textarea" name="blog_INTERESTS"><?echo $arResult["arBlogUser"]["INTERESTS"]; ?></textarea></p></td>
											</tr>
											<tr>
												<td class="va-top"><span class="title"><?=GetMessage("blog_AVATAR")?></span></td>
												<td>
													<?=$arResult["arBlogUser"]["AVATAR_INPUT"]?>
													<?
													if (strlen($arResult["arBlogUser"]["AVATAR"])>0)
													{
													?>
														<br /><?=$arResult["arBlogUser"]["AVATAR_HTML"]?>
													<?
													}
													?>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?
				}
				
				if ($arResult["INCLUDE_LEARNING"] == "Y")
				{
					?>
					<div class="switcher-wrap <?=in_array("profile-learning",$arResult["opened"])?"opened":""?>" id="profile-learning">
						<h2 class="black-subheader"><?=GetMessage("learning_INFO")?></h2>
						<div class="ordering-wrap">
							<div class="double-border-wrap">
								<div class="double-border">
									<div class="form-fields clearfix">
										<table class="fields-table registration-table">
											<tr>
												<td colspan="2">
													<label class="checkbox-label" style="display: block;">
														<input type="checkbox" name="student_PUBLIC_PROFILE" value="Y" <?if ($arResult["arStudent"]["PUBLIC_PROFILE"]=="Y") echo "checked=\"checked\"";?> /><?=GetMessage("learning_PUBLIC_PROFILE");?>
													</label>
												</td>
											</tr>
											<tr>
												<td class="va-top"><span class="title"><?=GetMessage("learning_RESUME");?></span></td>
												<td><p class="textarea-wrap normal-size"><textarea rows="5" class="textarea" name="student_RESUME"><?=$arResult["arStudent"]["RESUME"]; ?></textarea></p></td>
											</tr>
											<tr>
												<td class="va-top"><span class="title"><?=GetMessage("learning_TRANSCRIPT");?></span></td>
												<td>
													<?=$arResult["arStudent"]["TRANSCRIPT"];?>-<?=$arResult["ID"]?>
												</td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?
				}
				
				if($arResult["IS_ADMIN"])
				{
					?>
					<div class="switcher-wrap <?=in_array("profile-admin",$arResult["opened"])?"opened":""?>" id="profile-admin">
						<h2 class="black-subheader"><?=GetMessage("USER_ADMIN_NOTES")?></h2>
						<div class="ordering-wrap">
							<div class="double-border-wrap">
								<div class="double-border">
									<div class="form-fields clearfix">
										<table class="fields-table registration-table">
											<tr>
												<td class="va-top"><span class="title"><?=GetMessage("USER_ADMIN_NOTES")?></span></td>
												<td><p class="textarea-wrap normal-size"><textarea rows="5" class="textarea" name="ADMIN_NOTES"><?=$arResult["arUser"]["ADMIN_NOTES"]?></textarea></p></td>
											</tr>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?
				}
				
				if($arResult["USER_PROPERTIES"]["SHOW"] == "Y")
				{
					?>
					<div class="switcher-wrap <?=in_array("profile-props",$arResult["opened"])?"opened":""?>" id="profile-props">
						<h2 class="black-subheader"><?=strlen(trim($arParams["USER_PROPERTY_NAME"])) > 0 ? $arParams["USER_PROPERTY_NAME"] : GetMessage("USER_TYPE_EDIT_TAB")?></h2>
						<div class="ordering-wrap">
							<div class="double-border-wrap">
								<div class="double-border">
									<div class="form-fields clearfix">
										<table class="fields-table registration-table">
											<?
											foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField)
											{
												?>
												<tr>
													<td class="va-top">
														<span class="title"><?=$arUserField["EDIT_FORM_LABEL"]?></span>
														<?if ($arUserField["MANDATORY"]=="Y"):?>
															<span class="required">*</span>
														<?endif;?>
													</td>
													<td>
														<?$APPLICATION->IncludeComponent(
															"bitrix:system.field.edit",
															$arUserField["USER_TYPE"]["USER_TYPE_ID"],
														array("bVarsFromForm" => $arResult["bVarsFromForm"], "arUserField" => $arUserField), null, array("HIDE_ICONS"=>"Y"));?>
													</td>
												</tr>
												<?
											}
											?>
										</table>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?
				}
				?>
				<br/>
				<p>Пароль должен быть не менее 6 символов длиной.</p>
				<br/>
				<input type="hidden" name="save" value="Y"/>
				<button class="grey-btn3 size-142" style="margin-right: 20px;" type="submit"><span><?=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))?></span></button>
				<button type="reset" class="grey-btn3 size-142"><span><?=GetMessage('MAIN_RESET');?></span></button>
				<br/><br/><br/>
			</form>
			<?
			if($arResult["SOCSERV_ENABLED"])
			{
				?>
				<?
				$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", ".default", array(
					"SHOW_PROFILES" => "Y",
					"ALLOW_DELETE" => "Y"
				),
					false
				);
			}
			?>
		</div>
	</div>

</div>