DROP SCHEMA IF EXISTS cabinetMD CASCADE;
CREATE SCHEMA cabinetMD;

SET search_path = cabinetMD;

--
--  Création des tables
--

CREATE TABLE Secretaire (
SecID		CHAR(4) 	NOT NULL,
Prenom     	VARCHAR(25)	NOT NULL, 
Nom		VARCHAR(25) 	NOT NULL, 
NumTel   	VARCHAR(10) 	NOT NULL, 
Adresse 	VARCHAR(50)	NOT NULL,
CONSTRAINT secretaire_PK PRIMARY KEY (SecID)
);

CREATE TABLE Medecin (
MedID		CHAR(4)		NOT NULL,
Prenom     	VARCHAR(25)	NOT NULL, 
Nom		VARCHAR(25) 	NOT NULL, 
NumTel   	VARCHAR(10) 	NOT NULL,
Adresse		VARCHAR(50)	NOT NULL, 
Specialite	VARCHAR(20)	NOT NULL,
SecID		CHAR(4)		NOT NULL,
CONSTRAINT medecin_PK PRIMARY KEY (MedID),
CONSTRAINT medecin_sec_FK FOREIGN KEY (SecID) REFERENCES Secretaire(SecID)
	ON DELETE RESTRICT --Hyopthèse: Un médecin ne devrait jamais être sans secrétaire
	ON UPDATE CASCADE 
);

CREATE TABLE Patient (
PatID		CHAR(4)		NOT NULL,
Prenom     	VARCHAR(25)	NOT NULL, 
Nom		VARCHAR(25) 	NOT NULL, 
NumTel   	VARCHAR(10) 	NOT NULL, 
Adresse		VARCHAR(50)	NOT NULL,
DateNaissance	DATE		NOT NULL,
Sexe		CHAR		NOT NULL CONSTRAINT sexeCK CHECK (sexe IN ('M', 'F')),
SSN		VARCHAR(9)	UNIQUE,
RefMed		CHAR(4)		NOT NULL,
CONSTRAINT patient_PK PRIMARY KEY (PatID),
CONSTRAINT patient_med_FK FOREIGN KEY (RefMed) REFERENCES Medecin(MedID)
	ON DELETE RESTRICT --Hypothèse: Un patient ne devrait jamais être sans médecin référant.
	ON UPDATE CASCADE 
);

CREATE TABLE Consultation (
PatID		CHAR(4)		NOT NULL,
MedID		CHAR(4)		NOT NULL,
CDate		Date		NOT NULL,
Heure		Time		NOT NULL,
Duree		Time		NOT NULL,
Objet		VARCHAR(50)	,
CONSTRAINT consultation_PK PRIMARY KEY (PatID, MedID, CDate),
CONSTRAINT consultation_pat_FK FOREIGN KEY (PatID) REFERENCES Patient(PatID)
	ON DELETE RESTRICT --????????
	ON UPDATE CASCADE,
CONSTRAINT consultation_med_FK FOREIGN KEY (MedID) REFERENCES Medecin(MedID)
	ON DELETE RESTRICT --???????? 
	ON UPDATE CASCADE
);

CREATE TABLE SubstanceActive (
SubID		CHAR(4)		NOT NULL,
Nom		VARCHAR(20)	NOT NULL,
CONSTRAINT substance_PK PRIMARY KEY (SubID)
);

CREATE TABLE IncompatibleSubstanceActive (
SubA		CHAR(4)		NOT NULL,
SubB		CHAR(4)		NOT NULL CONSTRAINT sub CHECK (SubA < SubB), --prévient l'insertion de paires inverses (une redondance)
CONSTRAINT incompatiblesubstance_PK PRIMARY KEY (SubA, SubB),
CONSTRAINT incompatiblesubstance_A_FK FOREIGN KEY (SubA) REFERENCES SubstanceActive(SubID)
	ON DELETE CASCADE 
	ON UPDATE CASCADE,
CONSTRAINT incompatiblesubstance_B_FK FOREIGN KEY (SubB) REFERENCES SubstanceActive(SubID)
	ON DELETE CASCADE 
	ON UPDATE CASCADE
);

