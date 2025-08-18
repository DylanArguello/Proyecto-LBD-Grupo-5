<?php
require_once __DIR__ . '/OracleHelper.php';

class UsuarioModel extends OracleHelper {

  /** Opcional: si quieres seguir usando generación previa de ID */
  private function nextId(): int {
    $id = null;
    // SP_GENERAR_ID_USUARIO(p_id OUT NUMBER)
    $this->execProc("BEGIN SP_GENERAR_ID_USUARIO(:id); END;", [":id" => $id]);
    return (int)$id;
  }

  /** Devuelve array de filas o cursor OCI (según tu OracleHelper) */
  public function listar() {
    // SP_LISTAR_USUARIOS(p_cursor OUT SYS_REFCURSOR)
    return $this->execCursor("BEGIN SP_LISTAR_USUARIOS(:cur); END;");
  }

  /** Crea usuario usando la firma vigente: (usuario, contrasena, tipo, id OUT) */
  public function crear(array $d): int {
    $id = null;
    $this->execProc("BEGIN SP_CREAR_USUARIO(:n,:c,:t,:id); END;", [
      ":n"  => $d['NOMBRE_USUARIO'],
      ":c"  => $d['CONTRASENA'],
      ":t"  => $d['TIPO_USUARIO'],
      ":id" => $id,             // OUT
    ]);
    return (int)$id;
  }

  /** SP_ACTUALIZAR_USUARIO(p_id, p_nombre, p_clave, p_tipo) */
  public function actualizar(array $d): void {
    $this->execProc("BEGIN SP_ACTUALIZAR_USUARIO(:id,:n,:c,:t); END;", [
      ":id" => $d['ID_USUARIO'],
      ":n"  => $d['NOMBRE_USUARIO'],
      ":c"  => $d['CONTRASENA'],
      ":t"  => $d['TIPO_USUARIO']
    ]);
  }

  public function eliminar($id): void {
    $this->execProc("BEGIN SP_ELIMINAR_USUARIO(:id); END;", [":id"=>$id]);
  }

  /** pkg_usuario.sp_cambiar_clave(p_id, p_nueva) */
  public function cambiarClave($id, $nueva): void {
    $this->execProc("BEGIN pkg_usuario.sp_cambiar_clave(:id,:p); END;", [":id"=>$id, ":p"=>$nueva]);
  }

  /** pkg_usuario.sp_cambiar_tipo(p_id, p_tipo) */
  public function cambiarTipo($id, $tipo): void {
    $this->execProc("BEGIN pkg_usuario.sp_cambiar_tipo(:id,:t); END;", [":id"=>$id, ":t"=>$tipo]);
  }

  /** pkg_usuario.sp_buscar_por_nombre(p_nombre, p_cur OUT) */
  public function buscarPorNombre($texto) {
    return $this->execCursor("BEGIN pkg_usuario.sp_buscar_por_nombre(:q,:cur); END;", [":q"=>$texto]);
  }
}
