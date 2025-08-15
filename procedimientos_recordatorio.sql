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
/

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
/


