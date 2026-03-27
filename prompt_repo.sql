CREATE DATABASE IF NOT EXISTS prompt_repo;
USE prompt_repo;

-- ==================== TABLES ====================

CREATE TABLE Users (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL UNIQUE,
    Password VARCHAR(255) NOT NULL,
    Email VARCHAR(150) NOT NULL UNIQUE,
    Role ENUM('admin','user') DEFAULT 'user',
    Created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Categories (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(50) NOT NULL,
    Created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Prompts (
    Id INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    User_Id INT NOT NULL,
    Category_Id INT NOT NULL,
    FOREIGN KEY (User_Id) REFERENCES Users(Id),
    FOREIGN KEY (Category_Id) REFERENCES Categories(Id),
    Created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ==================== SEED DATA ====================

-- Users (admin123 / user123)
INSERT INTO Users (Username, Password, Email, Role) VALUES
('admin', '$2y$12$fXgOfXNUOV/m8uSId249uOzdSL4wSZ1Lyyuvuj4Xd9TCpS4i4Uq8C', 'admin@devgenius.io', 'admin'),
('omar_dev', '$2y$12$H1V/asl2qWS58uQWbW05P.e5HZ4WrIJrK2Up3vZBfYfQ9izmKiRsi', 'omar@devgenius.io', 'user'),
('salma_ui', '$2y$12$H1V/asl2qWS58uQWbW05P.e5HZ4WrIJrK2Up3vZBfYfQ9izmKiRsi', 'salma@devgenius.io', 'user');

-- Categories
INSERT INTO Categories (Title) VALUES
('Code'), ('Marketing'), ('DevOps'), ('SQL'), ('Science'), ('Finance'), ('Testing');

-- Prompts
INSERT INTO Prompts (Title, content, User_Id, Category_Id) VALUES
('React Hook Form Validator', 'Generate a complete React form validation system using custom hooks. Include error handling, field validation rules, and a reusable pattern for login, registration, and contact forms.', 1, 1),
('Email Marketing Campaign', 'Design an email marketing platform interface with campaign creation, contact management, templates, and analytics. Focus on ease of use and modern UI patterns.', 2, 2),
('Docker Compose Setup', 'Create a production-ready Docker Compose configuration with Nginx, PHP-FPM, and MySQL. Include volume mapping, environment variables, and health checks.', 3, 3),
('PostgreSQL Index Advisor', 'Analyze slow SQL queries and generate optimal indexes. Include EXPLAIN ANALYZE output interpretation and suggestions for composite indexes.', 1, 4),
('Python Unit Test Generator', 'Generate comprehensive Python unit tests with pytest. Include fixtures, parametrized tests, mocking, and edge case coverage for a given function.', 2, 1),
('SEO Blog Post Writer', 'Create SEO-optimized blog posts with proper heading structure, meta descriptions, keyword integration, and engaging content for technical topics.', 3, 2);