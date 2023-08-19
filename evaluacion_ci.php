<?php
include 'includes/connect.php';


define("YES", "yes");
define("NO", "no");
define("NA", "na");

// fetch content 1
$sql = "SELECT * FROM contents WHERE number = 1";
$result = $connect->query($sql);


if ($result->num_rows > 0) {
    $contentRow = $result->fetch_assoc();

} else {
    echo "No se encontraron resultados.";
}

class Question {
    public $number;
    public $text;
    public $question_result = "";
    public $process;


    public function __construct($number, $text,$process) {
        $this->number = $number;
        $this->text = $text;
        $this->process = $process;
    }

    public function getNumber() {
        return $this->number;
    }

    public function getText() {
        return $this->text;
    }

    public function getQuestionResult() {
        return $this->question_result;
    }

    public function setQuestionResult($result) {
        $this->question_result = $result;
    }
}



$get_questions_query = "select * from questionary_questions where fk_content_id = 1";
$questions_result = mysqli_query($connect, $get_questions_query);

$questions = array();

if ($questions_result && mysqli_num_rows($questions_result) > 0) {
    // Map questions to Question objects and add them to the array
    while ($row = mysqli_fetch_assoc($questions_result)) {
        $question = new Question($row["number"], $row["question"],$row["it_process"]);
        $questions[] = $question;
    }

    
} else {
    echo "No questions associated with content ID 1 found in the database.";
}





?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Control Interno</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <script src="js/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" type="text/css" href="css/styles.css">


</head>
<body>
    <script src="js/bootstrap.min.js"></script>
    
    <div class="container">

    <div class="content-description">
    <h3><?php echo $contentRow["name"]; ?></h3>
    <p><?php echo $contentRow["description"]; ?></p>
    </div>




    <div class="container questions-container">

    <div class="table-responsive table/hover" id="TablaConsulta">
        <table class="table questions-table">
            <thead class="thead-dark">
                <th class="text-center">Número</th>
                <th class="text-center">Objetivo</th>
                <th class="text-center">Sí</th>
                <th class="text-center">No</th>
                <th class="text-center">N/A</th>
            </thead>
            <tbody>


    <tr>
        <td colspan="5">P01 : Definir un plan estratégico de TI</td>
        <?php
     
    foreach ($questions as $question) {
        if ($question->process == "Definir un plan estratégico de TI") {
            echo "<tr>";
            echo "<td class='question-tr'>" .  $question->number. "</td>";
            echo "<td>" . $question->text . "</td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='si'></td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='no'></td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='na'></td>";
            echo "</tr>";
            
        }
    }
    ?>
    </tr>

    
    <tr>
        <td colspan="5">P02 : Definir la arquitectura de la información</td>
        <?php
            
    foreach ($questions as $question) {
        if ($question->process == "Definir la arquitectura de la información") {
            echo "<tr>";
            echo "<td class='question-tr'>" . $question->number . "</td>";
            echo "<td>" . $question->text . "</td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='si'></td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='no'></td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='na'></td>";
            echo "</tr>";
           
        }
    }
    ?>
    </tr>
    
    <tr>
        <td colspan="5">P03 : Gestionar la adquisición y la implementación</td>
        <?php
            
    foreach ($questions as $question) {
        if ($question->process == "Gestionar la adquisición y la implementación") {
            echo "<tr>";
            echo "<td class='question-tr'>" . $question->number . "</td>";
            echo "<td>" . $question->text . "</td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='si'></td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='no'></td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='na'></td>";
            echo "</tr>";
        }
    }
    ?>
    </tr>
    
    <tr>
        <td colspan="5">P04 : Gestionar cambios</td>
        <?php
             
    foreach ($questions as $question) {
        if ($question->process == "Gestionar cambios") {
            echo "<tr>";
            echo "<td class='question-tr'>" . $question->number . "</td>";
            echo "<td>" . $question->text . "</td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='si'></td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='no'></td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='na'></td>";
            echo "</tr>";
            
        }
    }
    ?>
    </tr>
    
    <tr>
        <td colspan="5">P05 : Gestionar operaciones</td>
        <?php
    
    foreach ($questions as $question) {
        if ($question->process == "Gestionar operaciones") {
            echo "<tr>";
            echo "<td class='question-tr'>" . $question->number . "</td>";
            echo "<td>" . $question->text . "</td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='si'></td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='no'></td>";
            echo "<td><input type='radio' name='answer_" . $question->number . "' value='na'></td>";
            echo "</tr>";
   
        }
    }
    ?>
    </tr>

    
</tbody>




        </table>

        <div class="alert alert-warning" role="alert" id="blank-space-alert" class="blank-space-alert">
        Debe marcar todas las respuestas para visualizar los resultados
        </div>

        <button  data-target="#exampleModal" class="btn btn-success" id="evaluate-results-btn"> Evaluate </button>


    </div>

    </div>


    </div>





<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Evaluación del control interno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">



      <canvas id="myChart"></canvas>
      <div id="results">

        </div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

    <script src="app.js"></script>
</body>
</html>
