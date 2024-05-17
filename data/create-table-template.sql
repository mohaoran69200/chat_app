-- Active: 1714565559054@@127.0.0.1@3306@chat_app
CREATE TABLE messages(  
    id int NOT NULL PRIMARY KEY AUTO_INCREMENT COMMENT 'Primary Key',
    message VARCHAR(255),
    create_at DATETIME COMMENT 'Create Time'
    
) COMMENT '';