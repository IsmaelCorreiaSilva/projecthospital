#!/bin/bash

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

#### SCRIPT START ####

# Defaults to podman-compose
CONST_COMPOSE_CMD="podman-compose"

CONST_PROJ_NAME="projetohospital"
CONST_STACK_STRGE="projetohospital-storage"

ENV_PG_PASS="";
ENV_POSTGRESQL_DATA_DIR="${SCRIPT_RES_DIR}/${CONST_STACK_STRGE}/projetohospital-data";

export ENV_POSTGRESQL_DATA_DIR="${ENV_POSTGRESQL_DATA_DIR}";


function fn_build_stack() {
    fn_build_setup;
    $CONST_COMPOSE_CMD -p ${CONST_PROJ_NAME} build;
}

function fn_build_and_run_stack() {
    fn_build_setup;
    $CONST_COMPOSE_CMD -p ${CONST_PROJ_NAME} up
}

function fn_run_stack(){
    $CONST_COMPOSE_CMD -p ${CONST_PROJ_NAME} run
}

function fn_destroy_stack_and_remove_data() {
    fn_destroy_stack;
    fn_remove_data;
}

function fn_destroy_stack() {
    $CONST_COMPOSE_CMD -p ${CONST_PROJ_NAME} down
}

function fn_build_setup() {
    fn_setup_dirs;
    fn_get_postgre_pass;
}

function fn_setup_dirs() {
    fn_mkdir_if_not_exist $ENV_POSTGRESQL_DATA_DIR
}

function fn_mkdir_if_not_exist(){
    [[ -d "${1}" ]] || mkdir -p "${1}";
}

function fn_get_postgre_pass() {
    
    stty -echo  # Disable keyboard echoing
    printf "PG password: "
    read -r ENV_PG_PASS # Get password.
    stty echo # Enable keyboard echoing
    printf "\n"

    # Export password via enviroment for LESS insecure stack deployment.
    
    export ENV_PG_PASS="$ENV_PG_PASS";
}

function fn_help() {
    echo 
}

function fn_check_for_compose_cmd() {

    if ! command -v "${CONST_COMPOSE_CMD}" &> /dev/null
    then
        CONST_COMPOSE_CMD="docker-compose"
    fi

    if test "${USE_DOCKER_COMPOSE}" = 'true'
    then
        echo "Using docker-compose";
        CONST_COMPOSE_CMD="docker-compose";
    fi
}


CONST_SUBCMD_FN_BUILD_STACK="build";
CONST_SUBCMD_FN_BUILD_RUN_STACK="up";
CONST_SUBCMD_FN_RUN_STACK="run";
CONST_SUBCMD_FN_RM_STACK="down";
CONST_SUBCMD_FN_RM_STACK_DATA="down-remove-data"

function start_script() {
	
    fn_check_for_compose_cmd;

    case $1 in
		"${CONST_SUBCMD_FN_BUILD_STACK}")
		fn_build_stack;
		;;
		"${CONST_SUBCMD_FN_BUILD_RUN_STACK}")
		fn_build_and_run_stack;
		;;
        "${CONST_SUBCMD_FN_RUN_STACK}")
		fn_run_stack;
		;;
        "${CONST_SUBCMD_FN_RM_STACK}")
		fn_destroy_stack;
		;;
        "${CONST_SUBCMD_FN_RM_STACK_DATA}")
		fn_destroy_stack_and_remove_data;
		;;
	*)
	echo $"Usage: $0 {${CONST_SUBCMD_FN_BUILD_STACK}|${CONST_SUBCMD_FN_BUILD_RUN_STACK}|${CONST_SUBCMD_FN_RM_STACK}|${CONST_SUBCMD_FN_RM_STACK_DATA}}"
	exit 1
	esac
}

start_script "$@";
