DROP DATABASE IF EXISTS hackland;
CREATE DATABASE hackland;
USE hackland;

CREATE TABLE Alliance
(
    ID INT NOT NULL,
    ownerID INT NOT NULL,
    nom INT NOT NULL,

    PRIMARY KEY (ID) # ,
    # FOREIGN KEY (ownerID) REFERENCES User(ID)
);

CREATE TABLE User
(
    ID INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(40) NOT NULL,
    motDePasse VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    hackMail VARCHAR(40) NOT NULL,
    hackCoins INT NOT NULL DEFAULT 2000,
    hackChip INT NOT NULL DEFAULT 100,

    PRIMARY KEY (ID)
);

CREATE TABLE Appartenir
(
	UserID INT NOT NULL,
    AllianceID INT NOT NULL,
    
    FOREIGN KEY (UserID) REFERENCES User(ID),
    FOREIGN KEY (AllianceID) REFERENCES Alliance(ID)
);

CREATE TABLE Modo
(
    userID INT NOT NULL,
    permissionLevel INT NOT NULL DEFAULT 0,

    FOREIGN KEY (userID) REFERENCES User(ID)
);

CREATE TABLE Mail
(
    userID INT NOT NULL,
    sujet VARCHAR(255),
    corps TEXT,

    FOREIGN KEY (userID) REFERENCES User(ID)
);

CREATE TABLE VirtualMachine
(
    ownerID INT NOT NULL,
    ID INT NOT NULL AUTO_INCREMENT,
    ipAddress VARCHAR(19) NOT NULL, # Adresse IP sur 5 octets : 255.255.255.255.255
    identifiant VARCHAR(20) NOT NULL,
    motDePasse VARCHAR(30) NOT NULL,
    hackData INT NOT NULL DEFAULT 1000,

    allianceID INT NOT NULL,

    PRIMARY KEY (ID),
    FOREIGN KEY (ownerID) REFERENCES User(ID)
);

CREATE TABLE Effet 
(
    ID INT NOT NULL,
    nom VARCHAR(255),

    PRIMARY KEY (ID)
);

CREATE TABLE Script
(
    creatorID INT NOT NULL,
    ID INT NOT NULL AUTO_INCREMENT,
    nom VARCHAR(30) NOT NULL UNIQUE,
    commande VARCHAR(20) NOT NULL UNIQUE,
    prix INT NOT NULL,

    PRIMARY KEY (ID),
    FOREIGN KEY (creatorID) REFERENCES User(ID)
);

CREATE TABLE ScriptSurVM
(
    scriptID INT NOT NULL,
    VMID INT NOT NULL,

    FOREIGN KEY (scriptID) REFERENCES Script(ID),
    FOREIGN KEY (VMID) REFERENCES VirtualMachine(ID)
);

CREATE TABLE ComposantScript
(
    ID INT NOT NULL,
    nom VARCHAR(30) NOT NULL,
    codeExecution VARCHAR(30) NOT NULL,
    effetID INT NOT NULL,
    niveau INT NOT NULL,

    PRIMARY KEY (ID),
    FOREIGN KEY (effetID) REFERENCES Effet(ID)
);

CREATE TABLE Logiciel
(
    ID INT NOT NULL,
    nom VARCHAR(30) NOT NULL UNIQUE,
    effetID INT NOT NULL,
    niveau INT NOT NULL,
    prix INT NOT NULL,

    PRIMARY KEY (ID),
    FOREIGN KEY (effetID) REFERENCES Effet(ID)
);

CREATE TABLE LogicielSurVM
(
    logicielID INT NOT NULL,
    VMID INT NOT NULL,
    etat INT NOT NULL DEFAULT 2, # 0 = éteint, 1 = lancement, 2 = en cours, 3 = extinction

    FOREIGN KEY (logicielID) REFERENCES Logiciel(ID),
    FOREIGN KEY (VMID) REFERENCES VirtualMachine(ID)
);

DROP USER IF EXISTS 'basicHacker'@'localhost';
CREATE USER 'basicHacker'@'localhost' IDENTIFIED BY 'Y6r33n$1Im#p';
GRANT ALL PRIVILEGES ON hackland.* TO 'basicHacker'@'localhost';
FLUSH PRIVILEGES;