
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
    career_high INT,
    titles INT,
    prize_money VARCHAR(15),
    matches_played INT,
    matches_won INT,
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



	-- hesla: 123456789 (hash cez password_hash)
INSERT INTO users (username, email, password_hash, role) VALUES
('admin', 'admin@tenniszone.sk', '$2y$10$se760wsMYbIZo2sEWDCwbecF.Ji1lQ8OGHWqqVCu3MKh/Pz455Zfu', 'admin'),
('fanusik', 'fanusik@tenniszone.sk', '$2y$10$se760wsMYbIZo2sEWDCwbecF.Ji1lQ8OGHWqqVCu3MKh/Pz455Zfu', 'user');

INSERT INTO categories (name, slug, description) VALUES
('ATP',         'atp',         'Mužský profesionálny tenis'),
('WTA',         'wta',         'Ženský profesionálny tenis'),
('Grand Slam',  'grand-slam',  'Štyri najprestížnejšie turnaje sezóny'),
('Davis Cup',   'davis-cup',   'Tímová súťaž národných reprezentácií');

INSERT INTO players
(name, country, ranking, birth_date, bio, image, career_high, titles, prize_money, matches_played, matches_won)
VALUES
('Carlos Alcaraz', 'Španielsko', 1, '2003-05-05',
 'Mladý španielsky talent, držiteľ viacerých Grand Slam titulov.',
 'alcaraz.jpg', 1, 18, '$45M', 350, 285),

('Jannik Sinner', 'Taliansko', 2, '2001-08-16',
 'Taliansky tenista, jedna z najväčších hviezd súčasnosti.',
 'sinner.jpg', 1, 22, '$40M', 420, 330),

('Novak Djokovic', 'Srbsko', 3, '1987-05-22',
 'Srbský šampión, držiteľ rekordného počtu Grand Slam titulov.',
 'djokovic.jpg', 1, 99, '$185M', 1420, 1140),

('Iga Swiatek', 'Poľsko', 1, '2001-05-31',
 'Poľská hráčka, jednotka WTA rebríčka.',
 'swiatek.jpg', 1, 24, '$38M', 420, 350),

('Aryna Sabalenka', 'Bielorusko', 2, '1998-05-05',
 'Útočná hráčka z Bieloruska, viacnásobná víťazka Grand Slam.',
 'sabalenka.jpg', 1, 20, '$33M', 520, 385),

('Alexander Zverev', 'Nemecko', 3, '1997-04-20',
 'Nemecký tenista, olympijský víťaz.',
 NULL, 2, 24, '$45M', 640, 445),

('Daniil Medvedev', 'Rusko', 4, '1996-02-11',
 'Bývalá svetová jednotka.',
 NULL, 1, 20, '$42M', 580, 400),

('Taylor Fritz', 'USA', 5, '1997-10-28',
 'Najlepší americký tenista súčasnosti.',
 NULL, 4, 11, '$22M', 450, 300),

('Casper Ruud', 'Nórsko', 6, '1998-12-22',
 'Špecialista na antuku.',
 'ruud.jpg', 2, 13, '$25M', 450, 300),

('Andrey Rublev', 'Rusko', 7, '1997-10-20',
 'Agresívny hráč základnej čiary.',
 'rublev.jpg', 5, 17, '$24M', 540, 355),

('Stefanos Tsitsipas', 'Grécko', 8, '1998-08-12',
 'Finalista Grand Slam turnajov.',
 'tsitsipas.jpg', 3, 12, '$37M', 600, 410),

('Holger Rune', 'Dánsko', 9, '2003-04-29',
 'Jeden z najväčších talentov novej generácie.',
 NULL, 4, 5, '$13M', 300, 185),

('Coco Gauff', 'USA', 3, '2004-03-13',
 'Americká Grand Slam šampiónka.',
 NULL, 2, 11, '$26M', 400, 305),

('Elena Rybakina', 'Kazachstan', 4, '1999-06-17',
 'Víťazka Wimbledonu.',
 NULL, 3, 10, '$22M', 370, 265),

('Jessica Pegula', 'USA', 5, '1994-02-24',
 'Stabilná členka svetovej špičky.',
 NULL, 3, 8, '$20M', 450, 300),

('Jasmine Paolini', 'Taliansko', 6, '1996-01-04',
 'Finalistka Roland Garros a Wimbledonu.',
 NULL, 4, 4, '$11M', 350, 210),

('Qinwen Zheng', 'Čína', 7, '2002-10-08',
 'Najväčšia čínska hviezda novej generácie.',
 NULL, 5, 6, '$14M', 270, 185),

('Felix Auger-Aliassime', 'Kanada', 8, '2000-08-08',
 'Kanadský tenista s veľkým potenciálom.',
 NULL, 6, 5, '$20M', 440, 280);

