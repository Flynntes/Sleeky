<?php include 'frontend/header.php'; ?>

<body>

<?php
	// Start YOURLS engine
	require_once( dirname(__FILE__).'/includes/load-yourls.php' );

	// URL of the public interface
	$page = YOURLS_SITE . '/index.php' ;

	// Make variables visible to function & UI
	$shorturl = $message = $title = $status = '';

	// Part to be executed if FORM has been submitted
	if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {
		if (enableRecaptcha) {
			// Use reCAPTCHA
			$token = $_POST['token'];
			$action = $_POST['action'];
			
			// call curl to POST request
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => recaptchaV3SecretKey, 'response' => $token)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$arrResponse = json_decode($response, true);
			
			// verify the response
			if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) {
				// reCAPTCHA succeeded
				shorten();
			} else {
				// reCAPTCHA failed
				$message = "reCAPTCHA failed";
			}
		} else {
			// Don't use reCAPTCHA
			shorten();
		}
	}

	function shorten() {
		// Get parameters -- they will all be sanitized in yourls_add_new_link()
		$url     = $_REQUEST['url'];
		$keyword = isset( $_REQUEST['keyword'] ) ? $_REQUEST['keyword'] : '' ;
		$title   = isset( $_REQUEST['title'] ) ?  $_REQUEST['title'] : '' ;
		$text    = isset( $_REQUEST['text'] ) ?  $_REQUEST['text'] : '' ;

		// Create short URL, receive array $return with various information
		$return  = yourls_add_new_link( $url, $keyword, $title );
		
		// Make visible to UI
		global $shorturl, $message, $status, $title;

		$shorturl = isset( $return['shorturl'] ) ? $return['shorturl'] : '';
		$message  = isset( $return['message'] ) ? $return['message'] : '';
		$title    = isset( $return['title'] ) ? $return['title'] : '';
		$status   = isset( $return['status'] ) ? $return['status'] : '';
		
		// Stop here if bookmarklet with a JSON callback function ("instant" bookmarklets)
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
					<?php if( isset($status) && $status == 'success' ):  ?>
						<?php $url = preg_replace("(^https?://)", "", $shorturl );  ?>

						<div class="close-container text-end mt-3 me-3">
							<button type="button" class="btn-close" id="close-shortened-screen" aria-label="Close"></button>
						</div>

						<div class="card-body px-5 pb-5">
							<h2 class="text-uppercase text-center">Your shortened link</h2>
							
							<div class="row justify-content-center">
								<div class="col-10">
									<div class="input-group input-group-block mt-4 mb-3">
										<input type="text" class="form-control text-uppercase" value="<?php echo $shorturl; ?>" required>
										<button class="btn btn-primary text-uppercase py-2 px-5 mt-2 mt-md-0" type="submit" id="copy-button" data-shorturl="<?php echo $shorturl; ?>">Copy</button>
									</div>
									<span class="info">View info &amp; stats at <a href="<?php echo $shorturl; ?>+"><?php echo $url; ?>+</a></span>
								</div>
							</div>
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
										<span>Oh no, <?php echo $message; ?>!</span>
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>	    
								<?php endif; ?>
							<?php endif; ?>

							<form id="shortenlink" method="post" action="">
								<div class="input-group input-group-block mt-4 mb-3">
									<input type="url" name="url" id="url" class="form-control text-uppercase" placeholder="PASTE URL, SHORTEN &amp; SHARE" aria-label="PASTE URL, SHORTEN &amp; SHARE" aria-describedby="shorten-button" required>
									<input class="btn btn-primary text-uppercase py-2 px-4 mt-2 mt-md-0" type="submit" id="shorten-button" value="Shorten" />
								</div>
								<?php if (enableCustomURL): ?>
									<a class="btn btn-sm btn-white text-black-50 text-uppercase" data-bs-toggle="collapse" href="#customise-link" role="button" aria-expanded="false" aria-controls="customise-link">
										<img src="<?php echo YOURLS_SITE ?>/frontend/assets/svg/custom-url.svg" alt="Options"> Customise Link
									</a>
									<div class="collapse" id="customise-link">
										<div class="mt-2 card card-body">
											<div class="d-flex  align-items-center">
												<span class="me-2"><?php echo preg_replace("(^https?://)", "", YOURLS_SITE ); ?>/</span>
												<input type="text" name="keyword" class="form-control form-control-sm text-uppercase" placeholder="CUSTOM URL" aria-label="CUSTOM URL">
											</div>
										</div>
									</div>
								<?php endif; ?>
							</form>
						</div>
					<?php endif; ?>
				</div>
				<div class="d-flex flex-column flex-md-row align-items-center my-3">
					<span class="text-white fw-light">&copy; <?php echo date("Y"); ?> <?php echo shortTitle ?></span>
					<div class="ms-3">
						<?php foreach ($footerLinks as $key => $val): ?>
							<a class="bold-link me-3 text-white text-decoration-none" href="<?php echo $val ?>"><span><?php echo $key ?></span></a>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include 'frontend/footer.php'; ?>
</body>
</html>
