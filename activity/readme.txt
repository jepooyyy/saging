CREATE TABLE bird_families (
    id INT AUTO_INCREMENT PRIMARY KEY,
    family_name VARCHAR(255) NOT NULL,
    image_url VARCHAR(255), -- Image for the bird family
    description TEXT -- Description of the family
);

CREATE TABLE bird_genera (
    id INT AUTO_INCREMENT PRIMARY KEY,
    family_id INT,
    genus_name VARCHAR(255) NOT NULL,
    image_url VARCHAR(255), -- Image for the genus
    description TEXT, -- Description of the genus
    FOREIGN KEY (family_id) REFERENCES bird_families(id) ON DELETE CASCADE
);

CREATE TABLE bird_species (
    id INT AUTO_INCREMENT PRIMARY KEY,
    genus_id INT,
    species_name VARCHAR(255) NOT NULL,
    iucn_status ENUM('Least Concern', 'Near Threatened', 'Vulnerable', 'Endangered', 'Critically Endangered', 'Extinct'),
    image_url VARCHAR(255), -- Image for the species
    description TEXT, -- Description of the species
    FOREIGN KEY (genus_id) REFERENCES bird_genera(id) ON DELETE CASCADE
);

CREATE TABLE bird_subspecies (
    id INT AUTO_INCREMENT PRIMARY KEY,
    species_id INT,
    subspecies_name VARCHAR(255) NOT NULL,
    image_url VARCHAR(255), -- Image for the subspecies
    description TEXT, -- Description of the subspecies
    FOREIGN KEY (species_id) REFERENCES bird_species(id) ON DELETE CASCADE
);

 this is the steps to add bird in the database and you identify if it is in iucn 



------sample for inserting description and images----
INSERT INTO bird_families (family_name, image_url, description) 
VALUES ('Accipitridae', 'images/birds/accipitridae.jpg', 'A family of birds of prey, including eagles, hawks, and kites.');

INSERT INTO bird_genera (family_id, genus_name, image_url, description) 
VALUES (1, 'Haliaeetus', 'images/birds/haliaeetus.jpg', 'A genus of large sea eagles.');

INSERT INTO bird_species (genus_id, species_name, iucn_status, image_url, description) 
VALUES (1, 'Bald Eagle', 'Least Concern', 'images/birds/bald_eagle.jpg', 'A bird of prey found in North America, known for its white head and yellow beak.');

INSERT INTO bird_subspecies (species_id, subspecies_name, image_url, description) 
VALUES (1, 'Southern Bald Eagle', 'images/birds/southern_bald_eagle.jpg', 'A subspecies of the Bald Eagle found in the southern United States.');
