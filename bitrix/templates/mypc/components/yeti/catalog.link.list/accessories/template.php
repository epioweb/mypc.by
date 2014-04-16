<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(count($arResult["ITEMS"]) > 0)
{
?>
<!-- Аксессуары -->
<div class="offers-wrap" style="text-align:center">
	<div class="offers">
		<?
		foreach($arResult["ITEMS"] as $arItem)
		{
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
			
			?>
			<!-- Акция -->
			<div class="offer"  id="<?=$this->GetEditAreaId($arItem['ID']);?>">
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
							<span class="title"><?=htmlspecialcharsEx($arItem["NAME"])?></span>
						</a>
						<span class="footer">
							<?
							ob_start();
							?>
							<a href="/ajax.php?action=add2cart&id=<?=$arItem["ID"]?>" class="add-to-cart buy-btn-link"><i class="icon icon-cart"></i> <span>в корзину</span></a>
							<span class="price">#PRICE_HTML#</span>
							<?
							$buyHTML = ob_get_clean();
							ob_start();
							?>
							<a href="/personal/cart/" class="add-to-cart"><i class="icon icon-cart"></i> <span>в корзине</span></a>
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
<?
}
?>