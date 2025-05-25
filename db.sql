CREATE DATABASE IF NOT EXISTS db_clinica;
USE db_clinica;

CREATE USER IF NOT EXISTS 'userclinica'@'localhost' IDENTIFIED BY 'changeit';
GRANT ALL PRIVILEGES ON db_clinica.* TO 'userclinica'@'localhost';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS specializari (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nume VARCHAR(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (nume)
);

INSERT IGNORE INTO specializari (nume) VALUES
('Medicina interna'),
('Ecografie Doppler color'),
('Cardiologie'),
('Neurologie'),
('Psihiatrie'),
('Dermato-venerologie'),
('O.R.L.'),
('Oftalmologie'),
('Medicina muncii'),
('Ortopedie'),
('Fizioterapie'),
('Psihologie'),
('Ginecologie'),
('Pneumologie'),
('Hematologie'),
('Remodelare corporala'),
('Masaj terapeutic');


CREATE TABLE IF NOT EXISTS admin_users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY (username)
);

-- Insert admin with properly hashed password (password: 'password')
INSERT IGNORE INTO admin_users (username, password) VALUES 
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

CREATE TABLE IF NOT EXISTS medici (
    id INT(11) NOT NULL AUTO_INCREMENT,
    specializare VARCHAR(100) NOT NULL COMMENT 'Medical specialization (e.g., Cardiologie, Neurologie)',
    nume VARCHAR(100) NOT NULL COMMENT 'Doctor name (e.g., Dr. Popescu Ion)',
    descriere TEXT COMMENT 'Optional details (e.g., "Medic primar", "Specialist in ecografie")',
    PRIMARY KEY (id),
    INDEX (specializare)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO medici (specializare, nume, descriere, cas) VALUES
('Fizioterapie', 'Dr. Unguru Aurora', 'medic primar reabilitare medicala', 1),
('Fizioterapie', 'Prof. Univ. Dr. Traistaru Rodica Magdalena', 'medic primar reabilitare medicala', 1),
('Medicina muncii', 'Dr. Stroe-Parvulescu Mihaela', 'medic primar medicina muncii', 0),
('ORL', 'Dr. Stanculescu Beatrice', 'medic primar ORL', 0);