FROM php:8.0

# Install npm
# libzip-dev: for the PHP zip extension (used by Composer)
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash - \
    && apt update && apt install -y git ssh apache2-utils nodejs python3-pip libzip-dev zip && rm -rf /var/lib/apt/lists/*

# Install Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
   && php -r "if (hash_file('sha384', 'composer-setup.php') === '756890a4488ce9024fc62c56153228907f1545c228516cbf63f885e036d37e9a59d27d63f46af1d4d07ee0f76181c7d3') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
   && php composer-setup.php --install-dir=bin --filename=composer \
   && php -r "unlink('composer-setup.php');"

# Install the `aws` CLI tool
RUN pip3 install --upgrade --user awscli && echo 'export PATH=/root/.local/bin:$PATH'>/root/.bashrc

# Install serverless
RUN npm install -g serverless

RUN docker-php-ext-install zip pdo_mysql

RUN mkdir -p /var/task

# Register the Serverless and AWS bin directories
ENV PATH="/root/.serverless/bin:/root/.local/bin:${PATH}"

WORKDIR '/var/task'
