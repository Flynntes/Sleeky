<script src="//code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo recaptchaV3SiteKey ?>"></script>

<script>
	$('#shortenlink').submit(function(event) {
		if (<?php echo (int)enableRecaptcha  ?>) {
                        grecaptcha.ready(function() {
                                grecaptcha.execute('<?php echo recaptchaV3SiteKey ?>', {action: 'shorten_link'}).then(function(token) {
                                        $('#shortenlink').prepend('<input type="hidden" name="token" value="' + token + '">');
                                        $('#shortenlink').prepend('<input type="hidden" name="action" value="shorten_link">');
                                        $('#shortenlink').unbind('submit').submit();
                                });;
                        });
                }else {
                        $('#shortenlink').unbind('submit').submit();
                }
	});
</script>

<script>
	$(document).ready(function() {
		$('.link').click(function() {
			event.preventDefault();
			newLocation = this.href;
			$('body').fadeOut(1000, newpage);
		});

		function newpage() {
			window.location = newLocation;
		}

		$('.hide-if-no-js').removeClass('hide-if-no-js');
		$('.hide-if-js').hide();
		
		$('#customise-toggle').on('click', function (event) {
			$('#customise-link').slideToggle('show');
		});
	});
</script>
