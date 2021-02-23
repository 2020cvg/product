@servers(['prod' => 'root@164.90.153.239'])

@story('deploy', ['on' => 'prod'])
start
git
@if($composer)
    composer
@endif
permissions
rebuild-cache
finish
@endstory

@task('start')
cd /var/www/html/ecom
php artisan down
echo 'Updating the production environment...'
@endtask

@task('finish')
cd /var/www/html/ecom
php artisan up
echo 'All done!'
@endtask

@task('git')
cd /var/www/html/ecom
git pull
@endtask

@task('composer')
cd /var/www/html/ecom
if [ -d "vendor" ]; then
rm -rf vendor
fi
composer install --no-dev
@endtask

@task('permissions')
cd /var/www/html/ecom
echo 'File permissions set successfully'
@endtask

@task('rebuild-cache')
cd /var/www/html/ecom
php artisan view:clear
php artisan route:clear
php artisan cache:clear
php artisan config:clear
@endtask
