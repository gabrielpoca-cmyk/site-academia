<?php
// --- LÓGICA PHP ---

// 1. Dados dos Vídeos
$videosData = [
    'video1' => [
        'titulo' => "Treino Adaptado de Musculação",
        'desc' => "Vídeo mostrando como um treino de musculação pode ser adaptado...",
        'src' => "videos/video1.mp4"
    ],
    'video2' => [
        'titulo' => "Aula de Dança Inclusiva",
        'desc' => "Vídeo de uma aula de dança inclusiva, mostrando movimentos adaptados...",
        'src' => "videos/video2.mp4"
    ],
    'video3' => [
        'titulo' => "Artes Marciais Adaptadas",
        'desc' => "Vídeo de artes marciais adaptadas, explicando técnicas seguras...",
        'src' => "videos/video3.mp4"
    ]
];

// 2. Captura configurações
$video_escolhido = isset($_GET['video']) ? $_GET['video'] : '';
$tema_atual = isset($_GET['tema']) ? $_GET['tema'] : 'padrao';
$tamanho_fonte = isset($_GET['fonte']) ? $_GET['fonte'] : 'medio';
$ler_texto = isset($_GET['ler']) ? $_GET['ler'] : 'nao';

// 3. Função para manter a URL organizada
function criarLink($params) {
    global $video_escolhido, $tema_atual, $tamanho_fonte, $ler_texto;
    
    // Mescla os parâmetros atuais com os novos
    $novos = array_merge([
        'video' => $video_escolhido,
        'tema' => $tema_atual,
        'fonte' => $tamanho_fonte,
        'ler' => 'nao' // Por padrão, ao navegar, para de ler
    ], $params);
    
    return "?" . http_build_query($novos);
}

// 4. Lógica de Leitura (TTS via MP3)
// Texto resumido para caber na URL da API gratuita
$texto_principal = "Bem-vindo ao Accessibility Fitness. Academia acessível para pessoas com deficiência visual. " .
                   "Nosso site oferece conteúdo sobre treinos, suplementos e saúde. " .
                   "Use a navegação abaixo para escolher vídeos de treino adaptado, dança inclusiva ou artes marciais.";

// Codifica o texto para URL
$texto_encoded = urlencode($texto_principal);
// Link para gerar áudio (Google TTS API não oficial mas funcional para testes)
$url_audio = "https://translate.google.com/translate_tts?ie=UTF-8&q={$texto_encoded}&tl=pt-BR&client=tw-ob";

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Accessibility Fitness</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* Estilos Básicos e Temas */
    body { font-family: sans-serif; line-height: 1.6; }
    
    /* Tamanhos */
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    /* Contraste */
    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste a { color: #00FF00 !important; }
    body.tema-alto-contraste .btn-acess { border: 1px solid white; background: #333; color: yellow; }
    
    /* Barra */
    #barra-acessibilidade { padding: 15px; background: #f0f0f0; border-bottom: 2px solid #ccc; text-align: center; }
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 1px solid yellow; }

    .btn-acess {
        display: inline-block; text-decoration: none; padding: 8px 12px;
        background: #0056b3; color: white; border-radius: 4px; margin: 0 4px;
    }
    .player-oculto { width: 100%; margin-top: 10px; }
  </style>
</head>

<body class="pg-sobre com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

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
        <a href="<?php echo criarLink(['ler' => 'nao']); ?>" class="btn-acess" style="background:red;">⏹️ Parar</a>
        <div style="margin-top: 10px;">
            <audio controls autoplay>
                <source src="<?php echo $url_audio; ?>" type="audio/mpeg">
                Seu navegador não suporta áudio.
            </audio>
            <p><small>Lendo a página...</small></p>
        </div>
    <?php else: ?>
        <a href="<?php echo criarLink(['ler' => 'sim']); ?>" class="btn-acess">🔊 Ouvir Texto</a>
    <?php endif; ?>
  </div>

  <div class="container sobre-container">
    <h1>Bem-vindo ao Accessibility Fitness</h1>
    <p>Academia acessível para pessoas com deficiência visual.</p>

    <figure>
      <img src="IMG/tela_oficial.png" alt="Dois fisiculturistas segurando a Terra" style="max-width: 100%; height: auto;">
      <figcaption>
        A cena mostra dois fisiculturistas de corpo inteiro... (Descrição completa para leitor de tela)
      </figcaption>
    </figure>

    <h2 class="titulo-amarelo">Acessibilidade: Nosso Compromisso</h2>
    <p>
      O <strong>Accessibility Fitness</strong> foi criado para pessoas com deficiência visual, focando na inclusão.
    </p>

    <hr>
    <h2>Experiências Inspiradoras</h2>
    <form action="" method="GET">
        <input type="hidden" name="tema" value="<?php echo $tema_atual; ?>">
        <input type="hidden" name="fonte" value="<?php echo $tamanho_fonte; ?>">

        <label for="videoSelect">Escolha um vídeo:</label>
        <select id="videoSelect" name="video">
            <option value="">-- Selecione --</option>
            <option value="video1" <?php if($video_escolhido == 'video1') echo 'selected'; ?>>Treino Adaptado</option>
            <option value="video2" <?php if($video_escolhido == 'video2') echo 'selected'; ?>>Dança Inclusiva</option>
            <option value="video3" <?php if($video_escolhido == 'video3') echo 'selected'; ?>>Artes Marciais</option>
        </select>
        <button type="submit" class="btn-acess">Visualizar Vídeo</button>
    </form>

    <?php if ($video_escolhido && isset($videosData[$video_escolhido])): ?>
        <div id="area-video" style="margin-top:20px; border: 1px solid #ccc; padding:10px;">
            <h3><?php echo $videosData[$video_escolhido]['titulo']; ?></h3>
            <p><em><?php echo $videosData[$video_escolhido]['desc']; ?></em></p>
            <video controls width="100%">
                <source src="<?php echo $videosData[$video_escolhido]['src']; ?>" type="video/mp4">
            </video>
        </div>
    <?php endif; ?>

    <hr>
    <nav>
        <a href="treino.html">Treinos</a> |
        <a href="suplementos.html">Suplementos</a> |
        <a href="contato.html">Contato</a>
    </nav>
  </div>

</body>
</html>



