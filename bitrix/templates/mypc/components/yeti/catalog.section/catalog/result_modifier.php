<?
$secCntMax = 50;
CModule::IncludeModule("iblock");
CModule::IncludeModule("catalog");
$basePrice = CCatalogGroup::GetBaseGroup();
$catGroupID = COption::GetOptionString("sale","ZED_FL_PRICETYPE");
$ut = CYetiProcessor::getCatalogUserType();
if($ut["USER_TYPE"] == "UL") $catGroupID = COption::GetOptionString("sale","ZED_UL_PRICETYPE");
$catGroupID = intval($catGroupID);
if($catGroupID == 0) $catGroupID = $basePrice["ID"];

if(is_array($arResult["SECTION_LIST"]) && count($arResult["SECTION_LIST"]) > 0)
{
	foreach($arResult["SECTION_LIST"] as $k=>$sec)
	{
		if(intval($sec["UF_PRODUCT_CNT"]) == 0)
		{
			unset($arResult["SECTION_LIST"][$k]);
			continue;
		}
		
		$sec["ITEMS"] = array();
		$catIbID = intval($sec["UF_IBLOCK_ID"]);
		if($catIbID > 0)
		{
			$arFilter = array(
				"IBLOCK_ID" => $catIbID,
				"GLOBAL_ACTIVE" => "Y",
				"ACTIVE" => "Y",
				"DEPTH_LEVEL" => 1,
				//"CNT_ACTIVE" => "Y",
			);
			$rs = CIBlockSection::GetList(array("SORT"=>"ASC","NAME"=>"ASC"),$arFilter,true,array("ID","NAME","IBLOCK_ID","CODE","PICTURE","UF_*"));
			while($s = $rs->fetch())
			{
				$s["SECTION_PAGE_URL"] = $sec["SECTION_PAGE_URL"].$s["CODE"]."/";
				$filtr = array(
					"IBLOCK_ID"=>$s["IBLOCK_ID"],
					">CATALOG_PRICE_".$catGroupID => 0,
					"SECTION_ID" => $s["ID"],
					"INCLUDE_SUBSECTIONS" => "Y",
					"ACTIVE" => "Y",
					"SECTION_GLOBAL_ACTIVE" => "Y",
				);
				$s["ELEMENT_CNT"] = CIBlockElement::GetList(false,$filtr,array());;
				if($s["ELEMENT_CNT"] > 0) $sec["ITEMS"][] = $s;
				if(count($sec["ITEMS"]) == $secCntMax) break;
			}
		}
		else
		{
			$arFilter = array(
				"IBLOCK_ID" => $sec["IBLOCK_ID"],
				"ACTIVE" => "Y",
				"SECTION_ID" => $sec["ID"],
			);
			$rs = CIBlockSection::GetList(array("SORT"=>"ASC","NAME"=>"ASC"),$arFilter,false,array("ID","NAME","IBLOCK_ID","CODE","PICTURE","LEFT_MARGIN","RIGHT_MARGIN","UF_*"));
			while($s = $rs->fetch())
			{
				$catIbID = intval($s["UF_IBLOCK_ID"]);
				$s["ELEMENT_CNT"] = $s["UF_PRODUCT_CNT"];
				$s["SECTION_PAGE_URL"] = $sec["SECTION_PAGE_URL"].$s["CODE"]."/";
				if($s["ELEMENT_CNT"] > 0) $sec["ITEMS"][] = $s;
				if(count($sec["ITEMS"]) == $secCntMax) break;
			}
		}
		$arResult["SECTION_LIST"][$k] = $sec;
	}
}
?>