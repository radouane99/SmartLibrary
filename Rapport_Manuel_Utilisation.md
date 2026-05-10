# RAPPORT DE PRÉSENTATION & MANUEL D'UTILISATION
## PROJET : SmartLibrary - Système Numérique de Gestion de Bibliothèque

---

### TABLE DES MATIÈRES
1. [Introduction et Contexte](#1-introduction-et-contexte)
2. [Objectifs de l'Application](#2-objectifs-de-lapplication)
3. [Fonctionnalités Principales](#3-fonctionnalités-principales)
4. [Architecture et Choix Techniques](#4-architecture-et-choix-techniques)
5. [Manuel d'Utilisation : Espace Public](#5-manuel-dutilisation--espace-public)
6. [Manuel d'Utilisation : Espace Adhérent](#6-manuel-dutilisation--espace-adhérent)
7. [Manuel d'Utilisation : Espace Administrateur](#7-manuel-dutilisation--espace-administrateur)
8. [La Communication Automatisée (Mailing)](#8-la-communication-automatisée-mailing)
9. [L'API Sécurisée](#9-lapi-sécurisée)
10. [Conclusion](#10-conclusion)

---

### 1. Introduction et Contexte
À l'ère de la digitalisation, la gestion des ressources littéraires et documentaires requiert des solutions logicielles performantes. Les bibliothèques traditionnelles souffrent souvent de processus lents : gestion papier des emprunts, relances téléphoniques chronophages pour les retards, et absence d'un catalogue facilement consultable à distance par les lecteurs.
C'est pour répondre à cette problématique que nous avons conçu **SmartLibrary**. Il s'agit d'une plateforme web robuste développée sous Laravel, qui vise à informatiser 100% des flux d'une bibliothèque physique.

### 2. Objectifs de l'Application
- **Automatisation :** Réduire la charge de travail de l'administrateur en gérant automatiquement les statuts des livres et les envois d'emails de rappel.
- **Accessibilité :** Offrir aux utilisateurs un accès 24/7 au catalogue depuis n'importe quel appareil (ordinateur, tablette, mobile).
- **Expérience Utilisateur (UX) :** Fournir une interface agréable (Premium), avec un thème sombre (Dark Mode) pour le confort visuel, et une navigation sans friction.
- **Sécurité :** Garantir que les données personnelles et les mots de passe sont hautement sécurisés (Bcrypt) et que l'accès aux fonctionnalités d'administration est strictement verrouillé (Middlewares).

### 3. Fonctionnalités Principales
L'application se divise en de multiples modules gérant l'ensemble du cycle de vie du livre :
- **Authentification & Inscription :** Système d'onboarding complet avec validation stricte.
- **Catalogue Dynamique :** Affichage riche des livres avec fonction de recherche instantanée.
- **Workflow d'Emprunt :** Demande de l'utilisateur -> Validation de l'Admin -> Prêt en cours -> Retour (ou Retard).
- **Système de Mailing HTML :** Notifications Premium pour chaque étape du Workflow.
- **Interface API REST :** Permet à une application mobile future de se connecter au catalogue via un système de Token (Bearer).

### 4. Architecture et Choix Techniques
- **Backend :** Laravel 11 (PHP 8.2+). Choisi pour sa sécurité (CSRF, ORM Eloquent contre les injections SQL) et sa rapidité de développement.
- **Base de données :** MySQL relationnelle. 4 tables principales (`users`, `livres`, `themes`, `emprunts`).
- **Frontend :** HTML5, CSS3, Bootstrap 5. Utilisation du CSS pur pour les effets avancés comme le "Glassmorphism" (transparence et flou).
- **Versioning :** Git & GitHub pour le travail collaboratif.

---

### 5. Manuel d'Utilisation : Espace Public

L'espace public est la vitrine de l'application. Un visiteur non connecté ne peut pas consulter le catalogue, il doit d'abord s'identifier.

#### 5.1 La Page de Connexion (Login)
> *[ 🖼️ INSERER ICI LA CAPTURE D'ECRAN DE LA PAGE LOGIN ]*
- **Description :** L'interface d'entrée de SmartLibrary. Elle est épurée et met en valeur la marque.
- **Comment l'utiliser :** L'utilisateur entre son adresse email et son mot de passe. Il peut également activer le Mode Sombre via l'icône dans la barre de navigation. S'il n'a pas de compte, un lien le redirige vers l'inscription.

#### 5.2 La Page d'Inscription (Register)
> *[ 🖼️ INSERER ICI LA CAPTURE D'ECRAN DE LA PAGE D'INSCRIPTION ]*
- **Description :** Le formulaire de création de profil.
- **Comment l'utiliser :** Remplir le nom complet, le code adhérent (ex: B1234), l'adresse postale, l'email et un mot de passe sécurisé. Le système validera que l'email est unique avant de créer le compte.

---

### 6. Manuel d'Utilisation : Espace Adhérent

Dès la connexion d'un membre avec le rôle "adherent", l'interface s'adapte pour ne montrer que ce qui le concerne.

#### 6.1 Le Catalogue des Livres
> *[ 🖼️ INSERER ICI LA CAPTURE D'ECRAN DU CATALOGUE (Cartes des livres) ]*
- **Description :** C'est le cœur de l'application pour le lecteur. Les livres sont affichés sous forme de "Cartes" (Cards) élégantes.
- **Comment l'utiliser :** L'adhérent fait défiler la liste ou utilise la barre de recherche. Pour emprunter un livre, il lui suffit de cliquer sur le bouton bleu **"Réserver"**. Une alerte de confirmation apparaît alors.

#### 6.2 La Gestion du Profil Utilisateur
> *[ 🖼️ INSERER ICI LA CAPTURE D'ECRAN DU MENU DEROULANT ET DE LA PAGE PROFIL ]*
- **Description :** En cliquant sur son nom en haut à droite, l'adhérent accède à un menu déroulant "Glassmorphism".
- **Comment l'utiliser :** En cliquant sur "Mon Profil", l'utilisateur peut modifier ses données personnelles, changer son mot de passe, ou télécharger une nouvelle photo de profil (Avatar).

#### 6.3 Le Suivi des Emprunts
> *[ 🖼️ INSERER ICI LA CAPTURE D'ECRAN DE LA LISTE "MES EMPRUNTS" ]*
- **Description :** Un tableau récapitulant l'historique de lecture de l'adhérent.
- **Comment l'utiliser :** L'adhérent peut voir si sa demande est "En attente" ou "Validée", et vérifier la date à laquelle il doit rendre son livre.

---

### 7. Manuel d'Utilisation : Espace Administrateur

Si l'utilisateur connecté possède le rôle "admin", la barre de navigation se dote de nouveaux liens cruciaux (Dashboard, Gestion, etc.).

#### 7.1 Le Dashboard (Tableau de Bord)
> *[ 🖼️ INSERER ICI LA CAPTURE D'ECRAN DU DASHBOARD (Statistiques) ]*
- **Description :** Un centre de contrôle visuel.
- **Comment l'utiliser :** L'admin consulte les cartes de statistiques en haut de la page pour savoir combien de livres sont actuellement en retard, ou combien d'adhérents sont inscrits.

#### 7.2 La Gestion du Catalogue (Livres & Thèmes)
> *[ 🖼️ INSERER ICI LA CAPTURE D'ECRAN DE LA LISTE DES LIVRES ADMIN + BOUTONS ACTIONS ]*
- **Description :** L'interface CRUD (Create, Read, Update, Delete) de la bibliothèque.
- **Comment l'utiliser :** L'admin peut cliquer sur "Ajouter un Livre". Dans le formulaire, il renseigne les détails et upload la couverture de l'œuvre. Il peut également éditer ou supprimer n'importe quel livre.

#### 7.3 Le Contrôle des Emprunts
> *[ 🖼️ INSERER ICI LA CAPTURE D'ECRAN DU TABLEAU DE GESTION DES EMPRUNTS ]*
- **Description :** Le tableau le plus important pour le bibliothécaire.
- **Comment l'utiliser :** 
  - Face à une demande "En attente", l'admin clique sur le bouton **"Valider"**. 
  - Quand le lecteur ramène le livre, l'admin clique sur **"Marquer comme Rendu"**. L'inventaire (nbExemplaire) s'ajuste automatiquement.
  - Face à un statut "Retard", l'admin clique sur le bouton **"Rappeler"**.

---

### 8. La Communication Automatisée (Mailing)

Afin d'offrir une expérience de haute qualité, nous avons intégré un système de notifications par e-mail au format HTML dynamique (pas de simple texte brut).

> *[ 🖼️ INSERER ICI LA CAPTURE D'ECRAN D'UN EMAIL REÇU (ex: Le template rouge de Retard ou le template bleu de Validation) ]*
- **Flux de Réservation :** L'utilisateur est notifié dès qu'il réserve, puis notifié quand l'admin valide sa demande.
- **Flux de Relance :** Le bouton "Rappeler" de l'admin déclenche instantanément l'envoi d'un email rouge très visible demandant à l'adhérent de restituer le livre en urgence.

---

### 9. L'API Sécurisée

En réponse aux besoins technologiques de demain, SmartLibrary est API-ready.
> *[ 🖼️ INSERER ICI UNE CAPTURE D'ECRAN DE POSTMAN MONTRANT LE JSON RETOURNÉ ]*
- **Description :** L'application dispose de 3 endpoints API (`/api/livres`, `/api/themes`, `/api/user`).
- **Sécurité :** Ces routes sont invisibles sans un Token (Bearer). L'utilisateur doit s'authentifier via `/api/login` pour recevoir ce token chiffré, prouvant ainsi la robustesse de l'architecture.

---

### 10. Conclusion

SmartLibrary est l'aboutissement d'un travail architectural et esthétique. L'application ne se contente pas de stocker des données ; elle communique avec l'utilisateur, s'adapte à ses besoins visuels (Dark Mode), et facilite grandement la gestion administrative grâce à ses automatisations. 
Ce projet démontre nos compétences complètes sur la stack Laravel (Backend), la structuration de bases de données, et l'intégration de maquettes (Frontend).
