# Sistema de Comentários em PHP

Este é um sistema completo de comentários desenvolvido em **PHP** com **MySQL**, incluindo:

- Cadastro e login de usuários  
- Sistema de comentários com imagens  
- Curtidas (likes)  
- Edição e exclusão de comentários  
- Upload de imagem de perfil  
- Upload de imagem no comentário  
- Estrutura organizada em actions, config, public, partials e uploads

---

# ✅ PASSO A PASSO PARA INSTALAR (FUNCIONA 100%)

## 1️⃣ Instale o XAMPP
Baixe e instale o XAMPP:
https://www.apachefriends.org

Ative no painel:
- Apache ✔  
- MySQL ✔  

---

## 2️⃣ Coloque o projeto na pasta certa
Extraia o projeto e copie a pasta **project** para:

```
C:\xampp\htdocs\sistema-comentarios\
```

Estrutura final:

```
C:\xampp\htdocs\sistema-comentarios\project\
```

---

## 3️⃣ Crie o banco de dados
Acesse:

```
http://localhost/phpmyadmin
```

1. Clique em **Novo**  
2. Nome do banco: `comentarios_db`  
3. Clique **Criar**  
4. Vá em **Importar**  
5. Selecione o arquivo: **comentarios_db.sql**  
6. Clique em **Executar**

---

## 4️⃣ Configure a conexão do banco
Abra:

```
project/config/database.php
```

Deixe assim:

```php
$host = 'localhost';
$dbname = 'comentarios_db';
$username = 'root';
$password = '';
```

Se usar senha no MySQL, coloque no `$password`.

---

## 5️⃣ Permissão de pastas (apenas Linux)
Se estiver no Windows, ignore.

Linux:

```bash
sudo chmod -R 777 project/uploads
```

---

## 6️⃣ Acesse o sistema
Abra o navegador e entre em:

```
http://localhost/sistema-comentarios/project/public/
```

Se aparecer a página inicial → Funcionou! 🎉

---

## 7️⃣ Use o sistema
1. Clique em **Registrar**  
2. Crie sua conta  
3. Faça login  
4. Poste comentários  
5. Envie imagens  
6. Edite ou delete seus comentários  
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
        │   └── imagens enviadas
        └── perfil imagens
```

---

# 🔧 Tecnologias Usadas
- PHP 7.4+  
- MySQL / MariaDB  
- HTML / CSS  
- PDO  
- Apache (XAMPP ou LAMP)

---

# 🤝 Contribuições
Pull requests são bem-vindos!  
Sugestões de melhorias também.

---

# 📄 Licença
Projeto sob a licença **MIT** – livre para usar e modificar.

