# Creacion del Proyecto

```powershell
composer create-project symfony/website-skeleton sistema-curso

php bin/console doctrine:database:create
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```