
// KATALOG OPEN AND CHANGE FIXED POSITION TO ABSOLUTE

$('#katalog').hover(
function(){
	$('#header').css('position', 'absolute').css('top', ($(document).scrollTop()-90))
},
function(){
	$('#header').css('position', 'fixed').css('top', '0')
})

// OPEN SEARCH FORM

$(document).on('click', '.search-button', function () {
	$(this).parent().parent().toggleClass('active')
})

// SHOW AND HIDE PASSWORD

function view(id1, id2) {
		$('#' + id1).addClass('noview')
		$('#' + id2).prop('type', 'text')
}

function noview(id1, id2) {
		$('#' + id1).removeClass('noview')
		$('#' + id2).prop('type', 'password')
}

// CLOSE LOGIN FORM

$('#close').click(function(){
	$('.zanaveska').hide().css('top', '-90px')
})

// OPEN LOGIN form

$('#signIn').click(function(){
	$('.zanaveska').show()
	if(!$('.login').hasClass('activeTitle'))
	{
		$('.registration').removeClass('activeTitle')
		$('.login').addClass('activeTitle')
		$('#loginForm').show()
		$('#forRegistrationScroll').hide()
	}
})

$('#signIn2').click(function(){
	$('.zanaveska').show().css('top', '-140px');
	if(!$('.login').hasClass('activeTitle'))
	{
		$('.registration').removeClass('activeTitle')
		$('.login').addClass('activeTitle')
		$('#loginForm').show()
		$('#forRegistrationScroll').hide()
	}
})

// OPEN REGISTRATION form

$('#registration').click(function(){
	$('.zanaveska').show()
	if(!$('.registration').hasClass('activeTitle'))
	{
		$('.login').removeClass('activeTitle')
		$('.registration').addClass('activeTitle')
		$('#forRegistrationScroll').show()
		$('#loginForm').hide()
	}
});

$('#registration2').click(function(){
	$('.zanaveska').show()
	$('.zanaveska').show().css('top', '-140px');
	if(!$('.registration').hasClass('activeTitle'))
	{
		$('.login').removeClass('activeTitle')
		$('.registration').addClass('activeTitle')
		$('#forRegistrationScroll').show()
		$('#loginForm').hide()
	}
})

// TOGGLE REGISTRATION AND Login

$('.login').click(function(){
	if(!$(this).hasClass('activeTitle'))
	{
		$('.registration').removeClass('activeTitle')
		$(this).addClass('activeTitle')
		$('#forRegistrationScroll').hide()
		$('#loginForm').show()
	}
})

$('.registration').click(function(){
	if(!$(this).hasClass('activeTitle'))
	{
		$('.login').removeClass('activeTitle')
		$(this).addClass('activeTitle')
		$('#loginForm').hide()
		$('#forRegistrationScroll').show()
	}
})

// VALIDATE ARRAY

var validate_array = [];

var required = [];
required['az'] = 'Bu xanan??n doldurulmas?? vacibdir';
required['en'] = 'This field is required';
required['ru'] = '?????????????????? ?????? ????????';
required['tr'] = 'Bu alan??n doldurulmas?? ??nemli';
validate_array['required'] = required;

var maxlength_20 = [];
maxlength_20['az'] = 'Bu xanaya 20 simvoldan art??q simvol daxil edil?? bilm??z';
maxlength_20['en'] = 'This field must have less than 20 symbols';
maxlength_20['ru'] = '?????? ???????? ???????????? ?????????????????? ???????????? 20 ????????????????';
maxlength_20['tr'] = 'Bu alan 20-den az sembol i??ere bilir';
validate_array['maxlength_20'] = maxlength_20;

var mail = [];
mail['az'] = 'D??zg??n e-po??t daxil edin';
mail['en'] = 'Enter a valid mail';
mail['ru'] = '?????????????? ???????????????????? ??-????????';
mail['tr'] = 'Ge??erli bir mail girin';
validate_array['mail'] = mail;

var maxlength_100 = [];
maxlength_100['az'] = 'Bu xanaya 100 simvoldan art??q simvol daxil edil?? bilm??z';
maxlength_100['en'] = 'This field must have less than 100 symbols';
maxlength_100['ru'] = '?????? ???????? ???????????? ?????????????????? ???????????? 100 ????????????????';
maxlength_100['tr'] = 'Bu alan 100-den az sembol i??ere bilir';
validate_array['maxlength_100'] = maxlength_100;

var maxlength_10 = [];
maxlength_10['az'] = 'Bu xanaya 10 simvoldan art??q simvol daxil edil?? bilm??z';
maxlength_10['en'] = 'This field must have less than 10 symbols';
maxlength_10['ru'] = '?????? ???????? ???????????? ?????????????????? ???????????? 10 ????????????????';
maxlength_10['tr'] = 'Bu alan 10-den az sembol i??ere bilir';
validate_array['maxlength_10'] = maxlength_10;

