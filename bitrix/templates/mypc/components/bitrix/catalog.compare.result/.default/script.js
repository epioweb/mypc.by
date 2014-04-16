$(function(){
	$(".buyBtnLink").live("click",function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var linkBtn = $(this);
		var actionUrl = linkBtn.attr("href");
		linkBtn.find("span").addClass("loading-field");
		$.post(actionUrl,{"AJAX":"Y"},function(data){
			linkBtn.replaceWith(data);
			if(typeof(updateCartSmallBlock) == "function") updateCartSmallBlock(true);
		});		
	});	
	
	/* Страница сравнения */
    var compare_header = $(".compare-header-wrap");
    var compare_body = $(".compare-wrap");
    compare_header.scroll(function() {
        compare_body.scrollLeft($(this).scrollLeft());
    });
    compare_body.scroll(function() {
        compare_header.scrollLeft($(this).scrollLeft());
    });
    compare_body.find("tr").not(":first").find("td")
        .hover(function() {
            $(this).parent().find("td").addClass("active");
        }, function(){
            $(this).parent().find("td").removeClass("active");
        });

    /* Скролинг, кнопка наверх */
    $('#top-link').click(function(e) {
        $("body,html").animate({ scrollTop: 0 }, 800);
        return false;
    });
	
	
});