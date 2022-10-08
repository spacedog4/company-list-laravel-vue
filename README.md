# Company List Laravel Vue

Este projeto foi desenvolvido utilizando **Laravel** para o back-end e **Vue** para desenvolvimento do front-end, possui
uma api para consulta de empresas, cidades e estados e apenas uma tela que exibe empresas e possibilita o filtro por
nome, cidade e estado.

### Como faço para o projeto funcionar em meu computador?

Para facilitar a visualização e reprodução do projeto, utilizei docker, então tenha certeza de que possua ele instalado
em seu sistema

**Dependencias:**

- Docker
- WSL

### Passo a Passo

Clone o projeto
```
git clone git@github.com:spacedog4/company-list-laravel-vue.git
```

Copie o arquivo de variáveis de ambiente (não se preocupe que ele já está configurado)
```
cp .env.example .env
```

Execute o comando a baixo para instalar suas dependencias (precisamos para conseguir usar os comandos do sail)
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/opt \
    -w /opt \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

Inicialize a API
```
sail up -d
```

Crie a base de dados e também alimente ela com algumas informações
```
sail artisan migrate --seed
```

Execute o front-end
```
sail npm install && npm run build
```

Prontinho, você pode acessar o sistema através do endereço
```
http://localhost
```

Você pode rodar os testes unitários atraves do comando abaixo
```
sail artisan test
```
