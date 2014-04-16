<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(is_array($arResult["ITEMS"]) && count($arResult["ITEMS"]) > 0)
{
	?>
	<!-- Блок новостей -->
	<div class="news-wrap">
		<h2 class="blue-header sidebar-header">НОВОСТИ</h2>
		<ul class="news-list">
			<?
			foreach($arResult["ITEMS"] as $arItem)
			{
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
				?>
				<li id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<h3 class="news-header"><a href="<?=$arItem["DETAIL_PAGE_URL"]?>"><?=$arItem["NAME"]?></a></h3>
					<div class="news-img">
						<?
						if(is_array($arItem["RESIZED_IMG"]))
						{
							?>
							<a href="<?=$arItem["DETAIL_PAGE_URL"]?>">
								<img src="<?=$arItem["RESIZED_IMG"]["src"]?>" alt=""/>
							</a>
							<?
						}
						?>
					</div>
					<p class="news-excerpt"><?=$arItem["PREVIEW_TEXT"]?></p>
					<a href="<?=$arItem["DETAIL_PAGE_URL"]?>" class="news-read-more">Подробнее »</a>
				</li>
				<?
			}
			?>
		</ul>
		<a href="/news/" class="all-news">
			<span>ВСЕ НОВОСТИ</span>
			<i class="icon icon-triangle"></i>
		</a>
	</div>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<div><?=$arResult["NAV_STRING"]?></div>
	<?endif;?>
	<?
}
?>