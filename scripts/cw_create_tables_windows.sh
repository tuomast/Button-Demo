#!/bin/bash
echo "Luodaan tietokantataulut..."

vagrant ssh -- "
cd button/sql
psql -1 -f create_tables.sql
exit"

echo "Valmis!"