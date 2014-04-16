$(function(){
	
	$(".switcher-wrap>h2").click(function(e){
		e.preventDefault ? e.preventDefault() : e.returnValue = false;
		var swObj = $(this).closest(".switcher-wrap");
		var frameObj = swObj.find(".ordering-wrap").eq(0);
		frameObj.slideToggle(200,function(){
			if(frameObj.is(":visible")) swObj.addClass("opened");
			else swObj.removeClass("opened");
			
			var opened = [];
			$(".switcher-wrap.opened").each(function(){
				opened.push($(this).attr("id"));
			});
			document.cookie = cookie_prefix + "_user_profile_open=" + opened.join(",") + "; expires=Thu, 31 Dec 2100 23:59:59 GMT; path=/;";
		});
	});
	
});