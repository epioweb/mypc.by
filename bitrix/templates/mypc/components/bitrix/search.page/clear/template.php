<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<div class="product-header">
   <h1>ПОИСК</h1>
   <?
   if (is_object($arResult["NAV_RESULT"])) {
      $cntResults = $arResult["NAV_RESULT"]->SelectedRowsCount();
      ?>
      <span class="search-results-count">По Вашему запросу найдено <?= $cntResults ?> результатов</span>
      <?
   }
   ?>
</div>

<div id="search-box">
   <div id="search">
      <form action="" method="get">
         <input type="hidden" name="tags" value="<? echo $arResult["REQUEST"]["TAGS"] ?>" />
         <input type="hidden" name="how" value="<? echo $arResult["REQUEST"]["HOW"] == "d" ? "d" : "r" ?>" />
         <input type="text" name="q" value="<?= htmlspecialcharsEx($arResult["REQUEST"]["QUERY"]) ?>" class="input-search" id="search-input" />
         <input type="submit" name="submit" class="button-search" value="Найти" />
      </form>
   </div>
</div>

<?
if ($arResult["REQUEST"]["QUERY"] === false && $arResult["REQUEST"]["TAGS"] === false) {
   
} elseif ($arResult["ERROR_CODE"] != 0) {
   ?>
   <p><?= GetMessage("CT_BSP_ERROR") ?></p>
   <? ShowError($arResult["ERROR_TEXT"]); ?>
   <p><?= GetMessage("CT_BSP_CORRECT_AND_CONTINUE") ?></p>
   <br /><br />
   <p><?= GetMessage("CT_BSP_SINTAX") ?><br /><b><?= GetMessage("CT_BSP_LOGIC") ?></b></p>
   <table border="0" cellpadding="5">
      <tr>
         <td align="center" valign="top"><?= GetMessage("CT_BSP_OPERATOR") ?></td><td valign="top"><?= GetMessage("CT_BSP_SYNONIM") ?></td>
         <td><?= GetMessage("CT_BSP_DESCRIPTION") ?></td>
      </tr>
      <tr>
         <td align="center" valign="top"><?= GetMessage("CT_BSP_AND") ?></td><td valign="top">and, &amp;, +</td>
         <td><?= GetMessage("CT_BSP_AND_ALT") ?></td>
      </tr>
      <tr>
         <td align="center" valign="top"><?= GetMessage("CT_BSP_OR") ?></td><td valign="top">or, |</td>
         <td><?= GetMessage("CT_BSP_OR_ALT") ?></td>
      </tr>
      <tr>
         <td align="center" valign="top"><?= GetMessage("CT_BSP_NOT") ?></td><td valign="top">not, ~</td>
         <td><?= GetMessage("CT_BSP_NOT_ALT") ?></td>
      </tr>
      <tr>
         <td align="center" valign="top">( )</td>
         <td valign="top">&nbsp;</td>
         <td><?= GetMessage("CT_BSP_BRACKETS_ALT") ?></td>
      </tr>
   </table>
   <?
} elseif (count($arResult["SEARCH"]) > 0) {
   ?>
   <? if ($arParams["DISPLAY_TOP_PAGER"] != "N") echo $arResult["NAV_STRING"] ?>
   <div class="search-results-list">
   <?
   foreach ($arResult["SEARCH"] as $arItem) {
      ?>
         <div class="item">
            <div class="double-border-wrap">
               <div class="double-border clearfix">
         <?
         if (!empty($arItem["PHOTO"])) {
            ?>
                     <div class="image">
                        <a href="<? echo $arItem["URL"] ?>"><img src="<?= $arItem["PHOTO"] ?>" alt=""></a>
                     </div>
                     <?
                  } else {
                     ?>
                     <div class="image">
                        <a href="<? echo $arItem["URL"] ?>"><img src="<?= SITE_TEMPLATE_PATH ?>/images/emptyphoto190.png" alt="" width="90"></a>
                     </div>
                     <?
                  }
                  ?>
                  <div class="main-column">
                     <h3 class="title"><a href="<? echo $arItem["URL"] ?>"><? echo $arItem["TITLE_FORMATED"] ?></a></h3>
                     <div class="description">
                  <? echo $arItem["BODY_FORMATED"] ?><br/>
                        <a href="<? echo $arItem["URL"] ?>" class="details-link">подробнее »</a>
                     </div>
                  </div>
      <?
      if ($arItem["IS_PRODUCT"] == "Y") {
         ?>
                     <div class="right-column">
         <?
         ob_start();
         ?>
                     <span class="price2"><strong>#PRICE_HTML#</strong><span class="usd">#PRICE_1#</span></span>
                        <?
                     $html = ob_get_clean();
                     ShowUncachedContent("price-block-section", array("id" => $arItem["ITEM_ID"], "priceHTML" => $html));

                     ob_start();
                     ?>
                        <a href="/ajax.php?action=add2cart&id=<?= $arItem["ITEM_ID"] ?>" class="add-to-cart buy-btn-link" ><i class="icon icon-cart"></i><span>в корзину</span></a>
                        <?
                        $buyHTML = ob_get_clean();
                        ob_start();
                        ?>
                        <a href="/personal/cart/" class="add-to-cart"><i class="icon icon-cart"></i><span>в корзину</span></a>
                        <?
                        $inbasketHTML = ob_get_clean();
                        ShowUncachedContent("buy-link-section", array("id" => $arItem["ITEM_ID"], "buyHTML" => $buyHTML, "inbasketHTML" => $inbasketHTML));
                        ?>
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
   </div>
               <? if ($arParams["DISPLAY_BOTTOM_PAGER"] != "N") echo $arResult["NAV_STRING"] ?>
   <?
}
else {
   ?><? ShowNote(GetMessage("CT_BSP_NOTHING_TO_FOUND")); ?><?
   }
   ?>