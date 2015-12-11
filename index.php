<?php
include 'config.php'; //Grab all the setting values

include 'header.php'; // Get the header
?>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="<?php echo "$siteUrl" ?>"><img src="<?php echo "$siteLogoLarge" ?>" height="30px"></a> <!-- Nav Bar Logo -->
        </div>
        <div id="navbar" class="navbar-collapse collapse">
        </div>
      </div>
    </nav>

    <!-- Section 1 - Top grey section -->
    <div class="jumbotron">
      <div class="container">
        <center>
            
<?php

// Start YOURLS engine
require_once( dirname(__FILE__).'/includes/load-yourls.php' );

// Change this to match the URL of your public interface. Something like: http://yoursite.com/index.php
$page = YOURLS_SITE . '/index.php' ;

// Part to be executed if FORM has been submitted
if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {

	// Get parameters -- they will all be sanitized in yourls_add_new_link()
	$url     = $_REQUEST['url'];
	$keyword = isset( $_REQUEST['keyword'] ) ? $_REQUEST['keyword'] : '' ;
	$title   = isset( $_REQUEST['title'] ) ?  $_REQUEST['title'] : '' ;
	$text    = isset( $_REQUEST['text'] ) ?  $_REQUEST['text'] : '' ;

	// Create short URL, receive array $return with various information
	$return  = yourls_add_new_link( $url, $keyword, $title );
	
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



// Part to be executed if FORM has been submitted
if ( isset( $_REQUEST['url'] ) && $_REQUEST['url'] != 'http://' ) {

	// Display result message of short link creation
    if (strpos($message,'added') === false) {
    echo "<div class=\"alert alert-warning\" role=\"alert\"><h5>$message!</h5></div><button onclick=\"goBack()\" class=\"btn btn-success margin\">Go Back</button>

<script>
function goBack() {
    window.history.back();
}
</script>";
    }

	
	if( $status == 'success' ) {
		// Include the Copy box and the Quick Share box
        echo "<p class=\"small-p\">Your shortened URL:<br><h3><a href=\"$shorturl\" target=\"_blank\">$shorturl</a></h3></p><div class=\"spacer\"></div>";
		
		// Initialize clipboard -- requires js/share.js and js/jquery.zclip.min.js to be properly loaded in the <head>
		echo "<script>init_clipboard();</script>\n";
	}

// Part to be executed when no form has been submitted
} else {

		$site = YOURLS_SITE;
		
		// Display the form
    
        echo "<a href=\"$siteUrl\"><img src=\"$siteLogo\"></a><h1>$siteName</h1><p class=\"headliner\">$siteTagline</p>";   
    
		echo <<<HTML
        
        <div class="col-md-6 col-centered">
                    <center><form method="post" action="">
                    <div class="input-group">
                        <input type="text" class="form-control url-input" name="url" placeholder="Enter your link to shorten">
                        <span class="input-group-btn">
                        <button class="btn btn-default show_hide" type="button"><span class="glyphicon glyphicon-cog cog"></span></button>
                        </span>
                    </div>
                    <div class="form-group">
                        <div class="custom">
                        <br><p class="small-p">Customise your short link (optional):</p>
                            <div class="input-group">
                                <span class="input-group-addon" id="basic-addon1">$site/</span>
                                <input type="text" class="form-control" name="keyword" placeholder="Custom short link" aria-describedby="basic-addon1">
                            </div>

                        </div>
                    </div>
                    <input type="submit" class="btn btn-success" value="Shorten" /></form><br /><p></p>
                    </center>
                </div>
HTML;

}

?>
        </center>
      </div>
    </div>
      
    <!-- Section 2 - 3 Column Text Area -->      
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-centered">
                <h2><?php echo "$aboutHead" ?></h2>
                <p class="bold"><?php echo "$aboutDescription" ?></p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <h2><?php echo "$aboutPoint1" ?></h2>
                <p><?php echo "$aboutText1" ?></p>
            </div>
            <div class="col-md-4">
                <h2><?php echo "$aboutPoint2" ?></h2>
                <p><?php echo "$aboutText2" ?></p>
            </div>
            <div class="col-md-4">
                <h2><?php echo "$aboutPoint3" ?></h2>
                <p><?php echo "$aboutText3" ?></p>
            </div>
        </div>
      </div>
      
    <!-- Section 3 - Footer -->      
    <div class="container">
      <div class="row">
        <!-- Content will go here -->      
      </div>
      <hr>
      <footer>
          <div class="col-md-6">
            <p>&copy; <?php echo "$siteName "; echo date("Y"); ?></p>
          </div>
          <div class="col-md-6">
            <p class="right"><a href="<?php echo "$siteUrl" ?>"><img height="30px" src="<?php echo "$siteLogoLarge" ?>"</p></a>
          </div>

      </footer>
    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
    <script src="/js/bootstrap.js"></script>
    <script type="text/javascript">
    $(document).ready(function(){

    $(".custom").hide();
	$(".show_hide").show();
	
	$('.show_hide').click(function(){
	$(".custom").slideToggle();
	});

    });

    </script>
  </body>
</html>
