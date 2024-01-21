<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Tic-Tac-Toe Game</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: #495057;
            text-align: center;
            margin: 50px;
        }
        h1 {
            color: #007bff;
        }
        #game-container {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        table {
            margin-top: 20px;
            border-collapse: collapse;
            width: 70%;
            max-width: 400px;
        }
        th, td {
            width: 33.33%;
            height: 70px;
            font-size: 24px;
            cursor: pointer;
            background-color: #e9ecef;
            border: 1px solid #dee2e6;
            transition: background-color 0.3s ease;
            position: relative;
        }
        th {
            background-color: #007bff;
            color: #fff;
        }
        .cell-content {
            width: 100%;
            height: 100%;
            font-size: 24px;
            border: none;
            background-color: #e9ecef;
            color: #495057;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background-color 0.3s ease;
        }
        .cell-content:hover {
            background-color: #ced4da;
        }
        .win-line {
            position: absolute;
            width: 100%;
            height: 100%;
            background-color: transparent;
            z-index: -1;
        }
        .win-line.horizontal {
            top: 50%;
            left: 0;
            transform: translateY(-50%);
        }
        .win-line.vertical {
            top: 0;
            left: 50%;
            transform: translateX(-50%);
        }
        .win-line.diagonal-left {
            top: 0;
            left: 0;
        }
        .win-line.diagonal-right {
            top: 0;
            right: 0;
        }
        #result {
            margin-top: 20px;
            font-size: 24px;
        }
        #reset-btn {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 18px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #reset-btn:hover {
            background-color: #218838;
        }
        #player-names-form {
            margin-top: 20px;
        }
        #player-names-form input {
            padding: 10px;
            font-size: 16px;
            margin-right: 10px;
        }
    </style>
</head>
<body>

<?php
session_start();

// Initialize the game state
if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = array_fill(0, 3, array_fill(0, 3, null));
    $_SESSION['currentPlayer'] = 'X';
}

// Process player move
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['row']) && isset($_POST['col'])) {
    $row = $_POST['row'];
    $col = $_POST['col'];

    // Check if the cell is empty and the game is not over
    if ($_SESSION['board'][$row][$col] === null && !isGameOver()) {
        $_SESSION['board'][$row][$col] = $_SESSION['currentPlayer'];
        switchPlayer();
    }
}

// Process player names form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['playerX']) && isset($_POST['playerO'])) {
    $_SESSION['playerX'] = htmlspecialchars($_POST['playerX']);
    $_SESSION['playerO'] = htmlspecialchars($_POST['playerO']);
}

// Display player names form if not set
if (!isset($_SESSION['playerX']) || !isset($_SESSION['playerO'])) {
    echo '<h1>Enter Player Names</h1>';
    echo '<div id="player-names-form">';
    echo '<form method="post">';
    echo '<input type="text" name="playerX" placeholder="Player X" required>';
    echo '<input type="text" name="playerO" placeholder="Player O" required>';
    echo '<button type="submit">Start Game</button>';
    echo '</form>';
    echo '</div>';
    exit; // Stop further execution until names are entered
}

// Display the game board
echo '<h1>Responsive Tic-Tac-Toe Game</h1>';
echo '<div id="game-container">';
echo '<table>';
for ($i = 0; $i < 3; $i++) {
    echo '<tr>';
    for ($j = 0; $j < 3; $j++) {
        echo '<td>';
        echo '<form method="post">';
        echo '<input type="hidden" name="row" value="' . $i . '">';
        echo '<input type="hidden" name="col" value="' . $j . '">';
        echo '<button type="submit" class="cell-content">' . ($_SESSION['board'][$i][$j] ?? '') . '</button>';
        echo '</form>';
        echo '<div class="win-line horizontal"></div>';
        echo '<div class="win-line vertical"></div>';
        echo '<div class="win-line diagonal-left"></div>';
        echo '<div class="win-line diagonal-right"></div>';
        echo '</td>';
    }
    echo '</tr>';
}
echo '</table>';

// Display the winner or current player
if (isGameOver()) {
    $winner = getWinner();
    if ($winner) {
        echo '<div id="result"><strong>' . $_SESSION['player' . $winner] . ' wins!</strong></div>';
        // Highlight the winning line
        highlightWinningLine();
    } else {
        echo '<div id="result">It\'s a draw!</div>';
    }
} else {
    echo '<div id="result"><strong>Current Player:</strong> ' . $_SESSION['player' . $_SESSION['currentPlayer']] . '</div>';
}

// Reset the game button
echo '<form method="post">';
echo '<button id="reset-btn" type="submit" name="reset">Reset Game</button>';
echo '</form>';
echo '</div>';

// Reset the game
if (isset($_POST['reset'])) {
    session_destroy();
    header("Location: {$_SERVER['PHP_SELF']}");
    exit;
}

function switchPlayer() {
    $_SESSION['currentPlayer'] = ($_SESSION['currentPlayer'] === 'X') ? 'O' : 'X';
}

function isGameOver() {
    return isBoardFull() || getWinner();
}

function isBoardFull() {
    foreach ($_SESSION['board'] as $row) {
        if (in_array(null, $row)) {
            return false;
        }
    }
    return true;
}

function getWinner() {
    // Check rows, columns, and diagonals
    for ($i = 0; $i < 3; $i++) {
        if ($_SESSION['board'][$i][0] && $_SESSION['board'][$i][0] === $_SESSION['board'][$i][1] && $_SESSION['board'][$i][1] === $_SESSION['board'][$i][2]) {
            return $_SESSION['board'][$i][0];
        }
        if ($_SESSION['board'][0][$i] && $_SESSION['board'][0][$i] === $_SESSION['board'][1][$i] && $_SESSION['board'][1][$i] === $_SESSION['board'][2][$i]) {
            return $_SESSION['board'][0][$i];
        }
    }

    if ($_SESSION['board'][0][0] && $_SESSION['board'][0][0] === $_SESSION['board'][1][1] && $_SESSION['board'][1][1] === $_SESSION['board'][2][2]) {
        return $_SESSION['board'][0][0];
    }

    if ($_SESSION['board'][0][2] && $_SESSION['board'][0][2] === $_SESSION['board'][1][1] && $_SESSION['board'][1][1] === $_SESSION['board'][2][0]) {
        return $_SESSION['board'][0][2];
    }

    return null;
}

function highlightWinningLine() {
    $winner = getWinner();
    switch ($winner) {
        case 'X':
            echo '<script>document.querySelector(".win-line.horizontal").style.backgroundColor = "#28a745";</script>';
            break;
        case 'O':
            echo '<script>document.querySelector(".win-line.vertical").style.backgroundColor = "#28a745";</script>';
            break;
        default:
            break;
    }
}
?>
</body>
</html>
