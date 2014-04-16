<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(count($arResult["ITEMS"]) > 0)
{
?>
<!-- Похожие товары -->
<div class="similar-wrap similarProductsList">
	<h2 class="light-blue-lineheader">Похожие товары</h2>

	<div class="offers-wrap">
		<div class="offers">
			<?
			foreach($arResult["ITEMS"] as $arElement)
			{
				$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				
				?>
				<div class="offer">
					<div class="double-border-wrap" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
						<div class="double-border">
							<a href="<?=$arElement["DETAIL_PAGE_URL"]?>">
								<span class="image">
									<?
									if(!empty($arElement["PHOTO"]))
									{
										?><img src="<?=$arElement["PHOTO"]?>" alt="" /><?
									}
									?>
								</span>
								<span class="title"><?=$arElement["NAME"]?></span>
							</a>
							<span class="footer">
								<?
								ob_start();
								?>
								<a href="/ajax.php?action=add2cart&id=<?=$arElement["ID"]?>" class="add-to-cart buy-btn-link"><i class="icon icon-cart"></i> <span>в корзину</span></a>
								<span class="price">#PRICE_HTML#</span>
								<?
								$buyHTML = ob_get_clean();
								ob_start();
								?>
								<a href="/personal/cart/" class="add-to-cart"><i class="icon icon-cart"></i> <span>в корзине</span></a>
								<span class="price">#PRICE_HTML#</span>
								<?
								$inbasketHTML = ob_get_clean();
								ShowUncachedContent("buy-block-actions",array("id"=>$arElement["ID"],"buyHTML"=>$buyHTML,"inbasketHTML"=>$inbasketHTML));
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