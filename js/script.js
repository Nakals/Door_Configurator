$('document').ready(function(){
    $('.options_btn').on("click", function(){
        if(($(this).next().hasClass('options_list') && !$(this).next().hasClass('open')) || (!$(this).next().hasClass('options_list')))
            $('.options_list').removeClass('open');
        $('list').scrollTop(0);
        $(this).next().toggleClass('open');
        $('.send_info').css('display', 'none');
    });
    $('.cross_popup').on("click", function(){
        $(this).closest(".options_popup").removeClass('open');
    });
    $('.options_popup_wrapper:not(.options_popup_accessories) label').on("click", function(){
        let value = $(this).children('span').text();
        $(this).closest('.options_popup').prev().text(value);
        let id = $(this).children('input').attr('attr_id');
        let color = $(this).children('input').attr('attr_color');
        let name = $(this).children('input').attr('name');
        let price = $(this).children('input').attr('attr_price');
        $('.door_wrapper .' + name).css("background",color);
        $('.sendForm input[name=form_'+name+']').val(id);
        $('.sendForm input[name=form_'+name+']').attr('attr_price',price);
        formValid();
        $(this).closest('.options_popup').removeClass('open');
    });
    $('.options_popup_wrapper.options_popup_accessories label').on("click", function(){
        let value = "";
        let id = "";
        let i = 0;
        let price = 0;
        $(".options_popup_accessories input[type=checkbox]").each(function( index ) {
            if($(this).is(":checked")){
                if(i>0) {value += ', '; id += ', ';}
                price += Number($(this).attr("attr_price"));
                i++
                value += $(this).next().text();
                id += $(this).attr("attr_id");
            }
          });
        let name = $(".options_popup_accessories input[type=checkbox]").attr("name");
        $(this).closest('.options_popup').prev().text(value);
        $('.sendForm input[name=form_'+name+']').val(id);
        $('.sendForm input[name=form_'+name+']').attr('attr_price',price);
        formValid();    
    });
    $('.options_select li').on("click", function(){
        let type = $(this).children('span').text();
        console.log('click');
        if($(this).closest('.options_select').hasClass('options_type')){
            if(type.indexOf('Правое')){
                $(".door_skin").css("justify-content","left");
                $(".door_skin.inside").css("justify-content","right");
            }
            else if(type.indexOf('Левое')){
                $(".door_skin").css("justify-content","right");
                $(".door_skin.inside").css("justify-content","left");
            }
        }
        let name = $(this).closest('.options_select').attr('attr_name');
        let id = $(this).children('span').attr('attr_id');
        let price = $(this).children('span').attr('attr_price');
        console.log(name);
        $(this).closest('.options_select').children('.options_btn').text(type);
        $('.sendForm input[name=form_'+name+']').val(id);
        $('.sendForm input[name=form_'+name+']').attr('attr_price',price);
        formValid();
        $(this).closest('.options_list').removeClass('open');
    });
    $(document).mouseup( function(e){
		var div = $( ".options_popup.open .options_popup_wrapper" );
		if ( !div.is(e.target)
		    && div.has(e.target).length === 0 ) {
			div.parent().removeClass('open');
		}
	});
});

function formValid(){
    let valid = true;
    let total_price = 0;
    $(".sendForm input[type=text]").each(function(e){
        if($(this).val() == ''){
            valid = false;
        }
        total_price += Number($(this).attr('attr_price'));
    });
    if(valid){
        $('.total_price_value').text(total_price);
        $(".total_price, .sendForm").css('display', 'flex');
    }
}