-- テーブル作成
CREATE TABLE todo.todos (
  id INT NOT NULL AUTO_INCREMENT,
  is_done BOOL DEFAULT false,
  title varchar,
  urls varchar,
  PRIMARY KEY (id)
);

CREATE TABLE todo.users (
  id INT NOT NULL AUTO_INCREMENT,
  name varchar,
  email varchar,
  password varchar,
  PRIMARY KEY (id)
);

CREATE TABLE todo.videos (
  yid INT NOT NULL AUTO_INCREMENT,
  youtubeId varchar,
  PRIMARY KEY (id)
);