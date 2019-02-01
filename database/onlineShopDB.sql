DROP DATABASE IF EXISTS onlineShop;
CREATE DATABASE IF NOT EXISTS onlineShop;
USE onlineShop;
CREATE TABLE Marque (
  marqueId   INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  marqueName VARCHAR(50),
  marImage   VARCHAR(250)
);
CREATE TABLE Famille (
  familleID   INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  familleName VARCHAR(255)    NOT NULL
);
CREATE TABLE Categorie (
  CatID     INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  familleID INT             NOT NULL,
  CONSTRAINT fk_familleID FOREIGN KEY (familleID) REFERENCES Famille (familleID)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  catName   VARCHAR(255)    NOT NULL
);
CREATE TABLE ProdImages (
  prodImageID INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  prodId      INT             NOT NULL,
  CONSTRAINT fk_prodId FOREIGN KEY (prodId) REFERENCES Produits (prodId)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  image1      VARCHAR(250),
  image2      VARCHAR(250)             DEFAULT NULL,
  image3      VARCHAR(250)             DEFAULT NULL,
  image4      VARCHAR(250)             DEFAULT NULL
);
CREATE TABLE Fournisseur (
  fourniID        INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nomComplet      VARCHAR(100) UNIQUE,
  pass            VARCHAR(255)    NOT NULL,
  email           VARCHAR(255)    NOT NULL,
  phone           VARCHAR(255)             DEFAULT '0621361189',
  panelAccess     INT                      DEFAULT 0,
  permission      VARCHAR(25)              DEFAULT 'simple user',
  StatutConfiance TINYINT                  DEFAULT 0,
  statutInsc      TINYINT                  DEFAULT 0,
  derniereVisite  DATETIME                 DEFAULT now()
);
CREATE TABLE Produits (
  prodId      INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  prodLabel   VARCHAR(255),
  marqueId    INT             NOT NULL,
  CONSTRAINT fk_marqueId FOREIGN KEY (marqueId) REFERENCES Marque (marqueId)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  CatID       INT             NOT NULL,
  CONSTRAINT fk_CatID FOREIGN KEY (CatID) REFERENCES Categorie (CatID)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  prodPrix    DECIMAL(10, 2),
  ancienPrix  DECIMAL(10, 2)           DEFAULT NULL,
  description TEXT,
  prodQté     INT                      DEFAULT 5,
  enStock     TINYINT(4)               DEFAULT 1,
  dateAjoutee DATETIME                 DEFAULT now(),
  presente    TINYINT(4)               DEFAULT 0,
  fourniID    INT             NOT NULL DEFAULT 1,
  CONSTRAINT fk_Fourn FOREIGN KEY (fourniID) REFERENCES Fournisseur (fourniID)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION

);
CREATE TABLE Paiement (
  paieID   INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  paieType VARCHAR(50)     NOT NULL,
  numCard  VARCHAR(255)    NOT NULL
);
CREATE TABLE Client (
  clientID       INT          NOT NULL AUTO_INCREMENT,
  email          VARCHAR(200) NOT NULL,
  CONSTRAINT pk_client PRIMARY KEY (clientID, email),
  pass           VARCHAR(255) NOT NULL,
  nom_Prenom     VARCHAR(40),
  tele           VARCHAR(18)           DEFAULT '0232659874',
  adresse        VARCHAR(255)          DEFAULT 'maroc',
  dateInsc       DATETIME              DEFAULT NOW(),
  derniereVisite DATETIME              DEFAULT NOW()
);
CREATE TABLE Expediteurs (
  exID          INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  nomEntreprise VARCHAR(100),
  phone         VARCHAR(20)
);
CREATE TABLE Commandes (
  cmdId               INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  clientID            INT             NOT NULL,
  CONSTRAINT fk_clientID FOREIGN KEY (clientID) REFERENCES Client (clientID)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  prodId              INT,
  CONSTRAINT fk_prodId FOREIGN KEY (prodId) REFERENCES Produits (prodId)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  quantite            INT,
  prixTotal           DECIMAL(10, 2),
  paieID              INT             NOT NULL DEFAULT 1,
  CONSTRAINT fk_paieID FOREIGN KEY (paieID) REFERENCES Paiement (paieID)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  dateCommande        DATE,
  dateLivraisonPrevue DATE,
  exID                INT             NOT NULL DEFAULT 1,
  CONSTRAINT fk_exID FOREIGN KEY (exID) REFERENCES Expediteurs (exID)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  statutCommande      VARCHAR(100),
  numeroDeSeuivi      BIGINT                   DEFAULT 11223344,
  userNoteMsg         TEXT                     DEFAULT NULL
);
CREATE TABLE Panier (
  panierId   INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  prodId     INT             NOT NULL,
  CONSTRAINT fk_prodId FOREIGN KEY (prodId) REFERENCES Produits (prodId)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  PanierQte  INT,
  clientID   INT             NOT NULL,
  CONSTRAINT fk_cltID FOREIGN KEY (clientID) REFERENCES Client (clientID)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  validercmd TINYINT                  DEFAULT 0
);
CREATE TABLE Commentaires (
  commId      INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
  clientID    INT,
  prodId      INT,
  commentaire TEXT,
  dateAjouter DATETIME                 DEFAULT now(),
  CONSTRAINT fk_pId FOREIGN KEY (prodId) REFERENCES Produits (prodId)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION,
  CONSTRAINT fk_cId FOREIGN KEY (clientID) REFERENCES Client (clientID)
    ON UPDATE NO ACTION
    ON DELETE NO ACTION
);

