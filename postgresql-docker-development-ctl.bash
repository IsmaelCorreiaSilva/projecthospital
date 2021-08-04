#!/usr/bin/env bash

# SCRIPT_INIT_START: DIR RESOLUTION ###
    SCRIPT_SRC="${BASH_SOURCE[0]}"
    # resolve $SCRIPT_SRC until the file is no longer a symlink
    while [ -h "$SCRIPT_SRC" ]; do 
        SCRIPT_RES_DIR="$( cd -P "$( dirname "$SCRIPT_SRC" )" >/dev/null 2>&1 && pwd )"
        # if $SCRIPT_SRC was a relative symlink,
        # we need to resolve it relative to the path where the symlink file was located
        SCRIPT_SRC="$(readlink "$SCRIPT_SRC")"
        [[ $SCRIPT_SRC != /* ]] && SCRIPT_SRC="$SCRIPT_RES_DIR/$SCRIPT_SRC"
    done
    SCRIPT_RES_DIR="$( cd -P "$( dirname "$SCRIPT_SRC" )" >/dev/null 2>&1 && pwd )"
    cd "${SCRIPT_RES_DIR}" || exit;
# SCRIPT_INIT_END: DIR RESOLUTION ###




CONST_CMD="podman"
CONST_CONTAINER_IMAGE_NAME="desafiodb-postgres"
CONST_CONTAINER_NAME="desafiodb-postgres-dev"
CONST_CONTAINER_PORT="5433";

function fn_check_for_compose_cmd() {

    if ! command -v "${CONST_CMD}" &> /dev/null
    then
        CONST_CMD="docker"
    fi

    if test "${USE_DOCKER}" = 'true'
    then
        echo "Using docker-compose";
        CONST_CMD="docker";
    fi
}

function fn_get_postgre_pass() {
    
    stty -echo  # Disable keyboard echoing
    printf "PG password: "
    read ENV_PG_PASS # Get password.
    stty echo # Enable keyboard echoing
    printf "\n"

    # Export password via enviroment for LESS insecure stack deployment.
    export POSTGRES_PASSWORD="$ENV_PG_PASS";
}

function fn_remove_image(){
    "$CONST_CMD" rmi "$CONST_CONTAINER_IMAGE_NAME";
}

function fn_remove_container(){
    "$CONST_CMD" stop "$CONST_CONTAINER_NAME";
    "$CONST_CMD" rm "$CONST_CONTAINER_NAME";
}

function fn_build_database_server_image() {
	"$CONST_CMD" build -t "$CONST_CONTAINER_IMAGE_NAME" ./database/
}

function fn_create_database_server() {
    fn_get_postgre_pass;
	fn_build_database_server_image;
	"$CONST_CMD" run -d -p "$CONST_CONTAINER_PORT:5432" --env POSTGRES_PASSWORD --name "$CONST_CONTAINER_NAME" "$CONST_CONTAINER_IMAGE_NAME"
}

function fn_run_database_server(){
    "$CONST_CMD" start "$CONST_CONTAINER_NAME";
}

CONST_SUBCMD_CREATE_CONTAINER="create";
CONST_SUBCMD_RUN_CONTAINER="start";
CONST_SUBCMD_BUILD_CONTAINER="build";
CONST_SUBCMD_RM_IMAGE="remove-image";
CONST_SUBCMD_RM_CONTAINER="remove-container"

function start_script() {
	
    fn_check_for_compose_cmd;

    case $1 in
		"${CONST_SUBCMD_CREATE_CONTAINER}")
		fn_create_database_server;
		;;
		"${CONST_SUBCMD_RUN_CONTAINER}")
		fn_run_database_server;
		;;
       	"${CONST_SUBCMD_BUILD_CONTAINER}")
		fn_build_database_server_image;
		;;
       	"${CONST_SUBCMD_RM_IMAGE}")
		fn_remove_image;
		;;
        "${CONST_SUBCMD_RM_CONTAINER}")
		fn_remove_container;
		;;
	*)
	echo $"Usage: $0 {${CONST_SUBCMD_CREATE_CONTAINER}|${CONST_SUBCMD_RUN_CONTAINER}|${CONST_SUBCMD_RM_IMAGE}|${CONST_SUBCMD_RM_CONTAINER}}"
	exit 1
	esac
}

start_script "$@";
