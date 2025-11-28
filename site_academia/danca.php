<?php
// --- LÓGICA PHP (Controla a acessibilidade sem JavaScript) ---

// 1. Captura configurações da URL (se não tiver, usa o padrão)
$tema_atual = isset($_GET['tema']) ? $_GET['tema'] : 'padrao';
$tamanho_fonte = isset($_GET['fonte']) ? $_GET['fonte'] : 'medio';
$ler_texto = isset($_GET['ler']) ? $_GET['ler'] : 'nao';

// 2. Função para criar os links sem perder as configurações
function criarLink($params) {
    global $tema_atual, $tamanho_fonte;
    // Pega o estado atual e mistura com o novo pedido
    $novos = array_merge([
        'tema' => $tema_atual,
        'fonte' => $tamanho_fonte,
        'ler' => 'nao' // Reseta o áudio ao navegar para não ficar tocando para sempre
    ], $params);
    return "?" . http_build_query($novos);
}

// 3. Texto que será lido se a pessoa clicar em "Ouvir"
$texto_para_ler = "Você está na página de Dança Inclusiva. " .
                  "Abaixo temos um vídeo de um show especial. " .
                  "Descrição do vídeo: O vídeo mostra um palco iluminado com luzes azuis. " .
                  "Um dançarino cadeirante gira em sincronia com uma bailarina em pé ao som de música clássica.";

// Prepara o link do áudio (Google TTS)
$url_audio = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($texto_para_ler) . "&tl=pt-BR&client=tw-ob";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Dança - Accessibility Fitness</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* Tamanhos de Fonte */
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    /* Alto Contraste */
    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste a { color: #00FF00 !important; }
    body.tema-alto-contraste .info-box { background-color: #333; color: white; border: 1px solid white; }
    body.tema-alto-contraste .descricao-video { background-color: #222; color: yellow; border-left: 4px solid yellow; }

    /* Estilo da Barra */
    #barra-acessibilidade { padding: 10px; background: #eee; text-align: center; border-bottom: 2px solid #ccc; }
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 1px solid yellow; }
    
    .btn-acess {
        text-decoration: none; padding: 5px 10px; background: #007bff; color: white; 
        border-radius: 4px; margin: 0 5px; display: inline-block;
    }
    
    /* Estilo da Descrição do Vídeo */
    .descricao-video {
        margin-top: 15px;
        padding: 15px;
        background-color: #f8f9fa;
        border-left: 5px solid #007bff;
        line-height: 1.5;
    }
  </style>
</head>

<body class="pg-interna com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

  <div id="barra-acessibilidade">
    <span style="margin-right:10px;">Acessibilidade:</span>
    
    <a href="<?php echo criarLink(['fonte' => 'grande']); ?>" class="btn-acess" aria-label="Aumentar fonte">A+</a>
    <a href="<?php echo criarLink(['fonte' => 'medio']); ?>" class="btn-acess" aria-label="Fonte normal">A</a>
    <a href="<?php echo criarLink(['fonte' => 'pequeno']); ?>" class="btn-acess" aria-label="Diminuir fonte">A-</a>

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
            <p><small>Lendo descrição...</small></p>
        </div>
    <?php else: ?>
        <a href="<?php echo criarLink(['ler' => 'sim']); ?>" class="btn-acess">🔊 Ouvir Página</a>
    <?php endif; ?>
  </div>

  <main>
    <h1>Dança Inclusiva</h1>
    
    <div class="info-box">
      <h2>Show Especial</h2>
      
      <video controls width="100%">
        <source src="videos/video12.mp4" type="video/mp4">
        Seu navegador não suporta a tag de vídeo.
      </video>

      <div class="descricao-video">
        <h3>Para cegos e baixa visão: O que acontece no vídeo?</h3>
        <p>
            O vídeo mostra um palco de teatro iluminado com focos de luz azul. 
            No centro, um dançarino em cadeira de rodas, vestido de preto, realiza movimentos de giro rápido em sincronia com uma bailarina que está de pé, vestida de branco.
            Eles se aproximam, dão as mãos e giram juntos. Ao fundo, é possível ouvir a música clássica e, no final, os aplausos da plateia.
        </p>
      </div>

    </div>
  </main>

  </body>
</html>

