<?php
// --- ARQUIVO: pagina_principal.php ---

// 1. DADOS DOS VÍDEOS (Substitui o JavaScript antigo)
$videosData = [
    'video1' => ['titulo' => 'Treino Funcional Adaptado', 'desc' => 'Experiência inspiradora focada em acessibilidade e treino funcional para cadeirantes.', 'src' => 'videos/video1.mp4'],
    'video2' => ['titulo' => 'Superação na Musculação', 'desc' => 'Atleta com deficiência visual demonstrando técnica correta no supino.', 'src' => 'videos/video2.mp4'],
    // ... Adicione os outros vídeos aqui (video3, video4...) ...
    'video12' => ['titulo' => 'Dança Inclusiva', 'desc' => 'Show de dança com par misto (cadeirante e andante) em perfeita sintonia.', 'src' => 'videos/video12.mp4'],
    'video19' => ['titulo' => 'Finalização de Treino', 'desc' => 'Alongamento guiado e depoimento final sobre a importância do esporte.', 'src' => 'videos/video19.mp4']
];

// 2. CONFIGURAÇÕES DE ACESSIBILIDADE
$tema_atual = isset($_GET['tema']) ? $_GET['tema'] : 'padrao';
$tamanho_fonte = isset($_GET['fonte']) ? $_GET['fonte'] : 'medio';
$ler_texto = isset($_GET['ler']) ? $_GET['ler'] : 'nao';
$video_selecionado = isset($_GET['video']) ? $_GET['video'] : '';

function criarLink($params) {
    global $tema_atual, $tamanho_fonte, $video_selecionado;
    $novos = array_merge([
        'tema' => $tema_atual,
        'fonte' => $tamanho_fonte,
        'video' => $video_selecionado, 
        'ler' => 'nao' 
    ], $params);
    return "?" . http_build_query($novos);
}

// 3. ÁUDIO DO TEXTO (Resumo da página)
$texto_audio = "Bem-vindo ao Accessibility Fitness. Conheça nosso propósito, veja experiências inspiradoras e entenda como a inclusão transforma vidas.";
if ($video_selecionado && isset($videosData[$video_selecionado])) {
    $texto_audio = "Você selecionou o vídeo: " . $videosData[$video_selecionado]['titulo'] . ". " . $videosData[$video_selecionado]['desc'];
}
$url_audio = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($texto_audio) . "&tl=pt-BR&client=tw-ob";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Accessibility Fitness - Guia de Exercícios</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* --- CSS ACESSIBILIDADE --- */
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste .titulo-amarelo { color: #FFD700 !important; }
    body.tema-alto-contraste .titulo-vermelho { color: #FF4500 !important; }
    body.tema-alto-contraste a { color: #00FF00 !important; }
    body.tema-alto-contraste select, body.tema-alto-contraste button { 
        background-color: #333; color: yellow; border: 1px solid yellow; 
    }
    body.tema-alto-contraste .video-container { border: 2px solid yellow; background: #222; }

    /* Barra Superior */
    #barra-acessibilidade { padding: 15px; background: #f4f4f4; text-align: center; border-bottom: 2px solid #ccc; margin-bottom: 20px;}
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 1px solid yellow; }
    
    .btn-acess {
        text-decoration: none; padding: 8px 12px; background: #007bff; color: white; 
        border-radius: 4px; margin: 0 5px; display: inline-block; font-weight: bold;
    }

    /* Utilitários */
    .centralizado { text-align: center; }
    .video-container { margin-top: 20px; padding: 20px; background: #f9f9f9; border-radius: 8px; border: 1px solid #ddd; }
  </style>
</head>

<body class="pg-sobre com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

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
        <div style="margin-top:15px;">
            <audio controls autoplay>
                <source src="<?php echo $url_audio; ?>" type="audio/mpeg">
            </audio>
            <p><small>Lendo...</small></p>
        </div>
    <?php else: ?>
        <a href="<?php echo criarLink(['ler' => 'sim']); ?>" class="btn-acess">🔊 Ouvir</a>
    <?php endif; ?>
  </div>

  <div class="container sobre-container">
    
    <div class="centralizado">
      <h1>Bem-vindo ao Accessibility Fitness</h1>
      <p>Academia acessível para pessoas com deficiência visual.</p>
    </div>

    <figure>
      <img src="img/tela_oficial.png" alt="Dois fisiculturistas segurando a Terra" style="max-width: 100%; height: auto;">
      <figcaption>
        A cena mostra dois fisiculturistas de corpo inteiro — um homem e uma mulher — posicionados lado a lado, contra um fundo cósmico.
      </figcaption>
    </figure>

    <section class="sobre-texto">
      <h2 class="titulo-amarelo">Acessibilidade: Nosso Compromisso</h2>
      <p>O <strong>Accessibility Fitness</strong> nasceu com um propósito claro: transformar o universo do treino em um espaço onde todos possam participar.</p>

      <h2 class="titulo-vermelho">Quando a Inclusão Enxerga o Invisível</h2>
      <p><strong>Acessibilidade não é favor, é direito!</strong> Todos têm o poder de transformar o próprio corpo.</p>
    </section>

    <hr>
    <h2>Experiências Inspiradoras</h2>
    <p>Escolha uma história abaixo e clique em "Assistir".</p>

    <form action="#video-area" method="GET" style="margin-bottom: 20px;">
        <input type="hidden" name="tema" value="<?php echo $tema_atual; ?>">
        <input type="hidden" name="fonte" value="<?php echo $tamanho_fonte; ?>">

        <label for="videoSelect" style="font-weight:bold;">Selecione um vídeo:</label>
        <br>
        <select id="videoSelect" name="video" style="padding: 10px; font-size: 1rem; margin-top:5px; max-width:100%;">
            <option value="">-- Escolha um vídeo --</option>
            <?php foreach($videosData as $chave => $dados): ?>
                <option value="<?php echo $chave; ?>" <?php if($video_selecionado == $chave) echo 'selected'; ?>>
                    <?php echo $dados['titulo']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        
        <button type="submit" class="btn-acess" style="margin-left: 10px; cursor: pointer;">Assistir</button>
    </form>

    <?php if ($video_selecionado && isset($videosData[$video_selecionado])): ?>
        <div id="video-area" class="video-container" tabindex="-1">
            <h3 style="margin-top:0; color: #007bff;"><?php echo $videosData[$video_selecionado]['titulo']; ?></h3>
            <p><strong>Descrição:</strong> <?php echo $videosData[$video_selecionado]['desc']; ?></p>
            
            <video controls width="100%" style="margin-top:10px;">
                <source src="<?php echo $videosData[$video_selecionado]['src']; ?>" type="video/mp4">
                Seu navegador não suporta a tag de vídeo.
            </video>
        </div>
    <?php endif; ?>

    <hr>
    <h2>Navegação</h2>
    <nav style="line-height: 2;">
        <a href="index.php">Voltar ao Menu Principal</a> | 
        <a href="treinos.html">Treinos</a> | 
        <a href="suplementos.html">Suplementos</a> | 
        <a href="lutas.php">Lutas</a> | 
        <a href="danca.php">Dança</a> | 
        <a href="anabolizantes.php">Anabolizantes</a> | 
        <a href="depoimentos.php">Depoimentos</a> | 
        <a href="contato.html">Contato</a>
    </nav>

    <br>
    <p class="texto-tts">Use os botões da barra superior para ajustar a acessibilidade.</p>
  </div>

  <footer class="sobre-rodape" style="text-align:center; margin-top:30px;">
    <img src="img/imagem_topo_pagina.png" alt="" style="max-width:200px;">
  </footer>

</body>
</html>

