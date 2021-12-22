## Slim framework 4 basic application
This is a skeleton for creating applications with Slim 4.

### System Requirements
- Web server with URL rewriting
- PHP 7.4 or newer

### Installation and setup
1. Copy this repository to the root directory of the project.
2. Use the following commands:
```
composer install
```

```
npm install
```
3. If you use Nginx instead of Apache web server read [this guide](https://www.slimframework.com/docs/v4/start/web-servers.html#nginx-configuration).
4. Change the default settings of the Database connection in the files `/config/database.php` and `/config/migrations.php`.
5. Start migrations:
```
./vendor/bin/phinx migrate -c ./config/migrations.php
```
6. Change the password of the test user in the file `/database/seeders/UserSeeder.php`.
7. Start seeders:
```
./vendor/bin/phinx seed:run -c ./config/migrations.php
```
8. If you use this application for building REST API don't forget to change the secret key in the file `/config/api.php`.

### Version with admin panel
The branch "[admin-panel](https://github.com/dmitry858/slim-basic-app/tree/admin-panel)" has the version of application with admin panel.

### Links
- https://www.slimframework.com
- https://book.cakephp.org/phinx/0/en/index.html
- https://symfony.com/doc/current/components/http_foundation/sessions.html
- https://laravel.com/docs/8.x/eloquent
- https://laravel.com/docs/8.x/blade
- https://laravel-mix.com/docs/6.0/api
- https://github.com/tuupola/slim-jwt-auth
- https://firebaseopensource.com/projects/firebase/php-jwt/
- https://github.com/PHPMailer/PHPMailer
- https://www.scrapbook.cash/adapters/flysystem/

____

## Базовое приложение на фреймворке Slim 4
Это каркас для создания приложений на Slim 4.

### Системные требования
- Веб-сервер с модулем перезаписи URL
- PHP 7.4 и выше

### Установка и настройка
1. Скопируйте содержимое репозитория в корень проекта.
2. Выполните следующие команды:
```
composer install
```

```
npm install
```
3. Если вы используете веб-сервер Nginx вместо Apache, посмотрите пример конфигурации в [документации](https://www.slimframework.com/docs/v4/start/web-servers.html#nginx-configuration).
4. Поменяйте настройки соединения с базой данных в файлах `/config/database.php` и `/config/migrations.php`.
5. Запустите миграции:
```
./vendor/bin/phinx migrate -c ./config/migrations.php
```
6. Поменяйте пароль тестового пользователя в файле `/database/seeders/UserSeeder.php`.
7. Запустите сидеры:
```
./vendor/bin/phinx seed:run -c ./config/migrations.php
```
8. Если вы используете это приложение для создания REST API, не забудьте поменять секретный ключ в файле `/config/api.php`.

### Версия с административной панелью
Ветка "[admin-panel](https://github.com/dmitry858/slim-basic-app/tree/admin-panel)" содержит версию приложения с административной панелью.

### Ссылки
- https://www.slimframework.ru/v4
- https://book.cakephp.org/phinx/0/en/index.html
- https://symfony.ru/doc/current/components/http_foundation/sessions.html
- https://docs.rularavel.com/docs/8.x/eloquent
- https://docs.rularavel.com/docs/8.x/blade
- https://laravel-mix.com/docs/6.0/api
- https://github.com/tuupola/slim-jwt-auth
- https://firebaseopensource.com/projects/firebase/php-jwt/
- https://github.com/PHPMailer/PHPMailer
- https://www.scrapbook.cash/adapters/flysystem/
