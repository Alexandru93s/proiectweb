CREATE DATABASE IF NOT EXISTS db_clinica;
USE db_clinica;

CREATE USER 'userclinica'@'localhost' IDENTIFIED BY 'changeit';
GRANT ALL PRIVILEGES ON db_clinica.* TO 'userclinica'@'localhost';


CREATE TABLE IF NOT EXISTS specializari (
  id INT(11) NOT NULL AUTO_INCREMENT,
  nume VARCHAR(100) NOT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY (nume)
);


INSERT INTO specializari (nume) VALUES
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