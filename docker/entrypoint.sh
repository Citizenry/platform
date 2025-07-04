#!/bin/bash
set -e

# Source utilities
. /utils.sh

# Run the initialization from run.run.sh
copy_external_config
touch_logs

# Dump lumen disk logs if something fails
trap dump_logs EXIT

run_composer_install --no-dev --no-scripts
run_composer dumpautoload
provision_passport_keys
set_storage_permissions

# Not all setups require containers handling migrations (i.e. multisite)
if [ "${DB_MIGRATIONS_HANDLED}" == "true" ]; then
# Not all containers may need to run migrations
if [ "${RUN_PLATFORM_MIGRATIONS}" == "true" ]; then
	run_migrations
else
	echo 'Waiting for database migrations to be done'
	while check_migrations_pending; do
		echo -n '.'
		sleep 5
	done
	echo
fi
fi

# Show logs so far, untrap exit
trap - EXIT
dump_logs

# Mark bootstrap complete
bootstrap_done

# Substitute environment variables in nginx config
envsubst '${HTTP_PORT}' < /etc/nginx/http.d/default.conf > /tmp/nginx.conf
mv /tmp/nginx.conf /etc/nginx/http.d/default.conf

# Create supervisor log directory
mkdir -p /var/log/supervisor

# Execute the command passed to the container
exec "$@"