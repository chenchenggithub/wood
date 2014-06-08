function dispose_package(type,dispose_type){
	switch(type){
		case 'host':
			var add_host_count = parseInt($("#add_host_count").val());
			var frequency = $("#add_host_frequency").val();
			if(dispose_type == 'add'){
				add_host_count += default_add_host_count;
			}
			if(dispose_type == 'reduce'){
				if(add_host_count > 0) add_host_count -= default_add_host_count;
			}
			$("#add_host_count").val(add_host_count);
			change_package_count('host',add_host_count,frequency);
			break;
		case 'website':
			var add_website_count = parseInt($("#add_website_count").val());
			var frequency = parseInt($("#add_website_frequency").val());
			if(dispose_type == 'add'){
				add_website_count += default_add_website_count;
			}
			if(dispose_type == 'reduce'){
				if(add_website_count > 0) add_website_count -= default_add_website_count;
			}
			$("#add_website_count").val(add_website_count);
			change_package_count('website',add_website_count,frequency)
			break;
		case 'mobileapp':
			var add_mobileapp_count = parseInt($("#add_mobileapp_count").val());
			var frequency = parseInt($("#add_mobileapp_frequency").val());
			if(dispose_type == 'add'){
				add_mobileapp_count += default_add_mobileapp_count;
			}
			if(dispose_type == 'reduce'){
				if(add_mobileapp_count > 0) add_mobileapp_count -= default_add_mobileapp_count;
			}
			$("#add_mobileapp_count").val(add_mobileapp_count);
			change_package_count('mobileapp',add_mobileapp_count,frequency)
			break;
		case 'monitor':
			var data = calculate_add_monitor();
			$("#add_monitor_count").html(data.monitor_count);
			$("#add_yundou_count").html(data.yundou_count);
			$("#buyAddPurchaseFormId").find("input[name='add_monitor']").val(data.add_monitor);
			change_package_count('monitor','','',data.monitor_count,data.yundou_count);
			break;
	}
	//计算套餐单价
	calculate_package();
}

//购买时限改变触发套餐计算
$("#purchase_time").change(function(){
	calculate_package();
});
//购买优惠码改变触发套餐计算
$("#promo_code").blur(function(){
    calculate_package();
});
//续费时限改变触发计算
$("#renewals_time").change(function(){
	calculate_renewals();
});
//续费优惠码改变触发计算
$("#renewals_promo").blur(function(){
    calculate_renewals();
});

//计算续费单价
function calculate_renewals(){
	var submit_data = {};
	submit_data.renewals_time = parseInt($("#renewals_time").val());
	submit_data.promo_code = $.trim($("#renewals_promo").val());
	var renewals_time = submit_data.renewals_time;
	$.ajax({
		'type':'post',
		'url':'/buy/get_renewals_price',
		'cache':false,
		'data':submit_data,
		'dataType':'json',
		'success':function(data,textStatus){
			var returnData = data.data;
			if(data.code == 1000){
				$("#renewals_unit_price").html('￥'+returnData.renewals_unit_price);
				$("#renewals_total_price").html('￥'+returnData.renewals_unit_price+' * '+renewals_time+' = '+returnData.total_price);
				$("#real_renewals_total_price").html('￥'+returnData.real_total_price);
                console.log(returnData.status_code);
                if(returnData.status_code == 1511){//没有使用优惠码
                    $("#renewals_promo_explanation").html('');
                    $("#renewals_actual_expression").html('');
                }else{
                    if(returnData.status_code == 1505){//符合条件的优惠码
                        var promo_expression = '';
                        var buy_actual_expression = '';
                        if(returnData.promo_strategy == 'discount') {
                            promo_expression = '说明：总价'+(returnData.promo_value*10)+'折优惠';
                            buy_actual_expression = '￥'+returnData.total_price+' * '+returnData.promo_value+' = ';
                        }
                        if(returnData.promo_strategy == 'promo_amount') {
                            promo_expression = '说明：总价优惠'+returnData.promo_value;
                            buy_actual_expression = '￥'+returnData.total_price+' - '+returnData.promo_value+' = ';
                        }
                        $("#renewals_promo_explanation").html(promo_expression);
                        $("#renewals_actual_expression").html(buy_actual_expression);
                    }else{//不符合条件的优惠码
                        $("#renewals_promo_explanation").html(returnData.promo_error_msg);
                        $("#renewals_actual_expression").html('');
                    }
                }

			}
		},
		'error':function (XMLHttpRequest, textStatus, errorThrown) {
			  // 通常情况下textStatus和errorThown只有其中一个有值 
		},
		'complete':function(XMLHttpRequest, textStatus){
		
		}
	});
}


