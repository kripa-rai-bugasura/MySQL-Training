-- Database Creation
CREATE DATABASE socialNetwork;

-- Using the Database Created
use socialNetwork;

-- Create Tables tUser, tFriends, tWall
CREATE TABLE tUser(
	user_id int(11) PRIMARY KEY,
	name varchar(50) NOT NULL,
	email_id varchar(50) NOT NULL,
	password varchar(50) NOT NULL,
	address varchar(100),
	phone bigint(18)
);

CREATE TABLE tFriends(
	user_id int, 
	friend_id int,
	FOREIGN KEY(user_id) REFERENCES tUser(user_id),
	FOREIGN KEY(friend_id) REFERENCES tUser(user_id)
);

CREATE TABLE tWall(
	user_id int 
	posting_date datetime DEFAULT CURRENT_TIMESTAMP,
	post varchar(200) NOT NULL
	FOREIGN KEY(user_id) REFERENCES tUser(user_id)
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
SELECT 
	* 
FROM 
	tUser 
WHERE 
	name = 'Bob Jones' ;

-- 3
SELECT 
	u.name,
	w.posting_date,
	w.post 
FROM 
	tUser u
	LEFT JOIN tWall w ON u.user_id = w.user_id 
WHERE 
	u.name = 'Alice Smith';


--4
SELECT 
	up.name as Name, 
	uf.name as Friend, 
	w.posting_date, 
	w.post
FROM 
	tWall w
	LEFT JOIN tFriends f ON w.user_id = f.friend_id
	LEFT JOIN tUser uf ON f.friend_id = uf.user_id 
	LEFT JOIN tUser up ON f.user_id = up.user_id
WHERE 
	uf.name = "Alice Smith" AND up.name = 'Charlie Brown';

--5
SELECT 
	ufof.name as Friends 
FROM 
	tUser ufof
	LEFT JOIN tFriends ff ON ufof.user_id = ff.friend_id
	LEFT JOIN tFriends fp ON ff.user_id = fp.friend_id
	LEFT JOIN tUser uf ON fp.friend_id = uf.user_id
	LEFT JOIN tUser up ON fp.user_id = up.user_id
WHERE  
	uf.name = 'Alice Smith' AND up.name = 'Bob Jones';

--6
DELETE
	f
FROM 
	tFriends f
	LEFT JOIN tUser up ON f.user_id = up.user_id
	LEFT JOIN tUser uf ON uf.user_id = f.friend_id
WHERE
	up.name = 'Alice Smith' AND uf.name = 'Bob Jones';


--7
INSERT INTO 
	tWall
SELECT 
	user_id, 
	CURRENT_TIMESTAMP,
	'Hello! New Post'
FROM
	tUser
WHERE 
	name = "Diana Prince";