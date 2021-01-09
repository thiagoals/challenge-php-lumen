# challenge-php-lumen
Esse projeto é feito utilizando lumen e docker

# PHP CHALLENGE:
- Brief Description:
    - Your customer receives two XML models from his partner. This information must be
available for both web system and mobile app. XML content can be very extensive and we must
ensure the content will be fully processed.

- The challenge
    - Create an application to manually upload the given XMLs and have an option
to asynchronously process them. The results of the processed data must be logged. Make the
processed information available via rest APIs.

- Must have:
    - Symfony/Laravel.
    - Docker image(s) used.
    - Any level of automated tests.
    - An index page to upload the XML with a button to process it.
    - Rest APIs for the XML data, only the GET methods are needed.
    - README.md with the instructions to install the application.

- Bonus
    - Authentication method to the APIs.
    - Generated documentation for the APIs.

# Adicionando swagger
- Swagger foi adicionado utilizando composer. O link do git do pacote utilizado é:
```
https://github.com/DarkaOnLine/SwaggerLume
```

- Para gerar o swagger caso exista alguma mudança nas annotations dos endpoints, precisamos gerar o swagger atualizado com os comandos dentro do container do php:
```
php artisan swagger-lume:generate
```

- e depois

```
php artisan swagger-lume:publish
```

# Atualizar as permissões da pasta storage
- Pode ser que, ao tentar lançar uma exception, o lumen não consiga guardar o log. Isso se dá porque a pasta storage não está com as permissões que deveria ter. Nesse caso precisamos utilizar o comando dentro do docker, no path /var/www/html:
```
chmod -R 777 (ou 775) storage
```