var minlength_6 = [];
minlength_6['az'] = 'Bu xanaya 6 simvoldan az simvol daxil edil?? bilm??z';
minlength_6['en'] = 'This field must have more than 6 symbols';
minlength_6['ru'] = '?????? ???????? ???????????? ?????????????????? ???????????? 6 ????????????????';
minlength_6['tr'] = 'Bu alan 6-dan ??ok sembol i??ermeli';
validate_array['minlength_6'] = minlength_6;

var minlength_15 = [];
minlength_15['az'] = 'Bu xanaya 15 simvoldan az simvol daxil edil?? bilm??z';
minlength_15['en'] = 'This field must have more than 15 symbols';
minlength_15['ru'] = '?????? ???????? ???????????? ?????????????????? ???????????? 15 ????????????????';
minlength_15['tr'] = 'Bu alan 15-dan ??ok sembol i??ermeli';
validate_array['minlength_15'] = minlength_15;

var equalTo = [];
equalTo['az'] = '??ifr??l??r bir birin?? uy??un deyil';
equalTo['en'] = 'Passwords are not identical';
equalTo['ru'] = '???????????? ???? ??????????????????';
equalTo['tr'] = 'Parolalar ayn?? de??il';
validate_array['equalTo'] = equalTo;

// VALIDATE REGISTRATION FORM

var lang = $('#language_js').text();
$(document).ready(function() {
	$('#registrationForm').validate({
		rules: {
			fullname: {
				required: true,
				maxlength: 100
			},
			// mail: {
			// 	required: true,
			// 	email: true
			// },
			phone: {
				required: true,
				maxlength: 20,
				minlength: 15
			},
			// adress: {
			// 	required: true,
			// 	maxlength: 100
			// },
			password2: {
				required: true,
				minlength: 6
			},
			repeatPassword: {
				equalTo: '#password2'
			}
		},
		messages: {
			fullname: {
				required: validate_array['required'][lang],
				maxlength: validate_array['maxlength_100'][lang]
			},
			// mail: {
			// 	required: validate_array['required'][lang],
			// 	email: validate_array['mail'][lang]
			// },
			phone: {
				required: validate_array['required'][lang],
				maxlength: validate_array['maxlength_20'][lang],
				minlength: validate_array['minlength_15'][lang]
			},
			// adress: {
			// 	required: validate_array['required'][lang],
			// 	maxlength: validate_array['maxlength_100'][lang]
			// },
			password2: {
				required: validate_array['required'][lang],
				minlength: validate_array['minlength_6'][lang]
			},
			repeatPassword: {
				equalTo: validate_array['equalTo'][lang]
			}
		}
	})
});

function replaceElementTag(targetSelector, newTagString) {
	$(targetSelector).each(function(){
		var newElem = $(newTagString, {html: $(this).html()});
		$.each(this.attributes, function() {
			newElem.attr(this.name, this.value);
		});
		$(this).replaceWith(newElem);
	});
}

replaceElementTag('.subKataloqContent', '<a></a>');
replaceElementTag('.subCategoryContent', '<a></a>');

// CLOSE LOGIN FORM

$('#close2').click(function(){
	$('.zanaveska2').hide()
})

// OPEN LOGIN form

$('#elaqe_click').click(function(){
	$('.zanaveska2').show()
});

// SEARCH FUNCTION

$('#search_click').on('keypress',function(e) {
    if(e.which == 13) {
			var obj = {
				search: $(this).val()
			}

			window.location.replace('/pages/index/search?' + $.param(obj));
    }
});

$('#search_click2').on('keypress',function(e) {
    if(e.which == 13) {
			var obj = {
				search: $(this).val()
			}

			window.location.replace('/pages/index/search?' + $.param(obj));
    }
});

// TOASTR

var success = [];
success['az'] = 'U??urlu';
success['ru'] = '??????????????';
success['en'] = 'Success';
success['tr'] = 'Ba??ar??l??';

var success_msg = [];
success_msg['az'] = 'U??urla d??yi??dirildi';
success_msg['ru'] = '?????????????? ????????????????';
success_msg['en'] = 'Successfully changed';
success_msg['tr'] = 'Ba??ar??yla de??i??tirildi';

var error = [];
error['az'] = 'X??ta';
error['ru'] = '????????????';
error['en'] = 'Error';
error['tr'] = 'Hata';

