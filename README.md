[![sleeky logo](sleeky-frontend/frontend/assets/img/logo-small.png)](https://sleeky.flynntes.com)

Sleeky is a minimal interface package for use with [YOURLS](https://github.com/YOURLS/YOURLS), an open source URL shortener. Sleeky adds a public interface and overhauls the backend (admin) interface. Using this theme you can create your own Bitly / URL shortening site or a shortening site for internal use at companies.

Sleeky is split into two parts - **frontend** and **backend**.
* **Frontend** adds a public user interface. Use this for creating a branded URL shortener or shortening service.
* **Backend** makes the YOURLS backend look a lot prettier and makes various administrative tasks easier.

[**Sleeky website & demo**](https://sleeky.flynntes.com)

# Screenshots
![Frontend Screenshot](http://sleeky.flynntes.com/assets/img/slides/frontend.png)
![Backend Screenshot](http://sleeky.flynntes.com/assets/img/slides/light_index.png)

## Quick Start
1. Get a YOURLS install up and running.
2. Clone this repo.
2. Move the contents of the `sleeky-frontend` directory to the root of your YOURLS installation.
3. Open the frontend/config.php file and change the values to suit (Remember to setup reCAPTCHA).
*Sleeky frontend is now installed a ready*
4. Move the `sleeky-backend` folder to the `user/plugins/` folder of your YOURLS installation.
5. Activate the plugin in the YOURLS admin area (`example.com/admin/plugins.php`). The plugin will show as Sleeky Backend.
6. Done. Sleeky is now installed

## Documentation 
Everything you need to know about Sleeky can be found in the Wiki! You can find that [here](https://github.com/Flynntes/Sleeky/wiki)

## Help
Need a hand? I would love to help you out! Head over to my [site](http://flynntes.com/contact). Alternatively, you could open an issue on GitHub or you could [tweet me](http://twitter.com/flynntes).

## Versioning
Sleeky follows the principles of [Semantic Versioning](http://semver.org/).

## License
This code is released under the [MIT License](https://github.com/Flynntes/Sleeky/blob/master/LICENSE.md)
