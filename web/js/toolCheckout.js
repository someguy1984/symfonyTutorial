
/* Provide AJAX Support to the Tool Checkout page */

$('#appbundle_toolcheckout_toolId').change(function(){
	$.ajax({
		'method': 'POST',
		'url': '/new',
		'dataType': 'json',
		'data': { 'id' : $('#appbundle_toolcheckout_toolId').val() },
		'success': function(data) {
			console.log(data)
			$('#appbundle_toolcheckout_quantity').attr('max', data.value).val(data.value);
		}
	});
});
