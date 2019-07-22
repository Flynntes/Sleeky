// Sleeky Admin Theme
// 2018 Flynn Tesoriero

// TODO
// Add theme URL config option (sleeky-backend)

console.log("Sleeky Admin Theme Running");

$( document ).ready(function() {
  // Get the theme URL
  var url;
  if ($('meta[name=pluginURL]').attr("content")) {
    url = $('meta[name=pluginURL]').attr("content");
  } else {
    // If for some reason we can't find the URL attribute
    url = "/user/plugins/sleeky_backend";
  }

  // Detect theme
  var theme;
  if ($('meta[name=sleeky_theme]').attr("content") == 'light') {
    theme = "light";
  } else if ($('meta[name=sleeky_theme]').attr("content") == 'dark') {
    theme = "dark";
  }
  
  console.log("Theme is", theme)

  // Update favicon
  $('link[rel="shortcut icon"]').attr('href', url + "/assets/img/favicon.ico");

  // Update meta viewport
  $('head').append('<meta name="viewport" content="width=device-width, initial-scale=1.0">');

  // Detect pages
  if ($("body").hasClass("login")) {
    // Login page
    console.log("Login page");

    if (theme == "light") {
      $("#login").prepend(`<img src="${url}/assets/img/logo_black.png">`);
    } else if (theme == "dark") {
      $("#login").prepend(`<img src="${url}/assets/img/logo_white.png">`);
    }

    
  } else if ($("body").hasClass("index")) {
    // Index page
    console.log("Index page");

    handleNav()

    // Add content padding to suit new URL section
    // $("#wrap").css("padding-top", "50px");

    // Hide YOURLS new URL section
    $("#new_url").hide();

    // Grab the nonce id
    var nonce = $("#nonce-add").val();

    // Remove the YOURLS new URL Section
    $("#new_url").remove();

    // Create the sleeky new URL section from the template
    $("nav").append($('<div>').load(`${url}/assets/html/form.html`, function () {
      $("#nonce-add").val(nonce);
    }));
  } else if ($("body").hasClass("tools")) {
    // Tools page
    console.log("Tools page");

    handleNav()

  } else if ($("body").hasClass("plugins")) {
    // Plugins page
    console.log("Plugins page");

    handleNav()

  } else if ($("body").hasClass("plugin_page_sleeky_settings")) {
    // Tools page
    console.log("Sleeky Settings Page");

    handleNav()

    $("#ui_selector").val($("#ui_selector").attr("value"));

  }  else if ($("body").hasClass("infos")) {
    // Information page
    console.log("Information page");

    handleNav()

    $("#historical_clicks li").each(function (index) {
      if (index % 2 != 0) {
        $("#historical_clicks li").eq(index).css("background", "#464646");
      }
    })
  } else {
    console.warn("Unknown page")
  }

  function handleNav() {
    // Add logo
    $("#wrap").prepend(`<img class="logo" src="${url}/assets/img/logo_white.png">`);

    // Add mobile nav hamburger
    $("#wrap").prepend(`<div class="nav-open" id="navOpen"><i class="material-icons">menu</i></div>`);

    // Add frontend link
    $('#admin_menu').append('<li class="admin_menu_toplevel"><a href="/"><i class="material-icons">arrow_back</i> Frontend Interface</a></li>');

    // admin_menu
    $('#navOpen').on('click', function() {
      $('#admin_menu').slideToggle();
    })
  }

  // Update P elements
  $("p").each(function (index) {
    if (/Display/.test($(this).text()) || /Overall/.test($(this).text())) {
      // Move info on index page to the bottom
      $("main").append("<p>" + $(this).html() + "</p>");
      $(this).remove();
    } else if (/Powered by/.test($(this).text())) {
        // Update footer
        var content = $(this).html();
        var i = 77
        var updated_content = "Running on" + content.slice(13, i) + '& <a href="https://sleeky.flynntes.com/" title="Sleeky">Sleeky</a>' + content.slice(i-1)
        $(this).html(updated_content);
      }
  });
});