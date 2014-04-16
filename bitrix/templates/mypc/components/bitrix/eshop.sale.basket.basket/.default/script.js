$(function(){
	$(".quantity-inp").change(function(){
		var q = $(this).val();
		var bid = $(this).attr("data-bid");
		var spinner = $(this);
		$.post("/ajax.php?action=basketRecalculate",{"bid":bid,"q":q},function(data){
			if(typeof(data) == "object")
			{
				if(data.action == "update")
				{
					spinner.closest(".item").find(".cart-item-total").html(data.price);
					spinner.val(data.quantity);
					$("#totalBasketSum strong").html(data.allSum);
				}
				
				if(typeof(updateCartSmallBlock) == "function") updateCartSmallBlock(false);
			}
		},"json");
	});
	
	$('.spinner').not('.ui-spinner-input').spinner({
		min: 0,
		stop: function(){
			$(this).change();
		}
	});
});