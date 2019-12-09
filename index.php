<?php
include 'PDOAdapter.php';
include 'MyLogger.php';

    $dsn = "mysql:dbname=Inlain;host=localhost";
    $errorLog = new MyLogger("log.txt");
    $connectDb = NEW PDOAdapter($dsn, "root", "", $errorLog);
     $errorLog->info("test");

    $maxAge = $connectDb->execute("selectOne", "SELECT MAX(age) as 'Max' FROM Inlain.person;");

    $nullAndAge = ($connectDb->execute("selectOne", "SELECT * FROM Inlain.person WHERE `mother_id` 
                                                            is NULL AND `age` < (SELECT MAX(age) FROM Inlain.person);"));
    $jsonNullAndAge = json_encode($nullAndAge,JSON_UNESCAPED_UNICODE);

   $changePersonAge = $connectDb->execute("execute", "UPDATE Inlain.person SET `age` = $maxAge->Max
                                                                    WHERE `id` = $nullAndAge->id;");

    $maxAgePeople = $connectDb->execute("selectAll", "SELECT * FROM Inlain.person WHERE age =
                                                                 (SELECT MAX(age) FROM Inlain.person);");
    $jsonMaxAgePeople = json_encode($maxAgePeople,JSON_UNESCAPED_UNICODE);

    echo("<p>Максимальный возраст: $maxAge->Max<p> 
          <p>персона с mother_id равным NULL  и возрастом меньше максимального: $jsonNullAndAge<p>
            <p>изменение возраста на максимальный: $changePersonAge<p>
            <p>список персон с максимальным возрастом: $jsonMaxAgePeople<p>"
        );
