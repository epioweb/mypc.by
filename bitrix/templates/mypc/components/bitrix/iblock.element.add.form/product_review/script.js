$(function(){
	$("#product-review-btn").live("click",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var productID = $("#input-product-id").val();
		var form = $(this).closest("form");
		$(".b-product-review-wr").addClass("loading-field");
		$.post("/ajax.php?action=productReview&ID="+productID,form.serialize(),function(data){
			$(".b-product-review-wr").removeClass("loading-field");
			$(".b-product-review-wr").html(data);
			$('select').styler({
				singleSelectzIndex: '909'
			});
		});
	});
});