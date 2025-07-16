init:
	docker exec symfony_app php /var/www/html/app/bin/console doctrine:database:create --if-not-exists
	docker exec symfony_app php /var/www/html/app/bin/console doctrine:migrations:migrate --no-interaction
	docker exec symfony_app php /var/www/html/app/bin/console doctrine:fixtures:load --no-interaction

dev:
	docker-compose -f docker-compose.yml -f docker-compose.override.dev.yml up -d --build
	docker exec symfony_app chmod 700 /root/.ssh
	docker exec symfony_app chmod 600 /root/.ssh/id_ed25519
	docker exec symfony_app chmod 644 /root/.ssh/id_ed25519.pub
	docker exec symfony_app chmod 644 /root/.ssh/known_hosts
	make gitconfig
	make ssh
perf:
	docker-compose -f docker-compose.yml -f docker-compose.override.perf.yml up -d --build

sync:
	docker cp . symfony_app:/var/www/html

stop:
	docker-compose down -v

ssh:
	docker exec -it symfony_app bash

serve:
	docker exec -it symfony_app bash -c "php -S 0.0.0.0:8000 -t public"
gitconfig:
	docker exec symfony_app git config --global user.email "philippeglessmer@gmail.com"
	docker exec symfony_app git config --global user.name "Philippe GLESSMER"