CREATE TABLE Medicament (
MediID		CHAR(4)		NOT NULL,
Nom		VARCHAR(20)	NOT NULL,
Prix		numeric(15,6)	NOT NULL,
estGenerique 	BOOLEAN		NOT NULL,
SubID		CHAR(4)		NOT NULL,
CONSTRAINT medicament_PK PRIMARY KEY (MediID),
CONSTRAINT medicament_sub_FK FOREIGN KEY (SubID) REFERENCES SubstanceActive(SubID)
	ON DELETE RESTRICT --Hypothèse: Il serait dangereux d'être capable de prescrire des médicaments sans avoir les informations sur sa substance active et ses incompatilbités.
	ON UPDATE CASCADE
);

CREATE TABLE PrescriptionExam (
ERXID		CHAR(4)		NOT NULL,
Nom		VARCHAR(20)	NOT NULL,
PatID		CHAR(4)		NOT NULL,
MedID		CHAR(4)		NOT NULL,
CDate		Date		NOT NULL,
CONSTRAINT examen_PK PRIMARY KEY (ERXID),
CONSTRAINT prescriptionexam_cons_FK FOREIGN KEY (PatID, MedID, CDate) REFERENCES Consultation(PatID, MedID, CDate)
	ON DELETE RESTRICT --????????
	ON UPDATE CASCADE
);

CREATE TABLE PrescriptionMedi (
MRXID		CHAR(4)		NOT NULL,
Duree		Date		NOT NULL,
MediID		CHAR(4)		NOT NULL,
PatID		CHAR(4)		NOT NULL,
MedID		CHAR(4)		NOT NULL,
CDate		Date		NOT NULL,
CONSTRAINT medicamenteuse_PK PRIMARY KEY (MRXID),
CONSTRAINT medicamenteuse_medi_FK FOREIGN KEY (MediID) REFERENCES Medicament(MediID)
	ON DELETE RESTRICT --????????
	ON UPDATE CASCADE,
CONSTRAINT prescription_cons_FK FOREIGN KEY (PatID, MedID, CDate) REFERENCES Consultation(PatID, MedID, CDate)
	ON DELETE CASCADE --????????
	ON UPDATE CASCADE
);

CREATE TABLE Pathologie (
PathID		CHAR(4)		NOT NULL,
Nom		VARCHAR(20) 	NOT NULL,
CONSTRAINT pathologie_PK PRIMARY KEY (PathID)
);

CREATE TABLE IncompatibleSubPath (
SubID		CHAR(4)		NOT NULL,
PathID		CHAR(4)		NOT NULL,
CONSTRAINT incompatiblesubpath_PK PRIMARY KEY (SubID, PathID),
CONSTRAINT incompatiblesubpath_sub_FK FOREIGN KEY (SubID) REFERENCES SubstanceActive(SubID)
	ON DELETE CASCADE
	ON UPDATE CASCADE,
CONSTRAINT incompatiblesubpath_path_FK FOREIGN KEY (PathID) REFERENCES Pathologie(PathID)
	ON DELETE CASCADE
	ON UPDATE CASCADE
);

CREATE TABLE PathologiePatient (
PathID		CHAR(4)		NOT NULL,
PatID		CHAR(4)		NOT NULL,
MedID		CHAR(4)		NOT NULL,
DateDebut	Date		NOT NULL,
DateFin		Date		CONSTRAINT EndCK  CHECK (DateDebut < DateFin),
CONSTRAINT pathologiePatient_PK PRIMARY KEY (PathID, PatID, MedID, DateDebut),
CONSTRAINT pathologiePatient_cons_FK FOREIGN KEY (PatID, MedID, DateDebut) REFERENCES Consultation(PatID, MedID, CDate)
	--Hypothèse: la date de début de la pathologie correspondra toujours à la date de la consultation qui a produit le diagnostic. Donc, il suffit de considérer la date de consultation comme la date de début de la pathologie.
	ON DELETE RESTRICT --???????? 
	ON UPDATE CASCADE,
CONSTRAINT pathologiePatient_path_FK FOREIGN KEY (PathID) REFERENCES Pathologie(PathID)
	ON DELETE RESTRICT --Hypothèse: Le cabinet devrait garder l'information sur une pathologie si un patient a été atteint par cette maladie.
	ON UPDATE CASCADE
);