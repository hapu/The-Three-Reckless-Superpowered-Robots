
-- Empleados

INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('00001', 'Sophia Smith', '00000001');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('00010', 'Emma Johnson', '00000002');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('00011', 'Isabella Williams', '00000003');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('00100', 'Jacob Brown', '00000004');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('00101', 'Mason Jones', '00000005');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('00110', 'Ethan Miller', '00000006');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('00111', 'Noah Davis', '00000007');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('01000', 'Olivia Garcia', '00000008');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('01001', 'William Rodriguez', '00000009');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('01010', 'Liam Wilson', '00000010');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('01011', 'Jayden Martinez', '00000011');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('01100', 'Michael Anderson', '00000012');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('01101', 'Ava Taylor', '00000013');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('01110', 'Alexander Thomas', '00000014');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('01111', 'Aiden Hernandez', '00000015');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('10000', 'Daniel Moore', '00000000');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('10001', 'Matthew Martin', '00000000');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('10010', 'Elijah Jackson', '00000000');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('10011', 'Emily Thompson', '00000000');
INSERT INTO Empleado (emp_id,emp_nombre,emp_puesto) VALUES ('10100', 'James White', '00000000');

-- Puestos

INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000000', 'Temporal');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000001', 'Puesto 1');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000002', 'Puesto 2');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000003', 'Puesto 3');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000004', 'Puesto 4');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000005', 'Puesto 5');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000006', 'Puesto 6');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000007', 'Puesto 7');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000008', 'Puesto 8');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000009', 'Puesto 9');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000010', 'Puesto 10');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000011', 'Puesto 11');
INSERT INTO Puesto (pst_id, pst_nombre) VALUES ('00000012', 'Puesto 12');


-- Capacidades

INSERT INTO Capacidad(cap_puesto,cap_empleado)VALUES('00000001','00001');
INSERT INTO Capacidad(cap_puesto,cap_empleado)VALUES('00000002','00010');
INSERT INTO Capacidad(cap_puesto,cap_empleado)VALUES('00000003','00011');
INSERT INTO Capacidad(cap_puesto,cap_empleado)VALUES('00000004','00100');
INSERT INTO Capacidad(cap_puesto,cap_empleado)VALUES('00000005','00101');
INSERT INTO Capacidad(cap_puesto,cap_empleado)VALUES('00000006','00110');
INSERT INTO Capacidad(cap_puesto,cap_empleado)VALUES('00000007','00111');
INSERT INTO Capacidad(cap_puesto,cap_empleado)VALUES('00000008','01000');

INSERT INTO Capacidad(cap_puesto,cap_empleado)VALUES('00000003','00111');
INSERT INTO Capacidad(cap_puesto,cap_empleado)VALUES('00000007','10000');

INSERT INTO Usuario(usu_nombre,usu_password,usu_empleado)VALUES('hapu','password','10100');

INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-07','2014-01-14','Vacaciones','00001',1);
INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-07','2014-01-14','Vacaciones','00010',1);
INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-07','2014-01-14','Vacaciones','00011',1);
INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-07','2014-01-14','Vacaciones','00100',1);
INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-07','2014-01-14','Vacaciones','00101',1);
INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-07','2014-01-14','Vacaciones','00110',1);

INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-17','2014-01-24','Vacaciones','00001',1);
INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-17','2014-01-24','Vacaciones','00010',1);
INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-17','2014-01-24','Vacaciones','00011',1);

INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-17','2014-01-24','Vacaciones','01100',1);
INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-17','2014-01-24','Vacaciones','01101',1);
INSERT INTO Incidencia(inci_inicio,inci_fin,inci_concepto,inci_empleado,inci_usuario)VALUES('2014-01-17','2014-01-24','Vacaciones','01110',1);