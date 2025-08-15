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
/











