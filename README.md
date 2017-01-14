# HBBK Timetable API

This API can be used to get your current timetable from hbbk-ilias.de without needing to do all the logging in and choosing your schedule and so on, in short, it saves to time and hassle with the other current methods and is completely free of ads 🤑 🤑 🤑.

### Usage
You can make calls to the API by navigating your browser to https://hbbk.radon.cloud/v1/ and giving it the following GET parameters:

| Parameter 	| Description                                                  	|                                           Possible Value                                           	| From Version 	|
|:---------:	|--------------------------------------------------------------	|:--------------------------------------------------------------------------------------------------:	|:------------:	|
| username  	| Your Username with hbbk-ilias.de so you can be authenticated 	| YOUR_USERNAME                                                                                      	| 2017-01-14/1 	|
| password  	| Your Password with hbbk-ilias.de so you can be authenticated 	| YOUR_PASSWORD                                                                                      	| 2017-01-14/1 	|
| week      	| The Week you want the Timetalble of                          	| "-1" or "prev" for the previous week; "0" or "this" for this week; "1" or "next" for the next week 	| 2017-01-14/1 	|
| class     	| The Class you want the Timetable of                          	| Your Classes UID (001..140) or your Classes Name (e.g. GIA2A or GYM2A)                             	| 2017-01-14/1 	|



### Installation
```sh
$ git clone https://github.com/lucakiebel/HBBK_API/master.git
$ sudo mv HBBK_API/ /var/www/html/ 
```


### Todos

 - Add Parameter for resulting return (html/JSON)

