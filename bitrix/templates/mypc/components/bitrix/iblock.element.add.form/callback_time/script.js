$(function(){
	$("#callback-form").live("submit",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var form = $(this);
		//form.closest("div").find(".ajax-loading-img").show();
		var formData = form.serialize();
		form.replaceWith("<p>Подождите...</p>");
		$.post("/ajax.php?action=callback",formData,function(data){
			$(".b-callback-wr").html(data);
			$('input[type="checkbox"], select').styler({
				browseText: 'Выбрать файл',
				singleSelectzIndex: '909'
			});
		});
	});
	
	$("#callback-btn").click(function(){
		$("#callback-window .field.product-title").hide();
		$("#callback-window .overlay-header").attr("style","");
		$("#callback-window .overlay-header span").text("ОБРАТНЫЙ ЗВОНОК");
	});
	
});