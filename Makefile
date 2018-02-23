help:	## This help.
		@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.DEFAULT_GOAL := help
.PHONY:	help

tests:	## PHPUnit tests & code coverage
		vendor/bin/phpunit --coverage-html coverage
.PHONY: tests

fix:	## PHP CS Fixer
		vendor/bin/php-cs-fixer fix --dry-run --diff
.PHONY: fix
