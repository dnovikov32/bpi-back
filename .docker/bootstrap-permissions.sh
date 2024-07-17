#!/bin/bash

set -eo pipefail

create_group() {
    echo "Create group \"docker\" with GID: ${GROUP_ID}"
    groupadd -g "${GROUP_ID}" docker
}

create_user() {
    echo "Create user \"docker\" with UID: ${USER_ID}"
    useradd $(if [ -d "/home/docker" ]; then echo '-M'; else echo '-m'; fi) -u "${USER_ID}" -g "${GROUP_ID}" docker
}

if [ -n "${USER_ID}" ] && [ -n "${GROUP_ID}" ]; then
    echo "Mapping Docker container UID:GID to ${USER_ID}:${GROUP_ID}"

    if getent group "${GROUP_ID}" > /dev/null 2>&1; then
        exists_group_name=$(getent group "${GROUP_ID}" | cut -d: -f1)

        if [[ "${exists_group_name}" != "docker" ]]; then
            echo "GID: ${GROUP_ID} already exists"
            echo "Change GID for ${exists_group_name} group"
            groupmod -g 7898 "${exists_group_name}"
            create_group
        fi
    else
        create_group
    fi

    if getent passwd "${USER_ID}" > /dev/null 2>&1; then
        exists_user_name=$(getent passwd "${USER_ID}" | cut -d: -f1)

        if [[ "${exists_user_name}" != "docker" ]]; then
            echo "UID: ${USER_ID} already exists"
            echo "Change UID for ${exists_user_name} user"
            usermod -u 7898 "${exists_user_name}"
            create_user
        fi
    else
        if getent passwd "${USER_ID}" > /dev/null 2>&1; then
            echo "User already exists"
        else
            echo "No, the user does not exist"
        fi

        create_user
    fi

    echo "Set permissions docker:docker on home dir \"/home/docker\""
    chown -R "${USER_ID}":"${GROUP_ID}" "/home/docker"

    echo "Set permissions docker:docker on default workdir \"/app\""
    chown "${USER_ID}":"${GROUP_ID}" "/app"

    if [ ! -z "${EXTRA_PERMISSIONS}" ]; then
        for dir in ${EXTRA_PERMISSIONS}; do
            mkdir -p "${dir}"
            echo "Set permissions docker:docker on ${dir}"
            chown -R "${USER_ID}":"${GROUP_ID}" "${dir}"
        done
    fi
fi
