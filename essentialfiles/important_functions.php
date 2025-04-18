<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
// sendEmail fuction
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/autoload.php'; // Make sure this path is correct based on your project structure

function sendEmail($recipientEmail, $recipientName, $subject, $body) {
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ionize2023@gmail.com'; // Replace with your Gmail email address
        $mail->Password = 'bfgdyfrocfvbkzay'; // Replace with your Gmail password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Email content
        $mail->setFrom('ionize@gmail.com', 'Ionize'); // Replace with your name and Gmail email address
        $mail->addAddress($recipientEmail, $recipientName);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send the email
        $mail->send();
        return true; // Email sent successfully!
    } catch (Exception $e) {
        return false; // Error sending email
    }
}
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//function to generate a random sentence
function generateRandomSentence() {
    // Lists of words for nouns, verbs, adjectives, and conjunctions
    $nouns = ['cat', 'dog', 'book', 'tree', 'house', 'car', 'apple', 'table', 'computer', 'flower', 'bird', 'moon', 'sun', 'river', 'mountain', 'ocean', 'friend', 'music', 'city', 'guitar', 'chair', 'beach', 'rain', 'cloud', 'star', 'mirror', 'picture', 'door', 'window', 'mountain'];
    $verbs = ['runs', 'jumps', 'reads', 'eats', 'drives', 'sleeps', 'writes', 'cooks', 'swims', 'flies', 'climbs', 'dances', 'laughs', 'cries', 'plays', 'sings', 'learns', 'teaches', 'works', 'paints', 'talks', 'listens', 'smiles', 'runs', 'thinks', 'dreams', 'builds', 'draws', 'plants', 'watches'];
    $adjectives = ['happy', 'big', 'red', 'tall', 'old', 'fast', 'beautiful', 'green', 'blue', 'small', 'young', 'brave', 'clever', 'calm', 'loud', 'funny', 'kind', 'smart', 'quiet', 'proud', 'shiny', 'bright', 'soft', 'warm', 'cold', 'colorful', 'clean', 'cozy', 'modern'];
    $conjunctions = ['and', 'but', 'or', 'so', 'yet', 'for', 'nor', 'while', 'although', 'unless', 'because', 'since', 'if', 'when', 'as', 'that', 'whether', 'provided', 'inasmuch'];

    // Randomly select words from the lists to create a sentence
    $sentence = $adjectives[array_rand($adjectives)] . ' ' . $nouns[array_rand($nouns)] . ' ';
    $sentence .= $verbs[array_rand($verbs)] . ' ' . $adjectives[array_rand($adjectives)] . ' ' . $nouns[array_rand($nouns)] . ' ';
    $sentence .= $conjunctions[array_rand($conjunctions)] . ' ' . $adjectives[array_rand($adjectives)] . ' ' . $nouns[array_rand($nouns)];

    return $sentence;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////




///////////////////////////////////////////////////////////////////////////////////////////////////////////
//random string generator function
function generateRandomString($length) {
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $randomString = '';

  for ($i = 0; $i < $length; $i++) {
    $randomString .= $characters[rand(0, strlen($characters) - 1)];
  }

  return $randomString;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
