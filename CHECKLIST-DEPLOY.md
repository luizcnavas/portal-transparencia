# ✅ Checklist de Deploy - Portal de Transparência

Use este checklist para garantir que tudo está configurado corretamente.

## 📦 Parte 1: Código (GitHub)

- [ ] Puxar as últimas mudanças: `git pull origin master`
- [ ] Verificar se o arquivo `app/Http/Middleware/TrustProxies.php` existe
- [ ] Verificar se `bootstrap/app.php` contém `trustProxies`
- [ ] Commit das mudanças (se necessário)
- [ ] Push para o GitHub: `git push origin master`

## ⚙️ Parte 2: Configuração no Koyeb

### Variáveis de Ambiente Essenciais

- [ ] `APP_NAME` = "Portal de Transparência"
- [ ] `APP_ENV` = production
- [ ] `APP_KEY` = (sua chave gerada)
- [ ] `APP_DEBUG` = false
- [ ] `APP_URL` = https://seu-app.koyeb.app

### Variáveis de Sessão (CRÍTICAS para login)

- [ ] `SESSION_DRIVER` = database
- [ ] `SESSION_SECURE_COOKIE` = true
- [ ] `SESSION_HTTP_ONLY` = true
- [ ] `SESSION_SAME_SITE` = lax

### Variáveis de Banco de Dados

- [ ] `DB_CONNECTION` = sqlite
- [ ] `DB_DATABASE` = /app/database/database.sqlite

### Outras Variáveis

- [ ] `LOG_CHANNEL` = stack
- [ ] `LOG_LEVEL` = error
- [ ] `CACHE_STORE` = database
- [ ] `QUEUE_CONNECTION` = database

## 🔨 Parte 3: Comandos de Build

### Build Command

```bash
composer install --optimize-autoloader --no-dev && php artisan config:cache && php artisan route:cache && php artisan view:cache
```

- [ ] Build command configurado

### Start Command

```bash
php artisan migrate --force && php artisan db:seed --force && php -S 0.0.0.0:8000 -t public
```

- [ ] Start command configurado

## 🌐 Parte 4: Configurações do Serviço

- [ ] Porta: 8000
- [ ] Health Check Path: /up
- [ ] Região selecionada

## 🚀 Parte 5: Deploy

- [ ] Clicar em "Redeploy" ou aguardar deploy automático
- [ ] Aguardar build completar
- [ ] Verificar logs (não deve ter erros)

## 🧪 Parte 6: Testes

### Teste Básico
- [ ] Acessar: https://seu-app.koyeb.app
- [ ] Página inicial carrega
- [ ] Ver totais no dashboard público

### Teste de Login
- [ ] Acessar: https://seu-app.koyeb.app/login
- [ ] Formulário de login aparece
- [ ] Fazer login com:
  - Email: admin@example.com
  - Senha: password
- [ ] Deve redirecionar para /admin/dashboard
- [ ] Dashboard administrativo carrega
- [ ] Fazer logout
- [ ] Deve redirecionar para página inicial

### Teste de Funcionalidades
- [ ] Criar uma transação
- [ ] Editar uma transação
- [ ] Criar uma notícia
- [ ] Upload de documento
- [ ] Visualizar documento público

## 🐛 Troubleshooting

Se algo não funcionar, verifique:

### 1. Login não funciona

```bash
# Verifique estas variáveis:
SESSION_SECURE_COOKIE=true ✅
APP_URL=https://... ✅
SESSION_DRIVER=database ✅
```

### 2. Erro 500

```bash
# Verifique:
APP_KEY está definida? ✅
APP_DEBUG=false? ✅
Logs no Koyeb? (verifique o painel)
```

### 3. Sessão não persiste

```bash
# Verifique:
SESSION_SECURE_COOKIE=true para HTTPS ✅
TrustProxies middleware ativo? ✅
Migration de sessions rodou? ✅
```

### 4. Banco de dados vazio

```bash
# Verifique:
Start command tem "php artisan migrate --force"? ✅
Start command tem "php artisan db:seed --force"? ✅
```

## 📊 Verificação Local (antes de deploy)

Execute localmente:

```bash
# Verificar configuração
php check-env.php

# Limpar cache
php artisan config:clear
php artisan cache:clear

# Testar localmente
php artisan serve
```

## 📱 URLs Importantes

- 🏠 Home: https://seu-app.koyeb.app
- 🔐 Login: https://seu-app.koyeb.app/login
- 📊 Dashboard Admin: https://seu-app.koyeb.app/admin/dashboard
- 💰 Transações: https://seu-app.koyeb.app/transacoes
- 📄 Documentos: https://seu-app.koyeb.app/documentos
- 📰 Notícias: https://seu-app.koyeb.app/noticias

## ✅ Tudo Funcionando?

Se todos os itens acima estiverem marcados e os testes passaram:

🎉 **PARABÉNS! Seu portal está no ar e funcionando!** 🎉

---

## 📞 Precisa de Ajuda?

1. Verifique os logs no painel do Koyeb
2. Execute `php check-env.php` localmente
3. Consulte `DEPLOY_KOYEB.md` para mais detalhes
4. Revise `FIX_LOGIN_KOYEB.md` para entender as mudanças

---

**Última atualização:** 21/10/2025  
**Versão do Portal:** 1.0.0
