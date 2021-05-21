<?php 
// Start YOURLS engine
require_once( dirname(__FILE__).'/includes/load-yourls.php' );

include 'frontend/header.php'; 

?>

<body>

<?php
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

	
<?php if( isset($status) && $status == 'success' ):  ?>

	<?php $url = preg_replace("(^https?://)", "", $shorturl );  ?>

	<section class="success-screen">
		<div class="container verticle-center">
			<div class="main-content">
				<div class="close noselect">
				    <a href="javascript:window.location.href=window.location.href;"><i class="material-icons">close</i></a>
				</div>
				<section class="head">
					<h2>YOUR SHORTENED LINK:</h2>
				</section>
				<section class="link-section">
					<input type="text" class="short-url" disabled style="text-transform:none;" value="<?php echo $shorturl; ?>">
					<button class="short-url-button noselect" data-clipboard-text="<?php echo $shorturl; ?>">Copy</button>
					<span class="info">View info &amp; stats at <a href="<?php echo $shorturl; ?>+"><?php echo $url; ?>+</a></span>
				</section>
			</div>
	</section>

    <script>
	    var clipboard = new ClipboardJS('.short-url-button');
    </script>

<?php else: ?>

	<?php $site = YOURLS_SITE; ?>

	<div class="container verticle-center main">
		<div class="main-content">
			<div class="above">
				<img class="noselect" src="<?php echo siteURL ?><?php echo logo ?>" alt="Logo" width="95px">
			</div>
			<section class="head">
				<p><?php echo description ?></p>
			</section>
			<section class="field-section">
				<?php if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ): ?>
					<?php if (strpos($message,'added') === false): ?>
						<div id="error" class="alert alert-warning error" role="alert">
							<h5>Oh no, <?php echo $message; ?>!</h5>
						</div>	    
					<?php endif; ?>
				<?php endif; ?>
				<form id="shortenlink" method="post" action="">
					<input type="url" name="url" class="url" id="url" placeholder="PASTE URL, SHORTEN &amp; SHARE" required>
					<input type="submit" value="Shorten">
					<?php if (enableCustomURL): ?>
						<span class="customise-button noselect" id="customise-toggle"><img src="<?php echo siteURL ?>/frontend/assets/svg/custom-url.svg" alt="Options"> Customise Link</span>
						<div class="customise-container" id="customise-link" style="display:none;">
							<span><?php echo preg_replace("(^https?://)", "", siteURL ); ?>/</span>
							<input type="text" name="keyword" class="custom" placeholder="CUSTOM URL">
						</div>
					<?php endif; ?>
				</form>
			</section>
			<section class="footer">
		<div>
			<span class="light">&copy; <?php echo date("Y"); ?> <?php echo shortTitle ?></span>
			<div class="footer-links">
				<?php foreach ($footerLinks as $key => $val): ?>
					<a href="<?php echo $val ?>"><span><?php echo $key ?></span></a>
				<?php endforeach ?>
			</div>
		</div>
	</section>
		</div>
	</div>
<?php endif; ?>
<?php include 'frontend/footer.php'; ?>
</body>
</html>