-- fin create tables------------------------------------------------------------------------------------
USE onlineShop;
DROP TRIGGER IF EXISTS fillDescription;
CREATE TRIGGER fillDescription
BEFORE INSERT ON Produits
FOR EACH ROW
  SET NEW.description = 'lobortis nisl ut aliquip ';
DELIMITER ;

DROP TRIGGER IF EXISTS setJourLivraison;
DELIMITER $$
CREATE TRIGGER setJourLivraison
BEFORE INSERT ON Commandes
FOR EACH ROW
  BEGIN
    DECLARE livDate DATE;
    DECLARE newDate DATE;
    SET livDate = curdate();
    SET newDate = DATE_ADD(now(), INTERVAL 7 DAY);
    SET NEW.dateCommande = livDate;
    SET NEW.DateLivraisonPrevue = newDate;
  END;
$$
DELIMITER ;

DROP TRIGGER IF EXISTS upperName;
DELIMITER $$
CREATE TRIGGER upperName
BEFORE INSERT ON Client
FOR EACH ROW
  BEGIN
    SET NEW.nom_Prenom = upper(NEW.nom_Prenom);
  END;
$$
DELIMITER ;

ALTER DATABASE onlineShop
CHARACTER SET utf8
COLLATE utf8_unicode_ci;
ALTER TABLE Marque
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_unicode_ci;
ALTER TABLE Famille
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_unicode_ci;
ALTER TABLE Produits
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_unicode_ci;
ALTER TABLE Paiement
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_unicode_ci;
ALTER TABLE Client
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_unicode_ci;
ALTER TABLE Commandes
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_unicode_ci;
ALTER TABLE Fournisseur
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_unicode_ci;
ALTER TABLE Expediteurs
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_unicode_ci;
ALTER TABLE Categorie
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_unicode_ci;
ALTER TABLE Panier
  CONVERT TO CHARACTER SET utf8
  COLLATE utf8_unicode_ci;
-- start filling the table ---------------------------------------------------------------
USE onlineShop;
INSERT INTO Marque (marqueName, marImage) VALUES ('Casio', 'brand02.jpg'),
  ('Milk & Rock', 'brand00.jpg');
INSERT INTO Marque (marqueName, marImage) VALUES ('Nike', 'brand01.jpg'),
  ('Infinix', 'brand03.jpg');
INSERT INTO Marque (marqueName, marImage) VALUES ('Swatch', 'brand04.jpg'),
  ('reebok', 'brand05.jpg'), ('Apple', 'brand06.jpg');
INSERT INTO Marque (marqueName)
VALUES ('C\'M Paris'), ('Diamantine'), ('Rip Curl'), ('Melany Brown'), ('Vila'), ('Marc YATES'), ('Steven\'s'),
  ('Seiko');
