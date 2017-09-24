#!/bin/bash
#
# Virtual box instalation tested only on Debian 9 "Stretch"
# These script is extra tool to play with docker machine and swarm, it's not part of course.
#
# Add virtualbox repo

# Init - setups virtual box source list and key
function init {
  local SRC_LIST="/etc/apt/sources.list.d/virtualbox.list"

  echo "deb http://download.virtualbox.org/virtualbox/debian stretch contrib" >> ${SRC_LIST}

  if [[ `cat ${SRC_LIST} | grep "deb"` ]]; then
    wget -q https://www.virtualbox.org/download/oracle_vbox_2016.asc -O- | apt-key add -
    else
      echo "Unable to find source repo in the new source list. It's created? Script runned from root or sudo?"
      exit 1;
  fi
}

# Main - simple install's virtualbox-5
function main {
  apt update && apt install virtualbox-5.1 -y
}

# ------------------------------------------------------------------------------
# Execution process
# ------------------------------------------------------------------------------

init
if [ $? -ne 0 ]; then
    echo "Init fails"
fi

main
if [ $? -ne 0 ]; then
    echo "Failed to install packages of virtualbox"
fi

exit 0;
