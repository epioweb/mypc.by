$(function(){
	$(".buy-btn-link").live("click",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var linkBtn = $(this);
		var actionUrl = linkBtn.attr("href");
		linkBtn.addClass("loading-field");
		$.post(actionUrl,{"AJAX":"Y"},function(data){
			linkBtn.replaceWith(data);
			if(typeof(updateCartSmallBlock) == "function") updateCartSmallBlock();
		});
		
	});
});