create table company
(
    compid int auto_increment primary key,
    name   nvarchar(100) not null,
    INDEX (name)
);
create table goods
(
    goodid int auto_increment primary key,
    name   nvarchar(100) not null
);
create table shipment
(
    shipid   int auto_increment primary key,
    compid   int      not null,
    goodid   int      not null,
    quantity float    not null,
    shipdate datetime not null
);

insert company (compid, name)
values (1, 'Intel');
insert company (compid, name)
values (2, 'IBM');
insert company (compid, name)
values (3, 'Compaq');

insert goods (goodid, name)
values (1, 'Pentium IIV');
insert goods (goodid, name)
values (2, 'IBM server');
insert goods (goodid, name)
values (3, 'Compaq Presario');

insert shipment (compid, goodid, quantity, shipdate)
values (1, 1, 100, '2010-04-11');
insert shipment (compid, goodid, quantity, shipdate)
values (1, 1, 200, '2010-11-12');
insert shipment (compid, goodid, quantity, shipdate)
values (1, 2, 300, '2010-12-02');
insert shipment (compid, goodid, quantity, shipdate)
values (1, 2, 400, '2010-10-09');
insert shipment (compid, goodid, quantity, shipdate)
values (2, 1, 100, '2010-10-29');
insert shipment (compid, goodid, quantity, shipdate)
values (2, 1, 200, '2010-11-06');
insert shipment (compid, goodid, quantity, shipdate)
values (2, 2, 300, '2010-12-29');
insert shipment (compid, goodid, quantity, shipdate)
values (2, 2, 700, '2010-12-03');


# 2.a. Вывести общий объем поставок каждого из продуктов для каждой фирмы с указанием
#       даты последней поставки
select company.name, goods.name, SUM(quantity) as quantity, MAX(shipment.shipdate) as shipdate
from shipment
         join company on company.compid = shipment.compid
         join goods on goods.goodid = shipment.goodid
group by company.name, goods.name;

# 2.b. Аналогично предыдущему пункту, но за последние 40 дней. Если поставки
#     какого-либо из товаров для компании в этот период отсутствовали, вывести в
#     столбце объема 'No data'
select company.name,
       goods.name                          as goodsName,
       CASE
           WHEN shipdate <= (NOW() - INTERVAL 1 MONTH)
               THEN 'No data'
           ELSE SUM(quantity) END          as quantity,
       CASE
           WHEN shipdate <= (NOW() - INTERVAL 1 MONTH)
               THEN NULL
           ELSE MAX(shipment.shipdate) END as lastShipmentDate
from shipment
         join company on company.compid = shipment.compid
         join goods on goods.goodid = shipment.goodid
group by company.name, goods.name, shipment.shipdate;