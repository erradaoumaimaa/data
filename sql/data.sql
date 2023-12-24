CREATE DATABASE db_dataware;

-- Structure de la table `users`
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    image_url VARCHAR(255),
    role VARCHAR(50) NOT NULL,
    UNIQUE(username),
    UNIQUE(email)
);
-- Structure de la table `projects`
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(25) NOT NULL,
    description TEXT,
    date_start DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP(),
    date_end DATETIME,
    status VARCHAR(25),
    product_owner_id INT,
    FOREIGN KEY (product_owner_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Structure de la table `teams`
CREATE TABLE teams (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    created_at DATETIME NOT NULL,
    description LONGTEXT NOT NULL,
    scrum_master_id INT,
    FOREIGN KEY (scrum_master_id) REFERENCES users(id) ON DELETE SET NULL
);

-- Structure de la table `team_members`
CREATE TABLE team_members (
    id_teams_membre INT AUTO_INCREMENT PRIMARY KEY,
    team_id INT,
    user_id INT,
    is_scrum_master BOOLEAN,
    UNIQUE (team_id, user_id),
    FOREIGN KEY (team_id) REFERENCES teams(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);






