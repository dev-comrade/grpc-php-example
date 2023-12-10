#!/usr/bin/env bash

### INIT
set -e

### FONTS
NC='\033[0m'
YELLOW='\033[1;33m' #bold
GREEN='\033[1;32m'
RED='\033[0;31m'

function log() {
  if [[ -z $2 ]]; then
    echo -e "${YELLOW}$1${NC}"
  else
    echo -e $1 "${YELLOW}$2${NC}"
  fi;
}

function ok() {
  echo -e "${GREEN}OK${NC}"
}

log "Install composer"
composer update
ok

mkdir -p ./src/proto
protoc --plugin=protoc-gen-grpc=/usr/local/bin/grpc_php_plugin --php_out=./src/proto --grpc_out=generate_server:./src/proto --proto_path=./proto proto/*.proto
log "generate proto src"
ok

if [ $(ps -a | grep php | wc -l) -le 1 ]; then
  log "start GRPC server"
  php server.php &
  ok
fi