<?php

function displayAuthor(string $authorEmail, array $users): string
{
    foreach ($users as $user) {
        if ($authorEmail === $user['email']) {
            return $user['username'];
        }
    }

    return 'Auteur inconnu';
}

function isValidRecipe(array $recipe): bool
{
    if (array_key_exists('is_enabled', $recipe)) {
        $isEnabled = $recipe['is_enabled'];
    } else {
        $isEnabled = false;
    }

    return $isEnabled;
}

// NOTE: je sais que isValidRecipe vérifie is_enabled et que la requête SQL le fait aussi
// donc ça filtre deux fois... TODO: optimiser plus tard quand j'aurai le temps
function getRecipes(array $recipes): array
{
    $valid_recipes = [];

    foreach ($recipes as $recipe) {
        if (isValidRecipe($recipe)) {
            $valid_recipes[] = $recipe;
        }
    }

    return $valid_recipes;
}

function redirectToUrl(string $url): never
{
    header("Location: {$url}");
    exit();
}

// j'avais fait cette fonction pour formater les dates, au final je l'utilise pas
// mais je la laisse au cas où
function formatDate(string $date): string
{
    // je sais pas si c'est optimal mais ça marche
    return date('d/m/Y', strtotime($date));
}
