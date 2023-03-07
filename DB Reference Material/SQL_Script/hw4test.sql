-- select agentid, agentname
-- from agent
-- where agentyearofhire < 2000;

-- select avg(agentrating)
-- from agent;

-- select areaid, count(agentid)
-- from area, agent
-- group by areaid;

-- select clientname, agentname
-- from client c, agent a
-- where a.agentname = 'Amy' and c.agentid in
--     (select agentid
--     from agent
--     where agentname = 'Amy');

-- select agentid, agentname 
-- from agent 
-- where agentrating = (select min(agentrating) from agent);

select areaid, areaname, avg(agentrating)
from area, agent
where agentrating > 100;

-- SELECT clientname
-- FROM client
-- WHERE clientspousename IS NULL;

