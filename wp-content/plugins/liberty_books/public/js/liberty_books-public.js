jQuery(document).ready(function(e){
	jQuery(document).on('submit', '#form_search', function(e){
		e.preventDefault();
		let form = jQuery(this)[0];
		let formData = new FormData(form);
		formData.append('action', 'search_books');
		ajax_call(formData, 'search');
	});

	jQuery(document).on('click', '#load_more', function(e){
		e.preventDefault();
		let paged = jQuery(this).attr('data-paged');
		let form = jQuery('#form_search')[0];
		let formData = new FormData(form);
		formData.append('paged', paged);
		formData.append('action', 'search_books');
		if(paged > 0){
			ajax_call(formData, 'loadmore');
		}
	});
});

function ajax_call(formData, action){
	jQuery.ajax({
	    type: "POST",
	    url: wp_object.ajaxurl,
	    data: formData,
	    dataType: 'json',
	    processData: false,
	    contentType: false,
	    success: function (data) {
			if(data.status=='success'){
				if(action == 'loadmore'){
					if(data.max_num_pages == data.paged){
						jQuery('#load_more').hide();
					}
					jQuery('#load_more').attr('data-paged', data.paged);
					jQuery('.list_books').append(data.data);
				}else{
					jQuery('.list_books').html(data.data);
				}
			}else{
				alert(data.data);
			}
	    },
	    error: function (e) {
	        console.log("ERROR : ", e);
	    }
	});
}