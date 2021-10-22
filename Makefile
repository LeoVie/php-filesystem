build_phpstan_image:
	cd docker && docker build . -f phpstan.Dockerfile -t php-filesystem/phpstan:latest && cd -

phpstan:
	docker run -v ${PWD}:/app --rm php-filesystem/phpstan:latest analyse -c /app/build/config/phpstan.neon

phpunit:
	composer phpunit

test: phpstan
	composer testall
