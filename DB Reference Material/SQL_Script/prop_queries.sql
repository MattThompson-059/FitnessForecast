-- select c.ccname AS client_name, r.ccname as recommender
-- from corpclient c, corpclient r
-- where c.ccid = r.ccidreferredby;

-- select a.buildingid, a.aptno, c.ccname
-- from apartment a, corpclient c
-- where a.ccid = c.ccid;

-- select a.buildingid, a.aptno, c.ccname
-- from apartment a
-- inner join corpclient c
-- on a.ccid = c.ccid;

-- select a.buildingid, a.aptno, c.ccname
-- from apartment a left outer join corpclient c
-- on a.ccid = c.ccid
-- union 
-- select a.buildingid, a.aptno, c.ccname
-- from apartment a right outer join corpclient c
-- on a.ccid = c.ccid;

-- select *
-- from manager
-- where mbonus is NULL;

-- select *
-- from manager
-- where mbonus is not NULL;

-- SELECT *
-- FROM corpclient c
-- WHERE EXISTS
-- (SELECT *
-- FROM apartment a
-- WHERE c.ccid = a.ccid);

-- SELECT *
-- FROM corpclient c
-- WHERE NOT EXISTS
-- (SELECT *
-- FROM apartment a
-- WHERE c.ccid = a.ccid);

-- SELECT *
-- FROM corpclient c
-- WHERE c.ccid IN
-- (SELECT cc.ccid
-- FROM apartment a, corpclient cc
-- WHERE cc.ccid = a.ccid);

-- CREATE TABLE cleaningdenormalized
-- ( buildingid CHAR(3) NOT NULL,
-- aptno CHAR(5) NOT NULL,
-- smemberid CHAR(4) NOT NULL,
-- smembername VARCHAR(15) NOT NULL,
-- PRIMARY KEY (buildingid, aptno, smemberid));

select *
from cleaningdenormalized;
INSERT INTO cleaningdenormalized 
SELECT c.buildingid, c.aptno, s.smemberid, s.smembername
FROM cleaning c, staffmember s
WHERE c.smemberid = s.smemberid;

