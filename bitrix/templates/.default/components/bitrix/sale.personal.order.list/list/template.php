<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<div class="cabinet-tab-panes">
                    <div class="pane">

                        <div class="orders-intro">
                            <div class="clearfix">
                                <div class="orders-intro-right">
                                    <p><?=GetMessage("STPOL_HINT")?><br/>
                                        <?=GetMessage("STPOL_HINT1")?></p>
                                </div>
			<?
			if ($_REQUEST["filter_history"] == "Y")
			{
			?>
                                <a href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N" class="orders-history-link"><?=GetMessage("STPOL_CUR_ORDERS")?></a>
                        <?
			}
			else
			{
			?>
                                <a href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y&filter_status=F"><?=GetMessage("STPOL_ORDERS_HISTORY")?></a>
                        <?
			}
			echo "<br /><br />";
			$bNoOrder = true;
                        ?>
                           </div> <!-- end of clearfix-->
                        </div> <!-- end of orders-info-->
<?


                        foreach($arResult["ORDER_BY_STATUS"] as $key => $val)
			{
				$bShowStatus = true;
				foreach($val as $vval)
				{
					$bNoOrder = false;
					$bShowStatus = false;
					?>
					<div class="order-info-block-wrap">
						<tr>
							<td>
                                                                <h2 class="order-subheader"><strong><?=GetMessage("STPOL_ORDER_NO")?></strong> <?=$vval["ORDER"]["ACCOUNT_NUMBER"]?> 
								   <?=GetMessage("STPOL_FROM")?>
								   <?= $vval["ORDER"]["DATE_INSERT"]; ?>
                                                                </h2>

                            <div class="ordering-wrap">
                                <div class="double-border-wrap">
                                    <div class="double-border">
                                        <div class="form-fields clearfix">
								<?
								if ($vval["ORDER"]["CANCELED"] == "Y")
									echo GetMessage("STPOL_CANCELED");
								?>
                                           <table class="order-table">
                                              <tr>
                                                 <td><?=GetMessage("STPOL_SUM")?></td>
                                                 <td><strong><?=$vval["ORDER"]["FORMATED_PRICE"]?></strong></td>
                                              </tr>

                                              <tr>
                                                 <td><?=GetMessage("STPOL_STATE_OF_PAYMENT");?></td>
                                                 <td>
						 <?if($vval["ORDER"]["PAYED"]=="Y")
						    echo GetMessage("STPOL_PAYED_Y");
						 else
						    echo GetMessage("STPOL_PAYED_N");
						 ?>
                                                 </td>
                                              </tr>

                                              <?if(IntVal($vval["ORDER"]["PAY_SYSTEM_ID"])>0):?>
                                              <tr>
                                                    <td><?=GetMessage("P_PAY_SYS")?></td>
						    <td><?=$arResult["INFO"]["PAY_SYSTEM"][$vval["ORDER"]["PAY_SYSTEM_ID"]]["NAME"];?>
                                              </tr>
                                              <?endif;?>

                                              <tr>
                                                 <td><?echo GetMessage("STPOL_STATUS_T")?></td>
                                                 <td>
                                                    <?=$arResult["INFO"]["STATUS"][$vval["ORDER"]["STATUS_ID"]]["NAME"]?>
                                                    <?=GetMessage("STPOL_STATUS_FROM")?>
                                                    <?=$vval["ORDER"]["DATE_STATUS"];?>
                                                 </td>
                                              </tr>


                                              <?if(IntVal($vval["ORDER"]["DELIVERY_ID"])>0):?>
                                              <tr>
                                                 <td><?=GetMessage("P_DELIVERY");?></td>
                                                 <td><?=$arResult["INFO"]["DELIVERY"][$vval["ORDER"]["DELIVERY_ID"]]["NAME"];?></td>
                                              </tr>
                                              <?elseif (strpos($vval["ORDER"]["DELIVERY_ID"], ":") !== false):?>
                                              <tr>
                                                 <td><?=GetMessage("P_DELIVERY");?></td>
                                                 <?$arId = explode(":", $vval["ORDER"]["DELIVERY_ID"]);?>
                                                 <td><?=$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]." (".$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"].")";?></td>
                                              </tr>
                                              <? endif;?>

                                              <tr>
                                                 <td><?=GetMessage("STPOL_CONTENT")?></td>
                                                 <td>
                                                    <table class="order-table-details">
                                                    <?
						       foreach ($vval["BASKET_ITEMS"] as $vvval):
						          $measure = (isset($vvval["MEASURE_TEXT"])) ? $vvval["MEASURE_TEXT"] : GetMessage("STPOL_SHT");
						    ?>
                                                       <tr>
                                                          <td>
                                                          <?
                                                          if (strlen($vvval["DETAIL_PAGE_URL"]) > 0)
							     echo "<a href=\"".$vvval["DETAIL_PAGE_URL"]."\">";
							     echo $vvval["NAME"];
							  if (strlen($vvval["DETAIL_PAGE_URL"]) > 0)
							     echo "</a>";
						          ?>
                                                          </td>
                                                          <td><?=$vvval["QUANTITY"] ?><?=$measure?></td>
                                                       </tr>
                                                    <?endforeach;?>
                                                    </table>
                                                 </td>
                                              </tr>
                                           </table>
                                           
                                           <div class="order-table-footer">
                                              <a title="<?= GetMessage("STPOL_DETAIL_ALT") ?>" href="<?=$vval["ORDER"]["URL_TO_DETAIL"]?>" class="order-table-link1"><?=GetMessage("STPOL_DETAILS") ?></a>
                                              <a title="<?= GetMessage("STPOL_REORDER") ?>" href="<?=$vval["ORDER"]["URL_TO_COPY"]?>" class="order-table-link2"><?=GetMessage("STPOL_REORDER1") ?></a>
                                              <?if ($vval["ORDER"]["CAN_CANCEL"] == "Y"):?>
					      <a title="<?= GetMessage("STPOL_CANCEL") ?>" href="<?=$vval["ORDER"]["URL_TO_CANCEL"]?>" class="order-table-link3"><?= GetMessage("STPOL_CANCEL") ?></a>
					      <?endif;?>                                              
                                           </div>
                                        </div> <!-- end of order-info-block-wrap-->
 
                                     </div> <!-- end of form-fields clearfix --> 
                                  </div> <!-- end of double-border -->
                               </div> <!-- end of double-border-wrap -->
                            </div> <!-- end of ordering wrap -->

				<?
				}
			}
                        ?>
                                    

