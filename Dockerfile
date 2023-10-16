# Use a imagem base desejada
RUN docker exec -it projects_web_1 bash

# Instale as dependências necessárias
RUN apk --no-cache add git

# Clone o repositório do GitHub
RUN git clone https://github.com/GuiCesar12/validator.git

# Defina o diretório de trabalho
WORKDIR /app

# Execute os comandos adicionais
RUN composer install && 
    cp .env.example .env &&
    php artisan key:generate