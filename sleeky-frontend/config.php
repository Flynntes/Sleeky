<?php 
// CONFIG - These control the look and details on your site. Consult documentation for more details.


// GENERAL

// Site URL
define('siteURL', 'http://localhost:8888/');

// Page title for your site
define('title', 'Sleeky theme for YOURLS'); 

// The short title of your site, used in the footer and in some sub pages
define('shortTitle', 'Sleeky');

// A description of your site, shown on the homepage.
define('description', 'A quick description on why your site is so fantastic, what it does and why people should definetly start using it. Oh, and how it’s free.'); 

// The favicon for your site
define('favicon', '/assets/img/favicon.ico');

// Logo for your site, displayed on home page
define('logo', '/assets/img/logo-black.png');

// Background for your site, displayed on home page
define('backgroundImage', '/assets/img/NAMEofYOURbackgroundFILE.jpg');

// FOOTER

// These are the links in the footer. Add a new link for each new link.
// The array follows a title link structure:
// "TITLE" => "LINK",
$footerLinks = [
    "About"   =>  "http://google.com",
    "Contact" =>  "http://apple.com",
    "Legal"   =>  "http://example.com",
    "Admin"   =>  "/admin"
];

?>
