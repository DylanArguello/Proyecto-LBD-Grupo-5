/*Tabla de Espacialidad*/
CREATE TABLE ESPECIALIDAD (
    ID_ESPECIALIDAD NUMBER PRIMARY KEY,
    NOMBRE VARCHAR2(100) NOT NULL
);


/*Tabla de Doctor*/

CREATE TABLE DOCTOR (
    ID_DOCTOR NUMBER PRIMARY KEY,
    NOMBRE VARCHAR2(100) NOT NULL,
    TELEFONO VARCHAR2(20),
    ID_ESPECIALIDAD NUMBER,
    FOREIGN KEY (ID_ESPECIALIDAD) REFERENCES ESPECIALIDAD(ID_ESPECIALIDAD)
);


/*Tabla de Paciente*/
CREATE TABLE PACIENTE (
    ID_PACIENTE NUMBER PRIMARY KEY,
    NOMBRE VARCHAR2(100) NOT NULL,
    EMAIL VARCHAR2(100) UNIQUE,
    TELEFONO VARCHAR2(20),
    DIRECCION VARCHAR2(255)
);


/*Tabla de Disponibilidad*/
CREATE TABLE DISPONIBILIDAD (
    ID_DISPONIBILIDAD NUMBER PRIMARY KEY,
    ID_DOCTOR NUMBER,
    DIA_SEMANA VARCHAR2(10),
    HORA_INICIO DATE,
    HORA_FIN DATE,
    FOREIGN KEY (ID_DOCTOR) REFERENCES DOCTOR(ID_DOCTOR)
);



/*Tabla de Cita*/
CREATE TABLE CITA (
    ID_CITA NUMBER PRIMARY KEY,
    ID_PACIENTE NUMBER,
    ID_DOCTOR NUMBER,
    FECHA DATE NOT NULL,
    HORA DATE NOT NULL,
    ESTADO VARCHAR2(20), -- 'AGENDADA', 'CONFIRMADA', 'CANCELADA', etc.
    FOREIGN KEY (ID_PACIENTE) REFERENCES PACIENTE(ID_PACIENTE),
    FOREIGN KEY (ID_DOCTOR) REFERENCES DOCTOR(ID_DOCTOR)
);



-- AGENDAR CITA
INSERT INTO CITA (ID_CITA, ID_PACIENTE, ID_DOCTOR, FECHA, HORA, ESTADO)
VALUES (:ID_CITA, :ID_PACIENTE, :ID_DOCTOR, :FECHA, :HORA, :ESTADO);


/*Tabla de Historial Medico */
CREATE TABLE HISTORIAL_MEDICO (
    ID_HISTORIAL NUMBER PRIMARY KEY,
    ID_PACIENTE NUMBER,
    ID_CITA NUMBER,
    DIAGNOSTICO VARCHAR2(500),
    TRATAMIENTO VARCHAR2(500),
    FOREIGN KEY (ID_PACIENTE) REFERENCES PACIENTE(ID_PACIENTE),
    FOREIGN KEY (ID_CITA) REFERENCES CITA(ID_CITA)
);


/*Tabla de Pago */
CREATE TABLE PAGO (
    ID_PAGO NUMBER PRIMARY KEY,
    ID_CITA NUMBER,
    MONTO NUMBER(10, 2),
    FECHA DATE,
    METODO_PAGO VARCHAR2(50),
    FOREIGN KEY (ID_CITA) REFERENCES CITA(ID_CITA)
);


/*Tabla de Usuario*/
CREATE TABLE USUARIO (
    ID_USUARIO NUMBER PRIMARY KEY,
    NOMBRE_USUARIO VARCHAR2(50) UNIQUE NOT NULL,
    CONTRASENA VARCHAR2(255) NOT NULL,
    TIPO_USUARIO VARCHAR2(20) -- 'ADMIN', 'PACIENTE', 'DOCTOR'
);

/*Tabla de Recordatorio*/
CREATE TABLE RECORDATORIO (
    ID_RECORDATORIO NUMBER PRIMARY KEY,
    ID_CITA NUMBER,
    MENSAJE VARCHAR2(255),
    FECHA_ENVIO DATE,
    FOREIGN KEY (ID_CITA) REFERENCES CITA(ID_CITA)
);

--------------------------------------------------------------------
-------------------VISTAS DE LA BASE DE DATOS-----------------------
--------------------------------------------------------------------

--1. Vista Agenda de citas

CREATE VIEW V_CITAS AS 
SELECT
    C.ID_CITA,
    P.NOMBRE AS "NOMBRE PACIENTE",
    D.NOMBRE AS "NOMBRE DOCTOR",
    E.NOMBRE AS ESPECIALIDAD,
    C.FECHA,
    C.HORA,
    C.ESTADO
FROM CITA C
INNER JOIN PACIENTE P ON C.ID_PACIENTE = P.ID_PACIENTE
INNER JOIN DOCTOR D ON C.ID_DOCTOR = D.ID_DOCTOR
LEFT JOIN ESPECIALIDAD E ON D.ID_ESPECIALIDAD = E.ID_ESPECIALIDAD
ORDER BY P.NOMBRE, C.FECHA, C.HORA;

-- 2. Vista Historial de Paciente

CREATE VIEW V_HISTORIAL AS 
SELECT
    H.ID_HISTORIAL,
    P.NOMBRE AS PACIENTE,
    C.FECHA,
    D.NOMBRE AS MEDICO,
    H.DIAGNOSTICO,
    H.TRATAMIENTO
