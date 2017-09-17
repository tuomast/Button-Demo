echo "Updating server..."

ssh ara "
cd button
git pull
composer update
exit"

echo "Done"
