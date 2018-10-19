`cp .env.dist .env`  
`docker-compose up`

open `http://localhost:1080`  

`docker-compose run php composer install`  
`docker-compose run php bin/console send:mail`   