FROM HISTORIAL_MEDICO H
INNER JOIN PACIENTE P ON H.ID_PACIENTE = P.ID_PACIENTE
INNER JOIN CITA C ON H.ID_CITA = C.ID_CITA
INNER JOIN DOCTOR D ON C.ID_DOCTOR = D.ID_DOCTOR;

-- 3. Vista Pagos Detallados

CREATE VIEW V_PAGOS AS 
SELECT
    PAG.ID_PAGO,
    P.NOMBRE AS PACIENTE,
    PAG.MONTO,
    PAG.FECHA,
    PAG.METODO_PAGO
FROM PAGO PAG
INNER JOIN CITA C ON PAG.ID_CITA = C.ID_CITA
INNER JOIN PACIENTE P ON C.ID_PACIENTE = P.ID_PACIENTE;

-- 4. Vista Disponibilidad de Doctores

CREATE VIEW V_DISPONIBILIDAD_DOCTOR AS
SELECT
    DISP.ID_DISPONIBILIDAD,
    D.NOMBRE AS DOCTOR,
    E.NOMBRE AS ESPECIALIDAD,
    DISP.DIA_SEMANA,
    TO_CHAR(DISP.HORA_INICIO, 'HH24:MI') AS HORA_INICIO,
    TO_CHAR(DISP.HORA_FIN, 'HH24:MI') AS HORA_FIN
FROM DISPONIBILIDAD DISP
INNER JOIN DOCTOR D ON DISP.ID_DOCTOR = D.ID_DOCTOR
LEFT JOIN ESPECIALIDAD E ON D.ID_ESPECIALIDAD = E.ID_ESPECIALIDAD;

-- 5. Vista Recordatorios de Citas
CREATE VIEW V_RECORDATORIOS_CITAS AS
SELECT
    R.ID_RECORDATORIO,
    C.ID_CITA,
    P.NOMBRE AS PACIENTE,
    C.FECHA,
    C.HORA,
    R.MENSAJE,
    R.FECHA_ENVIO
FROM RECORDATORIO R
INNER JOIN CITA C ON R.ID_CITA = C.ID_CITA
INNER JOIN PACIENTE P ON C.ID_PACIENTE = P.ID_PACIENTE
INNER JOIN DOCTOR D ON C.ID_DOCTOR = D.ID_DOCTOR
LEFT JOIN ESPECIALIDAD E ON D.ID_ESPECIALIDAD = E.ID_ESPECIALIDAD
ORDER BY R.FECHA_ENVIO DESC;


-- 6. Vista de Usuarios
CREATE VIEW V_USUARIOS AS
SELECT
    U.ID_USUARIO,
    U.NOMBRE_USUARIO,
    U.TIPO_USUARIO,
    CASE 
        WHEN U.TIPO_USUARIO = 'PACIENTE' THEN P.NOMBRE
        WHEN U.TIPO_USUARIO = 'DOCTOR' THEN D.NOMBRE
        ELSE NULL
    END AS NOMBRE_PERSONA
FROM USUARIO U
LEFT JOIN PACIENTE P ON U.ID_USUARIO = P.ID_PACIENTE
LEFT JOIN DOCTOR D ON U.ID_USUARIO = D.ID_DOCTOR
WHERE U.TIPO_USUARIO IN ('PACIENTE', 'DOCTOR')
ORDER BY U.NOMBRE_USUARIO;

-- 7. Vista de Especialidades
CREATE VIEW V_ESPECIALIDADES AS
SELECT
    E.ID_ESPECIALIDAD,
    E.NOMBRE AS ESPECIALIDAD,
    COUNT(D.ID_DOCTOR) AS NUM_DOCTORES
FROM ESPECIALIDAD E
LEFT JOIN DOCTOR D ON E.ID_ESPECIALIDAD = D.ID_ESPECIALIDAD
GROUP BY E.ID_ESPECIALIDAD, E.NOMBRE
ORDER BY E.NOMBRE;

-- 8. Vista de Doctores con Especialidad
CREATE VIEW V_DOCTORES_ESPECIALIDAD AS
SELECT
    D.ID_DOCTOR,
    D.NOMBRE AS DOCTOR,
    E.NOMBRE AS ESPECIALIDAD,
    D.TELEFONO 
FROM DOCTOR D
LEFT JOIN ESPECIALIDAD E ON D.ID_ESPECIALIDAD = E.ID_ESPECIALIDAD
ORDER BY D.NOMBRE;

-- 9. Vista de Citas por Doctor    
CREATE VIEW V_CITAS_POR_DOCTOR AS
SELECT
    D.ID_DOCTOR,
    D.NOMBRE AS DOCTOR,
    COUNT(C.ID_CITA) AS NUM_CITAS,
    SUM(CASE WHEN C.ESTADO = 'CONFIRMADA' THEN 1 ELSE 0 END) AS CITAS_CONFIRMADAS,
    SUM(CASE WHEN C.ESTADO = 'CANCELADA' THEN 1 ELSE 0 END) AS CITAS_CANCELADAS
FROM DOCTOR D
LEFT JOIN CITA C ON D.ID_DOCTOR = C.ID_DOCTOR
GROUP BY D.ID_DOCTOR, D.NOMBRE
ORDER BY D.NOMBRE;

-- 10. Vista de Pagos por Paciente

CREATE OR REPLACE VIEW V_PAGOS_PACIENTE AS
SELECT
    P.ID_PACIENTE,
    P.NOMBRE AS PACIENTE,
    COUNT(PAG.ID_PAGO) AS NUM_PAGOS,
    COALESCE(SUM(PAG.MONTO), 0) AS TOTAL_PAGADO
