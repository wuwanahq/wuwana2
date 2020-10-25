# Wuwana v2

Simple business directory project used for https://wuwana.com

## How to test locally

Open a Terminal and clone the project sources with Git.  
Then, in the project directory, run the PHP built-in web server:

```
git clone https://github.com/wuwanahq/wuwana2.git
cd wuwana2
php -S 0:8000
```

Now you can open the website with your browser:

- Go to http://localhost:8000/admin-wuwana To import your data
- Go to http://localhost:8000 To watch your data on the homepage

Later, if you want to update your local version: `git pull`

### How to test on a mobile device

First, find the local IP address of your computer that run PHP.

- On **Mac** open Network preferences:
![MacOS](https://cdn.osxdaily.com/wp-content/uploads/2010/11/ip-address-mac.jpg)

- On **Linux** open a new Terminal and type: `ifconfig | grep 'inet \(192\|10\)\.'`
- On **Windows** open a new Command Prompt and type: `ipconfig`

Then, on your mobile device, go to `http://` your IP `:8000` with the browser  
Example: http://192.168.0.100:8000

## How to deploy on a shared web hosting

Copy the project's files on your web hosting service (via FTP or GitHub sync).  
Import your data with the "admin-wuwana" page.