INSERT INTO Marque (marqueName) VALUES ('Jack & Jones'), ('Linx'), ('Belluga Shoes');
INSERT INTO Marque (marqueName, marImage) VALUES ('Canon', 'brand07.jpg');
INSERT INTO Marque (marqueName)
VALUES ('Asus'), ('Samsung'), ('STANLEY'), ('Old River'), ('Evet'), ('Beats'), ('Ray Ban');
-- end filling the table ---------------------------------------------------------------
-- start filling the table ---------------------------------------------------------------
INSERT INTO Famille (familleName) VALUES ('High tech'), ('Mode hommes'), ('Mode femmes');
-- end filling the table ---------------------------------------------------------------
-- start filling the table ---------------------------------------------------------------
INSERT INTO Categorie (familleID, catName)
VALUES (1, 'pc'), (1, 'Smartphone'), (2, 'Vetements Hommes'), (2, 'Chaussures Hommes');
INSERT INTO Categorie (familleID, catName)
VALUES (2, 'Accessoires Hommes'), (3, 'Vetements Femmes'), (3, 'Chaussures Femmes');
INSERT INTO Categorie (familleID, catName) VALUES (3, 'Accessoires Femmes'), (1, 'Caméras'), (1, 'Tablettes');
INSERT INTO Categorie (familleID, catName) VALUES (1, 'Accessoires high tech'), (1, 'Casque audio');
INSERT INTO Paiement (paieType, numCard)
VALUES ('VISA', '123456789'), ('MASTER CARD', '123456789'), ('CMI', '123456789');
INSERT INTO Expediteurs (nomEntreprise, phone) VALUES ('Amana', '0621548796');
INSERT INTO Client (email, pass, nom_Prenom) VALUES ('abde@gmaim.com', sha1('1111'), 'amanar abde');
INSERT INTO Client (email, pass, nom_Prenom) VALUES ('yasine@gmaim.com', '2222', 'amamar yasine');
INSERT INTO `commandes` (`clientID`, `prodId`, `quantite`, `prixTotal`, `paieID`, `dateCommande`, `dateLivraisonPrevue`, `exID`, `statutCommande`, `numeroDeSeuivi`)
VALUES
  (1, 1, 1, '150.00', 1, '2017-06-10', '2017-06-17', 1, 'En attente de Paiement', 11223344),
  (1, 2, 2, '161.00', 1, '2017-06-10', '2017-06-17', 1, 'Paiement accepté', 11223344),
  (1, 4, 6, '14141.00', 1, '2017-06-10', '2017-06-17', 1, 'Expédié', 11223344),
  (2, 4, 4, '4144.00', 1, '2017-06-10', '2017-06-17', 1, 'Préparation en cours', 11223344),
  (2, 4, 4, '45775.00', 1, '2017-06-10', '2017-06-17', 1, 'Annuler', 11223344);
INSERT INTO `commandes` (`clientID`, `prodId`, `quantite`, `prixTotal`, `paieID`, `exID`, `statutCommande`) VALUES
  (1, 1, 1, '150.00', 1, 1, 'En attente de Paiement'),
  (1, 2, 2, '161.00', 1, 1, 'Paiement accepté'),
  (1, 4, 6, '14141.00', 1, 1, 'Expédié'),
  (2, 4, 4, '4144.00', 1, 1, 'Livré'),
  (2, 4, 4, '45775.00', 1, 1, 'Annuler'),
  (1, 1, 1, '150.00', 1, 1, 'En attente de Paiement'),
  (1, 2, 2, '161.00', 1, 1, 'Paiement accepté'),
  (1, 4, 6, '14141.00', 1, 1, 'Livré'),
  (2, 4, 4, '4144.00', 1, 1, 'Préparation en cours'),
  (2, 4, 4, '45775.00', 1, 1, 'Annuler'),
  (1, 1, 1, '150.00', 1, 1, 'En attente de Paiement'),
  (1, 2, 2, '161.00', 1, 1, 'Paiement accepté'),
  (1, 4, 6, '14141.00', 1, 1, 'Expédié'),
  (2, 4, 4, '4144.00', 1, 1, 'Livré'),
  (2, 4, 4, '45775.00', 1, 1, 'Annuler'),
  (1, 1, 1, '150.00', 1, 1, 'En attente de Paiement'),
  (1, 2, 2, '161.00', 1, 1, 'Paiement accepté'),
  (1, 4, 6, '14141.00', 1, 1, 'Expédié'),
  (2, 4, 4, '4144.00', 1, 1, 'Préparation en cours'),
  (2, 4, 4, '45775.00', 1, 1, 'Annuler'),
  (1, 1, 1, '150.00', 1, 1, 'En attente de Paiement'),
  (1, 2, 2, '161.00', 1, 1, 'Paiement accepté'),
  (1, 4, 6, '14141.00', 1, 1, 'Expédié'),
  (2, 4, 4, '4144.00', 1, 1, 'Livré'),
  (2, 4, 4, '45775.00', 1, 1, 'Annuler'),
  (1, 1, 1, '150.00', 1, 1, 'En attente de Paiement'),
  (1, 2, 2, '161.00', 1, 1, 'Paiement accepté'),
  (1, 4, 6, '14141.00', 1, 1, 'Livré'),
  (2, 4, 4, '4144.00', 1, 1, 'Préparation en cours'),
  (2, 4, 4, '45775.00', 1, 1, 'Annuler'),
  (1, 1, 1, '150.00', 1, 1, 'En attente de Paiement'),
  (1, 2, 2, '161.00', 1, 1, 'Paiement accepté'),
  (1, 4, 6, '14141.00', 1, 1, 'Expédié'),
  (2, 4, 4, '4144.00', 1, 1, 'Livré'),
  (2, 4, 4, '45775.00', 1, 1, 'Annuler'),
  (1, 1, 1, '150.00', 1, 1, 'En attente de Paiement'),
  (1, 2, 2, '161.00', 1, 1, 'Paiement accepté'),
  (1, 4, 6, '14141.00', 1, 1, 'Expédié'),
  (2, 4, 4, '4144.00', 1, 1, 'Préparation en cours'),
  (2, 4, 4, '45775.00', 1, 1, 'Annuler');

