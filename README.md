# API Book

## Installation:
Configuration de la base de donnée dans le .env, puis:


Installation des dépendances
`composer install`

Création de la base de données
`bin/console doctrine:database:create`

CRéation du schema relationnel
`bin/console doctrine:schema:create`

Lancement du serveur web intégré à Symfony.
`symfony server:start`