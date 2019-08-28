create database part_two;
use part_two;

CREATE TABLE Firms
(
    ID   INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(30) NOT NULL,
    INDEX (Name)
);
CREATE TABLE Phones
(
    phone_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    FirmID   INT(6) UNSIGNED NOT NULL,
    Phone    VARCHAR(30)     NOT NULL,
    FOREIGN KEY (FirmID) REFERENCES Firms (ID)
);

insert into Firms (Name)
values ('Sony'),
       ('Panasonic'),
       ('Samsung');

insert into Phones (FirmID, Phone)
values (1, '332-55-56'),
       (1, '332-50-01'),
       (2, '256-49-12');


# 1.a Вернуть название фирмы и ее телефон. В результате должны быть представлены
#    все фирмы по одному разу. Если у фирмы нет телефона, нужно вернуть пробел или
#    прочерк. Если у фирмы несколько телефонов, нужно вернуть любой из них.
select Firms.Name, CASE WHEN P.Phone IS NULL THEN '--' ELSE P.Phone END as phone
from Firms
         left join Phones P on Firms.ID = P.FirmID
group by Firms.Name, P.Phone;

# 1.b. Вернуть все фирмы, не имеющие телефонов.
select Firms.*
from Firms
         left join Phones P on Firms.ID = P.FirmID
where P.Phone is null;

# 1.c. Вернуть все фирмы, имеющие не менее 2-х телефонов.
select Firms.Name, count(*) as count
from Firms
         join Phones P on Firms.ID = P.FirmID
group by Firms.Name
having count >= 2;

# 1.d. Вернуть все фирмы, имеющие менее 2-х телефонов.
select Firms.Name, count(*) as count
from Firms
         left join Phones P on Firms.ID = P.FirmID
group by Firms.Name
having count < 2;

# 1.e. Вернуть фирму, имеющую максимальное кол-во телефонов.
select Firms.Name, count(*) as count
from Firms
         left join Phones P on Firms.ID = P.FirmID
group by Firms.Name
order by count desc
limit 1;