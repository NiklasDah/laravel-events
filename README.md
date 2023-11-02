# Buchungsapplikation
## Disclaimer
Dieses Projekt ist für einen Kurs an meiner Hochschule innerhalb einer sehr kurzen Zeitspanne entstanden und hat bspw. keinerlei Test-Coverage. Von der Verwendung außerhalb eines Demonstrationssettings rate ich ab.
## Installation
```sh
git clone https://github.com/NiklasDah/laravel-events.git
cd laravel-events
composer install
php artisan sail:install
npm run build
./vendor/bin/sail up -d
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan db:seed --class=RoleSeeder
```
Um einen Admin-Account zu erstellen, ist ein manueller eintrag in user_roles nötig, welcher die user_id des gewünschten Nutzers und die role_id der Rolle enthält:
```sh
./vendor/bin/sail mysql
```
```sql
INSERT INTO your_table_name (user_id, role_id, created_at, updated_at)
VALUES (1, 1, NOW(), NOW());
```

## License

Das Projekt basiert auf dem Laravel-Framework, welches unter [MIT license](https://opensource.org/licenses/MIT) verfügbar ist.