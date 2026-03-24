Prompt Repository - La Knowledge Base des Prompts Performants
Contexte du Projet
Vous travaillez pour DevGenius Solutions, une agence de développement Full-Stack qui intègre l'IA au cœur de son workflow. Les développeurs utilisent quotidiennement des LLM (Large Language Models) pour générer du code, créer des scripts de test, ou rédiger des documentations techniques.
Le Problème : Beaucoup de "Prompts performants" (ceux qui donnent des résultats parfaits) se perdent dans l'historique de chat des développeurs. 
La Mission : L'agence vous demande de créer une plateforme interne de Knowledge Management. L'objectif est de permettre aux équipes de stocker, de catégoriser (Code, Marketing, DevOps, SQL, etc.) et de réutiliser ces actifs précieux pour ne plus jamais "perdre" une instruction qui fonctionne.

Objectifs & User Stories
Objectifs Techniques
Conception d'une architecture Relational Database normalisée.
Mise en place d'une Authentication sécurisée pour l'accès interne.
Maîtrise du cycle CRUD (Create, Read, Update, Delete) avec PHP/MySQL.
User Stories (Besoins Business)
En tant que Développeur : Je veux créer mon compte pour accéder à la bibliothèque.
En tant que Développeur : Je veux enregistrer un prompt "testé et approuvé" avec un titre et sa catégorie.
En tant que Développeur : Je veux pouvoir filtrer les prompts par thématique (ex: voir uniquement les prompts "Marketing" ou "Code").
En tant qu'Admin : Je veux gérer les catégories et voir qui sont les contributeurs les plus actifs.

Spécifications Techniques
Database Layer :
3 tables obligatoires : users, categories, prompts.
Utilisation stricte des Foreign Keys pour lier les prompts aux auteurs et thématiques.
Backend PHP :
Fichier de connexion centralisé db.php avec PDO.
Utilisation de Prepared Statements pour garantir la sécurité des données.
Gestion de l'état utilisateur via les Sessions.
Security :
Password Security : password_hash() à l'inscription.
Data Integrity : Validation des formulaires côté serveur (champs vides, formats).

Modalités Pédagogiques
Mode : Individuel.
Durée : 4 jours.
Date de lancement : 24/03/2026 – 10:00 AM.
Deadline : 27/03/2026 – 17:00 PM.

Modalités d'Évaluation
Entretien individuel de 25 à 30 minutes composé de :
Démonstration (10 min) : Parcours complet de l'application (inscription -> ajout de prompt -> recherche).
Code Review (10 min) : Explication du schéma SQL et de la logique PHP.
Mise en situation (10 min) : Modification "Live" demandée par le formateur (ex: "Modifiez la requête SQL pour afficher les prompts du plus récent au plus ancien").

Livrables Attendus
Dépôt GitHub : Propre, avec des commits explicites.
Fichier SQL : Script complet de création et de "seeding" (données de test).
README.md : Technos utilisées, capture d'écran, instructions d'installation.

Critères de Performance
Zéro SQL Injection : Aucune variable PHP directement dans les chaînes de requêtes.
Clean Code : Indentation propre et séparation de la logique (PHP) du visuel (HTML).
Relationnel : Utilisation de INNER JOIN pour afficher le nom de la catégorie dans la liste des prompts.

Bonus (Advanced Tracks)
OOP Mode : Migrer la connexion et les méthodes CRUD vers des Classes.
Advanced Search : Recherche multi-critères (par titre ET par catégorie simultanément).

