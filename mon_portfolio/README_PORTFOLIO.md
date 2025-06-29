# Portfolio - Projet PHP ESGI 2024/2025

Ce projet est une application web de **gestion de portfolio personnel** développée en **PHP & MySQL** dans le cadre du module de développement web à l'ESGI.

## 🚀 Fonctionnalités principales

### 🔐 Authentification
- Inscription sécurisée avec hachage des mots de passe (`password_hash`)
- Connexion et déconnexion via sessions
- Gestion des rôles (`admin` et `utilisateur`)
- Mise à jour du profil utilisateur

### 🧠 Compétences
- L’administrateur peut **ajouter / modifier / supprimer** des compétences
- Les utilisateurs peuvent sélectionner leurs compétences parmi celles proposées
- Chaque compétence a un **niveau** (débutant → expert)

### 📁 Projets
- Ajout, modification et suppression de projets
- Chaque projet a :
  - Un titre
  - Une description
  - Une image
  - Un lien externe
- Affichage des projets dans un portfolio visuel

### 🔒 Sécurité
- Protection contre XSS et injections SQL (requêtes préparées)
- Hachage sécurisé des mots de passe
- Contrôle d'accès à l’espace admin

---

## 🧪 Comptes de test

| Rôle        | Email              | Mot de passe |
|-------------|--------------------|--------------|
| Admin       | admin@mail.com     | password     |
| Utilisateur | user1@mail.com     | password     |
| Utilisateur | user2@mail.com     | password     |

---

## 💾 Installation

1. Cloner ce repo ou le télécharger en .zip
2. Copier le dossier dans `htdocs` (si XAMPP)
3. Importer la base de données :
   - Aller sur `http://localhost/phpmyadmin`
   - Créer une base `projetb2`
   - Importer le fichier SQL situé dans `SQL/projetb2_complet.sql`

4. Configurer la connexion BDD :
   - Le fichier est `config/database.php`
   - Les identifiants sont déjà pré-configurés :
     ```php
     define('DB_HOST', 'localhost');
     define('DB_PORT', 3306);
     define('DB_NAME', 'projetb2');
     define('DB_USER', 'projetb2');
     define('DB_PASS', 'password');
     ```

---

## 🛠️ Technologies utilisées

- PHP (procédural)
- MySQL
- HTML5 / CSS3
- JavaScript (léger)
- XAMPP / phpMyAdmin

---

## 📁 Arborescence principale

```
mon_portfolio/
│
├── auth/                 # Fichiers login, register, logout
├── config/               # Connexion à la base de données
├── skills/               # Gestion des compétences
├── projects/             # Gestion des projets
├── admin/                # Gestion des utilisateurs/compétences (admin)
├── uploads/              # Dossier des images uploadées
├── includes/             # Header, footer, fonctions communes
├── SQL/                  # Script SQL complet
└── README.md
```

---

## 👨‍🎓 Réalisé par :
**Di Pietro / Enzo ici**  
Promo B2 – ESGI 2024/2025  
