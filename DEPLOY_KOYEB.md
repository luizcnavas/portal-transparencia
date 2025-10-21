# Guia de Deploy no Koyeb - Portal de Transparência

## 🚨 Problema Identificado e Solução

### O que estava acontecendo?

Após mudanças no frontend, o sistema de login parou de funcionar quando hospedado no Koyeb. Isso ocorre porque o Koyeb usa um **proxy reverso** que encaminha as requisições para sua aplicação. Sem a configuração correta, o Laravel não reconhece que está rodando em HTTPS, causando problemas com:

- ❌ Cookies de sessão não funcionam
- ❌ Login não persiste
- ❌ Redirecionamentos incorretos
- ❌ CSRF tokens inválidos

### A solução implementada

Foi adicionado o middleware **TrustProxies** que configura o Laravel para confiar nos headers do proxy do Koyeb. Isso garante que:

- ✅ O Laravel reconheça corretamente requisições HTTPS
- ✅ Cookies de sessão funcionem adequadamente
- ✅ Login funcione em produção
- ✅ Redirecionamentos usem HTTPS corretamente

---

## 📋 Configuração para Deploy no Koyeb

### 1. Variáveis de Ambiente Obrigatórias

Configure as seguintes variáveis de ambiente no painel do Koyeb:

```env
# Básico
APP_NAME="Portal de Transparência"
APP_ENV=production
APP_KEY=base64:SUA_CHAVE_AQUI
APP_DEBUG=false
APP_URL=https://seu-app.koyeb.app

# Importante para produção
APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=en

# Database (SQLite)
DB_CONNECTION=sqlite
DB_DATABASE=/app/database/database.sqlite

# Sessões - CRÍTICO para login funcionar
SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax

# Logs
LOG_CHANNEL=stack
LOG_LEVEL=error

# Cache
CACHE_STORE=database

# Queue
QUEUE_CONNECTION=database

# Filesystem
FILESYSTEM_DISK=local
```

### 2. Gerar APP_KEY

Se você não tem uma `APP_KEY`, gere uma executando localmente:

```bash
php artisan key:generate --show
```

Copie o valor gerado e adicione como variável de ambiente no Koyeb.

### 3. Comandos de Build no Koyeb

Configure os seguintes comandos no Koyeb:

**Build Command:**
```bash
composer install --optimize-autoloader --no-dev && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

**Start Command:**
```bash
php artisan migrate --force && php artisan db:seed --force && php -S 0.0.0.0:8000 -t public
```

### 4. Configurações Importantes

#### Port
- Porta: `8000`

#### Health Check
- Path: `/up`
- Port: `8000`

#### Regions
- Escolha a região mais próxima dos seus usuários

---

## 🔧 Mudanças Implementadas no Código

### 1. Middleware TrustProxies

Criado o arquivo `app/Http/Middleware/TrustProxies.php`:

```php
<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    protected $proxies = '*';

    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
```

### 2. Registro do Middleware

Atualizado `bootstrap/app.php` para registrar o middleware:

```php
->withMiddleware(function (Middleware $middleware): void {
    $middleware->trustProxies(at: '*');
})
```

---

## 🧪 Testando Localmente

Antes de fazer deploy, teste localmente:

```bash
# 1. Instalar dependências
composer install
npm install

# 2. Configurar ambiente
cp .env.example .env
php artisan key:generate

# 3. Configurar banco de dados
php artisan migrate
php artisan db:seed

# 4. Compilar assets
npm run build

# 5. Iniciar servidor
php artisan serve
```

Acesse: http://localhost:8000/login

**Credenciais de teste:**
- Email: `admin@example.com`
- Senha: `password`

---

## 🚀 Processo de Deploy

### Passo a Passo

1. **Commit e Push das mudanças**
   ```bash
   git add .
   git commit -m "Fix: Adiciona TrustProxies para funcionamento em produção (Koyeb)"
   git push origin master
   ```

2. **No Painel do Koyeb**
   - Vá para seu app
   - Configure todas as variáveis de ambiente listadas acima
   - Configure os comandos de build e start
   - Faça o redeploy

3. **Verificação**
   - Acesse `https://seu-app.koyeb.app`
   - Teste o login em `https://seu-app.koyeb.app/login`
   - Verifique se o dashboard carrega após login

---

## 🐛 Troubleshooting

### Login ainda não funciona

1. **Verifique as variáveis de ambiente:**
   ```
   SESSION_SECURE_COOKIE=true
   SESSION_DRIVER=database
   APP_URL=https://seu-dominio.koyeb.app
   ```

2. **Limpe o cache:**
   ```bash
   php artisan config:clear
   php artisan cache:clear
   php artisan route:clear
   php artisan view:clear
   ```

3. **Verifique os logs:**
   - No Koyeb, vá para "Logs" do seu app
   - Procure por erros relacionados a sessão ou autenticação

### Erro de "Session store not found"

Certifique-se de que:
- A migration da tabela `sessions` foi executada
- O comando `php artisan migrate --force` está no start command

### Erro de "No application encryption key"

- Gere uma nova `APP_KEY`
- Configure como variável de ambiente no Koyeb

### Banco de dados não persiste

O SQLite pode não persistir em ambientes containerizados. Considere:
- Usar PostgreSQL fornecido pelo Koyeb
- Configurar um volume persistente

---

## 📝 Notas Importantes

### Sobre Proxies

O Koyeb (e outros serviços como Heroku, Railway, etc.) usam proxies reversos. Por isso:

- ✅ SEMPRE configure `TrustProxies` para produção
- ✅ Use `SESSION_SECURE_COOKIE=true` em HTTPS
- ✅ Configure `APP_URL` com o domínio completo incluindo HTTPS

### Sobre Segurança

Em produção:
- ✅ `APP_DEBUG=false` (nunca deixe true em produção)
- ✅ `APP_ENV=production`
- ✅ Use senhas fortes para usuários admin
- ✅ Mantenha `APP_KEY` secreta

### Sobre Banco de Dados

Para produção séria, considere migrar de SQLite para PostgreSQL:

1. No Koyeb, adicione um PostgreSQL addon
2. Configure as variáveis:
   ```env
   DB_CONNECTION=pgsql
   DB_HOST=seu-host.koyeb.app
   DB_PORT=5432
   DB_DATABASE=seu_database
   DB_USERNAME=seu_usuario
   DB_PASSWORD=sua_senha
   ```

---

## ✅ Checklist de Deploy

Antes de cada deploy, verifique:

- [ ] Todas as variáveis de ambiente estão configuradas
- [ ] `APP_KEY` está definida
- [ ] `APP_DEBUG=false` em produção
- [ ] `SESSION_SECURE_COOKIE=true` para HTTPS
- [ ] Build command inclui cache do Laravel
- [ ] Start command executa migrations
- [ ] TrustProxies middleware está configurado
- [ ] Assets foram compilados (`npm run build`)

---

## 🆘 Suporte

Se continuar com problemas:

1. Verifique os logs no Koyeb
2. Teste localmente primeiro
3. Confirme que todas as variáveis de ambiente estão corretas
4. Verifique se o middleware TrustProxies foi aplicado

---

**Última atualização:** 21/10/2025
**Versão:** 1.0.0
