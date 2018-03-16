help:	## This help.
		@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
.DEFAULT_GOAL := help
.PHONY:	help

tests:	## PHPUnit tests & code coverage
		vendor/bin/simple-phpunit --colors=always --coverage-html coverage
.PHONY: tests

fix:	## PHP CS Fixer
		vendor/bin/php-cs-fixer fix --diff
.PHONY: fix

fix-dry-run:	## PHP CS Fixer
		vendor/bin/php-cs-fixer fix --diff --dry-run
.PHONY: fix-dry-run
