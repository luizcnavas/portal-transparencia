# 🚀 AÇÃO NECESSÁRIA NO KOYEB - Atualizar Start Command

## ✅ Mudanças já enviadas para o GitHub

As correções foram feitas e enviadas! Agora você precisa atualizar o **Start Command** no Koyeb para as imagens funcionarem.

## 📝 O que fazer agora:

### 1. Acesse o Koyeb

Vá para: https://app.koyeb.com

### 2. Selecione seu aplicativo

Clique no seu projeto do Portal de Transparência

### 3. Vá em Settings (Configurações)

No menu lateral, clique em **Settings** ou **Configurações**

### 4. Edite o Start Command

Procure por **Build and deployment settings** ou **Configurações de build**

**Substitua o Start Command atual por:**

```bash
php artisan migrate --force && php artisan db:seed --force && php -S 0.0.0.0:8000 server.php
```

**⚠️ IMPORTANTE:** A mudança principal é trocar `-t public` por `server.php` no final!

### 5. Salve as mudanças

Clique em **Save** ou **Salvar**

### 6. Faça Redeploy

O Koyeb deve fazer deploy automático, mas se não:
- Clique em **Redeploy** ou **Deploy**
- Aguarde o build completar (2-5 minutos)

### 7. Teste seu site

Acesse: `https://seu-app.koyeb.app`

Verifique se:
- ✅ Logo aparece no topo
- ✅ Botões com imagens aparecem
- ✅ CSS está aplicado corretamente
- ✅ Login funciona

## 🎯 Antes e Depois

### ❌ Comando ANTIGO (não funciona imagens):
```bash
php -S 0.0.0.0:8000 -t public
```

### ✅ Comando NOVO (funciona tudo):
```bash
php -S 0.0.0.0:8000 server.php
```

## 💡 Por que isso funciona?

O arquivo `server.php` que criamos atua como um "roteador inteligente":

1. Quando recebe uma requisição para **imagem/CSS/JS**: serve o arquivo diretamente
2. Quando recebe uma requisição **Laravel** (rotas): passa para o framework

O servidor PHP simples com `-t public` não fazia essa distinção corretamente.

## 🐛 Se ainda não funcionar:

1. **Verifique os logs no Koyeb:**
   - Vá em "Logs" no painel
   - Procure por erros

2. **Verifique as variáveis de ambiente:**
   - `APP_URL` deve estar com HTTPS
   - `SESSION_SECURE_COOKIE=true`

3. **Force um redeploy limpo:**
   - Delete o app e crie novamente
   - Ou limpe o cache do Koyeb

## ✅ Checklist Final

- [ ] GitHub atualizado (✅ já feito!)
- [ ] Start Command atualizado no Koyeb
- [ ] Redeploy feito
- [ ] Site testado - login funciona
- [ ] Site testado - imagens aparecem
- [ ] Site testado - CSS aplicado

---

**Última atualização:** 21/10/2025  
**Status:** ⏳ Aguardando atualização no Koyeb

🎉 **Depois de fazer isso, tudo vai funcionar perfeitamente!**
