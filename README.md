# challenge-php-lumen
Esse projeto é feito utilizando lumen e docker

# PHP CHALLENGE:
Brief Description:
- Your customer receives two XML models from his partner. This information must be
available for both web system and mobile app. XML content can be very extensive and we must
ensure the content will be fully processed.

The challenge
- Create an application to manually upload the given XMLs and have an option
to asynchronously process them. The results of the processed data must be logged. Make the
processed information available via rest APIs.

Must have:
- Symfony/Laravel.
- Docker image(s) used.
- Any level of automated tests.
- An index page to upload the XML with a button to process it.
- Rest APIs for the XML data, only the GET methods are needed.
- README.md with the instructions to install the application.

Bonus
- Authentication method to the APIs.
- Generated documentation for the APIs.

# Um pouco do projeto
Este projeto é feito utilizando um container dockerizado para a comodidade de ser utilizado em qualquer sistema operacional.
Este projeto utiliza os seguintes serviços:
```
- Nginx (arquivo dockerfile e conf dentro da pasta images/nginx)
- PHP (arquivo dockerfile dentro da pasta images/php)
- Mysql (imagem padrão)
- PHPMyAdmin (imagem padrão) - Utilizado apenas por praticidade, caso queira remover para o seu projeto, fique à vontade.
```

# Adicionando swagger
Swagger foi adicionado utilizando composer. O link do git do pacote utilizado é:
```
https://github.com/DarkaOnLine/SwaggerLume
```

Para gerar o swagger caso exista alguma mudança nas annotations dos endpoints, precisamos gerar o swagger atualizado com os comandos dentro do container do php:
```
php artisan swagger-lume:generate
```

e depois

```
php artisan swagger-lume:publish
```

Para acessar as documentações, você pode utilizar:
```
http://localhost:8082/docs (para documentação do swagger em json)
```
ou
```
http://localhost:8082/api/documentation (para acessar a view da documentação do swagger)
```

# Atualizando as permissões da pasta storage
Pode ser que, ao tentar lançar uma exception, o lumen não consiga guardar o log. Isso se dá porque a pasta storage não está com as permissões que deveria ter. Nesse caso precisamos utilizar o comando dentro do docker, no path /var/www/html:
```
chmod -R 777 (ou 775) storage
```

```
OBS: Ao tentar acessar a parte visual do swagger através do localhost:8082/api/documentation, ele lançava uma exception pois a pasta storage não estava com permissão. Você provavelmente precisará colocar essa permissão nesse caso.
```