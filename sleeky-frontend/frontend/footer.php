<script src="//code.jquery.com/jquery-3.4.1.min.js"></script>

<?php if (captchaProvider == "reCAPTCHAV3"):?>
<script src="https://www.google.com/recaptcha/api.js?render=<?php echo captchaSiteKey ?>"></script>
<?php elseif (captchaProvider == "hCaptcha"): ?>
<script src="https://www.hCaptcha.com/1/api.js"></script>
<?php endif; ?>

<script>
	$('#shortenlink').submit(function(event) {
		<?php if (captchaProvider == "reCaptchaV3"): ?>
			grecaptcha.ready(function() {
				grecaptcha.execute('<?php echo captchaSiteKey ?>', {action: 'shorten_link'}).then(function(token) {
						$('#shortenlink').prepend('<input type="hidden" name="token" value="' + token + '">');
						$('#shortenlink').prepend('<input type="hidden" name="action" value="shorten_link">');
						$('#shortenlink').unbind('submit').submit();
				});;
			});
		<?php else: ?>
			$('#shortenlink').unbind('submit').submit();
		<?php endif; ?>
	});

	function onSubmit(token) {
      document.getElementById("shortenlink").submit();
   	};

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
