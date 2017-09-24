### While playing with swarm and docker you can use some ``"tools" scripts``

#### ``install_vbox.sh`` -- simply installs in debian 9 virtual box to play with swarm and docker-machine
#### ``swarm_toolset.sh`` ''Used to controll swarm clustre state with docker-machine''

````
# Help output of warm_toolset.sh [OPTION] COMMAND -- Automate docker machine cluster creation
OPTION:
    -h  show this help

COMMAND:
    init      - Creates in docker-machine nodes, default (3 nodes), with names (node_1, node_2, node_3 etc.).
    rm        - Removes all create nodes in docker-machine.
    start     - Start all stoped nodes in docker-machine.
    stop      - Stops all nodes in docker-machine.
````
