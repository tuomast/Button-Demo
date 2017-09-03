#!/bin/bash
echo "Lisätään testidata..."

vagrant ssh -- "
cd sql
psql < add_test_data.sql
exit"

echo "Valmis!"