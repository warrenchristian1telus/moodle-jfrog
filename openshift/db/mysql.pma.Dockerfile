FROM phpmyadmin/phpmyadmin

ARG PMA_PERSISTENT_STORAGE_PATH
ENV pma_persistent_storage_path=$PMA_PERSISTENT_STORAGE_PATH

EXPOSE 8080

RUN apt-get update -y
RUN apt-get upgrade -y --fix-missing
RUN apt-get dist-upgrade -y
RUN dpkg --configure -a
RUN apt-get -f install
RUN apt-get install -y ssh-client
RUN apt autoremove -y

# set recommended PHP.ini settings
# see https://secure.php.net/manual/en/opcache.installation.php
RUN { \
    echo 'memory_limit=1024M'; \
    echo 'output_buffering=Off'; \
    echo 'upload_max_filesize=1G'; \
    echo 'post_max_size=1G'; \
    echo 'max_input_time=3000'; \
    echo 'max_execution_time=3000'; \
    echo 'max_input_vars=30000'; \
  } > /usr/local/etc/php/php.ini-production

COPY app/config/sync/apache2.pma.conf /etc/apache2/apache2.conf
COPY app/config/sync/ports.conf /etc/apache2/ports.conf

RUN service apache2 restart

USER root

# create backup folders (persistent storage)
RUN mkdir -p ${pma_persistent_storage_path}
RUN chown -R www-data:www-data ${pma_persistent_storage_path}
#RUN mkdir -p ${pma_persistent_storage_path}/uploads
#RUN chown -R www-data:www-data ${pma_persistent_storage_path}/uploads

RUN mkdir -p ${pma_persistent_storage_path}/saved
#RUN chmod 755 ${pma_persistent_storage_path}/saved
#RUN chgrp -R 0 ${pma_persistent_storage_path}/saved
#RUN chmod -R g=u ${pma_persistent_storage_path}/saved

RUN chgrp -R 0 ${pma_persistent_storage_path}/saved && \
    chmod -R g=u ${pma_persistent_storage_path}/saved && \
    chown -R www-data:www-data ${pma_persistent_storage_path}/saved

# Temp folder
RUN mkdir -p /var/www/html/tmp/
RUN chown -R www-data:www-data /var/www/html/tmp/
RUN chmod 700 /var/www/html/tmp/

#RUN mkdir -p ${pma_persistent_storage_path}/tmp
#RUN chown -R www-data:www-data ${pma_persistent_storage_path}/tmp
#RUN chmod 700 ${pma_persistent_storage_path}/tmp

# configure pma
COPY openshift/app/configs/phpmyadmin-config.inc.php /etc/phpmyadmin/config.inc.php
COPY openshift/app/configs/phpmyadmin-config.secret.inc.php /etc/phpmyadmin/config.secret.inc.php
RUN chmod 644 /etc/phpmyadmin/*
RUN chown -R www-data:www-data /etc/phpmyadmin/config.inc.php
RUN chown -R www-data:www-data /etc/phpmyadmin/config.secret.inc.php

COPY ./openshift/app/configs/phpmyadmin-config.inc.php /var/www/html/config.inc.php

RUN chown -R www-data:www-data /var/www/html/config.inc.php
