# mibu

## Installer mibu en local

L'installation nécessite PHP 7.1+, composer et postgreSQL (9+?)

### Installer les dépendances

```
composer install
```

### Créer la BD

```
php bin/console doctrine:database:create --if-not-exists

php bin/console doctrine:migrations:migrate
```

### Lancer l'application en local

```
php bin/console server:run
```

## Installer mibu avec docker

### Compilation + execution des containers docker

docker run --detach --name mibu_db postgres:10.2
docker build docker/api -t mibu_api
docker run -p 80:80 --volume $PWD:/var/www/html --link mibu_db --name mibu_api mibu_api

### Copier les variables d'environnements

```
cp .env.docker.dist .env
```

### Installer les dépendances

```
docker exec -it mibu_api bash -c "/usr/local/bin/composer install"
```

### Créer la BD

```
docker exec -it mibu_api bash -c "php bin/console doctrine:database:create  --if-not-exists"
docker exec -it mibu_api bash -c "php bin/console doctrine:migrations:migrate --no-interaction"
```

## Génération de token

Se connecter à l'application nécessite des jetons. La seule route accessible publiquement en GET est l'accueil.

Nous utilisons LexikJWTAuthenticationBundle pour générer des tokens.

Afin d'y parvenir, il faut créer deux clés SSH (une privée et une publique).

```
mkdir config/jwt
openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem
```

Ajouter la configuration suivante dans lexik_jwt_authentication.yaml :

```
lexik_jwt_authentication:
    secret_key: '%env(resolve:JWT_SECRET_KEY)%'
    public_key: '%env(resolve:JWT_PUBLIC_KEY)%'
    pass_phrase: '%env(JWT_PASSPHRASE)%'
    token_ttl:        3600
```

Pour plus de documentation, consulter : https://github.com/lexik/LexikJWTAuthenticationBundle/blob/master/Resources/doc/index.md#installation 

## S'authentifier

Toutes les routes de l'API sont sécurisée à l'exception des suivantes
 - GET / : l'accueil
 - POST /jetons : voir plus bas

Pour se connecter à l'API, il faut donc générer au préalable un jeton. 

La route POST jetons permet de le faire, il faut ajouter un body avec le pseudo et le mot de passe d'un inscrit sur le modèle suivant :

```
{
  "pseudo" : "gaotian",
  "password" : "motdepasse"
}   
```

Pour l'instant, il n'existe pas encore de système de générations de fixtures, il faut donc créer directement via la BD un inscrit.

Par exemple :

```
INSERT INTO inscrit (SELECT 1, 'Nom', 'Prénom', 'femme',	'1980-01-01',	'gaetan@interlivre.fr',	NOW(), NOW(), '23ed908c-f566-4c85-fe18-9fafeff969c0',	'titre', 'Description', 'pseudo',	'[]',	'motdepasseEncodéAvecBcrypt');
```

## Présentation de l'application mibu

Mibu est une API dédiée l'écriture de fictions interactive.
Cet outil est encore en cours de développement, il ne s'agit encore que d'une première version.

## Quelques mots sur le projet

Mibu doit permettre d'écrire des fictions se composant de textes et comportant des personnages et des évènements.

Il doit permettre aux auteurs de disposer d'outils statistiques facilitant la connaissance de la fiction.

## En savoir plus

Une description plus complète du projet est disponible ici : [https://github.com/gdarquie/mibu/wiki](https://github.com/gdarquie/mibu/wiki)
