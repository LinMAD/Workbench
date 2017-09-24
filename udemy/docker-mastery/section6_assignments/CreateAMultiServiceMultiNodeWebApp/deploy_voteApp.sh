#!/bin/bash
#
# Tested only on Debian 9 "Stretch"
# Simple script to deploy docker-compose.yml to docker swarm cluster
#
read -p "Enter -> Docker machine master node name: " masterNodeName

echo "To deploy configuration of app, inside master-node run: docker stack deploy -c ~/voteApp.yml APP_catVsDogs"

echo "Move application stack configuration to master node: $masterNodeName"
docker-machine scp docker-compose.yml ${masterNodeName}:~/voteApp.yml
if [ $? -ne 0 ]; then
    echo "Unable upload configuration to nodee: $masterNodeName"
    exit 1
fi
wait

docker-machine ssh $masterNodeName
if [ $? -ne 0 ]; then
    echo "Unable to connect to node: $masterNodeName"
    exit 1
fi

exit 0
