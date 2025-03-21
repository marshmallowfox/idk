# Запуск сервиса

## Поднятие контейнеров:
```bash
docker compose up -d
```

Установка зависимостей:
```bash
docker exec -it laravel_app bash
composer install
php artisan migrate
```

Сервис доступен по адресу: 127.0.0.1:8080

# API Эндпоинты

Получить список гостей (пагинация)
```
GET /api/guests
```

Создать гостя
```
POST /api/guests
```
Получить гостя по ID
```
GET /api/guests/{guest}
```
Обновить гостя
```
PUT /api/guests/{guest}
```
Удалить гостя
```
DELETE /api/guests/{guest}
```

# Дополнительно

В ответах API присутствуют заголовки X-Debug-Time и X-Debug-Memory если установлено расширение X-Debug.
