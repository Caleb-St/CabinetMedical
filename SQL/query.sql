SET search_path = cabinetMD;

--
--  Requêtes
--

-- 1
SELECT *
FROM Medecin
ORDER BY nom ASC;

--2
SELECT *
FROM Patient
WHERE refmed = 'M001';

--3
SELECT *
FROM Patient
WHERE refMed IN 
(SELECT medID
FROM Medecin
WHERE LOWER(nom) LIKE '%blay%'); 

--4
SELECT *
FROM Patient
WHERE refMed IN
(SELECT medID
FROM Medecin
WHERE nom = 'Tremblay' OR nom = 'Solo');

--5
(SELECT patID
FROM PathologiePatient
WHERE pathID = (SELECT pathID FROM Pathologie WHERE nom = 'rhume'))
EXCEPT
(SELECT patID
FROM PathologiePatient
WHERE pathID = (SELECT pathID FROM Pathologie WHERE nom = 'grippe'));

--6
--Hypothèse: Pour une maladie donnée, un patient est "traité" par le medecin qui a diagnostiqué la maladie.
--(Alors il suffit de lister les medecins qui ont diagnostiqué les maladies rhume et grippe.
(SELECT medID
FROM PathologiePatient
WHERE PathID IN (SELECT pathID FROM Pathologie WHERE nom = 'rhume'))
INTERSECT
(SELECT medID
FROM PathologiePatient
WHERE PathID IN (SELECT pathID FROM Pathologie WHERE nom = 'grippe'));


--7
SELECT COUNT(*) AS myCount
FROM
(SELECT patID
FROM Consultation
WHERE medID IN (SELECT medID FROM Medecin WHERE nom = 'Tremblay')
INTERSECT
(SELECT patID
FROM PathologiePatient
WHERE pathID = (SELECT pathID FROM Pathologie WHERE nom = 'cancer du foie'))) AS liverCancerPatientsTreatedByTremblay;

--8
SELECT COUNT(*) AS myCount
FROM
(SELECT patID
FROM Consultation
WHERE medID IN (SELECT medID FROM Medecin WHERE nom = 'Tremblay')
EXCEPT
(SELECT patID
FROM PathologiePatient
WHERE pathID = (SELECT pathID FROM Pathologie WHERE nom = 'cancer du foie'))) AS R;

--9
SELECT M.medID, M.nom, Count(P.patID)
FROM Medecin M INNER JOIN Patient P
	ON P.refMed = M.medID
GROUP BY medID;

--10
--En se basant sur la même hypothèse que pour la requête (6), il suffit il suffit de trouver les médecins qui ont diagnositqué le cancer et pour quels patients.
SELECT medID, COUNT(patID) AS myCount
FROM PathologiePatient
WHERE pathID IN (SELECT PathID FROM Pathologie WHERE nom LIKE '%cancer%')
GROUP BY medID;

--La table temporaire suivante est utilisée pour les requêtes 11 à 13.
--Elle consiste de la table IncompatibleSubstanceActive augmentée avec toutes les paires inverses.
--Une contrainte sur la table IncompatibleSubstanceActive prévient l'ajout de paires inverses puisque c'est une redonance qui peut causer des anomalies.
--Cependant, cette redondance facilite la recherche de substances incompatibles pour les requêtes.
DROP TABLE IF EXISTS Incompatibilite;
CREATE TEMP TABLE Incompatibilite AS
(SELECT S.SubID, IA.SubB AS SubIncompatible
FROM SubstanceActive S INNER JOIN IncompatibleSubstanceActive IA
	ON S.SubID = IA.SubA)
UNION ALL
(SELECT S.SubID, IB.SubA
FROM SubstanceActive S INNER JOIN IncompatibleSubstanceActive IB
	ON S.SubID = IB.SubB);

--11
--Il suffit de trouver les médicaments couramment prescrits au patient P001 qui comportent des substances actives incompatibles avec celle du médicament M003.
SELECT MediID
FROM PrescriptionMedi P NATURAL JOIN Medicament M
WHERE P.patID = 'P001' AND P.Duree > CURRENT_DATE --On veut uniquement les medicaments du patient P001 en cours de prise.
AND M.SubID IN
(SELECT I.SubIncompatible
FROM Medicament NATURAL JOIN Incompatibilite I
WHERE MediID = 'M003');

--12
SELECT S.SubID, I.SubIncompatible
FROM SubstanceActive S LEFT JOIN Incompatibilite I 
	ON S.SubID = I.SubID
ORDER BY SubID,SubIncompatible;

--13: Voir la fin de ce fichier

--14
DELETE FROM Medecin
WHERE nom='Bos' AND prenom='Johan';

--15
UPDATE Patient
SET adresse = '1000 Strawberry Lane'
WHERE nom='Valls' AND prenom = 'Manuel';

--13
CREATE OR REPLACE FUNCTION reject_incompatible_prescription() RETURNS TRIGGER AS $reject_incompatibility$
DECLARE 
	patient CHAR(4) := NEW.PatID;
	newMed CHAR(4) := NEW.MedID;
BEGIN
	--Obtenir les substances contre-indiqués pour le patient à qui on souhaite prescrire un nouveau medicament 
	DROP TABLE IF EXISTS MedicamentsContreIndiques;
	CREATE TEMP TABLE MedicamentsContreIndiques AS
	SELECT MediID
	FROM Medicament
	WHERE SubID IN  --les subtances contre-indiqués par les medicaments du patient en cours de prise
		(SELECT SubIncompatible
		FROM Incompatibilite NATURAL JOIN Medicament
		WHERE MediID IN 
			(SELECT MediID FROM PrescriptionMedi WHERE PatID = 'P001' AND Duree > CURRENT_DATE)) 
	OR SubID IN --les substances contre-indiqués par les pathologies du patient
	(SELECT SubID
	FROM IncompatibleSubPath
	WHERE PathID IN (SELECT PathID FROM PathologiePatient WHERE PatID = 'P001'));

	IF EXISTS (SELECT * FROM MedicamentsContreIndiques WHERE MediID = newMed) THEN
		RAISE EXCEPTION 'Le medicament % est contre-indiqué pour le patient %',newMed,patient;
	END IF;
	RETURN NEW;
END;
$reject_incompatibility$ LANGUAGE plpgsql;

DROP TRIGGER IF EXISTS reject_incompatibility ON PrescriptionMedi;
CREATE TRIGGER reject_incompatibility
BEFORE INSERT ON PrescriptionMedi
    FOR EACH ROW EXECUTE PROCEDURE reject_incompatible_prescription();





