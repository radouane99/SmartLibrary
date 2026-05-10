# 📚 SmartLibrary — Système de Gestion de Bibliothèque Premium

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white"/>
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white"/>
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white"/>
  <img src="https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white"/>
  <img src="https://img.shields.io/badge/Vite-6.x-646CFF?style=for-the-badge&logo=vite&logoColor=white"/>
</p>

> **SmartLibrary** est une application web moderne et professionnelle de gestion de bibliothèque. Pensée pour offrir une expérience utilisateur haut de gamme (Premium), elle automatise la gestion des emprunts, centralise la communication par email, et propose une interface utilisateur à la pointe des standards actuels.

---

## 🌟 Nouvelles Fonctionnalités & Mises à Jour Récentes

Le projet a récemment bénéficié d'une refonte majeure pour le rendre 100% prêt pour la production. Voici tout ce qui a été ajouté :

### 1. 📧 Système d'Emails HTML Centrés & Premium
Tous les emails générés par l'application ont été transformés en véritables templates HTML professionnels (centrés, responsives, avec dégradés et cartes d'informations) :
- **Confirmation de réservation** (Pour l'adhérent).
- **Refus de réservation** (Pour l'adhérent).
- **Validation de retour** (Pour l'adhérent).
- **Rappels automatiques de retard** (Alerte visuelle rouge).
- **Rappels manuels** (Alerte visuelle orange).
- **Notification Admin** (Alerte à l'administrateur lors d'une nouvelle demande).
- **Réinitialisation de mot de passe** (Design sécurisé et moderne).

### 2. 👤 Gestion Avancée du Profil
- **Menu Déroulant Intelligent :** Un menu profil complet dans la barre de navigation avec photo de l'utilisateur, rôle, et statut de connexion (point vert).
- **Modification de Profil :** L'utilisateur peut mettre à jour ses informations, changer son mot de passe en toute sécurité, et uploader une photo de profil (avec gestion automatique des images par défaut si non fournie).
- **Stockage Sécurisé :** Utilisation du système de stockage local de Laravel (`storage:link`) pour la gestion des avatars.

### 3. 🎨 Design UI/UX et Mode Sombre (Dark Mode)
- **Dark Mode Intégré :** Un bouton permet de basculer l'ensemble de l'application en mode sombre (confort visuel) avec persistance du choix.
- **Barre de Navigation Organisée :** Refonte totale de la Navbar pour être aérée, "glassmorphism", et sans liens redondants.
- **Assistant Virtuel (Chatbot UI) :** Ajout d'une interface flottante d'assistant chatbot (prête à être connectée à une IA) pour aider les utilisateurs.

---

## 💎 Avantages & Points Forts (Pourquoi SmartLibrary ?)

- **Facilité d'utilisation (Faciliter) :** Tout est pensé pour limiter le nombre de clics. Les actions comme l'emprunt ou le retour se font directement depuis des tableaux de bord clairs.
- **Séparation Stricte des Rôles :** Un adhérent ne verra jamais les outils de l'administrateur. L'interface s'adapte automatiquement au profil connecté.
- **Communication Proactive :** Grâce aux emails automatiques, les adhérents sont toujours informés de l'état de leurs réservations sans avoir à se connecter.
- **Esthétique Premium :** Fini les tableaux gris et tristes. L'application utilise des ombres, des coins arrondis, des badges de statut colorés et une typographie moderne (Inter).

---

## 🛡️ Sécurité & Authentification Avancée

La sécurité des données et des accès est au cœur de SmartLibrary, respectant les normes de développement modernes :

- **Authentification Sécurisée & Hachage :** Tous les mots de passe sont fortement hachés (algorithme Bcrypt) avant d'être sauvegardés en base de données. Même l'administrateur ne peut pas voir le mot de passe d'un adhérent.
- **Mot de Passe Oublié :** Un système complet et sécurisé permet à l'utilisateur de réinitialiser son mot de passe de manière autonome via un lien unique et temporaire envoyé par email.
- **Middlewares & Contrôle d'Accès (RBAC) :** Des barrières strictes (Middlewares Laravel) protègent les routes. Un adhérent ne peut pas taper l'URL du dashboard Admin sans se faire bloquer, et les visiteurs non connectés ne peuvent pas accéder au catalogue.
- **Protection CSRF & Injections SQL :** Tous les formulaires sont protégés contre les failles CSRF (Cross-Site Request Forgery) par des tokens dynamiques. Les requêtes en base de données utilisent l'ORM Eloquent qui empêche automatiquement les injections SQL.
- **Validation Stricte des Données :** Chaque saisie utilisateur (inscription, modification de profil, ajout d'un livre) est scrupuleusement filtrée et validée côté serveur (taille des images, format des emails, confirmation des mots de passe).

---


## 🛠️ Fonctionnalités de A à Z (Par Rôle)

### 👨‍💼 Espace Administrateur (Gestion Totale)
L'administrateur a le contrôle absolu sur la bibliothèque :
| Fonctionnalité | Description |
|---|---|
| 📊 **Dashboard & Stats** | Vue globale sur le nombre de livres lus, en cours, les retards et les inscriptions. |
| 📖 **Gestion du Catalogue** | Ajouter, modifier, ou supprimer des livres et des thèmes (catégories). |
| 👥 **Gestion des Adhérents** | Voir la liste des membres, bloquer ou supprimer un compte si nécessaire. |
| 📋 **Monitoring des Emprunts** | Valider les demandes de réservation, marquer un livre comme rendu, ou refuser une demande. |
| 🚨 **Gestion des Retards** | Cliquer sur "Rappeler" pour envoyer instantanément un email de relance stylisé à un membre en retard. |

### 👤 Espace Adhérent (Autonomie)
L'adhérent profite d'une expérience fluide et personnalisée :
| Fonctionnalité | Description |
|---|---|
| 📚 **Catalogue Interactif** | Parcourir les livres avec un design en grille moderne et utiliser la barre de recherche globale. |
| ⚡ **Emprunt Rapide** | Demander la réservation d'un livre en un clic (en attente de validation admin). |
| 📋 **Historique Personnel** | Suivre l'état de ses emprunts (Validé, Refusé, Rendu, En cours). |
| ⚙️ **Paramètres & Profil** | Modifier sa photo, ses coordonnées et son mot de passe en toute autonomie. |

---

## 🏗️ Architecture du Projet

```text
Gestio Bib Laravel/
├── app/
│   ├── Http/Controllers/
│   │   ├── AuthController.php       ← Connexion / Inscription / Reset
│   │   ├── AdherentController.php   ← Gestion profil & membres
│   │   ├── LivreController.php      ← CRUD des livres
│   │   └── EmpruntController.php    ← Logique des réservations & Envoi d'Emails
│   └── Models/
│       ├── User.php      ← Utilisateurs (Admin & Adhérents)
│       ├── Livre.php     ← Livres
│       └── Emprunt.php   ← Table pivot avec statuts d'emprunt
├── database/
│   ├── migrations/       ← Structure SQL robuste
│   └── seeders/          ← Données de test (DatabaseSeeder)
├── routes/
│   └── web.php           ← Routes protégées par Middlewares
└── resources/views/      
    ├── emails/           ← Templates HTML d'emails Premium 🆕
    └── layouts/          ← _pageLayout.blade.php (Structure globale, Navbar, Footer)
```

---

## 🗄️ Schéma de la Base de Données

```text
┌──────────────┐       ┌──────────────┐       ┌──────────────────┐
│    users     │       │    livres    │       │     emprunts     │
├──────────────┤       ├──────────────┤       ├──────────────────┤
│ id (PK)      │───┐   │ id (PK)      │───┐   │ id (PK)          │
│ codeA        │   │   │ codeL        │   │   │ user_id (FK)─────┘
│ name         │   └──▶│ titre        │   └──▶│ livre_id (FK)────┘
│ email        │       │ auteur       │       │ dateEmp          │
│ password     │       │ nbExemplaire │       │ dateRetour       │
│ photo        │       │ theme_id(FK)─┼──┐    │ statut (enum)    │
│ role         │       └──────────────┘  │    └──────────────────┘
└──────────────┘                         │    ┌──────────────┐
                                         │    │    themes    │
                                         │    ├──────────────┤
                                         └───▶│ id (PK)      │
                                               │ intitule     │
                                               └──────────────┘
```

---

## 🚀 Installation Express & Configuration

1. **Cloner le projet** et démarrer votre serveur local (ex: XAMPP).
2. **Base de données :** Créer une base nommée `Gestion_biblio`.
3. **Commandes d'initialisation :**
   Dans le terminal du projet, exécutez ces commandes l'une après l'autre :
   ```bash
   composer install
   npm install
   cp .env.example .env
   php artisan key:generate
   php artisan migrate:fresh --seed
   ```
4. **Lien de stockage (TRÈS IMPORTANT pour les photos de profil) :**
   ```bash
   php artisan storage:link
   ```
5. **Configuration Email (.env) via GMAIL SMTP :**
   Le système est configuré pour envoyer de vrais emails (Confirmation, Réservation, Rappels). Nous utilisons **Gmail SMTP**.
   Dans votre fichier `.env`, configurez ces paramètres :
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=465
   MAIL_USERNAME=votre_adresse@gmail.com
   MAIL_PASSWORD=votre_mot_de_passe_d_application
   MAIL_ENCRYPTION=smtps
   MAIL_FROM_ADDRESS=votre_adresse@gmail.com
   MAIL_FROM_NAME="SmartLibrary"
   ```
   *Note : Vous devez générer un "Mot de passe d'application" dans les paramètres de sécurité de votre compte Google.*

6. **Lancement de l'application :**
   ```bash
   php artisan serve
   ```

---

## 🎬 Scénarios d'Utilisation (Workflow)

Pour bien comprendre la puissance de SmartLibrary, voici 3 scénarios typiques :

### Scénario 1 : Le nouvel adhérent réserve un livre
1. **L'Adhérent** crée son compte via la page d'inscription.
2. Il arrive sur le **Catalogue**, cherche un livre ("Harry Potter" par exemple) et clique sur **"Réserver"**.
3. *Magie !* Il reçoit instantanément un **email premium** lui confirmant que sa demande a été envoyée à l'administrateur.

### Scénario 2 : L'Admin valide la demande
1. **L'Administrateur** se connecte et voit une notification sur son Dashboard.
2. Il va dans "Emprunts", trouve la demande en statut "En attente", et clique sur **"Valider"**.
3. La date de retour est fixée (ex: dans 15 jours).
4. *Magie !* L'adhérent reçoit un **email de validation** lui indiquant qu'il peut venir chercher le livre, avec la date limite de retour.

### Scénario 3 : Le Retour et les Retards
- **Option A (Tout se passe bien) :** L'adhérent ramène le livre, l'Admin clique sur **"Marqué comme Rendu"**. L'adhérent reçoit un email le remerciant de l'avoir ramené.
- **Option B (Retard) :** Si la date est dépassée, l'Admin peut cliquer sur le bouton **"Rappeler"**. L'adhérent reçoit immédiatement une **alerte rouge par email** lui demandant de ramener le livre d'urgence.


---

## 🔑 Comptes de Test (Générés par le Seeder)

| Rôle | Email | Mot de passe |
|---|---|---|
| **Administrateur** | `khaldi@gmail.com` | `khaldi` |
| **Adhérent** | `ahmed@gmail.com` | `ahmed` |

---

## 🚧 Résolution des Problèmes Fréquents

### ❌ Les photos de profil ne s'affichent pas (Image cassée)
**Solution :** Vous avez oublié de créer le lien symbolique. Exécutez `php artisan storage:link` dans votre terminal.

### ❌ Erreur : `SQLSTATE: Access denied`
**Solution :** Vérifiez que MySQL (XAMPP) est bien allumé et que le nom de la BD dans votre fichier `.env` est correct.

### ❌ Les emails ne s'envoient pas (Timeout)
**Solution :** Assurez-vous d'avoir bien configuré vos identifiants SMTP dans le fichier `.env` et que vous avez une connexion internet active.

---

## 👨‍💻 Développeurs & Auteurs

- **ElAttar** — Architecture & Backend
- **Soufi Rabie** — Design UI/UX, Frontend Premium & Logique Emails

---
<p align="center">Fait avec ❤️, passion, et Laravel</p>
