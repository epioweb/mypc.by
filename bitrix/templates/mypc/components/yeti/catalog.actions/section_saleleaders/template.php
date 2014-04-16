<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?
if (is_array($arResult["ITEMS"]) && count($arResult["ITEMS"])) {
   ?>
   <!-- ЛУЧШИЕ ПРЕДЛОЖЕНИЯ В РУБРИКЕ  -->
   <div class="best-sellers">
      <h2><i class="icon icon-thumbup"></i>Лидеры продаж</h2>
      <div class="best-sellers-wrap">
         <div id="best-sellers">
            <div id="best-sellers-container">
               <?
               foreach ($arResult["ITEMS"] as $arItem) {
                  $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                  $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
                  ?>
                  <div class="best-seller" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                     <div class="double-border-wrap">
                        <div class="double-border">
                           <a href="<?= $arItem["DETAIL_PAGE_URL"] ?>">
                              <span class="image">
                                 <?
                                 if (!empty($arItem["PHOTO"])) {
                                    ?><img src="<?= $arItem["PHOTO"] ?>" alt="" /><?
                                 }
                                 ?>
                              </span>
                              <span class="title"><span class="dot-dot-dot"><?= $arItem["NAME"] ?></span></span>
                           </a>
                           <span class="footer">
                              <?
                              ob_start();
                              ?>
                              <span class="price2"><strong>#PRICE_HTML#</strong><span class="usd">#PRICE_1#</span></span>
                              <a href="/ajax.php?action=add2cart&id=<?= $arItem["ID"] ?>" class="add-to-cart buy-btn-link">
                                 <i class="icon icon-cart"></i>
                                 <span>в корзину</span>
                              </a>
                              <?
                              $buyHTML = ob_get_clean();
                              ob_start();
                              ?>
                              <span class="price2"><strong>#PRICE_HTML#</strong><span class="usd">#PRICE_1#</span></span>
                              <a href="/personal/cart/" class="add-to-cart">
                                 <i class="icon icon-cart"></i>
                                 <span>в корзине</span>
                              </a>
                              <?
                              $inbasketHTML = ob_get_clean();
                              ShowUncachedContent("buy-block-actions", array("id" => $arItem["ID"], "buyHTML" => $buyHTML, "inbasketHTML" => $inbasketHTML));
                              ?>
                           </span>
                        </div>
                     </div>
                  </div>
                  <?
               }
               ?>
            </div>
            <div id="best-sellers-left"></div>
            <div id="best-sellers-right"></div>
         </div>
      </div>
   </div>
   <?
}
?>