-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS proyecto_abd;

-- Seleccionar la base de datos
USE proyecto_abd;

-- Eliminar las tablas si existen
DROP TABLE IF EXISTS questionary_questions;
DROP TABLE IF EXISTS contents;

-- Crear la tabla 'contents'
CREATE TABLE contents (
    id INT AUTO_INCREMENT PRIMARY KEY,
    number INT,
    name VARCHAR(400),
    description VARCHAR(500)
);

-- Insertar datos en la tabla 'contents'
INSERT INTO contents (number, name,description)
VALUES (1, 'Control Interno en los Sistemas Gestores de Bases de Datos (SGBD)','El "Control Interno en los Sistemas Gestores de Bases de Datos (SGBD)" se refiere a las medidas, políticas y procedimientos diseñados y aplicados para garantizar la seguridad, integridad, confiabilidad y eficiencia de los sistemas que gestionan y almacenan bases de datos en una organización.');

-- Crear la tabla 'questionary_questions'
CREATE TABLE questionary_questions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fk_content_id INT,
    question VARCHAR(200),
    it_process VARCHAR(200),
    number INT,
    FOREIGN KEY (fk_content_id) REFERENCES contents(id)
);

-- Insertar preguntas en la tabla 'questionary_questions'

-- Proceso: Definir un plan estratégico de TI
INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Se ha establecido un proceso para definir y mantener un plan estratégico de TI alineado con los objetivos empresariales?', 'Definir un plan estratégico de TI', 1);

INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Cuál es el plan para garantizar la disponibilidad, integridad y confidencialidad de los datos en las bases de datos?', 'Definir un plan estratégico de TI', 2);

INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Cómo se establecerán y comunicarán los roles y responsabilidades relacionados con la administración de bases de datos en toda la organización?', 'Definir un plan estratégico de TI', 3);

-- Proceso: Definir la arquitectura de la información
INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Se documenta y comunica la arquitectura de la información de manera efectiva para asegurar su alineación con las necesidades empresariales?', 'Definir la arquitectura de la información', 4);

INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Define objetivos de control para asegurar la integridad y seguridad de las bases de datos?', 'Definir la arquitectura de la información', 5);

INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Qué medidas se toman para garantizar la escalabilidad y flexibilidad de la arquitectura de la información en función de las necesidades futuras?', 'Definir la arquitectura de la información', 6);

-- Proceso: Gestionar la adquisición y la implementación
INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Existe un proceso para gestionar la adquisición y la implementación de sistemas de TI, incluyendo la evaluación de proveedores y la validación de soluciones?', 'Gestionar la adquisición y la implementación', 7);

INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Qué estrategias se pueden emplear para minimizar los riesgos durante la implementación de tecnologías críticas para el negocio?', 'Gestionar la adquisición y la implementación', 8);

INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Qué estrategias se pueden emplear para minimizar los riesgos durante la implementación de tecnologías críticas para el negocio?', 'Gestionar la adquisición y la implementación', 9);

-- Proceso: Gestionar cambios 
INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Se siguen procedimientos formales para solicitar, evaluar y aprobar cambios en los sistemas de TI, asegurando la minimización de riesgos?', 'Gestionar cambios', 10);

INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Sugiere prácticas y controles para garantizar la disponibilidad de la información en las bases de datos?', 'Gestionar cambios', 11);

INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Se enfoca en minimizar los riesgos y los impactos negativos asociados con cambios no planificados en los sistemas de información y en el entorno tecnológico?','Gestionar operaciones', 12);

-- Proceso: Gestionar operaciones
INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Se cuenta con un plan de continuidad de negocios y se monitorean proactivamente las operaciones de TI para garantizar su disponibilidad?', 'Gestionar operaciones', 13);

INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Cómo se gestionan las actividades de copia de seguridad y recuperación en caso de fallos o pérdida de datos?', 'Gestionar operaciones', 14);

INSERT INTO questionary_questions (fk_content_id, question, it_process, number)
VALUES (1, '¿Qué procedimientos se siguen para planificar y ejecutar la migración de datos entre diferentes entornos o plataformas?', 'Gestionar operaciones', 15);
