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

----TRIGGER PARA VALIDAR HORAS DE DISPONIBILIDAD
CREATE OR REPLACE TRIGGER trg_validar_horas_disponibilidad
BEFORE INSERT OR UPDATE ON DISPONIBILIDAD
FOR EACH ROW
BEGIN
    IF :NEW.HORA_FIN <= :NEW.HORA_INICIO THEN
        RAISE_APPLICATION_ERROR(-20010, 'La hora de fin debe ser mayor que la hora de inicio.');
    END IF;
END;