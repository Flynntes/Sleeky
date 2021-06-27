<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
	// From https://stackoverflow.com/a/30810322
	function fallbackCopyTextToClipboard(text) {
		var textArea = document.createElement("textarea");
		textArea.value = text;
		
		// Avoid scrolling to bottom
		textArea.style.top = "0";
		textArea.style.left = "0";
		textArea.style.position = "fixed";

		document.body.appendChild(textArea);
		textArea.focus();
		textArea.select();

		try {
			var successful = document.execCommand('copy');
			var msg = successful ? 'successful' : 'unsuccessful';
			console.log('Fallback: Copying text command was ' + msg);
		} catch (err) {
			console.error('Fallback: Oops, unable to copy', err);
		}

		document.body.removeChild(textArea);
	}

	function copyTextToClipboard(text) {
		if (!navigator.clipboard) {
			fallbackCopyTextToClipboard(text);
			return;
		}
		navigator.clipboard.writeText(text).then(function() {
			console.log('Async: Copying to clipboard was successful!');
		}, function(err) {
			console.error('Async: Could not copy text: ', err);
		});
	}

	const copyBtn = document.querySelector('button#copy-button');

	if (copyBtn) {
		copyBtn.addEventListener('click', function(event) {
			copyTextToClipboard(event.target.dataset.shorturl);
		});
	}

	const closeShortenedLinkScreenButton = document.querySelector('button#close-shortened-screen');

	if (closeShortenedLinkScreenButton) {
		closeShortenedLinkScreenButton.addEventListener('click', function(event) {
			window.location.href=window.location.href;
		});
	}
</script>

<?php if (enableRecaptcha) : ?>
	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo recaptchaV3SiteKey ?>"></script>
	<script>
		const shortenForm = document.querySelector("form#shortenlink");

		if (shortenForm) {
			shortenForm.addEventListener("submit", function(e){
				e.preventDefault();
				grecaptcha.ready(function() {
					grecaptcha.execute('<?php echo recaptchaV3SiteKey ?>', {action: 'shorten_link'}).then(function(token) {
						const tokenInput = document.createElement("input");
						tokenInput.setAttribute("type", "hidden");
						tokenInput.setAttribute("name", "token");
						tokenInput.setAttribute("value", token);
						
						const actionInput = document.createElement("input");
						actionInput.setAttribute("type", "hidden");
						actionInput.setAttribute("name", "action");
						actionInput.setAttribute("value", "shorten_link");
						
						shortenForm.prepend(tokenInput);
						shortenForm.prepend(actionInput);
						shortenForm.submit();
					});
				});
			});
		}
	</script>
<?php endif; ?>