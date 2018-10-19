`cp .env.dist .env`  
`docker-compose up`

open `http://localhost:1080`  

`docker-compose run php composer install`  
`docker-compose run php bin/console send:mail`   

![screenshot](https://raw.githubusercontent.com/elmariachi111/sf-zip-memory-mail-attachment/master/screenshot.png)