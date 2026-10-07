package co.com.emssanar.tesoreria.service;

import java.util.List;
import java.util.Map;

import org.springframework.jdbc.core.namedparam.MapSqlParameterSource;
import org.springframework.jdbc.core.namedparam.NamedParameterJdbcTemplate;
import org.springframework.stereotype.Service;

@Service
public class AdminCrudService {

    private final NamedParameterJdbcTemplate jdbc;

    public AdminCrudService(NamedParameterJdbcTemplate jdbc) {
        this.jdbc = jdbc;
    }

    public int loginUser(String usuario, String pass) {
        List<Integer> tipos = jdbc.query("SELECT tipo FROM usuarios WHERE usuario = :usuario AND pass = :pass",
                new MapSqlParameterSource().addValue("usuario", usuario).addValue("pass", pass),
                (rs, rowNum) -> rs.getInt(1));
        return tipos.isEmpty() ? 0 : tipos.get(0);
    }

    public List<Map<String, Object>> listEmails() {
        return jdbc.queryForList("SELECT * FROM tesoreria_global.emails ORDER BY id", Map.of());
    }

    public Map<String, Object> getEmail(long id) {
        return jdbc.queryForMap("SELECT * FROM tesoreria_global.emails WHERE id = :id",
                Map.of("id", id));
    }

    public int createEmail(Map<String, Object> body) {
        return jdbc.update("INSERT INTO tesoreria_global.emails (nit, nombre, email) VALUES (:nit, :nombre, :email)",
                params(body, "nit", "nombre", "email"));
    }

    public int updateEmail(long id, Map<String, Object> body) {
        MapSqlParameterSource params = params(body, "email");
        params.addValue("id", id);
        return jdbc.update("UPDATE tesoreria_global.emails SET email = :email WHERE id = :id", params);
    }

    public int deleteEmail(long id) {
        return jdbc.update("UPDATE tesoreria_global.emails SET activo = false WHERE id = :id", Map.of("id", id));
    }

    public List<Map<String, Object>> listPqrs() {
        return jdbc.queryForList("SELECT * FROM gestion_pqrs ORDER BY id", Map.of());
    }

    public Map<String, Object> getPqrs(long id) {
        return jdbc.queryForMap("SELECT * FROM gestion_pqrs WHERE id = :id", Map.of("id", id));
    }

    public int updatePqrs(long id, Map<String, Object> body) {
        MapSqlParameterSource params = params(body,
                "responsable_ges", "fecha_entrega_ges", "observacion", "fecha_envio", "estado", "tiempo_gestion", "observ_pqrs");
        params.addValue("id", id);
        return jdbc.update("UPDATE gestion_pqrs SET responsable_ges = :responsable_ges, fecha_entrega_ges = :fecha_entrega_ges, " +
                        "observacion = :observacion, fecha_envio = :fecha_envio, estado = :estado, tiempo_gestion = :tiempo_gestion, " +
                        "observ_pqrs = :observ_pqrs WHERE id = :id",
                params);
    }

    public int deletePqrs(long id) {
        return jdbc.update("DELETE FROM gestion_pqrs WHERE id = :id", Map.of("id", id));
    }

    public List<Map<String, Object>> listBaseUnoeByRadicado(long numeroRadicado) {
        return jdbc.queryForList("SELECT * FROM tesoreria_evento.base_unoe WHERE numero_radicado = :numero_radicado",
                Map.of("numero_radicado", numeroRadicado));
    }

    public Map<String, Object> getBaseUnoeByRadicado(long numeroRadicado) {
        return jdbc.queryForMap("SELECT * FROM tesoreria_evento.base_unoe WHERE numero_radicado = :numero_radicado",
                Map.of("numero_radicado", numeroRadicado));
    }

    public int createBaseUnoe(Map<String, Object> body) {
        String sql = "INSERT INTO tesoreria_evento.base_unoe (codigo_regional, codigo_regional_documento, auxiliar, nit, numero_radicado, numero_cuenta_cobro, fecha, documento, debito, credito, neto, nota, tipo_movimiento, numero_pagos, tasa_impuesto_unoe, base_impuesto_unoe, fecha_creacion, fecha_aprobacion, tasa_impuesto_real, base_impuesto_real, tipo_impuesto) " +
                "VALUES (:codigo_regional, :codigo_regional_documento, :auxiliar, :nit, :numero_radicado, :numero_cuenta_cobro, :fecha, :documento, :debito, :credito, :neto, :nota, :tipo_movimiento, :numero_pagos, :tasa_impuesto_unoe, :base_impuesto_unoe, :fecha_creacion, :fecha_aprobacion, :tasa_impuesto_real, :base_impuesto_real, :tipo_impuesto)";
        return jdbc.update(sql, params(body,
                "codigo_regional", "codigo_regional_documento", "auxiliar", "nit", "numero_radicado", "numero_cuenta_cobro",
                "fecha", "documento", "debito", "credito", "neto", "nota", "tipo_movimiento", "numero_pagos",
                "tasa_impuesto_unoe", "base_impuesto_unoe", "fecha_creacion", "fecha_aprobacion", "tasa_impuesto_real",
                "base_impuesto_real", "tipo_impuesto"));
    }

