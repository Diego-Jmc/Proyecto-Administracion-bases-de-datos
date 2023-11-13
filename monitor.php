<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monitor de consumo de memoria </title>
    <script src="https://d3js.org/d3.v6.min.js"></script>
    <link rel="stylesheet" href="./styles.css" >
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">




</head>
<body>

    

    <div class="container">

    <h2>Monitor de la memoria del buffer de ORACLE</h2>
    <h3>
      Servidor Actual:
    <?php
    $server = $_GET['host'];
    echo $server;
    ?>
         </h3>

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

    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#open-analysis-modal">
    Tabla de análisis
</button>



    <div class="modal" id="open-analysis-modal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Large Analysis Modal</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        


      <h3>Análisis de tendencia</h3>

<form id="analysis-form">

<div class="input-daterange">

<div class="form-group">
 <label for="fecha">De</label>
 <input type="date" class="form-control" id="fecha1" name="fecha1">
</div>

<div class="form-group">
 <label for="fecha">A</label>
 <input type="date" class="form-control" id="fecha2" name="fecha2">
</div>



</div>


   <button type="submit" class="btn btn-dark"> Ver análisis </button>





</form>





<div class="graphs-container">


<div class="graphics-chart-container">

<div id="bar-grafics"></div>
<div id="bar-grafics-description"></div>

</div>

<div id="circular-graphics-container">

<div id="circular-grafics"></div>
<div id="circular-grafics-description"></div>


</div>



</div>



      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>






    </div>


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

  <tbody id='cblog-body'>

  </tbody>






</table>

    </div>


    <?php

    ?>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="./app.js"> </script>
<script src="./analysis.js"> </script>

</body>
</html>
