<?php
// --- LÓGICA PHP ---

// 1. Configurações de Acessibilidade (Igual às outras páginas)
$tema_atual = isset($_GET['tema']) ? $_GET['tema'] : 'padrao';
$tamanho_fonte = isset($_GET['fonte']) ? $_GET['fonte'] : 'medio';
$ler_texto = isset($_GET['ler']) ? $_GET['ler'] : 'nao';

function criarLink($params) {
    global $tema_atual, $tamanho_fonte;
    $novos = array_merge([
        'tema' => $tema_atual,
        'fonte' => $tamanho_fonte,
        'ler' => 'nao'
    ], $params);
    return "?" . http_build_query($novos);
}

// 2. LÓGICA DE LOGIN SIMPLIFICADA (PHP)
// Verifica se o formulário foi enviado (Método POST)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Se preencheu email e senha...
    if (!empty($email) && !empty($senha)) {
        // Redireciona para a Home mantendo a acessibilidade
        // Nota: O header('Location: ...') faz o navegador mudar de página
        header("Location: index.php?tema=$tema_atual&fonte=$tamanho_fonte");
        exit;
    } else {
        $erro = "Por favor, preencha todos os campos!";
    }
}

// Texto para o áudio
$texto_audio = "Tela de Login do Accessibility Fitness. Por favor, digite seu e-mail e senha para entrar.";
$url_audio = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($texto_audio) . "&tl=pt-BR&client=tw-ob";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login - Accessibility Fitness</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* CSS para Acessibilidade Dinâmica */
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste input { background-color: #333; color: white; border: 1px solid yellow; }
    body.tema-alto-contraste button { background-color: yellow; color: black; font-weight: bold; }
    body.tema-alto-contraste a { color: #00FF00 !important; }

    /* Barra Superior */
    #barra-acessibilidade { padding: 10px; background: #eee; text-align: center; border-bottom: 2px solid #ccc; margin-bottom: 20px;}
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 1px solid yellow; }
    
    .btn-acess {
        text-decoration: none; padding: 5px 10px; background: #007bff; color: white; 
        border-radius: 4px; margin: 0 5px; display: inline-block; font-size: 1rem;
    }

    /* Mensagem de Erro */
    .msg-erro { color: red; font-weight: bold; margin-bottom: 15px; }
  </style>
</head>

<body class="pg-login com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

  <div id="barra-acessibilidade">
    <a href="<?php echo criarLink(['fonte' => 'grande']); ?>" class="btn-acess">A+</a>
    <a href="<?php echo criarLink(['fonte' => 'medio']); ?>" class="btn-acess">A</a>
    <a href="<?php echo criarLink(['fonte' => 'pequeno']); ?>" class="btn-acess">A-</a>

    <?php if($tema_atual == 'padrao'): ?>
        <a href="<?php echo criarLink(['tema' => 'alto-contraste']); ?>" class="btn-acess">⚡ Contraste</a>
    <?php else: ?>
        <a href="<?php echo criarLink(['tema' => 'padrao']); ?>" class="btn-acess">⚪ Normal</a>
    <?php endif; ?>

    <?php if($ler_texto == 'sim'): ?>
        <a href="<?php echo criarLink(['ler' => 'nao']); ?>" class="btn-acess" style="background:red">⏹️ Parar</a>
        <div style="margin-top:10px;">
            <audio controls autoplay>
                <source src="<?php echo $url_audio; ?>" type="audio/mpeg">
            </audio>
        </div>
    <?php else: ?>
        <a href="<?php echo criarLink(['ler' => 'sim']); ?>" class="btn-acess">🔊 Ouvir</a>
    <?php endif; ?>
  </div>

  <main class="login-container">
    <header>
      <h2>Accessibility Fitness</h2>
      <p>Bem-vindo ao treino com liberdade.</p>
    </header>

    <?php if (isset($erro)): ?>
        <p class="msg-erro"><?php echo $erro; ?></p>
    <?php endif; ?>

    <form action="" method="POST">
      
      <input type="hidden" name="tema" value="<?php echo $tema_atual; ?>">
      <input type="hidden" name="fonte" value="<?php echo $tamanho_fonte; ?>">

      <div>
        <label for="email">E-mail</label>
        <input type="email" id="email" name="email" placeholder="seuemail@exemplo.com" required>
      </div>
      
      <div>
        <label for="senha">Senha</label>
        <input type="password" id="senha" name="senha" required>
      </div>
      
      <button type="submit">Entrar</button>
    </form>
    
    <p class="login-ajuda">
      <a href="contato.html">Precisa de ajuda?</a>
    </p>
  </main>

  </body>
</html>
