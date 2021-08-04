#!/bin/bash
set -e

psql -v ON_ERROR_STOP=1 --username "$POSTGRES_USER" --dbname "$POSTGRES_DB" <<-EOSQL
    CREATE USER projhospitaldb;
    CREATE DATABASE projhospitaldb;
    GRANT ALL PRIVILEGES ON DATABASE projhospitaldb TO projhospitaldb;
EOSQL
