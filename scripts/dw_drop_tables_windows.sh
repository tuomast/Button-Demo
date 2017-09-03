#!/bin/bash
echo "Poistetaan tietokantataulut..."

vagrant ssh -- "
cd button/sql 
psql < drop_tables.sql
exit"

echo "Valmis!"