<?

   AddEventHandler("catalog", "OnBeforePriceAdd", "MyRoundPrices");
   function MyRoundPrices(&$arFields)
   {
      if ($arFields['CATALOG_GROUP_ID'] == 8) {
         $arFields['PRICE'] = ceil($arFields['PRICE']/5)*5;
      }
   };


/*Version 0.3 2011-04-25*/
AddEventHandler("iblock", "OnAfterIBlockElementUpdate", "DoIBlockAfterSave");
AddEventHandler("iblock", "OnAfterIBlockElementAdd", "DoIBlockAfterSave");
AddEventHandler("catalog", "OnPriceAdd", "DoIBlockAfterSave");
AddEventHandler("catalog", "OnPriceUpdate", "DoIBlockAfterSave");
function DoIBlockAfterSave($arg1, $arg2 = false)
{
	$ELEMENT_ID = false;
	$IBLOCK_ID = false;
	$OFFERS_IBLOCK_ID = false;
	$OFFERS_PROPERTY_ID = false;
	if (CModule::IncludeModule('currency'))
		$strDefaultCurrency = CCurrency::GetBaseCurrency();
	
	//Check for catalog event
	if(is_array($arg2) && $arg2["PRODUCT_ID"] > 0)
	{
		//Get iblock element
		$rsPriceElement = CIBlockElement::GetList(
			array(),
			array(
				"ID" => $arg2["PRODUCT_ID"],
			),
			false,
			false,
			array("ID", "IBLOCK_ID")
		);
		if($arPriceElement = $rsPriceElement->Fetch())
		{
			$arCatalog = CCatalog::GetByID($arPriceElement["IBLOCK_ID"]);
			if(is_array($arCatalog))
			{
				//Check if it is offers iblock
				if($arCatalog["OFFERS"] == "Y")
				{
					//Find product element
					$rsElement = CIBlockElement::GetProperty(
						$arPriceElement["IBLOCK_ID"],
						$arPriceElement["ID"],
						"sort",
						"asc",
						array("ID" => $arCatalog["SKU_PROPERTY_ID"])
					);
					$arElement = $rsElement->Fetch();
					if($arElement && $arElement["VALUE"] > 0)
					{
						$ELEMENT_ID = $arElement["VALUE"];
						$IBLOCK_ID = $arCatalog["PRODUCT_IBLOCK_ID"];
						$OFFERS_IBLOCK_ID = $arCatalog["IBLOCK_ID"];
						$OFFERS_PROPERTY_ID = $arCatalog["SKU_PROPERTY_ID"];
					}
				}
				//or iblock which has offers
				elseif($arCatalog["OFFERS_IBLOCK_ID"] > 0)
				{
					$ELEMENT_ID = $arPriceElement["ID"];
					$IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
					$OFFERS_IBLOCK_ID = $arCatalog["OFFERS_IBLOCK_ID"];
					$OFFERS_PROPERTY_ID = $arCatalog["OFFERS_PROPERTY_ID"];
				}
				//or it's regular catalog
				else
				{
					$ELEMENT_ID = $arPriceElement["ID"];
					$IBLOCK_ID = $arPriceElement["IBLOCK_ID"];
					$OFFERS_IBLOCK_ID = false;
					$OFFERS_PROPERTY_ID = false;
				}
			}
		}
	}
	//Check for iblock event
	elseif(is_array($arg1) && $arg1["ID"] > 0 && $arg1["IBLOCK_ID"] > 0)
	{
		//Check if iblock has offers
		$arOffers = CIBlockPriceTools::GetOffersIBlock($arg1["IBLOCK_ID"]);
		if(is_array($arOffers))
		{
			$ELEMENT_ID = $arg1["ID"];
			$IBLOCK_ID = $arg1["IBLOCK_ID"];
			$OFFERS_IBLOCK_ID = $arOffers["OFFERS_IBLOCK_ID"];
			$OFFERS_PROPERTY_ID = $arOffers["OFFERS_PROPERTY_ID"];
		}
	}

	if($ELEMENT_ID)
	{
		static $arPropCache = array();
		if(!array_key_exists($IBLOCK_ID, $arPropCache))
		{
			//Check for MINIMAL_PRICE property
			$rsProperty = CIBlockProperty::GetByID("MINIMUM_PRICE", $IBLOCK_ID);
			$arProperty = $rsProperty->Fetch();
			if($arProperty)
				$arPropCache[$IBLOCK_ID] = $arProperty["ID"];
			else
				$arPropCache[$IBLOCK_ID] = false;
		}

		if($arPropCache[$IBLOCK_ID])
		{
			//Compose elements filter
			if($OFFERS_IBLOCK_ID)
			{
				$rsOffers = CIBlockElement::GetList(
					array(),
					array(
						"IBLOCK_ID" => $OFFERS_IBLOCK_ID,
						"PROPERTY_".$OFFERS_PROPERTY_ID => $ELEMENT_ID,
					),
					false,
					false,
					array("ID")
				);
				while($arOffer = $rsOffers->Fetch())
					$arProductID[] = $arOffer["ID"];
					
				if (!is_array($arProductID))
					$arProductID = array($ELEMENT_ID);
			}
			else
				$arProductID = array($ELEMENT_ID);

			$minPrice = false;
			$maxPrice = false;
			//Get prices
			$rsPrices = CPrice::GetList(
				array(),
				array(
					"PRODUCT_ID" => $arProductID,
				)
			);
			while($arPrice = $rsPrices->Fetch())
			{
				if (CModule::IncludeModule('currency') && $strDefaultCurrency != $arPrice['CURRENCY'])
					$arPrice["PRICE"] = CCurrencyRates::ConvertCurrency($arPrice["PRICE"], $arPrice["CURRENCY"], $strDefaultCurrency);
				
				$PRICE = $arPrice["PRICE"];

				if($minPrice === false || $minPrice > $PRICE)
					$minPrice = $PRICE;

				if($maxPrice === false || $maxPrice < $PRICE)
					$maxPrice = $PRICE;
			}

			//Save found minimal price into property
			if($minPrice !== false)
			{
				CIBlockElement::SetPropertyValuesEx(
					$ELEMENT_ID,
					$IBLOCK_ID,
					array(
						"MINIMUM_PRICE" => $minPrice,
						"MAXIMUM_PRICE" => $maxPrice,
					)
				);
			}
		}
	}
}


