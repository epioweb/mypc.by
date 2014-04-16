<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(count($arResult) > 0)
{
?>
<!-- Список сравниваемых товаров -->
<div class="sidebar-block-wrap">
<div class="typical sidebar-white-block b-compare-list">
	<h2>Список сравнения</h2>
	<ul class="links-list">
		<?
		foreach($arResult as $arElement)
		{
			?>
			<li>
				<a href="<?=$arElement["DETAIL_PAGE_URL"]?>"><?=$arElement["~NAME"]?></a>
				<noindex><a href="<?=$arElement["DELETE_URL"]?>" rel="nofollow" class="btn-delete-compare">&#10006;</a></noindex>
			</li>
			<?
		}
		?>
	</ul>
	<?
	if(count($arResult)>=2)
	{
		?>
		<div>
			<a href="<?=$arParams["COMPARE_URL"]?>?action=COMPARE&IBLOCK_ID=<?=$arParams["IBLOCK_ID"]?>" class="simple-btn"><?=GetMessage("CATALOG_COMPARE")?></a>
		</div>
		<?
	}
	?>
</div>
</div>
<?
}
?>