FROM PACIENTE P
LEFT JOIN CITA C ON P.ID_PACIENTE = C.ID_PACIENTE
LEFT JOIN PAGO PAG ON C.ID_CITA = PAG.ID_CITA
GROUP BY P.ID_PACIENTE, P.NOMBRE
ORDER BY P.NOMBRE;



/* 
DESCRIPCIÓN: Este paquete maneja todas las operaciones CRUD y consultas relacionadas con la tabla DOCTOR.
INCLUYE:
  - Crear, actualizar y eliminar doctores
  - Listar doctores
  - Listar doctores por especialidad
*/

CREATE OR REPLACE PACKAGE pkg_cita AS
  
    PROCEDURE sp_crear_cita (
        p_id_cita     IN CITA.ID_CITA%TYPE,
        p_id_paciente IN CITA.ID_PACIENTE%TYPE,
        p_id_doctor   IN CITA.ID_DOCTOR%TYPE,
        p_fecha       IN CITA.FECHA%TYPE,
        p_hora        IN CITA.HORA%TYPE,
        p_estado      IN CITA.ESTADO%TYPE
    );

    PROCEDURE sp_actualizar_cita (
        p_id_cita     IN CITA.ID_CITA%TYPE,
        p_id_paciente IN CITA.ID_PACIENTE%TYPE,
        p_id_doctor   IN CITA.ID_DOCTOR%TYPE,
        p_fecha       IN CITA.FECHA%TYPE,
        p_hora        IN CITA.HORA%TYPE,
        p_estado      IN CITA.ESTADO%TYPE
    );

    PROCEDURE sp_eliminar_cita (
        p_id_cita IN CITA.ID_CITA%TYPE
    );

    PROCEDURE sp_listar_citas (
        p_cursor OUT SYS_REFCURSOR
    );

    PROCEDURE sp_listar_citas_paciente (
        p_id_paciente IN CITA.ID_PACIENTE%TYPE,
        p_cursor OUT SYS_REFCURSOR
    );
END pkg_cita;

CREATE OR REPLACE PACKAGE BODY pkg_cita AS
    PROCEDURE sp_crear_cita (
        p_id_cita     IN CITA.ID_CITA%TYPE,
        p_id_paciente IN CITA.ID_PACIENTE%TYPE,
        p_id_doctor   IN CITA.ID_DOCTOR%TYPE,
        p_fecha       IN CITA.FECHA%TYPE,
        p_hora        IN CITA.HORA%TYPE,
        p_estado      IN CITA.ESTADO%TYPE
    ) AS
    BEGIN
        INSERT INTO CITA (ID_CITA, ID_PACIENTE, ID_DOCTOR, FECHA, HORA, ESTADO)
        VALUES (p_id_cita, p_id_paciente, p_id_doctor, p_fecha, p_hora, p_estado);
        COMMIT;
    END;

    PROCEDURE sp_actualizar_cita (
        p_id_cita     IN CITA.ID_CITA%TYPE,
        p_id_paciente IN CITA.ID_PACIENTE%TYPE,
        p_id_doctor   IN CITA.ID_DOCTOR%TYPE,
        p_fecha       IN CITA.FECHA%TYPE,
        p_hora        IN CITA.HORA%TYPE,
        p_estado      IN CITA.ESTADO%TYPE
    ) AS
    BEGIN
        UPDATE CITA
        SET ID_PACIENTE = p_id_paciente,
            ID_DOCTOR   = p_id_doctor,
            FECHA       = p_fecha,
            HORA        = p_hora,
            ESTADO      = p_estado
        WHERE ID_CITA   = p_id_cita;
        COMMIT;
    END;

    PROCEDURE sp_eliminar_cita (
        p_id_cita IN CITA.ID_CITA%TYPE
    ) AS
    BEGIN
        DELETE FROM CITA WHERE ID_CITA = p_id_cita;
        COMMIT;
    END;

    PROCEDURE sp_listar_citas (
        p_cursor OUT SYS_REFCURSOR
    ) AS
    BEGIN
        OPEN p_cursor FOR
            SELECT * FROM CITA ORDER BY FECHA, HORA;
    END;

    PROCEDURE sp_listar_citas_paciente (
        p_id_paciente IN CITA.ID_PACIENTE%TYPE,
        p_cursor OUT SYS_REFCURSOR
    ) AS
    BEGIN
        OPEN p_cursor FOR
            SELECT * FROM CITA
             WHERE ID_PACIENTE = p_id_paciente
             ORDER BY FECHA, HORA;
    END;
END pkg_cita;



/* 
DESCRIPCIÓN: Este paquete maneja todas las operaciones CRUD y consultas relacionadas con la tabla DOCTOR.
INCLUYE:
  - Crear, actualizar y eliminar doctores
  - Listar todos los doctores
  - Listar doctores por especialidad
*/
CREATE OR REPLACE PACKAGE pkg_doctor AS
    PROCEDURE sp_crear_doctor (
        p_id            IN DOCTOR.ID_DOCTOR%TYPE,
        p_nombre        IN DOCTOR.NOMBRE%TYPE,
        p_telefono      IN DOCTOR.TELEFONO%TYPE,
        p_especialidad  IN DOCTOR.ID_ESPECIALIDAD%TYPE
    );

    PROCEDURE sp_actualizar_doctor (
        p_id            IN DOCTOR.ID_DOCTOR%TYPE,
        p_nombre        IN DOCTOR.NOMBRE%TYPE,
        p_telefono      IN DOCTOR.TELEFONO%TYPE,
        p_especialidad  IN DOCTOR.ID_ESPECIALIDAD%TYPE
    );

    PROCEDURE sp_eliminar_doctor (
        p_id IN DOCTOR.ID_DOCTOR%TYPE
    );

    PROCEDURE sp_listar_doctores (
        p_cursor OUT SYS_REFCURSOR
    );

    PROCEDURE sp_listar_doctores_especialidad (
        p_id_especialidad IN DOCTOR.ID_ESPECIALIDAD%TYPE,
        p_cursor OUT SYS_REFCURSOR
    );
