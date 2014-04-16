$(function(){
	$("#section-product-list .buyBtnSection").live("click",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var linkBtn = $(this);
		var actionUrl = linkBtn.attr("href");
		linkBtn.find("span").addClass("loading-field");
		
		var showMode = $(this).attr("data-mode"); 
		
		$.post(actionUrl,{"AJAX":"Y","showMode":showMode},function(data){
			linkBtn.replaceWith(data);
			if(typeof(updateCartSmallBlock) == "function") updateCartSmallBlock(true);
		});
		
	});
	
	$("#section-product-list .compare-link-btn").live("click",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var linkBtn = $(this);
		var actionUrl = linkBtn.attr("href");
		var ib = linkBtn.attr("data-ib");
		var mib = linkBtn.attr("data-mib");
		linkBtn.html("<img src='/bitrix/templates/mypc/images/loader_rounded.gif'/>");
		$.post(actionUrl,{"AJAX":"Y"},function(data){
			linkBtn.replaceWith(data);
			$(".b-compare-list-wr").load("/ajax.php?action=updateCompareBlock&iblock_id="+ib+"&mib="+mib);
		});
		
	});
});