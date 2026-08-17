<?php include 'frontend/header.php'; ?>

<body>

<?php
	// Start YOURLS engine
	require_once( dirname(__FILE__).'/includes/load-yourls.php' );

	$is_authenticated = yourls_is_valid_user();
	$page = YOURLS_SITE . '/index.php';
	$shorturl = $message = $title = $status = '';
	$inputUc = (defined('enableUppercaseInputs') && enableUppercaseInputs) ? ' text-uppercase' : '';
	$publicShorten = !defined('enablePublicShorten') || enablePublicShorten;

	if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' && $publicShorten && (!defined('requireAuth') || !requireAuth || $is_authenticated === true) ) {
		if (defined('enableHcaptcha') && enableHcaptcha) {
			$token = isset($_POST['h-captcha-response']) ? trim($_POST['h-captcha-response']) : '';
			if ($token === '') {
				$message = 'Please complete the hCaptcha challenge';
			} else {
				$api_params = array(
					'secret'   => hcaptchaSecretKey,
					'response' => $token,
					'remoteip' => isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '',
					'sitekey'  => hcaptchaSiteKey,
				);
				$ch = curl_init('https://api.hcaptcha.com/siteverify');
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($api_params));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_TIMEOUT, 15);
				$response = curl_exec($ch);
				curl_close($ch);
				$arrResponse = json_decode($response, true);
				if (is_array($arrResponse) && !empty($arrResponse['success'])) {
					shorten();
				} else {
					$message = 'hCaptcha validation failed';
				}
			}
		} elseif (defined('enableRecaptcha') && enableRecaptcha) {
			$token = isset($_POST['token']) ? $_POST['token'] : '';
			$action = isset($_POST['action']) ? $_POST['action'] : '';
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => recaptchaV3SecretKey, 'response' => $token)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$arrResponse = json_decode($response, true);
			if(is_array($arrResponse) && !empty($arrResponse["success"]) && isset($arrResponse["action"]) && $arrResponse["action"] == $action && isset($arrResponse["score"]) && $arrResponse["score"] >= 0.5) {
				shorten();
			} else {
				$message = "reCAPTCHA failed";
			}
		} else {
			shorten();
		}
	}

	function shorten() {
		$url = isset($_REQUEST['url']) ? trim($_REQUEST['url']) : '';
		if ($url !== '' && !preg_match('#^https?://#i', $url)) {
			$url = 'https://' . $url;
		}
		$keyword = isset( $_REQUEST['keyword'] ) ? $_REQUEST['keyword'] : '' ;
		$title   = isset( $_REQUEST['title'] ) ?  $_REQUEST['title'] : '' ;
		$return  = yourls_add_new_link( $url, $keyword, $title );
		global $shorturl, $message, $status, $title;
		$shorturl = isset( $return['shorturl'] ) ? $return['shorturl'] : '';
		$message  = isset( $return['message'] ) ? $return['message'] : '';
		$title    = isset( $return['title'] ) ? $return['title'] : '';
		$status   = isset( $return['status'] ) ? $return['status'] : '';
		if( isset( $_GET['jsonp'] ) && $_GET['jsonp'] == 'yourls' ) {
			$short = $return['shorturl'] ? $return['shorturl'] : '';
			$message = "Short URL (Ctrl+C to copy)";
			header('Content-type: application/json');
			echo yourls_apply_filter( 'bookmarklet_jsonp', "yourls_callback({'short_url':'$short','message':'$message'});" );
			die();
		}
	}
