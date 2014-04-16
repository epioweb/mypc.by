<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
$arResult["PROPERTY_LIST"] = $arParams["PROPERTY_CODES"];
if (strlen($arResult["MESSAGE"]) > 0 && $arParams["AJAX_CALLBACK"] == "Y")
{
	?>
	<div class="success" style="font-size: 12pt;color: #fff;">
		<p>Благодарим Вас за обращение!</p>
		<p>В указанное Вами время<br/> менеджер свяжется с Вами!</p>
	</div>
	<script>
	setTimeout("location.reload();",3000);
	</script>
	<?
	return;
}
?>
<script>
$(function(){
	$("#callback-btn").live("click",function(){
		$("#callback-product").val("");
		$("#callback-product").closest("div.label").hide();
	});
});
</script>
<a href="#" class="popup-link" rel="#callback-window" id="callback-btn">Заказать обратный звонок</a>
<?
if($arParams["AJAX_CALLBACK"] != "Y")
{
	ob_start();
}
?>
<!-- Callback Window ------------------------------------------------------>
<div id="callback-window" class="overlay callback-window">
	<div class="callback-window2">
	    <div class="overlay-header">
	        <h3><i class="icon icon-callback2"></i><span>ОБРАТНЫЙ ЗВОНОК</span></h3>
	    </div>
	    <div class="overlay-body center">
	    	<?
			if (strlen($arResult["MESSAGE"]) > 0)
			{
				?>
				<div class="success" style="font-size: 12pt;color: #fff;">
					<p>Благодарим Вас за обращение!</p>
					<p>В указанное Вами время<br/> менеджер свяжется с Вами!</p>
				</div>
				<script>
				$(function(){
					$("#callback-btn").click();
				});
				</script>
				<?
			}
			else
			{
				?>
				<div class="b-callback-wr">
					<?
					if($arParams["AJAX_CALLBACK"] == "Y")
					{
						$GLOBALS['APPLICATION']->RestartBuffer(); 
						ob_start();
					}
					?>
					<form class="overlay-callback-form" id="callback-form" name="iblock_add" action="<?=POST_FORM_ACTION_URI?>" method="post" enctype="multipart/form-data">
						<?
						if (count($arResult["ERRORS"]) > 0)
						{
							$errorStr = implode("<br/>",$arResult["ERRORS"]);
							?>
							<div class="very-important-message" style="padding:10px;color:#c03;font-size:11pt;">
								<p style="margin:0;padding:0;"><?=$errorStr?></p>
							</div>
							<style>
								#callback-window .overlay-header{padding-bottom: 0!important;}
							</style>
							<?
							if($arParams["AJAX_CALLBACK"] != "Y")
							{
								?>
								<script>
								$(function(){
									$("#callback-btn").click();
								});
								</script>
								<?
							}
						}
						?>
						<?=bitrix_sessid_post()?>
						<?if ($arParams["MAX_FILE_SIZE"] > 0):?><input type="hidden" name="MAX_FILE_SIZE" value="<?=$arParams["MAX_FILE_SIZE"]?>" /><?endif?>
						<?
						if (is_array($arResult["PROPERTY_LIST"]) && !empty($arResult["PROPERTY_LIST"]))
						{
							foreach ($arResult["PROPERTY_LIST"] as $propertyID)
							{
								
								$propertyCode = $arResult["PROPERTY_LIST_FULL"][$propertyID]["CODE"];
								if($propertyCode == "PRODUCT")
								{
									?>
									<div class="field product-title" style="display:none;">
										<span class="title"><?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]?>: <span id="callback-product-title"></span></span>
										<input type="hidden" name="PROPERTY[<?=$propertyID?>][0]" value="" id="callback-product" />
									</div>
									<?
									continue;
								}
								?>
								<div class="field">
									<span class="title">
										<?if (intval($propertyID) > 0):?>
											<?=$arResult["PROPERTY_LIST_FULL"][$propertyID]["NAME"]?>:
										<?else:
											if($propertyID == "NAME") $arParams["CUSTOM_TITLE_".$propertyID] = "Введите Ваш телефон.";
											?>
											<?=!empty($arParams["CUSTOM_TITLE_".$propertyID]) ? $arParams["CUSTOM_TITLE_".$propertyID] : GetMessage("IBLOCK_FIELD_".$propertyID)?>:
										<?endif?>
									</span>
									<?
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
									$inputNum = 1;
									if($arResult["PROPERTY_LIST_FULL"][$propertyID]["GetPublicEditHTML"])
										$INPUT_TYPE = "USER_TYPE";
									else
										$INPUT_TYPE = $arResult["PROPERTY_LIST_FULL"][$propertyID]["PROPERTY_TYPE"];
	
									switch ($INPUT_TYPE):
										case "S":
										case "N":
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
											<p class="input-text-wrap callback-size"><input type="text" name="PROPERTY[<?=$propertyID?>][<?=$i?>]" class="input-text"  value="<?=$value?>"  /></p>
											<?
											}
										break;
									endswitch;?>
								</div>
								<?
							}
						}
						?>
						<input type="hidden" name="iblock_submit" value="Y" />
						<div class="field callback-btn-wrap">
							<button type="submit" class="yellow-btn3" >Заказать звонок</button>
			            </div>
					</form>
					<?
					if($arParams["AJAX_CALLBACK"] == "Y")
					{
						echo ob_get_clean();
						return;
					}
					?>
				</div>
				<?
			}
			?>
	    </div>
    </div>
</div>
<!-- End Callback Window -->
<?
if($arParams["AJAX_CALLBACK"] != "Y")
{
	$htmlPopup = ob_get_clean();
	$APPLICATION->AddViewContent("footer_contents", $htmlPopup);
}
?>