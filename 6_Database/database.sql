# Database.sql
# File di creazione per il database MySQL.
#
# @author Filippo Finke

# Elimino il database se esiste già.
DROP DATABASE IF EXISTS ritardi;
# Creo il database ritardi.
CREATE DATABASE ritardi;
# Seleziono il database da utilizzare.
USE ritardi;

# Creazione della tabella user.
#
# Permessi:
# 1 - Inserimento ritardi. 0b0001
# 2 - Visione ritardi.     0b0010
# 4 - Creazione PDF.       0b0100
# 8 - Amministratore.      0b1000
CREATE TABLE user (
    email VARCHAR(255) PRIMARY KEY,
    name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    password VARCHAR(60) NOT NULL,
    permission INT NOT NULL
);

INSERT INTO user VALUES("admin@samtrevano.ch", "Admin", "Account", "$2y$10$oW/jP8Jg0OQSR6aT7VGf8OCTcdG8eoqYxN/4PQDsYBj81K05jPFAm", 8);
INSERT INTO user VALUES("filippo.finke@samtrevano.ch", "Filippo", "Finke", "$2y$10$oW/jP8Jg0OQSR6aT7VGf8OCTcdG8eoqYxN/4PQDsYBj81K05jPFAm", 8);

# Creazione della tabella token che verrà utilizzata per
# la gestione del recupero password.
CREATE TABLE token (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(64) UNIQUE NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(email) REFERENCES user(email) ON UPDATE CASCADE ON DELETE CASCADE
);

# Creazione della tabella setting che verrà utilizzata per
# immagazzinare tutte le impostazioni del sito web.
CREATE TABLE setting (
    name VARCHAR(50) PRIMARY KEY,
    value VARCHAR(255) NOT NULL,
    type VARCHAR(30) NOT NULL
);

INSERT INTO setting VALUES("max_delays", "3", "number");
INSERT INTO setting VALUES("from_email", "gestione-ritardi@no-reply.ch", "email");

# Creazione della tabella section che verrà utilizzata per
# immagazzinare tutte le sezioni.
CREATE TABLE section (
    name VARCHAR(10) PRIMARY KEY,
    deleted TINYINT DEFAULT 0
);

INSERT INTO section VALUES("SAM I1AA", 0);
INSERT INTO section VALUES("SAM I2AA", 0);
INSERT INTO section VALUES("SAM I3AA", 0);
INSERT INTO section VALUES("SAM I4AA", 0);

# Creazione della tabella year che verrà utilizzata per
# il salvataggio degli anni e dei semestri.
CREATE TABLE year (
	id INT AUTO_INCREMENT PRIMARY KEY,
	start_first_semester DATE,
	end_first_semester DATE,
	start_second_semester DATE,
	end_second_semester DATE
);

INSERT INTO year VALUES(null, "2019-09-01", "2020-01-25", "2020-01-26", "2020-06-29");
INSERT INTO year VALUES(null, "2018-09-01", "2019-01-25", "2019-01-26", "2019-06-29");


# Creazione della tabella student che verrà utilizzata per
# il salvataggio degli studenti.
CREATE TABLE student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(20) NOT NULL,
    last_name VARCHAR(20) NOT NULL,
    section VARCHAR(10) NOT NULL,
    year INT NOT NULL,
    FOREIGN KEY(section) REFERENCES section(name),
    FOREIGN KEY(year) REFERENCES year(id) ON DELETE CASCADE
);

INSERT INTO student VALUES(null, "bryan.beffa@samtrevano.ch", "Bryan", "Beffa", "SAM I4AA", 1);
INSERT INTO student VALUES(null, "bryan.beffa@samtrevano.ch", "Bryan", "Beffa", "SAM I3AA", 2);

# Creazione della tabella delay che verrà utilizzata per
# il salvataggio dei ritardi degli studenti.
CREATE TABLE delay (
	id INT AUTO_INCREMENT PRIMARY KEY,
	student INT NOT NULL,
    date DATE NOT NULL,
    observations VARCHAR(255),
    recovered DATE,
    justified TINYINT NOT NULL,
    FOREIGN KEY(student) REFERENCES student(id) ON DELETE CASCADE
);

INSERT INTO delay VALUES (null, 1, "2020-05-20", "Causa sveglia", null, 0);
INSERT INTO delay VALUES (null, 1, "2020-05-21", "Incidente BUS", null, 0);
INSERT INTO delay VALUES (null, 1, "2020-05-21", "Ritardo treni", null, 0);
INSERT INTO delay VALUES (null, 2, "2018-12-01", "Ritardo bus", null, 0);