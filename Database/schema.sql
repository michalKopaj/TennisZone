
CREATE DATABASE IF NOT EXISTS tenniszone1 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE tenniszone1;


CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS articles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    author_id INT,
    title VARCHAR(255) NOT NULL,
    slug VARCHAR(255) NOT NULL UNIQUE,
    perex TEXT,
    content TEXT NOT NULL,
    image VARCHAR(255),
    is_published TINYINT(1) DEFAULT 0,
    views INT DEFAULT 0,
    published_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE SET NULL,
    FOREIGN KEY (author_id) REFERENCES users(id) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS players (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    country VARCHAR(50),
    ranking INT,
    birth_date DATE,
    bio TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS tournaments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    location VARCHAR(100),
    surface VARCHAR(50),
    start_date DATE,
    end_date DATE,
    prize_money INT,
    description TEXT,
    image VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    article_id INT NOT NULL,
    user_id INT NOT NULL,
    body TEXT NOT NULL,
    is_approved TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (article_id) REFERENCES articles(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);


CREATE TABLE IF NOT EXISTS contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



	-- hesla: admin123 (hash cez password_hash)
INSERT INTO users (username, email, password_hash, role) VALUES
('admin', 'admin@tenniszone.sk', '$2y$12$e0NR4M9gL8W0xY3hJ8e6t.P5r2d0R8YxJx7m8Q1P4Jr2g8h2z6D8K', 'admin'),
('fanusik', 'fanusik@tenniszone.sk', '$2y$12$GZTnHiFuAixK1FrXMPPva.WIXJDayFK8Ixm/X0.I8dW4yQXZxVOxK', 'user');

INSERT INTO categories (name, slug, description) VALUES
('ATP',         'atp',         'Mužský profesionálny tenis'),
('WTA',         'wta',         'Ženský profesionálny tenis'),
('Grand Slam',  'grand-slam',  'Štyri najprestížnejšie turnaje sezóny'),
('Davis Cup',   'davis-cup',   'Tímová súťaž národných reprezentácií');

INSERT INTO players (name, country, ranking, birth_date, bio, image) VALUES
('Carlos Alcaraz',  'Španielsko',  1, '2003-05-05', 'Mladý španielsky talent, držiteľ viacerých Grand Slam titulov.', 'alcaraz.jpg'),
('Jannik Sinner',   'Taliansko',   2, '2001-08-16', 'Taliansky tenista, jedna z najväčších hviezd súčasnosti.', 'sinner.jpg'),
('Novak Djokovic',  'Srbsko',      3, '1987-05-22', 'Srbský šampión, držiteľ rekordného počtu Grand Slam titulov.', 'djokovic.jpg'),
('Iga Swiatek',     'Poľsko',      1, '2001-05-31', 'Poľská hráčka, jednotka WTA rebríčka.', NULL),
('Aryna Sabalenka', 'Bielorusko',  2, '1998-05-05', 'Útočná hráčka z Bieloruska, viacnásobná víťazka Grand Slam.', 'sabalenka.jpg');


INSERT INTO tournaments (name, location, surface, start_date, end_date, prize_money, description) VALUES
('Australian Open', 'Melbourne, Austrália',     'Tvrdý povrch',       '2026-01-19', '2026-02-01', 86500000, 'Prvý Grand Slam roka, hráva sa od roku 1905.'),
('Roland Garros',   'Paríž, Francúzsko',        'Antuka',             '2026-05-25', '2026-06-08', 53478000, 'Antukový Grand Slam s najťažším povrchom na svete.'),
('Wimbledon',       'Londýn, Veľká Británia',   'Tráva',              '2026-06-29', '2026-07-12', 50000000, 'Najprestížnejší turnaj na tráve, hráva sa od roku 1877.'),
('US Open',         'New York, USA',            'Tvrdý povrch',       '2026-08-31', '2026-09-13', 75000000, 'Štvrtý a posledný Grand Slam roka.'),
('ATP Finals',      'Turín, Taliansko',         'Tvrdý povrch (hala)', '2026-11-15', '2026-11-22', 15000000, 'Záverečný turnaj sezóny pre osem najlepších hráčov.');

INSERT INTO articles (category_id, author_id, title, slug, perex, content, is_published, published_at) VALUES
(1, 1, 'Sinner dominuje začiatku sezóny 2026', 'sinner-dominuje-zaciatku-sezony-2026',
 'Taliansky jednotka nestratila v úvodnej časti roka ani set.',
 'Jannik Sinner predviedol v prvých mesiacoch roka 2026 fenomenálnu formu. Vyhral všetky turnaje, na ktorých štartoval, a nestratil ani set.',
 1, NOW()),

(3, 1, 'Roland Garros 2026: favoriti a tmavé kone', 'roland-garros-2026-favoriti',
 'Analýza pavúka pred štartom druhého Grand Slamu sezóny.',
 'Roland Garros 2026 sľubuje veľkolepú show. Carlos Alcaraz obhajuje titul, no Sinner aj Djokovic sú tu na to, aby ho zvalili z trónu.',
 1, NOW()),

(2, 1, 'Swiatek vs. Sabalenka: súboj o trón WTA', 'swiatek-vs-sabalenka-suboj-o-tron',
 'Obidve hráčky bojujú o prvé miesto v rebríčku.',
 'Boj o jednotku WTA rebríčka medzi Igou Swiatek a Arynou Sabalenkou je jedným z najzaujímavejších príbehov sezóny.',
 1, NOW());
