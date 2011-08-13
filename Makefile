SOURCES = index.php app.php controllers/*.php lib/helpers.php
OPTION ?= --dry-run

all: phpcs

phpcs:
	phpcs $(SOURCES)
    


# vim: set tabstop=4 shiftwidth=4 noexpandtab:
