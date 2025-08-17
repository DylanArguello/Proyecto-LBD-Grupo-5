CREATE OR REPLACE PROCEDURE sp_generar_id_paciente(
  p_id OUT PACIENTE.ID_PACIENTE%TYPE
) AS
BEGIN
  SELECT seq_paciente.NEXTVAL INTO p_id FROM DUAL;
END;
/
CREATE OR REPLACE PROCEDURE sp_generar_id_especialidad(
  p_id OUT ESPECIALIDAD.ID_ESPECIALIDAD%TYPE
) AS
BEGIN
  SELECT seq_especialidad.NEXTVAL INTO p_id FROM DUAL;
END;
/

CREATE OR REPLACE PROCEDURE sp_generar_id_historial(
  p_id OUT HISTORIAL_MEDICO.ID_HISTORIAL%TYPE
) AS
BEGIN
  SELECT seq_historial.NEXTVAL INTO p_id FROM DUAL;
END;
/


CREATE OR REPLACE PROCEDURE sp_cancelar_citas_pasadas AS
BEGIN
  UPDATE CITA
     SET ESTADO = 'Cancelada'
   WHERE ESTADO = 'Agendada'
     AND (FECHA + (HORA - TRUNC(HORA))) < SYSTIMESTAMP;
  COMMIT;
END;
/


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
/


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
/



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
/

CREATE OR REPLACE PROCEDURE sp_contar_especialidades(
  p_total OUT NUMBER
) AS
BEGIN
  SELECT COUNT(*) INTO p_total FROM ESPECIALIDAD;
END;
/

CREATE OR REPLACE PROCEDURE sp_contar_pacientes(
  p_total OUT NUMBER
) AS
BEGIN
  SELECT COUNT(*) INTO p_total FROM PACIENTE;
END;
/

CREATE OR REPLACE PROCEDURE sp_contar_historiales(
  p_total OUT NUMBER
) AS
BEGIN
  SELECT COUNT(*) INTO p_total FROM HISTORIAL_MEDICO;
END;
/

CREATE OR REPLACE PROCEDURE sp_validar_email_paciente(
  p_email IN PACIENTE.EMAIL%TYPE,
  p_valido OUT BOOLEAN
) AS
BEGIN
  p_valido := REGEXP_LIKE(p_email, '^[^@]+@[^@]+\.[^@]+$');
END;
/

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
/


