<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>
<?//printAdmin($GLOBALS["_SESSION"]["CATALOG_CURRENCY"]);?>
<?
$basketItems = $arResult["ITEMS"]["AnDelCanBuy"];
if (is_array($basketItems) && count($basketItems) > 0) {
   ?>
   <div class="cart-wrap">
      <?
      foreach ($arResult["ITEMS"]["AnDelCanBuy"] as $arBasketItems) {
         ?>
         <div class="item">
            <div class="double-border-wrap">
               <div class="double-border">
                  <div class="cell image">
                     <a href="<?= $arBasketItems["DETAIL_PAGE_URL"] ?>" class="image">
      <?
      if (!empty($arBasketItems["PHOTO"])) {
         ?><img src="<?= $arBasketItems["PHOTO"] ?>" alt="" /><?
                        }
                        ?>
                     </a>
                  </div>
                  <div class="cell details">
                     <a href="<?= $arBasketItems["DETAIL_PAGE_URL"] ?>"><span class="title"><?= $arBasketItems["NAME"] ?></span></a>
                     <span class="price3"><strong><?=$arBasketItems["PRICE_FORMATED"] ?></strong><span class="usd"><?=($GLOBALS["_SESSION"]["CATALOG_CURRENCY"] == "USD") ? convertPriceToBYR($arBasketItems["FULL_PRICE"]) : $arBasketItems["FULL_PRICE_FORMATED"] ?></span></span>

                     <!--
                     <span class="cart-price"><?=$arBasketItems["PRICE_FORMATED"] ?></span>
                     -->
                  </div>
                  <div class="cell qty">
                     <span class="label">Количество:</span>
                     <span class="spinner-wrap">
                        <input class="spinner quantity-inp" type="text" name="QUANTITY_<?= $arBasketItems["ID"] ?>" data-bid="<?= $arBasketItems["ID"] ?>" value="<?= $arBasketItems["QUANTITY"] ?>" />
                     </span>
                  </div>
                  <div class="cell item-total">
                     <span class="label">Стоимость:</span>
                     <span class="cart-item-total"><?= $arBasketItems["PRICE_ALL_F"] ?></span>
                  </div>
                  <div class="cell">
                     <a href="<?= str_replace("#ID#", $arBasketItems["ID"], $arUrlTempl["delete"]) ?>" class="del-item" title="Удалить из корзины" ></a>
                  </div>
               </div>
            </div>
         </div>
      <?
   }
   ?>
      <div class="cart-summary">
         <p>Общая стоимость заказа:</p>
         <p class="total" id="totalBasketSum"><strong><?= $arResult["allNOVATSum_FORMATED"] ?></strong></p>
         <input type="hidden" name="BasketOrder" value="Y"/>
         <button type="submit" id="basketOrderButton2" class="yellow-btn2">Оформить заказ</button>
      </div>
   </div>
   <script>
      $('.cell').on('click', '.del-item', function() {
         setTimeout(updateCartSmallBlock, 1000);
         return false;
      });
   </script>
   <?
} else {
   ?>
   <div class="article">
      <p>В корзине нет товаров. <a href="/catalog/">Перейти к покупкам</a>.</p>
   </div>
   <?
}
?>