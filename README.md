# HBBK Timetable API

This API can be used to get your current timetable from hbbk-ilias.de without needing to do all the logging in and choosing your schedule and so on, in short, it saves to time and hassle with the other current methods and is completely free of ads 🤑 🤑 🤑.

### Tech

Dillinger uses a number of open source projects to work properly:

* [AngularJS] - HTML enhanced for web apps!
* [Ace Editor] - awesome web-based text editor
* [markdown-it] - Markdown parser done right. Fast and easy to extend.
* [Twitter Bootstrap] - great UI boilerplate for modern web apps
* [node.js] - evented I/O for the backend
* [Express] - fast node.js network app framework [@tjholowaychuk]
* [Gulp] - the streaming build system
* [keymaster.js] - awesome keyboard handler lib by [@thomasfuchs]
* [jQuery] - duh

### Usage
You can make calls to the API by navigating your browser to https://hbbk.radon.cloud/v1/ and giving it the following GET parameters:
| Parameter | Description                                                                                                                                                                                                  | From Version |
| --------- | -------------------------------------------------------------------------------- | ------------ |
| username  | Your Username with hbbk-ilias.de so you can be authenticated                                                                                                                                                 | 2017-01-14/1 |
| password  | Your Password with hbbk-ilias.de so you can be authenticated                                                                                                                                                 | 2017-01-14/1 |
| week      | The Week you want the Timetalble of, this could be -1 or "prev" for last week, 0 or "this" for this week and 1 or "next" for, you guessed it, next week. If you leave it out, the API will default to "this" | 2017-01-14/1 |
| class     | The Class you want the Timetable of, this could either be your UID, ranging from 000 to 140 or your classes Name (e.g. GIA1A or GYM1B)                                                                       | 2017-01-14/1 |


### Installation
```sh
$ git clone https://github.com/lucakiebel/HBBK_API/master.git
$ sudo mv HBBK_API/ /var/www/html/ 
```


### Todos

 - Add Parameter for resulting return (html/JSON)

