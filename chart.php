<?php
include("funcs/funcs.php");

$filename = "data/data.txt";
$data = ReadFileData($filename);

$chart = new Chart();
$groom = new Chart();
$bride = new Chart();

foreach ($data as $entry) {
    $chart->setData($entry);
    if (in_array('新郎側', $entry)) {
        $groom->setData($entry);
    }
    if (in_array('新婦側', $entry)) {
        $bride->setData($entry);
    }
}

$chartData = [
    ["出席", "欠席", "保留"],
    [$chart->getAttend(), $chart->getAbsent(), $chart->getSuspend()]
];

if (isset($_POST["total"])) {
    $chartData = [
        ["出席", "欠席", "保留"],
        [$chart->getAttend(), $chart->getAbsent(), $chart->getSuspend()]
    ];
} elseif (isset($_POST["groom"])) {
    $chartData = [
        ["出席", "欠席", "保留"],
        [$groom->getAttend(), $groom->getAbsent(), $groom->getSuspend()]
    ];
} elseif (isset($_POST["bride"])) {
    $chartData = [
        ["出席", "欠席", "保留"],
        [$bride->getAttend(), $bride->getAbsent(), $bride->getSuspend()]
    ];
} elseif (isset($_POST["attend"])) {
    $chartData = [
        ["全体", "新郎", "新婦"],
        [$chart->getAttend(), $groom->getAttend(), $bride->getAttend()]
    ];
} elseif (isset($_POST["absent"])) {
    $chartData = [
        ["全体", "新郎", "新婦"],
        [$chart->getAbsent(), $groom->getAbsent(), $bride->getAbsent()]
    ];
} elseif (isset($_POST["suspend"])) {
    $chartData = [
        ["全体", "新郎", "新婦"],
        [$chart->getSuspend(), $groom->getSuspend(), $bride->getSuspend()]
    ];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録しました</title>
    <!-- Load the AJAX API -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        function drawChart() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', '回答結果');
            data.addColumn('number', '回答数');
            data.addRows([
                ["<?php echo $chartData[0][0]; ?>", <?php echo $chartData[1][0]; ?>],
                ["<?php echo $chartData[0][1]; ?>", <?php echo $chartData[1][1]; ?>],
                ["<?php echo $chartData[0][2]; ?>", <?php echo $chartData[1][2]; ?>],
            ]);

            var options = {
                title: '回答状況',
                width: 600,
                height: 500
            };

            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            google.visualization.events.addListener(chart, 'select', function () {
                var selectedItem = chart.getSelection()[0];
                if (selectedItem) {
                    var value = data.getValue(selectedItem.row, 0);
                    alert('選択されたのは ' + value);
                }
            });
            chart.draw(data, options);
        }

        $(document).ready(function () {
            google.charts.load('current', {'packages': ['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            $("#form input").on("click", function () {
                drawChart();
                $("#Popupchart").show();
            });

            $("#Closechart").on("click", function () {
                $("#Popupchart").hide();
            });
        });
    </script>
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
        <div id="Popupchart">
            <div id="form">
                <form action="chart.php" method="post">
                    <input type="submit" name="total" value="全体を表示" />
                    <input type="submit" name="groom" value="新郎側を表示" />
                    <input type="submit" name="bride" value="新婦側を表示" />
                    <input type="submit" name="attend" value="出席数の内訳" />
                    <input type="submit" name="absent" value="欠席数の内訳" />
                    <input type="submit" name="suspend" value="保留数の内訳" />
                </form>
            </div>
            <input type="button" onclick="location.href='./read.php'" value="表に戻る">
            <div id="chart_div"></div>
        </div>
    </header>
</body>
</html>
