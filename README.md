# Company List Laravel Vue

Este projeto foi desenvolvido utilizando **Laravel** para o back-end e **Vue** para desenvolvimento do front-end, possui
uma api para consulta de empresas, cidades e estados e apenas uma tela que exibe empresas e possibilita o filtro por
nome, cidade e estado.

### Como faço para o projeto funcionar em meu computador?

Para facilitar a visualização e reprodução do projeto, utilizei docker, então tenha certeza de que possua ele instalado
em seu sistema

**Dependencias:**

- Docker

### Passo a Passo

Clone o projeto

```
git clone git@github.com:spacedog4/company-list-laravel-vue.git
```

Inicie os container

```
docker-compose up -d
```

Instale as dependencias

```
docker exec api composer install
```

Execute o front-end

```
sail npm run dev
```

Prontinho, você pode acessar o sistema através do endereço

```
http://localhost
```
