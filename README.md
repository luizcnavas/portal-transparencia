# Portal de Transparência

Um sistema web desenvolvido em Laravel para gestão de transparência financeira, permitindo o controle de receitas, despesas, documentos e notícias de forma transparente e organizada.

## 📋 Índice

- [Sobre o Projeto](#sobre-o-projeto)
- [Funcionalidades](#funcionalidades)
- [Pré-requisitos](#pré-requisitos)
- [Instalação Passo a Passo](#instalação-passo-a-passo)
- [Configuração](#configuração)
- [Executando o Projeto](#executando-o-projeto)
- [Estrutura do Banco de Dados](#estrutura-do-banco-de-dados)
- [Uso do Sistema](#uso-do-sistema)
- [Troubleshooting](#troubleshooting)
- [Suporte](#suporte)

## 🎯 Sobre o Projeto

O Portal de Transparência é uma aplicação web desenvolvida para facilitar a gestão e visualização de informações financeiras de forma transparente. O sistema permite:

- **Gestão Financeira**: Controle de receitas e despesas
- **Gestão de Documentos**: Upload, visualização e download de documentos
- **Gestão de Notícias**: Publicação e gerenciamento de notícias
- **Dashboard Administrativo**: Painel com estatísticas e totais
- **Interface Responsiva**: Design moderno e adaptável

## ⚡ Funcionalidades

### Para Usuários Públicos
- Visualização de totais financeiros (receitas, despesas e saldo)
- Consulta de transações financeiras
- Visualização e download de documentos
- Leitura de notícias publicadas

### Para Administradores
- Dashboard com estatísticas completas
- CRUD completo de transações financeiras
- CRUD completo de documentos
- CRUD completo de notícias
- Sistema de autenticação seguro

## 🔧 Pré-requisitos

Antes de começar, certifique-se de ter instalado em seu computador:

### Obrigatórios
- **PHP 8.2 ou superior**
- **Composer** (gerenciador de dependências PHP)
- **Node.js 18+ e NPM** (para compilar assets)
- **Git** (para clonar o repositório)

### Opcionais (mas recomendados)
- **Laravel Sail** (ambiente Docker)
- **Editor de código** (VS Code, PhpStorm, etc.)

### Verificando as Instalações

Abra o terminal/prompt de comando e execute:

```bash
# Verificar PHP
php --version

# Verificar Composer
composer --version

# Verificar Node.js
node --version

# Verificar NPM
npm --version

# Verificar Git
git --version
```

## 📥 Instalação Passo a Passo

### Passo 1: Clonar o Repositório

```bash
# Navegue até a pasta onde deseja instalar o projeto
cd "C:\SeuDiretorio"

# Clone o repositório
git clone [URL_DO_REPOSITORIO] portal-transparencia

# Entre na pasta do projeto
cd portal-transparencia
```

### Passo 2: Instalar Dependências PHP

```bash
# Instalar dependências do Composer
composer install
```

### Passo 3: Instalar Dependências JavaScript

```bash
# Instalar dependências do NPM
npm install
```

### Passo 4: Configurar Variáveis de Ambiente

```bash
# Copiar arquivo de configuração
copy .env.example .env

# Gerar chave de aplicação
php artisan key:generate
```

### Passo 5: Configurar Banco de Dados

O projeto usa SQLite por padrão. O arquivo `database/database.sqlite` já deve existir.

```bash
# Executar migrações do banco de dados
php artisan migrate

# (Opcional) Executar seeders para dados de exemplo
php artisan db:seed
```

### Passo 6: Compilar Assets

```bash
# Compilar CSS e JavaScript
npm run build
```

## ⚙️ Configuração

### Configuração do Banco de Dados

O projeto está configurado para usar SQLite por padrão. Se desejar usar MySQL ou PostgreSQL:

1. Edite o arquivo `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=portal_transparencia
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

2. Execute as migrações:
```bash
php artisan migrate
```

### Configuração de Upload de Arquivos

O sistema permite upload de documentos. Certifique-se de que a pasta `storage/app/public` tem permissões de escrita:

```bash
# Criar link simbólico para storage
php artisan storage:link
```

## 🚀 Executando o Projeto

### Método 1: Servidor de Desenvolvimento (Recomendado para testes)

```bash
# Iniciar servidor Laravel
php artisan serve

# Em outro terminal, compilar assets em modo desenvolvimento
npm run dev
```

O sistema estará disponível em: `http://localhost:8000`

### Método 2: Usando Laravel Sail (Docker)

```bash
# Iniciar containers
./vendor/bin/sail up -d

# Executar migrações
./vendor/bin/sail artisan migrate

# Compilar assets
./vendor/bin/sail npm run build
```

### Método 3: Script Automatizado

```bash
# Executar script de setup completo
composer run setup

# Executar em modo desenvolvimento
composer run dev
```

## 🗄️ Estrutura do Banco de Dados

### Tabelas Principais

- **users**: Usuários do sistema
- **transacoes**: Transações financeiras (receitas/despesas)
- **documentos**: Documentos anexados
- **noticias**: Notícias publicadas

### Relacionamentos

- Usuários podem ter múltiplas transações
- Documentos podem estar relacionados a transações
- Sistema de autenticação integrado

## 📱 Uso do Sistema

### Acesso Público

1. **Página Inicial**: Visualize totais financeiros
2. **Transações**: Consulte receitas e despesas
3. **Documentos**: Visualize e baixe documentos
4. **Notícias**: Leia notícias publicadas

### Acesso Administrativo

1. **Login**: Acesse `/login` para fazer login
2. **Dashboard**: Painel administrativo em `/admin/dashboard`
3. **Gestão**: Use os menus para gerenciar conteúdo

### Credenciais Padrão

Após executar os seeders, use:
- **Email**: admin@exemplo.com
- **Senha**: password

## 🔧 Troubleshooting

### Problemas Comuns

#### Erro: "Class 'PDO' not found"
```bash
# Instalar extensão PDO do PHP
# No Windows: descomente extension=pdo_sqlite no php.ini
# No Linux: sudo apt-get install php-sqlite3
```

#### Erro: "Permission denied" no storage
```bash
# Dar permissões de escrita
chmod -R 775 storage
chmod -R 775 bootstrap/cache
```

#### Erro: "Vite manifest not found"
```bash
# Compilar assets
npm run build
```

#### Erro: "SQLite database not found"
```bash
# Criar arquivo de banco
touch database/database.sqlite
php artisan migrate
```

### Comandos Úteis

```bash
# Limpar cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Recriar banco de dados
php artisan migrate:fresh --seed

# Verificar rotas
php artisan route:list

# Verificar logs
tail -f storage/logs/laravel.log
```

## 📞 Suporte

### Para Professores

Este projeto foi desenvolvido para fins acadêmicos. Para dúvidas sobre:

- **Funcionalidades**: Consulte a documentação do Laravel
- **Instalação**: Siga os passos detalhados acima
- **Problemas Técnicos**: Verifique a seção de troubleshooting

### Recursos Adicionais

- [Documentação Laravel](https://laravel.com/docs)
- [Documentação Tailwind CSS](https://tailwindcss.com/docs)
- [Documentação Vite](https://vitejs.dev/guide/)

### Estrutura do Projeto

```
portal-transparencia/
├── app/                    # Código da aplicação
│   ├── Http/Controllers/   # Controladores
│   └── Models/            # Modelos
├── database/              # Migrações e seeders
├── resources/             # Views, CSS, JS
├── routes/                # Definição de rotas
├── storage/               # Arquivos e logs
└── public/                # Arquivos públicos
```

---

**Desenvolvido com ❤️ usando Laravel Framework**

*Versão: Laravel 12.x | PHP 8.2+ | Tailwind CSS 4.x*