<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>メールアドレス確認</title>
    <link rel="stylesheet" href="{{ asset('css/verify.css') }}">
</head>
<body>
    <div class="rese__content">
        <div class="message-box">
            <p>{{ $user->name }}さん</p>
            <p>以下のリンクをクリックしてメールアドレスを<br>確認してください。</p>
            <a href="{{ route('verify', ['email' => $user->email, 'token' => $token]) }}">メールアドレスを確認</a>
        </div>
    </div>
</body>
</html>
