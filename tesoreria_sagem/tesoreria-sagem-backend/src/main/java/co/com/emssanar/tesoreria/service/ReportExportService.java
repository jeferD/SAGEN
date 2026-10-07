package co.com.emssanar.tesoreria.service;

import java.io.StringWriter;
import java.nio.charset.StandardCharsets;
import java.sql.Connection;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.sql.Statement;
import java.time.LocalDate;
import java.time.format.DateTimeFormatter;
import java.util.ArrayList;
import java.util.List;

import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.stereotype.Service;

@Service
public class ReportExportService {

    private static final DateTimeFormatter DATE = DateTimeFormatter.ISO_LOCAL_DATE;

    private final JdbcTemplate jdbcTemplate;

    public ReportExportService(JdbcTemplate jdbcTemplate) {
        this.jdbcTemplate = jdbcTemplate;
    }

    public record DownloadResponse(String fileName, byte[] content) {}

    public DownloadResponse descargarTesoreria(String nit, String ctacobro, String idrad, String docto, String fini, String ffin) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.tesoreria_pagos(?,?,?,?,?,?)",
                fileName("PAGOS_NIT_" + safe(nit), fini, ffin, "PAGOS_NIT_" + safe(nit), "PERIODO_ENTRE_" + safe(fini) + "_A_" + safe(ffin)),
                nit, nullIfBlank(ctacobro), nullIfBlank(idrad), nullIfBlank(docto), nullIfBlank(fini), nullIfBlank(ffin));
    }

    public DownloadResponse descargarTesoreriaRadicados(String txtidrad) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.    (?)",
                today("PAGOS_POR_RADICADOS"),
                arrayLiteral(txtidrad));
    }

    public DownloadResponse descargarTesoreriaNitPeriodo(String nit, String fini, String ffin) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.exportar_pagos_nit_y_periodo(?,?,?)",
                fileName("PAGOS_NIT_" + safe(nit), fini, ffin, "PAGOS_NIT_" + safe(nit), "PERIODO_ENTRE_" + safe(fini) + "_A_" + safe(ffin)),
                nit, nullIfBlank(fini), nullIfBlank(ffin));
    }

    public DownloadResponse descargarTesoreriaNitCuenta(String nit, String cta) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.exportar_pagos_nit_y_cuenta_cobro(?,?)",
                fileName("PAGOS_NIT_" + safe(nit), cta, "PAGOS_NIT_" + safe(nit), "NUMERO_CUENTA_COBRO_" + safe(cta)),
                nit, nullIfBlank(cta));
    }

    public DownloadResponse descargarTesoreriaNitDocumento(String nit, String docto) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.exportar_pagos_nit_y_documento(?,?)",
                fileName("PAGOS_NIT_" + safe(nit), docto, "PAGOS_NIT_" + safe(nit), "NUMERO_DOCUMENTO_PAGO_" + safe(docto)),
                nit, nullIfBlank(docto));
    }

    public DownloadResponse descargarCartera(String nit, String ctacobro, String idrad, String docto, String fini, String ffin) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.tesoreria_cartera(?,?,?,?,?,?)",
                fileName("CARTERA_NIT_" + safe(nit), fini, ffin, "CARTERA_NIT_" + safe(nit), "PERIODO_ENTRE_" + safe(fini) + "_A_" + safe(ffin)),
                nit, nullIfBlank(ctacobro), nullIfBlank(idrad), nullIfBlank(docto), nullIfBlank(fini), nullIfBlank(ffin));
    }

    public DownloadResponse descargarCarteraRadicados(String txtidrad) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.exportar_cartera_lista_de_radicados(?)",
                today("CARTERA_POR_RADICADOS"),
                arrayLiteral(txtidrad));
    }

    public DownloadResponse descargarCarteraNitPeriodo(String nit, String fini, String ffin) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.exportar_cartera_nit_periodo(?,?,?)",
                fileName("CARTERA_NIT_" + safe(nit), fini, ffin, "CARTERA_NIT_" + safe(nit), "PERIODO_ENTRE_" + safe(fini) + "_A_" + safe(ffin)),
                nit, nullIfBlank(fini), nullIfBlank(ffin));
    }

    public DownloadResponse descargarCarteraNitCuenta(String nit, String cta) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.exportar_cartera_nit_y_numero_cuenta_cobro(?,?)",
                fileName("CARTERA_NIT_" + safe(nit), cta, "CARTERA_NIT_" + safe(nit), "NUMERO_CUENTA_COBRO_" + safe(cta)),
                nit, nullIfBlank(cta));
    }

    public DownloadResponse descargarImpuestos(String nit, String ctacobro, String idrad, String docto, String fini, String ffin) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.tesoreria_pagos(?,?,?,?,?,?)",
                fileName("IMPUESTOS_NIT_" + safe(nit), fini, ffin, "IMPUESTOS_NIT_" + safe(nit), "PERIODO_ENTRE_" + safe(fini) + "_A_" + safe(ffin)),
                nit, nullIfBlank(ctacobro), nullIfBlank(idrad), nullIfBlank(docto), nullIfBlank(fini), nullIfBlank(ffin));
    }

    public DownloadResponse descargarImpuestosRadicados(String txtidrad) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.exportar_impuestos_lista_de_radicados(?)",
                today("IMPUESTOS_POR_RADICADOS"),
                arrayLiteral(txtidrad));
    }

    public DownloadResponse descargarImpuestosNitPeriodo(String nit, String fini, String ffin) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.exportar_impuestos_nit_y_periodo(?,?,?)",
                fileName("PAGOS_NIT_" + safe(nit), fini, ffin, "PAGOS_NIT_" + safe(nit), "PERIODO_ENTRE_" + safe(fini) + "_A_" + safe(ffin)),
                nit, nullIfBlank(fini), nullIfBlank(ffin));
    }

    public DownloadResponse descargarImpuestosNitCuenta(String nit, String cta) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.exportar_impuestos_nit_y_cuenta_cobro(?,?)",
                fileName("PAGOS_NIT_" + safe(nit), cta, "PAGOS_NIT_" + safe(nit), "NUMERO_CUENTA_COBRO_" + safe(cta)),
                nit, nullIfBlank(cta));
    }

    public DownloadResponse descargarImpuestosNitDocumento(String nit, String docto) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.exportar_impuestos_nit_y_documento(?,?)",
                fileName("IMPUESTOS_NIT_" + safe(nit), docto, "IMPUESTOS_NIT_" + safe(nit), "NUMERO_DOCUMENTO_IMPUESTO_" + safe(docto)),
                nit, nullIfBlank(docto));
    }

    public DownloadResponse descargarRecobroPorRadicado(String idRad) {
        return exportDirectQuery(
                "select (case when codigo_regional = '01' then 'RNP' else 'RCV' end) as codigo_regional, " +
                        "(case when codigo_regional = '01' then 'RNP' else 'RCV' end) as codigo_regional_documento, " +
                        "auxiliar, a.descripcion as descripcion_auxiliar, nit, p.nombre_ips, numero_radicado, " +
                        "numero_cuenta_cobro, fecha, documento, to_char(debito,'999G999G999G999') as debito, " +
                        "to_char(credito,'999G999G999G999') as credito, to_char(neto,'999G999G999G999') as neto, nota, " +
                        "m.descripcion as tipo_movimiento, numero_pagos, tasa_impuesto_unoe, base_impuesto_unoe, fecha_creacion, " +
                        "fecha_aprobacion, tasa_impuesto_real, base_impuesto_real, i.descripcion as tipo_impuesto " +
                        "from tesoreria_evento.base_unoe " +
                        "join tesoreria_global.proveedores as p using(nit) " +
                        "join tesoreria_global.auxiliares as a using(auxiliar) " +
                        "join tesoreria_global.tipo_movimiento as m using(tipo_movimiento) " +
                        "join tesoreria_global.tipo_impuesto as i using(tipo_impuesto) " +
                        "WHERE numero_radicado = ?",
                today("NUMERO_RADICADO_" + safe(idRad)),
                idRad);
    }

    public DownloadResponse descargarRecobroPorCuentaCobro(String nit, String numeroCuentaCobro) {
        return exportDirectQuery(
                "select (case when codigo_regional = '01' then 'RNP' else 'RCV' end) as codigo_regional, " +
                        "(case when codigo_regional = '01' then 'RNP' else 'RCV' end) as codigo_regional_documento, " +
                        "auxiliar, a.descripcion as descripcion_auxiliar, nit, p.nombre_ips, numero_radicado, " +
                        "numero_cuenta_cobro, fecha, documento, to_char(debito,'999G999G999G999') as debito, " +
                        "to_char(credito,'999G999G999G999') as credito, to_char(neto,'999G999G999G999') as neto, nota, " +
                        "m.descripcion as tipo_movimiento, numero_pagos, tasa_impuesto_unoe, base_impuesto_unoe, fecha_creacion, " +
                        "fecha_aprobacion, tasa_impuesto_real, base_impuesto_real, i.descripcion as tipo_impuesto " +
                        "from tesoreria_evento.base_unoe " +
                        "join tesoreria_global.proveedores as p using(nit) " +
                        "join tesoreria_global.auxiliares as a using(auxiliar) " +
                        "join tesoreria_global.tipo_movimiento as m using(tipo_movimiento) " +
                        "join tesoreria_global.tipo_impuesto as i using(tipo_impuesto) " +
                        "WHERE nit = ? and numero_cuenta_cobro = ?",
                today("NIT_" + safe(nit) + "_NUMERO_CUENTA_COBRO_" + safe(numeroCuentaCobro)),
                nit, numeroCuentaCobro);
    }

    public DownloadResponse descargarRecobroPorFactura(String nit, String factura) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_global.trazabilidad_factura(?,?)",
                today("PAGOS_NIT_" + safe(nit) + "_NUMERO_FACTURA_" + safe(factura)),
                nit, factura);
    }

    public DownloadResponse descargarCruce(String nit, String ctacobro, String idrad, String docto, String fini, String ffin) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_sac.consulta_cruce(?,?,?,?,?,?)",
                today("CRUCE_NIT_" + safe(nit)),
                nit, nullIfBlank(ctacobro), nullIfBlank(idrad), nullIfBlank(docto), nullIfBlank(fini), nullIfBlank(ffin));
    }

    public DownloadResponse descargarFepa(String nit, String ctacobro, String idrad, String docto, String fini, String ffin) {
        return exportFromFunction(
                "SELECT * FROM tesoreria_sac.consulta_fepa(?,?,?,?,?,?)",
                today("CRUCE_NIT_" + safe(nit)),
                nit, nullIfBlank(ctacobro), nullIfBlank(idrad), nullIfBlank(docto), nullIfBlank(fini), nullIfBlank(ffin));
    }

    private DownloadResponse exportFromFunction(String sql, String fileName, Object... args) {
        for (Object arg : args) {
            if (arg == null) {
                throw new IllegalArgumentException("Faltan parametros obligatorios para la consulta");
            }
        }
        String generatedSql = jdbcTemplate.queryForObject(sql, String.class, args);
        return new DownloadResponse(fileName, executeSqlToCsv(generatedSql));
    }

    private DownloadResponse exportDirectQuery(String sql, String fileName, Object... args) {
        return new DownloadResponse(fileName, jdbcTemplate.execute((Connection connection) -> {
            try (var ps = connection.prepareStatement(sql)) {
                for (int i = 0; i < args.length; i++) {
                    ps.setObject(i + 1, args[i]);
                }
                try (ResultSet rs = ps.executeQuery()) {
                    return toCsv(rs);
                }
            }
        }));
    }

    private byte[] executeSqlToCsv(String sql) {
        String normalized = normalizeSql(sql);
        return jdbcTemplate.execute((Connection connection) -> {
            try (Statement statement = connection.createStatement(); ResultSet rs = statement.executeQuery(normalized)) {
                return toCsv(rs);
            }
        });
    }

    private byte[] toCsv(ResultSet rs) throws SQLException {
        StringWriter writer = new StringWriter();
        ResultSetMetaData metaData = rs.getMetaData();
        int columns = metaData.getColumnCount();

        appendRow(writer, headers(metaData, columns));
        while (rs.next()) {
            List<String> row = new ArrayList<>(columns);
            for (int i = 1; i <= columns; i++) {
                row.add(rs.getString(i));
            }
            appendRow(writer, row);
        }
        return writer.toString().getBytes(StandardCharsets.UTF_8);
    }

    private List<String> headers(ResultSetMetaData metaData, int columns) throws SQLException {
        List<String> headers = new ArrayList<>(columns);
        for (int i = 1; i <= columns; i++) {
            headers.add(metaData.getColumnLabel(i));
        }
        return headers;
    }

    private void appendRow(StringWriter writer, List<String> values) {
        for (int i = 0; i < values.size(); i++) {
            if (i > 0) {
                writer.append(',');
            }
            writer.append(escapeCsv(values.get(i)));
        }
        writer.append('\n');
    }

    private String escapeCsv(String value) {
        if (value == null) {
            return "";
        }
        boolean mustQuote = value.contains(",") || value.contains("\n") || value.contains("\r") || value.contains("\"");
        String escaped = value.replace("\"", "\"\"");
        return mustQuote ? '"' + escaped + '"' : escaped;
    }

    private String normalizeSql(String sql) {
        String trimmed = sql == null ? "" : sql.trim();
        if (trimmed.endsWith(";")) {
            return trimmed.substring(0, trimmed.length() - 1);
        }
        return trimmed;
    }

    private Object nullIfBlank(String value) {
        return value == null || value.isBlank() ? null : value;
    }

    private String arrayLiteral(String value) {
        if (value == null || value.isBlank()) {
            return "{}";
        }
        String trimmed = value.trim();
        return trimmed.startsWith("{") ? trimmed : "{" + trimmed + "}";
    }

    private String fileName(String base, String extraIfPresent, String baseIfEmpty, String extraSuffixIfPresent) {
        if (extraIfPresent == null || extraIfPresent.isBlank()) {
            return today(baseIfEmpty);
        }
        return today(base + "_" + extraSuffixIfPresent);
    }

    private String fileName(String base, String fini, String ffin, String baseIfEmpty, String rangeSuffix) {
        if (isBlank(fini) || isBlank(ffin)) {
            return today(baseIfEmpty);
        }
        return today(base + "_" + rangeSuffix);
    }

    private String today(String suffix) {
        return LocalDate.now().format(DATE) + "_" + suffix;
    }

    private String safe(String value) {
        return value == null ? "" : value.replaceAll("[\\r\\n,]", "_");
    }

    private boolean isBlank(String value) {
        return value == null || value.isBlank();
    }
}
