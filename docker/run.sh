#!/bin/bash

if ! docker network ls | grep internal &>/dev/null; then
  docker network create --internal internal
fi
docker run --rm -it --network internal --volume `pwd`/../:/gwf3_src:ro --volume dog_db:/db_data --volume dog_protected:/gwf3_run --publish 6667:6667 gwf3/develop_dog
