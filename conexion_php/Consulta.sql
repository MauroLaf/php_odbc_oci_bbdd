SELECT *
INTO OUTFILE 'C:\\consultas_tablas_externas\\notas.csv'
FIELDS TERMINATED BY ','
ENCLOSED BY '"'
LINES TERMINATED BY '\n'
FROM notas;

