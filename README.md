# PromptRepo - La Knowledge Base des Prompts Performants

Plateforme interne de Knowledge Management pour stocker, catégoriser et réutiliser des prompts IA testés et approuvés.

## Technos utilisées

- **Backend** : PHP 8 (OOP)
- **Database** : MySQL / MariaDB
- **Frontend** : HTML, CSS (Dark Theme)
- **Serveur** : Apache (XAMPP)

## Fonctionnalités

- Inscription / Connexion sécurisée (password_hash, sessions)
- CRUD Prompts (Create, Read, Update, Delete)
- Filtre par catégorie
- Page détail avec bouton "Copy Prompt"
- Dashboard Admin (stats, top contributeurs)
- Gestion des catégories (admin)
- Protection : Prepared Statements (anti SQL Injection)

## Installation

1. Installer [XAMPP](https://www.apachefriends.org/)
2. Cloner le repo dans `htdocs/` :
   ```
   git clone https://github.com/zinebtalghmet/PROMPT_REPO.git
   ```
3. Démarrer Apache et MySQL dans XAMPP
4. Importer `prompt_repo.sql` dans phpMyAdmin
5. Accéder à : `http://localhost/PROMPT_REPO/`

## Comptes de test

| Role  | Email              | Password |
|-------|--------------------|----------|
| Admin | admin@devgenius.io | admin123 |
| User  | omar@devgenius.io  | user123  |

## Structure du projet

```
PROMPT_REPO/
├── config/
│   └── Database.php          # Connexion PDO
├── classes/
│   ├── User.php              # Auth (register, login)
│   ├── Category.php          # CRUD catégories
│   └── Prompt.php            # CRUD prompts + INNER JOIN
├── auth/
│   ├── login.php
│   ├── registre.php
│   └── logout.php
├── prompts/
│   ├── index.php             # Liste + filtre
│   ├── create.php
│   ├── edit.php
│   ├── delete.php
│   └── view.php              # Détail prompt
├── admin/
│   ├── Dashboard.php         # Stats + top contributeurs
│   └── categories.php        # CRUD catégories
├── css/
│   ├── style.css             # Dark theme principal
│   └── auth.css              # Style login/register
├── prompt_repo.sql           # Script SQL + seed data
└── README.md
```

## Auteur

Zineb Talghmet - DevGenius Solutions
