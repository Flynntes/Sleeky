<?php 
// CONFIG - These control the look and details on your site. Consult documentation for more details.

// GENERAL

// Page title for your site
define('title', 'Sleeky theme for YOURLS'); 

// The short title of your site, used in the footer and in some sub pages
define('shortTitle', 'Sleeky');

// A description of your site, shown on the homepage.
define('description', 'A quick description on why your site is so fantastic, what it does and why people should definitely start using it. Oh, and how it’s free.'); 

// The favicon for your site
define('favicon', '/frontend/assets/img/favicon.ico');

// Logo for your site, displayed on home page
define('logo', '/frontend/assets/img/logo-black.png');

// Enable hCaptcha on the public shorten form (checkbox challenge)
// Get keys at https://dashboard.hcaptcha.com/
define('enableHcaptcha', false);
define('hcaptchaSiteKey', 'YOUR_SITE_KEY_HERE');
define('hcaptchaSecretKey', 'YOUR_SECRET_KEY_HERE');

// Enable reCAPTCHA V3 (legacy; keep disabled when using hCaptcha)
// https://www.google.com/recaptcha/admin/create
define('enableRecaptcha', false);
define('recaptchaV3SiteKey', 'YOUR_SITE_KEY_HERE');
define('recaptchaV3SecretKey', 'YOUR_SECRET_KEY_HERE');

// Enable authentication requirement for shortening links
// true = only authenticated users can shorten, false = anyone can shorten
define('requireAuth', false);

// When false, hide the public shorten form (admin/API still work). Issue #118
define('enablePublicShorten', true);

// Apply text-uppercase to URL/keyword inputs. Default false (Issue #115 / PR #48).
define('enableUppercaseInputs', false);

// Show a QR code image on the success screen (Issue #129). Default false.
define('enableQrOnSuccess', false);

// Enables the custom URL field
define('enableCustomURL', true);

// Optional primary colour. Default: #007bff
define('colour', '#007bff');

// Optional background image
// define('backgroundImage', 'https://picsum.photos/1920/1080');

// FOOTER
$footerLinks = [
    "About"   =>  "https://sleeky.flynntes.com/",
    "Contact" =>  "https://yourls.org/",
    "Legal"   =>  "https://yourls.org/",
    "Admin"   =>  "/admin"
];
