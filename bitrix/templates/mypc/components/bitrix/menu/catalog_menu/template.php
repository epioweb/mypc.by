<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if(is_array($arResult) && count($arResult) > 0)
{
	?>
			<!-- Навигация -->
            <div id="nav-bg">
                <ul id="nav">
                <?
                $i = 0;
                foreach($arResult as $m)
                {
                	if($i > 0)
                	{
                		?><li class="divider"></li><?
                	}
                	?>
                	<li>
	                    <div class="nav-item">
	                        <div class="nav-title-wrap"><a class="nav-title" href="<?=$m["LINK"]?>" ><?=$m["TEXT"]?></a></div>
	                        <?
	                        $dropdownClass = "";
	                        if($i > 2) $dropdownClass = "left-x1";
	                        if($i >= 4) $dropdownClass = "right";
	                        if(is_array($m["ITEMS"]) && count($m["ITEMS"]) > 0)
	                        {
	                        	?>
	                        	<div class="dropdown <?=$dropdownClass?>">
		                            <div class="subnav">
		                            	<ul class="x1">
		                            		<?
		                            		$ii = 0;
		                            		foreach($m["ITEMS"] as $mm)
		                            		{
		                            			if($ii > 0 && $ii%6 == 0)
		                            			{
		                            				?>
		                            				</ul>
		                            				<ul class="x1">
		                            				<?
		                            			}
		                            			?>
		                            			<li><a href="<?=$mm["LINK"]?>"><?=$mm["TEXT"]?></a></li>
		                            			<?
		                            			$ii++;
		                            		}
		                            		?>
		                                </ul>
		                            </div>
		                        </div>
	                        	<?
	                        }
	                        ?>
	                    </div>
	                </li>
                	<?
                	$i++;
                }
                ?>
            </ul>
            </div>
<?
}
?>