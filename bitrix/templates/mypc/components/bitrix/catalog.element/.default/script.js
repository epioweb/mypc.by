$(function(){
	$(".detailPageProduct .buyBtnLink").live("click",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var linkBtn = $(this);
		var actionUrl = linkBtn.attr("href");
		linkBtn.find("span").addClass("loading-field");
		$.post(actionUrl,{"AJAX":"Y"},function(data){
			if(data.length > 0)
			{
				linkBtn.replaceWith(data);
				if(typeof(updateCartSmallBlock) == "function") updateCartSmallBlock();
			}
		});		
	});
	
	$(".detailPageProduct .compare-link-btn").live("click",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var linkBtn = $(this);
		var actionUrl = linkBtn.attr("href");
		linkBtn.html("<img src='/bitrix/templates/zed/images/loader_rounded.gif'/>");
		$.post(actionUrl,{"AJAX":"Y"},function(data){
			linkBtn.replaceWith(data);
		});
		
	});
	
	$(".detailPageProduct .product-call-order").live("click",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var product = $(this).attr("data-product");
		var inpProd = $("#callback-product");
		inpProd.val(product);
		$("#callback-product-title").html(product);
		$("#callback-window .overlay-header").css({"padding-bottom":0});
		$("#callback-window .overlay-header span").text("ЗАКАЗ ПО ТЕЛЕФОНУ");
		
		inpProd.closest("div.field").show();
	});
	
});











jQuery(function($) {
    // Notice Window
    if ($("#notice-window").length) {
        $("#notice-window").overlay({
            mask: {
                color: '#000',
                loadSpeed: 500,
                opacity: 0.4,
            },
            top: "15%"
        });
        $(".notice-btn").on("click", function(e){
            e.preventDefault();
            $("#notice-window").overlay().load();
        });
    }

});

function setEqualHeight(columns)
{   var tallestcolumn = 0;
    columns.each(function()
    {   currentHeight = $(this).height();
        if(currentHeight > tallestcolumn)
        { tallestcolumn  = currentHeight; }});
    columns.height(tallestcolumn);
}






