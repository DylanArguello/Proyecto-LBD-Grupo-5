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

----TRIGGER PARA VALIDAR LONGITUD DEL TELEFONO
CREATE OR REPLACE TRIGGER trg_validar_telefono_doctor
BEFORE INSERT OR UPDATE ON DOCTOR
FOR EACH ROW
BEGIN
    IF :NEW.TELEFONO IS NOT NULL AND LENGTH(:NEW.TELEFONO) < 8 THEN
        RAISE_APPLICATION_ERROR(-20020, 'El teléfono debe tener al menos 8 dígitos.');
    END IF;
END;