END pkg_doctor;



CREATE OR REPLACE PACKAGE BODY pkg_doctor AS

    PROCEDURE sp_crear_doctor (
        p_id            IN DOCTOR.ID_DOCTOR%TYPE,
        p_nombre        IN DOCTOR.NOMBRE%TYPE,
        p_telefono      IN DOCTOR.TELEFONO%TYPE,
        p_especialidad  IN DOCTOR.ID_ESPECIALIDAD%TYPE
    ) AS
    BEGIN
        INSERT INTO DOCTOR (ID_DOCTOR, NOMBRE, TELEFONO, ID_ESPECIALIDAD)
        VALUES (p_id, p_nombre, p_telefono, p_especialidad);
        COMMIT;
    END sp_crear_doctor;

    PROCEDURE sp_actualizar_doctor (
        p_id            IN DOCTOR.ID_DOCTOR%TYPE,
        p_nombre        IN DOCTOR.NOMBRE%TYPE,
        p_telefono      IN DOCTOR.TELEFONO%TYPE,
        p_especialidad  IN DOCTOR.ID_ESPECIALIDAD%TYPE
    ) AS
    BEGIN
        UPDATE DOCTOR
           SET NOMBRE = p_nombre,
               TELEFONO = p_telefono,
               ID_ESPECIALIDAD = p_especialidad
         WHERE ID_DOCTOR = p_id;
        COMMIT;
    END sp_actualizar_doctor;

    PROCEDURE sp_eliminar_doctor (
        p_id IN DOCTOR.ID_DOCTOR%TYPE
    ) AS
    BEGIN
        DELETE FROM DOCTOR WHERE ID_DOCTOR = p_id;
        COMMIT;
    END sp_eliminar_doctor;
    
    PROCEDURE sp_listar_doctores (
    p_cursor OUT SYS_REFCURSOR
    ) AS
    BEGIN
        OPEN p_cursor FOR
            SELECT ID_DOCTOR, NOMBRE, TELEFONO, ID_ESPECIALIDAD
            FROM DOCTOR
            ORDER BY NOMBRE;
    END sp_listar_doctores;


    PROCEDURE sp_listar_doctores_especialidad (
        p_id_especialidad IN DOCTOR.ID_ESPECIALIDAD%TYPE,
        p_cursor OUT SYS_REFCURSOR
    ) AS
    BEGIN
        OPEN p_cursor FOR
            SELECT ID_DOCTOR, NOMBRE, TELEFONO, ID_ESPECIALIDAD
              FROM DOCTOR
             WHERE ID_ESPECIALIDAD = p_id_especialidad
             ORDER BY NOMBRE;
    END sp_listar_doctores_especialidad;

END pkg_doctor;

/* 
DESCRIPCIÓN: Maneja todas las operaciones CRUD y consultas relacionadas con la tabla DISPONIBILIDAD.
INCLUYE:
  - Crear, actualizar y eliminar disponibilidad de los doctores
  - Listar todas las disponibilidades
*/

CREATE OR REPLACE PACKAGE pkg_disponibilidad AS
    PROCEDURE sp_crear_disponibilidad (
        p_id        IN DISPONIBILIDAD.ID_DISPONIBILIDAD%TYPE,
        p_doctor    IN DISPONIBILIDAD.ID_DOCTOR%TYPE,
        p_dia       IN DISPONIBILIDAD.DIA_SEMANA%TYPE,
        p_inicio    IN DISPONIBILIDAD.HORA_INICIO%TYPE,
        p_fin       IN DISPONIBILIDAD.HORA_FIN%TYPE
    );

    PROCEDURE sp_actualizar_disponibilidad (
        p_id        IN DISPONIBILIDAD.ID_DISPONIBILIDAD%TYPE,
        p_doctor    IN DISPONIBILIDAD.ID_DOCTOR%TYPE,
        p_dia       IN DISPONIBILIDAD.DIA_SEMANA%TYPE,
        p_inicio    IN DISPONIBILIDAD.HORA_INICIO%TYPE,
        p_fin       IN DISPONIBILIDAD.HORA_FIN%TYPE
    );

    PROCEDURE sp_eliminar_disponibilidad (
        p_id IN DISPONIBILIDAD.ID_DISPONIBILIDAD%TYPE
    );

    PROCEDURE sp_listar_disponibilidad (
        p_cursor OUT SYS_REFCURSOR
    );
END pkg_disponibilidad;



