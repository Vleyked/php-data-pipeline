FROM ubuntu:22.04

ARG DEBIAN_FRONTEND=noninteractive

# Copy the application code & set the working directory
COPY src /app
WORKDIR /app

# Authenticate with gcloud
ENV GOOGLE_APPLICATION_CREDENTIALS /app/bigquery.json
ENV GOOGLE_CLOUD_PROJECT high-victor-361803

# Install the required packages
# RUN add-apt-repository ppa:ondrej/php

RUN apt-get -y update && apt-get install -y software-properties-common \
    libapache2-mod-php \
    php \
    php-cli \
    zip \
    unzip \
    php-zip \
    php-curl
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer require google/cloud-bigquery
RUN composer require google/apiclient

# Install the packages with composer
RUN composer install

CMD ["php", "insertRows.php"]
