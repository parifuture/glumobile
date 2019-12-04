# Glu Tech Challenge

Submitted by Parik on Dec 3rd 2019.
Notes:
* Lumen for API
* MySQL to store information
* Queues/Jobs for backend processing

## Installation

Make sure that lumen is installed globally. And then run the following commands. The commands may not be in the right order or I might have missed something please reach out and I will be happy to jump on a call to discuss.

```bash
lumen new glu
php artisan migrate
php artisan db:seed
composer dump-autoload -o
php artisan queue:work &
```


## License

Open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
