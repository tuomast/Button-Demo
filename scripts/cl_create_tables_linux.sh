#!/bin/bash
echo "Luodaan tietokantataulut..."

psql -1 -f ../sql/create_tables.sql

echo "Valmis!"