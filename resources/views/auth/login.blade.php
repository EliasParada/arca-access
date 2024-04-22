<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
   <link rel="stylesheet" href="{{ asset('css/login.css') }}">  
  <title>Document</title>
</head> 
<body>
  <section>
    <div class="login-box">
      <div style=" margin: 0; padding: 0; position: absolute; top: 15px; left: 10px;">
        <a href="/" style="text-decoration: none;
        padding: 10px; color: black; background-color: #CACCD9; border-radius: 10px;"><em class="fa-solid fa-arrow-left"></em></a>
      </div>
      <form action="{{ route('login') }}" method="POST">
        @csrf
        <h2>Inicio de sesion</h2>
        <div class="input-box">
          <span class="icono"><i class="fa-regular fa-envelope"></i></span>
          <input type="email" name="email">
          <label for="">Correo</label>
        </div>
        <div class="input-box">
          <span class="icono"><i class="fa-solid fa-lock"></i></span>
          <input type="password" name="password">
          <label for="">Contraseña</label>
        </div>
        <div class="recordar-password">
          <label><input type="checkbox" name="rememberme" id="">recordar contraseña</label>
          <a href="#">Olvidaste la contraseña?</a>
        </div>
        <button type="submit">Entrar</button>
        <div class="Registrer">
          <p>No te as registrado?<a href="{{ route('register') }}">Registrate</a></p>
        </div>
      </form>
    </div>
  </section>
</body>
</html>