### Copy yml file to deploy stacked application
```
docker-machine scp docker-compose.yml <masterNodeName>:~/app.yml
```
Then connect to master node and run command to deploy
```
docker stack deploy -c ~/app.yml <service_stack_name>
```
### Short TIP
```
# Shows all services stacks
docker service ls

# Shows where containers running in cluster
docker service ps <service_stack_name>
```
