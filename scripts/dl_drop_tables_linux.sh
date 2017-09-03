#!/bin/bash
echo "Poistetaan tietokantataulut..."

psql < ../sql/drop_tables.sql

echo "Valmis!"