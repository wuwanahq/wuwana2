# Wuwana v2

Simple business directory used by https://wuwana.com

This project maintains a list of local businesses and keep track of it by scraping their data across social media platform and websites.

## How to deploy on your web server

This WebApp needs **PHP 7** and the DOM extension (php-xml package) to work.  
Also the HTTP server must be able to rewrite URL with Apache mod_rewrite, FallbackResource directive or Nginx "try_files" directive.

### Dedicated Server or Virtual Private Server (with SSH access)

This part is for system administrator who have full access to its own server.  
If it's your case, connect to your server with SSH then...

- Move the Current Directory to your web root and clone the project:

```
cd /var/www
git clone https://github.com/wuwanahq/wuwana2.git
```

- Modify the configuration's file for the database connection in `WebRoot/Models/WebApp/Config.php` and ignore your changes by Git:

```
cd /var/www/wuwana2
nano WebRoot/Models/WebApp/Config.php
git update-index --skip-worktree WebRoot/Models/WebApp/Config.php
```

- If you don't want to use `.htaccess` files you have to copy the parameters in your server configuration in order to use permalinks.

Your website is now ready!  
Later, if you want to update the WebApp, just run `git pull` in the project directory.

### PHP shared web hosting (without SSH access)

This part is for webmaster who just have a website hosting service.  
If it's your case, check if your hosting solution is compatible with all the previous requirements then...

- Clone the project on your computer: `git clone https://github.com/wuwanahq/wuwana2.git`
- Modify the configuration's file to add your database connection parameters in `WebRoot/Models/WebApp/Config.php`
- In the Command Prompt type `git update-index --skip-worktree WebRoot/Models/WebApp/Config.php`
- Copy only the content inside the "WebRoot" folder at the root of your web hosting with a FTP client.

Your website is now ready!  
Later, if you want to update the WebApp, just run `git pull` on your computer in the project directory then re-upload all files in your web hosting with FTP.

## How to use this WebApp

Just after you installed this WebApp, the first thing to do is probably adding new company.  
Go to https://your.website/admin/companies to add new companies in the database.  
After that you can see all companies on the homepage.

## Maintainers

<table><tr>
 <td align="center"><a href="https://github.com/levogirar">
  <img src="https://avatars0.githubusercontent.com/u/54992530" width="128px">
  <br><b>Jonathan</b><br>Web designer
 </a></td>
 <td align="center"><a href="https://github.com/Nils85">
  <img src="https://avatars2.githubusercontent.com/u/11949055" width="128px">
  <br><b>Vince</b><br>Backend developer
 </a></td>
</tr></table>

## Contributing

Everybody is welcome to contribute! 🤓  
Please read the [contributing developer doc.](CONTRIBUTING.md)

## Open source license

This project is distributed under the [Mozilla Public License 2.0](LICENSE.txt) (MPL-2.0 License).  
To summarize you can fork, modify, distribute or use it even for commercial use but you can **not** use the name Wuwana™ in your website name or the Wuwana logo.