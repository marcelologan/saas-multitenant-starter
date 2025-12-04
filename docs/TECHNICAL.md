2️⃣ DOCUMENTAÇÃO TÉCNICA (docs/TECHNICAL.md)
markdown
Copiar

# 🏗️ Documentação Técnica - SaaS Multi-Tenant Starter

## 📋 **Índice**
- [Arquitetura do Sistema](#arquitetura)
- [Estrutura de Diretórios](#estrutura)
- [Sistema de Temas](#temas)
- [Autenticação e Autorização](#auth)
- [Banco de Dados](#database)
- [APIs e Endpoints](#apis)

---

## 🏛️ **Arquitetura do Sistema** {#arquitetura}

### **Padrão MVC Laravel**
┌─────────────────┐ ┌─────────────────┐ ┌─────────────────┐ │ Models │ │ Controllers │ │ Views │ │ │ │ │ │ │ │ User.php │◄──►│ UserController │◄──►│ users/index │ │ Company.php │ │ AuthController │ │ auth/login │ │ Role.php │ │ ThemeController │ │ layouts/app │ └─────────────────┘ └─────────────────┘ └─────────────────┘


### **Service Providers**
- **ThemeServiceProvider**: Gerencia temas dinâmicos
- **AuthServiceProvider**: Configurações de autorização
- **RouteServiceProvider**: Roteamento da aplicação

---

## 📁 **Estrutura de Diretórios** {#estrutura}

saas-multitenant-starter/ ├── app/ │ ├── Http/ │ │ ├── Controllers/ │ │ │ ├── Auth/ │ │ │ │ ├── AuthenticatedSessionController.php │ │ │ │ └── RegisteredUserController.php │ │ │ ├── ProfileController.php │ │ │ └── ThemeController.php │ │ └── Middleware/ │ ├── Models/ │ │ ├── User.php │ │ ├── Company.php │ │ ├── Role.php │ │ └── Permission.php │ ├── Providers/ │ │ └── ThemeServiceProvider.php │ └── Helpers/ │ └── ThemeHelper.php ├── config/ │ └── theme.php ├── resources/ │ ├── views/ │ │ ├── admin/ │ │ │ ├── settings.blade.php │ │ │ └── partials/ │ │ ├── auth/ │ │ ├── profile/ │ │ └── layouts/ │ ├── css/ │ │ ├── themes/ │ │ │ └── themes.css │ │ └── dashboard/ │ └── js/ │ └── themes/ │ └── theme-switcher.js └── database/ ├── migrations/ └── seeders/


---

## 🎨 **Sistema de Temas** {#temas}

### **Arquitetura do Sistema de Temas**

```php
// config/theme.php
return [
    'default' => 'flat-ui',
    'available' => [
        'flat-ui' => [
            'name' => 'Flat UI',
            'description' => 'Modern flat design theme'
        ],
        'russian' => [
            'name' => 'Russian',
            'description' => 'Russian flag inspired theme'
        ],
        'german' => [
            'name' => 'German',
            'description' => 'German flag inspired theme'
        ]
    ]
];
ThemeServiceProvider
php
Copiar

class ThemeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Registra helper global para temas
        View::composer('*', function ($view) {
            $view->with('currentTheme', session('theme', config('theme.default')));
        });
    }
}
Variáveis CSS por Tema
css
Copiar

/* Flat UI Theme */
:root[data-theme="flat-ui"] {
    --color-main: #3498db;
    --color-second: #2ecc71;
    --color-font: #2c3e50;
    --color-background: #ecf0f1;
    --color-link: #e74c3c;
    --color-danger: #e74c3c;
    --color-success: #27ae60;
    --color-warning: #f39c12;
}

/* Russian Theme */
:root[data-theme="russian"] {
    --color-main: #0039a6;
    --color-second: #d52b1e;
    --color-font: #ffffff;
    /* ... */
}
Theme Switcher JavaScript
javascript
Copiar

class ThemeSwitcher {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
        this.loadSavedTheme();
    }

    switchTheme(themeName) {
        document.documentElement.setAttribute('data-theme', themeName);
        localStorage.setItem('selectedTheme', themeName);
        this.updateServer(themeName);
    }

    updateServer(themeName) {
        fetch('/theme/switch', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ theme: themeName })
        });
    }
}
🔐 Autenticação e Autorização {#auth}
Modelo de Usuário
php
Copiar

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'email', 'password', 'company_id'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles');
    }

    public function hasRole($role)
    {
        return $this->roles()->where('name', $role)->exists();
    }
}
Sistema de Roles e Permissions
php
Copiar

// Estrutura de Roles
class Role extends Model
{
    protected $fillable = ['name', 'description'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_roles');
    }
}

// Middleware de Autorização
class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!auth()->user()->hasRole($role)) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
🗄️ Banco de Dados {#database}
Schema Principal
sql
Copiar

-- Empresas/Tenants
CREATE TABLE companies (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Usuários
CREATE TABLE users (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE,
    company_id BIGINT,
    password VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (company_id) REFERENCES companies(id)
);

-- Roles
CREATE TABLE roles (
    id BIGINT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- User-Role Relationship
CREATE TABLE user_roles (
    id BIGINT PRIMARY KEY,
    user_id BIGINT,
    role_id BIGINT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (role_id) REFERENCES roles(id)
);
Seeders
php
Copiar

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Roles padrão
        Role::create(['name' => 'admin-empresa', 'description' => 'Administrador da empresa']);
        Role::create(['name' => 'usuario', 'description' => 'Usuário padrão']);
        
        // Permissions padrão
        Permission::create(['name' => 'manage-users', 'description' => 'Gerenciar usuários']);
        Permission::create(['name' => 'manage-settings', 'description' => 'Gerenciar configurações']);
    }
}
🔌 APIs e Endpoints {#apis}
Rotas de Autenticação
php
Copiar

// routes/auth.php
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('register', [RegisteredUserController::class, 'store']);
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});
Rotas de Temas
php
Copiar

// routes/web.php
Route::middleware('auth')->group(function () {
    Route::post('/theme/switch', [ThemeController::class, 'switch'])->name('theme.switch');
    Route::get('/theme/current', [ThemeController::class, 'current'])->name('theme.current');
});
Rotas Administrativas
php
Copiar

Route::middleware(['auth', 'role:admin-empresa'])->prefix('admin')->group(function () {
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
});
🧪 Testes
Estrutura de Testes
php
Copiar

// tests/Feature/ThemeTest.php
class ThemeTest extends TestCase
{
    public function test_user_can_switch_theme()
    {
        $user = User::factory()->create();
        
        $response = $this->actingAs($user)
            ->post('/theme/switch', ['theme' => 'russian']);
            
        $response->assertStatus(200);
        $this->assertEquals('russian', session('theme'));
    }
}
🔧 Configurações de Desenvolvimento
Ambiente Local
bash
Copiar

# .env.example
APP_NAME="SaaS Starter"
APP_ENV=local
APP_DEBUG=true

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=saas_starter

THEME_DEFAULT=flat-ui
THEME_CACHE_ENABLED=true
Comandos Artisan Personalizados
php
Copiar

// app/Console/Commands/ThemeInstall.php
class ThemeInstall extends Command
{
    protected $signature = 'theme:install {name}';
    
    public function handle()
    {
        // Instala novo tema
    }
}

---

## 3️⃣ **GUIA DO USUÁRIO** (`docs/USER_GUIDE.md`)

```markdown
# 👥 Guia do Usuário - SaaS Multi-Tenant Starter

## 📋 **Índice**
- [Primeiros Passos](#inicio)
- [Registro de Empresa](#registro)
- [Sistema de Temas](#temas)
- [Gestão de Usuários](#usuarios)
- [Configurações](#configuracoes)
- [FAQ](#faq)

---

## 🚀 **Primeiros Passos** {#inicio}

### **1. Acessando o Sistema**
1. Acesse `http://seu-dominio.com`
2. Clique em **"Registrar Nova Empresa"**
3. Preencha os dados da sua empresa
4. Seu usuário administrador será criado automaticamente

### **2. Primeiro Login**
1. Use o email e senha cadastrados
2. Você será direcionado ao **Dashboard**
3. Como administrador, terá acesso a todas as funcionalidades

---

## 🏢 **Registro de Empresa** {#registro}

### **Passo a Passo**

#### **Tela de Registro**
![Registro](images/register.png)

1. **Nome da Empresa**: Digite o nome completo
2. **Email Corporativo**: Email principal da empresa
3. **Nome do Administrador**: Seu nome completo
4. **Email Pessoal**: Seu email de acesso
5. **Senha**: Mínimo 8 caracteres

#### **Após o Registro**
✅ **Empresa criada** no sistema
✅ **Usuário admin** criado automaticamente
✅ **Roles padrão** atribuídas
✅ **Redirecionamento** para o dashboard

---

## 🎨 **Sistema de Temas** {#temas}

### **Como Trocar de Tema**

#### **Método 1: Menu Superior**
1. Clique no **ícone de paleta** no canto superior direito
2. Selecione o tema desejado:
   - **Flat UI**: Design moderno e limpo
   - **Russian**: Cores inspiradas na bandeira russa
   - **German**: Paleta alemã elegante

#### **Método 2: Configurações**
1. Vá em **Configurações** → **Aparência**
2. Escolha o tema na lista suspensa
3. Clique em **"Salvar"**

### **Temas Disponíveis**

| Tema | Cores Principais | Melhor Para |
|------|------------------|-------------|
| **Flat UI** | Azul, Verde, Cinza | Uso geral, moderno |
| **Russian** | Azul, Vermelho, Branco | Corporativo formal |
| **German** | Preto, Vermelho, Amarelo | Empresas tradicionais |

### **Personalização**
- Temas são **salvos por usuário**
- **Sincronização** entre dispositivos
- **Modo escuro** disponível em todos os temas

---

## 👥 **Gestão de Usuários** {#usuarios}

### **Adicionando Usuários**

#### **Via Modal de Criação**
1. Vá para **Admin** → **Configurações**
2. Clique na aba **"Usuários"**
3. Clique em **"+ Novo Usuário"**
4. Preencha os dados:
   - Nome completo
   - Email válido
   - Senha temporária
   - Role (função)

#### **Roles Disponíveis**
- **Admin Empresa**: Acesso total ao sistema
- **Usuário**: Acesso limitado às funcionalidades básicas
- **Visualizador**: Apenas leitura

### **Editando Usuários**

#### **Informações Básicas**
1. Clique no **ícone de edição** ao lado do usuário
2. Modifique os campos necessários
3. Clique em **"Salvar Alterações"**

#### **Alterando Roles**
1. Na modal de edição
2. Selecione a nova **Role** no dropdown
3. Confirme a alteração

### **Removendo Usuários**
⚠️ **Atenção**: Esta ação é irreversível

1. Clique no **ícone de lixeira**
2. Confirme digitando **"CONFIRMAR"**
3. Usuário será removido permanentemente

---

## ⚙️ **Configurações** {#configuracoes}

### **Configurações da Empresa**

#### **Informações Básicas**
- **Nome da Empresa**: Altere quando necessário
- **Email Corporativo**: Email principal de contato
- **Logo**: Upload da logo da empresa (opcional)

#### **Configurações de Sistema**
- **Tema Padrão**: Tema aplicado a novos usuários
- **Idioma**: Português (BR) por padrão
- **Fuso Horário**: Configuração regional

### **Configurações de Usuário**

#### **Perfil Pessoal**
1. Clique no **seu nome** no canto superior direito
2. Selecione **"Perfil"**
3. Edite suas informações:
   - Nome
   - Email
   - Senha
   - Foto de perfil

#### **Preferências**
- **Tema Pessoal**: Sobrescreve o tema da empresa
- **Notificações**: Configure alertas por email
- **Dashboard**: Personalize widgets exibidos

---

## ❓ **FAQ - Perguntas Frequentes** {#faq}

### **🔐 Autenticação**

**P: Esqueci minha senha, como recuperar?**
R: Clique em "Esqueci minha senha" na tela de login e siga as instruções por email.

**P: Posso ter múltiplas empresas no mesmo email?**
R: Não, cada email pode estar associado a apenas uma empresa.

### **🎨 Temas**

**P: Posso criar meus próprios temas?**
R: Atualmente não, mas esta funcionalidade está em desenvolvimento.

**P: O tema escolhido afeta outros usuários?**
R: Não, cada usuário pode escolher seu tema individual.

### **👥 Usuários**

**P: Quantos usuários posso adicionar?**
R: Não há limite técnico, mas verifique seu plano de assinatura.

**P: Posso transferir a administração para outro usuário?**
R: Sim, através das configurações de roles na área administrativa.

### **🏢 Empresa**

**P: Posso alterar o nome da empresa depois do registro?**
R: Sim, através das configurações da empresa.

**P: Como faço backup dos dados?**
R: Entre em contato com o suporte para procedimentos de backup.

---

## 📞 **Suporte**

### **Canais de Atendimento**
- 📧 **Email**: suporte@seudominio.com
- 💬 **Chat**: Disponível no sistema (canto inferior direito)
- 📱 **WhatsApp**: +55 (11) 99999-9999

### **Horário de Atendimento**
- **Segunda a Sexta**: 9h às 18h
- **Sábado**: 9h às 12h
- **Domingo**: Apenas emergências

### **Documentação Adicional**
- 🏗️ [Documentação Técnica](TECHNICAL.md)
- 🚀 [Guia de Deploy](DEPLOYMENT.md)
- 📊 [Relatórios e Analytics](ANALYTICS.md)

---

💡 **Dica**: Mantenha este guia sempre à mão para consultas rápidas!
4️⃣ GUIA DE DEPLOY (docs/DEPLOYMENT.md)
markdown
Copiar

# 🚀 Guia de Deploy - SaaS Multi-Tenant Starter

## 📋 **Índice**
- [Pré-requisitos](#prerequisitos)
- [Deploy em Produção](#producao)
- [Configuração de Servidor](#servidor)
- [SSL e Domínio](#ssl)
- [Monitoramento](#monitoramento)
- [Backup e Recuperação](#backup)

---

## ⚡ **Pré-requisitos** {#prerequisitos}

### **Servidor Mínimo**
- **CPU**: 2 vCPUs
- **RAM**: 4GB
- **Storage**: 50GB SSD
- **OS**: Ubuntu 20.04+ / CentOS 8+

### **Software Necessário**
- **PHP**: 8.2+
- **MySQL**: 8.0+ ou PostgreSQL 13+
- **Nginx**: 1.18+ ou Apache 2.4+
- **Node.js**: 18+
- **Composer**: 2.x
- **Git**: 2.x

### **Extensões PHP**
```bash
sudo apt install php8.2-fpm php8.2-mysql php8.2-xml php8.2-curl \
php8.2-mbstring php8.2-zip php8.2-gd php8.2-intl php8.2-bcmath
🌐 Deploy em Produção {#producao}
1. Preparação do Servidor
Ubuntu/Debian
bash
Copiar

# Atualizar sistema
sudo apt update && sudo apt upgrade -y

# Instalar LEMP Stack
sudo apt install nginx mysql-server php8.2-fpm -y

# Instalar Composer
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Instalar Node.js
curl -fsSL https://deb.nodesource.com/setup_18.x | sudo -E bash -
sudo apt-get install -y nodejs
2. Clone e Configuração
bash
Copiar

# Clone do repositório
cd /var/www
sudo git clone https://github.com/marcelologan/saas-multitenant-starter.git
sudo chown -R www-data:www-data saas-multitenant-starter
cd saas-multitenant-starter

# Instalar dependências
composer install --optimize-autoloader --no-dev
npm ci && npm run build

# Configurar permissões
sudo chmod -R 755 storage bootstrap/cache
sudo chown -R www-data:www-data storage bootstrap/cache
3. Configuração do Ambiente
bash
Copiar

# Copiar e configurar .env
cp .env.example .env
php artisan key:generate
Arquivo .env para Produção
env
Copiar

APP_NAME="SaaS Starter"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://seudominio.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=saas_production
DB_USERNAME=saas_user
DB_PASSWORD=senha_super_segura

CACHE_DRIVER=redis
SESSION_DRIVER=redis
QUEUE_CONNECTION=redis

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=seu-email@gmail.com
MAIL_PASSWORD=sua-senha-app
MAIL_ENCRYPTION=tls

# Configurações de tema
THEME_DEFAULT=flat-ui
THEME_CACHE_ENABLED=true
4. Banco de Dados
bash
Copiar

# Criar banco e usuário
sudo mysql -u root -p
sql
Copiar

CREATE DATABASE saas_production;
CREATE USER 'saas_user'@'localhost' IDENTIFIED BY 'senha_super_segura';
GRANT ALL PRIVILEGES ON saas_production.* TO 'saas_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;
bash
Copiar

# Executar migrations
php artisan migrate --force
php artisan db:seed --force
⚙️ Configuração de Servidor {#servidor}
Nginx Configuration
Arquivo: /etc/nginx/sites-available/saas-starter
nginx
Copiar

server {
    listen 80;
    server_name seudominio.com www.seudominio.com;
    root /var/www/saas-multitenant-starter/public;
    index index.php index.html;

    # Security headers
    add_header X-Frame-Options "SAMEORIGIN" always;
    add_header X-XSS-Protection "1; mode=block" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header Referrer-Policy "no-referrer-when-downgrade" always;
    add_header Content-Security-Policy "default-src 'self' http: https: data: blob: 'unsafe-inline'" always;

    # Gzip compression
    gzip on;
    gzip_vary on;
    gzip_min_length 1024;
    gzip_types text/plain text/css text/xml text/javascript application/javascript application/xml+rss application/json;

    # Handle Laravel routes
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP-FPM configuration
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Cache static assets
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Security: deny access to sensitive files
    location ~ /\. {
        deny all;
    }

    location ~ /\.ht {
        deny all;
    }
}
bash
Copiar

# Ativar site
sudo ln -s /etc/nginx/sites-available/saas-starter /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl restart nginx
PHP-FPM Otimização
Arquivo: /etc/php/8.2/fpm/pool.d/www.conf
ini
Copiar

[www]
user = www-data
group = www-data
listen = /var/run/php/php8.2-fpm.sock
listen.owner = www-data
listen.group = www-data
pm = dynamic
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
pm.process_idle_timeout = 10s
pm.max_requests = 500
�� SSL e Domínio {#ssl}
Certificado SSL com Let's Encrypt
bash
Copiar

# Instalar Certbot
sudo apt install certbot python3-certbot-nginx -y

# Obter certificado
sudo certbot --nginx -d seudominio.com -d www.seudominio.com

# Renovação automática
sudo crontab -e
# Adicionar linha:
0 12 * * * /usr/bin/certbot renew --quiet
Configuração HTTPS (Auto-gerada pelo Certbot)
nginx
Copiar

server {
    listen 443 ssl http2;
    server_name seudominio.com www.seudominio.com;
    
    ssl_certificate /etc/letsencrypt/live/seudominio.com/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/seudominio.com/privkey.pem;
    
    # SSL configuration
    ssl_protocols TLSv1.2 TLSv1.3;
    ssl_ciphers ECDHE-RSA-AES256-GCM-SHA512:DHE-RSA-AES256-GCM-SHA512;
    ssl_prefer_server_ciphers off;
    
    # ... resto da configuração
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name seudominio.com www.seudominio.com;
    return 301 https://$server_name$request_uri;
}
📊 Monitoramento {#monitoramento}
Logs do Laravel
bash
Copiar

# Configurar rotação de logs
sudo nano /etc/logrotate.d/laravel
/var/www/saas-multitenant-starter/storage/logs/*.log {
    daily
    missingok
    rotate 52
    compress
    delaycompress
    notifempty
    create 0644 www-data www-data
}
Monitoramento de Performance
Instalar Redis para Cache
bash
Copiar

sudo apt install redis-server -y
sudo systemctl enable redis-server
sudo systemctl start redis-server
Configurar Queue Workers
bash
Copiar

# Criar service para queue
sudo nano /etc/systemd/system/laravel-worker.service
ini
Copiar

[Unit]
Description=Laravel queue worker
After=network.target

[Service]
Type=simple
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /var/www/saas-multitenant-starter/artisan queue:work --sleep=3 --tries=3 --max-time=3600
StandardOutput=journal
StandardError=journal

[Install]
WantedBy=multi-user.target
bash
Copiar

sudo systemctl enable laravel-worker
sudo systemctl start laravel-worker
Monitoramento com Supervisor
bash
Copiar

sudo apt install supervisor -y
sudo nano /etc/supervisor/conf.d/laravel-worker.conf
ini
Copiar

[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/saas-multitenant-starter/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=www-data
numprocs=2
redirect_stderr=true
stdout_logfile=/var/www/saas-multitenant-starter/storage/logs/worker.log
stopwaitsecs=3600
bash
Copiar

sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start laravel-worker:*
💾 Backup e Recuperação {#backup}
Script de Backup Automatizado
Arquivo: /home/backup/backup-saas.sh
bash
Copiar

#!/bin/bash

# Configurações
DB_NAME="saas_production"
DB_USER="saas_user"
DB_PASS="senha_super_segura"
APP_PATH="/var/www/saas-multitenant-starter"
BACKUP_PATH="/home/backup"
DATE=$(date +%Y%m%d_%H%M%S)

# Criar diretório de backup
mkdir -p $BACKUP_PATH/$DATE

# Backup do banco de dados
mysqldump -u $DB_USER -p$DB_PASS $DB_NAME > $BACKUP_PATH/$DATE/database.sql

# Backup dos arquivos da aplicação
tar -czf $BACKUP_PATH/$DATE/application.tar.gz -C $APP_PATH \
    --exclude='node_modules' \
    --exclude='storage/logs' \
    --exclude='storage/framework/cache' \
    --exclude='storage/framework/sessions' \
    --exclude='storage/framework/views' \
    .

# Backup dos uploads (se houver)
if [ -d "$APP_PATH/storage/app/public" ]; then
    tar -czf $BACKUP_PATH/$DATE/uploads.tar.gz -C $APP_PATH/storage/app/public .
fi

# Remover backups antigos (manter últimos 7 dias)
find $BACKUP_PATH -type d -name "20*" -mtime +7 -exec rm -rf {} \;

echo "Backup concluído: $BACKUP_PATH/$DATE"
bash
Copiar

# Tornar executável e agendar
chmod +x /home/backup/backup-saas.sh
sudo crontab -e
# Adicionar linha para backup diário às 2h:
0 2 * * * /home/backup/backup-saas.sh
Procedimento de Recuperação
bash
Copiar

# Restaurar banco de dados
mysql -u saas_user -p saas_production < /home/backup/20231201_020000/database.sql

# Restaurar aplicação
cd /var/www
sudo rm -rf saas-multitenant-starter-old
sudo mv saas-multitenant-starter saas-multitenant-starter-old
sudo tar -xzf /home/backup/20231201_020000/application.tar.gz
sudo chown -R www-data:www-data saas-multitenant-starter

# Restaurar uploads
sudo tar -xzf /home/backup/20231201_020000/uploads.tar.gz -C /var/www/saas-multitenant-starter/storage/app/public/

# Reconfigurar permissões
sudo chmod -R 755 /var/www/saas-multitenant-starter/storage
sudo chmod -R 755 /var/www/saas-multitenant-starter/bootstrap/cache
🔧 Comandos de Manutenção
Otimização de Performance
bash
Copiar

# Cache de configuração
php artisan config:cache

# Cache de rotas
php artisan route:cache

# Cache de views
php artisan view:cache

# Otimização do autoloader
composer dump-autoload --optimize

# Limpeza de cache
php artisan cache:clear
php artisan view:clear
php artisan config:clear
php artisan route:clear
Atualizações de Segurança
bash
Copiar

# Atualizar dependências
composer update --no-dev
npm update

# Verificar vulnerabilidades
composer audit
npm audit

# Atualizar sistema
sudo apt update && sudo apt upgrade -y
📈 Escalabilidade
Load Balancer (Nginx)
nginx
Copiar

upstream app_servers {
    server 10.0.1.10:80 weight=3;
    server 10.0.1.11:80 weight=2;
    server 10.0.1.12:80 weight=1;
}

server {
    listen 80;
    location / {
        proxy_pass http://app_servers;
        proxy_set_header Host $host;
        proxy_set_header X-Real-IP $remote_addr;
    }
}
Database Clustering
Master-Slave para leitura/escrita
Connection pooling com PgBouncer
Backup automático em múltiplas regiões
💡 Dica: Sempre teste o deploy em ambiente de staging antes da produção!

