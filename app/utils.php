<?php

namespace App;

function hidemail(string $email): string{
    $pattern = '/(?<=.).(?=.*@)/'; // L'expression régulière qui correspond aux caractères à remplacer
    $replacement = '*'; // Le caractère de remplacement
    $protected_email = preg_replace($pattern, $replacement, $email); // L'email protégé
    return $protected_email; // Affiche h*****@mail.com
}
