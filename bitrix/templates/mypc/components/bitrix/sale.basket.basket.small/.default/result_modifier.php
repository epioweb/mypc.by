<?
CModule::IncludeModule("catalog");

if(!function_exists("zedPluralForm"))
{
	function zedPluralForm($n, $form1, $form2, $form5)
	{
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20) return $form5;
		if ($n1 > 1 && $n1 < 5) return $form2;
		if ($n1 == 1) return $form1;
		return $form5;
	}
}

$arResult["CAN_BUY_CNT"] = 0;
$arResult["CAN_BUY_SUM"] = 0;

$currency = ($_SESSION["CATALOG_CURRENCY"]=="USD")?"USD":"BYR";

foreach ($arResult["ITEMS"] as $v)
{
	if ($v["DELAY"]=="N" && $v["CAN_BUY"]=="Y")
	{
		$arResult["CAN_BUY_CNT"]++;
		$priceVal = floatval($v["PRICE"]);
		$priceCurrency = $v["CURRENCY"];
		if($priceCurrency != $currency) $priceVal = CCurrencyRates::ConvertCurrency($priceVal, $priceCurrency, $currency);
		
		$arResult["CAN_BUY_SUM"] += $priceVal * $v["QUANTITY"];
	}
}

$arResult["CAN_BUY_SUM_F"] = CurrencyFormat(floatval($arResult["CAN_BUY_SUM"]),$currency);
$arResult["CAN_BUY_CNT_PLURAL"] = $arResult["CAN_BUY_CNT"]." ".zedPluralForm($arResult["CAN_BUY_CNT"], "товар", "товара", "товаров");
?>