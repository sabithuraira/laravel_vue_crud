## About App

- run "composer install".
- run "php artisan migrate".
- run "php artisan db:seed".
- Frontend Apps is under "ctech_fe" directory, I put "Readme" file there.
- You need to set URL API for frontend in "ctech_fe/src/main.js" variable: app.config.globalProperties.urlApi

## BACKEND API FOR PRODUCT CRUD

- INDEX: GET - {url}/api/product with body request 'keyword', 'page' and 'per_page' (optional)  => return list of column data
- STORE: POST - {url}/api/product with body request (product_name, price, quantity)  => return data that store
- UPDATE: PATCH - {url}/api/product/{id} with body request (product_name, price, quantity)  => return data that update (id param is encryption id from real ID)
- SHOW: GET - {url}/api/product/{id}  => return data column (id param is encryption id from real ID)
- DESTROY: DELETE - {url}/api/product/{id}  => return message result (id param is encryption id from real ID)


## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
