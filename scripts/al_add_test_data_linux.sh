#!/bin/bash
echo "Lisätään testidata..."

psql < ../sql/add_test_data.sql

echo "Valmis!"