CREATE OR REPLACE PACKAGE BODY pkg_disponibilidad AS

    PROCEDURE sp_crear_disponibilidad (
        p_id        IN DISPONIBILIDAD.ID_DISPONIBILIDAD%TYPE,
        p_doctor    IN DISPONIBILIDAD.ID_DOCTOR%TYPE,
        p_dia       IN DISPONIBILIDAD.DIA_SEMANA%TYPE,
        p_inicio    IN DISPONIBILIDAD.HORA_INICIO%TYPE,
        p_fin       IN DISPONIBILIDAD.HORA_FIN%TYPE
    ) AS
    BEGIN
        INSERT INTO DISPONIBILIDAD (ID_DISPONIBILIDAD, ID_DOCTOR, DIA_SEMANA, HORA_INICIO, HORA_FIN)
        VALUES (p_id, p_doctor, p_dia, p_inicio, p_fin);
        COMMIT;
    END sp_crear_disponibilidad;

    PROCEDURE sp_actualizar_disponibilidad (
        p_id        IN DISPONIBILIDAD.ID_DISPONIBILIDAD%TYPE,
        p_doctor    IN DISPONIBILIDAD.ID_DOCTOR%TYPE,
        p_dia       IN DISPONIBILIDAD.DIA_SEMANA%TYPE,
        p_inicio    IN DISPONIBILIDAD.HORA_INICIO%TYPE,
        p_fin       IN DISPONIBILIDAD.HORA_FIN%TYPE
    ) AS
    BEGIN
        UPDATE DISPONIBILIDAD
           SET ID_DOCTOR   = p_doctor,
               DIA_SEMANA  = p_dia,
               HORA_INICIO = p_inicio,
               HORA_FIN    = p_fin
         WHERE ID_DISPONIBILIDAD = p_id;
        COMMIT;
    END sp_actualizar_disponibilidad;

    PROCEDURE sp_eliminar_disponibilidad (
        p_id IN DISPONIBILIDAD.ID_DISPONIBILIDAD%TYPE
    ) AS
    BEGIN
        DELETE FROM DISPONIBILIDAD WHERE ID_DISPONIBILIDAD = p_id;
        COMMIT;
    END sp_eliminar_disponibilidad;

    PROCEDURE sp_listar_disponibilidad (
        p_cursor OUT SYS_REFCURSOR
    ) AS
    BEGIN
        OPEN p_cursor FOR
            SELECT ID_DISPONIBILIDAD, ID_DOCTOR, DIA_SEMANA, HORA_INICIO, HORA_FIN
              FROM DISPONIBILIDAD
             ORDER BY DIA_SEMANA, HORA_INICIO;
    END sp_listar_disponibilidad;

END pkg_disponibilidad;

----TRIGGER PARA VALIDAR ESTADO DE CITA
CREATE OR REPLACE TRIGGER trg_validar_estado_cita
BEFORE INSERT OR UPDATE ON CITA
FOR EACH ROW
BEGIN
    IF :NEW.ESTADO NOT IN ('AGENDADA', 'CONFIRMADA', 'CANCELADA') THEN
        RAISE_APPLICATION_ERROR(-20001, 'Estado inválido para la cita.');
    END IF;
END;

----TRIGGER PARA VALIDAR LONGITUD DEL TELEFONO
CREATE OR REPLACE TRIGGER trg_validar_telefono_doctor
BEFORE INSERT OR UPDATE ON DOCTOR
FOR EACH ROW
BEGIN
    IF :NEW.TELEFONO IS NOT NULL AND LENGTH(:NEW.TELEFONO) < 8 THEN
        RAISE_APPLICATION_ERROR(-20020, 'El teléfono debe tener al menos 8 dígitos.');
    END IF;
END;

----TRIGGER PARA VALIDAR HORAS DE DISPONIBILIDAD
CREATE OR REPLACE TRIGGER trg_validar_horas_disponibilidad
BEFORE INSERT OR UPDATE ON DISPONIBILIDAD
FOR EACH ROW
BEGIN
    IF :NEW.HORA_FIN <= :NEW.HORA_INICIO THEN
        RAISE_APPLICATION_ERROR(-20010, 'La hora de fin debe ser mayor que la hora de inicio.');
    END IF;
END;




--obtener todos los pagos

CREATE OR REPLACE PROCEDURE SP_OBTENER_PAGOS(
    p_resultado OUT SYS_REFCURSOR
) AS
BEGIN
    OPEN p_resultado FOR
        SELECT P.ID_PAGO,
               P.ID_CITA,
               PAC.NOMBRE   AS PACIENTE,
               P.MONTO,
               TO_CHAR(P.FECHA,'YYYY-MM-DD') AS FECHA,
               P.METODO_PAGO
          FROM PAGO  P
          JOIN CITA  C   ON P.ID_CITA     = C.ID_CITA
          JOIN PACIENTE PAC ON C.ID_PACIENTE = PAC.ID_PACIENTE
      ORDER BY P.FECHA DESC;
END;

---obtener un pago específico

CREATE OR REPLACE PROCEDURE SP_OBTENER_PAGO_POR_ID(
    p_id_pago   IN  PAGO.ID_PAGO%TYPE,
    p_resultado OUT SYS_REFCURSOR
) AS
BEGIN
    OPEN p_resultado FOR
        SELECT * FROM PAGO WHERE ID_PAGO = p_id_pago;
END;
/

--CRUD

-- Crear pago
CREATE OR REPLACE PROCEDURE SP_CREAR_PAGO(
    p_id_pago      IN PAGO.ID_PAGO%TYPE,
    p_id_cita      IN PAGO.ID_CITA%TYPE,
    p_monto        IN PAGO.MONTO%TYPE,
    p_fecha        IN DATE,
    p_metodo_pago  IN PAGO.METODO_PAGO%TYPE,
    p_estado       OUT VARCHAR2
) AS
BEGIN
    INSERT INTO PAGO (ID_PAGO, ID_CITA, MONTO, FECHA, METODO_PAGO)
    VALUES (p_id_pago, p_id_cita, p_monto, p_fecha, p_metodo_pago);
    p_estado := 'OK';
