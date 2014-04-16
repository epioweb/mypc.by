<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<!-- Содержимое корзины -->
<div class="product-header cart-header">
	<h1><i class="icon icon-cart4"></i>Корзина покупок</h1>
</div>
<?
$arUrlTempl = Array(
	"delete" => $APPLICATION->GetCurPage()."?action=delete&id=#ID#",
	"shelve" => $APPLICATION->GetCurPage()."?action=shelve&id=#ID#",
	"add" => $APPLICATION->GetCurPage()."?action=add&id=#ID#",
);
?>
<form method="post" action="<?=POST_FORM_ACTION_URI?>" name="basket_form">
<?
include($_SERVER["DOCUMENT_ROOT"].$templateFolder."/basket_items.php");
?>
</form>