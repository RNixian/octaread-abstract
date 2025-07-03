<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
-----------------------------------------------------------------------------------------------------------------------------------

=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+

USER: http://10.0.0.41/pages/userlogin
ADMIN: http://10.0.0.41/admin/adminlogin

IPv4 address MUST BE CHANGE, to see the address to use just do "crtl+r" then type cmd click OK, 
then type "ipconfig" then look for the line "IPv4 address...." 

=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+=+


Installing XAMPP
    //
Go to: https://www.apachefriends.org/index.html

*Click on Download for your OS (choose Windows if you're using Windows).

*Run the downloaded .exe file.

*During installation, enable at least:

    Apache

    MySQL

    PHP

    phpMyAdmin

*After installation, open XAMPP Control Panel.

*Click Start for both Apache and MySQL.

*To check if it's working:

    Open your browser and go to: http://localhost

If it loads the XAMPP dashboard, you're good!
-----------------------------------------------------------------------------------------------------------------------------------
Installing Visual Studio Code (VS Code)
    //
*Go to: https://code.visualstudio.com/

*Click Download.

*Install with default settings.

*After installing, open VS Code.

Recommended Extensions (install inside VS Code)

Click on the Extensions icon on the left sidebar and install:

    Laravel Blade Snippets
    Laravel Artisan
    Laravel Extra Intellisense
    PHP Intelephense
    MySQL (by cweijan)
-----------------------------------------------------------------------------------------------------------------------------------

Installing Composer
    //
*Go to: https://getcomposer.org/download/

*Download the Composer-Setup.exe file.

Run the installer:
Make sure it detects the PHP path (usually from XAMPP: C:\xampp\php\php.exe)- simply search in the file explorer
Finish setup and restart your PC.

to check the version open command prompt "ctrl+r" type "cmd" click "ok" then type "composer -v"

expected output:Composer version 2.8.9 2025-05-13 14:01:37
-----------------------------------------------------------------------------------------------------------------------------------
Installing Laravel
    //
*Open Command Prompt or Terminal.
run the command:
    composer global require laravel/installer

Adding laravel path
C:\Users\YourUsername\AppData\Roaming\Composer\vendor\bin

*Copy this path.

*Open Start Menu > Environment Variables.

*Click Edit the system environment variables.

*Click Environment Variables.

*Under User variables, find Path and click Edit.

*Click New and paste the path.

*Click OK.

to check the version open command prompt "ctrl+r" type "cmd" click "ok" then type "laravel -v"

-------------------------------------------------------------------------------------------------------------
Installing Gitbash
    //
Go to the official Git website:
https://git-scm.com/downloads

*Download the installer for your operating system (Windows).

*Run the installer.

*When asked for setup options, you can leave everything as default unless you know what you're changing.

*Important recommended options during setup:

*Choose the default editor: You can select Visual Studio Code if you have it installed.

*Adjusting your PATH environment: Choose Git from the command line and also from 3rd-party software.

*Choosing HTTPS transport backend: Select Use HTTPS.

*Line ending conversions: Choose Checkout Windows-style, commit Unix-style line endings.

*Finish the installation.

-------------------------------------------------------------------------------------------------------------
1. Creating Your Laravel Project
Open Command Prompt.

Navigate to XAMPP’s htdocs folder:
cd C:\xampp\htdocs
Create your Laravel project:

laravel new your-project-name
This may take a few minutes. It will automatically create a new folder.

2. Open Project in VS Code

Open VS Code.
Click File > Open Folder.

Select:
C:\xampp\htdocs\your-project-name

3. Setup .env File

In the VS Code sidebar, find .env.example.

Right-click > Copy then Paste in the same folder.

Rename the copy to: .env

In VS Code Terminal:
php artisan key:generate
This generates your app key and updates the .env file automatically.

4. Create a MySQL Database

Open your browser.

Go to: http://localhost/phpmyadmin

Click New on the left sidebar.

Type laravel_db as the database name (or any name).

Click Create.

4. Update .env for Database
In your .env file, update these lines:

from this:
DB_CONNECTION=sqlite
#DB_HOST=127.0.0.1
#DB_PORT=3306
#DB_DATABASE=laravel
#DB_USERNAME=root
#DB_PASSWORD=

to this:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_db(or any name)
DB_USERNAME=root
DB_PASSWORD=

No password is needed for XAMPP's default MySQL setup.

5. Run Laravel Development Server

In the VS Code Terminal, type:

php artisan serve
Open your browser and visit:
http://127.0.0.1:8000

You should see the Laravel welcome page!
-------------------------------------------------------------------------------------------------------------
TIPS USE GITBASH AS TERMINAL

DO "ctrl+shift+p"

type: Terminal: Select Dafult Profile

choose preferred CLI(command-line interface)

do "crtl+`" will open the terminal

when opening adding another terminal just find the icon "v" then select preferred CLI

go to this link to see the commands you might need
https://laravel.com/docs/12.x/artisan


php artisan serve
php artisan migrate
php artisan make:view Laravel
php artisan make:controller LaravelController
php artisan make:model LaravelModel


Best Practices
https://github.com/alexeymezenin/laravel-best-practices/blob/master/README.md

When looking for a specific line in a long code do this "ctrl+f" a pop from the upper right should appear;
Then just type the word you are looking for

-------------------------------------------------------------------------------------------------------------
ON THE PROJECT OCTAREAD
-------------------------------------------------------------------------------------------------------------

1. Open VsCode
2. Click "File" in the upper right tab 
   Click "open folder"
   Locate the path: C:\xampp\htdocs
   then click "select folder"


3. Open a new terminal and type this command: 
    git clone https://github.com/RNixian/octaread-abstract.git
    composer install
    php artisan storage:link

4. Copy the .env file type this command
    cp .env .env.example

    In your .env file, update these lines:

    from this:
    DB_CONNECTION=sqlite
    #DB_HOST=127.0.0.1
    #DB_PORT=3306
    #DB_DATABASE=laravel
    #DB_USERNAME=root
    #DB_PASSWORD=

    to this:
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=octaread
    DB_USERNAME=root
    DB_PASSWORD=

5. Open your browser and go to this link 
    http://localhost/phpmyadmin/

    Click "new" from the left sidebar
    Input the database name "octaread"
    Then click "create"

6. In your terminal run the command: php artisan migrate
    then refresh the website in your browser to see if the tables were successfully imported

7. Click "File" in the upper right tab 
   Click "open file"
   Locate the path: C:\Users\lexpi\octaread-abstract\vendor\laravel\framework\src\illuminate\foundation\http\kernel.php
   then click "open"

   or

   Find the manually from the left sidebar
   vendor/laravel/framework/src/illuminate/foundation/http/kernel.php

    locate the line: protected $routeMiddleware = [];
    then type the following:
    'admin.auth' => \App\Http\Middleware\AdminAuth::class,
    'account.auth' => \App\Http\Middleware\accountauth::class,
    'noadmins.auth' => \App\Http\Middleware\adminemptyauth::class,

    Which should look like this:

     protected $routeMiddleware = [
        'admin.auth' => \App\Http\Middleware\AdminAuth::class,
        'account.auth' => \App\Http\Middleware\accountauth::class,
        'noadmins.auth' => \App\Http\Middleware\adminemptyauth::class,
    ];

8. Follow path: C:\xampp\apache\conf\extra
    in httpd-vhosts

    a.replace bottom section to This:

        <VirtualHost *:80>
            ServerAdmin webmaster@localhost
            DocumentRoot "C:\Users\lexpi\octaread-abstract\public"
            ServerName octaread.test
                <Directory "C:\Users\lexpi\octaread-abstract\public">
                    Options Indexes FollowSymLinks
                    AllowOverride All
                    Require all granted
                </Directory>
        </VirtualHost>

    NOTE: copy the path of the laravel project then add "/public"

9. open your CMD on your PC then run: ipconfig
    a. find the IPv4 address 

10. follow this path: C:\Windows\System32\drivers\etc
        in hosts
            at the buttom part look for the line:

            "120.0.0.1       localhost"

        a.replace the 127.0.0.1 with the "IPv4 address"
        b. replace the localhost the same as the servername in the previous path

        Which should look like this:

        10.0.0.43   	octaread.test

        After saving the file restart the apache in the xampp Control Panel:
        Click the "stop" button then then start it again by clicking the "start" button

11. C:\xampp\apache\conf

be sure to remove the comment of "#"

    # Include conf/extra/httpd-vhosts.conf

12. local the line APP_URL=http://localhost:8000
    a. replace the "localhost:8000" with the "IPv4 address"

13. running it on other divice you must type this "http://(IPv4address)"

14. When running on computer "host" i can be run by "http://(IPv4address)" or "octaread.test"