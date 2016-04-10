SET search_path = cabinetMD;

--
--  Population de tables
--

--SECRETAIRE (SecID(PK), Prenom, Nom, NumTel, adresse)
INSERT INTO Secretaire VALUES
	('S001', 'Lucie', 'Roy', '6135553121', '21 Jump Street'),
	('S002', 'Pierre', 'Joly', '6135555436', '123 Sesame Street'),
	('S003', 'Alice', 'Lamontagne', '6135554698', '3355 Carriage Hill Place'),
	('S004', 'Sophie', 'Duguay', '6135553678', '222 Russell Avenue');

--MEDECIN (MedID(PK), Prenom, Nom, NumTel, adresse, Specialite, adresse,  SecID(FK))
INSERT INTO Medecin VALUES
	('M001', 'Lea', 'Solo', '6135557946', '144 Sable Ridge Drive', 'Medecin general', 'S001'),
	('M002', 'Francine', 'Tremblay', '6135553164', '22 Jump Street', 'Oncologie', 'S002'),
	('M003', 'Leonard', 'Bloom', '6135554644', '1600 Pennsylvania Avenue',  'Oncologie', 'S001'),
	('M004', 'Mark', 'Blayney', '6135554667', '1 Wellington Street',  'Medecin general', 'S003'),
	('M005', 'Johan', 'Bos', '6135554669', '123 Sathorn Road', 'Medecin general', 'S004');

--PATIENT (PatID(PK), Prenom, Nom, NumTel, adresse, dateNaissance, sexe, SSN, RefMed(FK))
INSERT INTO Patient VALUES
	('P001', 'Manuel', 'Valls', '6135553663', '333 Elm Street', 'Apr-02-1977', 'M', '223887696', 'M001'),
	('P002', 'Pierre', 'Cousineau', '6135554467', '255 Evergreen Terrace', 'Mar-14-1960', 'M', '343565778','M002'),
	('P003', 'Suzanne', 'Clement', '6135551132', '221 Baker Street', 'Jun-06-1965', 'F', '456789123','M002'),
	('P004', 'Martin', 'Lamothe', '6135557798', '555 Coronation Street', 'Aug-08-1972', 'M', '321456987','M002'),
	('P005', 'Paul', 'Gingras', '6135554058', '123 Fake Street', 'Sep-22-1966', 'M', '224557668','M003'),
	('P006', 'Martine', 'Gelinas', '6135553181', '767 Spooner Street', 'Oct-25-1984', 'F', '264795413','M003'),
	('P007', 'Julie', 'Chartrand', '6135552288', '777 Paper Street', 'Nov-10-1978', 'F', '102426759','M004'),
	('P008', 'Catherine', 'DAoust', '6135551998', '800 King Edward', 'Dec-03-1956', 'F', '351687907','M004'),
	('P009', 'Marc', 'Rochon', '6135553773', '444 Diagon Alley', 'May-30-1955', 'M', '500644901','M004'),
	('P010', 'Melanie', 'Bergeron', '6135559676', '233 Yellow Brick Road', 'Feb-07-1988', 'F', '688911355','M001');

--CONSULTATION (PatID(FK), MedID(FK), CDate(PK), Heure, Duree, Objet)
INSERT INTO Consultation VALUES
	('P002', 'M002', 'Jan-08-2015', '9:15:00', '0:45:00', 'Revue: résultats de test'),
	('P001', 'M002', 'Jan-08-2015', '10:15:00', '0:30:00', 'Nouveaux symptomes'),
	('P004', 'M002', 'Jan-10-2015', '9:45:00', '0:30:00', 'Examen annuel'),
	('P003', 'M002', 'Mar-11-2015', '10:00:00', '0:20:00', 'Fin de remission'),
	('P007', 'M002', 'Mar-11-2015', '15:30:00', '0:30:00', 'Suivi annuel: nouveau medicament'),
	('P008', 'M002', 'May-16-2015', '11:00:00', '0:30:00', 'Nouveaux symptomes'),
	('P009', 'M003', 'Jun-21-2015', '12:00:00', '0:15:00', 'Examen annuel'),
	('P001', 'M003', 'Jun-21-2015', '12:30:00', '0:55:00', 'Examen annuel'),
	('P008', 'M003', 'Jun-21-2015', '14:00:00', '0:35:00', 'Nouveaux symptomes'),
	('P003', 'M003', 'Jun-21-2015', '14:50:00', '0:25:00', 'Resultats de tests'),
	('P001', 'M001', 'Dec-10-2015', '12:30:00', '1:00:00', 'Examen annuel'),
	('P010', 'M004', 'Feb-26-2016', '14:00:00', '0:20:00', 'Noueveaux symtpomes'),
	('P002', 'M004', 'Jan-08-2014', '9:35:00', '0:45:00', 'Nouveaux symptomes'),
	('P009', 'M001', 'Feb-21-2016', '10:30:00', '0:35:00', 'Examen annuel'),
	('P005', 'M001', 'Jan-05-2014', '11:00:00', '0:20:00', 'Examen annuel'),
	('P006', 'M003', 'Jan-06-2016', '14:00:00', '0:30:00', 'Nouveaux symptomes'),
	('P006', 'M003', 'Jan-30-2016', '14:00:00', '0:30:00', 'Suivi'),
	('P001', 'M001', 'Apr-10-2016', '10:15:00', '0:30:00', 'Nouveaux symptomes'),
	('P002', 'M002', 'Apr-11-2016', '10:15:00', '0:30:00', 'Nouveaux symptomes'),
	('P003', 'M003', 'Apr-11-2016', '10:15:00', '0:30:00', 'Nouveaux symptomes');
	
