(function () {

	$(document).on('click',".rate:not([qualified]) > span[data-qualify]",function(){
        $(this).attr("checked",true);
        $(this).closest(".rate").attr("qualified",true)

        postId = $(this).attr("data-post-id");
        stars = $(this).attr("data-star");

        $.ajax({
        	type:'POST',
        	url:'/calificar/'+postId,
        	data:{
        		stars:stars, 
        	},
        	success:function(data){
				iziToast.show({
                    title: 'Gracias',
                    message: 'La calificación se registró con éxito',
                    color: 'green',
                });
        	}
        })
    })

	function getAjaxError(xhr) {
		var message = 'Ocurrió un error, vuelva a intentar';
		if (xhr.status == 422) {
			for (var i  in xhr.responseJSON.errors) {
				message = xhr.responseJSON.errors[i][0];
				break;
			}
		}
		return message;
	}
})();