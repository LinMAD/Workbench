### Copy yml file to deploy stacked application
Where <masterNodeName> set master node name
``
docker-machine scp docker-compose.yml <masterNodeName>:~/app.yml
``
Then connect to master node and run command to deploy
``
docker stack deploy -c ~/app.yml StackedApp
``
### Short TIP
``
docker service ls // Shows all services stacks
docker service ps <service_name> // Shows where containers running in cluster
``
