<?php

// Gojo.php - Scanner personalizado desenvolvido por EDUZADA & FARM APOSTAS

// === Cores ===

$reset = "\033[0m";

$azul = "\033[34m";

$vermelho = "\033[31m";

$branco = "\033[97m";

$roxo = "\033[35m";

$amarelo = "\033[33m";

$negrito = "\033[1m";

// Função para imprimir título do scanner

function printHeader() {

    global $azul, $vermelho, $negrito, $reset;

    echo $negrito . $azul . "=========================================\n" . $reset;

    echo $negrito . $vermelho . "             SCANNER EDUZADA              \n" . $reset;

    echo $negrito . $azul . "          Desenvolvido por EDUZADA & FARM APOSTAS\n" . $reset;

    echo $negrito . $azul . "=========================================\n\n" . $reset;

}

// Função para ler opção do usuário

function escolherVersao() {

    global $amarelo, $branco, $reset, $negrito;

    echo $negrito . $amarelo . "Escolha qual Free Fire está jogando:\n" . $reset;

    echo $amarelo . "1 - Free Fire Normal\n";

    echo "2 - Free Fire Max\n" . $reset;

    echo $amarelo . "Opção: " . $reset;

    $handle = fopen("php://stdin", "r");

    $linha = fgets($handle);

    $opcao = trim($linha);

    fclose($handle);

    if ($opcao !== "1" && $opcao !== "2") {

        echo $vermelho . "Opção inválida. Tente novamente.\n" . $reset;

        return escolherVersao();

    }

    return $opcao;

}

// Função para verificar alteração de replays

function verificaReplay($dirReplay) {

    global $azul, $vermelho, $negrito, $reset;

    echo $negrito . $azul . "[+] Checando se o replay foi passado...\n" . $reset;

    $arquivos = glob($dirReplay . "/*.bin");

    if (!$arquivos || count($arquivos) < 2) {

        echo $vermelho . "[-] Diretório de replays está vazio ou com menos de 2 arquivos.\n" . $reset;

        return false;

    }

    rsort($arquivos);

    $penultimo = $arquivos[1];

    $dataModificacao = filemtime($penultimo);

    $agora = time();

    $dif = $agora - $dataModificacao;

    if ($dif > 3600) {

        echo $vermelho . "[-] Replay pode ter sido manipulado (arquivo antigo).\n" . $reset;

        return false;

    } else {

        echo $azul . "[+] Replay está dentro do tempo esperado.\n" . $reset;

        return true;

    }

}

// Função para verificar arquivos na pasta GameSetBundles

function verificaGameSetBundles($dirGSB) {

    global $azul, $vermelho, $negrito, $reset;

    echo $negrito . $azul . "[+] Verificando arquivos GameSetBundles...\n" . $reset;

    $shadersFile = $dirGSB . "/shaders.t4";

    if (!file_exists($shadersFile)) {

        echo $vermelho . "[-] Arquivo shaders.t4 não encontrado em GameSetBundles.\n" . $reset;

        return false;

    } else {

        echo $azul . "[+] Arquivo shaders.t4 encontrado.\n" . $reset;

        return true;

    }

}

// Função para verificar logs do sistema

function verificaLogSistema($pathLog) {

    global $azul, $vermelho, $negrito, $reset;

    echo $negrito . $azul . "[+] Verificando logs do sistema...\n" . $reset;

    if (!file_exists($pathLog)) {

        echo $vermelho . "[-] Log do sistema não encontrado.\n" . $reset;

        return false;

    }

    $logContent = file_get_contents($pathLog);

    if (strpos($logContent, "alterado") !== false) {

        echo $vermelho . "[-] Alterações suspeitas encontradas no log.\n" . $reset;

        return false;

    } else {

        echo $azul . "[+] Logs parecem normais.\n" . $reset;

        return true;

    }

}

// Função para verificar data e hora do sistema/aplicativo

function verificaDataHora($dataInstalacaoApp) {

    global $azul, $vermelho, $negrito, $reset;

    echo $negrito . $azul . "[+] Verificando data e hora de instalação...\n" . $reset;

    $dataAtual = time();

    $diferenca = $dataAtual - $dataInstalacaoApp;

    if ($diferenca < 0) {

        echo $vermelho . "[-] Data de instalação inválida (futura).\n" . $reset;

        return false;

    }

    if ($diferenca > 31536000) {

        echo $vermelho . "[-] Data de instalação muito antiga.\n" . $reset;

        return false;

    }

    echo $azul . "[+] Data de instalação dentro do esperado.\n" . $reset;

    return true;

}

// Função principal

function main() {

    global $azul, $vermelho, $negrito, $reset;

    printHeader();

    $opcao = escolherVersao();

    if ($opcao === "1") {

        // Free Fire Normal

        $pkg = "com.dts.freefireth";

    } else {

        // Free Fire Max

        $pkg = "com.dts.ffmax";

    }

    $diretorioReplay = "/sdcard/Android/data/$pkg/files/MReplays";

    $diretorioGSB = "/sdcard/Android/obb/$pkg/gamesetbundles";

    $pathLog = "/sdcard/Android/data/$pkg/files/logs/system.log";

    $timestampInstalacao = strtotime("-6 months");

    $replayOk = verificaReplay($diretorioReplay);

    $gsbOk = verificaGameSetBundles($diretorioGSB);

    $logOk = verificaLogSistema($pathLog);

    $dataOk = verificaDataHora($timestampInstalacao);

    echo "\n";

    if ($replayOk && $gsbOk && $logOk && $dataOk) {

        echo $negrito . $azul . "[+] ESCANEAMENTO FINALIZADO: SEM ALTERAÇÕES DETECTADAS.\n" . $reset;

    } else {

        echo $negrito . $vermelho . "[-] ESCANEAMENTO FINALIZADO: ALTERAÇÕES DETECTADAS.\n" . $reset;

    }

    echo "\n" . $negrito . $roxo . "     Desenvolvido por EDUZADA & FARM APOSTAS\n" . $reset;

}

main();

?>