<?
	$APPLICATION->IncludeComponent("bitrix:socserv.auth.split", "twitpost", array(
			"SHOW_PROFILES" => "Y",
			"ALLOW_DELETE" => "Y"
		),
		false
	);
?>

                    </div> <!-- end of pane-->
</div><!-- end of cabinet-tab-panes-->



<!--

                        <div class="order-info-block-wrap">
                            <h2 class="order-subheader"><strong>Заказ №316</strong> от 23.12.2013 (18:31)</h2>

                            <div class="ordering-wrap">
                                <div class="double-border-wrap">
                                    <div class="double-border">
                                        <div class="form-fields clearfix">

                                            <table class="order-table">
                                                <tr>
                                                    <td>Сумма</td>
                                                    <td><strong>841 500 руб</strong>.</td>
                                                </tr>
                                                <tr>
                                                    <td>Состояние оплаты</td>
                                                    <td>Не оплачен</td>
                                                </tr>
                                                <tr>
                                                    <td>Способ оплаты</td>
                                                    <td>Наличными курьеру</td>
                                                </tr>
                                                <tr>
                                                    <td>Статус</td>
                                                    <td>Есть договоренность с клиентом от 23.12.2013 (17:44)</td>
                                                </tr>
                                                <tr>
                                                    <td>Способ доставки</td>
                                                    <td>Самовывоз</td>
                                                </tr>
                                                <tr>
                                                    <td>Состав заказа</td>
                                                    <td>
                                                        <table class="order-table-details">
                                                            <tr>
                                                                <td>Ноутбук Packard Bell EasyNote TE69KB-12502G32Mnsk (NX.C2CER.010)</td>
                                                                <td>1 шт.</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ноутбук Lenovo B590 (59381391)</td>
                                                                <td>1 шт.</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ноутбук HP 2000-2d52SR (F1W78EA)</td>
                                                                <td>1 шт.</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Ноутбук Dell Inspiron 3521 (3521-8249)</td>
                                                                <td>1 шт.</td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <div class="order-table-footer">
                                                <a href="#" class="order-table-link1">Подробнее</a>
                                                <a href="#" class="order-table-link2">Повторить заказ</a>
                                                <a href="#" class="order-table-link3">Отменить заказ</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




</br>
</br>
</br>
</br>
</br>

-->









<?if(false):?>

