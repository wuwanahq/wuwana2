# Contributing to the Wuwana project

Looking to contribute? Welcome here friend developer! 🤓  
Wuwana is written in PHP and follows the [MVC design pattern](https://en.wikipedia.org/wiki/Model–view–controller) without any framework (so far).

The choice to use vanilla PHP was made to...

- keep the source code as simple as possible even for junior developers
- keep the memory footprint per request extremely low (PHP memory_limit can be set to **2MB**)
- keep a very short response time per request

To contribute you just need to create a pull request when your modifications are done in order to be approved by one maintainer.

## How to test locally?

After cloning the project, move in the "WebRoot" directory then run the PHP built-in web server:

```
git clone https://github.com/wuwanahq/wuwana2.git
cd wuwana2/WebRoot
php -S 0:8000 router.php
```

> This WebApp needs **PHP 7** and the DOM extension (php-xml) to work.

Now you can open the website with your browser:

- Go to http://localhost:8000/admin/companies to add new companies in the database
- Go to http://localhost:8000 to watch your data on the homepage

### Test on a mobile device

First, find the local IP address of your computer that run PHP.

- On **Mac** open Network preferences:  
![System preferences > Network](https://cdn.osxdaily.com/wp-content/uploads/2010/11/ip-address-mac.jpg)

- On **Linux** open a new Terminal and type: `ifconfig | grep 'inet \(192\|10\)\.'`
- On **Windows** open a new Command Prompt and type: `ipconfig`

Then, open the browser on your mobile device and go to `http://` your IP `:8000`  
Example: http://192.168.0.100:8000

## Targeted web browsers

- Mozilla Firefox 48+ (desktop)
- Google Chrome 49+ (desktop & mobile)
- Samsung Internet 5+ (mobile)
- Apple Safari 10+ (desktop & mobile)
- Microsoft Edge & Internet Explorer 11 (desktop)

## Project architecture

```
WebRoot
├─ router.php           <- Front controller
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
│  │  ├─ CompanyData.php
│  │  ├─ Tag.php
│  │  ├─ TagData.php
│  │  ├─ TagIterator.php
│  │  └─ ...
│  └─ Scraper, etc...   <- Other models
├─ Templates
│  ├─ admin menu.php
│  ├─ page footer.php
│  ├─ page header.php
│  ├─ page metadata.php
│  └─ text...           <- Text translations
├─ ajax                 <- Handle all JavaScript XmlHttpRequest (AJAX)
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

## Guideline and naming convention

We try to respect the following rules. 😇

**PHP code**

- Use PascalCase for namespace, class and interface names
- Use camelCase for function, method, property and variable names
- Use UPPERCASE_UNDERSCORE for constant names
- Max 120 characters per line please

**CSS code**

- Use lowercase-dashed for class names
- Use --lowercase-dashed for custom property (variable) names
- Only use property or function available with **Targeted web browsers**

**JavaScript**

- Only use strict **ECMAScript 5** (because IE11, Chrome 50 and Firefox 53 don't fully support ES6)

**SQL database**

- Use PascalCase for table and column names

**Filename**

- Use lowercase for folder names related to a web page
- Use PascalCase for PHP files related to a class, interface or namespaces (folder)
- Use lowercase for other PHP files like controller, view, text translation...
- Use lowercase for **Everything** inside the "static" folder