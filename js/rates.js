function update_rates(renew)
{
	data = {
		'renew': null
	};
	if (renew == 1)
	{
		data.renew = 1;
	}


	$('#rates-content').html('<div class="rates-loading">Идет обновление списка...</div>');
	$.ajax({
		'url': window.URL_RATES_AJAX,
		'async': false,
		'data': data,
		'dataType': 'json',
		'success': function (result) {
			if (result && result.success)
			{
				$('#rates-content').html(result.html);
				$('.rates-controls .add-rates span').html(result.addlist);
				$('.rates-controls .selected-rates span').html(result.currentlist);
			}
			else
			{
				alert('Произошла ошибка при получении текущих валют');
			}
		},
		'error': function () {
			alert('Произошла ошибка на сервере при получении текущих валют');
		}
	});
}

function add_to_selected()
{
	$.ajax({
		'url': window.URL_ADD_TO_SELECTED,
		'async': false, 
		'data': {
			"char_code": $('.rates-controls .add-rates span select option:selected').val(),
		},
		'dataType': 'json',
		'success': function (result) {
			if (result && !result.success)
			{
				alert('Произошла ошибка при добавлении валюты в список выбранных');
			}
		},
		'error': function () {
			alert('Произошла ошибка на сервере при добавлении валюты в список выбранных');
		}
	});
	update_rates();
}

function remove_from_selected(char_code)
{
	$.ajax({
		'url': window.URL_REMOVE_FROM_SELECTED,
		'async': false, 
		'data': {
			"char_code": char_code,
		},
		'dataType': 'json',
		'success': function (result) {
			if (!result.success)
			{
				alert('Произошла ошибка при удалении валюты из списка выбранных');
			}
		},
		'error': function () {
			alert('Произошла ошибка на сервере при удалении валюты из списка выбранных');
		}
	});
	update_rates();
}

$(document).ready(function () {
	update_rates();
});
