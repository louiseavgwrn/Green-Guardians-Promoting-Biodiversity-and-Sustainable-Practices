<?php
// Include the Game class from the 'animalgame.php' file
include_once 'animalgame.php';

// Create an instance of the Game class
$game = new Game();

// Check if the form was submitted (POST request)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the user's guess (convert to lowercase and trim spaces)
    $userGuess = strtolower(trim($_POST['guess']));
    
    // Get the sound associated with the animal (passed from the form)
    $sound = $_POST['sound'];

    // Get animal information based on the sound
    $animalInfo = $game->getAnimalInfo($sound);
    
    // Retrieve the correct name of the animal (case-insensitive comparison)
    $correctAnswer = strtolower($animalInfo->getName());

    // Check if the user's guess matches the correct animal name
    $isCorrect = $game->checkGuess($userGuess, $sound);

    // Display the result
    echo "<div class='answer-box'>";
    
    // If the guess is correct
    if ($isCorrect) {
        echo "<h1>Correct!</h1>";
        echo "<p>You guessed it right. The sound belongs to a <strong>{$animalInfo->getName()}</strong>.</p>";
    } else {
        // If the guess is incorrect
        echo "<h1>Wrong Answer!</h1>";
        echo "<p>Sorry, that's incorrect. The correct answer is <strong>{$animalInfo->getName()}</strong>.</p>";
    }

    // Display a fun fact about the animal
    echo "<div class='fun-fact'>";
    echo "<h2>Fun Fact:</h2><p>{$animalInfo->getFact()}</p>";
    echo "</div>";

    // Display a description and image of the animal
    echo "<div class='description'>";
    echo "<h3>Description:</h3><p>{$animalInfo->getDescription()}</p>";
    echo "<img src='images/{$animalInfo->getImage()}' alt='{$animalInfo->getName()}' width='300'>";
    echo "</div>";

    // Provide a link for the user to try again
    echo '<br><a href="animalsound.php">Try Again</a>';
} else {
    // If the request method is not POST, redirect to the animalsound.php page
    header('Location: animalsound.php');
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Style/guessanimals.css">
    <title>Guessing Game</title>
</head>
<body>
<main>
    <div class="section-container">
        <button onclick="window.location.href='useracc.php'" class="nav-button">Home</button>
        <button onclick="window.location.href='lifesection.php'" class="nav-button">Life Section</button>
    </div>
</main>
</body>
</html>