INSERT INTO Fournisseur (nomComplet, pass, email, panelAccess, permission, StatutConfiance, statutInsc)
VALUES ('admin', sha1('admin'), 'abde@gmaim.com', 1, 'c', 1, 1),
  ('m', sha1('m'), 'abde@gmaim.com', 1, 'Moderator', 0, 0),
  ('yassin', sha1('m'), 'abde@gmaim.com', 1, 'Modérateur', 1, 0),
  ('soso', sha1('m'), 'abde@gmaim.com', 1, 'Modérateur', 0, 0),
  ('nonos', sha1('m'), 'abde@gmaim.com', 1, 'Modérateur', 1, 0),
  ('uness', sha1('m'), 'abde@gmaim.com', 1, 'Modérateur', 1, 0),
  ('a', sha1('a'), 'abde@gmaim.com', 1, 'Controle total', 1, 1),
  ('rkiya', sha1('m'), 'abde@gmaim.com', 1, 'Modérateur', 0, 0);
-- start insert into produit
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, ancienPrix, enStock)
VALUES ('Zenfone 3 Max', 20, 2, 500.50, 700, 1);
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, presente)
VALUES ('ATIV Book 9 Plus', 21, 1, 150.50, 0);
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, ancienPrix, presente, enStock)
VALUES ('Veste - Gris', 23, 3, 8000, 300, 1, 1);
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix)
VALUES ('Manteaux - Gris', 24, 6, 1000.50),
  ('T-shirt Basic Col V - Noir', 2, 3, 150.50),
  ('Pantalon Chino - Bleu nuit', 3, 3, 80.50),
  ('Slip on - Noir', 18, 4, 90.50),
  ('Derbies 100% Cuir - Marron', 22, 4, 149.50),
  ('Montre Legendary Eagle - Noir', 5, 8, 349.55),
  ('EOS 600D', 19, 9, 9310),
  ('Sandales Compensees - Camel', 7, 7, 499.99),
  ('Sac a main - Noir', 9, 8, 399.99);
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, ancienPrix, enStock)
VALUES ('Galaxy Tab A 2016- Noir', 21, 10, 3490, 3999, 1);
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, ancienPrix)
VALUES ('Casque Studio Noir', 25, 12, 5, 399);
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, ancienPrix)
VALUES ('Galaxy Tab A 2017- Noir', 21, 10, 3490, 3999),
  ('Galaxy Tab A 2017- Noir', 21, 10, 3490, 3999),
  ('Galaxy Tab A 2017- Noir', 21, 10, 3490, 3999),
  ('Galaxy Tab A 2017- Noir', 21, 11, 3490, 3999);
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, ancienPrix)
VALUES ('Carte Mémoire', 21, 11, 549, 80), ('Carte Mémoire', 21, 11, 549, 80), ('Carte Mémoire', 21, 11, 549, 80);
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, ancienPrix)
VALUES ('Casque Studio Noir', 25, 7, 211, 399),
  ('Casque Studio Noir', 25, 7, 111, 399),
  ('Casque Studio Noir', 25, 12, 5, 399),
  ('Casque Studio Noir', 25, 7, 87, 399),
  ('Casque Studio Noir', 25, 7, 642, 399),
  ('Casque Studio Noir', 25, 1, 200, 399),
  ('Casque Studio Noir', 25, 1, 200, 399),
  ('Casque Studio Noir', 25, 1, 200, 399),
  ('Casque Studio Noir', 25, 1, 200, 399),
  ('Casque Studio Noir', 25, 1, 200, 399),
  ('Casque Studio Noir', 25, 1, 200, 399),
  ('Casque Studio Noir', 25, 1, 200, 399),
  ('Baskets - Bleu pétrole', 14, 4, 249, 300);

INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, ancienPrix)
VALUES ('Lunettes de Soleil - Aviator Classic', 26, 5, 1350, 1600);
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, ancienPrix)
VALUES ('Lunettes de Soleil - Aviator Classic', 26, 12, 1350, 1600);
INSERT INTO Produits (prodLabel, marqueId, CatID, prodPrix, ancienPrix)
VALUES ('Montre - Mtp-V003G-9Audf - Doré', 1, 5, 1350, 1600),
  ('Baskets - Bleu pétrole', 14, 4, 249, 300);
-- start filling the table ---------------------------------------------------------------

-- start filling the table ---------------------------------------------------------------
INSERT INTO prodImages (prodId, image1, image2, image3)
VALUES (1, 'sp00.jpg', 'sp01.jpg',
        'sp02.jpg'),
  (2, 'pc00.jpg', 'pc01.jpg',
   'pc02.jpg');
INSERT INTO prodImages (prodId, image1, image2)
VALUES (3, 'v00.jpg', 'v01.jpg'),
  (4, 'm00.jpg', 'm01.jpg');
INSERT INTO prodImages (prodId, image1)
VALUES (5, 'p9.jpg'),
  (6, 'woo3.jpg'),
  (7, 's3.jpg'),
  (8, 's9.jpg'),
  (9, 'p29.jpg');
INSERT INTO prodImages (prodId, image1, image2)
VALUES (10, 'ht01.jpg', 'ht02.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (11, 'i6.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (12, 'i3.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (13, 'tab01.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (14, 'sd01.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (15, 'hp01.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (16, 'ac01.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (17, 'ac02.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (18, 's01.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (19, 's01.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (20, 's01.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (21, 's01.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (22, 's01.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (23, 's01.jpg');
INSERT INTO prodImages (prodId, image1) VALUES (24, 's01.jpg');

-- start filling the table ---------------------------------------------------------------


-- start filling the table ---------------------------------------------------------------
INSERT INTO Commentaires (clientID, prodId, commentaire) VALUES (1, 1, 'sssssssssssssssssssssssssssssssssss'),
  (1, 1, 'sssssssssssssssssssssssssssssssssss'),
  (1, 2, 'sssssssssssssssssssssssssssssssssss'),
  (2, 1, 'sssssssssssssssssssssssssssssssssss'),
  (3, 2, 'sssssssssssssssssssssssssssssssssss'),
  (5, 3, 'sssssssssssssssssssssssssssssssssss'),
  (1, 4, 'sssssssssssssssssssssssssssssssssss'),
  (2, 1, 'sssssssssssssssssssssssssssssssssss'),
  (3, 2, 'sssssssssssssssssssssssssssssssssss'),
  (3, 3, 'sssssssssssssssssssssssssssssssssss'),
  (4, 4, 'sssssssssssssssssssssssssssssssssss'),
  (5, 2, 'sssssssssssssssssssssssssssssssssss'),
  (2, 1, 'sssssssssssssssssssssssssssssssssss'),
  (1, 1, 'sssssssssssssssssssssssssssssssssss'),
  (3, 1, 'sssssssssssssssssssssssssssssssssss'),
  (1, 1, 'sssssssssssssssssssssssssssssssssss'),
  (1, 1, 'sssssssssssssssssssssssssssssssssss');
-- start filling the table ---------------------------------------------------------------

INSERT INTO Panier (prodId, PanierQte, clientID) VALUES
  (1, 4, 1), (1, 4, 2), (1, 4, 1), (1, 4, 1), (1, 4, 2);
