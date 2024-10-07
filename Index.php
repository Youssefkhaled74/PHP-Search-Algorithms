<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Algorithms</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4 wow-heading">Choose Search Algorithm</h1>
        <div class="text-center mb-4">
            <h4>Array:</h4>
            <p><?php echo implode(', ', [10, 50, 0, 30, 60, 80, 88, 66, 0, 11, 444, 88, 26, 35, 74, 15, 290]); ?></p>
        </div>
        <form method="POST" action="index.php" class="text-center">
            <select name="algorithm" class="form-control form-control-lg mb-3">
                <option value="linear">Linear Search</option>
                <option value="binary">Binary Search</option>
                <option value="jump">Jump Search</option>
                <option value="exponential">Exponential Search</option>
            </select>
            <input type="number" name="target" placeholder="Enter the target value" class="form-control form-control-lg mb-3" required>
            <button type="submit" class="btn btn-primary btn-lg wow-button">Search</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $array = [10, 50, 0, 30, 60, 80, 88, 66, 0, 11, 444, 88, 26, 35, 74, 15, 290];
            sort($array); // Array needs to be sorted for Binary, Jump, and Exponential search
            $algorithm = $_POST['algorithm'];
            $target = (int)$_POST['target'];

            function linearSearch($arr, $target) {
                foreach ($arr as $index => $value) {
                    if ($value == $target) {
                        return $index;
                    }
                }
                return -1;
            }

            function binarySearch($arr, $target) {
                $low = 0;
                $high = count($arr) - 1;
                while ($low <= $high) {
                    $mid = floor(($low + $high) / 2);
                    if ($arr[$mid] == $target) {
                        return $mid;
                    } elseif ($arr[$mid] < $target) {
                        $low = $mid + 1;
                    } else {
                        $high = $mid - 1;
                    }
                }
                return -1;
            }

            function jumpSearch($arr, $target) {
                $n = count($arr);
                $step = floor(sqrt($n));
                $prev = 0;

                while ($arr[min($step, $n) - 1] < $target) {
                    $prev = $step;
                    $step += floor(sqrt($n));
                    if ($prev >= $n) return -1;
                }

                while ($arr[$prev] < $target) {
                    $prev++;
                    if ($prev == min($step, $n)) return -1;
                }

                if ($arr[$prev] == $target) return $prev;

                return -1;
            }

            function exponentialSearch($arr, $target) {
                if ($arr[0] == $target) return 0;
                $n = count($arr);
                $i = 1;
                while ($i < $n && $arr[$i] <= $target) $i *= 2;

                return binarySearch(array_slice($arr, 0, min($i, $n)), $target);
            }

            switch ($algorithm) {
                case 'linear':
                    $startTime = microtime(true);
                    $result = linearSearch($array, $target);
                    $endTime = microtime(true);
                    $timeComplexity = "O(n)";
                    $spaceComplexity = "O(1)";
                    $requiresSorted = "No";
                    break;

                case 'binary':
                    $startTime = microtime(true);
                    $result = binarySearch($array, $target);
                    $endTime = microtime(true);
                    $timeComplexity = "O(log n)";
                    $spaceComplexity = "O(1)";
                    $requiresSorted = "Yes";
                    break;

                case 'jump':
                    $startTime = microtime(true);
                    $result = jumpSearch($array, $target);
                    $endTime = microtime(true);
                    $timeComplexity = "O(√n)";
                    $spaceComplexity = "O(1)";
                    $requiresSorted = "Yes";
                    break;

                case 'exponential':
                    $startTime = microtime(true);
                    $result = exponentialSearch($array, $target);
                    $endTime = microtime(true);
                    $timeComplexity = "O(log n)";
                    $spaceComplexity = "O(log n)";
                    $requiresSorted = "Yes";
                    break;
            }

            $executionTime = $endTime - $startTime;

            echo "<div class='mt-5 text-center'>";
            if ($result != -1) {
                echo "<h4>Target Found at Index: $result</h4>";
            } else {
                echo "<h4>Target Not Found</h4>";
            }
            echo "<p>Time Complexity: $timeComplexity</p>";
            echo "<p>Space Complexity: $spaceComplexity</p>";
            echo "<p>Requires Sorted Array: $requiresSorted</p>";
            echo "<p>Execution Time: " . number_format($executionTime, 10) . " seconds</p>";
            echo "</div>";
        }
        ?>
    </div>
</body>
</html>
