# 📚 SmartLibrary — Système de Gestion de Bibliothèque Premium

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white"/>
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white"/>
  <img src="https://img.shields.io/badge/Vite-6.x-646CFF?style=for-the-badge&logo=vite&logoColor=white"/>
</p>

> **SmartLibrary** est une application web moderne et professionnelle de gestion de bibliothèque. Elle offre une expérience utilisateur premium, une séparation stricte des rôles et un système automatisé de notifications par email.

---

## ✨ Nouvelles Fonctionnalités Premium

### 💎 Design & UX "Modern UI"
- **Expérience Différenciée :** L'Adhérent navigue dans un **Catalogue Visuel** (cartes interactives, effets de survol, notes) tandis que l'Admin dispose d'un **Tableau de Bord de Gestion** puissant.
- **Glassmorphism & Micro-animations :** Interface épurée avec des ombres douces, des cartes "premium" et des transitions fluides.
- **Design Responsive :** Entièrement optimisé pour mobiles et tablettes.

### 🛡️ Sécurité & Rôles Avancés
- **Middleware `AdminOnly` :** Protection stricte des routes sensibles. Seuls les administrateurs peuvent modifier les données.
- **Authentification Sécurisée :** Système de connexion/inscription robuste avec hashage des mots de passe.
- **Réinitialisation de Mot de Passe :** Flux complet "Mot de passe oublié" avec envoi sécurisé de lien par email.

### 📧 Système de Notifications Automatisées
- **Confirmation de Réservation :** Envoi automatique d'un email détaillé dès qu'un livre est emprunté.
- **Relances de Retard :** Commande Artisan `library:notify-late-books` qui identifie les livres non rendus et alerte les adhérents par email.

---

## 🛠️ Fonctionnalités par Rôle

### 👨‍💼 Espace Administrateur
| Fonctionnalité | Description |
|---|---|
| 📊 Dashboard Stats | Statistiques en temps réel (livres, adhérents, retards) |
| 📖 Gestion Totale | CRUD complet sur les livres, thèmes et adhérents |
| 📋 Monitoring | Suivi global de tous les emprunts de la bibliothèque |
| 🚨 Gestion des Retards | Envoi manuel ou automatique des emails de relance |

### 👤 Espace Adhérent
| Fonctionnalité | Description |
|---|---|
| 📚 Catalogue Interactif | Parcourir les livres avec une vue "Galerie" moderne |
| ⚡ Emprunt Rapide | Réserver un livre en un clic directement depuis la carte |
| 📋 Mes Emprunts | Suivi personnel des livres empruntés avec dates limites |
| 🔐 Auto-Gestion | Réinitialisation de mot de passe et gestion du profil |

---

## 🏗️ Architecture du Projet

```
Gestio Bib Laravel/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AuthController.php       ← Connexion / Inscription / Reset Password
│   │       ├── AdherentController.php   ← CRUD des adhérents (membres)
│   │       ├── LivreController.php      ← CRUD des livres
│   │       ├── ThemeController.php      ← CRUD des thèmes/catégories
│   │       └── EmpruntController.php    ← CRUD des emprunts + emails
│   └── Models/
│       ├── User.php      ← Modèle utilisateur (admin + adhérent)
│       ├── Livre.php     ← Modèle livre (appartient à un Thème)
│       ├── Theme.php     ← Modèle thème (a plusieurs Livres)
│       └── Emprunt.php   ← Modèle emprunt (lie User et Livre)
├── database/
│   ├── migrations/       ← Structure des tables SQL
│   └── seeders/          ← Données de test initiales
├── routes/
│   └── web.php           ← Toutes les routes de l'application
└── resources/views/      ← Les vues Blade (interface HTML Premium)
```

---

## 🗄️ Schéma de la Base de Données

