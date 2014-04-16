
jQuery(function($) {

    // Стилизация элементов форм ----------------------------
    $('.formstyler').styler({
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


    // Ценовой слайдер
    $("#price-range").slider({
        range: true,
        min: 9,
        max: 45,
        values: [ 9, 45 ],
        slide: function( event, ui ) {
            $( "#left-slider-value" ).val( ui.values[0] );
            $( "#right-slider-value" ).val( ui.values[1] );
        }
    });
    $( "#left-slider-value" ).val( $( "#price-range" ).slider( "values", 0 ) );
    $( "#right-slider-value" ).val( $( "#price-range" ).slider( "values", 1 ) );

    // Показать / Скрыть панель параметров
    $(".parameters h2").click(function() {
        var $link = $(this);
        $link.toggleClass('active').next('.panel').slideToggle();
        return false;
    });

    // Стилизация элементов форм
    $('.formstyler, input[type=checkbox], input[type=radio]').styler({
        singleSelectzIndex: '9999'
    });
    $('.spinner').spinner({
        min: 0,
        change: function(event, ui) {
        },
        spin: function(event, ui) {
        },
    });

    // Переключатель Список / Сетка
    if ($(".display-type").length) {
        var $display_type = $('.display-type');
        $(".display-type .list-type").on("click", function() {
            var $list_type = $(this);
            if (!$list_type.hasClass('active')) {
                $display_type.find('a').removeClass('active');
                $list_type.addClass('active');
                $display_type.parent().parent().find('.products-grid').attr('class', 'products-list')
                    .find('.add-to-cart').addClass('yellow-btn');
                $('.products-list .action-links').each(function(index, element) {
                    var $dest = $(element).parent().parent().find('.left-column');
                    $(element).appendTo($dest);
                });
            }
            return false;
        });
        $(".display-type .grid-type").on("click", function() {
            var $grid_type = $(this);
            if (!$grid_type.hasClass('active')) {
                $display_type.find('a').removeClass('active');
                $grid_type.addClass('active');
                $display_type.parent().parent().find('.products-list').attr('class', 'products-grid')
                    .find('.add-to-cart').removeClass('yellow-btn');
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
    $("a[rel^='prettyPhoto[ajax]']").prettyPhoto({ theme: 'facebook', social_tools: '', gallery_markup: '', deeplinking: false });

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

    // Login Window
    if ($(".overlay").length)
        $("#callback-btn").overlay({
            mask: {
                color: '#000',
                loadSpeed: 500,
                opacity: 0.4
            },
            top: "15%"
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

    /* */
    $(".cabinet-tab-headers").tabs(".cabinet-tab-panes > div", { tabs: 'li', effect: 'fade' });

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


    setEqualHeight($(".checkout-auth-cols > ul .in"));


    // Notice Window
    if ($("#notice-window").length) {
        $("#notice-window").overlay({
            mask: {
                color: '#000',
                loadSpeed: 500,
                opacity: 0.4
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
