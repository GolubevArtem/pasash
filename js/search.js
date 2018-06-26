$(function() {

    //Живой поиск
    $('.who').bind("change keyup input click", function () {
        if (this.value.length >= 2) {
            $.ajax({
                type: 'post',
                url: "search.php", //Путь к обработчику
                data: {'referal': this.value},
                response: 'text',
                success: function (data) {
                    $(".search_result").html(data).fadeIn(); //Выводим полученые данные в списке
                }
            })
        }
    })

    $(".search_result").hover(function () {
        $(".who").blur(); //Убираем фокус с input
    })



    //При выборе результата поиска
    $(".search_result").on("click", "tr", function () {
        s_user = $(this).text();
        $.cookie('s', s_user);
        s_param_id = $(this).next('.hid').find('.id').text();
        s_param_parent = $(this).next('.hid').find('.parent').text();
        var pathname = window.location.pathname;
        var url = pathname + '?id_tree=' + s_param_parent + '#' + s_param_id;



        $(location).attr('href', url);

        var s = window.location.search;
        var x = '?id_tree=' + s_param_parent;
        if (s == x){
            window.location.reload(true);
        }


        })



    // подсветка поиска
    $(document).ready( function() {
        var path = window.location.href;
        var url_arr = path.split('#');
        if ((url_arr[1]) !== 0 && url_arr[1] !== undefined) {
            $('html, body').animate({scrollTop: $("." + url_arr[1] + "").offset().top}, 300); // анимируем скроолинг к элементу
            $("." + url_arr[1] + "").css("background", "#f0f395");

            var newURL = (function () {
                var Hash = window.location.hash;
                var URLBase_and_QS = window.location.href.split('#')[0];
                var newParams = (URLBase_and_QS.indexOf('?') == -1) ? '?' : '&';
                //newParams += "[QueryParameterGoesHere]=[QueryParamValue]";
                return URLBase_and_QS; //   + newParams + Hash
            })();
            window.history.pushState(null, null, newURL);

            $(".search_result").fadeOut();

        }
    });



    jQuery(function ($) {
        $(document).mouseup(function (e) { // событие клика по веб-документу
            var div = $(".search_result"); // тут указываем ID элемента
            if (!div.is(e.target) // если клик был не по нашему блоку
                && div.has(e.target).length === 0) { // и не по его дочерним элементам
                div.fadeOut(); // скрываем его
            }
        });
    });

    $(document).ready(function () {
        var div = $(".search_result");
        $(this).keydown(function (eventObject) {
            if (eventObject.keyCode == 27)
                div.fadeOut();
        });
    })

})


// TO DO по ентер открывать первый результат поиска
