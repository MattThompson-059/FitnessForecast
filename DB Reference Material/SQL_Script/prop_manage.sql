/* HAFH - CREATE TABLE statements Figure 5.40b */

CREATE TABLE manager
( 	managerid 	CHAR(4) 	NOT NULL,
	mfname 		VARCHAR(15) 	NOT NULL,
	mlname 		VARCHAR(15) 	NOT NULL,
	mbdate 		DATE 		NOT NULL,
	msalary 	NUMERIC(9,2) 	NOT NULL,
	mbonus 		NUMERIC(9,2),
	mresbuildingid 	CHAR(3),
	PRIMARY KEY (managerid) );

CREATE TABLE managerphone
( 	managerid 	CHAR(4) 	NOT NULL,
	mphone 		CHAR(11) 	NOT NULL,
	PRIMARY KEY (managerid, mphone),
	FOREIGN KEY (managerid) REFERENCES manager(managerid) );

CREATE TABLE building
( 	buildingid 	CHAR(3) 	NOT NULL,
	bnooffloors 	INT 		NOT NULL,
	bmanagerid 	CHAR(4) 	NOT NULL,
	PRIMARY KEY (buildingid),
	FOREIGN KEY (bmanagerid) REFERENCES manager(managerid) );

CREATE TABLE inspector
( 	insid 		CHAR(3) 	NOT NULL,
	insname 	VARCHAR(15) 	NOT NULL,
	PRIMARY KEY (insid) );

CREATE TABLE inspecting
( 	insid 		CHAR(3) 	NOT NULL,
	buildingid 	CHAR(3) 	NOT NULL,
	datelast 	DATE 		NOT NULL,
	datenext 	DATE 		NOT NULL,
	PRIMARY KEY (insid, buildingid),
	FOREIGN KEY (insid) REFERENCES inspector(insid),
	FOREIGN KEY (buildingid) REFERENCES building(buildingid) );

CREATE TABLE corpclient
( 	ccid 		CHAR(4) 	NOT NULL,
	ccname 		VARCHAR(25) 	NOT NULL,
	ccindustry 	VARCHAR(25) 	NOT NULL,
	cclocation 	VARCHAR(25) 	NOT NULL,
	ccidreferredby 	CHAR(4),
	PRIMARY KEY (ccid),
	UNIQUE (ccname),
	FOREIGN KEY (ccidreferredby) REFERENCES corpclient(ccid) );

CREATE TABLE apartment
( 	buildingid 	CHAR(3) 	NOT NULL,
	aptno 		CHAR(5) 	NOT NULL,
	anoofbedrooms 	INT 		NOT NULL,
	ccid 		CHAR(4),
	PRIMARY KEY (buildingid, aptno),
	FOREIGN KEY (buildingid) REFERENCES building(buildingid),
	FOREIGN KEY (ccid) REFERENCES corpclient(ccid) );

CREATE TABLE staffmember
( 	smemberid 	CHAR(4) 	NOT NULL,
	smembername 	VARCHAR(15) 	NOT NULL,
	PRIMARY KEY (smemberid) );

CREATE TABLE cleaning
( 	buildingid 	CHAR(3) 	NOT NULL,
	aptno 		CHAR(5) 	NOT NULL,
	smemberid 	CHAR(4) 	NOT NULL,
	CONSTRAINT cleaningpk PRIMARY KEY (buildingid, aptno, smemberid),
	CONSTRAINT cleaningfk1 FOREIGN KEY (buildingid, aptno)
	REFERENCES apartment(buildingid, aptno),
	CONSTRAINT cleaningfk2 FOREIGN KEY (smemberid)
	REFERENCES staffmember(smemberid) );

/* ZAGI - INSERT INTO statements Figure 5.40d */

INSERT INTO manager VALUES ('M12', 'Boris', 'Grant', '1980-06-20', 60000, null, null);
INSERT INTO manager VALUES ('M23', 'Austin', 'Lee', '1975-10-30', 50000, 5000, null);
INSERT INTO manager VALUES ('M34', 'George', 'Sherman', '1976-01-11', 52000, 2000, null);

INSERT INTO managerphone VALUES ('M12','555-2222');
INSERT INTO managerphone VALUES ('M12','555-3232');
INSERT INTO managerphone VALUES ('M23','555-9988');
INSERT INTO managerphone VALUES ('M34','555-9999');

INSERT INTO building VALUES ('B1', '5', 'M12');
INSERT INTO building VALUES ('B2', '6', 'M23');
INSERT INTO building VALUES ('B3', '4', 'M23');
INSERT INTO building VALUES ('B4', '4', 'M34');

INSERT INTO inspector VALUES ('I11', 'Jane');
INSERT INTO inspector VALUES ('I22', 'Niko');
INSERT INTO inspector VALUES ('I33', 'Mick');

INSERT INTO inspecting VALUES ('I11','B1','2019-05-05','2020-05-05');
INSERT INTO inspecting VALUES ('I11','B2','2019-02-02','2020-02-02');
INSERT INTO inspecting VALUES ('I22','B2','2019-04-03','2020-02-02');
INSERT INTO inspecting VALUES ('I22','B3','2019-08-09','2020-03-03');
INSERT INTO inspecting VALUES ('I33','B3','2019-04-04','2020-04-04');
INSERT INTO inspecting VALUES ('I33','B4','2019-05-05','2020-04-04');

INSERT INTO corpclient VALUES ('C111', 'BlingNotes', 'Music', 'Chicago', null);
INSERT INTO corpclient VALUES ('C222', 'SkyJet', 'Airline', 'Oak Park', 'C111');
INSERT INTO corpclient VALUES ('C777', 'WindyCT', 'Music', 'Chicago', 'C222');
INSERT INTO corpclient VALUES ('C888', 'SouthAlps', 'Sports', 'Rosemont', 'C777');

INSERT INTO apartment VALUES ('B1', '21', 1, 'C111');
INSERT INTO apartment VALUES ('B1', '41', 1, null);
INSERT INTO apartment VALUES ('B2', '11', 2, 'C222');
INSERT INTO apartment VALUES ('B2', '31', 2, null);
INSERT INTO apartment VALUES ('B3', '11', 2, 'C777');
INSERT INTO apartment VALUES ('B4', '11', 2, 'C777');

INSERT INTO staffmember VALUES ('5432', 'Brian');
INSERT INTO staffmember VALUES ('9876', 'Boris');
INSERT INTO staffmember VALUES ('7652', 'Caroline');

INSERT INTO cleaning VALUES ('B1', '21', '5432');
INSERT INTO cleaning VALUES ('B1', '41', '9876');
INSERT INTO cleaning VALUES ('B2', '11', '9876');
INSERT INTO cleaning VALUES ('B2', '31', '5432');
INSERT INTO cleaning VALUES ('B3', '11', '5432');
INSERT INTO cleaning VALUES ('B4', '11', '7652');

/* Alter Statement 5 */
ALTER TABLE manager
ADD CONSTRAINT fkresidesin
FOREIGN KEY (mresbuildingid) REFERENCES
	   building (buildingid);

/* Update Statement 4 */

UPDATE manager
SET mresbuildingid = 'B1'
WHERE managerid = 'M12';

/* Update Statement 5 */

UPDATE manager
SET mresbuildingid = 'B2'
WHERE managerid = 'M23';

/* Update Statement 6 */

UPDATE manager
SET mresbuildingid = 'B4'
WHERE managerid = 'M34';

/* Alter Statement 6 */

ALTER TABLE manager
MODIFY mresbuildingid   CHAR(3)     NOT NULL;