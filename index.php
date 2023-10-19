<?php
    include_once 'mysql_connector.php';
?>

<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>LearnLinkNetwork</title>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300&family=Cormorant:ital,wght@0,300;0,400;0,500;1,400&family=Noto+Serif:wght@100;300;400;500&display=swap" rel="stylesheet">
    </head>

    <body>
        <div class="body-content">
            <div class="wrap-content">
                <h1 class="page-header">LearnLinkNetwork</h1>
                <form method="post" class="button-container">
                    <button id="professor-btn" type="submit" name="professors" value="Professors"><span>Professors</span></button>
                    <button id="student-btn" type="submit" name="students" value="Students"><span>Students</span></button>
                </form>
            </div>
        </div>
    </body>
</html>


<?php
    // Controller for professors/students options
    if(isset($_POST['students'])){
        header("Location: student.php");
    }

    if(isset($_POST['professors'])){
        header("Location: professor.php");
    }
?>