?>

	<div class="container-fluid h-100">
		<div class="row justify-content-center align-items-center h-100">
			<div class="col-12 col-lg-10 col-xl-8 col-xxl-5 mt-5">
				<div class="card border-0 mt-5">
					<?php if( $publicShorten && (!defined('requireAuth') || !requireAuth || $is_authenticated === true) && isset($status) && $status == 'success' ):  ?>
						<?php $url = preg_replace("(^https?://)", "", $shorturl );  ?>

						<div class="close-container text-end mt-3 me-3">
							<button type="button" class="btn-close" id="close-shortened-screen" aria-label="Close"></button>
						</div>

						<div class="card-body px-5 pb-5">
							<h2 class="text-center sleeky-heading">Your shortened link</h2>
							
							<div class="row justify-content-center">
								<div class="col-10">
									<div class="input-group input-group-block mt-4 mb-3">
										<input type="text" class="form-control<?php echo $inputUc; ?>" value="<?php echo htmlspecialchars($shorturl, ENT_QUOTES, 'UTF-8'); ?>" required>
										<button class="btn btn-primary text-uppercase py-2 px-5 mt-2 mt-md-0" type="button" id="copy-button" data-shorturl="<?php echo htmlspecialchars($shorturl, ENT_QUOTES, 'UTF-8'); ?>">Copy</button>
									</div>
									<?php if (defined('enableQrOnSuccess') && enableQrOnSuccess): ?>
										<div class="text-center my-3">
											<img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&amp;data=<?php echo rawurlencode($shorturl); ?>" width="160" height="160" alt="QR code for shortened link">
										</div>
									<?php endif; ?>
									<span class="info">View info &amp; stats at <a href="<?php echo htmlspecialchars($shorturl, ENT_QUOTES, 'UTF-8'); ?>+"><?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>+</a></span>
								</div>
							</div>
						</div>
					<?php elseif( defined('requireAuth') && requireAuth && $is_authenticated !== true ): ?>
						<div class="text-center">
							<img src="<?php echo YOURLS_SITE ?><?php echo logo ?>" alt="Logo" width="95px" class="mt-n5">
						</div>
						<div class="card-body px-md-5">
							<h2 class="text-center mb-4 sleeky-heading">Login Required</h2>
							<p class="text-center mb-4">Please log in to access the link shortening service.</p>
							<form method="post" action="">
								<div class="mb-3">
									<label for="username" class="form-label">Username</label>
									<input type="text" id="username" name="username" class="form-control" autocomplete="username" required>
								</div>
								<div class="mb-3">
									<label for="password" class="form-label">Password</label>
									<input type="password" id="password" name="password" class="form-control" autocomplete="current-password" required>
								</div>
								<div class="d-grid">
									<?php echo yourls_nonce_field('admin_login', 'nonce', false, false); ?>
									<button type="submit" class="btn btn-primary text-uppercase">Login</button>
								</div>
							</form>
						</div>
					<?php elseif( !$publicShorten ): ?>
						<div class="text-center">
							<img src="<?php echo YOURLS_SITE ?><?php echo logo ?>" alt="Logo" width="95px" class="mt-n5">
						</div>
						<div class="card-body px-md-5">
							<h1 class="h4 text-center mb-3"><?php echo htmlspecialchars(title, ENT_QUOTES, 'UTF-8'); ?></h1>
							<p class="text-center">Public link shortening is currently disabled. Use the <a href="<?php echo YOURLS_SITE; ?>/admin/">admin area</a> or the API.</p>
						</div>
					<?php else: ?>
						<div class="text-center">
							<img src="<?php echo YOURLS_SITE ?><?php echo logo ?>" alt="Logo" width="95px" class="mt-n5">
						</div>
						<div class="card-body px-md-5">
							<p><?php echo description ?></p>

							<?php if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ): ?>
								<?php if (strpos($message,'added') === false): ?>
									<div class="alert alert-danger alert-dismissible fade show" role="alert">
										<span>Oh no, <?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?>!</span>
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>	    
								<?php endif; ?>
							<?php endif; ?>

							<form id="shortenlink" method="post" action="">
								<div class="input-group input-group-block mt-4 mb-3">
									<input type="url" name="url" id="url" class="form-control sleeky-input<?php echo $inputUc; ?>" placeholder="Paste URL, Shorten &amp; Share" aria-label="Paste URL, Shorten &amp; Share" aria-describedby="shorten-button" required>
									<input class="btn btn-primary text-uppercase py-2 px-4 mt-2 mt-md-0" type="submit" id="shorten-button" value="Shorten" />
								</div>
								<?php if (defined('enableHcaptcha') && enableHcaptcha): ?>
									<div class="mb-3 d-flex justify-content-center">
										<div class="h-captcha" data-sitekey="<?php echo htmlspecialchars(hcaptchaSiteKey, ENT_QUOTES, 'UTF-8'); ?>"></div>
									</div>
								<?php endif; ?>
								<?php if (enableCustomURL): ?>
									<a class="btn btn-sm btn-white text-black-50 text-uppercase" data-bs-toggle="collapse" href="#customise-link" role="button" aria-expanded="false" aria-controls="customise-link">
										<img src="<?php echo YOURLS_SITE ?>/frontend/assets/svg/custom-url.svg" alt="Options"> Customize Link
									</a>
									<div class="collapse" id="customise-link">
										<div class="mt-2 card card-body">
											<div class="d-flex align-items-center">
												<span class="me-2"><?php echo preg_replace("(^https?://)", "", YOURLS_SITE ); ?>/</span>
												<input type="text" name="keyword" class="form-control form-control-sm sleeky-input<?php echo $inputUc; ?>" placeholder="Custom URL" aria-label="Custom URL">
											</div>
										</div>
									</div>
								<?php endif; ?>
							</form>
						</div>
					<?php endif; ?>
				</div>
				<div class="d-flex flex-column flex-md-row align-items-center my-3">
					<span class="text-white fw-light">&copy; <?php echo date("Y"); ?> <?php echo htmlspecialchars(shortTitle, ENT_QUOTES, 'UTF-8'); ?></span>
					<div class="ms-3">
						<?php foreach ($footerLinks as $key => $val): ?>
							<a class="bold-link me-3 text-white text-decoration-none" href="<?php echo htmlspecialchars($val, ENT_QUOTES, 'UTF-8'); ?>"><span><?php echo htmlspecialchars($key, ENT_QUOTES, 'UTF-8'); ?></span></a>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include 'frontend/footer.php'; ?>
</body>
</html>
