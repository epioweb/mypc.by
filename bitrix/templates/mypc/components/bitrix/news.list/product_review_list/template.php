<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(is_array($arResult["ITEMS"]) && count($arResult["ITEMS"]) > 0)
{
	?>
	<ul class="reviews-list">
		<?
		foreach($arResult["ITEMS"] as $arItem)
		{
			$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
			$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
			?>
			<li>
				<div class="reviews-list-two-cols clearfix" id="<?=$this->GetEditAreaId($arItem['ID']);?>">
					<div class="reviews-list-lc">
						<div class="rating-progress-bar">
							<?
							$vote = (floatval($arItem["PROPERTIES"]["VOTE"]["VALUE"])/5) * 100;
							?>
							<div class="rating-percent" style="width: <?=$vote?>%"></div>
						</div>
						<p class="reviewer"><a href="#"><?=$arItem["NAME"]?></a></p>
						<p class="age"><?=$arItem["DISPLAY_ACTIVE_FROM"]?></p>
					</div>
					<div class="reviews-list-rc">
						<div class="reviews-list-item-body">
							<p><?=$arItem["PREVIEW_TEXT"];?></p>
						</div>
						<p class="review-rating">
							Отзыв полезен?
							<?
							$usefullYes = intval($arItem["PROPERTIES"]["USEFULL_YES"]["VALUE"]);
							$usefullNo = intval($arItem["PROPERTIES"]["USEFULL_NO"]["VALUE"]);
							?>
							<a href="/ajax.php?action=rateReview&id=<?=$arItem["ID"]?>&value=y" class="review-usefull reviewBtn" title="Да"></a>
							Да: <span class="usefull-yes"><?=$usefullYes?></span>
							<a href="/ajax.php?action=rateReview&id=<?=$arItem["ID"]?>&value=n" class="review-not-usefull reviewBtn" title="Нет"></a>
							Нет: <span class="usefull-no"><?=$usefullNo?></span>
						</p>
					</div>
				</div>
			</li>
			<?
		}
		?>
	</ul>
	<?if($arParams["DISPLAY_BOTTOM_PAGER"]):?>
		<div><?=$arResult["NAV_STRING"]?></div>
	<?endif;?>
	<?
}
?>