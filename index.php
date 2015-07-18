<?php
// PHP Config - These control the look and details on your site. Consult documentation for more details.
// GENERAL SETTINGS
$siteTitle = "Sleeky for YOURLS"; // Title of the page.
$siteDescription = "One of the most amazing YOURLS theme's in the world!"; // Description of your site for search engines.
$siteName = "Sleeky"; // Name of your site. Used in the top section and footer. Example: Sleeky or Shorty or Linky. I think you get the point...
$siteTagline = "The sleek public theme for YOURLS"; // The tagline of your site. Used underneath siteName in the top section.
$siteUrl = "http://localhost:8888"; // The url of your site. Don't forgot to add http:// For example: http://shorturl.com or http://sho.rt
$siteLogo = "/img/logo.png"; // The small square logo displayed at the top of the page
$siteLogoLarge = "/img/logo-head.png"; // The rectangular logo displayed in navigation and footer.
$siteFavicon = "/img/favicon.ico"; // The favourite icon used by the browser for bookmarks. Must be a .ico file and 16px x 16px

// About Area Settings
$aboutHead = "About"; // About title at the top of the section.
$aboutDescription = "Duis mollis, est non commodo luctus, nisi erat porttitor ligula, eget lacinia odio sem nec elit. Nulla vitae elit libero, a pharetra augue."; // About description at the top of the section.

$aboutPoint1 = "Clean"; // About Area Heading 1
$aboutText1 = "Nulla vitae elit libero, a pharetra augue. Maecenas faucibus mollis interdum. Sed posuere consectetur est at lobortis. Etiam porta sem malesuada magna mollis euismod."; // 3 Column Text Area 1

$aboutPoint2 = "Responsive"; // About Area Heading 2
$aboutText2 = "Nulla vitae elit libero, a pharetra augue. Maecenas faucibus mollis interdum. Sed posuere consectetur est at lobortis. Etiam porta sem malesuada magna mollis euismod."; // 3 Column Text Area 1

$aboutPoint3 = "Bootstrap Powered"; // About Area Heading 3
$aboutText3 = "Nulla vitae elit libero, a pharetra augue. Maecenas faucibus mollis interdum. Sed posuere consectetur est at lobortis. Etiam porta sem malesuada magna mollis euismod."; // 3 Column Text Area 1


?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo "$siteDescription" ?>">
    <link rel="icon" href="<?php echo "$siteFavicon" ?>">

    <title><?php echo "$siteTitle" ?></title>

    <!-- BEGIN CSS -->
    <!-- Bootstrap core CSS -->
    <link href="/styles/bootstrap.css" rel="stylesheet">
      
    <!-- Sleeky CSS -->
    <link href="/styles/sleeky.css" rel="stylesheet">
    <!-- END CSS -->

    <!-- Add extra support of older browsers -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

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
