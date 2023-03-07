select E_First, E_Last
from employee
where E_ID in
(select Mentor_ID
from employee
group by Mentor_ID
having count(Mentor_ID) >= 2);

SELECT * FROM assemblyline
WHERE
itemtype LIKE '*automobile';

SELECT empSSN, emp_fname, emp_lname, enrollmentdate
from employee e, insurancePolicy i
where i.enrollment <= '2020-06-01';

SELECT avg(cost) FROM insurancepolicy;