function PR($o,$toString = false,$ltf=false)
{
  if($toString)ob_start();
  $bt_src =  debug_backtrace();
  if($ltf)
	$bt = $bt_src[1];
  else
	$bt = $bt_src[0];
  $dRoot = $_SERVER["DOCUMENT_ROOT"];
  $dRoot = str_replace("/","\\",$dRoot);
  $bt["file"] = str_replace($dRoot,"",$bt["file"]);
  $dRoot = str_replace("\\","/",$dRoot);
  $bt["file"] = str_replace($dRoot,"",$bt["file"]);
  ?>
  <div style='font-size:9pt; color:#000; background:#fff; border:1px dashed #000;'>
  <div style='padding:3px 5px; background:#99CCFF; font-weight:bold;'>File: <?=$bt["file"]?> [<?=$bt["line"]?>] <?=date("d.m.Y H:i:s")?></div>
  <pre style='padding:10px;'><?print_r($o)?></pre>
  </div>
  <?  
  if($toString)return ob_get_clean(); 
}

function LTF($var,$unlink = false)
{
	$logFile = $_SERVER["DOCUMENT_ROOT"]."/ltf_log.html";
	if($unlink)
	{
		unlink($logFile);
	}
	file_put_contents($logFile,PR($var,true,true)."\n",FILE_APPEND);
}


$incFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/zd/yeti_catalog_processor.php"; if(file_exists($incFile)) require_once($incFile);
$incFile = $_SERVER["DOCUMENT_ROOT"]. "/bitrix/php_interface/usertypeiblocks.php"; if(file_exists($incFile)) require_once($incFile);
$incFile = $_SERVER["DOCUMENT_ROOT"]. "/bitrix/components/yeti/yam.parser.threads/parser_agent.php";if(file_exists($incFile)) require_once($incFile);
$incFile = $_SERVER["DOCUMENT_ROOT"]. "/bitrix/php_interface/yeti/element_add_event.php"; if(file_exists($incFile)) require_once($incFile);
$incFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/zd/property_iblock_property.php"; if(file_exists($incFile)) require_once($incFile);
$incFile = $_SERVER["DOCUMENT_ROOT"]."/bitrix/php_interface/zd/uncachedcontent.php"; if(file_exists($incFile)) require_once($incFile);
$incFile = dirname(__FILE__)."/yeti_youtube.php"; if(file_exists($incFile)) require_once($incFile);

AddEventHandler('main', 'OnBuildGlobalMenu', "OnBuildGlobalMenuHandler");
function OnBuildGlobalMenuHandler(&$aGlobalMenu, &$aModuleMenu)
{
	foreach($aModuleMenu as $k => $v)
	{
		if($v['parent_menu']=='global_menu_store' && $v["items_id"] == "menu_sale_settings")
		{
			$newMenuItem = Array(
				"text" => "Настройки магазина zed.by",
				"url" => "zed_settings.php",
				"title" => "Настройка магазина zed.by",
			);
			array_unshift($aModuleMenu[$k]["items"],$newMenuItem);
		}
	}
}