    public int updateBaseUnoe(long idUnoe, Map<String, Object> body) {
        String sql = "UPDATE tesoreria_evento.base_unoe SET codigo_regional = :codigo_regional, codigo_regional_documento = :codigo_regional_documento, " +
                "auxiliar = :auxiliar, nit = :nit, numero_radicado = :numero_radicado, numero_cuenta_cobro = :numero_cuenta_cobro, " +
                "fecha = :fecha, documento = :documento, debito = :debito, credito = :credito, neto = :neto, nota = :nota, " +
                "tipo_movimiento = :tipo_movimiento, numero_pagos = :numero_pagos, tasa_impuesto_unoe = :tasa_impuesto_unoe, " +
                "base_impuesto_unoe = :base_impuesto_unoe, fecha_creacion = :fecha_creacion, fecha_aprobacion = :fecha_aprobacion, " +
                "tasa_impuesto_real = :tasa_impuesto_real, base_impuesto_real = :base_impuesto_real, tipo_impuesto = :tipo_impuesto WHERE id_unoe = :id_unoe";
        MapSqlParameterSource params = params(body,
                "codigo_regional", "codigo_regional_documento", "auxiliar", "nit", "numero_radicado", "numero_cuenta_cobro",
                "fecha", "documento", "debito", "credito", "neto", "nota", "tipo_movimiento", "numero_pagos",
                "tasa_impuesto_unoe", "base_impuesto_unoe", "fecha_creacion", "fecha_aprobacion", "tasa_impuesto_real",
                "base_impuesto_real", "tipo_impuesto");
        params.addValue("id_unoe", idUnoe);
        return jdbc.update(sql, params);
    }

    public int deleteBaseUnoe(long idUnoe) {
        return jdbc.update("DELETE FROM tesoreria_evento.base_unoe WHERE id = :id", Map.of("id", idUnoe));
    }

    public List<Map<String, Object>> listCubos() {
        return jdbc.queryForList("SELECT * FROM tesoreria_sac.cubos ORDER BY id", Map.of());
    }

    public Map<String, Object> getCubosByNitIps(long nitips) {
        return jdbc.queryForMap("SELECT * FROM tesoreria_sac.cubos WHERE nitips = :nitips", Map.of("nitips", nitips));
    }

    public int createCubos(Map<String, Object> body) {
        String sql = "INSERT INTO tesoreria_sac.cubos (niteps, nitips, vrfacturaeps, vrglosaaceptadaeps, vrpagototaleps, vrsaldoeps, vrfacturaips, vrglosaaceptadaips, vrpagototalips, vrsaldoips, nomeps, nomips, diferencia, coincidencia) " +
                "VALUES (:niteps, :nitips, :vrfacturaeps, :vrglosaaceptadaeps, :vrpagototaleps, :vrsaldoeps, :vrfacturaips, :vrglosaaceptadaips, :vrpagototalips, :vrsaldoips, :nomeps, :nomips, :diferencia, :coincidencia)";
        return jdbc.update(sql, params(body,
                "niteps", "nitips", "vrfacturaeps", "vrglosaaceptadaeps", "vrpagototaleps", "vrsaldoeps",
                "vrfacturaips", "vrglosaaceptadaips", "vrpagototalips", "vrsaldoips", "nomeps", "nomips",
                "diferencia", "coincidencia"));
    }

    public int updateCubos(long id, Map<String, Object> body) {
        String sql = "UPDATE tesoreria_sac.cubos SET niteps = :niteps, nitips = :nitips, vrfacturaeps = :vrfacturaeps, vrglosaaceptadaeps = :vrglosaaceptadaeps, " +
                "vrpagototaleps = :vrpagototaleps, vrsaldoeps = :vrsaldoeps, vrfacturaips = :vrfacturaips, vrglosaaceptadaips = :vrglosaaceptadaips, " +
                "vrpagototalips = :vrpagototalips, vrsaldoips = :vrsaldoips, nomeps = :nomeps, nomips = :nomips, diferencia = :diferencia, coincidencia = :coincidencia WHERE id = :id";
        MapSqlParameterSource params = params(body,
                "niteps", "nitips", "vrfacturaeps", "vrglosaaceptadaeps", "vrpagototaleps", "vrsaldoeps",
                "vrfacturaips", "vrglosaaceptadaips", "vrpagototalips", "vrsaldoips", "nomeps", "nomips",
                "diferencia", "coincidencia");
        params.addValue("id", id);
        return jdbc.update(sql, params);
    }

    public int deleteCubos(long id) {
        return jdbc.update("DELETE FROM tesoreria_sac.cubos WHERE id = :id", Map.of("id", id));
    }

    public List<Map<String, Object>> listIndicadores() {
        return jdbc.queryForList("SELECT * FROM tesoreria_sac.indicador", Map.of());
    }

    private MapSqlParameterSource params(Map<String, Object> body, String... keys) {
        MapSqlParameterSource params = new MapSqlParameterSource();
        for (String key : keys) {
            params.addValue(key, body.get(key));
        }
        return params;
    }
}
