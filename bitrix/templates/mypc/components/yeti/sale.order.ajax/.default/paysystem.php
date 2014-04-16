<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<label>
	<span class="title">Способ оплаты</span>
	<p class="radio-wrap">
		<?
		foreach($arResult["PAY_SYSTEM"] as $arPaySystem)
		{
			if(count($arResult["PAY_SYSTEM"]) == 1)
			{
				?>
				<input type="hidden" name="PAY_SYSTEM_ID" value="<?=$arPaySystem["ID"]?>">
				<?=$arPaySystem["NAME"];?>
				<?
				if (strlen($arPaySystem["DESCRIPTION"])>0)
				{
					?><br /><?=$arPaySystem["DESCRIPTION"]?><?
				}
			}
			else
			{
				if (!isset($_POST['PAY_CURRENT_ACCOUNT']) OR $_POST['PAY_CURRENT_ACCOUNT'] == "N")
				{
					?>
					<label>
						<input type="radio" id="ID_PAY_SYSTEM_ID_<?= $arPaySystem["ID"] ?>" name="PAY_SYSTEM_ID" value="<?= $arPaySystem["ID"] ?>"<?if ($arPaySystem["CHECKED"]=="Y") echo " checked=\"checked\"";?>>
						<?= $arPaySystem["PSA_NAME"] ?>
						<?
						if (strlen($arPaySystem["DESCRIPTION"])>0)
						{
							?>
							<br /><?=$arPaySystem["DESCRIPTION"]?>
							<?
						}
						?>
					</label>
					<?
				}
			}
		}
		?>
	</p>
</label>