<table border="0" cellspacing="0" cellpadding="5">
	<tr>
		<td width="60%">
			<?
			if ($_REQUEST["filter_history"] == "Y")
			{
				?><a href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=N"><?echo GetMessage("STPOL_CUR_ORDERS")?></a><?
			}
			else
			{
				?><a href="<?=$arResult["CURRENT_PAGE"]?>?filter_history=Y&filter_status=F"><?echo GetMessage("STPOL_ORDERS_HISTORY")?></a><?
			}
			echo "<br /><br />";
			$bNoOrder = true;

			foreach($arResult["ORDER_BY_STATUS"] as $key => $val)
			{
				$bShowStatus = true;
				foreach($val as $vval)
				{
					$bNoOrder = false;
					if($bShowStatus)
					{
						?><h2><?echo GetMessage("STPOL_STATUS")?> "<?=$arResult["INFO"]["STATUS"][$key]["NAME"] ?>"</h2>
						<small><?=$arResult["INFO"]["STATUS"][$key]["DESCRIPTION"] ?></small>
					<?
					}
					$bShowStatus = false;
					?>
					<table class="sale_personal_order_list">
						<tr>
							<td>
								<b>
								<?echo GetMessage("STPOL_ORDER_NO")?>
								<a title="<?echo GetMessage("STPOL_DETAIL_ALT")?>" href="<?=$vval["ORDER"]["URL_TO_DETAIL"] ?>"><?=$vval["ORDER"]["ACCOUNT_NUMBER"]?></a>
								<?echo GetMessage("STPOL_FROM")?>
								<?= $vval["ORDER"]["DATE_INSERT"]; ?>
								</b>
								<?
								if ($vval["ORDER"]["CANCELED"] == "Y")
									echo GetMessage("STPOL_CANCELED");
								?>
								<br />
								<b>
								<?echo GetMessage("STPOL_SUM")?>
								<?=$vval["ORDER"]["FORMATED_PRICE"]?>
								</b>
								<?if($vval["ORDER"]["PAYED"]=="Y")
									echo GetMessage("STPOL_PAYED_Y");
								else
									echo GetMessage("STPOL_PAYED_N");
								?>
								<?if(IntVal($vval["ORDER"]["PAY_SYSTEM_ID"])>0)
									echo GetMessage("P_PAY_SYS").$arResult["INFO"]["PAY_SYSTEM"][$vval["ORDER"]["PAY_SYSTEM_ID"]]["NAME"]?>
								<br />
								<b><?echo GetMessage("STPOL_STATUS_T")?></b>
								<?=$arResult["INFO"]["STATUS"][$vval["ORDER"]["STATUS_ID"]]["NAME"]?>
								<?echo GetMessage("STPOL_STATUS_FROM")?>
								<?=$vval["ORDER"]["DATE_STATUS"];?>
								<br />
								<?if(IntVal($vval["ORDER"]["DELIVERY_ID"])>0)
								{
									echo "<b>".GetMessage("P_DELIVERY")."</b>".$arResult["INFO"]["DELIVERY"][$vval["ORDER"]["DELIVERY_ID"]]["NAME"];
								}
								elseif (strpos($vval["ORDER"]["DELIVERY_ID"], ":") !== false)
								{
									echo "<b>".GetMessage("P_DELIVERY")."</b>";
									$arId = explode(":", $vval["ORDER"]["DELIVERY_ID"]);
									echo $arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["NAME"]." (".$arResult["INFO"]["DELIVERY_HANDLERS"][$arId[0]]["PROFILES"][$arId[1]]["TITLE"].")";
								}
								?>
							</td>
						</tr>
						<tr>
							<td>
								<table class="sale_personal_order_list_table">
									<tr>
										<td width="0%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
										<td width="100%">
											<b><?=GetMessage("STPOL_CONTENT")?></b>
										</td>
										<td width="0%">&nbsp;</td>
									</tr>
									<?
									foreach ($vval["BASKET_ITEMS"] as $vvval)
									{
										$measure = (isset($vvval["MEASURE_TEXT"])) ? $vvval["MEASURE_TEXT"] : GetMessage("STPOL_SHT");
										?>
										<tr>
											<td width="0%">&nbsp;&nbsp;&nbsp;&nbsp;</td>
											<td width="100%">

												<?
												if (strlen($vvval["DETAIL_PAGE_URL"]) > 0)
													echo "<a href=\"".$vvval["DETAIL_PAGE_URL"]."\">";
												echo $vvval["NAME"];
												if (strlen($vvval["DETAIL_PAGE_URL"]) > 0)
													echo "</a>";
												?>
											</td>
											<td width="0%" nowrap><?= $vvval["QUANTITY"] ?> <?=$measure?></td>
										</tr>
										<?
									}
									?>
								</table>
							</td>
						</tr>
						<tr>
							<td align="right">
								<a title="<?= GetMessage("STPOL_DETAIL_ALT") ?>" href="<?=$vval["ORDER"]["URL_TO_DETAIL"]?>"><?= GetMessage("STPOL_DETAILS") ?></a>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<a title="<?= GetMessage("STPOL_REORDER") ?>" href="<?=$vval["ORDER"]["URL_TO_COPY"]?>"><?= GetMessage("STPOL_REORDER1") ?></a>
								<?if ($vval["ORDER"]["CAN_CANCEL"] == "Y"):?>
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<a title="<?= GetMessage("STPOL_CANCEL") ?>" href="<?=$vval["ORDER"]["URL_TO_CANCEL"]?>"><?= GetMessage("STPOL_CANCEL") ?></a>
								<?endif;?>
							</td>
						</tr>
					</table>
					<br />
				<?
				}
				?>
				<br />
				<?
			}

			if ($bNoOrder)
			{
				?><center><?echo GetMessage("STPOL_NO_ORDERS")?></center><?
			}
			?>
		</td>
		<td width="5%" rowspan="3">&nbsp;</td>
		<td width="35%" rowspan="3" valign="top">
			<?=GetMessage("STPOL_HINT")?><br /><br />
			<?=GetMessage("STPOL_HINT1")?>
		</td>
	</tr>
</table>

<?endif; //старая вёрстка?>