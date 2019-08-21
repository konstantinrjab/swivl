create database part_two;
use part_two;

CREATE TABLE Firms
(
    ID   INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    Name VARCHAR(30) NOT NULL
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

# TODO: make it work
select Firms.Name, P.Phone
from Firms
         left join Phones P on Firms.ID = P.FirmID
group by Firms.Name;

select Firms.Name
from Firms
         left join Phones P on Firms.ID = P.FirmID
where P.Phone is null;

select Firms.Name, count(*) as count
from Firms
         join Phones P on Firms.ID = P.FirmID
group by Firms.Name
having count >= 2;

select Firms.Name, count(*) as count
from Firms
         left join Phones P on Firms.ID = P.FirmID
group by Firms.Name
having count < 2;

select Firms.Name, count(*) as count
from Firms
         left join Phones P on Firms.ID = P.FirmID
group by Firms.Name
order by count desc
limit 1;