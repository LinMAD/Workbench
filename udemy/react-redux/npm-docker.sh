#!/usr/bin/env bash

NPM_IMG=node:6
DOCKER_RUN="run --rm --interactive --net host --tty --user $(id -u):$(id -g)"

# Execute container with npm command
docker ${DOCKER_RUN} --volume `pwd`:/app --workdir /app --entrypoint npm ${NPM_IMG} "$@"
