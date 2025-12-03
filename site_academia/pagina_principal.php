
<?php
// --- ARQUIVO: pagina_principal.php ---
// Versão ajustada para leitura automática via SpeechSynthesis (funciona em localhost/XAMPP)

// DADOS DOS VÍDEOS
$videosData = [
    'video1' => ['titulo' => 'Treino Funcional Adaptado', 'desc' => 'Experiência inspiradora focada em acessibilidade e treino funcional para cadeirantes.', 'src' => 'videos/video1.mp4'],
    'video2' => ['titulo' => 'Superação na Musculação', 'desc' => 'Atleta com deficiência visual demonstrando técnica correta no supino.', 'src' => 'videos/video2.mp4'],
    'video12' => ['titulo' => 'Dança Inclusiva', 'desc' => 'Show de dança com par misto (cadeirante e andante) em perfeita sintonia.', 'src' => 'videos/video12.mp4'],
    'video19' => ['titulo' => 'Finalização de Treino', 'desc' => 'Alongamento guiado e depoimento final sobre a importância do esporte.', 'src' => 'videos/video19.mp4']
];

// CONFIGURAÇÕES
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

// TEXTO QUE SERÁ LIDO (pelo speechSynthesis)
$texto_audio = "Bem-vindo ao Accessibility Fitness. Conheça nosso propósito, veja experiências inspiradoras e entenda como a inclusão transforma vidas.";
if ($video_selecionado && isset($videosData[$video_selecionado])) {
    $texto_audio = "Você selecionou o vídeo: " . $videosData[$video_selecionado]['titulo'] . ". " . $videosData[$video_selecionado]['desc'];
}

// Passa o texto para o JS com json_encode (seguro)
$texto_audio_json = json_encode($texto_audio, JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP);
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Accessibility Fitness - Guia de Exercícios</title>
  <link rel="stylesheet" href="style.css">
  <style>
    /* estilos mínimos para o botão fallback e status */
    #ttsFallbackBtn {
      display: none;
      margin: 10px auto;
      padding: 10px 16px;
      background: #007bff;
      color: #fff;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-weight: bold;
    }
    #ttsStatus { text-align:center; margin-top:6px; font-size:0.95rem; color:#fff; }
  </style>
</head>
<body class="pg-sobre com-barra fonte-<?php echo htmlspecialchars($tamanho_fonte); ?> tema-<?php echo htmlspecialchars($tema_atual); ?>">

<!-- Botão visível caso o autoplay falhe -->
<div style="text-align:center; margin-top:8px;">
  <button id="ttsFallbackBtn" aria-label="Tocar áudio de leitura">🔊 Tocar Áudio</button>
  <div id="ttsStatus" aria-live="polite"></div>
</div>

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
    <?php else: ?>
        <a href="<?php echo criarLink(['ler' => 'sim']); ?>" class="btn-acess">🔊 Ouvir</a>
    <?php endif; ?>
</div>

<div class="container sobre-container">
  <div class="imagem-main">
    <div class="centralizado">
      <h1 class="titulo-branco">Bem-vindo ao Accessibility Fitness</h1>
      <p>Academia acessível para pessoas com deficiência visual.</p>
    </div>

    <section class="sobre-texto">
      <h2 class="titulo-amarelo">Acessibilidade: Nosso Compromisso</h2>
      <p>O <strong>Accessibility Fitness</strong> nasceu com um propósito claro: transformar o universo do treino em um espaço onde todos possam participar.</p>

      <h2 class="titulo-vermelho">Quando a Inclusão Enxerga o Invisível</h2>
      <p><strong>Acessibilidade não é favor, é direito!</strong> Todos têm o poder de transformar o próprio corpo.</p>
    </section>

    <p>"A verdadeira mudança não começa nos músculos, mas na mente. Cada repetição é uma escolha..."</p>
  </div>

  <hr>
  <h2 class="titulo-triste" id="oi">Experiências Inspiradoras</h2>
  <p id="escolha">Escolha uma história abaixo e clique em "Assistir".</p>

  <form action="#video-area" method="GET" style="margin-bottom: 20px;">
    <input type="hidden" name="tema" value="<?php echo $tema_atual; ?>">
    <input type="hidden" name="fonte" value="<?php echo $tamanho_fonte; ?>">

    <label for="videoSelect" style="font-weight:bold;">Selecione um vídeo:</label><br>
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
    </video>
  </div>

  <img src="https://cdn.pixabay.com/photo/2023/02/23/08/24/trainer-7808159_1280.jpg" alt="">
  <img src="https://cdn.pixabay.com/photo/2013/02/26/02/14/exercise-86200_1280.jpg" alt="">
  <img src="https://cdn.pixabay.com/photo/2021/12/23/05/05/woman-6888634_1280.jpg" alt="">
  <?php endif; ?>

  <hr>
  <h2>Navegação</h2>
 <nav class="menu-navegacao">
    <a class="botao-menu" href="index.php">Voltar ao Menu Principal</a>
    <a class="botao-menu" href="treinos.html">Treinos</a>
    <a class="botao-menu" href="suplementos.html">Suplementos</a>
    <a class="botao-menu" href="lutas.php">Lutas</a>
    <a class="botao-menu" href="danca.php">Dança</a>
    <a class="botao-menu" href="anabolizantes.php">Anabolizantes</a>
    <a class="botao-menu" href="depoimentos.php">Depoimentos</a>
    <a class="botao-menu" href="contato.html">Contato</a>
