<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monitor de consumo de memoria </title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://d3js.org/d3.v6.min.js"></script>
    <link rel="stylesheet" href="./styles.css" >
</head>
<body>

    <div class="container">

    <h2>Monitor de la memoria del buffer de ORACLE</h2>
    <svg class="memory-monitor" width="1200" height="400"></svg>


    <div class="d-flex options-buttons">
    <button class="btn btn-success" id="db-mode-btn"> Modo Base de datos </button>
    <button class="btn btn-success" id="random-mode-btn"> Modo simulación </button>
    </div>

    

    <div id="alert" class="alert alert-danger" >
           Alerta de alto consumo!
    </div>

    <div class="cblog-table-container">

    <h2>bitacora CBLog </h2>


    <table class="table">
  <thead class="thead-dark">
    <tr>
    <th scope="col">Day</th>
      <th scope="col">Time</th>
      <th scope="col">Size</th>
      <th scope="col">Used</th>
      <th scope="col">Free</th>
      <th scope="col">Process Id</th>
      <th scope="col">Sql Text</th>

    </tr>
  </thead>


</table>



    </div>



    </div>


    <?php

    ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="./app"></script>
</body>
</html>
