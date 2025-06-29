# Projet Portfolio - Gestion des Utilisateurs et des Compétences

## Présentation du Projet
Ce projet est une application web développée en PHP & MySQL permettant aux utilisateurs de :
- [x] Gérer leur profil (inscription, connexion, mise à jour des informations).
- [x] Ajouter et modifier leurs compétences parmi celles définies par un administrateur.
- [x] Ajouter et gérer leurs projets (titre, description, image et lien).
- [x] Un administrateur peut gérer les compétences disponibles.

## Fonctionnalités Implémentées

### Authentification & Gestion des Comptes
- [x] Inscription avec validation des champs
- [x] Connexion sécurisée avec sessions et option "Se souvenir de moi"
- [x] Gestion des rôles (Admin / Utilisateur)
- [x] Mise à jour des informations utilisateur
- [ ] Réinitialisation du mot de passe
- [x] Déconnexion sécurisée

### Gestion des Compétences
- [x] L’administrateur peut gérer les compétences proposées
- [x] Un utilisateur peut sélectionner ses compétences parmi celles disponibles
- [x] Niveau de compétence défini sur une échelle (débutant → expert)

### Gestion des Projets
- [x] Ajout, modification et suppression de projets
- [x] Chaque projet contient : Titre, Description, Image, Lien externe
- [x] Upload sécurisé des images avec restrictions de format et taille
- [x] Affichage structuré des projets

### Sécurité
- [x] Protection contre XSS, CSRF et injections SQL
- [x] Hachage sécurisé des mots de passe
- [x] Gestion des erreurs utilisateur avec affichage des messages et conservation des champs remplis
- [ ] Expiration automatique de la session après inactivité

## Installation et Configuration

### Prérequis
- Serveur local (XAMPP, WAMP, etc.)
- PHP 8.x et MySQL
- Un navigateur moderne

### Étapes d’Installation
1. Cloner le projet sur votre serveur local :
   ```sh
   git clone url_de_votre_repo
   cd mon_portfolio
   ```
2. Importer la base de données :
   - Fichier SQL : `SQL/projet_web.sql` à importer via phpMyAdmin

3. Configurer la connexion à la base de données :
   Modifier le fichier `config/database.php` :
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'portfolio_db');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_PORT', 3306);
   ```

4. Démarrer le serveur PHP et tester l'application :
   ```sh
   php -S localhost:8000
   ```
   Puis accéder à l'application via `http://localhost:8000` ou `http://localhost/mon_portfolio`

## Comptes de Test

### Compte Administrateur
- **Email** : admin@example.com
- **Mot de passe** : password

### Compte Utilisateur
- **Email** : user@example.com
- **Mot de passe** : password

## Structure du Projet

```
mon_portfolio/
├── index.php
├── contact.php
├── login.php / register.php / logout.php
├── profile.php / profile_edit.php
├── projects/               # Gestion des projets
├── skills/                # Gestion des compétences
├── admin/user_skills/     # Espace admin
├── config/database.php
├── includes/              # Header, footer, fonctions
├── uploads/               # Dossier des images
└── SQL/projet_web.sql     # Base de données
```

## Licence
Ce projet est sous licence MIT.

## Contact
Une question ou un bug ? Contactez-moi à : **votre.email@example.com**
