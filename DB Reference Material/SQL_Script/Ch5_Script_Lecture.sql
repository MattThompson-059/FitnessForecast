-- /* ZAGI - CREATE TABLE statements Figure 5.1b */

-- CREATE TABLE vendor
-- ( 	vendorid CHAR(2) 	NOT NULL,
-- 	vendorname 	VARCHAR(25) 	NOT NULL,
-- 	PRIMARY KEY (vendorid) );

-- CREATE TABLE category
-- ( 	categoryid 	CHAR(2) 	NOT NULL,
-- 	categoryname 	VARCHAR(25) 	NOT NULL,
-- 	PRIMARY KEY (categoryid) );

-- CREATE TABLE product
-- ( 	productid 	CHAR(3) 	NOT NULL,
-- 	productname 	VARCHAR(25) 	NOT NULL,
-- 	productprice 	NUMERIC(7,2) 	NOT NULL,
-- 	vendorid 	CHAR(2) 	NOT NULL,
-- 	categoryid 	CHAR(2) 	NOT NULL,
-- 	PRIMARY KEY (productid),
-- 	FOREIGN KEY (vendorid) REFERENCES vendor(vendorid),
-- 	FOREIGN KEY (categoryid) REFERENCES category(categoryid) );

-- CREATE TABLE region
-- ( 	regionid 	CHAR(1) 	NOT NULL,
-- 	regionname 	VARCHAR(25) 	NOT NULL,
-- 	PRIMARY 	KEY (regionid) );

-- CREATE TABLE store
-- ( 	storeid 	VARCHAR(3) 	NOT NULL,
-- 	storezip 	CHAR(5) 	NOT NULL,
-- 	regionid 	CHAR(1) 	NOT NULL,
-- 	PRIMARY KEY (storeid),
-- 	FOREIGN KEY (regionid) REFERENCES region(regionid) );

-- CREATE TABLE customer
-- ( 	customerid 	CHAR(7) 	NOT NULL,
-- 	customername 	VARCHAR(15) 	NOT NULL,
-- 	customerzip 	CHAR(5) 	NOT NULL,
-- 	PRIMARY 	KEY (customerid) );

-- CREATE TABLE salestransaction
-- ( 	tid 		VARCHAR(8) 	NOT NULL,
-- 	customerid 	CHAR(7) 	NOT NULL,
-- 	storeid 	VARCHAR(3) 	NOT NULL,
-- 	tdate 		DATE 		NOT NULL,
-- 	PRIMARY KEY (tid),
-- 	FOREIGN KEY (customerid) REFERENCES customer(customerid),
-- 	FOREIGN KEY (storeid) REFERENCES store(storeid) );

-- CREATE TABLE includes
-- ( 	productid 	CHAR(3) 	NOT NULL,
-- 	tid 		VARCHAR(8) 	NOT NULL,
-- 	quantity 	INT 		NOT NULL,
-- 	PRIMARY KEY (productid, tid),
-- 	FOREIGN KEY (productid) REFERENCES product(productid),
-- 	FOREIGN KEY (tid) REFERENCES salestransaction(tid) );

-- /* ZAGI - INSERT INTO statements Figure 5.1d */

-- INSERT INTO vendor VALUES ('PG','Pacifica Gear');
-- INSERT INTO vendor VALUES ('MK','Mountain King');

-- INSERT INTO category VALUES ('CP','Camping');
-- INSERT INTO category VALUES ('FW','Footwear');

-- INSERT INTO product VALUES ('1X1','Zzz Bag',100,'PG','CP');
-- INSERT INTO product VALUES ('2X2','Easy Boot',70,'MK','FW');
-- INSERT INTO product VALUES ('3X3','Cosy Sock',15,'MK','FW');
-- INSERT INTO product VALUES ('4X4','Dura Boot',90,'PG','FW');
-- INSERT INTO product VALUES ('5X5','Tiny Tent',150,'MK','CP');
-- INSERT INTO product VALUES ('6X6','Biggy Tent',250,'MK','CP');

-- INSERT INTO region VALUES ('C','Chicagoland');
-- INSERT INTO region VALUES ('T','Tristate');

-- INSERT INTO store VALUES ('S1','60600','C');
-- INSERT INTO store VALUES ('S2','60605','C');
-- INSERT INTO store VALUES ('S3','35400','T');

