CREATE DATABASE todolist
DEFAULT CHARACTER SET utf8
DEFAULT COLLATE utf8_general_ci;

USE todolist;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_add DATETIME,
  name VARCHAR(255),
  email VARCHAR(255) NOT NULL,
  password VARCHAR(64)
);

CREATE TABLE projects (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title_project VARCHAR(255),
  user_id INT
);

CREATE TABLE tasks (
  id INT AUTO_INCREMENT PRIMARY KEY,
  date_create DATETIME,
  date_done DATETIME,
  state TINYINT DEFAULT 0,
  title_task VARCHAR(255),
  file VARCHAR(255),
  date_do DATETIME,
  user_id INT,
  project_id INT
);

CREATE UNIQUE INDEX email ON users(email);
CREATE INDEX date_add ON users(date_add);
CREATE INDEX user_name ON users(name);
CREATE INDEX title_project ON projects(title_project);
CREATE INDEX date_create ON tasks(date_create);
CREATE INDEX date_done ON tasks(date_done);
CREATE INDEX date_do ON tasks(date_do);
CREATE FULLTEXT INDEX title_task ON tasks(title_task);
CREATE INDEX state ON tasks(state);