EXCEPTION
    WHEN OTHERS THEN
        p_estado := 'ERROR: ' || SQLERRM;
END;
/

-- Actualizar pago
CREATE OR REPLACE PROCEDURE SP_ACTUALIZAR_PAGO(
    p_id_pago      IN PAGO.ID_PAGO%TYPE,
    p_monto        IN PAGO.MONTO%TYPE,
    p_fecha        IN DATE,
    p_metodo_pago  IN PAGO.METODO_PAGO%TYPE,
    p_estado       OUT VARCHAR2
) AS
BEGIN
    UPDATE PAGO
       SET MONTO = p_monto,
           FECHA = p_fecha,
           METODO_PAGO = p_metodo_pago
     WHERE ID_PAGO = p_id_pago;

    IF SQL%ROWCOUNT = 0 THEN
        p_estado := 'NO EXISTE EL REGISTRO';
    ELSE
        p_estado := 'OK';
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        p_estado := 'ERROR: ' || SQLERRM;
END;
/

-- Eliminar pago
CREATE OR REPLACE PROCEDURE SP_ELIMINAR_PAGO(
    p_id_pago IN PAGO.ID_PAGO%TYPE,
    p_estado  OUT VARCHAR2
) AS
BEGIN
    DELETE FROM PAGO WHERE ID_PAGO = p_id_pago;
    IF SQL%ROWCOUNT = 0 THEN
        p_estado := 'NO EXISTE EL REGISTRO';
    ELSE
        p_estado := 'OK';
    END IF;
EXCEPTION
    WHEN OTHERS THEN
        p_estado := 'ERROR: ' || SQLERRM;
END;
/


--1 trigger para auditoría

CREATE TABLE AUDITORIA_PAGO (
    ID_AUDITORIA   NUMBER PRIMARY KEY,
    ID_PAGO        NUMBER,
    ACCION         VARCHAR2(50),
    FECHA_ACCION   DATE,
    USUARIO_BD     VARCHAR2(50)
);

CREATE SEQUENCE SEQ_AUDITORIA_PAGO START WITH 1 INCREMENT BY 1;

CREATE OR REPLACE TRIGGER TR_AUDITAR_PAGO
AFTER INSERT ON PAGO
FOR EACH ROW
BEGIN
    INSERT INTO AUDITORIA_PAGO (ID_AUDITORIA, ID_PAGO, ACCION, FECHA_ACCION, USUARIO_BD)
    VALUES (SEQ_AUDITORIA_PAGO.NEXTVAL, :NEW.ID_PAGO, 'INSERT', SYSDATE, USER);
END;
/


--Cursor interno

DECLARE
    CURSOR cur_pagos IS
        SELECT p.id_pago, pac.nombre AS paciente, p.monto, p.metodo_pago
        FROM pago p
        JOIN cita c ON p.id_cita = c.id_cita
        JOIN paciente pac ON c.id_paciente = pac.id_paciente;

    v_id_pago     PAGO.ID_PAGO%TYPE;
    v_paciente    PACIENTE.NOMBRE%TYPE;
    v_monto       PAGO.MONTO%TYPE;
    v_metodo_pago PAGO.METODO_PAGO%TYPE;
BEGIN
    OPEN cur_pagos;
    LOOP
        FETCH cur_pagos INTO v_id_pago, v_paciente, v_monto, v_metodo_pago;
        EXIT WHEN cur_pagos%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE(
            'Pago ID: ' || v_id_pago || 
            ', Paciente: ' || v_paciente ||
            ', Monto: ' || v_monto ||
            ', Método: ' || v_metodo_pago
        );
    END LOOP;
    CLOSE cur_pagos;
END;


-- Procedimiento para insertar un recordatorio
CREATE OR REPLACE PROCEDURE insertar_recordatorio (
    p_id_recordatorio IN RECORDATORIO.ID_RECORDATORIO%TYPE,
    p_id_cita         IN RECORDATORIO.ID_CITA%TYPE,
    p_mensaje         IN RECORDATORIO.MENSAJE%TYPE,
    p_fecha_envio     IN DATE
) AS
BEGIN
    INSERT INTO RECORDATORIO (ID_RECORDATORIO, ID_CITA, MENSAJE, FECHA_ENVIO)
    VALUES (p_id_recordatorio, p_id_cita, p_mensaje, p_fecha_envio);
END;
/

-- Procedimiento para actualizar un recordatorio
CREATE OR REPLACE PROCEDURE actualizar_recordatorio (
    p_id_recordatorio IN RECORDATORIO.ID_RECORDATORIO%TYPE,
    p_id_cita         IN RECORDATORIO.ID_CITA%TYPE,
    p_mensaje         IN RECORDATORIO.MENSAJE%TYPE,
    p_fecha_envio     IN DATE
) AS
BEGIN
    UPDATE RECORDATORIO
    SET ID_CITA = p_id_cita,
        MENSAJE = p_mensaje,
        FECHA_ENVIO = p_fecha_envio
    WHERE ID_RECORDATORIO = p_id_recordatorio;
END;
/

-- Procedimiento para eliminar un recordatorio
CREATE OR REPLACE PROCEDURE eliminar_recordatorio (
    p_id_recordatorio IN RECORDATORIO.ID_RECORDATORIO%TYPE
) AS
BEGIN
    DELETE FROM RECORDATORIO
    WHERE ID_RECORDATORIO = p_id_recordatorio;
