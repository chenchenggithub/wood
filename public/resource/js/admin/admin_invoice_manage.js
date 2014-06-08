var admin_invoice_manage = (function () {
    //加载等待发票审核列表
    var load_invoice_list = function () {
        var status = $("#invoice_status_id").val();
        T.ajaxLoad('/invoice_manage/ajax/load_invoice_list', 'placeholder', {status:status}, function () {
        });
    }

   var page_func = function(page){
       var status = $("#invoice_status_id").val();
       T.ajaxLoad('/invoice_manage/ajax/load_invoice_list?page='+page, 'placeholder', {status:status}, function () {
       });
   }
    //加载页面审核页面
    var load_invoice_audit = function(invoice_apply_id){
        T.ajaxLoad('/invoice_manage/ajax/invoice_audit', 'placeholder', {invoice_apply_id:invoice_apply_id}, function () {
        });
    }
    //加载开发票页面
    var load_invoice_invoicing = function(invoice_apply_id){
        T.ajaxLoad('/invoice_manage/ajax/invoice_invoicing', 'placeholder', {invoice_apply_id:invoice_apply_id}, function () {
        });
    }
    //加载发票邮寄页面
    var load_invoice_mail = function(invoice_apply_id){
        T.ajaxLoad('/invoice_manage/ajax/invoice_mail', 'placeholder', {invoice_apply_id:invoice_apply_id}, function () {
        });
    }

    //发票审核处理接口
    var dispose_invoice_audit = function(sign){
        var invoice_amount = $('#invoice_amount_id').val();
        var audit_remark = $('#audit_remark_id').val();
        var invoice_apply_id = $('#invoice_apply_id').val();
        T.restPost('/invoice_manage/ajax/dispose_invoice_audit', {sign:sign,invoice_apply_id:invoice_apply_id,invoice_amount:invoice_amount,audit_remark:audit_remark},invoiceAuditSuccess, invoiceAuditError)
    }
    var invoiceAuditSuccess = function (data) {
        window.location.href = '/invoice_manage';
    }
    var invoiceAuditError = function (data) {
        alert(data.msg);
    }

    //开发票处理接口
    var dispose_invoice_invoicing = function(sign){
        var invoice_code = $('#invoice_code_id').val();
        var invoice_apply_id = $('#invoice_apply_id').val();
        T.restPost('/invoice_manage/ajax/dispose_invoice_invoicing', {invoice_apply_id:invoice_apply_id,invoice_code:invoice_code},invoiceInvoicingSuccess,invoiceInvoicingError)
    }
    var invoiceInvoicingSuccess = function (data) {
        var status = data.data.status;
        $("#invoice_status_id").val(status);
        load_invoice_list();
    }
    var invoiceInvoicingError = function (data) {
        alert(data.msg);
    }

    //开发票处理接口
    var dispose_invoice_mail = function(sign){
        var invoice_code = $('#invoice_code_id').val();
        var invoice_apply_id = $('#invoice_apply_id').val();
        var express_company = $('#express_company_id').val();
        var express_code = $('#express_code_id').val();
        var mail_remark = $('#mail_remark_id').val();
        T.restPost('/invoice_manage/ajax/dispose_invoice_mail', {invoice_apply_id:invoice_apply_id,express_company:express_company,express_code:express_code,mail_remark:mail_remark},invoiceMailSuccess,invoiceMailError)
    }
    var invoiceMailSuccess = function (data) {
        var status = data.data.status;
        $("#invoice_status_id").val(status);
        load_invoice_list();
    }
    var invoiceMailError = function (data) {
        alert(data.msg);
    }

    return {
        'load_invoice_list': load_invoice_list,
        'page_func':page_func,
        'load_invoice_audit':load_invoice_audit,
        'load_invoice_invoicing':load_invoice_invoicing,
        'load_invoice_mail':load_invoice_mail,
        'dispose_invoice_audit':dispose_invoice_audit,
        'dispose_invoice_invoicing':dispose_invoice_invoicing,
        'dispose_invoice_mail':dispose_invoice_mail
    };
})()