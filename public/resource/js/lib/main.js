$(function(){
	if($('input[name="switch-checkbox"]')[0]){
		$('input[name="switch-checkbox"]').bootstrapSwitch();
	}
	
	/*$(".main").mCustomScrollbar({
		theme:"dark",
		scrollInertia:100
	});*/
});

window.TSB = (function($, window, document, undefined){
	var tsb = {
		/*弹框提示信息*/
		modalAlert : function(options){
			var opt = $.extend({
				status:'success',
				msg:"Operation is successful !",
				speed:2000
			},options||{});
			if(opt.status == 'success'){
				var alertIcon = '<i class="fa fa-check-circle"></i>';
			}else{
				var alertIcon = '<i class="fa fa-times-circle"></i>';
			}
			var alertHtml = '<div class="modal-alert" style="display:none;"><div class="alert alert-'+opt.status+'">'+alertIcon+opt.msg+'</div></div>';
			$(alertHtml).appendTo($('body')).fadeIn().delay(opt.speed).fadeOut(function(){
				$(this).remove()
			});
		},
		/*jquery UI 滑块扩展*/
		slider : function(sel,opt){
			var $selectors = $(sel);
			return $.each($selectors,function(){
				var $target = $(this);
				opt.start = function(event,ui){
					if(typeof opt.startFun == 'function'){
						opt.startFun.call(this,event,ui);
					}
				};
				opt.slide = function(event,ui){
					if(typeof opt.slideFun == 'function'){
						opt.slideFun.call(this,event,ui);
					}
					if(opt.values != undefined){
						rangeWidget.call(this);
					}
				};
				opt.change = function(event,ui){
					if(typeof opt.changeFun == 'function'){
						opt.changeFun.call(this,event,ui);
					}
					if(opt.values != undefined){
						rangeWidget.call(this);
					}
				};
				opt.stop = function(event,ui){
					if(typeof opt.stopFun == 'function'){
						opt.stopFun.call(this,event,ui);
					}
				};
				
				$target.slider(opt);
				
				if(opt.values != undefined){
					var rangeWidget = function(){
						var widthPer = parseInt($target.find('.ui-slider-range')[0].style.width);
						var leftPer =  parseInt($target.find('.ui-slider-range')[0].style.left);
						if($target.find('.ui-widget-range-left')[0] == undefined){
							$('<div class="ui-widget-range-left" style="width:'+leftPer+'%;"></div>'+
							'<div class="ui-widget-range-right" style="width:'+(100-widthPer-leftPer)+'%;"></div>').appendTo($target);
						}else{
							$target.find('.ui-widget-range-left').css('width',leftPer+'%');
							$target.find('.ui-widget-range-right').css('width',(100-widthPer-leftPer)+'%');
						}
					};
					rangeWidget();
				}
			});
		}
		
	};
	return tsb;
}(jQuery, window, document, undefined));