END;
/

---trigger recordatorio de audit
CREATE OR REPLACE TRIGGER trg_auditar_recordatorio
AFTER INSERT OR UPDATE OR DELETE ON RECORDATORIO
FOR EACH ROW
BEGIN
    IF INSERTING THEN
        INSERT INTO AUDITORIA_RECORDATORIO (ID_RECORDATORIO, ACCION, FECHA_EVENTO, USUARIO_BD)
        VALUES (:NEW.ID_RECORDATORIO, 'INSERT', SYSDATE, USER);
    ELSIF UPDATING THEN
        INSERT INTO AUDITORIA_RECORDATORIO (ID_RECORDATORIO, ACCION, FECHA_EVENTO, USUARIO_BD)
        VALUES (:NEW.ID_RECORDATORIO, 'UPDATE', SYSDATE, USER);
    ELSIF DELETING THEN
        INSERT INTO AUDITORIA_RECORDATORIO (ID_RECORDATORIO, ACCION, FECHA_EVENTO, USUARIO_BD)
        VALUES (:OLD.ID_RECORDATORIO, 'DELETE', SYSDATE, USER);
    END IF;
END;
/


--Cursor para rrecorrer los recordatorios
DECLARE
    CURSOR cur_recordatorios IS
        SELECT R.ID_RECORDATORIO, P.NOMBRE AS PACIENTE, C.FECHA, C.HORA, R.MENSAJE
        FROM RECORDATORIO R
        JOIN CITA C ON R.ID_CITA = C.ID_CITA
        JOIN PACIENTE P ON C.ID_PACIENTE = P.ID_PACIENTE
        ORDER BY R.FECHA_ENVIO DESC;

    v_id_recordatorio RECORDATORIO.ID_RECORDATORIO%TYPE;
    v_paciente        PACIENTE.NOMBRE%TYPE;
    v_fecha           CITA.FECHA%TYPE;
    v_hora            CITA.HORA%TYPE;
    v_mensaje         RECORDATORIO.MENSAJE%TYPE;
BEGIN
    OPEN cur_recordatorios;
    LOOP
        FETCH cur_recordatorios INTO v_id_recordatorio, v_paciente, v_fecha, v_hora, v_mensaje;
        EXIT WHEN cur_recordatorios%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('Recordatorio ' || v_id_recordatorio || 
                             ': ' || v_paciente || ' - ' || v_fecha || ' ' || v_hora || 
                             ' - ' || v_mensaje);
    END LOOP;
    CLOSE cur_recordatorios;
END;


DECLARE
    CURSOR cur_recordatorios IS
        SELECT R.ID_RECORDATORIO, P.NOMBRE AS PACIENTE, C.FECHA, C.HORA, R.MENSAJE
        FROM RECORDATORIO R
        JOIN CITA C ON R.ID_CITA = C.ID_CITA
        JOIN PACIENTE P ON C.ID_PACIENTE = P.ID_PACIENTE
        ORDER BY R.FECHA_ENVIO DESC;

    v_id_recordatorio RECORDATORIO.ID_RECORDATORIO%TYPE;
    v_paciente        PACIENTE.NOMBRE%TYPE;
    v_fecha           CITA.FECHA%TYPE;
    v_hora            CITA.HORA%TYPE;
    v_mensaje         RECORDATORIO.MENSAJE%TYPE;
BEGIN
    OPEN cur_recordatorios;
    LOOP
        FETCH cur_recordatorios INTO v_id_recordatorio, v_paciente, v_fecha, v_hora, v_mensaje;
        EXIT WHEN cur_recordatorios%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('Recordatorio ' || v_id_recordatorio || 
                             ': ' || v_paciente || ' - ' || v_fecha || ' ' || v_hora || 
                             ' - ' || v_mensaje);
    END LOOP;
    CLOSE cur_recordatorios;
END;


---procedimiento para crear usuario
CREATE OR REPLACE PROCEDURE sp_crear_usuario (
    p_id       IN USUARIO.ID_USUARIO%TYPE,
    p_nombre   IN USUARIO.NOMBRE_USUARIO%TYPE,
    p_clave    IN USUARIO.CONTRASENA%TYPE,
    p_tipo     IN USUARIO.TIPO_USUARIO%TYPE
) AS
BEGIN
    INSERT INTO USUARIO (ID_USUARIO, NOMBRE_USUARIO, CONTRASENA, TIPO_USUARIO)
    VALUES (p_id, p_nombre, p_clave, p_tipo);
    COMMIT;
END;


--para update usuario
CREATE OR REPLACE PROCEDURE sp_actualizar_usuario (
    p_id       IN USUARIO.ID_USUARIO%TYPE,
    p_nombre   IN USUARIO.NOMBRE_USUARIO%TYPE,
    p_clave    IN USUARIO.CONTRASENA%TYPE,
    p_tipo     IN USUARIO.TIPO_USUARIO%TYPE
) AS
BEGIN
    UPDATE USUARIO
       SET NOMBRE_USUARIO = p_nombre,
           CONTRASENA     = p_clave,
           TIPO_USUARIO   = p_tipo
     WHERE ID_USUARIO     = p_id;
    COMMIT;
END;


---para delete usuario
CREATE OR REPLACE PROCEDURE sp_eliminar_usuario (
    p_id IN USUARIO.ID_USUARIO%TYPE
) AS
BEGIN
    DELETE FROM USUARIO
     WHERE ID_USUARIO = p_id;
    COMMIT;
END;


