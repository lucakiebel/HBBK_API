# HBBK Stundenplan API
## Installation on a Webserver

##Requirements
 - Apache on Linux / macOS
 - wGet Command or FTP/SCP Access
 - PHP >7
 - PHPcURL installed and active
 
##Installation

Get the [API's ZIP](https://github.com/lucakiebel/HBBK_API/archive/website.zip) on your Server.

With wGet:
```sh
$ wget https://github.com/lucakiebel/HBBK_API/archive/website.zip
```
Without wGet you need to first navigate your browser to the [API's ZIP](https://github.com/lucakiebel/HBBK_API/website.zip) and then get it on your Server using either FTP, SCP or another File Transfer Protocol avaiable to you.

Then you need to unzip the file, you need Console Access (SSH), or a (browser based) File Manager for this.

With SSH:
```sh
$ unzip wesbite.zip
```

After that, using the same mehtod of accessing your servers files, move the files from the ZIP in your Apache's DocumentRoot, which by default is located at "/var/www/html/".

```sh
$ sudo mv -r HBBK_API/ /var/www/html/API
```

After that navigate your browser to http://YOUR-SERVER/API/v1/ and add the needed GET parameters from the [user documentation](https://github.com/lucakiebel/HBBK_API/blob/master/README.md)

To learn more about how to use the API as a backend developer, take a look at the [API Docs](https://hbbk.radon.cloud/v1/docs/API/)