INSERT INTO tournaments
(name, location, surface, start_date, end_date, prize_money, description, image)
VALUES
('Indian Wells Masters', 'Indian Wells, USA', 'Tvrdý povrch',
 '2026-03-09', '2026-03-22', 9500000,
 'Jeden z najväčších turnajov mimo Grand Slamov, prezývaný aj piaty Grand Slam. Hrá sa na púšti v Kalifornii.',
 'indian-wells.jpg'),

('Miami Open', 'Miami, USA', 'Tvrdý povrch',
 '2026-03-24', '2026-04-05', 9000000,
 'Prestížny americký Masters 1000 turnaj, ktorý uzatvára takzvaný Sunshine Double spolu s Indian Wells.',
 'miami-open.jpg'),

('Monte-Carlo Masters', 'Monako', 'Antuka',
 '2026-04-12', '2026-04-19', 6000000,
 'Úvodný antukový Masters sezóny v malebnom prostredí Monackého kniežatstva.',
 'monte-carlo.jpg'),

('Madrid Open', 'Madrid, Španielsko', 'Antuka',
 '2026-04-27', '2026-05-10', 8500000,
 'Antukový Masters 1000 vo vysokej nadmorskej výške, kde lopta lieta rýchlejšie než inde.',
 'madrid-open.jpg'),

('Italian Open', 'Rím, Taliansko', 'Antuka',
 '2026-05-11', '2026-05-24', 8500000,
 'Tradičný antukový turnaj v Ríme, posledná veľká generálka pred Roland Garros.',
 'italian-open.jpg'),

('Canadian Open', 'Toronto, Kanada', 'Tvrdý povrch',
 '2026-08-03', '2026-08-09', 7000000,
 'Severoamerický Masters na tvrdom povrchu, ktorý sa strieda medzi Torontom a Montrealom.',
 'canadian-open.jpg'),

('Cincinnati Open', 'Cincinnati, USA', 'Tvrdý povrch',
 '2026-08-10', '2026-08-17', 7500000,
 'Dôležitá príprava na US Open, jeden z najstarších turnajov sveta.',
 'cincinnati-open.jpg'),

('Shanghai Masters', 'Šanghaj, Čína', 'Tvrdý povrch',
 '2026-10-04', '2026-10-15', 9200000,
 'Najväčší ázijský Masters 1000 turnaj, vrchol jesennej časti sezóny.',
 'shanghai-masters.jpg'),

('Paris Masters', 'Paríž, Francúzsko', 'Tvrdý povrch (hala)',
 '2026-10-26', '2026-11-01', 6000000,
 'Posledný Masters 1000 sezóny, hrá sa v hale tesne pred záverečným turnajom majstrov.',
 'paris-masters.jpg');

INSERT INTO articles
(category_id, author_id, title, slug, perex, content, image, is_published, published_at)
VALUES

(1, 1,
 'Súboj generácií: Alcaraz a Sinner prepisujú dejiny tenisu',
 'suboj-generacii-alcaraz-sinner',
 'Dvaja hráči narodení v novom tisícročí ovládli vrchol mužského tenisu a ich vzájomné súboje sa stali najsledovanejšími zápasmi celého okruhu.',
 'Carlos Alcaraz a Jannik Sinner predstavujú novú éru mužského tenisu. Po rokoch, počas ktorých dominovala takzvaná veľká trojka v zložení Federer, Nadal a Djokovič, sa na vrchole rebríčka usadili dvaja hráči narodení v novom tisícročí. Ich vzájomné súboje sa rýchlo stali najsledovanejšími zápasmi celého okruhu a fanúšikovia v nich vidia predzvesť ďalšieho veľkého obdobia tenisu.
 
Alcaraz je hráč s mimoriadnou všestrannosťou. Dokáže zahrať silný úder z oboch strán, vyniká pri sieti a jeho skrátené údery patria k najlepším v histórii. Jeho hra pôsobí explozívne a divácky atraktívne, pretože sa nebojí riskovať ani v najdôležitejších momentoch zápasu. Práve táto odvaha z neho robí jedného z najobľúbenejších hráčov súčasnosti.
 
Sinner naopak stavia svoju hru na neuveriteľnej presnosti a vyrovnanosti. Jeho údery zo základnej čiary patria k najtvrdším a zároveň najpresnejším na celom okruhu. Tam, kde Alcaraz hľadá kreativitu a prekvapenie, Sinner spolieha na disciplínu a takmer chirurgickú presnosť. Pôsobí chladnokrvne aj v momentoch, keď iní hráči podliehajú nervozite.
 
Práve kontrast týchto dvoch štýlov robí ich rivalitu výnimočnou. Každý ich zápas je súbojom dvoch odlišných filozofií tenisu, kde proti sebe stojí inštinkt a poriadok, riziko a istota. Diváci tak nikdy nevedia, čo presne uvidia, a to je presne to, čo robí tenis nádherným.
 
Obaja hráči sú navyše mimoriadne mladí, čo znamená, že ich najlepšie roky možno ešte len prídu. Ak si udržia zdravie a motiváciu, tenis sa môže tešiť na jednu z najväčších rivalít vo svojej histórii, ktorá môže definovať celé nasledujúce desaťročie.',
 'alcaraz.jpg',
 1, NOW()),


