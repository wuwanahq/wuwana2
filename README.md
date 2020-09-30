# Wuwana v2

CMS used for https://www.wuwana.com

## How to test locally

Open a Terminal and clone the project source with Git.  
Then, in the project directory, run the PHP built-in web server:

```
git clone https://github.com/wuwanahq/wuwana2.git
cd wuwana2
php -S localhost:8000
```

Now you can open the website with your browser:

- Go to http://localhost:8000/admin-wuwana To import your data
- Go to http://localhost:8000 To watch your data on the homepage

To update your local version: `git pull`

## How to deploy on a shared web hosting

Copy the project's files on your web hosting service (via FTP or GitHub sync).  
Import your data with the "admin-wuwana" page.