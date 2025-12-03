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
- 🎨 **NOVO**: Design moderno com Glassmorphism
- 🌙 **NOVO**: Dark Mode fosco com transições suaves
- 📱 **NOVO**: 100% responsivo (mobile, tablet, desktop)
- ✨ **NOVO**: Animações e microinterações

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

# 🎨 Design Moderno (NEW)

Seu sistema foi completamente redesenhado com um design moderno, limpo e elegante!

## ✨ Características de Design

### 🌈 Modo Claro
- **Glassmorphism** com transparência e blur effect
- Tons neutros com detalhes em púrpura/lilás
- Sombras suaves e cantos arredondados
- Gradientes elegantes em botões

### 🌙 Dark Mode Fosco
- Tons grafite (#0f0f10) e cinza petróleo (#1a1a1d)
- Sem brilho - design fosco profissional
- Transição suave de 300-400ms
- Toggle automático com localStorage

### 📱 Totalmente Responsivo
- Desktop (1200px+): 3 colunas para estatísticas
- Tablet (768px-1200px): Layout adaptado
- Mobile (<768px): Optimizado para tela pequena
- Telemóvel (<480px): Comprimido ao máximo

### ✨ Animações Suaves
- Entrada suave (fadeIn, slideInUp, slideInDown)
- Hover effects em botões e cards
- Pop animation em curtidas
- Glow em avatares
- Transições em 300-400ms

### 🎯 Componentes Modernos
- Cards com glassmorphism
- Botões com gradientes
- Formulários elegantes
- Alertas coloridos
- Modal com overlay
- Comentários com avatares glow
- Estatísticas com ícones

## 📚 Documentação de Design

Para detalhes completos sobre o design:
1. 📄 **DESIGN_GUIDE.md** - Documentação completa (paleta, componentes, etc)
2. 📄 **HTML_SUGESTOES.html** - Exemplos práticos de estrutura HTML
3. 📄 **styles.css** - CSS novo (1.500+ linhas, bem organizado)

## 🚀 Começar a Usar

O design está **100% integrado** e pronto para usar! Nenhuma ação necessária.

Para testar **Dark Mode** no console (F12):
```javascript
localStorage.setItem('darkMode', 'true'); location.reload();
```

Ou use o botão no dropdown do usuário: **🌙 Dark Mode**

## 🎨 Cores Principais

| Propósito | Cor | Código |
|-----------|-----|--------|
| Primário | 🟣 Púrpura | `#667eea` |
| Secundário | 🟣 Lilás | `#764ba2` |
| Sucesso | 🟢 Verde | `#43e97b` |
| Perigo | 🔴 Vermelho/Rosa | `#f5576c` |
| Aviso | 🟡 Amarelo | `#fcb045` |

## 📊 Estatísticas

- ✅ **1.500+ linhas** de CSS bem estruturado
- ✅ **19 seções** de CSS (navbar, botões, cards, etc)
- ✅ **10 animações** prontas para usar
- ✅ **100% Bootstrap 5** compatível
- ✅ **0% mudanças** no banco de dados
- ✅ **5 breakpoints** responsivos

---

# 🤝 Contribuições
Pull Requests são bem-vindos!  
Sugestões também. 😄

---

# 📄 Licença
Projeto sob licença **MIT** – Livre para uso e modificação.

---