//计算增购套餐单价
function calculate_package(){
	var submit_data = {};
	submit_data.add_host_count = parseInt($("#add_host_count").val());
	submit_data.add_website_count = parseInt($("#add_website_count").val());
	submit_data.add_mobileapp_count = parseInt($("#add_mobileapp_count").val());
	submit_data.add_yundou_count = parseInt($("#add_yundou_count").html());
	submit_data.add_host_frequency = parseInt($("#add_host_frequency").val());
	submit_data.add_website_frequency = parseInt($("#add_website_frequency").val());
	submit_data.add_mobileapp_frequency = parseInt($("#add_mobileapp_frequency").val());
	submit_data.add_monitor = $("#buyAddPurchaseFormId").find("input[name='add_monitor']").val();
	submit_data.purchase_time = parseInt($("#purchase_time").val());
	submit_data.promo_code = $("#promo_code").val();
	
	$.ajax({
		'type':'post',
		'url':'/buy/get_package_price',
		'cache':false,
		'data':submit_data,
		'dataType':'json',
		'success':function(data,textStatus){
			if(data.code == 1000){
				var returnData = data.data;
				var purchase_time = $("#purchase_time").val();
				$("#add_total_price").html('￥'+returnData.add_total_price+'/月');
				$("#unit_price").html('￥'+returnData.basic_package_price+' + ￥'+returnData.add_total_price+' = ￥'+returnData.unit_price);
				$("#total_price").html('￥'+returnData.unit_price+' * '+purchase_time+' = '+returnData.total_price);
                $("#actual_total_price").html('￥'+returnData.real_total_price);

                if(returnData.status_code == 1511){//没有使用优惠码
                    $("#buy_promo_explanation").html('');
                    $("#buy_actual_expression").html('');
                }else{
                    if(returnData.status_code == 1505){//符合条件的优惠码
                        var promo_expression = '';
                        var buy_actual_expression = '';
                        if(returnData.promo_strategy == 'discount') {
                            promo_expression = '说明：总价'+(returnData.promo_value*10)+'折优惠';
                            buy_actual_expression = '￥'+returnData.total_price+' * '+returnData.promo_value+' = ';
                        }
                        if(returnData.promo_strategy == 'promo_amount') {
                            promo_expression = '说明：总价优惠'+returnData.promo_value;
                            buy_actual_expression = '￥'+returnData.total_price+' - '+returnData.promo_value+' = ';
                        }
                        $("#buy_promo_explanation").html(promo_expression);
                        $("#buy_actual_expression").html(buy_actual_expression);
                    }else{//不符合条件的优惠码
                        $("#buy_promo_explanation").html(returnData.promo_error_msg);
                        $("#buy_actual_expression").html('');
                    }
                }
			}
		},
		'error':function (XMLHttpRequest, textStatus, errorThrown) {
			  // 通常情况下textStatus和errorThown只有其中一个有值 
		},
		'complete':function(XMLHttpRequest, textStatus){
		
		}
	});
	
}

