# Wuwana v2

Simple business directory project used for https://wuwana.com

Targeted browsers on desktop and mobile:  
Mozilla Firefox 48+, Google Chrome 49+, Samsung Internet 5+, Apple Safari 10+, Microsoft Edge and Internet Explorer 11

## How to test locally

Open a Terminal and clone the project sources with Git.  
Then, in the project directory, run the PHP built-in web server:

```
git clone https://github.com/wuwanahq/wuwana2.git
cd wuwana2
php -S 0:8000 index.php
```

> This WebApp only needs **PHP 5.6 or newer** to work.  
> PHP is already installed on Mac but you need to install it on **Windows** or **Linux**.

Now you can open the website with your browser:

- Go to http://localhost:8000/admin-wuwana to import your TSV files in the database
- Go to http://localhost:8000 to watch your data on the homepage

Later, if you want to update your local version: `git pull`

### How to test on a mobile device

First, find the local IP address of your computer that run PHP.

- On **Mac** open Network preferences:
![System preferences > Network](https://cdn.osxdaily.com/wp-content/uploads/2010/11/ip-address-mac.jpg)

- On **Linux** open a new Terminal and type: `ifconfig | grep 'inet \(192\|10\)\.'`
- On **Windows** open a new Command Prompt and type: `ipconfig`

Then, open the browser on your mobile device and go to `http://` your IP `:8000`  
Example: http://192.168.0.100:8000

## How to deploy on your web server

Instructions to install this WebApp on a shared web hosting service or a dedicated server under Linux.

### Dedicated Server or Virtual Private Server

This part is for administrators who have full access to their own server.  
If it's your case, connect to your server with SSH then...

- Move the Current Directory to your web root and clone the project:

```
cd /var/www
git clone https://github.com/wuwanahq/wuwana2.git
```

- Modify the configuration's file for the database connection in `Models/WebApp/Config.php` and add your changes in Git:

```
cd /var/www/wuwana2
nano Models/WebApp/Config.php
git update-index --skip-worktree Models/WebApp/Config.php
```

- Open your browser then go to the "admin-wuwana" page to import your TSV files in the database.

Your website is ready, you can now go to the homepage!

Later, if you want to update the WebApp, just run `git pull` in the project directory.

### PHP shared web hosting

This part is for webmasters who just have a website hosting service.  
If it's your case, check if your hosting solution is compatible with PHP, then...

- Clone the project on your computer: `git clone https://github.com/wuwanahq/wuwana2.git`
- Modify the configuration's file to add your database connection parameters in `Models/WebApp/Config.php`
- In the Command Prompt type `git commit -a -m "local config"`
- Copy all project's files at the root of your web hosting service with a FTP client.
- Open your browser then go to the "admin-wuwana" page to import your TSV files in the database.

Your website is ready, you can now go to the homepage!

Later, if you want to update the WebApp, just run `git pull` on your computer in the project directory then re-upload all files in your web hosting with FTP.

## Open source license

This project is distributed under the [Mozilla Public License 2.0](LICENSE) (MPL-2.0 License).  
To sumarize you can fork, modify, distribute or use it even for commercial use but you can **not** reuse the name "Wuwana" in your website name or the Wuwana logo.