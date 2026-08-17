<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<script>
	// Clipboard with execCommand fallback (Issue #124 / Android)
	function fallbackCopyTextToClipboard(text) {
		var textArea = document.createElement("textarea");
		textArea.value = text;
		textArea.style.top = "0";
		textArea.style.left = "0";
		textArea.style.position = "fixed";
		document.body.appendChild(textArea);
		textArea.focus();
		textArea.select();
		try {
			document.execCommand('copy');
		} catch (err) {
			console.error('Fallback: unable to copy', err);
		}
		document.body.removeChild(textArea);
	}

	function copyTextToClipboard(text) {
		if (!navigator.clipboard) {
			fallbackCopyTextToClipboard(text);
			return;
		}
		navigator.clipboard.writeText(text).then(function() {
			console.log('Copying to clipboard was successful');
		}, function(err) {
			console.error('Could not copy text: ', err);
			fallbackCopyTextToClipboard(text);
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
		closeShortenedLinkScreenButton.addEventListener('click', function() {
			window.location.href = window.location.href;
		});
	}

	// Auto-add https:// if missing (Issue #132)
	const shortenForm = document.querySelector("form#shortenlink");
	if (shortenForm) {
		const urlInput = shortenForm.querySelector('input[name="url"]');
		if (urlInput) {
			urlInput.addEventListener('blur', function() {
				let url = this.value.trim();
				if (url && !url.match(/^https?:\/\//i)) {
					this.value = 'https://' + url;
				}
			});
			shortenForm.addEventListener("submit", function() {
				let url = urlInput.value.trim();
				if (url && !url.match(/^https?:\/\//i)) {
					urlInput.value = 'https://' + url;
				}
			}, false);
		}
	}
</script>

<?php if (defined('enableHcaptcha') && enableHcaptcha) : ?>
	<script src="https://js.hcaptcha.com/1/api.js" async defer></script>
<?php endif; ?>

<?php if (defined('enableRecaptcha') && enableRecaptcha) : ?>
	<script src="https://www.google.com/recaptcha/api.js?render=<?php echo htmlspecialchars(recaptchaV3SiteKey, ENT_QUOTES, 'UTF-8'); ?>"></script>
	<script>
	const shortenFormRecaptcha = document.querySelector("form#shortenlink");
	if (shortenFormRecaptcha) {
		shortenFormRecaptcha.addEventListener("submit", function(e){
			e.preventDefault();
			const urlInput = shortenFormRecaptcha.querySelector('input[name="url"]');
			if (urlInput) {
				let url = urlInput.value.trim();
				if (url && !url.match(/^https?:\/\//i)) {
					urlInput.value = 'https://' + url;
				}
			}
			grecaptcha.ready(function() {
				grecaptcha.execute('<?php echo htmlspecialchars(recaptchaV3SiteKey, ENT_QUOTES, 'UTF-8'); ?>', {action: 'shorten_link'}).then(function(token) {
					const tokenInput = document.createElement("input");
					tokenInput.setAttribute("type", "hidden");
					tokenInput.setAttribute("name", "token");
					tokenInput.setAttribute("value", token);
					const actionInput = document.createElement("input");
					actionInput.setAttribute("type", "hidden");
					actionInput.setAttribute("name", "action");
					actionInput.setAttribute("value", "shorten_link");
					shortenFormRecaptcha.prepend(tokenInput);
					shortenFormRecaptcha.prepend(actionInput);
					shortenFormRecaptcha.submit();
				});
			});
		});
	}
	</script>
<?php endif; ?>
