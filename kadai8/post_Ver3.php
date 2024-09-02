<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>sample</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 20px;
        }

        form {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: calc(100% - 22px);
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 15px;
            font-size: 16px;
            box-sizing: border-box;
        }

        input[type="radio"] {
            margin-right: 5px;
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
            margin-top: 10px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover,
        input[type="button"]:hover {
            background-color: #0056b3;
        }

        .radio-group {
            margin-bottom: 15px;
        }

        .radio-group label {
            display: inline;
            margin-right: 20px;
        }

        .error {
            color: #ff0000;
            font-size: 14px;
            margin-bottom: 15px;
        }
    </style>
    <script>
        function validateForm(event) {
            const firstname = document.getElementById('firstname').value.trim();
            const lastname = document.getElementById('lastname').value.trim();
            const mail = document.getElementById('mail').value.trim();
            const guest = document.querySelector('input[name="guest"]:checked');
            const attendance = document.querySelector('input[name="attendance"]:checked');
            const errorElement = document.getElementById('error-message');
            
            // Clear previous error messages
            errorElement.textContent = '';

            // Check for empty required fields
            if (!firstname || !lastname || !mail || !guest || !attendance) {
                errorElement.textContent = 'すべての必須項目に回答してください。';
                event.preventDefault(); // Prevent form submission
            }
        }
    </script>
</head>
<body>
    <form action="write.php" method="post" onsubmit="validateForm(event)">
        <h1>回答フォーム</h1>
        <div id="error-message" class="error"></div>
        <label for="firstname">お名前（姓）：</label>
        <input type="text" id="firstname" name="firstname" value="" required />

        <label for="lastname">お名前（名）：</label>
        <input type="text" id="lastname" name="lastname" value="" required />

        <label for="mail">メールアドレス：</label>
        <input type="email" id="mail" name="mail" value="" required />

        <div class="radio-group">
            <label>ゲスト様：</label>
            <input type="radio" id="guest1" name="guest" value="新郎側" />
            <label for="guest1">新郎</label>
            <input type="radio" id="guest2" name="guest" value="新婦側" />
            <label for="guest2">新婦</label>
        </div>

        <div class="radio-group">
            <label>出欠の確認：</label>
            <input type="radio" id="attendance1" name="attendance" value="出席" />
            <label for="attendance1">出席</label>
            <input type="radio" id="attendance2" name="attendance" value="欠席" />
            <label for="attendance2">欠席</label>
            <input type="radio" id="attendance3" name="attendance" value="保留" />
            <label for="attendance3">保留</label>
        </div>
        <label for="inquiry">メッセージ：</label>
        <textarea name="inquiry" id="inquiry" cols="50" rows="5"></textarea>

        <input type="submit" name="confirm" value="送信" />
    </form>

    <input type="button" onclick="location.href='./read.php'" value="回答状況を確認">
</body>
</html>