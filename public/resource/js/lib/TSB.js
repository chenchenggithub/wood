/**
 * Created by neeke on 14-5-15.
 *
 * 前端组件库
 */
var T;
T = (function ($, window, document, undefined) {

    var alert = function (msg, type) {
        window.alert(msg);
    };

    var restGet = function (url, data, success, error, type) {
        var der = $.Deferred();
        $.ajax({
            url: url,
            type: type || "get",
            data: data,
            dataType: "json"
        }).done(function (data) {
                if (data && data.code === 1000) {
                    if (typeof success === "function") {
                        success.call(this, data);
                    }
                    der.resolve();
                }
                else {
                    if(typeof error === 'function'){
                        error.call(this,data);
                    }
                    der.reject(data);
                }
            }).fail(function () {

                der.reject();
            });
        return der.promise();
    };

    var restPost = function (url, data, success, error) {
        return T.restGet(url, data, success, error, "post");
    };

    var ajaxLoad = function(url,domId,data,callback){
        data = (typeof data !='undefined') ? data : {};

        $("#"+domId).load(url,data,function(response,status,xhr){
            status = status.toLowerCase();
            if(status == 'success'){
                if(typeof callback != 'undefined') callback();
            }
            if(status == 'error'){

            }
        });
    }


    return {
        restGet: restGet,
        restPost: restPost,
        alert: alert,
        ajaxLoad: ajaxLoad
    };
})(jQuery, window, document, undefined);