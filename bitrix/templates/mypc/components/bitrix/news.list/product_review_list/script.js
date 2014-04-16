$(function(){
	$(".reviewBtn").live("click",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var action = $(this).prop("href");
		var wr = $(this).closest(".review-rating");
		$.post(action,{"AJAX":"Y"},function(data){
			if(typeof(data) == "object")
			{
				wr.find(".usefull-yes").text(data.Y);
				wr.find(".usefull-no").text(data.N);
			}
		},"json");//
		
	});
});