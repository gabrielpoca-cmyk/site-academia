<?php
// --- LÓGICA PHP ---

// 1. Dados dos Suplementos (Substitui o JavaScript)
$suplementosData = [
    'whey' => [
        'nome' => 'Whey Protein',
        'desc' => 'Proteína do soro do leite de rápida absorção. Ideal para consumir após o treino para ajudar na recuperação e construção muscular.'
    ],
    'creatina' => [
        'nome' => 'Creatina',
        'desc' => 'Composto de aminoácidos que aumenta a força e a explosão muscular. Ajuda a treinar com mais intensidade.'
    ],
    'bcaa' => [ // Adicionei mais um exemplo
        'nome' => 'BCAA',
        'desc' => 'Aminoácidos de cadeia ramificada. Ajudam a evitar a fadiga durante o treino e diminuem a dor muscular depois.'
    ]
];

// 2. Configurações de Acessibilidade
$tema_atual = isset($_GET['tema']) ? $_GET['tema'] : 'padrao';
$tamanho_fonte = isset($_GET['fonte']) ? $_GET['fonte'] : 'medio';
$ler_texto = isset($_GET['ler']) ? $_GET['ler'] : 'nao';
$suplemento_escolhido = isset($_GET['suplemento']) ? $_GET['suplemento'] : '';

// 3. Função de Links
function criarLink($params) {
    global $tema_atual, $tamanho_fonte, $suplemento_escolhido;
    $novos = array_merge([
        'tema' => $tema_atual,
        'fonte' => $tamanho_fonte,
        'suplemento' => $suplemento_escolhido,
        'ler' => 'nao'
    ], $params);
    return "?" . http_build_query($novos);
}

// 4. Áudio (TTS)
$texto_audio = "Guia de Suplementos. Selecione: Whey Protein, Creatina ou BCAA para saber mais.";
if ($suplemento_escolhido && isset($suplementosData[$suplemento_escolhido])) {
    $texto_audio = "Você escolheu " . $suplementosData[$suplemento_escolhido]['nome'] . ". " . $suplementosData[$suplemento_escolhido]['desc'];
}
$url_audio = "https://translate.google.com/translate_tts?ie=UTF-8&q=" . urlencode($texto_audio) . "&tl=pt-BR&client=tw-ob";
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <title>Suplementos - Accessibility Fitness</title>
  <link rel="stylesheet" href="style.css">

  <style>
    /* CSS Acessibilidade (Padrão) */
    body.fonte-pequeno { font-size: 14px; }
    body.fonte-medio   { font-size: 18px; }
    body.fonte-grande  { font-size: 24px; }

    body.tema-alto-contraste { background-color: black !important; color: yellow !important; }
    body.tema-alto-contraste select, body.tema-alto-contraste button { 
        background-color: #333; color: yellow; border: 1px solid yellow; 
    }
    body.tema-alto-contraste .info-box { border: 2px solid yellow; background: #222; }
    body.tema-alto-contraste a { color: #00FF00 !important; }

    /* Barra */
    #barra-acessibilidade { padding: 10px; background: #eee; text-align: center; border-bottom: 2px solid #ccc; margin-bottom: 20px;}
    body.tema-alto-contraste #barra-acessibilidade { background: #000; border-bottom: 1px solid yellow; }
    
    .btn-acess {
        text-decoration: none; padding: 5px 10px; background: #007bff; color: white; 
        border-radius: 4px; margin: 0 5px; display: inline-block;
    }
  </style>
</head>

<body class="pg-interna com-barra fonte-<?php echo $tamanho_fonte; ?> tema-<?php echo $tema_atual; ?>">

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

  <main>
    <h1>Guia de Suplementos</h1>
    <p>Descubra qual suplemento é ideal para o seu objetivo:</p>

    <form action="" method="GET">
        <input type="hidden" name="tema" value="<?php echo $tema_atual; ?>">
        <input type="hidden" name="fonte" value="<?php echo $tamanho_fonte; ?>">

        <label for="supplements" style="font-weight:bold;">Escolha o suplemento:</label>
        <br>
        <select id="supplements" name="suplemento" style="padding: 5px; margin-bottom: 10px;">
            <option value="">-- Selecione --</option>
            <option value="whey" <?php if($suplemento_escolhido == 'whey') echo 'selected'; ?>>Whey Protein</option>
            <option value="creatina" <?php if($suplemento_escolhido == 'creatina') echo 'selected'; ?>>Creatina</option>
            <option value="bcaa" <?php if($suplemento_escolhido == 'bcaa') echo 'selected'; ?>>BCAA</option>
        </select>
        
        <button type="submit" class="btn-nav" style="padding: 5px 15px; min-width: auto; min-height: auto;">Ver Informações</button>
    </form>

    <?php if ($suplemento_escolhido && isset($suplementosData[$suplemento_escolhido])): ?>
        <div id="info-supplement" class="info-box">
            <h2><?php echo $suplementosData[$suplemento_escolhido]['nome']; ?></h2>
            <p><?php echo $suplementosData[$suplemento_escolhido]['desc']; ?></p>
        </div>
    <?php endif; ?>

    <hr>
    <a href="index.php?tema=<?php echo $tema_atual; ?>&fonte=<?php echo $tamanho_fonte; ?>">Voltar ao Menu Principal</a>

  </main>

  </body>

</html>

