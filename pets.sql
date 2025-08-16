CREATE TABLE pets (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    breed VARCHAR(100),
    age INT,
    sex VARCHAR(10),
    size VARCHAR(20),
    vaccinated BOOLEAN,
    neutered BOOLEAN,
    location VARCHAR(255),
    description TEXT,
    features TEXT,
    image_path VARCHAR(255)
);
