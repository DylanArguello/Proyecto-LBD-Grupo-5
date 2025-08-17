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

----TRIGGER PARA VALIDAR ESTADO DE CITA
CREATE OR REPLACE TRIGGER trg_validar_estado_cita
BEFORE INSERT OR UPDATE ON CITA
FOR EACH ROW
BEGIN
    IF :NEW.ESTADO NOT IN ('AGENDADA', 'CONFIRMADA', 'CANCELADA') THEN
        RAISE_APPLICATION_ERROR(-20001, 'Estado inválido para la cita.');
    END IF;
END;