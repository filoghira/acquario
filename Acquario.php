<?php
session_start();

// Ghirardini Filippo 5AIN 10/03/2022

function init($height, $width): array
{

    $_SESSION['counter'] = 0;
    $_SESSION['h']=$height;
    $_SESSION['w']=$width;

    $nFish_1 = 5;
    $nFih_2 = 5;

    $matrix = array_fill(0, $height, array_fill(0, $width, 0));

    for ($i=0; $i <= $nFish_1; $i++) {
        try {
            $matrix[random_int(0, $height)][random_int(0, $width)] = 1;
        } catch (Exception $e) {
            $i--;
        }
    }

    for ($i=0; $i <= $nFih_2; $i++) {
        try {
            $matrix[random_int(0, $height)][random_int(0, $width)] = 2;
        } catch (Exception $e) {
            $i--;
        }
    }

    return $matrix;
}

function move_fishes(){
    $matrix = $_SESSION['acquario'];
    $h = $_SESSION['h'];
    $w = $_SESSION['w'];

    for ($i=0; $i < $h; $i++) {
        for ($j = 0; $j < $w; $j++) {
            // Move fishes to a random direction
            try {
                $dir = random_int(0, 3);

                if (valid_direction($i, $j, $dir, $matrix)) {

                    switch ($dir) {
                        // Up
                        case 0:
                            $temp = $matrix[$i][$j];
                            $matrix[$i - 1][$j] = $temp;
                            break;
                        // Right
                        case 1:
                            $temp = $matrix[$i][$j];
                            $matrix[$i][$j + 1] = $temp;
                            break;
                        // Down
                        case 2:
                            $temp = $matrix[$i][$j];
                            $matrix[$i + 1][$j] = $temp;
                            break;
                        // Left
                        case 3:
                            $temp = $matrix[$i][$j];
                            $matrix[$i][$j - 1] = $temp;
                            break;
                    }
                    $matrix[$i][$j] = 0;
                }
            } catch (Exception $e) {
                $j--;
            }
        }
    }

    $_SESSION['acquario'] = $matrix;
}

function valid_direction($i, $j, $dir, $matrix): bool
{
    if ($matrix[$i][$j] === 0) {
        return false;
    }
    $h = $_SESSION['h'];
    $w = $_SESSION['w'];

    return match ($dir) {
        // Up
        0 => ($i > 0 && $matrix[$i - 1][$j] === 0),
        // Right
        1 => ($j < ($w - 1) && $matrix[$i][$j + 1] === 0),
        // Down
        2 => ($i < ($h - 1)) && $matrix[$i + 1][$j] === 0,
        // Left
        3 => ($j > 0 && $matrix[$i][$j - 1] === 0),
        default => false,
    };
}

function print_matrix($matrix){
    echo "<table>";
    for ($i=0; $i < $_SESSION['h']; $i++) {
        echo "<tr>";
        for ($j=0; $j < $_SESSION['w']; $j++) {
            echo "<td><img src='images/" . $matrix[$i][$j] . ".png' height='50%' width='50%' alt='lol'></td>";
        }
        echo "</tr>";
    }
    echo "</table>";
}

header("Refresh: 1; URL=".$_SERVER['REQUEST_URI']);

if (!isset($_SESSION['counter'])) {
    $_SESSION['acquario'] = init(10, 10);
}
else {
    move_fishes();
    $_SESSION['counter']++;
}
?>

<!doctype html>
<html lang="it">
<head>
    <link rel='stylesheet' href='style/style.css'>
    <title>Acquario</title>
</head>
<body>
<?php
print_matrix( $_SESSION['acquario']);
?>

</body>
</html>