```
┌──────────────┐       ┌──────────────┐       ┌──────────────────┐
│    users     │       │    livres    │       │     emprunts     │
├──────────────┤       ├──────────────┤       ├──────────────────┤
│ id (PK)      │───┐   │ id (PK)      │───┐   │ id (PK)          │
│ codeA        │   │   │ codeL        │   │   │ user_id (FK)─────┘
│ name         │   └──▶│ titre        │   └──▶│ livre_id (FK)────┘
│ email        │       │ auteur       │       │ dateEmp          │
│ password     │       │ nbExemplaire │       │ dateRetour       │
│ adresse      │       │ theme_id(FK)─┼──┐    └──────────────────┘
│ photo        │       └──────────────┘  │
│ role         │                         │    ┌──────────────┐
└──────────────┘                         │    │    themes    │
                                         │    ├──────────────┤
                                         └───▶│ id (PK)      │
                                               │ codeTh       │
                                               │ intitule     │
                                               └──────────────┘
```

---

## 🚀 Installation Express

1. **Cloner le projet** et lancer **XAMPP** (Apache & MySQL).
2. **Base de données :** Créer une base nommée `Gestion_biblio` dans phpMyAdmin.
3. **Configuration :**
   ```bash
   composer install
   npm install
   php artisan key:generate
   php artisan migrate --seed
   ```
4. **Lancement :**
   Ouvrir deux terminaux :
   - `php artisan serve`
   - `npm run dev`

---

## 🔑 Comptes de Test

| Rôle | Email | Mot de passe |
|---|---|---|
| **Admin** | `khaldi@gmail.com` | `khaldi` |
| **Adhérent** | `ahmed@gmail.com` | `ahmed` |

---

## 🗺️ Routes de l'Application

| URL | Méthode | Description | Auth |
|---|---|---|---|
| `/` | GET | Page d'accueil | Non |
| `/login` | GET | Page de connexion | Non |
| `/forgot-password` | GET | Demande de reset | Non |
| `/livres` | GET | Catalogue (Grid pour Adhérent) | ✅ Oui |
| `/emprunts` | GET | Liste des emprunts personnels | ✅ Oui |
| `/adherents` | GET | Gestion des membres (Admin) | 🛡️ Admin |

---

## 🎯 Prochaines Étapes (Tasks)

- [ ] **Historique de Lecture :** Ajouter une page "Livres déjà lus" pour les adhérents.
* [ ] **Mode Sombre (Dark Mode) :** Implémenter un switch visuel pour le confort nocturne.
* [ ] **Export PDF :** Permettre à l'admin d'exporter les statistiques d'emprunts.
* [ ] **Système de Favoris :** Permettre aux adhérents de "liker" des livres pour les retrouver plus tard.
* [ ] **Commentaires :** Laisser les adhérents écrire des critiques sur les livres.

---

## 👨‍💻 Développeurs

- **ElAttar** — Architecture & Backend
- **Soufi Rabie** — Design & Frontend Premium

---
<p align="center">Fait avec ❤️ et SmartLibrary</p>

## 🚧 Problèmes Fréquents

### ❌ Erreur : `php n'est pas reconnu comme commande`
**Solution :** PHP n'est pas dans le PATH de Windows.  
Ajoute le chemin de PHP de XAMPP à ta variable d'environnement PATH : `C:\xampp\php`

### ❌ Erreur : `SQLSTATE: Access denied` ou `Connection refused`
**Solution :** MySQL n'est pas démarré. Lance XAMPP et démarre MySQL.

### ❌ Erreur : `Table 'sessions' doesn't exist`
**Solution :** Tu n'as pas exécuté les migrations. Lance :
```bash
php artisan migrate
```

### ❌ La page CSS n'est pas chargée / styles manquants
**Solution :** Vite n'est pas démarré. Lance dans un terminal séparé :
```bash
npm run dev
```

### ❌ Erreur 500 après `migrate --seed`
**Solution :** Le seeder contient `Adherent::class` mais ce modèle n'existe pas. Vérifier le `DatabaseSeeder.php`.  
Lance `php artisan migrate:fresh --seed` pour repartir de zéro.

---

## 👨‍💻 Auteurs

- **ElAttar** — Développeur principal
- **Soufi Rabie** — Co-développeur

---

## 📄 Licence

Ce projet est développé dans un cadre académique.

---

<p align="center">Fait avec ❤️ et Laravel 12</p>
