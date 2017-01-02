# Atan\Framework
Bare bones framework for generating a request and emitting a response.

## Requirements
**PHP >= 7.0** is required to use Atan\Framework but the latest stable version of PHP is recommended.

## Installation
```
$ composer create-project --repository
```
Make sure you web server uses the `public` (or whatever you want to rename it to) directory as its root.

For nginx:
```nginx
location / {
    if (!-e $request_filename){
        rewrite ^(.*)$ /index.php;
    }
}
```
For Apache, make sure `mod_rewrite` is enabled, otherwise the provided `.htaccess` will not work.

## Dependencies
Feel free to review the `composer.json` and add/remove the packages you want. The example `composer.json` has the following dependencies:

| Package Name | Version | Description |
| --- | --- | --- |
| php | ^7.0 | The minimum php version |
| psr/http-message | ^1.0.1 | PSR-7 HTTP Message interfaces |
| container-interop/container-interop | ^1.1.0 | PSR-11 Container interfaces |
| http-interop/http-middleware | ^0.3.0 | PSR-15 HTTP Middleware interfaces |
| atan/core | ^0.1.1 | Some handy helper functions used in `src/main.php` and the configuration files. This can be removed if you don't mind rewriting those files a bit. |
| atan/dependency | ^0.1.1 | A bare bones dependency injection container. This can be replaced for any container that implements PSR-11 if you want something meatier (auto wiring, perhaps). |
| atan/error | ^0.2.0 | Provides global error and throwable handlers. These can be replaced with your preference, or removed entirely if you're confident you won't trigger errors or throw exceptions. It also provides a throwable catcher for the start of the middleware queue, so if the queue throws an exception a well-formed PSR-7 response is still returned. |
| atan/http-tools | ^0.2.1 | Provides an emitter and preparer for the generated response. You can swap this out for any method for emitting your response. |
| atan/middleware | ^0.1.0 | The infrastructure for the middleware queue. This can be replaced with any PSR-15 queue runner. |
| zendframework/zend-diactoros | ^1.3.7 | The PSR-7 implementation. Easily exchanged for any other PSR-7 implementation that provides server request and response classes. |

## Directory structure
The directory structure can be altered as you see fit.
```
/
├ app/                  # For things to set once then forget about (until you need them)
│ ├ config/             # Configuration files, /src/main.php cares about this location
│ │ ├ dependencies.php  # For the default dependency injection container
│ │ ├ middleware.php    # For the default middleware queue
│ │ └ routes.pgp        # For the default router
│ └ log/                # Log files
│   └ log.json          # For the default logger
├ public/               # The web root
│ ├ assets/             # A place for symbolic links to vendor provided asset folders
│ ├ .htaccess           # Apache directory configuration file
│ └ index.php           # Redirect to /src/main.php
├ resource/             # Your non-static assets, like templates
├ src/                  # Your php files, like controllers
│ ├ Example.php         # The example controller
│ └ main.php            # Where the magic happens and where your customisation should begin
├ vendor/               # Packages from composer and the autoloader
├ composer.json         # Your package dependency and autoloader configuration
└ README.md             # This file
```