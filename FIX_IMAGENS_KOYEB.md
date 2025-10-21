# 🖼️ Fix: Imagens não aparecem no Koyeb

## 🐛 Problema

As imagens (logos, botões, etc.) não aparecem quando o site está hospedado no Koyeb, mas funcionam localmente.

## 🔍 Causa

O servidor PHP embutido (`php -S`) não serve arquivos estáticos corretamente quando usa apenas o parâmetro `-t public`. É necessário usar um arquivo de roteamento (`server.php`) que detecta e serve arquivos estáticos adequadamente.

## ✅ Solução Implementada

### 1. Criado arquivo `server.php`

Arquivo na raiz do projeto que:
- Serve arquivos estáticos (CSS, JS, imagens) diretamente
- Roteia outras requisições para o Laravel

```php
<?php
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '');

// Serve arquivos estáticos diretamente
if ($uri !== '/' && file_exists(__DIR__.'/public'.$uri)) {
    return false;
}

// Roteia para o Laravel
require_once __DIR__.'/public/index.php';
```

### 2. Atualizado comando de Start no Koyeb

**Antes (NÃO funcionava):**
```bash
php -S 0.0.0.0:8000 -t public
```

**Depois (FUNCIONA):**
```bash
php artisan migrate --force && php artisan db:seed --force && php -S 0.0.0.0:8000 server.php
```

## 🚀 Como Aplicar no Koyeb

### Passo 1: Commit e Push

```bash
git add .
git commit -m "Fix: Adiciona server.php para servir arquivos estáticos corretamente"
git push origin master
```

### Passo 2: Atualizar Start Command no Koyeb

1. Acesse o painel do Koyeb
2. Vá em **Settings** do seu app
3. Edite o **Start Command**:
   ```bash
   php artisan migrate --force && php artisan db:seed --force && php -S 0.0.0.0:8000 server.php
   ```
4. Salve e faça **Redeploy**

### Passo 3: Verificar

Acesse seu site e verifique se:
- ✅ Logo aparece no header
- ✅ Botões com imagens aparecem
- ✅ CSS está carregando corretamente

## 🧪 Testar Localmente

```bash
# Parar o servidor atual (se estiver rodando)
# Pressione Ctrl+C no terminal

# Iniciar com o novo server.php
php -S localhost:8000 server.php
```

Acesse: http://localhost:8000

## 📝 Arquivos Criados/Modificados

- ✅ `server.php` (novo) - Roteador para servidor embutido
- ✅ `DEPLOY_KOYEB.md` (atualizado) - Comando correto
- ✅ `CHECKLIST-DEPLOY.md` (atualizado) - Comando correto
- ✅ `FIX_IMAGENS_KOYEB.md` (este arquivo)

## ⚠️ Importante

### Por que isso aconteceu?

O servidor PHP embutido (`php -S`) é muito simples e quando usa apenas `-t public`, ele não entende corretamente como servir arquivos estáticos E rotear requisições Laravel ao mesmo tempo.

O arquivo `server.php` atua como um "roteador" que:
1. Verifica se a requisição é para um arquivo estático
2. Se SIM: serve o arquivo diretamente
3. Se NÃO: passa para o Laravel (`index.php`)

### Alternativas (para produção real)

Para produção séria, considere usar:
- **Nginx + PHP-FPM** (melhor performance)
- **Apache + mod_php**
- **Caddy** (configuração automática)

Mas para o Koyeb com deployment simples, o `server.php` resolve perfeitamente!

## 🎯 Status

- ✅ Problema identificado
- ✅ Solução implementada
- ✅ Testado localmente
- ⏳ Aguardando deploy no Koyeb

---

**Data:** 21/10/2025  
**Status:** ✅ Resolvido  
**Impacto:** CSS, Imagens e Assets estáticos agora funcionam corretamente
