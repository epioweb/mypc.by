<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
$showMode = ($arParams["SHOW_MODE"] == "grid")?"grid":"list";

if($arResult["ITEMS"])
{
	?>
			<!-- Вывод списка продуктов (Списком / Сеткой) -->
            <div class="products-<?=$showMode?>" id="section-product-list">
            	<?
            	foreach($arResult["ITEMS"] as $cell=>$arElement)
            	{
            		$this->AddEditAction($arElement['ID'], $arElement['EDIT_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_EDIT"));
            		$this->AddDeleteAction($arElement['ID'], $arElement['DELETE_LINK'], CIBlock::GetArrayByID($arParams["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
            		?>
            		<!-- Элемент -->
	                <div class="item" id="<?=$this->GetEditAreaId($arElement['ID']);?>">
	                <!--<div class="offer" id="<?=$this->GetEditAreaId($arElement['ID']);?>">-->
	                    <div class="double-border-wrap">
	                        <div class="double-border clearfix">
	                            <div class="left-column">
	                                <div class="image">
	                                    <?
										if(!empty($arElement["PHOTO"]))
										{
											?><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><img src="<?=$arElement["PHOTO"]?>" alt=""  /></a><?
										}
										?>
	                                </div>
	                            </div>
	                            <div class="middle-column">
	                                <div class="heading clearfix">
	                                    <h3 class="title"><a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["NAME"]?></a></h3>
	                                    <?
	                                    $rating = floatval($arElement["PROPERTIES"]["rating"]["VALUE"]);
	                                    $rating = ($rating/5)*100;
	                                    $rating = round($rating);
	                                    ?>
	                                    <div class="rating">
	                                        <div class="rating-progress-bar">
	                                            <div class="rating-percent" style="width: <?=$rating?>%"></div>
	                                        </div>
	                                    </div>
	                                </div>
                                        <?if(isset($arElement["PROPERTIES"]["ARTNUMBER"]["VALUE"])):?>
                                                <span>                                                
                                                   <?=GetMessage('CATALOG_ARTNUMBER')?>: <?=$arElement["PROPERTIES"]["ARTNUMBER"]["VALUE"];?>
                                                </span>
                                        <?endif;?>
	                                <p class="description">
	                                	<?=$arElement["~PREVIEW_TEXT"]?>
	                                	<a href="<?=$arElement["DETAIL_PAGE_URL"]?>" class="details-link">подробнее »</a>
                                        </p>

	                                <div class="footer clearfix">
	                                    <!--<div class="left">-->

	                                <!--<span class="footer">-->
	                                    <div class="left">
                                            <div class="price2">
	                                    	<?ob_start();?>
                                                       <strong>
                                                          #PRICE_1#
                                                       </strong>                                                
                                                       <span class="usd">#PRICE_HTML#</span>
                                                <?
	                                    	$html = ob_get_clean();
	                                    	ShowUncachedContent("price-block-section",array("id"=>$arElement["ID"],"priceHTML"=>$html));
	                                    	?>
	                                   </div></div>
	                                   <div class="right">
	                                    	<?
	                                    	ob_start();
	                                    	?><a data-ib="<?=$arParams["IBLOCK_ID"]?>" data-mib="<?=$arParams["MENU_IBLOCK_ID"]?>" href="/ajax.php?action=add2compare&id=<?=$arElement["ID"]?>" class="compare-link compare-link-btn"><i class="icon icon-compare"></i>Сравнить</a><?
                                    		$compareHTML = ob_get_clean();
                                    		ob_start();
                                    		?><a href="/catalog/compare/?IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>" class="compare-link"><i class="icon icon-compare"></i>В сравнении</a><?
                                    		$incompareHTML = ob_get_clean();
                                    		ShowUncachedContent("compare-link-section",array("id"=>$arElement["ID"],"iblock_id"=>$arParams["IBLOCK_ID"],"compareHTML"=>$compareHTML,"incompareHTML"=>$incompareHTML));
                                    		
                                    		
                                    		ob_start();
                                    		?>
                                    		<a data-mode="<?=$showMode?>" href="/ajax.php?action=add2cartSection&id=<?=$arElement["ID"]?>" class="<?=$showMode=="list"?"yellow-btn":""?> add-to-cart buyBtnSection"><i class="icon icon-cart"></i>В корзину</a>
                                    		<?
                                    		$buyHTML = ob_get_clean();
                                    		ob_start();
                                    		?>
                                    		<a data-mode="<?=$showMode?>" href="/personal/cart/" class="<?=$showMode=="list"?"yellow-btn":""?> add-to-cart in-cart"><span>Товар в корзине</span></a>
                                    		<?
                                    		$inbasketHTML = ob_get_clean();
                                    		ShowUncachedContent("buy-link-section",array("id"=>$arElement["ID"],"buyHTML"=>$buyHTML,"inbasketHTML"=>$inbasketHTML));
                                    		?>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </div>
            		<?
            	}
            	?>
            </div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<?=$arResult["NAV_STRING"]?>
	<?endif;?>
	<?
}
else
{
	?><p>Нет товаров.</p><?
}
?>