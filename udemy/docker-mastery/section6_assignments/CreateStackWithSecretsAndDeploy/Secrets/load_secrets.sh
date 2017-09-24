#!/bin/sh
#
# Load secrets to docker
# NOTE These method not secure for production
# Load secrets in master node
echo `cat postgres_pwd.txt` | docker secret create psql_password -
echo `cat postgres_user.txt` | docker secret create psql_user -

exit 0