--trigger audit
CREATE OR REPLACE TRIGGER trg_auditoria_usuario
AFTER INSERT OR UPDATE ON USUARIO
FOR EACH ROW
BEGIN
    INSERT INTO AUDITORIA_USUARIO (
        ID_AUDITORIA, ID_USUARIO, ACCION, FECHA_ACCION
    ) VALUES (
        SEQ_AUDITORIA.NEXTVAL,
        :NEW.ID_USUARIO,
        CASE 
            WHEN INSERTING THEN 'INSERT'
            WHEN UPDATING THEN 'UPDATE'
        END,
        SYSDATE
    );
END;


---cursor 
CREATE OR REPLACE PROCEDURE sp_listar_usuarios (
    p_cursor OUT SYS_REFCURSOR
) AS
BEGIN
    OPEN p_cursor FOR
        SELECT ID_USUARIO, NOMBRE_USUARIO, CONTRASENA, TIPO_USUARIO
          FROM USUARIO
         ORDER BY NOMBRE_USUARIO;
END;



CREATE OR REPLACE PROCEDURE sp_generar_id_paciente(
  p_id OUT PACIENTE.ID_PACIENTE%TYPE
) AS
BEGIN
  SELECT seq_paciente.NEXTVAL INTO p_id FROM DUAL;
END;

CREATE OR REPLACE PROCEDURE sp_generar_id_especialidad(
  p_id OUT ESPECIALIDAD.ID_ESPECIALIDAD%TYPE
) AS
BEGIN
  SELECT seq_especialidad.NEXTVAL INTO p_id FROM DUAL;
END;


CREATE OR REPLACE PROCEDURE sp_generar_id_historial(
  p_id OUT HISTORIAL_MEDICO.ID_HISTORIAL%TYPE
) AS
BEGIN
  SELECT seq_historial.NEXTVAL INTO p_id FROM DUAL;
END;



CREATE OR REPLACE PROCEDURE sp_cancelar_citas_pasadas AS
BEGIN
  UPDATE CITA
     SET ESTADO = 'Cancelada'
   WHERE ESTADO = 'Agendada'
     AND (FECHA + (HORA - TRUNC(HORA))) < SYSTIMESTAMP;
  COMMIT;
END;


CREATE OR REPLACE PROCEDURE sp_get_nombre_especialidad(
  p_id_especialidad IN ESPECIALIDAD.ID_ESPECIALIDAD%TYPE,
  p_nombre          OUT ESPECIALIDAD.NOMBRE%TYPE
) AS
BEGIN
  SELECT NOMBRE INTO p_nombre
    FROM ESPECIALIDAD
   WHERE ID_ESPECIALIDAD = p_id_especialidad;
EXCEPTION
  WHEN NO_DATA_FOUND THEN
    p_nombre := NULL;
END;



CREATE OR REPLACE PROCEDURE sp_get_resumen_paciente(
  p_id_paciente IN PACIENTE.ID_PACIENTE%TYPE,
  p_resumen     OUT VARCHAR2
) AS
  v_nombre PACIENTE.NOMBRE%TYPE;
  v_email  PACIENTE.EMAIL%TYPE;
BEGIN
  SELECT NOMBRE, EMAIL INTO v_nombre, v_email
    FROM PACIENTE
   WHERE ID_PACIENTE = p_id_paciente;
  p_resumen := 'Paciente: ' || v_nombre || ' | Email: ' || v_email;
EXCEPTION
  WHEN NO_DATA_FOUND THEN
    p_resumen := 'Paciente no encontrado';
END;


CREATE OR REPLACE PROCEDURE sp_get_ultima_fecha_historial(
  p_id_paciente IN HISTORIAL_MEDICO.ID_PACIENTE%TYPE,
  p_fecha       OUT DATE
) AS
BEGIN
  SELECT MAX(C.FECHA) INTO p_fecha
    FROM HISTORIAL_MEDICO H
    JOIN CITA C ON H.ID_CITA = C.ID_CITA
   WHERE H.ID_PACIENTE = p_id_paciente;
EXCEPTION
  WHEN NO_DATA_FOUND THEN
    p_fecha := NULL;
END;


CREATE OR REPLACE PROCEDURE sp_contar_especialidades(
  p_total OUT NUMBER
) AS
BEGIN
  SELECT COUNT(*) INTO p_total FROM ESPECIALIDAD;
END;


CREATE OR REPLACE PROCEDURE sp_contar_pacientes(
  p_total OUT NUMBER
) AS
BEGIN
  SELECT COUNT(*) INTO p_total FROM PACIENTE;
END;


CREATE OR REPLACE PROCEDURE sp_contar_historiales(
  p_total OUT NUMBER
) AS
BEGIN
  SELECT COUNT(*) INTO p_total FROM HISTORIAL_MEDICO;
END;


CREATE OR REPLACE PROCEDURE sp_validar_email_paciente(
  p_email IN PACIENTE.EMAIL%TYPE,
  p_valido OUT BOOLEAN
) AS
BEGIN
  p_valido := REGEXP_LIKE(p_email, '^[^@]+@[^@]+\.[^@]+$');
END;


CREATE OR REPLACE PROCEDURE sp_existe_paciente(
  p_id_paciente IN PACIENTE.ID_PACIENTE%TYPE,
  p_existe      OUT BOOLEAN
) AS
  v_count NUMBER;
BEGIN
  SELECT COUNT(*) INTO v_count
    FROM PACIENTE
   WHERE ID_PACIENTE = p_id_paciente;
  p_existe := (v_count > 0);
END;




























