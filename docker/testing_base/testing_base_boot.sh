#!/bin/bash

echo "Starting mysqld..."
mysqld_safe --datadir=/db_data &
while ! mysql -e 'SELECT 1;' &>/dev/null; do
  echo "Mysql not ready yet..."
  sleep 1
done
echo "Mysql ready!"


echo "Running command: $@"
"$@"

echo "That's all folks!"
