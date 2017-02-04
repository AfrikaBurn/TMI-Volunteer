# Laravel VolDB
A volunteer database for events written using the Laravel 5.1 framework


## Dependencies

1. A webserver that supports PHP (```nginx``` and ```php-fpm``` recommended)
2. ```mysql```
3. ```node.js``` and ```npm``` installed on your system
4. ```gulp``` installed globally (```npm install -g gulp```) or locally if you know what you're doing
5. ```composer```, the PHP package manager
6. ```redis```, if you want to use websockets


## Installing

1. Git clone this repo
2. Set **laravel/public/** as your document root
3. Run ```composer install``` within the **laravel** folder
4. Run ```npm install``` within the **laravel** folder  
5. Set up your environment configuration. See the [Setup / Configuration](#configuration) section below. 
6. Run ```php artisan migrate``` within the **laravel** folder


## <a name="configuration"></a> Setup / Configuration

1. In the **laravel** folder, copy **.env.example** and rename it to **.env**
2. Configure your database and email settings in the **.env** file
3. run `php artisan key:generate` to generate an application key for Laravel.
4. Optionally, configure your queue and broadcast drivers. If you want to use websockets, you'll need to use redis for broadcasting
5. In the **laravel/resources/js/** folder, copy **config.example.js** and rename it to **config.js**
6. Optionally, you may configure your websocket server to use a specific hostname, however by default it will use the current domain of the site
7. Run ```gulp``` within the **laravel** folder


Alright! Now everything is compiled and the site is functional. You can register accounts, create events, and sign up for shifts.
If you want to use websockets for a couple extra features (auto-updating when shifts are taken or departments are changed), follow these steps:


## Extra websockets steps

1. Make sure ```redis``` is installed and configured as the broadcast driver in your **.env** file
2. Run ```npm install``` within the **node** folder
3. Run ```node websocket-server.js``` within the **node** folder
4. Use a ```screen``` session or a process manager like ```pm2``` to keep the websocket server running indefinitely
