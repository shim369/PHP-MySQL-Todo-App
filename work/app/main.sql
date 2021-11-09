-- ターミナルからテーブル作成
CREATE TABLE todo.todos (
  id INT NOT NULL AUTO_INCREMENT,
  is_done BOOL DEFAULT false,
  title TEXT,
  PRIMARY KEY (id)
);
-- テーブルにデータを手動でテスト追加
INSERT INTO todo.todos (title) VALUES ('aaa');
INSERT INTO todo.todos (title, is_done) VALUES ('bbb', true);
INSERT INTO todo.todos (title, is_done) VALUES ('ccc', false);

SELECT * FROM todos;