<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?
if($arResult["CAN_BUY_CNT"] > 0)
{
	?>
	<a href="<?=$arParams["PATH_TO_BASKET"]?>">
		В корзине <?=$arResult["CAN_BUY_CNT_PLURAL"]?><br/>
		на сумму <?=$arResult["CAN_BUY_SUM_F"]?>
	</a>
	<?
}
else
{
	?>
	<div style="padding-top:10px;">
	В Вашей корзине нет товаров
	</div>
	<?

}
?>