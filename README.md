# Sistema de Comentários em PHP

Este é um sistema completo de comentários desenvolvido em **PHP** com **MySQL**, incluindo:

- Cadastro e login de usuários  
- Sistema de comentários com envio de imagens  
- Curtidas (likes)  
- Edição e exclusão de comentários  
- Upload de foto de perfil  
- Organização clara em actions, config, public, partials e uploads

---

# ✅ PASSO A PASSO PARA INSTALAR (WINDOWS + LINUX)

## 1️⃣ Instalar o servidor

### ✔️ Windows – XAMPP
Baixe no site oficial:  
https://www.apachefriends.org

Ative no painel:
- Apache ✔  
- MySQL ✔  

### ✔️ Linux – LAMP (Apache + MySQL + PHP)
Instale (caso não tenha):

```bash
sudo apt update
sudo apt install apache2 mysql-server php php-mysql php-pdo php-xml php-mbstring
sudo systemctl enable apache2
sudo systemctl enable mysql
sudo systemctl start apache2
sudo systemctl start mysql
```

---

## 2️⃣ Colocar o projeto na pasta certa

### ▶️ Windows (XAMPP)

1. Extraia o projeto.
2. Crie esta pasta:

```
C:\xampp\htdocs\sistema-comentarios\
```

3. Coloque dentro dela:

- a pasta **project/**
- o arquivo **comentarios_db.sql**

Estrutura final:

```
C:\xampp\htdocs\sistema-comentarios\project\
C:\xampp\htdocs\sistema-comentarios\comentarios_db.sql
```

---

### ▶️ Linux (Apache / LAMP)

1. Extraia o projeto.
2. Crie a pasta do site:

```bash
sudo mkdir -p /var/www/html/sistema-comentarios
```

3. Copie o conteúdo:

```bash
sudo cp -r project /var/www/html/sistema-comentarios/
sudo cp comentarios_db.sql /var/www/html/sistema-comentarios/
```

4. Permissão para uploads:

```bash
sudo chmod -R 777 /var/www/html/sistema-comentarios/project/uploads
```

Estrutura final:

```
/var/www/html/sistema-comentarios/project/
/var/www/html/sistema-comentarios/comentarios_db.sql
```

---

## 3️⃣ Criar o banco de dados

Acesse:

```
http://localhost/phpmyadmin
```

1. Clique em **Novo**
2. Nome do banco:

```
comentarios_db
```

3. Clique **Criar**
4. Vá em **Importar**
5. Selecione o arquivo:

```
comentarios_db.sql
```

6. Clique **Executar**

Banco criado com sucesso!

---

## 4️⃣ Configurar a conexão do banco

Abra:

```
project/config/database.php
```

E configure:

```php
$host = 'localhost';
$dbname = 'comentarios_db';
$username = 'root';
$password = '';
```

Se você usa senha no MySQL, coloque aqui:

```php
$password = 'SUA_SENHA';
```

---

## 5️⃣ Acessar o sistema

### ✔️ Windows

```
http://localhost/sistema-comentarios/project/public/
```

### ✔️ Linux

```
http://localhost/sistema-comentarios/project/public/
```

Se abrir → Funcionou 🎉

---

## 6️⃣ Usando o sistema

1. Vá em **Registrar**  
2. Crie sua conta  
3. Faça login  
4. Publique comentários  
5. Envie imagens  
6. Edite / delete seus comentários  
7. Dê likes  

---

# 📁 Estrutura do Projeto

```
Sistema_comentarios-main/
│
├── comentarios_db.sql
└── project/
    ├── actions/
    │   ├── comment_action.php
    │   ├── delete_comment_action.php
    │   ├── edit_comment_action.php
    │   ├── like_action.php
    │   ├── login_action.php
    │   └── register_action.php
    │
    ├── config/
    │   ├── config.php
    │   └── database.php
    │
    ├── partials/
    │   ├── footer.php
    │   ├── header-dashboard.php
    │   ├── header.php
    │   ├── navbar-dashboard.php
    │   └── navbar.php
    │
    ├── public/
    │   ├── assets/
    │   │   └── app.css
    │   ├── comments.php
    │   ├── index.php
    │   ├── login.php
    │   ├── logout.php
    │   └── register.php
    │
    └── uploads/
        ├── comentarios/
        └── perfil/
```

---

# 🔧 Tecnologias Usadas

- PHP 7.4+  
- MySQL / MariaDB  
- Apache  
- PDO  
- HTML / CSS  

---

# 🤝 Contribuições

Pull requests são bem-vindos!  
Sugestões também são aceitas.

---

# 📄 Licença

Projeto sob a licença **MIT** – livre para usar e modificar.