function MypcCleanCacheFiles($path = "")
{
	if (!class_exists("CFileCacheCleaner"))
		require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/cache_files_cleaner.php");

	$curentTime = mktime();
	$obCacheCleaner = new CFileCacheCleaner("all");

	if(!$obCacheCleaner->InitPath($path)) return "clean_expire_cache();";
	$obCacheCleaner->Start();
	while($file = $obCacheCleaner->GetNextFile())
	{
		if (is_string($file) && file_exists($file))
		{
			unlink($file);
		}
	}
	return "MypcCleanCacheFiles();";
}


function yetiUpdateProductCntInSection()
{
	CModule::IncludeModule("iblock");
	CModule::IncludeModule("catalog");

	$iblockIds = array(
		98 => 1,//mypc.by - BASE
		109 => 3,//zed.by - Цена ФЛ
	);

	$sObj = new CIBlockSection();

	$sectionRecursiveCnt = function($sid, &$sections) use (&$sectionRecursiveCnt){
		$secCnt = 0;
		if(is_array($sections[$sid]))
		{
			foreach($sections[$sid] as $k=>$sec)
			{
				$sec["UF_PRODUCT_CNT"] += $sectionRecursiveCnt($sec["ID"],$sections);
				$sections[$sid][$k]["UF_PRODUCT_CNT"] = $sec["UF_PRODUCT_CNT"];
				$secCnt += $sec["UF_PRODUCT_CNT"];
			}
		}
		return $secCnt;
	};

	foreach($iblockIds as $iid=>$priceTypeID)
	{
		$sections = array();
		$iblockIDs = array();
		$rs = CIBlockSection::GetList(array(),array("IBLOCK_ID"=>$iid),false,array("ID","IBLOCK_ID","IBLOCK_SECTION_ID","NAME","UF_PRODUCT_CNT","UF_IBLOCK_ID"));
		while($s = $rs->fetch())
		{
				
			$s["UF_PRODUCT_CNT"] = 0;
			$ufIblock = intval($s["UF_IBLOCK_ID"]);
			$parentSection = intval($s["IBLOCK_SECTION_ID"]);
				
			if($ufIblock > 0)
			{
				$filtr = array(
						"IBLOCK_ID"=>$ufIblock,
						">CATALOG_PRICE_".$priceTypeID => 0,
						"ACTIVE" => "Y",
						"SECTION_GLOBAL_ACTIVE" => "Y",
				);
				$cntProd = CIBlockElement::GetList(false,$filtr,array());
				$s["UF_PRODUCT_CNT"] = $cntProd;
			}
				
			$sections[$parentSection][] = $s;
		}

		$sectionRecursiveCnt(0,$sections);

		foreach($sections as $ss)
		{
			foreach($ss as $s)
			{
				$sObj->Update($s["ID"], array("UF_PRODUCT_CNT"=>$s["UF_PRODUCT_CNT"]));
			}
		}

	}

	$GLOBALS["DB"]->Commit();
	return "updateProductCntInSection();";
}

///// useful tools //////
function PrintAdmin($obj)
{
    global  $USER;
    if($USER->IsAdmin())
    {
      echo "<pre style=\"background-color:#FFF;color:#000;font-size:10px;\"><span style=\"color: red;\">PrintAdmin:</span>\n";
      print_r($obj);
      echo "</pre>";
    }
};

function convertPriceToUSD($basePrice){
   $lcur = CCurrency::GetList(($by="name"), ($order1="asc"), LANGUAGE_ID);
   $currency = $lcur->Fetch();
   $priceUSD = round($basePrice / $currency['AMOUNT_CNT']);
   return $priceUSD.' '.'у.е.';//GetMessage("USD");
};

function formatToBYR($price){
   $price =  number_format($price, 0, ',' ,' ');
   $newPrice = $price.' '.GetMessage("BYR");
   return $newPrice;
};

function convertPriceToBYR($basePrice){
   $lcur = CCurrency::GetList(($by="name"), ($order1="asc"), LANGUAGE_ID);
   $currency = $lcur->Fetch();
   $price = $basePrice * $currency['AMOUNT_CNT'];
   $price =  number_format($price, 0, ',' ,' ');
   $newPrice = $price.' '.'Р.';//GetMessage("BYR");

   return $newPrice;
};

/*
AddEventHandler("iblock", "OnBeforePriceAdd", "OnBeforeIBlockElementUpdateHandler");

    // создаем обработчик события "OnBeforeIBlockElementUpdate"
    function OnBeforeIBlockElementUpdateHandler($ID, &$arFields)
    {
        mail("a.broiko@gmail.com", "My Subject", "12312312"); 
    }

*/






?>
