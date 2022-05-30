db-drop:
	bin/console doctrine:database:drop --force

db-create:
	bin/console doctrine:database:create

db-init:
	bin/console doctrine:schema:create
	bin/console doctrine:fixtures:load -n

db-reset:
	make --no-print-directory db-drop
	make --no-print-directory db-create
	make --no-print-directory db-init

#mq-purge:
#	rabbitmqctl list_queues | awk '{ if ($2 > 0) {print $1} }' | xargs -L1 rabbitmqctl purge_queue