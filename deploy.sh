echo "Updating server..."

ssh ara "
cd button
git pull
composer update
sudo service apache2 restart
exit"

echo "Done"
