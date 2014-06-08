/**
 * Created by neeke on 14-5-23.
 */
var project_domain_board = (function () {

    function overview() {

    }


    function init() {
        $(".ajax-get").find("a").click(function () {
            var data_js = $(this).attr('data-js');
            var htmlResult = '';

            switch (data_js) {
                case 'overview':

            }


            $("#" + data_js).html(htmlResult);
        });
    }

    return {
        init: init
    }
})();
