# Rapport de Présentation & Manuel d'Utilisation
## Projet : SmartLibrary (Gestion de Bibliothèque)

---

### 1. Description Générale de l'Application

**Contexte :**
Dans le cadre de notre projet de développement, nous avons conçu "SmartLibrary", une application web moderne de gestion de bibliothèque. De nos jours, la gestion des emprunts et des ouvrages nécessite des outils numériques performants, esthétiques et automatisés pour faciliter la tâche des administrateurs tout en offrant une expérience fluide aux adhérents.

**Objectif :**
L'objectif de SmartLibrary est de digitaliser intégralement le processus de prêt de livres. L'application permet de gérer un catalogue d'ouvrages, de suivre les emprunts, d'automatiser les rappels via des notifications par email, et d'offrir une interface "Premium" garantissant une accessibilité maximale (mode sombre, design responsive).

**Fonctionnalités Principales :**
- **Système d'authentification et gestion des rôles :** Distingue les actions possibles entre un "Administrateur" et un "Adhérent".
- **Catalogue interactif :** Recherche, filtrage et consultation des livres disponibles.
- **Gestion des emprunts et réservations :** Flux complet (demande, validation, prêt en cours, retour).
- **Communication automatisée (Mailing) :** Envoi d'emails professionnels pour les confirmations de réservation, les validations, les retours et les relances de retard.
- **Dashboard analytique :** Suivi statistique en temps réel pour l'administrateur.
- **API REST :** Endpoints sécurisés par token pour interagir avec l'application depuis d'autres plateformes.

---

### 2. Guide d'Utilisation par Rôle (Avec Captures d'Écran)

#### A. Accès Public (Visiteur non connecté)

**Page d'Accueil / Connexion**
> *[ INSERER CAPTURE D'ECRAN DE LA PAGE DE LOGIN ]*
**Explication :** La page d'authentification. L'utilisateur doit saisir son email et mot de passe. S'il n'a pas de compte, il peut cliquer sur "S'inscrire".
**Utilisation :** Entrer les identifiants pour accéder à son espace. Le système détecte automatiquement s'il s'agit d'un admin ou d'un adhérent.

**Page d'Inscription**
> *[ INSERER CAPTURE D'ECRAN DE LA PAGE REGISTER ]*
**Explication :** Formulaire de création de compte pour les nouveaux adhérents.
**Utilisation :** Remplir les champs obligatoires. Les validations vérifient que l'email n'est pas déjà utilisé et que les mots de passe correspondent.

---

#### B. Espace Adhérent (Utilisateur Normal)

L'adhérent a un accès restreint. Il ne peut gérer que son propre profil et interagir avec le catalogue.

**Le Catalogue de Livres**
> *[ INSERER CAPTURE D'ECRAN DU CATALOGUE DE LIVRES (Côté adhérent) ]*
**Explication :** La page principale de l'adhérent. Elle affiche sous forme de cartes tous les livres disponibles (dont les ouvrages marocains comme "La Boîte à Merveilles").
**Utilisation :** L'utilisateur peut utiliser la barre de recherche en haut. Pour emprunter un livre, il lui suffit de cliquer sur le bouton "Réserver".

**Mon Profil et Mes Emprunts**
> *[ INSERER CAPTURE D'ECRAN DE LA PAGE PROFIL / MENU DEROULANT ]*
**Explication :** Accessible via la barre de navigation "glassmorphism", le menu déroulant permet à l'adhérent d'accéder à ses informations.
**Utilisation :** L'utilisateur peut mettre à jour sa photo de profil, changer son mot de passe, ou consulter l'état de ses demandes de réservation (En attente, Validé, etc.).

**Notification par Email (Exemple de Réservation)**
> *[ INSERER CAPTURE D'ECRAN DE L'EMAIL REÇU ]*
**Explication :** Exemple du template premium reçu par l'adhérent après une action.
**Utilisation :** L'email confirme instantanément à l'adhérent que sa demande est bien enregistrée.

---

#### C. Espace Administrateur (Contrôle Total)

L'administrateur a accès à des menus cachés aux adhérents pour gérer toute la bibliothèque.

**Le Dashboard (Tableau de bord)**
> *[ INSERER CAPTURE D'ECRAN DU DASHBOARD ADMIN AVEC LES STATS ]*
**Explication :** Le centre de contrôle. Affiche le nombre total de livres, d'adhérents, et les emprunts en cours.
**Utilisation :** Permet à l'admin d'avoir une vue globale instantanée sur l'activité de la bibliothèque.

**Gestion des Emprunts & Retards**
> *[ INSERER CAPTURE D'ECRAN DU TABLEAU DES EMPRUNTS ]*
**Explication :** Liste complète de toutes les demandes. Les statuts sont clairs avec des badges colorés (En attente, En cours, Rendu, Retard).
**Utilisation :** L'admin utilise cette page pour "Valider" une demande. Si un adhérent est en retard, un bouton rouge "Rappeler" permet d'envoyer un email de relance instantané.

**Gestion du Catalogue (Ajout d'un Livre / Thème)**
> *[ INSERER CAPTURE D'ECRAN DU FORMULAIRE D'AJOUT D'UN LIVRE ]*
**Explication :** L'interface de gestion (CRUD) des ouvrages.
**Utilisation :** L'admin remplit le titre, choisit l'auteur, associe un thème, télécharge une image de couverture et définit le nombre d'exemplaires.

**Gestion des Utilisateurs**
> *[ INSERER CAPTURE D'ECRAN DE LA LISTE DES ADHERENTS ]*
**Explication :** Liste des membres inscrits.
**Utilisation :** L'admin peut consulter les coordonnées d'un adhérent ou supprimer un compte si nécessaire.

---

### 3. Conclusion
SmartLibrary démontre une maîtrise complète du framework Laravel : de la conception de la base de données relationnelle à la sécurisation des routes, en passant par le développement d'une API et d'une interface utilisateur (UI/UX) très soignée. Ce manuel prouve la fiabilité et la facilité d'utilisation de notre système.
