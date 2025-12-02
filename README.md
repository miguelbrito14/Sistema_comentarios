# 💬 Sistema de Comentários em PHP

![PHP](https://img.shields.io/badge/PHP-7.4+-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?logo=mysql&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-Server-D22128?logo=apache&logoColor=white)
![License](https://img.shields.io/badge/License-MIT-green)
![Status](https://img.shields.io/badge/Status-Ativo-success)

Sistema completo de comentários com:
- Cadastro e login  
- Comentários com envio de imagens  
- Likes  
- Edição e exclusão  
- Foto de perfil  
- Estrutura profissional em pastas  

---

## 📚 Sumário
- [✨ Recursos](#-recursos)
- [🛠️ Instalação (Windows, Linux e macOS)](#️-instalação-windows-linux-e-macos)
- [🗄️ Configuração do Banco](#️-configuração-do-banco)
- [⚙️ Configurar o Projeto](#️-configurar-o-projeto)
- [🚀 Acessando o Sistema](#-acessando-o-sistema)
- [📁 Estrutura do Projeto](#-estrutura-do-projeto)
- [🤝 Contribuições](#-contribuições)
- [📄 Licença](#-licença)

---

## ✨ Recursos
- 🔐 Autenticação (login/registro)  
- 💬 Sistema de comentários  
- 🖼️ Upload de imagens  
- 👍 Sistema de likes  
- ✏️ Editar e excluir comentários  
- 👤 Upload de foto de perfil  
- 📦 Arquitetura organizada (actions, config, public, partials, uploads)

---

# 🛠️ Instalação (Windows, Linux e macOS)

## 1️⃣ Instalar servidor Apache + PHP + MySQL

---

### ✔️ Windows – XAMPP
Baixe:  
https://www.apachefriends.org  

Ative no painel:  
- Apache  
- MySQL  

---

### ✔️ Linux – LAMP
```sh
sudo apt update
sudo apt install apache2 mysql-server php php-mysql php-pdo php-xml php-mbstring
sudo systemctl enable apache2
sudo systemctl enable mysql
sudo systemctl start apache2
sudo systemctl start mysql
```

---

### ✔️ macOS – MAMP
Baixe:  
https://www.mamp.info/en/downloads/

Ative no MAMP:  
- Apache  
- MySQL  

Coloque arquivos no diretório:
```
/Applications/MAMP/htdocs/
```

---

## 2️⃣ Colocar o projeto na pasta correta

### ▶️ Windows (XAMPP)
```
C:\xampp\htdocs\sistema-comentarios\project\
C:\xampp\htdocs\sistema-comentarios\comentarios_db.sql
```

---

### ▶️ Linux (LAMP)
```sh
sudo mkdir -p /var/www/html/sistema-comentarios
sudo cp -r project /var/www/html/sistema-comentarios/
sudo cp comentarios_db.sql /var/www/html/sistema-comentarios/
sudo chmod -R 777 /var/www/html/sistema-comentarios/project/uploads
```

---

### ▶️ macOS (MAMP)
```
/Applications/MAMP/htdocs/sistema-comentarios/project/
/Applications/MAMP/htdocs/sistema-comentarios/comentarios_db.sql
```

Permissões:
```sh
sudo chmod -R 777 /Applications/MAMP/htdocs/sistema-comentarios/project/uploads
```

---

# 🗄️ Configuração do Banco

Acesse:  
http://localhost/phpmyadmin  

1. Novo banco  
2. Nome: **comentarios_db**  
3. Criar  
4. Importar → **comentarios_db.sql**  
5. Executar  

---

# ⚙️ Configurar o Projeto

Edite o arquivo:  
`project/config/database.php`

```php
$host = 'localhost';
$dbname = 'comentarios_db';
$username = 'root';
$password = '';
```

Se MySQL tiver senha:
```php
$password = 'SUA_SENHA';
```

---

# 🚀 Acessando o Sistema

### ✔️ Windows
http://localhost/sistema-comentarios/project/public/

### ✔️ Linux
http://localhost/sistema-comentarios/project/public/

### ✔️ macOS (MAMP)
http://localhost:8888/sistema-comentarios/project/public/

---

# 📁 Estrutura do Projeto
```
Sistema_comentarios-main/
│
├── comentarios_db.sql
└── project/
    ├── actions/
    ├── config/
    ├── partials/
    ├── public/
    └── uploads/
```

---

# 🤝 Contribuições
Pull Requests são bem-vindos!  
Sugestões também. 😄

---

# 📄 Licença
Projeto sob licença **MIT** – Livre para uso e modificação.

---
