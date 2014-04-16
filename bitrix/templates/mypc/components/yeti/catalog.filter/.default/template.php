<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
CModule::IncludeModule("catalog");

if(is_array($arResult["FILTER_ITEMS"]) && count($arResult["FILTER_ITEMS"]) > 0)
{
	?>
	<!-- Параметры -->
	<form method="post" id="filter-param-form">
	<?
	$showParams = array(
		"MENU_IBLOCK_ID",
		"MENU_SECTION_ID",
		"CATALOG_SECTION_ID",
		"CATALOG_GROUP_ID",
		"PRICE_CURRENCY",
	);
	foreach($showParams as $p)
	{
		?>
		<input type="hidden" name="<?=$p?>" value="<?=$arParams[$p]?>" />
		<?
	}
	?>
	<div class="sidebar-block-wrap">
	<div class="typical sidebar-white-block">
		<ul class="parameters">
			<?
			foreach($arResult["FILTER_ITEMS"] as $arItem)
			{
				$this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arParams["MENU_IBLOCK_ID"], "ELEMENT_EDIT"));
				$this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arParams["MENU_IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BCS_ELEMENT_DELETE_CONFIRM')));
				
				$proFilterHide = false;
				if($arItem["PRO_FILTER"] == "Y" && $arItem["ACTIVE"] != "Y" )
				{
					$proFilterHide = true;
				}
				
				switch($arItem["VIEW_TYPE"])
				{
					case "select":
						$inputName = $arItem["CONTROL_NAME"];
						$size = intval($arItem["VALUES_CNT"]);
						if($size == 0) $size = 5;
						?>
						<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?=$proFilterHide?"class='item-pro-filter' style='display:none;'":""?>>
							<h2 class="active"><?=$arItem["NAME"]?><i class="i-trigger"></i></h2>
							<div class="panel">
								<?
								$isSelected = false;
								$selectedVal = array();
								foreach($arItem["LIST_VALUES"] as $vid => $val)
								{
									if(in_array($vid,$arItem["VALUE"]))
									{
										$isSelected = true;
										$selectedVal[$vid] = $val;
									}
								}
								
								if($isSelected)
								{
									foreach($selectedVal as $vid=>$val)
									{
										$hash = md5($arItem["PROPERTY_ID"]."/".$vid);
										?>
										<div class="filter-select-val">
											<input type="hidden" name="<?=$inputName?>" value="<?=$vid?>" id="filter-property-<?=$hash?>">
											<?=$val?> <span title="Убрать параметр из фильтра" class="delete-filter-prop" data-id="<?=$hash?>">&times;</span>
										</div>
										<?
									}
								}
								else
								{
									
									if($arItem["MULTIPLE"] == "Y")
									{
										?><p class="select-multiple-wrap sidebar-size small-height"><?
									}
									else
									{
										?><p class="select-wrap sidebar-size"><?
									}
									?>
									<select class="formstyler" name="<?=$inputName?>" <?=($arItem["MULTIPLE"] == "Y")?"multiple='multiple' size='".$size."'":""?> >
										<option value="">--- выберите ---</option>
										<?
										natsort($arItem["LIST_VALUES"]);
										foreach($arItem["LIST_VALUES"] as $vid => $val)
										{
											$selected = "";
											if(is_array($arItem["VALUE"]))
											{
												$selected = in_array($vid,$arItem["VALUE"])?"selected='selected'":"";
											}
											
											$val = strip_tags($val);
											?><option <?=$selected?> value="<?=$vid?>"><?=htmlspecialcharsEx($val)?></option><?
										}
										?>
									</select>
									</p>
									<?
									
									
									
									
								}
								?>
							</div>
						</li>
						<?
						break;
					case "checkbox":
						?>
						<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?=$proFilterHide?"class='item-pro-filter' style='display:none;'":""?>>
							<h2 class="active"><?=$arItem["NAME"]?><i class="i-trigger"></i></h2>
							<div class="panel">
								<ul class="checkbox-list">
									<?
									$viewCnt = intval($arItem["VALUES_CNT"]);
									if($viewCnt == 0) $viewCnt = 5;
									
									$cnt = count($arItem["LIST_VALUES"]);
									if(($cnt - $viewCnt) < 5)$viewCnt = $cnt;// нет смысла скрывать малое количество пунктов
									
									$i = 0;
									$inputType = "radio";
									$inputName = $arItem["CONTROL_NAME"];
									
									$checkboxOne = "";
									
									if($arItem["MULTIPLE"] == "Y" || $cnt == 1)
									{	
										$inputType = "checkbox";
										if($cnt == 1) $checkboxOne = "checkboxOne";
									}
									natsort($arItem["LIST_VALUES"]);
									foreach($arItem["LIST_VALUES"] as $vid => $val)
									{
										$val = strip_tags($val);
										$hide = ($i>$viewCnt)?"class='hide'":"";
										
										$checked = "";
										if(is_array($arItem["VALUE"]))
										{
											$checked = in_array($vid,$arItem["VALUE"])?"checked='checked'":"";
										}
										
										?>
										<li <?=$hide?> ><label><input class="<?=$checkboxOne?>" <?=$checked?> type="<?=$inputType?>" name="<?=$inputName?>" value="<?=$vid?>"><?=htmlspecialcharsEx($val)?></label></li>
										<?
										$i++;
									}
									?>
								</ul>
								<?
								if($viewCnt < $cnt)
								{
									$cntHided = $cnt-$viewCnt;
									?>
									<a href="#" class="show-others">
										<span>Показать ещё <?=$cntHided?></span>
										<span class="hide">Скрыть <?=$cntHided?></span>
									</a>
									<?
								}
								?>
							</div>
						</li>
						<?
						break;
					case "slider":
						if($arItem["PROPERTY_ID"] == "PRICE")
						{
							if($arItem["SLIDER_RANGE"]["CURRENCY"] == "BYR")
							{
								$sectionMinPrice = 0;
								$sectionMaxPrice = 50000000;
								
								if (!empty($arItem["SLIDER_RANGE"]["MIN"])) $sectionMinPrice = intval($arItem["SLIDER_RANGE"]["MIN"]);
								if (!empty($arItem["SLIDER_RANGE"]["MAX"])) $sectionMaxPrice = intval($arItem["SLIDER_RANGE"]["MAX"]);
								
								$minPrice = $arItem["VALUE"]["MIN"];
								$maxPrice = $arItem["VALUE"]["MAX"];
								
								$step = 100000;
								//PR(($sectionMaxPrice - $sectionMinPrice));
								if(($sectionMaxPrice - $sectionMinPrice) > 5000000) $step = 1000000;
								
								//PR($step);
								
								$sectionShowMinPrice = floor($sectionMinPrice/$step);
								$sectionShowMaxPrice = ceil($sectionMaxPrice/$step);
								?>
								<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?=$proFilterHide?"class='item-pro-filter' style='display:none;'":""?>>
									<?
									//PR(array($sectionMinPrice,$sectionMaxPrice));
									?>
									<h2 class="active">Цена<i class="i-trigger"></i></h2>
									<div class="panel">
										<ul class="ranges-list b-price-range-links">
											<?
											$showStep = floor(($sectionMaxPrice - $sectionMinPrice)/5);
											$priceFrom = false;
											$priceTo = $sectionMinPrice + $showStep;
											while($priceTo < $sectionMaxPrice)
											{
												
												$priceFrom_f = floor($priceFrom/$step)*$step;
												$priceFrom_f_show = floor($priceFrom/$step);
												
												$priceTo_f = floor($priceTo/$step)*$step;
												$priceTo_f_show = floor($priceTo/$step);
												
												if($step == 1000000)
												{
													$priceTo_f_show = $priceTo_f_show." млн.";
												}
												else
												{
													$priceFrom_f_show = ($priceFrom_f_show*100);
													$priceTo_f_show = ($priceTo_f_show*100)." т.";
												}
												
												$queryParams = "SET_FILTER=Y&".$arItem["CONTROL_NAME"]."[MIN]=".$priceFrom_f;
												$queryParams .= "&".$arItem["CONTROL_NAME"]."[MAX]=".$priceTo_f;
												$urlPrice = $GLOBALS["APPLICATION"]->GetCurPageParam($queryParams,array("SET_FILTER",$arItem["CONTROL_NAME"],"AJAX_CALL","URL","action"));
												?>
												<li>
													<a data-price-min="<?=$priceFrom_f?>" data-price-max="<?=$priceTo_f?>" href="<?=$urlPrice?>">
														<?
														if($priceFrom)
														{
															?>
															от <?=$priceFrom_f_show?>
															<?
														}
														?>
														до <?=$priceTo_f_show?> руб.
													</a>
												</li>
												<?
												$priceFrom = $priceTo;
												$priceTo += $showStep;
											}
											
											$priceFrom = $priceTo;
											if($priceFrom)
											{
												$priceFrom_f = floor($priceFrom/$step)*$step;
												$priceFrom_f_show = floor($priceTo/$step);
												if($step == 1000000)
												{
													$priceFrom_f_show = $priceFrom_f_show." млн.";
												}
												else
												{
													$priceFrom_f_show = ($priceFrom_f_show*100)." т.";
												}
												
												$queryParams = "SET_FILTER=Y&".$arItem["CONTROL_NAME"]."[MIN]=".$priceFrom_f;
												$urlPrice = $GLOBALS["APPLICATION"]->GetCurPageParam($queryParams,array("SET_FILTER",$arItem["CONTROL_NAME"],"AJAX_CALL","URL","action"));
												?>
												<li>
													<a data-price-min="<?=$priceFrom_f?>" data-price-max="<?=$sectionMaxPrice?>" href="<?=$urlPrice?>">от <?=$priceFrom_f_show?> руб.</a>
												</li>
												<?
											}
											?>
										</ul>
										<div id="price-range-wrap">
											<div id="price-range" class="b-price-range">
												<span id="range-start">от <?=($step == 100000)?($sectionShowMinPrice*100)." т.":$sectionShowMinPrice." млн."?> руб.</span>
												<span id="range-end">до <?=($step == 100000)?($sectionShowMaxPrice*100)." т.":$sectionShowMaxPrice." млн."?> руб.</span>
											</div>
											<div class="clearfix">
												<div class="fl">
													от <p class="input-text-wrap slider-size"><input type="text" style="line-height: 14pt;font-size: 8pt" name="<?=$arItem["CONTROL_NAME"]?>[MIN]" id="left-slider-value" class="input-text" value="<?=$minPrice?>"  /></p>
												</div>
												<div class="fr">
													до <p class="input-text-wrap slider-size"><input type="text" style="line-height: 14pt;font-size: 8pt" name="<?=$arItem["CONTROL_NAME"]?>[MAX]" id="right-slider-value" class="input-text" value="<?=$maxPrice?>"  /></p>
												</div>
											</div>
										</div>
									</div>
									<script>
									$(function(){
										$(".b-price-range-links a").click(function(e){
											e.preventDefault ? e.preventDefault() : e.returnValue = false;
											var minVal = $(this).attr("data-price-min");
											var maxVal = $(this).attr("data-price-max");
											var step = <?=$step?>;
											$( "#left-slider-value").val( minVal );
											$( "#right-slider-value").val( maxVal );
											minVal = minVal/step;
											maxVal = maxVal/step;
											$(".b-price-range").slider({ values: [ minVal, maxVal ] });
											$( "#left-slider-value").change();
										});
										
										
										// Ценовой слайдер
										<?
										$sliderInitValueFrom = $sectionShowMinPrice;
										if($minPrice > 0) $sliderInitValueFrom = floatval($minPrice/$step);
										$sliderInitValueTo = $sectionShowMaxPrice;
										if($maxPrice > 0) $sliderInitValueTo = floatval($maxPrice/$step);
										?>
										$(".b-price-range").slider({
											range: true,
											min: <?=$sectionShowMinPrice?>,
											max: <?=$sectionShowMaxPrice?>,
											values: [ <?=$sliderInitValueFrom?>, <?=$sliderInitValueTo?> ],
											slide: function( event, ui ) {
												var step = <?=$step?>;
												$( "#left-slider-value").val( ui.values[0] * step );
												$( "#right-slider-value").val( ui.values[1] * step );
											},
											stop:function( event, ui ) {
												if(ui.value == ui.values[0]) $( "#left-slider-value").change();
												else $( "#right-slider-value").change();
											}
										});
									});
									</script>
								</li>
								<?
							}
							else
							{
								$sectionMinPrice = 0;
								$sectionMaxPrice = 1000000;
								
								if (!empty($arItem["SLIDER_RANGE"]["MIN"])) $sectionMinPrice = intval($arItem["SLIDER_RANGE"]["MIN"]);
								if (!empty($arItem["SLIDER_RANGE"]["MAX"])) $sectionMaxPrice = intval($arItem["SLIDER_RANGE"]["MAX"]);
								
								$minPrice = $arItem["VALUE"]["MIN"];
								$maxPrice = $arItem["VALUE"]["MAX"];
								
								$step = 10;
								
								$sectionShowMinPrice = floor($sectionMinPrice/$step) * $step;
								$sectionShowMinPrice_f = CurrencyFormat($sectionShowMinPrice,$arItem["SLIDER_RANGE"]["CURRENCY"]);
								$sectionShowMinPrice_f = preg_replace("#[\.,]0+$#","",$sectionShowMinPrice_f);
								$sectionShowMaxPrice = ceil($sectionMaxPrice/$step) * $step;
								$sectionShowMaxPrice_f = CurrencyFormat($sectionShowMaxPrice,$arItem["SLIDER_RANGE"]["CURRENCY"]);
								$sectionShowMaxPrice_f = preg_replace("#[\.,]0+$#","",$sectionShowMaxPrice_f);
								?>
								<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?=$proFilterHide?"class='item-pro-filter' style='display:none;'":""?>>
									<h2 class="active">Цена<i class="i-trigger"></i></h2>
									<div class="panel">
										<div id="price-range-wrap">
											<div id="price-range" class="b-price-range">
												<span id="range-start">от <?=$sectionShowMinPrice_f?></span>
												<span id="range-end">до <?=$sectionShowMaxPrice_f?></span>
											</div>
											<div class="clearfix">
												<div class="fl">
													от <p class="input-text-wrap slider-size"><input type="text" name="<?=$arItem["CONTROL_NAME"]?>[MIN]" id="left-slider-value" class="input-text"  value="<?=$minPrice?>"  /></p>
												</div>
												<div class="fr">
													до <p class="input-text-wrap slider-size"><input type="text" name="<?=$arItem["CONTROL_NAME"]?>[MAX]" id="right-slider-value" class="input-text"  value="<?=$maxPrice?>"  /></p>
												</div>
											</div>
										</div>
									</div>
									<script>
									$(function(){
										// Ценовой слайдер
										<?
										$sliderInitValueFrom = $sectionShowMinPrice;
										if($minPrice > 0) $sliderInitValueFrom = $minPrice;
										$sliderInitValueTo = $sectionShowMaxPrice;
										if($maxPrice > 0) $sliderInitValueTo = $maxPrice;
										?>
										$(".b-price-range").slider({
											range: true,
											min: <?=$sectionShowMinPrice?>,
											max: <?=$sectionShowMaxPrice?>,
											values: [ <?=$sliderInitValueFrom?>, <?=$sliderInitValueTo?> ],
											step: <?=$step?>,
											slide: function( event, ui ) {
												//var step = <?=$step?>;
												$( "#left-slider-value" ).val( ui.values[0]);// * step 
												$( "#right-slider-value" ).val( ui.values[1]);// * step 
											},
											stop:function( event, ui ) {
												if(ui.value == ui.values[0]) $( "#left-slider-value").change();
												else $( "#right-slider-value").change();
											}
										});
									});
									</script>
								</li>
								<?
							}
						}
						else
						{
							$min = $arItem["VALUE"]["MIN"];
							$max = $arItem["VALUE"]["MAX"];
							
							if($min != $max && $max > $min)
							{
								?>
								<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?=$proFilterHide?"class='item-pro-filter' style='display:none;'":""?>>
									<h2 class="active"><?=$arItem["NAME"]?><i class="i-trigger"></i></h2>
									<div class="panel">
										<div id="price-range-wrap">
											<div id="price-range" class="slider-<?=$arItem["PROPERTY_ID"]?>">
												<span id="range-start">от <?=$arItem["SLIDER_RANGE"]["MIN"]?></span>
												<span id="range-end">до <?=$arItem["SLIDER_RANGE"]["MAX"]?></span>
											</div>
											<div class="clearfix">
												<div class="fl">
													от <p class="input-text-wrap slider-size"><input type="text" name="<?=$arItem["CONTROL_NAME"]?>[MIN]" id="left-slider-value-<?=$arItem["PROPERTY_ID"]?>" class="input-text" value="<?=$min?>" /></p>
												</div>
												<div class="fr">
													до <p class="input-text-wrap slider-size"><input type="text" name="<?=$arItem["CONTROL_NAME"]?>[MAX]" id="right-slider-value-<?=$arItem["PROPERTY_ID"]?>" class="input-text" value="<?=$max?>" /></p>
												</div>
											</div>
										</div>
									</div>
									<script>
									$(function(){
										// Ценовой слайдер
										<?
										
										$initMin = $arItem["SLIDER_RANGE"]["MIN"];
										if($min > 0)$initMin = $min;
										$initMax = $arItem["SLIDER_RANGE"]["MAX"];
										if($max > 0)$initMax = $max;
										?>
										$(".slider-<?=$arItem["PROPERTY_ID"]?>").slider({
											range: true,
											min: <?=$arItem["SLIDER_RANGE"]["MIN"]?>,
											max: <?=$arItem["SLIDER_RANGE"]["MAX"]?>,
											values: [ <?=$initMin?>, <?=$initMax?> ],
											slide: function( event, ui ) {
												//var step = <?=$step?>;
												$( "#left-slider-value-<?=$arItem["PROPERTY_ID"]?>" ).val( ui.values[0]);// * step 
												$( "#right-slider-value-<?=$arItem["PROPERTY_ID"]?>" ).val( ui.values[1]);// * step 
											},
											stop:function( event, ui ) {
												if(ui.value == ui.values[0]) $( "#left-slider-value-<?=$arItem["PROPERTY_ID"]?>" ).change();
												else $( "#right-slider-value-<?=$arItem["PROPERTY_ID"]?>" ).change();
											}
										});
									});
									</script>
								</li>
								<?
							}
							
						}
						break;
					default:
						?>
						<li id="<?=$this->GetEditAreaId($arItem['ID']);?>" <?=$proFilterHide?"class='item-pro-filter' style='display:none;'":""?>>
							<h2 class="active"><?=$arItem["NAME"]?><i class="i-trigger"></i></h2>
							<div class="panel">
								<p class="input-text-wrap">
									<input type="text" name="<?=$arItem["CONTROL_NAME"]?>" class="input-text" value="<?=htmlspecialcharsEx($arItem["VALUE"])?>" />
								</p>
							</div>
						</li>
						<?
						break;
				}
			}
			?>
		</ul>
		<?
		if(intval($arResult["HIDED_CNT"]) > 0)
		{
			?>
			<a href="#" class="all-parameters filter-show-all">Все параметры</a>
			<?
		}
		?>
		<input type="hidden" name="SET_FILTER" value="Y" />
		<table style="width:100%;" class="b-filter-buttons-wr">
			<tr>
				<td style="padding-right:5px;">
					<input type="submit" name="" value="Найти" class="simple-btn" style="<?=$style?>"/>
				</td>
				<td><a href="<?=$arResult["RESET_URL"]?>" id="resetFilterBtn" class="simple-btn" style="<?=$style?>">Сбросить</a></td>
			</tr>
		</table>
	</div>
	</div>
	</form>
	<?
}


