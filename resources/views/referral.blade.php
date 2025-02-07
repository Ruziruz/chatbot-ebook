<!DOCTYPE html>
<html lang="en">
<head>
    <title>Masukkan Kode Referal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            background-color: #006d5b;
            color: white;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        input, button {
            font-size: 16px;
            padding: 10px;
            margin: 10px;
            border-radius: 5px;
            border: none;
        }
        button {
            background-color: #00a582;
            color: white;
            cursor: pointer;
        }
        button:hover {
            background-color: #008f6f;
        }
    </style>
</head>
<body>
    <h1>Masukkan Kode Referal</h1>
    @if ($errors->any())
        <p style="color: red;">{{ $errors->first() }}</p>
    @endif
    <form method="POST" action="/referral">
        @csrf
        <input type="text" name="code" placeholder="Kode Referal" required>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
