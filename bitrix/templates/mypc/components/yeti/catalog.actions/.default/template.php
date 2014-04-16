<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>
<?
if(is_array($arResult["ITEMS"]) && count($arResult["ITEMS"]))
{

//printAdmin($GLOBALS['_SESSION']['CATALOG_CURRENCY']);
?>
<!-- Акции и предложения -->
<div class="offers-wrap">
	<?
	if(!empty($arParams["BLOCK_TITLE"]))
	{
		?>
		<h1 class="blue-header bottom-line"><?=$arParams["BLOCK_TITLE"]?></h1>
		<?
	}
	?>
	<div class="offers">
		<?
		foreach($arResult["ITEMS"] as $keyItem =>$arItem)
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
							<span class="title"><?=$arItem["NAME"]?></span>
						</a>
						<span class="footer">
							<p class="price2">
							<?ob_start();?>
                                                           <strong> 
                                                              #PRICE_1#
                                                              </strong>
                                                           <span class="usd">#PRICE_HTML#</span>
                                                        </p>

							<a href="/ajax.php?action=add2cart&id=<?=$arItem["ID"]?>" class="add-to-cart buy-btn-link"><i class="icon icon-cart"></i> <span>в корзину</span></a>
                                                        <?
							$buyHTML = ob_get_clean();
	                                    	ShowUncachedContent("buy-block-actions",array("id"=>$arElement["ID"],"priceHTML"=>$buyHTML));
							ob_start();
							?>

                                                        <p class="price2">
                                                           <strong>
                                                              #PRICE_1#
                                                           </strong> 
                                                           <span class="usd">#PRICE_HTML#</span>
                                                        </p>

							<a href="/personal/cart/" class="add-to-cart in-cart"><span>в корзине</span></a>
							<!--<span class="price2">#PRICE_HTML#</span>-->
							
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