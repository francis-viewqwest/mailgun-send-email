<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
</head>
<style>
  body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    padding: 20px;
  }

  .container {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
  }

  h1 {
    color: #333;
  }

  p {
    color: #555;
  }

  .footer {
    font-size: 12px;
    color: #999;
    margin-top: 20px;
  }
</style>

<body>
  @if ($message_id)
  <div class="container">
    <h1>Message ID: {{ $message_id }}</h1>
    <h1>Replying to your issue... test</h1>
  </div>
  @else
  <div class="container">
    <h1>Your ticket has been updated: {{ $summary }} test</h1>
    <br>
    <p>Status: {{ $status }}</p>
    <br>
    <p>Comments: {{ $comment }}</p>
    <div class="footer">
      &copy; {{ date('Y') }}. All rights reserved.
    </div>
  </div>
  @endif
</body>

</html>