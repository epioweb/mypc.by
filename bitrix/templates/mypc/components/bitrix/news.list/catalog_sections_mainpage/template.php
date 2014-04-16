<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(is_array($arResult["ITEMS"]) && count($arResult["ITEMS"]) > 0)
{
	?>
	<!-- Категории товаров -->
	<div class="grey-wrap top-shadow">
		<h2 class="blue-header bottom-line">Товары по категориям</h2>
		<div class="categories-menu">
			<ul class="categories-menu-list">
				<?
				foreach($arResult["ITEMS"] as $arItem)
				{
					$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
					$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
					?>
					<li  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
						<a href="<?=$arItem["PROPERTIES"]["URL"]["VALUE"]?>">
							<span class="image">
								<?
								if(is_array($arItem["RESIZED_IMG"]))
								{
									?>
									<img src="<?=$arItem["RESIZED_IMG"]["src"]?>" alt="" />
									<?
								}
								?>
							</span>
							<span class="title"><?=$arItem["NAME"]?></span>
						</a>
					</li>
					<?
				}
				?>
			</ul>
		</div>
	</div>
	<?
}
?>