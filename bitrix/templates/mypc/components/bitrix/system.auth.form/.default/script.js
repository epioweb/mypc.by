$(function(){
	$("#login-btn").live("click",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var form = $(this).closest("form");
		//form.closest("div").find(".ajax-loading-img").show();
		$(".b-login-form-wr").html("<p>Подождите...</p>");
		form.remove();
		$.post("/ajax.php?action=login",form.serialize(),function(data){
			$(".b-login-form-wr").html(data);
			$('input[type="checkbox"], select').styler({
				browseText: 'Выбрать файл',
				singleSelectzIndex: '909'
			});
		});
	});
});