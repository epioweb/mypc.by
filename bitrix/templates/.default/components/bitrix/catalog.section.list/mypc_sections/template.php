<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<div class="b-catalog-section-list">
	<div class="b-section-row">
	<?
	$i = 0;
	foreach($arResult["SECTIONS"] as $arSection)
	{
		$this->AddEditAction($arSection['ID'], $arSection['EDIT_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_EDIT"));
		$this->AddDeleteAction($arSection['ID'], $arSection['DELETE_LINK'], CIBlock::GetArrayByID($arSection["IBLOCK_ID"], "SECTION_DELETE"), array("CONFIRM" => GetMessage('CT_BCSL_ELEMENT_DELETE_CONFIRM')));
		
		if($i > 0 && $i%3 ==0)
		{
			?>
			</div><div class="b-section-row">
			<?
		}
		?>
		<div class="b-catalog-section" id="<?=$this->GetEditAreaId($arSection['ID']);?>">
			<a href="<?=$arSection["SECTION_PAGE_URL"]?>">
				<div class="b-image-section">
					<?
					if(!empty($arSection["PHOTO"]))
					{
						?><img src="<?=$arSection["PHOTO"]?>"/><?
					}
					else
					{
						?>
						<div class="b-section-nophoto"></div>
						<?
					}
					?>
				</div>
				<div class="b-section-name">
					<?=$arSection["NAME"]?><?if($arParams["COUNT_ELEMENTS"]):?>&nbsp;(<?=$arSection["ELEMENT_CNT"]?>)<?endif;?>
				</div>
			</a>
		</div>
		<?
		$i++;
	}
	?>
	</div>
</div>