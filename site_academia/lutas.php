<?php
// --- LÓGICA PHP (Padrão para todas as páginas) ---

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

// Texto de boas-vindas para o áudio
$texto_audio = "Bem-vindo ao Accessibility Fitness. Escolha sua modalidade no menu abaixo: " .
               "Guia de Treinos, Anabolizantes, Suplementos, Lutas, Dança, Depoimentos e Sobre o Projeto.";

$url_audio = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($texto_audio) . "&tl=pt-BR&client=tw-ob";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home - Accessibility Fitness</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* Classes de Acessibilidade (PHP) */
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    /* Alto Contraste */
    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste a.btn-nav { 
        background-color: #333 !important; 
        color: yellow !important; 
        border: 2px solid yellow !important;
    }
    body.tema-alto-contraste .frase-home { color: #00FF00 !important; }

    /* Barra Superior */
    #barra-acessibilidade { padding: 10px; background: #eee; text-align: center; border-bottom: 2px solid #ccc; margin-bottom: 20px;}
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 1px solid yellow; }
    
    .btn-acess {
        text-decoration: none; padding: 5px 10px; background: #007bff; color: white; 
        border-radius: 4px; margin: 0 5px; display: inline-block; font-size: 1rem;
    }
  </style>
</head>

<body class="pg-home com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

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
        <a href="<?php echo criarLink(['ler' => 'sim']); ?>" class="btn-acess">🔊 Ouvir Menu</a>
    <?php endif; ?>
  </div>

  <main>
    <h1>Accessibility Fitness</h1>
    <p>Escolha sua modalidade e comece seu treino heroico!</p>

    <nav class="menu-botoes">
      <a href="treinos.html" class="btn-nav">💪 Guia de Treinos</a>
      
      <a href="anabolizantes.php" class="btn-nav">💊 Anabolizantes (Info)</a>
      
      <a href="suplementos.html" class="btn-nav">🥤 Suplementos</a>
      <a href="lutas.html" class="btn-nav">🥋 Lutas</a>
      
      <a href="danca.php" class="btn-nav">💃 Dança</a>
      
      <a href="depoimentos.php" class="btn-nav">🎥 Depoimentos</a>
      
      <a href="contato.html" class="btn-nav">📞 Contato</a>
      <a href="login.html" class="btn-nav">🔐 Login</a>
      
      <a href="pagina_principal.php" class="btn-nav">ℹ️ Sobre o Projeto</a>
    </nav>

    <div class="frase-home">
      <p><em>"O impossível só existe até alguém provar o contrário."</em></p>
    </div>
  </main>

  </body>

</html>

