<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Math Questions</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg,rgb(210, 215, 216),rgb(213, 218, 223));
            color: #333;
            flex-direction: column;
        }
        .container {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            width: 400px;
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            font-size: 22px;
        }
        input[type="file"], button {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            background: black;
            border: none;
            color: white;
            cursor: pointer;
            transition: 0.3s;
        }
        button:hover {
            background: rgb(210, 215, 216);
            color: black;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
        .logout-container {
            text-align: right;
            width: 400px;
            margin-bottom: 10px;
        }
        .logout-btn {
            background: white;
            width: 25%;
            border: none;
            padding: 8px 15px;
            color: black;
            cursor: pointer;
            border-radius: 5px;
            font-size: 14px;
            transition: 0.3s;
        }
        .logout-btn:hover {
            background: #c82333;
            color: white;
        }
    </style>
</head>
<body>
    @auth
        <div class="logout-container">
            <span>Welcome, {{ auth()->user()->name }}!</span><br>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>

        <div class="container">
            <h2>Import Math Questions</h2>
            @if(session('success'))
                <p class="success">{{ session('success') }}</p>
            @endif
            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" required>
                <button type="submit">Import</button>
            </form>
        </div>
    @else
        <p>Please <a href="{{ route('login') }}">login</a> to access this page.</p>
    @endauth
</body>
</html>