//改写总的套餐数量
function change_package_count(type,add_count,frequency,add_monitor_count,add_yundou_count){
	switch(type){
		case 'host':
			var all_host_count = basic_host_count + add_count;
			$("#all_host_count").html(all_host_count);
			$("#all_host_frequency").html(frequency+'min');
			break;
		case 'website':
			var all_website_count = basic_website_count + add_count;
			$("#all_website_count").html(all_website_count); 
			$("#all_website_frequency").html(frequency+'min');	
			break;
		case 'mobileapp':
			var all_mobileapp_count = basic_mobileapp_count + add_count;
			$("#all_mobileapp_count").html(all_mobileapp_count);
			$("#all_mobileapp_frequency").html(frequency+'min'); 
			break;
		case 'monitor':
			var all_monitor_count = basic_monitor_count + add_monitor_count;
			var all_yundou_count = parseInt($("#all_yundou_count").val()) + add_yundou_count;
			$("#all_monitor_count").html(all_monitor_count);
			$("#all_yundou_count").html(all_yundou_count);
			break;
	}
}

var temp_quota_count = 0;
//主机增加数量
$("#add_host_count").focus(function(){
	temp_quota_count = parseInt($(this).val());
}).blur(function(){
	var add_count = parseInt($(this).val());
	var frequency = $("#add_host_frequency").val();
	if(add_count < 0) {$(this).val(temp_quota_count);alert('数量不能为零!');return false;}
	change_package_count('host',add_count,frequency)
});

//网站增加数量
$("#add_website_count").focus(function(){
	temp_quota_count = parseInt($(this).val());
}).blur(function(){
	var add_count = parseInt($(this).val());
	var frequency = $("#add_website_frequency").val();
	if(add_count < 0) {$(this).val(temp_quota_count);alert('数量不能为零!');return false;}
	change_package_count('website',add_count,frequency)
});

//移动应用增加数量
$("#add_mobileapp_count").focus(function(){
	temp_quota_count = parseInt($(this).val());
}).blur(function(){
	var add_count = parseInt($(this).val());
	var frequency = $("#add_mobileapp_frequency").val();
	if(add_count < 0) {$(this).val(temp_quota_count);alert('数量不能为零!');return false;}
	change_package_count('mobileapp',add_count,frequency)
});

//展示增购监测点的数量
$(".add_monitor_class").click(function(){
	var monitor_count = 0,
		yundou_count = 0;
	$("#add_monitor_fieldset").children().each(function(){
		if($(this).is(':checked')){
			monitor_count += 1;
			yundou_count += parseInt($(this).attr('yundou'));
		}
	});
	$("#temp_add_monitor_count").html(monitor_count);
	$("#temp_add_yundou_count").html(yundou_count);
});

function calculate_add_monitor(){
	var data = {monitor_count:0,yundou_count:0,add_monitor:''};
	$("#add_monitor_fieldset").children().each(function(){
		if($(this).is(':checked')){
			data.monitor_count += 1;
			data.yundou_count += parseInt($(this).attr('yundou'));
			data.add_monitor += $(this).val()+','
		}
	});
	return data;
}

//获取对象的成员个数
function tsb_count(o){
    var t = typeof o;
    if(t == 'string'){
        return o.length;
    }else if(t == 'object'){
        var n = 0;
        for(var i in o){
            n++;
        }
        return n;
    }
    return false;
}

/*//查看监测点弹窗
	$( "#show_monitor" ).dialog({
		autoOpen: false,
		height: 300,
		width: 488,
		modal: true,
		buttons: {
			"确定": function() {
				$( this ).dialog( "close" );
			}
		},

	});
//设置监测点弹窗
	$( "#setting_monitor" ).dialog({
		autoOpen: false,
		height: 300,
		width: 488,
		modal: true,
		buttons: {
			"确定":function(){
				dispose_package('monitor');
				$( this ).dialog( "close" );

			},
			"取消": function() {
				$( this ).dialog( "close" );
			}
		},
	});

	$( "#show_monitor_button" ).click(function() {
		$( "#show_monitor" ).dialog( "open" );
	});

	$( "#setting_monitor_button" ).click(function() {
		$( "#setting_monitor" ).dialog( "open" );
	});*/
