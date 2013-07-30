window.rates = [];
window.count_rates = 0;

function get_rates_data(id)
{
	data = {};
	if (typeof(id) == 'string')
	{
		data = {'id': id};
	}

	$('#rates-content .rates-loading').html('Идет обновление списка...').show();
	$.ajax({
		'url': window.URL_GET_RATES_AJAX,
		'data': data,
		'dataType': 'json',
		'success': function (result) {
			if (result.success)
			{
				if (typeof(id) == 'string')
				{
					window.rates[id] = result.rates[id];
				}
				else
				{
					window.rates = result.rates;
					window.count_rates = result.count;
				}
				$('#rates-content .rates-loading').hide();
				redraw_interface();
			}
			else
			{
				$('#rates-content .rates-loading').hide();
				alert('Произошла ошибка при получении текущих валют');
			}
		},
		'error': function () {
		}
	});
}

function update_rates(id)
{
	data = {};
	if (typeof(id == 'string'))
	{
		data = {'id': id};
	}
	
	$('#rates-content .rates-loading').html('Идет обновление списка...').show();
	$.ajax({
		'url': window.URL_UPDATE_RATES_AJAX,
		'data': data,
		'dataType': 'json',
		'success': function (result) {
			$('#rates-content .rates-loading').hide();
			if (result && result.success)
			{
				get_rates_data(id);
			}
			else if (result.errors && (result.errors.length > 0))
			{
				alert(result.errors.join('\n'));
			}
			else
			{
				alert('Произошла неизвестная ошибка при обработке данных');
			}
		},
		'error': function () {
			$('#rates-content .rates-loading').hide();
			alert('Произошла ошибка на сервере при получении текущих валют');
		}
	});
}

function toggle_display(id)
{
	data = {
		'id': id,
		'select': ($('#rates-list label[remote_id=' + id + '] :checkbox').is(':checked') ? 1 : 0)
	};

	$.ajax({
		'url': window.URL_SET_SELECTED_AJAX,
		'async': false, 
		'data': data,
		'dataType': 'json',
		'success': function (result) {
			if (result && result.success)
			{
				window.rates[id].selected = data.select;
				redraw_interface();
				return;
			}
			else if (result.errors && (result.errors.length > 0))
			{
				alert(result.errors.join('\n'));
			}
			else
			{
				alert('Произошла неизвестная ошибка при обработке данных');
			}
			$('#rates-list lable[remote_id=' + id + '] input:checkbox').prop('checked', (window.rates[id].selected == 1));
		},
		'error': function () {
			alert('Произошла ошибка на сервере при добавлении валюты в список выбранных');
		}
	});
}

function redraw_interface()
{
	for (var id in window.rates)
	{
		var rate = window.rates[id];
		var oRate = $('#rates-content .rates .rate[remote_id=' + rate.remote_id + ']');
		var oOption = $('#rates-list label[remote_id=' + rate.remote_id + ']');
		if (oRate.length == 0)
		{
			oRate = $(
				'<div class="rate" remote_id="' + rate.remote_id + '">' +
					'<div class="nominal">' + rate.nominal + '&nbsp;</div>' +
					'<div class="name">' + rate.name + '</div>' +
					'<div class="char-code">' + rate.char_code + '</div>' +
					'<div class="value">' + rate.value + '</div>' +
					'<div class="control">' +
							'<button onclick="javascript: update_rates(\'' + rate.remote_id + '\');">Обновить</>' +
					'</div>' +
				'</div>'
			);
			oOption = $(
				'<label for="chk' + rate.remote_id + '" remote_id="' + rate.remote_id + '">'
					+ '<input onclick="javascript: toggle_display(\'' + rate.remote_id + '\');" id="chk' + rate.remote_id + '" type="checkbox" value="1" />'
					+ '<span>' + rate.char_code + ' - ' + rate.name + '</span>'
				+ '</label>'
			);
		}
		else
		{
			oRate.find('.nominal').html(rate.nominal + '&nbsp;');
			oRate.find('.name').html(rate.name);
			oRate.find('.char-code').html(rate.char_code);
			oRate.find('.value').html(rate.value);
			oOption.find('span').html(rate.char_code + ' - ' + rate.name);
		}

		oOption.find('input:checkbox').prop('checked', ((rate.selected == 1) ? true : false));
		if (rate.selected == 1)
		{
			oRate.show();
		}
		else
		{
			oRate.hide();
		}

		if (oRate.parent().length == 0)
		{
			$('#rates-content .rates').append(oRate);
		}
		if (oOption.parent().length == 0)
		{
			$('#rates-list').append(oOption);
		}
	}
}

$(document).ready(function () {
	get_rates_data();
});
