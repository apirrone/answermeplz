<?php

    if(isset($_POST['submit'])){
        if(!empty($_POST['question']) and !empty($_POST['answ1']) and !empty($_POST['answ2'])){
            $question = $_POST['question'];
            $answ1 = $_POST['answ1'];
            $answ2 = $_POST['answ2'];
            
            pushNewQuestion($question, $answ1, $answ2);
        }
        else{
            echo("Fill all the fields plz\n");
            
        }
    }

    if(isset($_POST['yes'])){
        $id = $_POST['id'];
        incrementQuestion($id, True);
    }

    if(isset($_POST['no'])){
        $id = $_POST['id'];
        incrementQuestion($id, False);
    }

    function pushNewQuestion($question, $answ1, $answ2){
    
        $db = new PDO(
            'mysql:host=mysql.hostinger.fr;dbname=u365392331_quest',
            'u365392331_awa',
            'Zigmartoula1!'
        );
        
        $req = $db->prepare("INSERT INTO  `u365392331_quest`.`Questions` (
                        `question` ,
                        `rep1` ,
                        `rep2`
                        )
                        VALUES (
                        :question,  :rep1,  :rep2
                        );");

        $req->execute( array( 'question' => $question,
                                  'rep1' => $answ1,
                                  'rep2' => $answ2));
        
    }

    function incrementQuestion($id, $rep1){
        $db = new PDO(
            'mysql:host=mysql.hostinger.fr;dbname=u365392331_quest',
            'u365392331_awa',
            'Zigmartoula1!'
        );
        
        if($rep1 == True){
         $req = $db->prepare("UPDATE  `u365392331_quest`.`Questions` SET  `nbrep1` =  `nbrep1`+1 
                    WHERE  `Questions`.`id` =".$id.";");
        }
        else{
             $req = $db->prepare("UPDATE  `u365392331_quest`.`Questions` SET  `nbrep2` =  `nbrep2`+1 
                    WHERE  `Questions`.`id` =".$id.";");
        }
        
        $req->execute();
        
    }


    function getAndDisplayRandomQuestion(){
        $db = new PDO(
            'mysql:host=mysql.hostinger.fr;dbname=u365392331_quest',
            'u365392331_awa',
            'Zigmartoula1!'
        );

        $req = $db->prepare("SELECT * FROM Questions ORDER BY RAND() LIMIT 1");
                $req->execute();
                $result = $req->fetchAll();
        
        $id = $result[0]['id'];
        $question =  $result[0]['question'];
        $answ1 =  $result[0]['rep1'];
        $answ2 =  $result[0]['rep2'];
        $nbAnsw1 =  $result[0]['nbrep1'];
        $nbAnsw2 =  $result[0]['nbrep2'];
        
        echo '<div class="section group question">';
            echo '<p style="text-align: center">';
                echo $question;
            echo'</p>';
        echo '</div>';
        echo '<div class="section group answers">';
            echo '<form method="post" action="index.php" class="col span_1_of_2" >';
                echo '<div class=" yesbutton button">';
                    echo '<input type="int" name="id"  value="',$id,'" style="visibility:hidden">';
                    echo '  <input type="submit" value="',$answ1,'(',$nbAnsw1,')" name="yes">';
                echo ' </div>';
            echo '</form>';
            echo '<form method="post" action="index.php" class="col span_1_of_2">';
                echo '<div class="nobutton button">';
                    echo '<input type="int" name="id"  value="',$id,'" style="visibility:hidden">';
                    echo '<input type="submit" value="',$answ2,'(',$nbAnsw2,')" name="no">';
                echo ' </div>';
            echo '</form>';
       echo ' </div>';


    }
?>


<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        
	<title> ANSWER ME PLZ </title> 
        
        
        <link rel="stylesheet" href="Style/html5reset.css" media="all">
        <link rel="stylesheet" href="Style/4cols.css" media="all">
        <link rel="stylesheet" href="Style/8cols.css" media="all">
        <link rel="stylesheet" href="Style/2cols.css" media="all">
        <link rel="stylesheet" href="Style/3cols.css" media="all">
        <link rel="stylesheet" href="Style/5cols.css" media="all">
        <link rel="stylesheet" href="Style/6cols.css" media="all">
        <link href="Style/style.css" rel="stylesheet">
        
        
        <script src="libs/jquery-2.1.4.min.js"></script>
        
        <link href="libs/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="libs/bootstrap/js/bootstrap.min.js"></script>
        
        <meta charset="UTF-8">

        <!-- Responsive and mobile friendly stuff -->
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
    </head>
    <body onload="return ran_col()">
        <div id ="wrapper">
            <section id="content">
                <div class="section group title">
                    <p style="text-align: center ; font-family: alba;">
                        ANSWER ME PLZ
                    </p>
                </div>
                <?php
                getAndDisplayRandomQuestion()
                ?>
                <div class="section group ask">
                    <form method="post" action="index.php">
                        <div class="col span_1_of_2">
                            <input type="text" name="question" placeholder="Your amazing question">
                        </div>
                        <div class="section group answ">
                            <div class="col span_1_of_2">
                                <input type="text" name="answ1"  placeholder="Choice 1">
                            </div>
                            <div class="col span_1_of_2" style="text-align:right">
                                <input type="text" name="answ2" placeholder="Choice 2">
                            </div>
                            <input type="submit" value="Submit Question" name="submit">
                        </div>
                    </form>
                </div>
            </section>
        </div>
        
        
        
        <script type="text/javascript">
         //Random background color
         function ran_col() { 
             var color = '#'; 
             var letters = ['FF5252', 'D81B60', '7B1FA2', '673AB7', '303F9F', '2196F3', '039BE5', '43A047', '689F38', 'FFA000', 'D84315', '546E7A']; //COULEURS
             color += letters[Math.floor(Math.random() * letters.length)];
             document.body.style.background = color;
         }
        </script>
        
        
    </body>
    
</html>
