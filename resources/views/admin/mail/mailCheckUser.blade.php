<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Thông Báo Hết Hạn Tài Khoản</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f7fc;
      margin: 0;
      padding: 0;
    }
    .email-wrapper {
      max-width: 600px;
      margin: 0 auto;
      background-color: #fff;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      padding: 30px;
      text-align: center;
    }
    .email-header {
      background: linear-gradient(90deg, #FF5722, #FF007A);
      color: #fff;
      padding: 20px;
      border-radius: 8px 8px 0 0;
    }
    .email-header h2 {
      margin: 0;
      font-size: 24px;
    }
    .email-content {
      margin-top: 20px;
      color: #333;
      font-size: 16px;
      line-height: 1.6;
    }
    .email-content p {
      margin: 15px 0;
    }
    .email-content strong {
      color: #FF5722;
    }
    .cta-button {
      background: linear-gradient(90deg, #FF5722, #FF007A);
      color: white;
      padding: 12px 20px;
      text-decoration: none;
      border-radius: 30px;
      font-size: 18px;
      margin-top: 20px;
      display: inline-block;
      transition: box-shadow 0.3s;
    }
    .cta-button:hover {
      box-shadow: 0 4px 15px rgba(255, 87, 34, 0.5);
    }
    .footer {
      margin-top: 40px;
      font-size: 14px;
      color: #888;
    }
  </style>
</head>
<body>
  <div class="email-wrapper">
    <div class="email-header">
      <h2>Thông Báo Hết Hạn Tài Khoản</h2>
    </div>
    <div class="email-content">
      <p>Xin chào, <strong>{{$name}}</strong></p>
      <p>Tài khoản của bạn đã hết hạn vào ngày: <strong>{{ $date }}</strong></p>
      <p>Loại tài khoản <strong>{{$users_type}}</strong> của bạn đã bị hạ cấp xuống tài khoản <strong>Basic</strong>.</p>
      <p>Để nâng cấp tài khoản và tiếp tục trải nghiệm các dịch vụ, vui lòng truy cập vào <a style="color: white;" href="https://soundwave.io.vn/" class="cta-button">SoundWave</a></p>
    </div>
    <div class="footer">
      <p>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</p>
    </div>
  </div>
</body>
</html>