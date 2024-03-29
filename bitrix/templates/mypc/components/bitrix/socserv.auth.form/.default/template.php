<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)	die();
$arAuthServices = $arPost = array();
if(is_array($arParams["~AUTH_SERVICES"]))
{
	$arAuthServices = $arParams["~AUTH_SERVICES"];
}
if(is_array($arParams["~POST"]))
{
	$arPost = $arParams["~POST"];
}
?>
<?
if($arParams["POPUP"]):
	//only one float div per page
	if(defined("BX_SOCSERV_POPUP"))
		return;
	define("BX_SOCSERV_POPUP", true);
?>
<div style="display:none">
<div id="bx_auth_float" class="bx-auth-float">
<?endif?>

<?if(($arParams["~CURRENT_SERVICE"] <> '') && $arParams["~FOR_SPLIT"] != 'Y'):?>
<script type="text/javascript">
BX.ready(function(){BxShowAuthServiceMyPC('<?=CUtil::JSEscape($arParams["~CURRENT_SERVICE"])?>', '<?=$arParams["~SUFFIX"]?>')});
</script>
<?endif?>
<?
if($arParams["~FOR_SPLIT"] == 'Y'):?>
<div class="bx-auth-serv-icons">
	<?foreach($arAuthServices as $service):?>
	<?
	if(($arParams["~FOR_SPLIT"] == 'Y') && (is_array($service["FORM_HTML"])))
		$onClickEvent = $service["FORM_HTML"]["ON_CLICK"];
	else
		$onClickEvent = "onclick=\"BxShowAuthServiceMyPC('".$service['ID']."', '".$arParams['SUFFIX']."')\"";
	?>
	<a title="<?=htmlspecialcharsbx($service["NAME"])?>" href="javascript:void(0)" <?=$onClickEvent?> id="bx_auth_href_<?=$arParams["SUFFIX"]?><?=$service["ID"]?>"><i class="bx-ss-icon <?=htmlspecialcharsbx($service["ICON"])?>"></i></a>
	<?endforeach?>
</div>
<?endif;?>
<div class="bx-auth">
	<form method="post" name="bx_auth_services<?=$arParams["SUFFIX"]?>" target="_top" action="<?=$arParams["AUTH_URL"]?>">
	
		<?if($arParams["~SHOW_TITLES"] != 'N'):?>
			<h2 class="line-header"><?=GetMessage("socserv_as_user")?></h2>
		<?endif;?>
		
		<?if($arParams["~FOR_SPLIT"] != 'Y'):?>
			<?
			$arAssocClasses = array(
				"Livejournal" => "soc-lj",
				"YandexOpenID" => "soc-ya",
				"MailRuOpenID" => "soc-mr",
				"Liveinternet" => "soc-li",
				"Blogger" => "soc-bl",
				"OpenID" => "soc-op",
			);
			?>
			<div class="social-logins">
				<?
				$i = 0;
				foreach($arAuthServices as $service)
				{
					if($i > 0 && $i%3 == 0) echo "<br/>";
					$sClass = $arAssocClasses[$service["ID"]];
					?>
					<a onclick="BxShowAuthServiceMyPC('<?=$service["ID"]?>', '<?=$arParams["SUFFIX"]?>')" id="bx_auth_href_<?=$arParams["SUFFIX"]?><?=$service["ID"]?>" href="javascript:void(0)" class="social-login-btn"><i class="<?=$sClass?>"></i><?=htmlspecialcharsbx($service["NAME"])?></a>
					<?
				}
				?>
			</div>
		<?endif;?>
		
		<?if($arParams["~AUTH_LINE"] != 'N'):?>
			<div class="bx-auth-line"></div>
		<?endif;?>
		<div class="bx-auth-service-form" id="bx_auth_serv<?=$arParams["SUFFIX"]?>" style="display:none">
			<?foreach($arAuthServices as $service):?>
				<?if(($arParams["~FOR_SPLIT"] != 'Y') || (!is_array($service["FORM_HTML"]))):?>
					<div id="bx_auth_serv_<?=$arParams["SUFFIX"]?><?=$service["ID"]?>" style="display:none"><?=$service["FORM_HTML"]?></div>
				<?endif;?>
			<?endforeach?>
		</div>
		<?foreach($arPost as $key => $value):?>
			<?if(!preg_match("|OPENID_IDENTITY|", $key)):?>
				<input type="hidden" name="<?=$key?>" value="<?=$value?>" />
			<?endif;?>
		<?endforeach?>
		<input type="hidden" name="auth_service_id" value="" />
	</form>
</div>

<?if($arParams["POPUP"]):?>
</div>
</div>
<?endif?>