(3, 1,
 'Roland Garros: prečo je antuka najťažším povrchom',
 'roland-garros-preco-je-antuka-najtazsia',
 'Pomalá antuka v Paríži preverí nielen údery, ale aj fyzickú a psychickú odolnosť hráčov ako žiadny iný povrch.',
 'Roland Garros je jediný Grand Slam, ktorý sa hrá na antuke, a práve preto je medzi hráčmi povestný svojou náročnosťou. Antuka je najpomalší povrch v profesionálnom tenise, čo znamená, že lopta po dopade stráca rýchlosť a vyskakuje vyššie. Body sa tým predlžujú a hráči musia odohrať oveľa viac úderov, kým získajú jeden jediný fiftín.
 
Pomalý povrch odmeňuje trpezlivosť a fyzickú pripravenosť. Zápasy na antuke patria k najdlhším v celom tenisovom kalendári a nezriedka trvajú aj viac ako štyri hodiny. Hráč preto musí mať nielen kvalitné údery, ale aj výnimočnú vytrvalosť, schopnosť koncentrácie a odolnosť voči únave.
 
Špecifický je aj pohyb po antuke. Hráči sa po nej kĺžu, čo si vyžaduje úplne odlišnú techniku ako pohyb po tvrdom povrchu alebo tráve.
 
Antuka navyše kladie veľký dôraz na taktiku a prácu s rotáciou.
 
Práve preto je víťazstvo v Paríži považované za jeden z najťažších výkonov v celom športe.',
 NULL,
 1, NOW()),


(1, 1,
 'Novak Djokovič a jeho miesto v histórii tenisu',
 'novak-djokovic-miesto-v-historii',
 'Srbský šampión prepísal takmer všetky dôležité rekordy a otvoril debatu o tom, kto je najväčším hráčom všetkých čias.',
 'Novak Djokovič patrí medzi najúspešnejších tenistov v histórii a jeho meno sa pravidelne objavuje v diskusiách o tom, kto je najväčším hráčom všetkých čias.
 
Jeho najväčšou zbraňou je univerzálnosť. Djokovič nemá výrazne slabú stránku.
 
Okrem techniky ho odlišuje aj výnimočná psychická sila.
 
Djokovičova dlhovekosť je ďalším dôvodom jeho úspechu.
 
Bez ohľadu na to, ako dopadne debata o najväčšom hráčovi všetkých čias, je isté, že Djokovič zanechal v tenise nezmazateľnú stopu.',
 'djokovic.jpg',
 1, NOW()),


(3, 1,
 'Wimbledon: tradícia, tráva a biele oblečenie',
 'wimbledon-tradicia-trava-biele-oblecenie',
 'Najstarší a najprestížnejší tenisový turnaj sveta si dodnes zachováva atmosféru, akú nemá žiadne iné podujatie.',
 'Wimbledon je najstarší tenisový turnaj na svete a zároveň jediný Grand Slam, ktorý sa stále hrá na tráve.
 
Tráva je najrýchlejší povrch v tenise.
 
Wimbledon je známy aj svojimi prísnymi pravidlami a tradíciami.
 
K turnaju neodmysliteľne patria aj ďalšie symboly.',
 NULL,
 1, NOW()),


(2, 1,
 'Vzostup ženského tenisu: Swiatek, Sabalenka a nová generácia',
 'vzostup-zenskeho-tenisu-nova-generacia',
 'Ženský okruh prežíva jedno z najvyrovnanejších období svojej histórie.',
 'Ženský tenis prežíva v posledných sezónach mimoriadne zaujímavé obdobie.
 
Na čele tejto generácie stoja Iga Swiatek a Aryna Sabalenka.
 
K špičke sa však rýchlo prebojovali aj mladšie hráčky.
 
Táto rozmanitosť štýlov robí každý veľký turnaj nepredvídateľným.
 
Ženský tenis tak dnes ponúka jednu z najvyrovnanejších súťaží v celom športe.',
 NULL,
 1, NOW()),


(1, 1,
 'Masters 1000: rebrík k svetovej špičke',
 'masters-1000-rebrik-k-svetovej-spicke',
 'Deväť turnajov najvyššej kategórie pod úrovňou Grand Slamov rozhoduje o rebríčku.',
 'Séria turnajov Masters 1000 predstavuje najvyššiu kategóriu mužského tenisu.
 
Názov série je odvodený od počtu bodov, ktoré získava víťaz.
 
Masters 1000 sa hrajú na rôznych povrchoch a v rôznych častiach sveta.
 
Pre hráčov majú tieto turnaje aj psychologický význam.
 
Sledovanie série Masters 1000 počas roka tak ponúka jasný obraz o forme hráčov.',
 NULL,
 1, NOW());