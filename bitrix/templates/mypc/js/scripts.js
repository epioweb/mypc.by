jQuery(function($) {

    // Стилизация элементов форм ----------------------------
    $('.formstyler, .select-wrap select').styler({
        singleSelectzIndex: '99'
    });

    /* Placeholder */
    if ($("input, textarea").length)
        $('input[placeholder], textarea[placeholder]').placeholder();

    // Главная навигация
    $("#nav > li").not(".divider").hover(function(){
        $(this).find('.nav-title-wrap').addClass("active");
        $('.dropdown',this).show();
    }, function(){
        $(this).find('.nav-title-wrap').removeClass("active");
        $('.dropdown',this).hide();
    });

    // Слайдер на главной
    if ($("#slider").length)
        $("#slider").carouFredSel({
            circular: true,
            infinite: false,
            responsive: false,
            width: 949,
            height: 315,
            auto: { play: true },
            prev: {  button: '#slider-prev'   },
            next: {  button: '#slider-next'  },
            items: { visible: 1, minimum: 1 },
            scroll: { items: 1, fx: "crossfade", easing: "swing", duration: 700, pauseOnHover: true }
        });
    
    // Показать / Скрыть панель параметров
    $(".parameters h2").live("click",function() {
        var $link = $(this);
        $link.toggleClass('active').next('.panel').slideToggle();
        return false;
    });

    // Стилизация элементов форм
    $('.formstyler, input[type=checkbox], input[type=radio]').styler({
        singleSelectzIndex: '9999'
    });
    
    // Переключатель Список / Сетка
    if ($(".display-type").length) {
        var $display_type = $('.display-type');
        $(".display-type .list-type").on("click", function() {
        	
        	var date = new Date( new Date().getTime() + 30*86400*1000);
			document.cookie="BITRIX_SM_CATALOG_SHOW_MODE=list; path=/; expires="+date.toUTCString();
        	
            var $list_type = $(this);
            if (!$list_type.hasClass('active')) {
                $display_type.find('a').removeClass('active');
                $list_type.addClass('active');
                $display_type.parent().parent().find('.products-grid').attr('class', 'products-list')
                    .find('.add-to-cart').addClass('yellow-btn');
                
                $(".products-list .add-to-cart").attr("data-mode","list");
                
                $('.products-list .action-links').each(function(index, element) {
                    var $dest = $(element).parent().parent().find('.left-column');
                    $(element).appendTo($dest);
                });
            }
            return false;
        });
        $(".display-type .grid-type").on("click", function() {
        	
        	var date = new Date( new Date().getTime() + 30*86400*1000);
			document.cookie="BITRIX_SM_CATALOG_SHOW_MODE=grid; path=/; expires="+date.toUTCString();
        	
            var $grid_type = $(this);
            if (!$grid_type.hasClass('active')) {
                $display_type.find('a').removeClass('active');
                $grid_type.addClass('active');
                $display_type.parent().parent().find('.products-list').attr('class', 'products-grid')
                    .find('.add-to-cart').removeClass('yellow-btn');
                
                $(".products-grid .add-to-cart").attr("data-mode","grid");
                
                $('.products-grid .action-links').each(function(index, element) {
                    var $dest = $(element).parent().parent().find('.right-column');
                    $(element).appendTo($dest);
                });
            }
            return false;
        });
    }

    // Лидеры продаж
    if ($("#best-sellers-container").length)
        $("#best-sellers-container").carouFredSel({
            circular: false,
            infinite: true,
            responsive: false,
            width: 714,
            height: 'variable',
            auto: { play: false },
            items: { visible: 3, minimum: 3 },
            prev: {  button: '#best-sellers-left'   },
            next: {  button: '#best-sellers-right'  },
            scroll: { items: 1, fx: "scroll", easing: "swing", duration: 700, pauseOnHover: true }
        });


    // Ограничение текста в блоках
    if ($(".dot-dot-dot").length)
        $(".dot-dot-dot").dotdotdot({ ellipsis	: ' ...' });

    // Показать скрытые элементы
    $(".show-others").click(function() {
        var $link = $(this);
        $link.find('span').toggleClass('hide');
        $link.parent().find('.checkbox-list .hide').fadeToggle().css('display','inline-block');
        return false;
    });

    // Переключение вкладок
    $(".tab-headers").tabs("div.tab-panes > div");
    $("#thumbs-container").tabs("#full-image > a", { tabs: 'div', effect: 'fade' });

    /* Картинки в полный размер, Галереи */
    $("a[rel^='prettyPhoto[gal1]']").prettyPhoto({ theme: 'facebook', social_tools: '', gallery_markup: '', deeplinking: false });
    $("a[rel^='prettyPhoto[gal2]']").prettyPhoto({ theme: 'facebook', social_tools: '', gallery_markup: '', deeplinking: false });

    // Карусель с миниатюрами
    if ($("#thumbs-container").length)
        $("#thumbs-container").carouFredSel({
            circular: false,
            infinite: true,
            responsive: false,
            width: 348,
            height: 81,
            auto: { play: false },
            items: { visible: 4, minimum: 4 },
            prev: {  button: '#thumbs-left'   },
            next: {  button: '#thumbs-right'  },
            scroll: { items: 1, fx: "scroll", easing: "swing", duration: 400, pauseOnHover: true }
        });

    // Рейтинг
    $('#big-stars').raty({
        starOff  : 'images/big-star-off.png',
        starOn   : 'images/big-star-on.png',
        width: 157
    });
    $('#small-stars').raty({
        starOff  : 'images/star-off.png',
        starOn   : 'images/star-on.png',
        width: 110
    });

    // Галерея
    $("a[rel^='gallery']").fancybox({
        'titlePosition' 	: 'over',
        'centerOnScroll'    : 'true',
        'padding'           : 2,
        'titleShow'	     	: true,
        'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
            return '<span id="fancybox-title-over">' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
        }
    });
    $(".ajax-modal").fancybox({
        'centerOnScroll'    : true,
        'padding'           : 30,
        'autoDimensions'    : false,
        'autoScale'         : true,
        'height'            : '90%',
        'width'             : '80%'
    });

    // Login Window
    if ($(".overlay").length && $(".popup-link").length)
    {
    	$(".popup-link").overlay({
            mask: {
                color: '#000',
                loadSpeed: 500,
                opacity: 0.4
            },
            top: "50%"
        });
    	





    	
    }
	
	$('.subcategories-list li.show-all-link a').on("click",function() {
		if($(this).attr('class')!='open'){
			$(this).parent().parent().find('._hide').show();
			$(this).addClass('open').text('Свернуть список »');
		}else{
			$(this).parent().parent().find('._hide').hide();
			$(this).removeClass('open').text('Раскрыть полный список »');
		}
		return false;
	});	
	
	$.datepicker.regional['ru'] = {
        closeText: 'Закрыть',
        prevText: '&#x3c;Пред',
        nextText: 'След&#x3e;',
        currentText: 'Сегодня',
        monthNames: ['Январь','Февраль','Март','Апрель','Май','Июнь',
            'Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
        monthNamesShort: ['Янв','Фев','Мар','Апр','Май','Июн',
            'Июл','Авг','Сен','Окт','Ноя','Дек'],
        dayNames: ['воскресенье','понедельник','вторник','среда','четверг','пятница','суббота'],
        dayNamesShort: ['вск','пнд','втр','срд','чтв','птн','сбт'],
        dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Нед',
        dateFormat: 'dd.mm.yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearRange: 'c-50:c+10',
        yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['ru']);

    /* Локализация календаря */
    $( "#date-from, #date-to" ).datepicker({
        showOn: "button",
        buttonText: "",
        buttonImageOnly: false
    });
});
