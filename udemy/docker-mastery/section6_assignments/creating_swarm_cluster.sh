#!/bin/bash
#
# Tested only on Debian 9 "Stretch"
# These script is extra tool to play with docker machine and swarm, it's not part of course.
# Create 3 nodes in docker-machine for swarm cluster
#
NODE_COUNT=3 # Default value of nodes number
NODE_PREFIX="node"
USAGE="$(basename "$0") [OPTION] COMMAND -- Automate docker machine cluster creation
OPTION:
    -h  show this help

COMMAND:
    init      - Creates in docker-machine nodes, default (3 nodes), with names (node_1, node_2, node_3 etc.).
    rm        - Removes all create nodes in docker-machine.
    up        - Start all stoped nodes in docker-machine.
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

# Arg 1 represents command what will happens in Loop
# Create docker machines or remove them, also start\stop it
# For more details Watch swith case in execute block
function dockerMachineDo {
  local NODE_NAME=''

  # Create nodes in loop
  for (( i=1; i<=$NODE_COUNT; i++ ))
  do
    # Combine name of node
    NODE_NAME=${NODE_PREFIX}"-"${i}
    # Execute command for docker-machine
    $1 ${NODE_NAME}
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
        dockerMachineDo createNode
      ;;
  rm)   echo  "Remove all docker machine nodes"
        dockerMachineDo removeNode
      ;;
  up)   echo  "Starts all docker machine nodes"
        dockerMachineDo startNode
      ;;
  stop) echo  "Stops all docker machine nodes"
        dockerMachineDo stopNode
      ;;
  *)  echo "Unknown command, watch help"
      echo "---------------------------"
      echo $"$USAGE"

      exit 1
      ;;
esac

exit 0