var error_msg = [];
error_msg['az'] = 'X??ta ba?? verdi';
error_msg['ru'] = '?????????????????? ????????????';
error_msg['en'] = 'An error has occured';
error_msg['tr'] = 'Bir hata olu??tu';

let searchParams = new URLSearchParams(window.location.search)
if(searchParams.has('pd'))
{
  let pd = searchParams.get('pd');

  if(pd==0)
    toastr["error"](error_msg[lang], error[lang]);
	else if(pd==1)
		toastr["success"](success_msg[lang], success[lang]);
	else
		toastr["error"](pd, error[lang]);
}

if(searchParams.has('err_msg'))
	toastr["error"](searchParams.get('err_msg'), error[lang]);

if(searchParams.has('succ_msg'))
	toastr["success"](searchParams.get('succ_msg'), success[lang]);

	/*----- PHONE INPUT -----*/

	$('.phone_format')

		.keydown(function (e) {
			var key = e.which || e.charCode || e.keyCode || 0;
			$phone = $(this);

	    // Don't let them remove the starting '('
	    if ($phone.val().length === 1 && (key === 8 || key === 46)) {
				$phone.val('(');
	      return false;
			}
	    // Reset if they highlight and type over first char.
	    else if ($phone.val().charAt(0) !== '(') {
				$phone.val('('+String.fromCharCode(e.keyCode)+'');
			}

			// Auto-format- do not expose the mask as the user begins to type
			if (key !== 8 && key !== 9) {
				if ($phone.val().length === 4) {
					$phone.val($phone.val() + ')');
				}
				if ($phone.val().length === 5) {
					$phone.val($phone.val() + ' ');
				}
				if ($phone.val().length === 9) {
					$phone.val($phone.val() + '-');
				}
	      if ($phone.val().length === 12) {
					$phone.val($phone.val() + '-');
				}
			}

			// Allow numeric (and tab, backspace, delete) keys only
			if ($phone.val().length > 14)
				return (key == 8 ||
						key == 9 ||
						key == 46 ||
						(key >= 96 && key <= 105));
			else
				return (key == 8 ||
						key == 9 ||
						key == 46 ||
						(key >= 48 && key <= 57) ||
						(key >= 96 && key <= 105));
		})

		.bind('focus click', function () {
			$phone = $(this);

			if ($phone.val().length === 0) {
				$phone.val('(');
			}
			else {
				var val = $phone.val();
				$phone.val('').val(val); // Ensure cursor remains at the end
			}
		})

		.blur(function () {
			$phone = $(this);

			if ($phone.val() === '(') {
				$phone.val('');
			}
		});


/*----- OPEN SIDE BAR -----*/

$('.bar i').click(function(){
	if ($(this).hasClass('opened')) {
		$('.open_bar').hide(100);
		$(this).removeClass('opened');
		$(this).removeClass('fa-times');
		$(this).addClass('fa-bars');
	} else {
		$('.open_bar').show(200);
		$(this).addClass('opened');
		$(this).addClass('fa-times');
		$(this).removeClass('fa-bars');
	}
})

/*------ FOOTER CHANGE SIZE ------*/

$(document).ready(function() {
	if($(window).width() > 470)
		$('#haqqimizda').css('height', $('#kataloq').height());
});

/*----- OPEN CATALOG -----*/

$(document).on('click', '#katalog', function(){
	if (!$(this).hasClass('opened')) {
		$(this).addClass('opened');
		$('#subKataloq').slideDown(200);
	} else {
		$(this).removeClass('opened');
		$('#subKataloq').slideUp(100);
	}
});

$(document).on('click', '#katalog_mobile', function(){
	if (!$(this).hasClass('opened')) {
		$(this).addClass('opened');
		$('#subKataloq_mobile').slideDown(200);
	} else {
		$(this).removeClass('opened');
		$('#subKataloq_mobile').slideUp(100);
	}
});

$(document).click(function (e) {
    var $tgt = $(e.target);
    if (!$tgt.closest("#katalog").length) {
			$(this).removeClass('opened');
			$('#subKataloq').slideUp(100);
    }

		if (!$tgt.closest("#katalog_mobile").length) {
			$(this).removeClass('opened');
			$('#subKataloq_mobile').slideUp(100);
    }

		if (!$tgt.closest("#language").length) {
			$(this).removeClass('opened');
			$('#language_submenu').slideUp(100);
    }
});

/*----- LANGUAGE SUBMENU OPEN -----*/

$(document).on('click', '#language', function(){
	if (!$(this).hasClass('opened')) {
		$(this).addClass('opened');
		$('#language_submenu').slideDown(200);
	} else {
		$(this).removeClass('opened');
		$('#language_submenu').slideUp(100);
	}
});

//COMEMMEKSFKDKSNF

//-----
