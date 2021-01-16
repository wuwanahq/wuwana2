# Contributing to the Wuwana project

Looking to contribute? Welcome here friend developer! 🤓  
Wuwana is written in PHP and follows the [MVC design pattern](https://en.wikipedia.org/wiki/Model–view–controller) without any framework.

This basic technology stack choice was made to...

- keep the source code as simple as possible even for junior developers
- use a very low amount of memory per request (PHP memory_limit can be set to 1MB)

To contribute you just need to create a pull request when your modifications are done in order to be approuve by another contributor.

## Targeted browsers

- Mozilla Firefox 48+ (desktop)
- Google Chrome 49+ (desktop + mobile)
- Samsung Internet 5+ (mobile)
- Apple Safari 10+ (desktop + mobile)
- Microsoft Edge & Internet Explorer 11 (desktop)

## Project architecture

```
Web root
├─ index.php            <- Front controller (router)
├─ homepage             <- Folder for the home page
│  ├─ controller.php    <- Page's controller
│  ├─ view.php          <- Page's view
│  ├─ text en.php       <- Text translation in English
│  └─ text...           <- Text translations in another languages
├─ Models               <- All models usable by a controller
│  ├─ WebApp
│  │  ├─ WebApp.php     <- Common functions used for the WebApp
│  │  ├─ Config.php     <- Configuration file
│  │  └─ ...
│  ├─ DataAccess        <- Access to the database (all SQL queries are here)
│  │  ├─ DataAccess.php
│  │  ├─ Company.php
│  │  ├─ CompanyObject.php
│  │  ├─ Tag.php
│  │  ├─ TagObject.php
│  │  ├─ TagIterator.php
│  │  └─ ...
│  └─ Scraper, etc...   <- Other models
├─ Templates
│  ├─ admin menu.php
│  ├─ page footer.php
│  ├─ page header.php
│  ├─ page metadata.php
│  └─ text...           <- Text translations
├─ ajax                 <- Handle JavaScript XmlHttpRequest (AJAX)
│  └─ ...
├─ static               <- All static ressources
│  ├─ favicon
│  ├─ dhtml             <- CSS + JavaScript files
│  ├─ logo              <- Wuwana logo under trademark™
│  ├─ image             <- Pictures and backgrounds (jpg & png)
│  ├─ icon              <- Small SVG icons
│  │  ├─ gray
│  │  ├─ tiny
│  │  └─ ...
│  └─ badge, etc...
└─ ...                 <- All other folders related to a page have the same files as the homepage
```

## Naming convention

We try to respect the following naming rules. 😇

**PHP code**

- PascalCase: Name of classes, interfaces and namespaces
- camelCase: Name of functions, methods, properties and variables
- UPPERCASE_UNDERSCORE: Name of constants

**CSS code**

- lowercase-dash: Name of classes
- --lowercase-dash: Name of custom properties (variables)

**JavaScript**

...

**SQL database**

- PascalCase: Name of tables and columns

**Filename**

- lowercase: Folder related to a page
- PascalCase: PHP classes, interfaces and namespaces (folder)
- lowercase: Other PHP files like controller, view, text translation...
- lowercase: Everything inside the "static" folder