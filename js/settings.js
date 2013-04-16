jQuery(document).ready(function($){
	if ($('#kudos-position-t_l:checked' ).length === 0 &&
		  $('#kudos-position-t_r:checked').length === 0 &&
		  $('#kudos-position-c_tl:checked').length === 0 &&
		  $('#kudos-position-c_tr:checked').length === 0 &&
		  $('#kudos-position-off:checked' ).length === 0 ){
	    	$('#kudos-margins').hide();
	 }

  $('.kudos-radios input[type=radio]').bind('click change', function(){
    if ($(this).prop('checked')) {
	   	if 			 ($(this).is('#kudos-position-t_l' )){
		  	$('#kudos-margins').slideDown('slow');
		    $('#kudos-margins-0').val('0');
		    $('#kudos-margins-1').val('30');
		    $('#kudos-margins-2').val('0');
		    $('#kudos-margins-3').val('0');
	    }else if ($(this).is('#kudos-position-t_r' )){
			 	$('#kudos-margins').slideDown('slow');
		    $('#kudos-margins-0').val('0');
		    $('#kudos-margins-1').val('0');
		    $('#kudos-margins-2').val('0');
		    $('#kudos-margins-3').val('30');
	    }else if ($(this).is('#kudos-position-c_tr')){
			 	$('#kudos-margins').slideDown('slow');
		    $('#kudos-margins-0').val('0');
		    $('#kudos-margins-1').val('0');
		    $('#kudos-margins-2').val('30');
		    $('#kudos-margins-3').val('30');
	   	}else if ($(this).is('#kudos-position-c_tl')){
		  	$('#kudos-margins').slideDown('slow');
		    $('#kudos-margins-0').val('30');
		    $('#kudos-margins-1').val('30');
		    $('#kudos-margins-2').val('0');
		    $('#kudos-margins-3').val('0');
	   	}else if ($(this).is('#kudos-position-off' )){
		  	$('#kudos-margins').slideDown('slow');
		    $('#kudos-margins-0').val('0');
		    $('#kudos-margins-1').val('0');
		    $('#kudos-margins-2').val('0');
		    $('#kudos-margins-3').val('0');
		  }else
	    	$('#kudos-margins').slideUp('slow');
	  }
  });
});