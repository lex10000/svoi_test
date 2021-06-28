
## Тестовое задание

## Rest-api ЖК (companies) и планировок (layouts) с аутентификацией.

- Environment - laravel sail.
- Аутентификация - laravel sanctum.
- Laravel v. 8.40
- БД - Postgresql

Для тестирования необходимо скопировать настройки из .env.example в .env файл, 
установить зависимости командой composer install и запустить докер-среду
sail командой ./vendor/bin/sail up -d. 

В завершении устанвоки необходимо накатить миграции ./vendor/bin/sail artisan migrate --seed.


## Использование.

- необходимо зарегистрировать пользователя (/api/register, POST),
- залогиниться под пользователем (/api/login, POST), сохранить токен
- полученный токен ввести в параметром Authorization в headers для дальнеших запросов (см. использование sanctum)
- Далее, согласно resource-роутам работать с ЖК и с Планировками.
