<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
if(is_array($arResult["ITEMS"]) && count($arResult["ITEMS"]))
{
?>
<!-- Лучшие предложения в рубрике -->
<div class="similar-wrap">
	<?
	if(is_array($arResult["SECTION"]))
	{
		?><h2 class="light-blue-lineheader">Лучшие предложения в рубрике “<?=$arResult["SECTION"]["NAME"]?>”</h2><?
	}
	else
	{
		?><h2 class="light-blue-lineheader">Акции и спецпредложения</h2><?
	}
	?>
	<div class="offers-wrap">
		<div class="offers">
			<?
			foreach($arResult["ITEMS"] as $arItem)
			{
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				?>
				<div class="offer" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<div class="double-border-wrap">
						<div class="double-border">
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
								<span class="image">
									<?
									if(!empty($arItem["PHOTO"]))
									{
										?><img src="<?=$arItem["PHOTO"]?>" alt="" /><?
									}
									?>
								</span>
								<span class="title"><?=$arItem["NAME"]?></span>
							</a>
							<span class="footer">
								<?
								ob_start();
								?>
								<a class="add-to-cart buy-btn-link" href="/ajax.php?action=add2cart&id=<?=$arItem["ID"]?>"><i class="icon icon-cart"></i><span>в корзину</span></a>
								<span class="price">#PRICE_HTML#</span>
								<?
								$buyHTML = ob_get_clean();
								ob_start();
								?>
								<a class="add-to-cart" href="/personal/cart/"><i class="icon icon-cart"></i><span>в корзине</span></a>
								<span class="price">#PRICE_HTML#</span>
								<?
								$inbasketHTML = ob_get_clean();
								ShowUncachedContent("buy-block-actions",array("id"=>$arItem["ID"],"buyHTML"=>$buyHTML,"inbasketHTML"=>$inbasketHTML));
								?>
							</span>
						</div>
					</div>
				</div>
				<?
			}
			?>
		</div>
	</div>
</div>
<?
}
?>