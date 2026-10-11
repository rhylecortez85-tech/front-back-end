-- Run once in phpMyAdmin (SQL tab) on your existing database
USE pawpathrole;
ALTER TABLE pets
  MODIFY species ENUM('cat','dog','rabbit','other') NOT NULL,
  ADD COLUMN size ENUM('small','medium','large') NOT NULL DEFAULT 'medium' AFTER species,
  ADD COLUMN age_years DECIMAL(3,1) NOT NULL DEFAULT 1 AFTER size;
UPDATE pets SET age_years=2, size='small' WHERE name='Milo';
UPDATE pets SET age_years=3, size='medium', name='Koda' WHERE name IN ('Kodai','Koda');
INSERT INTO pets (name,species,size,age_years,age,gender,story,image) VALUES
('Suzzy','cat','small',3,'3 years old','Female','Suzzy is a lovable cat waiting for a forever home. Add the background story here.','suzzy.jpg'),
('Bebang','cat','small',2,'2 years old','Female','Bebang is a lovable cat waiting for a forever home. Add the background story here.','bebang.jpg'),
('Goldy','dog','large',4,'4 years old','Male','Goldy is a lovable dog waiting for a forever home. Add the background story here.','goldy.jpg'),
('Toby','dog','medium',5,'5 years old','Male','Toby is a lovable dog waiting for a forever home. Add the background story here.','toby.jpg'),
('Bori','rabbit','small',1,'1 years old','Female','Bori is a lovable rabbit waiting for a forever home. Add the background story here.','bori.jpg'),
('June','rabbit','small',1,'1 years old','Female','June is a lovable rabbit waiting for a forever home. Add the background story here.','june.jpg');
