https://api.telegram.org/bot<token>/setWebhook?url=<https_url>/api

needed ssl
on localhost
```openssl req -x509 -newkey rsa:4096 -days `days` -keyout `key_filename`.key -out `cert_filename`.crt```


installation

```composer update```
```php artisan migrate --seed```
```npm i```
```npm run dev```
```php artisan key:generate```
```php artisan storage:link```
