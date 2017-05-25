FROM saleschamp/php

ARG COMPOSER_AUTH

WORKDIR /srv/

COPY . /srv/
RUN composer install --prefer-dist -o -n --no-progress \
  # Run tests to see that we didn't break things, then remove them as
  # they are not necessary in production
  && composer tester && rm -r tests \
  # Nuke the dev dependencies
  && composer install --prefer-dist --no-dev -o -n --no-progress

CMD ["php-fpm"]
