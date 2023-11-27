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
            <div class="student-wrap-content">
                <h1 class="student-header">Student Course and Campus Search</h1>
                <!-- Course ID input -->
                <div class="student-wrap-form">
                    <form method="post" class="student-courseid-wrap">
                        <label class="student-courseid-label" for="course_id">Course ID:</label>
                        <br>
                        <input type="text" name="course_id" class="course_id">
                        <br>
                        <input class="course-submit-btn" type="submit" value="Submit">
                    </form>
        
                    <!-- Student Campus ID input -->
                    <form method="post" class="student-campusid-wrap">
                        <label class="student-campusid-label" for="campus_id">Campus ID:</label>
                        <br>
                        <input type="text" name="campus_id" id="campus_id">
                        <br>
                        <input class="campus-submit-btn" type="submit" value="Submit">
                    </form>
                </div>
            </div>

            <div class="table-container">
                <?php
                if(isset($_POST['course_id'])){
                    $course_id = $_POST['course_id'];
    
                    // Query the course sections given course_id
                    $query = "SELECT Section.id, Section.classroom, Section.meeting_days, Section.start_time, Section.end_time, COUNT(Enrollment.campus_id) as student_count
                                FROM Section LEFT JOIN Enrollment ON Section.id = Enrollment.section_id AND Section.course_id = Enrollment.course_id
                                WHERE Section.course_id = $course_id
                                GROUP BY Section.id";
    
                    // Execute the query
                    $result = mysqli_query($conn, $query);
    
                    // If there is one or more records
                    if(mysqli_num_rows($result) > 0){
                        // Display the results as a table
                        // Table headers
                        echo "<br><h2 style='font-size: 20px;'>Sections for course $course_id</h2><br>";
                        echo "<table>
                                <tr>
                                    <th>Section ID</th>
                                    <th>Meeting Days</th>
                                    <th>Start Time</th>
                                    <th>End Time</th>
                                    <th>Classroom</th>
                                    <th>Number of Students</th>
                                </tr>";
                        // Table data
                        while($row = mysqli_fetch_assoc($result)){
                            echo "<tr>
                                    <td>" . $row['id'] . "</td>
                                    <td>" . $row['meeting_days'] . "</td>
                                    <td>" . $row['start_time'] . "</td>
                                    <td>" . $row['end_time'] . "</td>
                                    <td>" . $row['classroom'] . "</td>
                                    <td>" . $row['student_count'] . "</td>
                                </tr>";
                        }
                        echo "</table>";
                    } else {
                        echo "
                        <div style='padding: 20px;'>
                            <h2 style='font-size: 20px;'>This course has no sections</h2>
                        </div>
                        ";
                    }
                }
                ?>
                
                <?php
                if(isset($_POST['campus_id'])){
                    $campus_id = $_POST['campus_id'];
    
                    // Query the courses and grades for a given student
                    $query = "SELECT Course.title, Enrollment.grade
                                FROM Enrollment INNER JOIN Course ON Enrollment.course_id = Course.id
                                WHERE Enrollment.campus_id = '$campus_id'";
    
                    // Execute the query
                    $result = mysqli_query($conn, $query);
    
                    // If there is one or more records
                    if(mysqli_num_rows($result) > 0){
                        // Display the results as a table
                        // Table headers
                        echo "<br><h2 style='font-size: 20px;'>Courses for student</h2><br>";
                        echo "<table>
                                <tr>
                                    <th>Title</th>
                                    <th>Grade</th>
                                </tr>";
                        // Table data
                        while($row = mysqli_fetch_assoc($result)){
                                    echo "<tr>
                                            <td>" . $row['title'] . "</td>
                                            <td>" . $row['grade'] . "</td>
                                        </tr>";
                                }
                        echo "</table>";
                    }
                    else {
                        echo "
                        <div style='padding: 20px;'>
                            <h2 style='font-size: 20px;'>No courses/sections found for this student</h2>
                        </div>";
                    }
                }
                ?>
            </div>
        </div>  
  </body>
</html>
