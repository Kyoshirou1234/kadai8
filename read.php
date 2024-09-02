<?PHP
include("funcs/funcs.php");

$filename = "data/data.txt";
$data = ReadFileData($filename);

$filterGuest = isset($_POST['filter_guest']) ? $_POST['filter_guest'] : '';
$filterStatus = isset($_POST['filter_status']) ? $_POST['filter_status'] : '';

$filteredData = array_filter($data, function($row) use ($filterGuest, $filterStatus) {
    $guestMatch = $filterGuest === '' || in_array($filterGuest, $row);
    $statusMatch = $filterStatus === '' || $row[3] === $filterStatus;
    return $guestMatch && $statusMatch;
});

$chart = new chart();
$groom = new chart();
$bride = new chart();

foreach ($filteredData as $row) {
    $chart->setData($row);
    if (in_array('新郎側', $row)) {
        $groom->setData($row);
    }
    if (in_array('新婦側', $row)) {
        $bride->setData($row);
    }
}

$chartData = [
    ["出席","欠席","保留"],
    [$chart->getAttend(),$chart->getAbsent(), $chart->getSuspend()]
];

if (isset($_POST["total"]) && $_POST["total"]) {
    $chartData = [
        ["出席","欠席","保留"],
        [$chart->getAttend(),$chart->getAbsent(), $chart->getSuspend()]
    ];
} elseif (isset($_POST["groom"]) && $_POST["groom"]) {
    $chartData = [
        ["出席","欠席","保留"],
        [$groom->getAttend(),$groom->getAbsent(), $groom->getSuspend()]
    ];
} elseif (isset($_POST["bride"]) && $_POST["bride"]) {
    $chartData = [
        ["出席","欠席","保留"],
        [$bride->getAttend(),$bride->getAbsent(), $bride->getSuspend()]
    ];
} elseif (isset($_POST["attend"]) && $_POST["attend"]) {
    $chartData = [
        ["全体","新郎","新婦"],
        [$chart->getAttend(),$groom->getAttend(), $bride->getAttend()]
    ];
} elseif (isset($_POST["absent"]) && $_POST["absent"]) {
    $chartData = [
        ["全体","新郎","新婦"],
        [$chart->getAbsent(),$groom->getAbsent(), $bride->getAbsent()]
    ];
} elseif (isset($_POST["suspend"]) && $_POST["suspend"]) {
    $chartData = [
        ["全体","新郎","新婦"],
        [$chart->getSuspend(),$groom->getSuspend(), $bride->getSuspend()]
    ];
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>回答状況</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        header {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        header div {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        form {
            margin-bottom: 20px;
        }

        input[type="submit"],
        input[type="button"] {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: #fff;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        @media (max-width: 768px) {
            input[type="submit"],
            input[type="button"] {
                width: 100%;
                padding: 12px;
                font-size: 14px;
                margin: 5px 0;
            }

            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header>
        <div>
            <form action="chart.php" method="post">
                <input type="submit" name="total" value="グラフを表示" />
            </form>
            <input type="button" onclick="location.href='./post_Ver3.php'" value="回答画面に戻る">
        </div>
    </header>

    <form method="post" action="">
        <label for="filter_guest">ゲスト情報でフィルター:</label>
        <select name="filter_guest" id="filter_guest">
            <option value="">全て</option>
            <option value="新郎側" <?php if ($filterGuest === '新郎側') echo 'selected'; ?>>新郎側</option>
            <option value="新婦側" <?php if ($filterGuest === '新婦側') echo 'selected'; ?>>新婦側</option>
        </select>

        <label for="filter_status">出欠でフィルター:</label>
        <select name="filter_status" id="filter_status">
            <option value="">全て</option>
            <option value="出席" <?php if ($filterStatus === '出席') echo 'selected'; ?>>出席</option>
            <option value="欠席" <?php if ($filterStatus === '欠席') echo 'selected'; ?>>欠席</option>
            <option value="保留" <?php if ($filterStatus === '保留') echo 'selected'; ?>>保留</option>
 
        </select>

        <input type="submit" value="フィルター" />
    </form>

    <table>
        <thead>
            <tr>
                <th>名前</th>
                <th>メールアドレス</th>
                <th>ゲスト情報</th>
                <th>出欠</th>
                <th>メッセージ</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($filteredData as $row): ?>
            <tr>
                <td><?php echo htmlspecialchars($row[0]); ?></td>
                <td><?php echo htmlspecialchars($row[1]); ?></td>
                <td><?php echo htmlspecialchars($row[2]); ?></td>
                <td><?php echo htmlspecialchars($row[3]); ?></td>
                <td><?php echo htmlspecialchars($row[4]); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
