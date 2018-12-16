CURRENT_DIRECTORY := $(shell pwd)

test:
	echo 'Test réussi, make fonctionne correctement'

start:
	php bin/console server:run

stop:
	php bin/console server:stop

db:
	psql -h 0.0.0.0 -U postgres fictio
