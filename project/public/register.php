<?php require_once "../partials/header.php"; ?>

<style>
.register-wrapper {
    max-width: 450px;
    margin: 50px auto;
    padding: 40px 30px;
    background: #ffffff;
    border-radius: 16px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.1);
    animation: fadeIn .6s ease;
    border: 1px solid #e0e0e0;
}

.register-title {
    font-size: 2rem;
    font-weight: 800;
    text-align: center;
    margin-bottom: 30px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}

.register-wrapper label {
    font-weight: 600;
    margin-top: 15px;
    color: #333;
    display: block;
}

.register-wrapper input {
    height: 50px;
    border-radius: 10px;
    border: 2px solid #e0e0e0;
    padding: 0 15px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.register-wrapper input:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.register-wrapper button {
    width: 100%;
    height: 50px;
    font-size: 18px;
    font-weight: 700;
    border-radius: 10px;
    background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
    border: none;
    margin-top: 25px;
    transition: all 0.3s ease;
    color: white;
}

.register-wrapper button:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(67, 233, 123, 0.4);
}

.register-links {
    text-align: center;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #e0e0e0;
}

.register-links a {
    font-weight: 600;
    color: #667eea;
    text-decoration: none;
    transition: color 0.3s ease;
}

.register-links a:hover {
    color: #764ba2;
    text-decoration: underline;
}

.photo-preview {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #667eea;
    margin: 10px auto;
    display: block;
}

/* Dark mode */
.dark-mode .register-wrapper {
    background: radial-gradient(1200px 400px at 10% 10%, rgba(124,58,237,0.06), transparent 10%),
                        radial-gradient(1000px 300px at 90% 90%, rgba(236,72,153,0.04), transparent 10%),
                        linear-gradient(180deg,#0b0b0d,#0f1113);
    border-color: rgba(255,255,255,0.04);
    box-shadow: 0 8px 32px rgba(2,6,23,0.6);
}

.dark-mode .register-wrapper label {
    color: #e6e6e6;
}

.dark-mode .register-wrapper input {
    background: #111318;
    border-color: #22262b;
    color: #e6e6e6;
}

/* Alerts & preview in dark mode */
.dark-mode .alert {
    border: 1px solid rgba(255,255,255,0.04);
    background: rgba(255,255,255,0.02);
    color: #e6e6e6;
}
.dark-mode .photo-preview {
    border-color: rgba(255,255,255,0.06);
}
</style>

<div class="register-wrapper">
    <h2 class="register-title">🚀 Criar Conta</h2>

    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= $_SESSION['flash']; unset($_SESSION['flash']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="../actions/register_action.php" method="POST" enctype="multipart/form-data">
        <label>👤 Nome de usuário:</label>
        <input type="text" name="username" class="form-control" required placeholder="Seu nome de usuário">

        <label class="mt-3">📧 Email:</label>
        <input type="email" name="email" class="form-control" required placeholder="seu@email.com">

        <label class="mt-3">🔒 Senha:</label>
        <input type="password" name="password" class="form-control" required placeholder="Crie uma senha segura">

        <label class="mt-3">🖼️ Foto de perfil (opcional):</label>
        <input type="file" name="photo" class="form-control" accept="image/*" onchange="previewProfilePhoto(this)">
        
        <img id="profilePreview" class="photo-preview d-none">

        <button class="btn btn-success">🎉 Criar Minha Conta</button>
    </form>

    <p class="register-links">
        Já tem conta? <a href="login.php">Faça login aqui!</a>
    </p>
</div>

<script>
function previewProfilePhoto(input) {
    const preview = document.getElementById('profilePreview');
    const file = input.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    } else {
        preview.classList.add('d-none');
    }
}
</script>

<?php require_once "../partials/footer.php"; ?>