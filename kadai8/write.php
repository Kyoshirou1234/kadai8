<?PHP
include("funcs/funcs.php");

$firstname = $_POST["firstname"];
$lastname = $_POST["lastname"];
$fullname = "{$firstname} {$lastname}";
$mail = $_POST["mail"];
$attendance = $_POST["attendance"];
$guest = $_POST["guest"];
$inquiry = $_POST["inquiry"];

$c = ",";
$filename = "data/data.txt";
$str = $fullname.$c.$mail.$c.$guest.$c.$attendance.$c.$inquiry;
$fp = fopen($filename, "a" ); 
fwrite($fp, $str."\n");//ファイルに書き込みを開始
fclose($fp);//ファイルを閉じる
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>登録しました</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
            color: #333;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 24px;
            margin: 0;
        }

        h3 {
            color: #007bff;
            margin-top: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f7f7f7;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        input[type="button"] {
            background-color: #007bff;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="button"]:hover {
            background-color: #0056b3;
        }

        @media (max-width: 768px) {
            header {
                padding: 15px;
            }

            table, th, td {
                font-size: 14px;
            }

            input[type="button"] {
                padding: 8px 16px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>ご回答ありがとうございます！</h1>
    </header>

    <div>
        <h3>回答内容</h3>
        <div>
            <table border="1">
                <tr>
                    <th>名前</th>
                    <th>メールアドレス</th>
                    <th>ゲスト情報</th>
                    <th>出欠</th>
                    <th>メッセージ</th>
                </tr>
                <tr>
                    <td><?php echo h($fullname) ?></td>
                    <td><?php echo h($mail) ?></td>
                    <td><?php echo h($guest) ?></td>
                    <td><?php echo h($attendance) ?></td>
                    <td><?php echo h($inquiry) ?></td>
                </tr>
            </table>
            <input type="button" onclick="location.href='./read.php'" value="回答状況を確認">
        </div>
    </div>
</body>
</html>
