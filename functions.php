<?php

function sanitizeInput($input) {
    return trim(htmlspecialchars(strip_tags($input)));
}

function generateBookID($title, $author, $publicationDate) {
    // Remove whitespaces and special characters.
    $title = preg_replace("/[^a-zA-Z0-9]/", "", $title);
    $author = preg_replace("/[^a-zA-Z0-9]/", "", $author);

    // Extract first 3 letters of title (padded if less than 3)
    $titleCode = strtoupper(substr(trim($title), 0, 3));
    $titleCode = str_pad($titleCode, 3, " ", STR_PAD_RIGHT);
  
    // Extract last 3 letters of author's name (padded if less than 3)
    $authorCode = strtoupper(substr(trim($author), -3, 3));
    $authorCode = str_pad($authorCode, 3, " ", STR_PAD_RIGHT);
  
    // Generate random 5-digit number (zero-padded)
    $randomNum = str_pad(rand(0, pow(10, 5) - 1), 5, "0", STR_PAD_RIGHT);
  
    // Format publication date (mmmYYYY)
    $pubDate = strtoupper(date('M', strtotime($publicationDate))) . date('Y', strtotime($publicationDate));
  
    // Combine and return ID
    return "$titleCode-$authorCode-$randomNum-$pubDate";
  }