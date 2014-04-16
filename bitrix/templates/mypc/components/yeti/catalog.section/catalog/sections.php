<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$APPLICATION->IncludeComponent("bitrix:breadcrumb", ".default", Array("START_FROM" => "0","PATH" => "","SITE_ID" => "-"),false);
$APPLICATION->SetDirProperty("HIDE_MAINPAGETITLE", "Y");
if(is_array($arResult["SECTION_LIST"]) && count($arResult["SECTION_LIST"]) > 0)
{
	$firsSec = reset($arResult["SECTION_LIST"]);
	if($firsSec["DEPTH_LEVEL"] == 1)
	{
		?>
		<div class="product-header cart-header">
			<h1><i class="icon icon-catalog"></i><?=$APPLICATION->GetTitle(false)?></h1>
		</div>
		
		<div class="all-categories-wrap">
			<ul class="all-categories-list">
				<?
				foreach($arResult["SECTION_LIST"] as $sec)
				{
					$this->AddEditAction($sec['ID'], $sec['EDIT_LINK'], CIBlock::GetArrayByID($sec["IBLOCK_ID"], "SECTION_EDIT"));
					$fid = intval($sec["PICTURE"]);
					if($fid > 0)
					{
						$arFilter = array("name" => "sharpen", "precision" => 30);
						$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 48, "height" => 48),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arFilter);
						$sec["PHOTO"] = $arFileTmp["src"];
					}
					?>
					<li id="<?=$this->GetEditAreaId($sec['ID']);?>">
						<?
						if(!empty($sec["PHOTO"]))
						{
							?><a href="<?=$sec["SECTION_PAGE_URL"]?>" class="image"><img src="<?=$sec["PHOTO"]?>" alt="" /></a><?
						}
						?>
						<ul>
							<li class="first"><a href="<?=$sec["SECTION_PAGE_URL"]?>"><?=$sec["NAME"]?></a></li>
							<li style="display:block"></li>
							<?
							if(is_array($sec["ITEMS"]))
							{
								foreach($sec["ITEMS"] as $k=>$s)
								{
									if($s["UF_DISABLE_MYPC"] == 1) unset($sec["ITEMS"][$k]);
								}
								
								$z = 0;
								foreach($sec["ITEMS"] as $s)
								{
									if($z <= 4)
									{
										?>
										<li><a href="<?=$s["SECTION_PAGE_URL"]?>"><?=$s["NAME"]?></a> <span>(<?=$s["ELEMENT_CNT"]?>)</span></li>
										<?
									}
									else
									{
										?>
										<li><a href="<?=$s["SECTION_PAGE_URL"]?>"><?=$s["NAME"]?></a> <span>(<?=$s["ELEMENT_CNT"]?>)</span></li>
										<?
									}
									$z++;
								}
								if(count($sec["ITEMS"]) > 0)
								{
									?>
									<li class="show-all-link"><a href="<?=$sec["SECTION_PAGE_URL"]?>">раскрыть полный список »</a></li>
									<?
								}
							}
							?>
						</ul>
					</li>
					<?
				}
				?>
			</ul>
		</div>
		<?
	}
	else
	{
		?>
		
		<div class="product-header cart-header">
			<h1><?=$APPLICATION->GetTitle(false)?></h1>
		</div>
		
		<!-- Выбранная категория товаров -->
		<div class="all-categories-wrap subcategories-wrap">
			<ul class="all-categories-list subcategories-list">
				<?
				foreach($arResult["SECTION_LIST"] as $sec)
				{
					$this->AddEditAction($sec['ID'], $sec['EDIT_LINK'], CIBlock::GetArrayByID($sec["IBLOCK_ID"], "SECTION_EDIT"));
					$fid = intval($sec["PICTURE"]);
					if($fid > 0)
					{
						$arFilter = array("name" => "sharpen", "precision" => 30);
						$arFileTmp = CFile::ResizeImageGet($fid,array("width" => 140, "height" => 140),BX_RESIZE_IMAGE_PROPORTIONAL,true, $arFilter);
						$sec["PHOTO"] = $arFileTmp["src"];
					}
					?>
					<li id="<?=$this->GetEditAreaId($sec['ID']);?>">
						<?
						if(!empty($sec["PHOTO"]))
						{
							?><a href="<?=$sec["SECTION_PAGE_URL"]?>" class="image"><img src="<?=$sec["PHOTO"]?>" alt="" /></a><?
						}
						?>
						<ul>
							<li class="first"><a href="<?=$sec["SECTION_PAGE_URL"]?>"><?=$sec["NAME"]?></a></li>
							<?
							if(is_array($sec["ITEMS"]))
							{
								foreach($sec["ITEMS"] as $k=>$s)
								{
									if($s["UF_DISABLE_MYPC"] == 1) unset($sec["ITEMS"][$k]);
								}
								
								$z = 0;
								foreach($sec["ITEMS"] as $s)
								{
									if($z <= 4)
									{
										?>
										<li><a href="<?=$s["SECTION_PAGE_URL"]?>"><?=$s["NAME"]?></a> <span>(<?=$s["ELEMENT_CNT"]?>)</span></li>
										<?
									}
									else
									{
										?>
										<li class="_hide"><a href="<?=$s["SECTION_PAGE_URL"]?>"><?=$s["NAME"]?></a> <span>(<?=$s["ELEMENT_CNT"]?>)</span></li>
										<?
									}
									$z++;
								}
								if(count($sec["ITEMS"]) > 5)
								{
									?>
									<li class="show-all-link"><a href="<?=$sec["SECTION_PAGE_URL"]?>">Раскрыть полный список »</a></li>
									<?
								}
							}
							?>
						</ul>
					</li>
					<?
				}
				?>
			</ul>
		</div>
		
		<?
		$menuSections = $arResult["MENU_SECTION_CHAIN"];
		$currentSec = array_pop($menuSections);
		if(is_array($currentSec))
		{
			
			CModule::IncludeModule("iblock");
			CModule::IncludeModule("catalog");
			$basePrice = CCatalogGroup::GetBaseGroup();
			$catGroupID = $basePrice["ID"];
			?>
			<?$APPLICATION->IncludeComponent("yeti:catalog.actions", "sections", array(
				"IBLOCK_TYPE"=>$arParams["IBLOCK_TYPE"],
				"IBLOCK_ID"=>$arParams["IBLOCK_ID"],
				"SECTION_ID" => $currentSec["ID"],
				"ACTION_PROPERTY_CODE"=>"SPECIALOFFER",
				"CACHE_TYPE"=>"A",
				"CACHE_TIME"=>"3600",
				"CACHE_GROUPS"=>"Y",
				"SEF_FOLDER"=>$arResult["COMPONENT_SEF_FOLDER"],
				"MAX_CNT"=>10,
				"CATALOG_GROUP_ID" => $catGroupID,
				),
				false
			);?>
			<?
		}
	}
}

?>
