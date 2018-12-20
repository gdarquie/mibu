CURRENT_DIRECTORY := $(shell pwd)

test:
	echo 'Test réussi, make fonctionne correctement'

start:
	php bin/console server:run

stop:
	php bin/console server:stop

db:
#	psql -h 0.0.0.0 -U postgres fictio
	docker-compose exec db bash
#	psql -U postgres

#api:
#	docker-compose exec api bash

db-test:
	psql -h 0.0.0.0 -U postgres fictio_test

#installer localement cs
cs:
	php-cs-fixer fix src --verbose --diff  --rules=@Symfony,object_operator_without_whitespace,-yoda_style $(CS_OPTION) || true

#php bin/console doctrine:database:create --env test
