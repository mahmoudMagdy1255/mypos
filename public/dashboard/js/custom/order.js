$(document).ready(function() {
	
	$('.add-product-btn').on('click', function(e) {
		
		e.preventDefault();

		var name = $(this).data('name');
		var id = $(this).data('id');
		var price = $(this).data('price');

		$(this).removeClass('btn-success').addClass('btn-default disabled');

		var html = 
		`
		<tr>

			<td>${name}</td>
			<td> <input type="number" value="1" min="1" name="quantities[]" data-price="${price}" class="product-quantity form-control"> </td>
			<td class="product-price">${price}</td>
			<td> <button class="btn btn-sm btn-danger remove-product-btn" data-id="${id}" > <i class="fa fa-trash"></i> </button> </td>

		</tr>


		`;

		$('.order-list').append(html);


		calculate_total();

	});

	$('body').on('click', '.remove-product-btn' , function(e) {

		e.preventDefault();

		var id = $(this).data('id');

		$(this).closest('tr').remove();

		$('#product-' + id).addClass('btn-success').removeClass('btn-default disabled');

		calculate_total();

	});

	$('body').on('change keyup', '.product-quantity' , function(e) {

		
		var quantity = parseInt( $(this).val() );
		var productPrice = parseInt( $(this).data('price') );

		var productPrice = parseInt( $(this).closest('tr').find('.product-price').html(quantity * productPrice) );


	calculate_total();
	});

});


function calculate_total () {

	var price = 0;

	$(".order-list .product-price").each(function(index, el) {
		
			price += parseInt($(this).html() );

	});


	$('.total-price').html(price);

}