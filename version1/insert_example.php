<?php
// Database connection settings
$host = 'localhost';
$dbname = 'database';
$username = 'user';
$password = 'password';

try {
    // Create PDO connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create films table if it doesn't exist
    $createTable = "
    CREATE TABLE IF NOT EXISTS mcu_films (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(100) NOT NULL,
        release_date DATE NOT NULL,
        phase INT NOT NULL,
        director VARCHAR(100) NOT NULL
    )";
    $pdo->exec($createTable);

    // Sample MCU films data
    $films = [
        ['title' => 'Iron Man', 'release_date' => '2008-05-02', 'phase' => 1, 'director' => 'Jon Favreau'],
        ['title' => 'The Incredible Hulk', 'release_date' => '2008-06-13', 'phase' => 1, 'director' => 'Louis Leterrier'],
        ['title' => 'Iron Man 2', 'release_date' => '2010-05-07', 'phase' => 1, 'director' => 'Jon Favreau'],
        ['title' => 'Thor', 'release_date' => '2011-05-06', 'phase' => 1, 'director' => 'Kenneth Branagh'],
        ['title' => 'Captain America: The First Avenger', 'release_date' => '2011-07-22', 'phase' => 1, 'director' => 'Joe Johnston'],
        ['title' => 'The Avengers', 'release_date' => '2012-05-04', 'phase' => 1, 'director' => 'Joss Whedon'],
        ['title' => 'Iron Man 3', 'release_date' => '2013-05-03', 'phase' => 2, 'director' => 'Shane Black'],
        ['title' => 'Thor: The Dark World', 'release_date' => '2013-11-08', 'phase' => 2, 'director' => 'Alan Taylor'],
        ['title' => 'Captain America: The Winter Soldier', 'release_date' => '2014-04-04', 'phase' => 2, 'director' => 'Anthony Russo, Joe Russo'],
        ['title' => 'Guardians of the Galaxy', 'release_date' => '2014-08-01', 'phase' => 2, 'director' => 'James Gunn']
    ];

    // Prepare insert statement
    $stmt = $pdo->prepare("
        INSERT INTO mcu_films (title, release_date, phase, director)
        VALUES (:title, :release_date, :phase, :director)
    ");

    // Insert each film
    foreach ($films as $film) {
        $stmt->execute([
            ':title' => $film['title'],
            ':release_date' => $film['release_date'],
            ':phase' => $film['phase'],
            ':director' => $film['director']
        ]);
    }

    echo "MCU films imported successfully!\n";

    // Optional: Display imported films
    $result = $pdo->query("SELECT * FROM mcu_films");
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: {$row['id']}, Title: {$row['title']}, Release: {$row['release_date']}, Phase: {$row['phase']}, Director: {$row['director']}\n";
    }

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
