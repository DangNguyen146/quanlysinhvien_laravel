function loadBtn(button) {
	var btnold = button.html();
	button.attr('disabled', '');
	button.html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw" style="font-size:14px"></i> Đang xử lý');
	return btnold;
}

function oldBtn(button, btnold) {
	button.removeAttr('disabled');
	button.html(btnold);
}
// Check Null Input
function inputIsNull(input) {
	if (input.val() == '') return true;
	else false;
}

function inputNotNull(selector, message) {
	var input = $(selector);
	var help = $(selector + 'Help');
	if (inputIsNull(input) == true) {
		input.removeClass('is-valid').addClass('is-invalid');
		help.addClass('error').html(message);
	} else {
		input.removeClass('is-invalid').addClass('is-valid');
		help.addClass('error').html('');
	}
}
// Alert
function thongbao(type, message) {
	var select = $('#thong-bao');
	select.prepend('<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' + message + '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
	setTimeout(function () {
		jQuery('#thong-bao > .alert').fadeOut('slow');
		jQuery('#thong-bao > .alert').remove('100');
	}, 5000);
}

function clearThongbao() {
	$('#thong-bao').html('');
}
// Hàm thiết lập Cookie
function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + "; " + expires;
}
 
// Hàm lấy Cookie
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
    }
    return "";
}
// SELECT 2

function getDataUri(url, callback) {
	var image = new Image();

	image.onload = function () {
		var canvas = document.createElement('canvas');
		canvas.width = this.naturalWidth; // or 'width' if you want a special/scaled size
		canvas.height = this.naturalHeight; // or 'height' if you want a special/scaled size

		canvas.getContext('2d').drawImage(this, 0, 0);

		// Get raw image data
//		callback(canvas.toDataURL('image/png').replace(/^data:image\/(png|jpg);base64,/, ''));

		// ... or get as Data URI
		callback(canvas.toDataURL('image/png'));
	};
	image.src = url;
}

var nc = jQuery.noConflict();
nc(document).ready(function () {
	nc(function () {
		nc('[data-toggle="tooltip"]').tooltip()
	})
	nc('[nc-class-hover]').on('mouseover', function(){
		const cl = nc(this).attr('nc-class-hover');
		nc(this).addClass(cl);
	});
	nc('[nc-class-hover]').on('mouseout', function(){
		const cl = nc(this).attr('nc-class-hover');
		nc(this).removeClass(cl);
	});
	nc('[nc-notnul]').on('focusout', function(){
		var uuid = nc(this).attr('uuid');
		var value = nc(this).attr('nc-notnul');
		inputNotNull('#'+uuid, value);
	});
	nc('[link-to]').on('click', function(){
		var link = nc(this).attr('link-to');
		window.location = link;
	});
	nc('[d-uuid]').on('click', function() {
		var uuid = nc(this).attr('d-uuid');
		window.open('/api/get-file?uuid='+uuid);
	});
	
	// END HERE
});