?>

<script>
function zedSubmitFilterForm()
{
	$("#filter-param-form .sidebar-grey-block").addClass("loading-field");
	$(".b-ajax-section-wrapper .loading-wrapper").show();
	var formData = $("#filter-param-form").serialize();
	$.post("/ajax.php?action=updateFilterBlock&AJAX_CALL=Y&URL="+document.URL,formData,function(data){
		
		$(".filter-show-all").click(function(e){
			e.preventDefault ? e.preventDefault() : e.returnValue = false;
			$(".item-pro-filter").toggle();
		});
		
		$(".b-filter-params-wrapper").html(data);
		$('#filter-param-form input[type="checkbox"],#filter-param-form select').styler({
			browseText: 'Выбрать файл',
			singleSelectzIndex: '809'
		});
		
		
		$("#filter-param-form .show-others").click(function() {
			var $link = $(this);
			$link.find('span').toggleClass('hide');
			$link.parent().find('.checkbox-list .hide').fadeToggle().css('display','inline-block');
			return false;
		});
		
		$(".b-ajax-section-wrapper").load(document.URL,{"AJAX_SECTION_CALL":"Y"},function(){
			// 
		});
	});
}

$(function(){

	$(".delete-filter-prop").click(function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var propID = $(this).attr("data-id");
		$("#filter-property-"+propID).remove();
		zedSubmitFilterForm();
	});

	
	$("#filter-param-form").submit(function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		zedSubmitFilterForm();
	});

	$(".filter-show-all").click(function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		$(".item-pro-filter").toggle();
	});
	
	$("#filter-param-form .panel input, #filter-param-form .panel select").not("input[type=checkbox]").not("select[multiple]").change(function(){
		zedSubmitFilterForm();
	});
	
	
	$("#filter-param-form .panel input[type=checkbox]:checked, #filter-param-form .panel select[multiple][value!='']").change(function(){
		zedSubmitFilterForm();
	});
	
	
	
	$("#resetFilterBtn").click(function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		$("#filter-param-form .sidebar-grey-block").addClass("loading-field");
		$(".b-ajax-section-wrapper .loading-wrapper").show();
		
		var MENU_IBLOCK_ID = $("#filter-param-form input[name=MENU_IBLOCK_ID]").val();
		var MENU_SECTION_ID = $("#filter-param-form input[name=MENU_SECTION_ID]").val();
		var CATALOG_SECTION_ID = $("#filter-param-form input[name=CATALOG_SECTION_ID]").val();
		var CATALOG_GROUP_ID = $("#filter-param-form input[name=CATALOG_GROUP_ID]").val();
		var PRICE_CURRENCY = $("#filter-param-form input[name=PRICE_CURRENCY]").val();
		
		var formData = {
			"RESET_FILTER":"Y",
			"MENU_IBLOCK_ID":MENU_IBLOCK_ID,
			"MENU_SECTION_ID":MENU_SECTION_ID,
			"CATALOG_SECTION_ID":CATALOG_SECTION_ID,
			"CATALOG_GROUP_ID":CATALOG_GROUP_ID,
			"PRICE_CURRENCY":PRICE_CURRENCY,
			};
		
		$.post("/ajax.php?action=updateFilterBlock&AJAX_CALL=Y&URL="+document.URL,formData,function(data){
		
			$(".filter-show-all").click(function(e){
				e.preventDefault ? e.preventDefault() : e.returnValue = false;
				$(".item-pro-filter").toggle();
			});
			
			$(".b-filter-params-wrapper").html(data);
			$('#filter-param-form input[type="checkbox"],#filter-param-form select').styler({
				browseText: 'Выбрать файл',
				singleSelectzIndex: '809'
			});
			
			
			$("#filter-param-form .show-others").click(function() {
				var $link = $(this);
				$link.find('span').toggleClass('hide');
				$link.parent().find('.checkbox-list .hide').fadeToggle().css('display','inline-block');
				return false;
			});
			
			$(".b-ajax-section-wrapper").load(document.URL,{"AJAX_SECTION_CALL":"Y"},function(){
				// 
			});
		});
		
	});
	
});
</script>