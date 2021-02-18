# API Book

## Partie serveur

Partie regroupant l'API permettant dajouter / éditer / supprimer des libres, ainsi que de gérer el stock par livre.


### Installation:
Configuration de la base de donnée dans le .env, puis:


Installation des dépendances
`composer install`

Création de la base de données
`bin/console doctrine:database:create`

Création du schema relationnel
`bin/console doctrine:schema:create`

Création de livres et generation d'un stock
`bin/console doctrine:fixtures:load`

Lancement du serveur web intégré à Symfony.
`symfony server:start`

## Partie client

Partie regroupant l'interface utilisateur et le pannier.

Interroge l'API sur les livres disponibles, le stock,

et met à jour l'APi lorsque l'on valide le pannier.


### Installation:
Configuration de la base de donnée dans le .env, puis:

Installation des dépendances
`composer install`

Lancement du serveur web intégré à Symfony.
`symfony server:start`