<?php
// --- LÓGICA PHP (Igual às outras páginas para manter o padrão) ---

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

// Texto para o botão "Ouvir Página"
$texto_audio = "Página de Depoimentos. Assista ao vídeo de Fabiano mostrando seu treino de resistência e superação. " .
               "Descrição visual: Fabiano está na academia realizando exercícios de musculação adaptada com foco e determinação.";

$url_audio = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($texto_audio) . "&tl=pt-BR&client=tw-ob";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Depoimentos - Accessibility Fitness</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* Estilos essenciais para a troca de tema funcionar */
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste section { border-color: yellow !important; }
    body.tema-alto-contraste a { color: #00FF00 !important; }

    /* Barra de Acessibilidade */
    #barra-acessibilidade { padding: 10px; background: #eee; text-align: center; border-bottom: 2px solid #ccc; }
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 1px solid yellow; }
    
    .btn-acess {
        text-decoration: none; padding: 5px 10px; background: #007bff; color: white; 
        border-radius: 4px; margin: 0 5px; display: inline-block;
    }

    /* Caixa de Descrição */
    .descricao-detalhada {
        background-color: #f8f9fa;
        padding: 15px;
        border-left: 5px solid #28a745; /* Verde para diferenciar */
        margin-top: 10px;
    }
    body.tema-alto-contraste .descricao-detalhada { background-color: #222; border-left-color: yellow; }
  </style>
</head>

<body class="pg-interna com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

  <div id="barra-acessibilidade">
    <a href="<?php echo criarLink(['fonte' => 'grande']); ?>" class="btn-acess" aria-label="Aumentar fonte">A+</a>
    <a href="<?php echo criarLink(['fonte' => 'medio']); ?>" class="btn-acess" aria-label="Fonte normal">A</a>
    <a href="<?php echo criarLink(['fonte' => 'pequeno']); ?>" class="btn-acess" aria-label="Diminuir fonte">A-</a>

    <?php if($tema_atual == 'padrao'): ?>
        <a href="<?php echo criarLink(['tema' => 'alto-contraste']); ?>" class="btn-acess">⚡ Contraste</a>
    <?php else: ?>
        <a href="<?php echo criarLink(['tema' => 'padrao']); ?>" class="btn-acess">⚪ Normal</a>
    <?php endif; ?>

    <?php if($ler_texto == 'sim'): ?>
        <a href="<?php echo criarLink(['ler' => 'nao']); ?>" class="btn-acess" style="background:red">⏹️ Parar Áudio</a>
        <div style="margin-top:10px;">
            <audio controls autoplay>
                <source src="<?php echo $url_audio; ?>" type="audio/mpeg">
            </audio>
        </div>
    <?php else: ?>
        <a href="<?php echo criarLink(['ler' => 'sim']); ?>" class="btn-acess">🔊 Ouvir Página</a>
    <?php endif; ?>
  </div>

  <main>
    <h1>Depoimentos</h1>
    
    <section class="info-box">
      <h2>História do Fabiano</h2>
      
      <video controls width="100%">
        <source src="videos/video2.mp4" type="video/mp4">
        Seu navegador não suporta vídeos.
      </video>

      <p style="font-weight: bold; margin-top: 10px;">Tema: Treino de resistência e superação.</p>

      <div class="descricao-detalhada">
        <h3>Audiodescrição (O que acontece no vídeo):</h3>
        <p>
            O vídeo mostra Fabiano na academia. Ele está sentado em um aparelho de musculação, vestindo camiseta cinza. 
            Ele realiza movimentos de puxada com os braços, demonstrando esforço e controle da respiração. 
            Ao fundo, é possível ver outros equipamentos de ginástica.
        </p>
      </div>

    </section>
  </main>

  </body>
</html>

