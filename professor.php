<?php
    include_once 'mysql_connector.php';
?>

<!DOCTYPE html>
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
            <a class="back-link" href="index.php">
                <button class="back-btn">
                    <span class="back-title">BACK</span>
                </button>
            </a>

            <div class="professor-wrap-content">
                <h1 class="professor-header">Professor and Course Search</h1>
                <!-- Professor SSN input -->
                <div class="professor-wrap-form">
                    <form method="post" class="professor-ssn-wrap">
                        <label class="professor_label" for="ssn">Professor's SSN</label>
                        <br>
                        <input type="text" id="professor_ssn" name="ssn" placeholder="Professor's SSN">
                        <br>
                        <input class="professor_submit-btn" type="submit" value="Submit">
                    </form>
        
                    <!-- Course and Section input -->
                    <form method="post" class="course-section-wrap">
                        <label class="course_label" for="course_id">Course ID</label>
                        <input type="text" id="course_id" name="course_id" placeholder="Course ID">
                        <br>
                        <label class="course_label" for="section_id">Section ID</label>
                        <input type="text" id="section_id" name="section_id" placeholder="Section ID">
                        <br>
                        <input class="course_submit-btn" type="submit" value="Submit">
                    </form>
                </div>
            </div>

        <div class="table-container">
            <?php
                // Query the professor's information given ssn
                if (isset($_POST['ssn'])) {
                    $ssn = $_POST['ssn'];
                    $query = "SELECT Course.title, Section.classroom, Section.meeting_days, Section.start_time, Section.end_time
                            FROM Professor
                            JOIN Section ON Professor.id = Section.professor_id
                            JOIN Course ON Section.course_id = Course.id
                            WHERE Professor.ssn = '$ssn'";
    
                    $result = mysqli_query($conn, $query);
    
                    if (mysqli_num_rows($result) > 0) {
                        // Display classes taught by professor
                        echo "<br><h2 style='font-size: 20px;'>
                            Professor's classes
                        </h2><br>";
                        echo "<table class='footer-table'>
                        <tr>
                            <th>Course Title</th>
                            <th>Meeting Days</th>
                            <th>Time</th>
                            <th>Classroom</th>
                        </tr>";
                        // Table data
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>
                                    <td>" . $row['title'] . "</td>
                                    <td>" . $row['meeting_days'] . "</td>
                                    <td>" . $row['start_time'] . " - " . $row['end_time'] . "</td>
                                    <td>" . $row['classroom'] . "</td>
                                </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "<div style='padding: 20px;'>
                            <h2 style='font-size: 20px;'>This professor does not teach any courses or there is no professors with that SSN.</h2>
                        </div>";
                    }
                }
            ?>
    
            <?php
                // Query the number of students and their grades for a given course section
                if (isset($_POST['course_id']) && isset($_POST['section_id'])) {
                    $course_id = $_POST['course_id'];
                    $section_id = $_POST['section_id'];
    
                    $query = "SELECT grade, COUNT(*) AS count
                            FROM Enrollment
                            WHERE course_id = $course_id AND section_id = $section_id
                            GROUP BY grade";
    
                    $result = mysqli_query($conn, $query);
    
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table>
                        <tr>
                            <th>Grade</th>
                            <th>Student Count</th>
                        </tr>";
                        // Display number of students and their grades
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>
                                    <td>" . $row['grade'] . "</td>
                                    <td>" . $row['count'] . "</td>
                            </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "
                        <div style='padding: 20px;'>
                            <h2 style='font-size: 20px;'>This course section has no students or there is no courses/sections with those IDs.</h2>
                        </div>
                        ";
                    }
                }
            ?>
        </div>
    </div>    
</body>
</html>
