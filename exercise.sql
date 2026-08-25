-- Database Creation
CREATE DATABASE socialNetwork;

-- Using the Database Created
use socialNetwork;

-- Create Tables tUser, tFriends, tWall
CREATE TABLE tUser(
	User_id int(11) PRIMARY KEY,
	Name varchar(50) NOT NULL,
	Email_id varchar(50) NOT NULL,
	Password varchar(50) NOT NULL,
	Address varchar(100),
	Phone bigint(18)
);

CREATE TABLE tFriends(
	user_id int, 
	friend_id int,
	FOREIGN KEY(user_id) REFERENCES tUser(User_id),
	FOREIGN KEY(friend_id) REFERENCES tUser(User_id)
);

CREATE TABLE tWall(
	user_id int 
	posting_date datetime DEFAULT CURRENT_TIMESTAMP,
	post varchar(200) NOT NULL
	FOREIGN KEY(user_id) REFERENCES tUser(User_id)
);

-- Insert Values into the tables
INSERT INTO tUser VALUES
(1, 'Alice Smith', 'alice@example.com', 'password', '123 Maple St, Boston', 9876543210),
(2, 'Bob Jones', 'bob@example.com', 'password', '456 Oak Rd, New York', 8765432109),
(3, 'Charlie Brown', 'charlie@example.com', 'password', '789 Pine Ave, Chicago', 7654321098),
(4, 'Diana Prince', 'diana@example.com', 'password', '101 Cherry Ln, Seattle', 6543210987);

INSERT INTO tFriends VALUES
(1, 2), 
(2, 1), 
(1, 3), 
(3, 1), 
(3, 4),
(4, 3);

INSERT INTO tWall VALUES
(1, '2026-08-25 09:00:00', 'Hello world! This is my first post on the wall.'),
(2, '2026-08-25 09:30:00', 'Excited to connect with friends here.'),
(1, '2026-08-25 10:00:00', 'What is everyone up to today?'),
(3, CURRENT_TIMESTAMP, 'Just joined the platform! Feel free to add me.');

--Queries for the questions asked
-- 2
SELECT * FROM tUser WHERE Name = 'Bob Jones' ;

-- 3
SELECT Name,posting_date,post 
FROM tUser u
JOIN tWall w
ON u.User_id = w.user_id 
WHERE u.name = 'Alice Smith';


--4
SELECT u.Name as Name, t.Name as Friend, posting_date, post
FROM tWall w
JOIN tFriends f
ON w.user_id = f.friend_id
JOIN tUser t
ON f.friend_id = t.User_id 
JOIN tUser u
ON f.user_id = u.User_id
WHERE t.name = "Alice Smith" AND u.name = 'Charlie Brown';

--5
SELECT fof.name as Friends 
FROM tUser fof
JOIN tFriends ft ON fof.User_id = ft.friend_id
JOIN tFriends ut ON ft.user_id = ut.friend_id
JOIN tUser f ON ut.friend_id = f.User_id
JOIN tUser u ON ut.user_id = u.User_id
WHERE  f.Name = 'Alice Smith' AND u.Name = 'Bob Jones';

--6
-- DELETE FROM tFriends f
-- WHERE (f.user_id = (SELECT user_id FROM tUser WHERE Name= 'Alice Smith' ) AND f.friend_id = (SELECT user_id FROM tUser WHERE Name= 'Bob Jones' ))
-- OR (f.user_id = (SELECT user_id FROM tUser WHERE Name= 'Bob Jones' ) AND f.friend_id = (SELECT user_id FROM tUser WHERE Name= 'Alice Smith' ));

DELETE FROM tFriends f
WHERE f.user_id IN (SELECT user_id FROM tUser WHERE Name IN ('Alice Smith', 'Bob Jones' ))
AND f.friend_id IN (SELECT user_id FROM tUser WHERE Name IN ('Bob Jones', 'Alice Smith' ));


--7
INSERT INTO tWall
SELECT User_id, CURRENT_TIMESTAMP, 'Hello! New Post'
FROM tUser
WHERE tUser.name = "Diana Prince";