// render option for select by json
function render_option(setting = {}) {
	if (count_key(setting)) {
		let select = setting.select ? setting.select : '';
		let field = setting.field;
		let valueField = (field.valueField) ? field.valueField : '';
		let textField = (field.textField) ? field.textField : '';
		let attr = (setting.attr) ? setting.attr : '';
		let data = setting.data ? setting.data : null;
		let option = '';


		// build option
		if (data !== null && typeof data == 'object' 
			&& count_key(data) > 0) {

			$.each(setting.data, function(k, v) {
				let text = textField !== '' ? v[textField] : '';
				let value = valueField !== '' ? v[valueField] : '';

				option += `<option ${attr} value="${value}">
							${text}
						   </option>`
			});
		}

		switch (setting.type) {
			case 'fresh':
				// build default option
				if (setting.default !== undefined) {
					let attrOptionDefault = "";
					let textOptionDefault = ""; 

					if (setting.default.attr) {
						attrOptionDefault = setting.default.attr;
					}

					if (setting.default.text) {
						textOptionDefault = setting.default.text;
					}

					option = `<option ${attrOptionDefault}>
								${textOptionDefault}
							   </option>${option}`;
					console.log(option);
				}

				// // build option
				// $.each(setting.data, function(k, v) {
				// 	let text = textField !== '' ? v[textField] : '';
				// 	let value = valueField !== '' ? v[valueField] : '';

				// 	option += `<option ${attr} value="${value}">
				// 				${text}
				// 			   </option>`
				// })

				// fresh option of select
				$(select).html(option);

				// if select has class 'selecpicker' -> refresh
				if ($(select).hasClass('selectpicker')) {
					console.log('ok');
					$(select).selectpicker('refresh');
				}

				break;

			case 'append':
				// append option to select
				$(select).append(option);

				// if select has class 'selecpicker' -> refresh
				if ($(select).hasClass('selectpicker')) {
					console.log('ok');
					$(select).selectpicker('refresh');
				}
				break;

			default:
				break;
		}
	}
}

// count attribute of object
function count_key(object) {
	key = [];

	for (let i in object) {
		key.push(i);
	}

	return key.length;
}

// render alert
function render_alert(type = '', message = '', selector = '') {
	let alertClass = '';
	let alertTitle = '';
	let alertMessage = message;

	switch (type) {
		case 'error':
			alertClass = 'alert-danger';
			alertTitle = 'Error!';
			break;

		case 'warning':
			alertClass = 'alert-warning';
			alertTitle = 'Warning!';
			break;

		case 'success':
			alertClass = 'alert-success';
			alertTitle = 'Success!';
			break;

		default:
			break;
	}

	let alert = `
	<div class="alert alert-dismissable ${alertClass}">
		<button type="button" class="close" data-dismiss="alert" aria-label="Close" style="margin-right: 20px;">
			<span aria-hidden="true">&times;</span>
		</button>
		<strong>${alertTitle}</strong> ${alertMessage}
	</div>`;

	$(selector).html(alert);
}

// hide element after time
function hide_after(selector, time) {
	setTimeout(() => {
	  $(selector).hide();
	}, time);
}