--SUBSTANCEACTIVE (SubID(PK), Nom)
INSERT INTO SubstanceActive VALUES
	('S001', 'irbesartan'),
	('S002', 'teriflunomide'),
	('S003', 'leflunomide'),
	('S004', 'simvastatin'),
	('S005', 'paracetamol'),
	('S006', 'codeine');

--INCOMPATIBLESUBSTANCEACTIVE (SubA(FK), SubB(FK))
INSERT INTO IncompatibleSubstanceActive VALUES
	--('S001', 'S002'),
	--('S001', 'S006'),
	('S002', 'S003'),
	('S002', 'S004'),
	('S003', 'S005'),
	('S004', 'S005'),
	('S004', 'S006'),
	('S005', 'S006');

--MEDICAMENT (MedID(PK), Nom, Prix, estGenerique, SubID(FK))
INSERT INTO Medicament VALUES
	('M001', 'diazepam', 100.00, true, 'S001'),
	('M002', 'valium', 97.99, false, 'S002'),
	('M003', 'ibuprofen', 2.38, true, 'S003'),
	('M004', 'pseudoephedrine', 27.50, true, 'S004'),
	('M005', 'tylenol', 11.86, false, 'S005'),
	('M006', 'sudafed', 67.53, false, 'S006');

--EXAMEN (EXRXID(PK), Nom, PatID(FK), MedID(FK), CDate(PK))
INSERT INTO PrescriptionExam VALUES
	('E001', 'Biopsie', 'P004', 'M002', 'Jan-10-2015'),
	('E002', 'Prise de sang', 'P001', 'M002', 'Jan-08-2015'),
	('E003', 'Ultrason', 'P007', 'M002', 'Mar-11-2015'),
	('E004', 'Biopsie', 'P003', 'M003', 'Jun-21-2015');

--MEDICAMENTEUSE (MEDRXID(PK), Duree, MediID, PatID(FK), MedID(FK), CDate(PK))
INSERT INTO PrescriptionMedi VALUES
	('M001', 'Jun-08-2016', 'M002', 'P001', 'M002', 'Jan-08-2015'),
	('M002', 'Jul-21-2015', 'M004', 'P003', 'M003', 'Jun-21-2015'),
	('M003', 'Dec-20-2016', 'M005', 'P001', 'M001', 'Dec-10-2015'),
	('M004', 'Jun-20-2016', 'M001', 'P001', 'M003', 'Jun-21-2015');

--PATHOLOGIE (PathID(PK), Nom)
INSERT INTO Pathologie VALUES
	('P001', 'grippe'),
	('P002', 'rhume'),
	('P003', 'cancer du foie'),
	('P004', 'cancer du pancreas');
	
--INCOMPATIBLESUBPATH (SubID(FK), PathID(FK))
INSERT INTO IncompatibleSubPath VALUES
	('S001', 'P001'),
	('S001', 'P003'),
	('S002', 'P002'),
	('S003', 'P004'),
	('S003', 'P002'),
	('S004', 'P001'),
	('S006', 'P003');
	
--PathologiePatient (PathID(FK), PatID(FK), MedID(FK), dateDebut(FK), dateFin)
INSERT INTO PathologiePatient VALUES
	('P001', 'P001', 'M001', 'Dec-10-2015', 'Dec-15-2015'),
	('P002', 'P001', 'M001', 'Dec-10-2015', 'Dec-18-2015'),
	('P004', 'P001', 'M002', 'Jan-08-2015', NULL),
	('P002', 'P002', 'M002', 'Jan-08-2015', 'Jan-15-2015'),
	('P003', 'P002', 'M004', 'Jan-08-2014', NULL),     
	('P002', 'P002', 'M004', 'Jan-08-2014', 'Jan-12-2014'),
	('P001', 'P003', 'M002', 'Mar-11-2015', 'Mar-16-2015'),
	('P003', 'P003', 'M002', 'Mar-11-2015', NULL),
	('P003', 'P004', 'M002', 'Jan-10-2015', NULL),     
	('P004', 'P004', 'M002', 'Jan-10-2015', NULL),     
	('P002', 'P005', 'M001', 'Jan-05-2014', 'Feb-05-2014'),
	('P001', 'P006', 'M003', 'Jan-06-2016', 'Jan-30-2016'),
	('P002', 'P006', 'M003', 'Jan-30-2016', 'Feb-05-2016'),
	('P002', 'P007', 'M002', 'Mar-11-2015', 'Mar-24-2016'),
	('P003', 'P007', 'M002', 'Mar-11-2015', NULL),     
	('P001', 'P008', 'M003', 'Jun-21-2015', 'Jun-25-2015'),
	('P002', 'P008', 'M002', 'May-16-2015', 'Sep-16-2015'),
	('P004', 'P008', 'M002', 'May-16-2015', NULL),     
	('P002', 'P009', 'M001', 'Feb-21-2016', 'Feb-28-2016'),
	('P003', 'P009', 'M003', 'Jun-21-2015', NULL),
	('P004', 'P009', 'M003', 'Jun-21-2015', NULL),
	('P001', 'P010', 'M004', 'Feb-26-2016', 'Mar-01-2016');