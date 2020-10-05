# Wuwana v2

Simple business directory project used for https://www.wuwana.com

## How to test locally

Open a Terminal and clone the project sources with Git.  
Then, in the project directory, run the PHP built-in web server:

```
git clone https://github.com/wuwanahq/wuwana2.git
cd wuwana2
php -S 0.0.0.0:8000
```

Now you can open the website with your browser:

- Go to http://localhost:8000/admin-wuwana To import your data
- Go to http://localhost:8000 To watch your data on the homepage

To update your local version: `git pull`

### How to test on a mobile device

Find the local IP address of your computer that run PHP.

- On **Mac** or **Linux** open a new Terminal and type: `ifconfig | grep 'inet \(192\|10\)\.'`
- On **Windows** open a new Command Prompt and type: `ipconfig`

Usually a local IP ends with a number smaller than 100 and starts by 10 or 192.168...  
Now that you know your IP address, you can open the browser on your mobile device and navigate to the same URL as before by replacing “localhost” with your local IP address.

## How to deploy on a shared web hosting

Copy the project's files on your web hosting service (via FTP or GitHub sync).  
Import your data with the "admin-wuwana" page.