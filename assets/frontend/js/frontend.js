jQuery(document).ready(function($) {
	$('select.rating_sorting').change(function() {
		$(this).find('option[id="default"]').hide();
		var post_id = $(this).parents().find('.current_post_id').val();
		var post_title = $(this).parents().find('.current_product_title').val();
		var selected_time = $('select.time_sorting').val();
    var selected_rating = $(this).val();
    
    $(this).parents().find('ol.commentlist li').fadeOut(300, function(){ $(this).remove(); });
    $(this).parents().find('h2.no_of_review span').fadeOut(300, function(){ $(this).remove(); });
    
		var sort_rating_data = {
			action: 'sort_review_rating_ajax',
			product_id: post_id,
			selected_rating: selected_rating,
			selected_time: selected_time
		};
		$.post(woocommerce_params.ajax_url, sort_rating_data, function(response) {
			var splitten_data = response.split('[${#(%18_concatenate-string%18)#}$]');
			if( splitten_data[0] ) {
				$('ol.commentlist').html(splitten_data[0]);
				if( splitten_data[1] == 1 ) {
					$('h2.no_of_review').html('<span>'+splitten_data[1]+' review for '+post_title+'</span>');
				} else if( splitten_data[1] > 1 ) {
					$('h2.no_of_review').html('<span>'+splitten_data[1]+' reviews for '+post_title+'</span>');
				}
			} else {
				$('h2.no_of_review').html('<span>0 review for '+post_title+'</span>');
			}
		});
	});
	
	$('select.time_sorting').change(function() {
		$(this).find('option[id="default"]').hide();
		var selected_rating = $('select.rating_sorting').val();
		var selected_time = $(this).val();
		var post_id = $(this).parents().find('.current_post_id').val();
		
		$(this).parents().find('ol.commentlist li').fadeOut(300, function(){ $(this).remove(); });
		
		var sort_time_data = {
			action: 'sort_review_time_ajax',
			product_id: post_id,
			selected_rating: selected_rating,
			selected_time: selected_time
		};
		
		$.post(woocommerce_params.ajax_url, sort_time_data, function(response) {
			if( response ) {
				$('ol.commentlist').html(response);
			}
		});
	});
	
});