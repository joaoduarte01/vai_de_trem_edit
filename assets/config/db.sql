






DROP DATABASE IF EXISTS vaidetrem2;

CREATE DATABASE IF NOT EXISTS vaidetrem2
  CHARACTER SET utf8mb4
  COLLATE utf8mb4_unicode_ci;
USE vaidetrem2;




CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(200) NOT NULL,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  phone VARCHAR(30),
  department VARCHAR(120),
  job_title VARCHAR(120),
  avatar VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT uq_users_email UNIQUE (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




CREATE TABLE IF NOT EXISTS stations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  city VARCHAR(120),
  state CHAR(2),
  cep VARCHAR(9),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




CREATE TABLE IF NOT EXISTS routes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  status ENUM('ativa','manutencao') NOT NULL DEFAULT 'ativa',
  duration_minutes INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;





CREATE TABLE IF NOT EXISTS route_stations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  route_id INT NOT NULL,
  station_id INT NOT NULL,
  stop_order INT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_rs_route FOREIGN KEY (route_id)
    REFERENCES routes(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_rs_station FOREIGN KEY (station_id)
    REFERENCES stations(id) ON DELETE RESTRICT ON UPDATE CASCADE,
  CONSTRAINT uq_route_stop UNIQUE (route_id, stop_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




CREATE TABLE IF NOT EXISTS cameras (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  location VARCHAR(200),
  status ENUM('online','offline') DEFAULT 'online',
  train_code VARCHAR(50),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




CREATE TABLE IF NOT EXISTS notices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,
  tag ENUM('Manutenção','Novidades','Sistema') DEFAULT 'Sistema',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;




CREATE TABLE IF NOT EXISTS chat_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_chat_user FOREIGN KEY (user_id)
    REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;






DELETE FROM users WHERE email IN ('admin@vaidetrem.com','cliente@vaidetrem.com');





INSERT INTO users (name, email, password, role, avatar)
VALUES
('Administrador', 'admin@vaidetrem.com',
  '$2y$10$4uEvjaGCF3Zr7ZSeZb05EOB7JHnIB8uHQzOHcKyImNOf0UbH19V0S', 'admin', NULL),
('Cliente de Teste', 'cliente@vaidetrem.com',
  '$2y$10$Q3nVsb09TLOE2RSkWnRQhO8Fj8AZqQTBSPi2nZJb3M2N6yS6Kzk3i', 'user', NULL);


INSERT IGNORE INTO stations (name, city, state, cep) VALUES
('Estação Central - Plataforma 1','São Paulo','SP','01001-000'),
('Estação Central - Plataforma 2','São Paulo','SP','01001-000'),
('Estação Norte - Entrada','São Paulo','SP','02000-000'),
('Estação Sul - Plataforma 1','São Paulo','SP','04000-000'),
('Túnel KM 45','Campinas','SP','13010-000'),
('Ponte Rio Grande','Sorocaba','SP','18010-000');


INSERT IGNORE INTO routes (name, status, duration_minutes) VALUES
('São Paulo → Rio de Janeiro','ativa',390),
('Campinas → Santos','ativa',225),
('Belo Horizonte → São Paulo','manutencao',495),
('Curitiba → Florianópolis','ativa',320);


INSERT IGNORE INTO route_stations (route_id, station_id, stop_order) VALUES
(1,1,1),(1,3,2),(1,2,3),
(2,5,1),(2,6,2),
(3,4,1),(3,1,2),
(4,3,1),(4,6,2);


INSERT IGNORE INTO cameras (name, location, status, train_code) VALUES
('Câmera #1','Estação Central - Plataforma 1','online','1234'),
('Câmera #2','Estação Central - Plataforma 2','online','5678'),
('Câmera #3','Estação Norte - Entrada','online',NULL),
('Câmera #4','Estação Sul - Plataforma 1','offline',NULL),
('Câmera #5','Túnel KM 45','online','9012'),
('Câmera #6','Ponte Rio Grande','online','3456');


INSERT IGNORE INTO notices (title, body, tag) VALUES
('Manutenção Programada',
 'Linha São Paulo-Rio será interditada dia 15/01 das 02h às 06h para manutenção preventiva.',
 'Manutenção'),
('Nova Rota Disponível',
 'A partir de amanhã, nova rota Campinas-Sorocaba estará operando das 06h às 22h.',
 'Novidades'),
('Atualização de Sistema',
 'Sistema de câmeras atualizado com novos recursos de detecção automática.',
 'Sistema');


INSERT IGNORE INTO chat_messages (user_id, message) VALUES
( (SELECT id FROM users WHERE email='cliente@vaidetrem.com' LIMIT 1), 'Olá, gostaria de informações sobre a rota SP-RJ.' ),
( (SELECT id FROM users WHERE email='admin@vaidetrem.com' LIMIT 1), 'Mensagem de boas-vindas do administrador.' );







DROP DATABASE IF EXISTS vaidetrem2;
CREATE DATABASE vaidetrem2 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vaidetrem2;

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(200) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  role ENUM('admin','user') NOT NULL DEFAULT 'user',
  phone VARCHAR(30),
  department VARCHAR(120),
  job_title VARCHAR(120),
  avatar VARCHAR(255) DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE stations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  city VARCHAR(120),
  state CHAR(2),
  cep VARCHAR(9),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE routes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(200) NOT NULL,
  status ENUM('ativa','manutencao') DEFAULT 'ativa',
  duration_minutes INT DEFAULT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE route_stations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  route_id INT NOT NULL,
  station_id INT NOT NULL,
  stop_order INT NOT NULL,
  FOREIGN KEY (route_id) REFERENCES routes(id) ON DELETE CASCADE,
  FOREIGN KEY (station_id) REFERENCES stations(id) ON DELETE RESTRICT
);

CREATE TABLE cameras (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  location VARCHAR(200),
  status ENUM('online','offline') DEFAULT 'online',
  train_code VARCHAR(50)
);

CREATE TABLE notices (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  body TEXT NOT NULL,
  tag ENUM('Manutenção','Novidades','Sistema') DEFAULT 'Sistema',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE chat_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


INSERT INTO users (name,email,password,role) VALUES
('Administrador','admin@vaidetrem.com','$2y$10$4uEvjaGCF3Zr7ZSeZb05EOB7JHnIB8uHQzOHcKyImNOf0UbH19V0S','admin'),
('Cliente de Teste','cliente@vaidetrem.com','$2y$10$Q3nVsb09TLOE2RSkWnRQhO8Fj8AZqQTBSPi2nZJb3M2N6yS6Kzk3i','user');


CREATE TABLE employees (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  role VARCHAR(120) NOT NULL,
  phone VARCHAR(30),
  cep VARCHAR(12),
  street VARCHAR(200),
  neighborhood VARCHAR(150),
  city VARCHAR(120),
  uf VARCHAR(4),
  photo VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
