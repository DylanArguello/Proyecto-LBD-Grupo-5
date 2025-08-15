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
/

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
/

---para delete usuario
CREATE OR REPLACE PROCEDURE sp_eliminar_usuario (
    p_id IN USUARIO.ID_USUARIO%TYPE
) AS
BEGIN
    DELETE FROM USUARIO
     WHERE ID_USUARIO = p_id;
    COMMIT;
END;
/

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
/

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
/