-- INSERT INTO customer VALUES ('1-2-333','Tina','60137');
-- INSERT INTO customer VALUES ('2-3-444','Tony','60611');
-- INSERT INTO customer VALUES ('3-4-555','Pam','35401');

-- INSERT INTO salestransaction VALUES ('T111','1-2-333','S1', '2020-01-01');
-- INSERT INTO salestransaction VALUES ('T222','2-3-444','S2','2020-01-01');
-- INSERT INTO salestransaction VALUES ('T333','1-2-333','S3','2020-01-02');
-- INSERT INTO salestransaction VALUES ('T444','3-4-555','S3','2020-01-02');
-- INSERT INTO salestransaction VALUES ('T555','2-3-444','S3','2020-01-02');

-- INSERT INTO includes VALUES ('1X1','T111',1);
-- INSERT INTO includes VALUES ('2X2','T222',1);
-- INSERT INTO includes VALUES ('3X3','T333',5);
-- INSERT INTO includes VALUES ('1X1','T333',1);
-- INSERT INTO includes VALUES ('4X4','T444',1);
-- INSERT INTO includes VALUES ('2X2','T444',2);
-- INSERT INTO includes VALUES ('4X4','T555',4);
-- INSERT INTO includes VALUES ('5X5','T555',2);
-- INSERT INTO includes VALUES ('6X6','T555',1);

-- select productid, productname, productprice, vendorid, categoryid
-- from product;

-- select productid, productprice, productprice * 1.1
-- from product;

-- select productid, productname, vendorid, productprice
-- from product
-- where productprice > 100;

-- select productid, productname, vendorid, productprice
-- from product
-- where productprice <= 110 and categoryid = 'FW';

-- select distinct vendorid
-- from product;

-- select productid, productname, categoryid, productprice
-- from product
-- where categoryid = "FW"
-- order by productprice;

-- select productid, productname, productprice, categoryid
-- from product
-- order by categoryid, productprice;

-- select *
-- from product
-- where productname LIKE '%Boot%';

select count(productid)
from product;

-- select count(vendorid)
-- from product;

-- select count(*), avg(productprice), min(productprice), max(productprice)
-- from product
-- where categoryid = 'CP';

-- select vendorid , count(*), avg(productprice)
-- from product;

-- select vendorid, count(*)
-- from product
-- where productprice >= 100
-- group by vendorid;

-- select vendorid, categoryid, count(*), avg(productprice)
-- from product
-- group by vendorid, categoryid;

-- select productid, sum(quantity)
-- from includes
-- group by productid;

-- select productid, count(*)
-- from includes
-- group by productid;

-- select vendorid, categoryid, count(*), avg(productprice)
-- from product
-- group by vendorid, categoryid
-- having count(*) > 1;

-- select productid, productname, productprice
-- from product
-- where productprice < (select avg(productprice)
-- from product);

-- select productid
-- from includes
-- group by productid
-- having SUM(quantity) > 3;

-- select p.productid pid, p.productname pname, v.vendorid vname, p.productprice pprice
-- from product p, vendor v
-- where p.vendorid = v.vendorid;

-- select t.tid, t.tdate, p.productname, i.quantity, (i.quantity * p.productprice)
-- from product p, salestransaction t, includes i
-- where p.productid= i.productid AND i.tid = t.tid
-- order by t.tid;

-- CREATE VIEW products_more_than_3_sold AS
-- SELECT productid, productname, productprice
-- FROM product
-- WHERE productid IN
-- 		(SELECT productid
-- 		FROM includes
-- 		GROUP BY productid
-- 		HAVING SUM(quantity) > 3);

-- CREATE VIEW products_in_multiple_trnsc AS
-- SELECT productid, productname, productprice
-- FROM product
-- WHERE productid IN
-- 		(SELECT productid
-- 		FROM includes
-- 		GROUP BY productid
-- 		HAVING COUNT(*) > 1);
        
-- select *
-- from products_in_multiple_trnsc
-- union
-- select *
-- from products_more_than_3_sold;

-- select *
-- from products_in_multiple_trnsc
-- natural join products_more_than_3_sold;

-- select distinct *
-- from products_more_than_3_sold
-- where (productid, productname, productprice) 
-- 	IN (select * from products_in_multiple_trnsc);

select distinct *
from products_more_than_3_sold
where (productid, productname, productprice) 
	NOT IN (select * from products_in_multiple_trnsc);