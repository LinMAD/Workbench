#!/bin/bash
#
# Tested only on Debian 9 "Stretch"
# These script is extra tool to play with docker machine and swarm, it's not part of course.
# Create nodes in docker-machine for swarm cluster
#
NODE_COUNT=3 # Default value of nodes number
NODE_PREFIX="node"
MASTER_NODE="" # Defines, when createSwarmCluster: Stores first node IP in docker machine
SWARM_JOIN_TOKEN="" # Defines, when createSwarmCluster: Stores token for joining to swarm clusre
USAGE="$(basename "$0") [OPTION] COMMAND -- Automate docker machine cluster creation
OPTION:
    -h  show this help

COMMAND:
    init      - Creates in docker-machine nodes, default (3 nodes), with names (node_1, node_2, node_3 etc.).
    rm        - Removes all create nodes in docker-machine.
    start     - Start all stoped nodes in docker-machine.
    stop      - Stops all nodes in docker-machine.
"

# Arg1 - name of docker machine
function createNode {
  docker-machine create $1
  if [ $? -ne 0 ]; then
      echo "Unable to create node: ($1) in docker machine"
      exit 1
  fi
}

# Arg1 - name of docker machine
function removeNode {
  docker-machine rm -f $1
  if [ $? -ne 0 ]; then
      echo "Unable to remove node: ($1) in docker machine"
      exit 1
  fi
}

# Arg1 - name of docker machine
function startNode {
  docker-machine start $1
  if [ $? -ne 0 ]; then
      echo "Unable to start node: $1"
      exit 1
  fi
}

# Arg1 - name of docker machine
function stopNode {
  docker-machine stop $1
  if [ $? -ne 0 ]; then
      echo "Unable to stop node: $1"
      exit 1
  fi
}

function createSwarmCluster {
  # Start from first node
  local NODE_NAME=${NODE_PREFIX}"-"1
  local TMP_SWARM_INIT_RESP=""

  # Get IP in docker machine of first node
  echo "Inspecting node: $NODE_NAME"
  MASTER_NODE=`docker-machine env "$NODE_NAME" | grep -oE "\b([0-9]{1,3}\.){3}[0-9]{1,3}:[0-9]{1,4}\b"`
  if [ $? -ne 0 ]; then
      echo "Unable to initialize swarm cluster"
      exit 1
  fi

  # Store TOKEN for joining nodes to swarm cluster
  echo "Initialize swarm cluster for $NODE_NAME and advertise-addr $MASTER_NODE"
  SWARM_JOIN_TOKEN=`docker-machine ssh "$NODE_NAME" "docker swarm init --advertise-addr $MASTER_NODE" | grep "docker swarm join --token"`
  if [ $? -ne 0 ]; then
      echo "Unable to initialize swarm cluster"
      exit 1
  fi

  echo "To join remaining nodes will used swarm token:"
  echo $SWARM_JOIN_TOKEN
}

function joinToSwarmCluster {
  # Join nodes only by IP, or will drop with error : rpc error: code = 13
  # Cut port from token
  SWARM_JOIN_TOKEN=`echo $SWARM_JOIN_TOKEN | cut -d: -f-1`

  echo "Docker machine swarm joining: $SWARM_JOIN_TOKEN"
  docker-machine ssh $1 $SWARM_JOIN_TOKEN
  if [ $? -ne 0 ]; then
      echo "Unable to join to swarm cluster"
      exit 1
  fi
}

# Arg1 represents number from nodes will be started for work
# Arg 2 represents command what will happens in Loop
# Create docker machines or remove them, also start\stop it
# For more details Watch swith case in execute block
function dockerMachineDo {
  local NODE_NAME=''

  # Create nodes in loop
  for (( i=$1; i<=$NODE_COUNT; i++ ))
  do
    # Combine name of node
    NODE_NAME=${NODE_PREFIX}"-"${i}
    # Execute command for docker-machine
    $2 ${NODE_NAME}
    wait # Wait for node creaetion, then create next
  done
}

# ------------------------------------------------------------------------------
# Execution process
# ------------------------------------------------------------------------------
while getopts ':hs:' option; do
  case "$option" in
    h) echo $"$USAGE"

       exit 0
       ;;
  esac
done
shift $((OPTIND - 1))

# Check system dependencies
if [[ -z `which virtualbox` ]]; then
 echo "First install virtualbox"

 exit 1
fi

if [[ -z `which docker-machine` ]]; then
 echo "First install docker machine"

 exit 1
fi

#
# Execute and parse commands
#
case "$1" in
  init) echo "Creating docker machine nodes"
        # Create all nodes, node names starts from "1"
        dockerMachineDo 1 createNode
        wait
        # Create init swarm cluster in node 1
        createSwarmCluster
        wait
        # join to swarm other nodes if need
        if [[ $NODE_COUNT > 1  ]]; then
          dockerMachineDo 2 joinToSwarmCluster
        fi
        wait
      ;;
  rm)   echo  "Remove all docker machine nodes"
        dockerMachineDo 1 removeNode
      ;;
  start)   echo  "Starts all docker machine nodes"
        dockerMachineDo 1 startNode
      ;;
  stop) echo  "Stops all docker machine nodes"
        dockerMachineDo 1 stopNode
      ;;
  *)  echo "Unknown command, watch help"
      echo "---------------------------"
      echo $"$USAGE"

      exit 1
      ;;
esac

exit 0
