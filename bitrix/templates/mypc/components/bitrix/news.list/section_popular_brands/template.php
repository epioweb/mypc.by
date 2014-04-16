<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if($arResult["ITEMS"])
{
	?>
	<!-- Популярные бренды -->
	<div class="sidebar-block-wrap">
		<div class="popular-brands typical sidebar-white-block">
			<h2>Популярные бренды</h2>
			<ul class="links-list">
				<?
				foreach($arResult["ITEMS"] as $arItem)
				{
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
					<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" ><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></li>
					<?
				}
				?>
			</ul>
		</div>
	</div>
	<?
}
?>