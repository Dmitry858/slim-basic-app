## Slim framework 4 basic application
This is a skeleton for creating applications with Slim 4.

### System Requirements
- Web server with URL rewriting
- PHP 7.2 or newer

### Installation
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

### Links
- https://www.slimframework.com
- https://book.cakephp.org/phinx/0/en/index.html
- https://symfony.com/doc/current/components/http_foundation/sessions.html
- https://laravel-mix.com/docs/6.0/api

____

## Базовое приложение на фреймворке Slim 4
Это каркас для создания приложений на Slim 4.

### Системные требования
- Веб-сервер с модулем перезаписи URL
- PHP 7.2 и выше

### Установка
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

### Ссылки
- https://www.slimframework.ru/v4
- https://book.cakephp.org/phinx/0/en/index.html
- https://symfony.ru/doc/current/components/http_foundation/sessions.html
- https://laravel-mix.com/docs/6.0/api
