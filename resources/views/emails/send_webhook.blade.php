<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>MailGun Sender</title>
  <style>
    body {
      background-color: #f9f9f9;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      margin: 0;
      color: black;
    }

    .logo {
      width: 256px;
      height: auto;
    }

    .container {
      background: #fff;
      padding: 20px;
      border-radius: 8px;
    }

    .section {
      margin-top: 20px;
    }
    
    .footer {
      margin: auto;
      padding: 16px;
      background-color: #241F21;
      color: white;
      border-top: 2px solid #E51A2C;
      text-align: center;
      font-size: 12px;
    }

    .footer a {
      color: #E51A2C;
      text-decoration: none;
    }
  </style>
</head>

<body>
  <div class="container">
    <img src="https://viewqwest.com/sg/wp-content/uploads/2023/12/aboutlogo.png" class="logo"
      alt="ViewQwest Logo">
    <div class="container">
      <div class="section">
        @if ($in_reply_to)
        <h2>Replying to your issue... </h2>
        <br>
        <h3>In-Reply-To: {{ $in_reply_to }}</h3>
        <h4>Message ID: {{ $message_id }}</h4>
        @else
        <h2>Your ticket has been updated: {{ $summary }}</h2>
        <h3>Message ID: {{ $message_id }}</h3>
        @endif
        
        @if ($status) <p>Status: {{ $status }}</p> @endif
        @if ($comment) <p>Comments: {{ $comment }}</p> @endif
      </div>
    </div>
    <div class="footer">
      Copyright &copy; {{ date('Y') }}. ViewQwest, All rights reserved.
    </div>
  </div>
</body>

</html>