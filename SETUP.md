# Configuração do Portal de Transparência

## Problema: "Credenciais inválidas" no login

Se você está recebendo erro de "credenciais inválidas" ao tentar fazer login, siga estes passos:

## 1. Configurar arquivo .env

Crie um arquivo `.env` na raiz do projeto com o seguinte conteúdo:

```env
APP_NAME="Portal de Transparência"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=pt_BR

APP_MAINTENANCE_DRIVER=file
APP_MAINTENANCE_STORE=database

BCRYPT_ROUNDS=12

ADMIN_EMAIL=admin
ADMIN_PASSWORD=admin

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database
CACHE_PREFIX=

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

VITE_APP_NAME="${APP_NAME}"
```

## 2. Gerar chave da aplicação

Execute no terminal:

```bash
php artisan key:generate
```

## 3. Executar migrações e seeders

```bash
php artisan migrate
php artisan db:seed
```

## 4. Credenciais de login

As credenciais de login são configuradas através das variáveis de ambiente `ADMIN_EMAIL` e `ADMIN_PASSWORD` no arquivo `.env`.

Por padrão (conforme `.env` acima):
- **Email/Login:** admin
- **Senha:** admin

Se desejar alterar as credenciais, edite o arquivo `.env` e altere as variáveis `ADMIN_EMAIL` e `ADMIN_PASSWORD`.

## 5. Verificar se o banco de dados foi criado

O arquivo `database/database.sqlite` deve existir. Se não existir, crie-o:

```bash
touch database/database.sqlite
```

## 6. Executar o servidor

```bash
php artisan serve
```

Acesse: http://localhost:8000

## Estrutura de Autenticação

O sistema de autenticação está configurado em:

- **Controller:** `app/Http/Controllers/AuthController.php`
- **Modelo:** `app/Models/User.php`
- **Configuração:** `config/auth.php`
- **Rotas:** `routes/web.php`
- **Seeder:** `database/seeders/DatabaseSeeder.php`

## Sistema de Permissões

### Administrador Principal

O usuário definido nas variáveis `ADMIN_EMAIL` e `ADMIN_PASSWORD` no arquivo `.env` é considerado o **Administrador Principal** do sistema e possui permissões exclusivas.

**Permissões exclusivas do Admin Principal:**
- ✅ Criar e editar credenciais de login de outros usuários na seção "Pessoal"
- ✅ Gerenciar todos os aspectos do sistema administrativo

**Importante:** 
- Outros usuários autenticados podem editar conteúdo (documentos, notícias, financeiro, etc.), mas **não podem criar ou modificar credenciais de login** de outros usuários.
- O sistema identifica o admin principal pelo **email configurado no .env**, não pelo ID no banco de dados, tornando-o portável entre diferentes ambientes.

**Como funciona:**
1. O primeiro usuário criado via seeder usa `ADMIN_EMAIL` e `ADMIN_PASSWORD` do `.env`
2. Este usuário pode criar outros usuários com login ao adicionar pessoas no menu "Pessoal"
3. Apenas o email que corresponde ao `ADMIN_EMAIL` verá os campos de login ao criar/editar pessoas
4. Usuários secundários podem fazer login e editar conteúdo, mas não gerenciar outros usuários


## Troubleshooting

Se ainda estiver com problemas:

1. Verifique se o arquivo `.env` foi criado corretamente
2. Execute `php artisan config:clear` para limpar cache de configuração
3. Verifique se o banco de dados SQLite existe e tem permissões de escrita
4. Execute `php artisan migrate:fresh --seed` para recriar o banco do zero

### Problema: Login não funciona em produção (Koyeb/Heroku/etc)

Se o login funciona localmente mas não em produção:

1. **Configure as variáveis de ambiente de sessão:**
   ```
   SESSION_SECURE_COOKIE=true
   SESSION_DRIVER=database
   APP_URL=https://seu-dominio.com
   ```

2. **Verifique se o TrustProxies está configurado**
   - O middleware já está incluído no projeto

3. **Execute o script de verificação:**
   ```bash
   php check-env.php
   ```
