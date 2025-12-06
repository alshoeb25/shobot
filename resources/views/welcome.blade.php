<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Sho Bot - Modern AI</title>

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Poppins", sans-serif;
    }

    body, html {
      height: 100%;
      overflow-x: hidden;
      background: #05080f;
    }

    /* MAIN PARALLAX BG */
    .parallax {
      background-image: url("https://images.unsplash.com/photo-1695663428801-d665fb692e8a");
      background-size: cover;
      background-position: center;
      background-attachment: fixed;
      height: 100vh;
      filter: brightness(0.45);
    }

    /* CENTER CONTAINER */
    .hero-content {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      width: 420px;
      padding: 35px;
      background: rgba(255, 255, 255, 0.06);
      border-radius: 20px;
      backdrop-filter: blur(12px);
      border: 1px solid rgba(255, 255, 255, 0.15);
      box-shadow: 0 0 40px rgba(0, 255, 255, 0.2);
      animation: fadeUp 1.3s ease;
    }

    @keyframes fadeUp {
      0% { opacity: 0; transform: translate(-50%, -40%); }
      100% { opacity: 1; transform: translate(-50%, -50%); }
    }

    /* BOT IMAGE (clean subtle AI style) */
    .bot-img {
      width: 150px;
      margin-bottom: 15px;
      filter: drop-shadow(0 0 16px rgba(0,255,255,0.6));
      animation: float 4s infinite ease-in-out;
    }

    @keyframes float {
      0% { transform: translateY(0); }
      50% { transform: translateY(-10px); }
      100% { transform: translateY(0); }
    }

    h1 {
      font-size: 32px;
      margin-bottom: 10px;
      color: #fff;
      text-shadow: 0 0 15px rgba(0,255,255,0.8);
    }

    p {
      font-size: 1rem;
      color: #d9e9ff;
      margin-bottom: 28px;
      opacity: 0.9;
    }

    /* BUTTONS */
    .btn-group {
      display: flex;
      justify-content: center;
      gap: 18px;
    }

    .btn {
      padding: 12px 34px;
      border-radius: 30px;
      background: linear-gradient(90deg, #00f0ff, #00b7ff);
      color: #000;
      font-weight: 600;
      text-decoration: none;
      transition: 0.25s;
      box-shadow: 0 0 18px #00eaff;
    }

    .btn:hover {
      letter-spacing: 1px;
      background: white;
      box-shadow: 0 0 30px white;
    }
  </style>
</head>

<body>

  <!-- PARALLAX BACKGROUND -->
  <div class="parallax"></div>

  <!-- CENTER CONTENT -->
  <div class="hero-content">
    <img src="{{ asset('images/bot-img.png') }}" width="180" height="180" alt="Chatbot">


    <h1>Sho Bot AI</h1>
    <p>Your intelligent assistant that helps you solve, learn & grow.</p>

    <div class="btn-group">
      <a href="/login" class="btn">Login</a>
      <a href="/register" class="btn">Register</a>
    </div>
  </div>

</body>
</html>
