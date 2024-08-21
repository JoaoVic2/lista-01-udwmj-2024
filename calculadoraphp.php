<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculadora</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="calculator">
        <form method="POST">
            <div class="display-container">
                <input type="text" id="display" name="display" value="<?php echo isset($_POST['hiddenDisplay']) ? htmlspecialchars($_POST['hiddenDisplay']) : ''; ?>" readonly>
                <input type="hidden" name="hiddenDisplay" id="hiddenDisplay" value="<?php echo isset($_POST['hiddenDisplay']) ? htmlspecialchars($_POST['hiddenDisplay']) : ''; ?>">
            </div>
            <div class="buttons">
                <button type="submit" name="clear" class="btn operator">C</button>
                <button type="submit" name="delete" class="btn operator">⌫</button>
                <button type="submit" name="operation" value="/" class="btn operator">/</button>
                <button type="submit" name="operation" value="*" class="btn operator">*</button>
                <button type="submit" name="number" value="7" class="btn">7</button>
                <button type="submit" name="number" value="8" class="btn">8</button>
                <button type="submit" name="number" value="9" class="btn">9</button>
                <button type="submit" name="operation" value="-" class="btn operator">-</button>
                <button type="submit" name="number" value="4" class="btn">4</button>
                <button type="submit" name="number" value="5" class="btn">5</button>
                <button type="submit" name="number" value="6" class="btn">6</button>
                <button type="submit" name="operation" value="+" class="btn operator">+</button>
                <button type="submit" name="number" value="1" class="btn">1</button>
                <button type="submit" name="number" value="2" class="btn">2</button>
                <button type="submit" name="number" value="3" class="btn">3</button>
                <button type="submit" name="number" value="0" class="btn zero">0</button>
                <button type="submit" name="number" value="." class="btn">.</button>
                <button type="submit" name="calculate" class="btn equals">=</button>
            </div>
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $display = isset($_POST['hiddenDisplay']) ? $_POST['hiddenDisplay'] : '';

        if (isset($_POST['clear'])) {
            $display = '';
        } elseif (isset($_POST['delete'])) {
            $display = substr($display, 0, -1);
        } elseif (isset($_POST['number']) || isset($_POST['operation'])) {
            $display .= isset($_POST['number']) ? $_POST['number'] : $_POST['operation'];
        } elseif (isset($_POST['calculate'])) {
            try {
                // Verifica se há divisão por zero antes de avaliar a expressão
                if (preg_match('/\/0/', $display)) {
                    throw new Exception('Divisão por zero');
                }
                // Utilizando eval apenas para operações matemáticas simples
                $result = @eval("return $display;");
                if ($result === false) {
                    $display = 'Error';
                } else {
                    $display = $result;
                }
            } catch (Exception $e) {
                $display = 'Error';
            }
        }

        echo "<script>
            document.getElementById('display').value = '" . htmlspecialchars($display) . "';
            document.getElementById('hiddenDisplay').value = '" . htmlspecialchars($display) . "';
        </script>";
    }
    ?>
</body>
</html>
