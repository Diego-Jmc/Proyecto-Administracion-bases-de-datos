<!DOCTYPE html>
<html>
<head>
    <title>Monitor</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://d3js.org/d3.v6.min.js"></script>
    <link rel="stylesheet"  href="./login.css" >
</head>
<body>

  <div class="container d-flex login-container">


  <div>
  <div class="form-group">

  <h1>Monitor de memoria de la base de datos</h1>

<h3>Inicio de sesión</h3>

    <label for="exampleInputEmail1">Usuario</label>
    <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Usuario">
  </div>
  <div class="form-group">
    <label for="exampleInputPassword1">Contraseña</label>
    <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Contraseña">
  </div>

  <div class="form-group">
    <label for="server-select">Servidor</label>
    <select class="form-control" id="server-select">
      <option>Local</option>
      <option>Jesus</option>
      <option>Jose</option>
    </select>
  </div>

  <button  id="open-monitor-btn" class="btn btn-dark open-monitor-btn">Ingresar</button>
</div>


  </div>


  <script src="./login.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>
</html>
