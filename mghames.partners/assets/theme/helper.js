"use strict";

const currency_settings=JSON.parse($('#currency_settings').val());
var base_url = $('#base_url').val();
var defaut_img=base_url + '/uploads/default.png';;

/*-------------------------
        runpreloader
    --------------------------*/
function runpreloader() {
	$('.content-placeholder').each(function() {

		var height=$(this).data('height');
		var width=$(this).data('width');

		$(this).css({"height":height, "width":width});


	});
}

/*-------------------------
        amount_format
    --------------------------*/
function amount_format(amount,type='name') {

	var format= type == 'name' ?  ' '+currency_settings.currency_name+' ' : currency_settings.currency_icon;
 
    
    if (currency_settings.currency_position == 'left') {
        var price=format+amount;
       
    }
    else{
        var price=amount+' '+format;
    }

   
    
    return price;
    
   
}

/*-------------------------
        str_limit
    --------------------------*/
function str_limit(text,limit=16) {
	if (text.length > limit) {
		return  (text.slice(0,limit))+'...';
	}
	return text;
	
}

/*-------------------------
        audio Sound
    --------------------------*/
function audio(sound_link=clickaudio) {
	var audio = document.createElement("AUDIO")
	audio.setAttribute('allow', 'autoplay')
	audio.setAttribute('autoplay', 'autoplay')
	document.body.appendChild(audio);
	audio.src = sound_link;
	audio.currentTime = 0;
	return audio;
}

/*-------------------------
        run_lazy
    --------------------------*/
function run_lazy() {
    $(".lazy").unveil(100, function() {
      $(this).on('load',function(){
         this.style.opacity = 1;
      });
    }); 
}

var entityMap = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#39;',
      '/': '&#x2F;',
      '`': '&#x60;',
      '=': '&#x3D;'
};

/*-------------------------
        escapeHtml
    --------------------------*/
function escapeHtml(string) {
      return String(string).replace(/[&<>"'`=\/]/g, function (s) {
        return entityMap[s];
    });
 }

 /*-------------------------
        render_pagination
    --------------------------*/
 function render_pagination(target,data,left_icon="fas fa-angle-left",right_icon="fas fa-angle-right"){
        $('.page-item').remove();
       $.each(data, function(key,value){
            if(value.label === '&laquo; Previous'){
                if(value.url === null){
                    var is_disabled="disabled"; 
                    var is_active=null;
                }
                else{
                    var is_active='page-link-no'+key;
                    var is_disabled='';
                }
                var html='<li  class="page-item"><a '+is_disabled+' class="page-link '+is_active+'" href="javascript:void(0)" data-url="'+value.url+'"><i class="'+left_icon+'"></i></a></li>';
            }
            else if(value.label === 'Next &raquo;'){
                if(value.url === null){
                    var is_disabled="disabled"; 
                    var is_active=null;
                }
                else{
                    var is_active='page-link-no'+key;
                   var is_disabled='';
                }
                var html='<li class="page-item"><a '+is_disabled+'  class=" page-link '+is_active+'" href="javascript:void(0)" data-url="'+value.url+'"><i class="'+right_icon+'"></i></a></li>';
            }
            else{
                if(value.active==true){
                    var is_active="active";
                    var is_disabled="disabled";
                    var url=null;

                }
                else{
                    var is_active='page-link-no'+key;
                    var is_disabled='';
                    var url=value.url;
                }
                var html='<li class="page-item '+is_active+'"><a class="page-link '+is_active+'" '+is_disabled+' href="javascript:void(0)" data-url="'+url+'">'+value.label+'</a></li>';
            }
            if(value.url !== null){
              $(target).append(html);
            }
            
       });
    }

$('.render_currency').each(function() {
    $(this).text(amount_format($(this).text()));
}); 

  $('.make_review').on('click',function(){
    var star=$(this).data('star');
    var comment=$(this).data('comment');
    var action=$(this).data('action');

    $('.review_form').attr('action',action);
    $('.feedback').val(comment);

  });
