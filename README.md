# Therapy Dashboard – Version PHP

## Présentation du projet

Ce projet est une adaptation en PHP d’un prototype de "Therapy Dashboard".

L’idée est de simuler une application utilisée dans un contexte thérapeutique, avec deux types d’utilisateurs :

- **Patient**
- **Thérapeute**

Le patient peut écrire des notes personnelles (comme un journal), et choisir de les partager ou non avec son thérapeute.  
Le thérapeute peut consulter uniquement les notes que ses patients ont décidé de partager.

---

## Technologies utilisées

- PHP (architecture MVC simple)
- MySQL
- Docker (nginx, php, mysql, phpMyAdmin)
- Composer (autoload PSR-4)

---

## Architecture

Le projet est organisé de manière simple :
public/ → point d’entrée (index.php)
src/
Controller/ → logique (Auth, Notes, Therapist)
Repository/ → accès base de données
Entity/ → objets métier
Helper/ → gestion auth
view/ → affichage (HTML + PHP)


---

## Authentification

L’authentification est basée sur :

- `password_hash()` / `password_verify()`
- sessions PHP (`$_SESSION`)
- protection CSRF sur les formulaires

Lors de la connexion, on stocke :

```php
$_SESSION['user_id']
$_SESSION['user_name']
$_SESSION['role']

## Gestion des rôles

### Patient

- peut créer des notes  
- peut modifier et supprimer ses notes  
- choisit si une note est partagée (`is_shared`)  

### Thérapeute

- voit uniquement ses patients  
- peut consulter uniquement les notes partagées  
- ne peut pas accéder aux données d’un autre thérapeute  

---

## Modèle de données

### Table `users`

- id  
- name  
- email  
- password  
- role (`patient` / `therapist`)  
- therapist_id (relation patient → therapist)  

### Table `notes`

- id  
- user_id  
- title  
- content  
- is_shared  
- created_at  

---

## Sécurité

Quelques règles mises en place :

- un utilisateur ne voit que ses propres données  
- un thérapeute ne voit que ses patients  
- les notes privées ne sont jamais visibles côté thérapeute  
- filtrage côté SQL (`WHERE user_id = ...`)  
- protection CSRF sur les formulaires POST  

---

## Lancer le projet

Avec Docker :

```bash
docker compose up --build

## Accès

- Application : http://localhost:8090/public/index.php  
- phpMyAdmin : http://localhost:8092  

---

## Données de test

Créer via le formulaire :

### Thérapeutes

- lemoine.t1@therapy.dev  
- caron.t2@therapy.dev  

Mot de passe :
Test1234!


Ensuite créer des patients en les assignant à un thérapeute.

---

## Fonctionnalités principales

- inscription / connexion  
- gestion des rôles  
- création de notes  
- partage de notes  
- dashboard thérapeute  
- filtrage sécurisé des données  

---

## Remarques

Ce projet est volontairement simple mais permet de bien comprendre :

- le fonctionnement d’un backend PHP sans framework  
- la séparation MVC  
- la gestion des rôles  
- les bases de la sécurité web  

---

## Améliorations possibles

- améliorer l’interface (CSS / UI)  
- pagination des notes  
- ajout de fichiers (images, audio…)  
- notifications  