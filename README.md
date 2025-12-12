# CRUD de Pessoas – Laravel + Vue.js + Docker

Sistema CRUD de Pessoas utilizando:

- **Laravel (API)**
- **Vue 3 + Vite (Frontend)**
- **PostgreSQL (Docker)**
- **TailwindCSS**

---

## Pré-requisitos

Antes de iniciar, você precisa ter instalado:

- Docker + Docker Compose  
- PHP 8.2+  
- Composer  
- Node.js 18+ e NPM  

---

## 1. Subir o Banco de Dados (PostgreSQL via Docker)

O repositório contém um arquivo `docker-compose.yml` com a configuração do PostgreSQL.

Para iniciar o banco:

```bash
cd server
docker compose up -d
```

Isso iniciará o PostgreSQL com:
* Host: 127.0.0.1
* Porta: 5432
* Usuário: laravel
* Senha: laravel
* banco: laravel

Para parar:

```bash
docker compose down
```

---

## 2. Rodar a API (Laravel)

Acesse a pasta "server":

```bash
cd server
```

Instale as dependências:

```bash
composer install
```

Configure o arquivo .env:

```
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=laravel
DB_PASSWORD=laravel
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Execute as migrations:

```bash
php artisan migrate
```

Inicie o servidor Laravel:

```bash
php artisan serve
```

A API ficará disponível em:

```
http://localhost:8000
```

---

## 3. Rodar o Frontend (Vue.js + Vite)

Acesse a pasta "web":

```bash
cd web
```

Instale as dependências:

```bash
npm install
```

Execute o ambiente de desenvolvimento:

```bash
npm run dev
```

A aplicação inciará normalmente em:

```
http://localhost:5173
```

---

## 4. Usuários

Para criar o primeiro usuário no sistema, rode o comando:

```bash
php artisan user:create
```

E preencha os parâmetros solicitados.

Para criar novos usuários, pode-se reutilizar o comando, ou fazê-lo via API.

Para criar via API, realize o login com um usuário existente no endpoint:

* **POST /api/login**

E utilize os endpoints:

* **POST /api/users** - Cria usuário
* **PUT /api/users/{id}** - Atualiza usuário

Não é possível criar ou alterar usuários via web.