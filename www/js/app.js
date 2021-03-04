(function($){

	$('.addarticlePanier').click(function(event){


		event.preventDefault();
		$.get($(this).attr('href'),{},function(data){
			location.href = 'produits.php';
			$('#total').empty().append(data.total);
			$('#count').empty().append(data.count);


		},'json');
		return false;
	});

})(jQuery);
