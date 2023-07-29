.SILENT:

default: build

install:
	yarn install

dev:
	yarn dev
	./ssg build

preview:
	yarn preview
	./ssg build

build:
	yarn build
	./ssg build

prod:
	yarn prod
	./ssg build

format:
	vendor/bin/phpcbf
