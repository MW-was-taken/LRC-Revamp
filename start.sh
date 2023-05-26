sudo systemctl stop apache2
echo "Ended A2..."
sudo php artisan migrate
echo "Migration finished..."
sudo php artisan serve --port=80