var CONFIG = {};
$.ajax({
	type: 'POST',
	dataType: 'json',
	url: 'backend/login/getauth',
	async: false,
	success: function(data) {
		CONFIG.role = data.role;
		CONFIG.role_name = data.role_name;
	}
});