</nav>

  <br>
  <p class="texto-tts">Use os botões da barra superior para ajustar a acessibilidade.</p>
</div>

<footer class="sobre-rodape" style="text-align:center; margin-top:30px;">
</footer>

<link rel="stylesheet" href="pagina_principal.css">

<script>
/*
  Fluxo de leitura:
  1) tenta iniciar speechSynthesis imediatamente;
  2) se vozes ainda não carregaram, espera onvoiceschanged;
  3) se o browser bloquear a fala automática, aguarda primeiro gesto do usuário;
  4) botão #ttsFallbackBtn aparece para o usuário caso precise clicar.
*/

// Texto vindo do PHP
const textoAudio = <?php echo $texto_audio_json; ?>;

(function() {
  const fallbackBtn = document.getElementById('ttsFallbackBtn');
  const status = document.getElementById('ttsStatus');
  let started = false;

  function speakText() {
    if (!('speechSynthesis' in window)) {
      status.textContent = "Leitura não suportada neste navegador.";
      fallbackBtn.style.display = 'inline-block';
      return false;
    }

    // cancelar qualquer fala anterior
    speechSynthesis.cancel();

    const utter = new SpeechSynthesisUtterance(textoAudio);
    utter.lang = 'pt-BR';
    utter.rate = 1;
    utter.pitch = 1;

    // tentar selecionar voz pt-BR (se disponível)
    const voices = speechSynthesis.getVoices();
    const vozBR = voices.find(v => v.lang && v.lang.startsWith('pt'));
    if (vozBR) utter.voice = vozBR;

    utter.onstart = () => {
      started = true;
      status.textContent = "Lendo...";
      fallbackBtn.style.display = 'none';
    };
    utter.onend = () => {
      status.textContent = "Leitura finalizada.";
    };
    utter.onerror = (e) => {
      console.error('Erro na leitura:', e);
      status.textContent = "Erro ao ler o texto.";
      fallbackBtn.style.display = 'inline-block';
    };

    try {
      speechSynthesis.speak(utter);
      return true;
    } catch (e) {
      console.warn('speechSynthesis.speak falhou:', e);
      return false;
    }
  }

  // Se vozes não estiverem carregadas, aguarda o evento
  function startWhenVoicesReady() {
    if (speechSynthesis.getVoices().length === 0) {
      // vozes serão carregadas em breve
      speechSynthesis.onvoiceschanged = function() {
        if (!started) {
          const ok = speakText();
          if (!ok) showFallback();
        }
      };
    } else {
      const ok = speakText();
      if (!ok) showFallback();
    }
  }

  function showFallback() {
    fallbackBtn.style.display = 'inline-block';
    status.textContent = "Clique em 'Tocar Áudio' para ouvir (ou interaja com a página).";
  }

  // Se o browser bloqueou a leitura automática, inicia na primeira interação do usuário
  function attachOneGestureStart() {
    const events = ['click','touchstart','keydown','mousemove'];
    const handler = function() {
      if (!started) {
        const ok = speakText();
        if (!ok) showFallback();
      }
      // remover listeners
      events.forEach(ev => document.body.removeEventListener(ev, handler));
    };
    events.forEach(ev => document.body.addEventListener(ev, handler, { once: true }));
  }

  // Botão de fallback
  fallbackBtn.addEventListener('click', function() {
    status.textContent = "Tentando tocar...";
    const ok = speakText();
    if (!ok) {
      status.textContent = "Não foi possível iniciar automaticamente. Tente interagir com a página.";
    }
  });

  // Inicia o fluxo após DOM carregado
  document.addEventListener('DOMContentLoaded', function() {
    // Se você deseja que apenas ?ler=sim inicie, descomente abaixo e comente as próximas linhas.
    // if (<?php echo ($ler_texto === 'sim') ? 'true' : 'false'; ?>) { startWhenVoicesReady(); attachOneGestureStart(); return; }

    startWhenVoicesReady();
    attachOneGestureStart();
  });

})();
</script>

</body>
</html>
